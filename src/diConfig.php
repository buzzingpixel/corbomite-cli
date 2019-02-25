<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use corbomite\cli\Kernel;
use corbomite\cli\ExitStatement;
use corbomite\cli\PHPInternalCalls;
use corbomite\configcollector\Collector;
use corbomite\cli\actions\ListActionsAction;
use Symfony\Component\Console\Input\ArgvInput;
use corbomite\cli\services\CliQuestionService;
use NunoMaduro\Collision\Provider as Collision;
use Symfony\Component\Console\Output\ConsoleOutput;
use corbomite\cli\factories\ConsoleQuestionFactory;
use Symfony\Component\Console\Application as ConsoleApplication;

return [
    Kernel::class => function () {
        return new Kernel(new Di, new Collision(), new ExitStatement());
    },
    PHPInternalCalls::class => function () {
        return new PHPInternalCalls();
    },
    ListActionsAction::class => function () {
        return new ListActionsAction(
            new ConsoleOutput(),
            Di::get(Collector::class)->collect('cliActionConfigFilePath')
        );
    },
    CliQuestionService::class => function () {
        return new CliQuestionService(
            (new ConsoleApplication())
                ->getHelperSet()
                ->get('question'),
            new ArgvInput(),
            new ConsoleOutput(),
            new ConsoleQuestionFactory()
        );
    },
];
