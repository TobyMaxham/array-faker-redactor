<?php

namespace TobyMaxham\ArrayFakerRedactor;

use Faker\Provider\Base;

/**
 * @author Tobias Maxham <git2019@maxham.de>
 */
class FakerProvider extends Base
{
    public function random($length = 16)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $str_gen = $this->asciify(str_repeat('*', $size));

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($str_gen)), 0, $size);
        }

        return $string;
    }
}
