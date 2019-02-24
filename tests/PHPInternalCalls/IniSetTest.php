<?php
declare(strict_types=1);

namespace corbomite\tests\PHPInternalCalls;

use PHPUnit\Framework\TestCase;
use corbomite\cli\PHPInternalCalls;

class IniSetTest extends TestCase
{
    public function test(): void
    {
        ini_set('display_errors', '0');

        self::assertEquals('0', ini_get('display_errors'));

        $obj = new PHPInternalCalls();

        $obj->iniSet('display_errors', '1');

        self::assertEquals('1', ini_get('display_errors'));
    }
}
