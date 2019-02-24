<?php
declare(strict_types=1);

namespace corbomite\tests\actions\ListActionsAction;

use PHPUnit\Framework\TestCase;
use corbomite\cli\actions\ListActionsAction;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends TestCase
{
    private $writeLineCalls = [];

    public function test(): void
    {
        $self = $this;

        self::assertFalse(defined('ENTRY_POINT'));

        $consoleOutputMock = $this->createMock(OutputInterface::class);

        $consoleOutputMock->expects(self::exactly(6))
            ->method('writeln')
            ->willReturnCallback(function ($str) use ($self) {
                $self->writeLineCalls[] = $str;
            });

        $cliActionConfig = [
            'cli' => [
                'description' => 'Corbomite CLI Commands',
                'commands' => [
                    'list-actions' => [
                        'description' => 'Lists available actions',
                        'class' => ListActionsAction::class,
                    ],
                ],
            ],
        ];

        $listActions = new ListActionsAction($consoleOutputMock, $cliActionConfig);

        self::assertNull($listActions->__invoke());

        self::assertEquals(
            [
                '<fg=green>Corbomite Command Line</>' . PHP_EOL,
                '<fg=yellow>Usage:</>',
                '  php app action-group/action-name' . PHP_EOL,
                'Group: <fg=yellow>cli</>          <fg=cyan>Corbomite CLI Commands</>',
                '<fg=green>  cli/list-actions  </>Lists available actions',
                '',
            ],
            $self->writeLineCalls
        );
    }
}
