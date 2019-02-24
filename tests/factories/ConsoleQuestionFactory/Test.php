<?php
declare(strict_types=1);

namespace corbomite\tests\factories\ConsoleQuestionFactory;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Question\Question;
use corbomite\cli\factories\ConsoleQuestionFactory;

class Test extends TestCase
{
    public function test(): void
    {
        $factory = new ConsoleQuestionFactory();

        $question = $factory->make('Test Question');

        $reflector = new \ReflectionClass($question);
        $property = $reflector->getProperty('question');
        $property->setAccessible(true);

        self::assertInstanceOf(Question::class, $question);

        self::assertEquals($property->getValue($question), 'Test Question');
    }
}
