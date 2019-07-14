<?php

namespace TobyMaxham\ArrayFakerRedactor\Test;

use PHPUnit\Framework\TestCase;
use TobyMaxham\ArrayFakerRedactor\ArrayFakerRedactor;

/**
 * @author Tobias Maxham <git2019@maxham.de>
 */
class ArrayFakerRedactorTest extends TestCase
{
    protected $content;

    protected function setUp(): void
    {
        $this->content = [
            'email'       => 'mtownsend5512@gmail.com',
            'password'    => 'secret123',
            'sample_data' => 'nothing else matters',
            'changes'     => [
                'account' => [
                    'old_password' => 'secret321',
                    'new_password' => 'secret789',
                ],
            ],
        ];
    }

    /** @test */
    public function can_redact_and_fake_data(): void
    {
        $result = (new ArrayFakerRedactor())->content($this->content)->keys(['email', 'password'])
            ->withFaker()
            ->redact();
        $this->assertNotEquals($this->content['email'], $result['email']);
        $this->assertNotEquals($this->content['password'], $result['password']);
        $this->assertStringContainsString('@', $result['email']);
    }

    /** @test */
    public function can_ignore_invalid_formatter(): void
    {
        $result = (new ArrayFakerRedactor())->content($this->content)->keys(['sample_data'])
            ->withFaker()
            ->redact();
        $this->assertNotEquals($this->content['sample_data'], $result['sample_data']);
        $this->assertEquals('[REDACTED]', $result['sample_data']);
    }

    /** @test */
    public function can_change_formatter(): void
    {
        $result = (new ArrayFakerRedactor())->content($this->content)->keys(['sample_data' => 'random'])
            ->withFaker()
            ->redact();
        $this->assertNotEquals($this->content['sample_data'], $result['sample_data']);
        $this->assertEquals($this->content['email'], $result['email']);
    }
}
