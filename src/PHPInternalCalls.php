<?php
declare(strict_types=1);

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
