<?php
declare(strict_types=1);

use corbomite\di\Di;
use corbomite\cli\Kernel;
use corbomite\cli\PHPInternalCalls;
use corbomite\cli\ActionConfigCollector;
use corbomite\cli\actions\ListActionsAction;
use Symfony\Component\Console\Input\ArgvInput;
use corbomite\cli\services\CliQuestionService;
use NunoMaduro\Collision\Provider as Collision;
use Symfony\Component\Console\Output\ConsoleOutput;
use corbomite\cli\factories\ConsoleQuestionFactory;
use Composer\Console\Application as ComposerApplication;
use Symfony\Component\Console\Application as ConsoleApplication;

return [
    ActionConfigCollector::class => function () {
        $composerApp = new ComposerApplication();

        /** @noinspection PhpUnhandledExceptionInspection */
        $composer = $composerApp->getComposer();
        $repositoryManager = $composer->getRepositoryManager();
        $installedFilesystemRepository = $repositoryManager->getLocalRepository();
        $packages = $installedFilesystemRepository->getCanonicalPackages();

        return new ActionConfigCollector($packages);
    },
    Kernel::class => function () {
        return new Kernel(new Di, new Collision());
    },
    PHPInternalCalls::class => function () {
        return new PHPInternalCalls();
    },
    ListActionsAction::class => function () {
        return new ListActionsAction(
            new ConsoleOutput(),
            Di::get(ActionConfigCollector::class)()
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
