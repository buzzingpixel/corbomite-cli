<?php
declare(strict_types=1);

namespace corbomite\tests\Kernel;

use corbomite\di\Di;
use corbomite\cli\Kernel;
use PHPUnit\Framework\TestCase;
use corbomite\cli\ExitStatement;
use corbomite\cli\PHPInternalCalls;
use corbomite\configcollector\Collector;
use NunoMaduro\Collision\Provider as Collision;

class ArgumentActionTest extends TestCase
{
    public function test(): void
    {
        $di = $this->createMock(Di::class);

        $collision = $this->createMock(Collision::class);

        $exitStatement = $this->createMock(ExitStatement::class);

        $phpInternalCalls = $this->createMock(PHPInternalCalls::class);

        $phpInternalCalls->expects(self::exactly(2))
            ->method('iniSet')
            ->with(
                self::logicalOr('display_errors', 'display_startup_errors'),
                self::equalTo('1')
            );

        $phpInternalCalls->expects(self::once())
            ->method('errorReporting')
            ->with(self::equalTo(E_ALL));

        $collision->expects(self::once())
            ->method('register');

        $collector = $this->createMock(Collector::class);

        $collector->expects(self::once())
            ->method('__invoke')
            ->with(self::equalTo('cliActionConfigFilePath'))
            ->willReturn([
                'test-group' => [
                    'commands' => [
                        'test-command' => [
                            'class' => ActionCallable::class,
                            'method' => 'callableMethod'
                        ]
                    ],
                ],
            ]);

        $exitStatement->expects(self::once())
            ->method('exitWith')
            ->with(self::equalTo('ActionCallable::callableMethod'));

        $di->method('getFromDefinition')
            ->willReturnCallback(function (string $class) use (
                $phpInternalCalls,
                $collector
            ) {
                switch ($class) {
                    case PHPInternalCalls::class:
                        return $phpInternalCalls;
                    case Collector::class:
                        return $collector;
                    default:
                        throw new \Exception('Unknown Class');
                }
            });

        $kernel = new Kernel($di, $collision, $exitStatement);

        $kernel->__invoke([
            'asdf',
            'test-group/test-command'
        ]);
    }
}
