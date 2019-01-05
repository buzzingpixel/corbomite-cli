<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\cli\factories;

use Symfony\Component\Console\Input\ArrayInput;

class ArrayInputFactory
{
    public function make(array $params): ArrayInput
    {
        return new ArrayInput($params);
    }
}
