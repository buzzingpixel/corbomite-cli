<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use corbomite\cli\Kernel;
use PHPUnit\Framework\TestCase;
use corbomite\cli\PHPInternalCalls;
use NunoMaduro\Collision\Provider as Collision;

class KernelTest extends TestCase
{
    private $iniSetCalls = [];

    public function testKernel()
    {
        $collisionMock = self::createMock(Collision::class);

        $collisionMock->expects(self::once())->method('register');

        $phpInternalCallsMock = self::createMock(PHPInternalCalls::class);

        $phpInternalCallsMock->expects(self::exactly(2))
            ->method('iniSet')
            ->with(self::anything())
            ->will(self::returnCallback(function ($key, $val) {
                $this->iniSetCalls[] = [
                    'key' => $key,
                    'val' => $val,
                ];
            }));

        $phpInternalCallsMock->expects(self::once())
            ->method('errorReporting')
            ->with(self::equalTo(E_ALL));

        $appDiContainer = (new ContainerBuilder())
            ->useAutowiring(false)
            ->useAnnotations(false)
            ->build();

        $kernel = new Kernel(
            $appDiContainer,
            [],
            $collisionMock,
            $phpInternalCallsMock
        );

        $kernel();

        self::assertCount(2, $this->iniSetCalls);

        $calls = [];

        foreach ($this->iniSetCalls as $call) {
            $calls[$call['key']] = $call['val'];
        }

        self::assertEquals('1', $calls['display_errors']);
        self::assertEquals('1', $calls['display_startup_errors']);
    }
}
