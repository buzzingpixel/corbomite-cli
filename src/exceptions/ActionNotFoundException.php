<?php
declare(strict_types=1);

namespace corbomite\cli\exceptions;

use Exception;
use Throwable;

class ActionNotFoundException extends Exception
{
    public function __construct(
        string $message = 'Action not found',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
