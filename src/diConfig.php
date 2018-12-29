<?php
declare(strict_types=1);

use Composer\Console\Application;
use corbomite\cli\ActionConfigCollector;

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
];
