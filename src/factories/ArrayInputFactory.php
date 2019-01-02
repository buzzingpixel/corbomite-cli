<?php
declare(strict_types=1);

namespace corbomite\cli\factories;

use Symfony\Component\Console\Input\ArrayInput;

class ArrayInputFactory
{
    public function make(array $params): ArrayInput
    {
        return new ArrayInput($params);
    }
}
