<?php
declare(strict_types=1);

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
