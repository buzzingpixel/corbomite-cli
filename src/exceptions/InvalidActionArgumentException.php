<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\cli\exceptions;

use Exception;
use Throwable;

class InvalidActionArgumentException extends Exception
{
    public function __construct(
        string $message = 'Invalid action argument',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
