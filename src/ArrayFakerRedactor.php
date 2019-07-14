<?php

namespace TobyMaxham\ArrayFakerRedactor;

use Faker\Factory;
use Faker\Generator;
use Mtownsend\ArrayRedactor\ArrayRedactor;
use Mtownsend\ArrayRedactor\Exceptions\ArrayRedactorException;

/**
 * @author Tobias Maxham <git2019@maxham.de>
 */
class ArrayFakerRedactor extends ArrayRedactor
{
    /**
     * @var callable
     */
    public $fakerInk;

    /**
     * @var Generator
     */
    protected $fakerGenerator;

    public function withFaker($locale = Factory::DEFAULT_LOCALE): self
    {
        $this->fakerGenerator = Factory::create($locale);
        $this->fakerInk(function ($formatter, $ink) {
            return $this->fakerGenerator->{$formatter};
        });

        return $this;
    }

    public function addFakerProvider($provider): self
    {
        if (is_string($provider)) {
            $provider = new $provider($this->fakerGenerator);
        }
        $this->fakerGenerator->addProvider($provider);

        return $this;
    }

    public function fakerInk(callable $callable): self
    {
        $this->fakerInk = $callable;

        return $this;
    }

    /**
     * Apply recursive array redaction to the content.
     *
     * @throws ArrayRedactorException
     *
     * @return array
     */
    public function redact()
    {
        if (is_string($this->content) && $this->isValidJson($this->content)) {
            $this->content = json_decode($this->content, true);
        }

        if (! is_array($this->content) || ! $this->isAssocArray($this->content)) {
            throw new ArrayRedactorException("ArrayRedactor received invalid content `{$this->content}`");
        }

        $this->checkReverseKeys();

        // Recursively traverse the array and redact the specified keys
        array_walk_recursive($this->content, function (&$value, $key) {
            if (in_array($key, $this->keys, true)) {
                $formatter = $key;
                if (! is_int($newFormatter = array_search($key, $this->keys))) {
                    $formatter = $newFormatter;
                }
                $value = $this->redactWithFaker($formatter);
            }
        });

        return $this->content;
    }

    private function redactWithFaker($formatter)
    {
        if (is_null($this->fakerInk)) {
            return $this->ink;
        }
        try {
            $value = call_user_func_array($this->fakerInk, [$formatter, $this->ink]);
        } catch (\InvalidArgumentException $exception) {
            return $this->ink;
        }

        return $value;
    }

    private function checkReverseKeys()
    {
        foreach ($this->keys as $key => $value) {
            if (is_int($key)) {
                continue;
            }
            $old_key = $key;
            $this->keys[$value] = $key;
            unset($this->keys[$old_key]);
        }
    }
}
