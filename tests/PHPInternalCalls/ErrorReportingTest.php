<?php
declare(strict_types=1);

namespace corbomite\tests\PHPInternalCalls;

use PHPUnit\Framework\TestCase;
use corbomite\cli\PHPInternalCalls;

class ErrorReportingTest extends TestCase
{
    public function test(): void
    {
        error_reporting(0);

        self::assertEquals(0, error_reporting());

        $obj = new PHPInternalCalls();

        $obj->errorReporting(E_ALL);

        self::assertEquals(E_ALL, error_reporting());
    }
}
