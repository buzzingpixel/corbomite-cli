<?php
declare(strict_types=1);

use corbomite\di\Di;
use corbomite\cli\Kernel;
use Composer\Console\Application;
use corbomite\cli\PHPInternalCalls;
use corbomite\cli\ActionConfigCollector;
use corbomite\cli\actions\ListActionsAction;
use NunoMaduro\Collision\Provider as Collision;

return [
    ActionConfigCollector::class => function () {
        $composerApp = new Application();

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
        return new ListActionsAction();
    },
];
