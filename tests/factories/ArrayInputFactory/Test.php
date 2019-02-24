<?php
declare(strict_types=1);

namespace corbomite\tests\factories\ArrayInputFactory;

use PHPUnit\Framework\TestCase;
use corbomite\cli\factories\ArrayInputFactory;
use Symfony\Component\Console\Input\ArrayInput;

class Test extends TestCase
{
    public function test(): void
    {
        $factory = new ArrayInputFactory();

        $arrayInput = $factory->make([
            'foo' => 'bar'
        ]);

        $reflector = new \ReflectionClass($arrayInput);
        $property = $reflector->getProperty('parameters');
        $property->setAccessible(true);

        self::assertInstanceOf(ArrayInput::class, $arrayInput);

        self::assertEquals($property->getValue($arrayInput)['foo'], 'bar');
    }
}
