<?php
declare(strict_types=1);

namespace corbomite\cli;

use Psr\Container\ContainerInterface;
use NunoMaduro\Collision\Provider as Collision;

class Kernel
{
    private $appDiContainer;
    private $arguments;
    private $collision;
    private $phpInternalCalls;

    public function __construct(
        ContainerInterface $appDiContainer,
        array $arguments = [],
        Collision $collision = null,
        PHPInternalCalls $phpInternalCalls = null
    ) {
        $this->appDiContainer = $appDiContainer;
        $this->arguments = $arguments;
        $this->collision = $collision ?? new Collision();
        $this->phpInternalCalls = $phpInternalCalls ?? new PHPInternalCalls();
    }

    public function __invoke()
    {
        // Set up errors
        $this->phpInternalCalls->iniSet('display_errors', '1');
        $this->phpInternalCalls->iniSet('display_startup_errors', '1');
        $this->phpInternalCalls->errorReporting(E_ALL);
        $this->collision->register();
    }
}
