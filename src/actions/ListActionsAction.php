<?php
declare(strict_types=1);

namespace corbomite\cli\actions;

use Symfony\Component\Console\Output\OutputInterface;

class ListActionsAction
{
    private $consoleOutput;
    private $cliActionConfig;

    public function __construct(
        OutputInterface $consoleOutput,
        array $cliActionConfig
    ) {
        $this->consoleOutput = $consoleOutput;
        $this->cliActionConfig = $cliActionConfig;
    }

    public function __invoke(): ?int
    {
        defined('ENTRY_POINT') || define('ENTRY_POINT', 'app');

        $this->consoleOutput->writeln(
            '<fg=green>Corbomite Command Line</>' . PHP_EOL
        );

        $this->consoleOutput->writeln(
            '<fg=yellow>Usage:</>'
        );

        $this->consoleOutput->writeln(
            '  php ' . ENTRY_POINT . ' action-group/action-name' . PHP_EOL
        );

        $toCharacters = 0;

        foreach ($this->cliActionConfig as $groupName => $group) {
            $commands = $group['commands'] ?? [];

            $groupTitle = 'Group: ' . $groupName;

            $len = \strlen($groupTitle);
            $toCharacters = $len > $toCharacters ? $len : $toCharacters;

            foreach (array_keys($commands) as $commandName) {
                $fullName = $groupName . '/' . $commandName;
                $len = \strlen($fullName);
                $toCharacters = $len > $toCharacters ? $len : $toCharacters;
            }
        }

        $toCharacters += 4;

        foreach ($this->cliActionConfig as $groupName => $group) {
            $commands = $group['commands'] ?? [];
            $desc = $group['description'] ?? '';

            $groupTitle = 'Group: ' . $groupName;
            $len = \strlen($groupTitle);
            $to = abs($len - $toCharacters);

            $this->consoleOutput->writeln(
                'Group: ' . '<fg=yellow>' . $groupName . '</>' .
                str_repeat(' ', $to) . '<fg=cyan>' . $desc . '</>'
            );

            foreach ($commands as $commandName => $commandConfig) {
                $commandName = $groupName . '/' . $commandName;
                $desc = $commandConfig['description'] ?? '';

                $len = \strlen($commandName);
                $to = abs($len - $toCharacters) - 2;

                $this->consoleOutput->writeln(
                    '<fg=green>  ' . $commandName . str_repeat(' ', $to) .
                    '</>' . $desc
                );
            }

            $this->consoleOutput->writeln('');
        }

        return null;
    }
}
