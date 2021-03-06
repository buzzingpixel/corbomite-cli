<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\cli;

class ExitStatement
{
    public function exitWith($arg = null)
    {
        exit($arg);
    }
}
