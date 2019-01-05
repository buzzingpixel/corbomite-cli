<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\cli;

class PHPInternalCalls
{
    public function iniSet($key, $val): void
    {
        ini_set($key, $val);
    }

    public function errorReporting($val): void
    {
        error_reporting($val);
    }
}
