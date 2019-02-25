<?php
declare(strict_types=1);

namespace corbomite\tests\Kernel;

class ActionCallable
{
    public function __invoke(): string
    {
        return 'ActionCallable::__invoke';
    }

    public function callableMethod(): string
    {
        return 'ActionCallable::callableMethod';
    }
}
