<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\cli;

use corbomite\di\Di;
use corbomite\configcollector\Collector;
use corbomite\cli\models\CliArgumentsModel;
use NunoMaduro\Collision\Provider as Collision;
use corbomite\cli\exceptions\ActionNotFoundException;
use corbomite\cli\exceptions\InvalidActionArgumentException;

class Kernel
{
    private $di;
    private $collision;
    private $existStatement;

    public function __construct(
        Di $di,
        Collision $collision,
        ExitStatement $existStatement
    ) {
        $this->di = $di;
        $this->collision = $collision;
        $this->existStatement = $existStatement;
    }

    /**
     * @param array $arguments This should be the $argv variable set by the CLI
     * @throws ActionNotFoundException
     * @throws InvalidActionArgumentException
     * @throws \corbomite\di\DiException
     */
    public function __invoke(array $arguments = []): void
    {
        /** @var PHPInternalCalls $phpInternalCalls */
        $phpInternalCalls = $this->di->getFromDefinition(
            PHPInternalCalls::class
        );

        // Set up errors
        $phpInternalCalls->iniSet('display_errors', '1');
        $phpInternalCalls->iniSet('display_startup_errors', '1');
        $phpInternalCalls->errorReporting(E_ALL);
        $this->collision->register();

        $action = explode('/', $arguments[1] ?? 'cli/list-actions');

        if (count($action) !== 2) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new InvalidActionArgumentException('Invalid action');
        }

        $collector = $this->di->getFromDefinition(Collector::class);

        $actions = $collector('cliActionConfigFilePath');

        $action = $actions[$action[0]]['commands'][$action[1]] ?? null;

        if (! $action) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new ActionNotFoundException();
        }

        $actionClass = $action['class'] ?? '';
        $actionMethod = $action['method'] ?? '__invoke';

        if (! $actionClass) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new ActionNotFoundException();
        }

        $class = null;

        /** @noinspection PhpUnhandledExceptionInspection */
        if ($this->di->hasDefinition($actionClass)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $class = $this->di->makeFromDefinition($actionClass);
        }

        if (! $class) {
            $class = new $actionClass;
        }

        $this->existStatement->exitWith(
            $class->{$actionMethod}(new CliArgumentsModel($arguments))
        );
    }
}
