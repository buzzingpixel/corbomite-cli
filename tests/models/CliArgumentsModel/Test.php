<?php
declare(strict_types=1);

namespace corbomite\tests\models\CliArgumentsModel;

use PHPUnit\Framework\TestCase;

use corbomite\cli\models\CliArgumentsModel;

class Test extends TestCase
{
    public function test(): void
    {
        $initialArgs = [
            '--foo=bar',
            '--sun=shine',
        ];

        $argumentsModel = new CliArgumentsModel($initialArgs);

        self::assertEquals($initialArgs, $argumentsModel->getRawArguments());

        self::assertEquals(
            [
                'foo' => 'bar',
                'sun' => 'shine',
            ],
            $argumentsModel->getParsedArguments()
        );

        self::assertEquals('bar', $argumentsModel->getArgument('foo'));
        self::assertEquals('shine', $argumentsModel->getArgument('sun'));

        self::assertEquals('bar', $argumentsModel->getArgumentByIndex(0));
        self::assertEquals('shine', $argumentsModel->getArgumentByIndex(1));

        $newArguments = [
            '--testing',
            '--Jim=Kirk',
        ];

        $argumentsModel->setRawArguments($newArguments);

        self::assertEquals($newArguments, $argumentsModel->getRawArguments());

        self::assertEquals(
            [
                'testing' => 'testing',
                'Jim' => 'Kirk',
            ],
            $argumentsModel->getParsedArguments()
        );

        self::assertEquals('testing', $argumentsModel->getArgument('testing'));
        self::assertEquals('Kirk', $argumentsModel->getArgument('Jim'));

        self::assertEquals('testing', $argumentsModel->getArgumentByIndex(0));
        self::assertEquals('Kirk', $argumentsModel->getArgumentByIndex(1));
    }
}
