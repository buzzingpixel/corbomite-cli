<?php
declare(strict_types=1);

namespace corbomite\cli;

use LogicException;
use Composer\Console\Application;

class ActionConfigCollector
{
    public function __invoke(): array
    {
        if (! defined('APP_BASE_PATH')) {
            throw new LogicException('APP_BASE_PATH must be defined');
        }

        // Edge case and weirdness with composer
        getenv('HOME') || putenv('HOME=' . __DIR__);

        $oldCwd = getcwd();

        $actionConfig = [];

        chdir(APP_BASE_PATH);

        $appJsonPath = APP_BASE_PATH . DIRECTORY_SEPARATOR . 'composer.json';

        if (file_exists($appJsonPath)) {
            $appJson = json_decode(file_get_contents($appJsonPath), true);
            $configFilePath = $appJson['extra']['cliActionConfigFilePath'] ?? null;

            if ($configFilePath &&
                file_exists($configFilePath)
            ) {
                $configInclude = include APP_BASE_PATH . '/' . $configFilePath;
                $actionConfig = \is_array($configInclude) ? $configInclude : [];
            }
        }

        $composerApp = new Application();

        /** @noinspection PhpUnhandledExceptionInspection */
        $composer = $composerApp->getComposer();
        $repositoryManager = $composer->getRepositoryManager();
        $installedFilesystemRepository = $repositoryManager->getLocalRepository();
        $packages = $installedFilesystemRepository->getCanonicalPackages();

        foreach ($packages as $package) {
            $extra = $package->getExtra();

            $configFilePath = APP_BASE_PATH .
                '/vendor/' .
                $package->getName() .
                '/' .
                ($extra['cliActionConfigFilePath'] ?? 'asdf');

            if (file_exists($configFilePath)) {
                $configInclude = include $configFilePath;
                $config = \is_array($configInclude) ? $configInclude : [];
                $actionConfig = array_merge($actionConfig, $config);
            }
        }

        chdir($oldCwd);

        return $actionConfig;
    }
}
