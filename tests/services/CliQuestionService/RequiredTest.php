<?php
declare(strict_types=1);

namespace corbomite\tests\services\CliQuestionService;

use PHPUnit\Framework\TestCase;
use corbomite\cli\services\CliQuestionService;
use Symfony\Component\Console\Question\Question;
use corbomite\cli\factories\ConsoleQuestionFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;

class RequiredTest extends TestCase
{
    private $counter = 0;

    public function test(): void
    {
        $self = $this;

        $question = $this->createMock(Question::class);

        $questionHelper = $this->createMock(QuestionHelper::class);

        $consoleInput = $this->createMock(InputInterface::class);

        $consoleOutput = $this->createMock(OutputInterface::class);

        $consoleQuestionFactory = $this->createMock(ConsoleQuestionFactory::class);

        $consoleQuestionFactory->expects(self::once())
            ->method('make')
            ->with(self::equalTo('Test Question'))
            ->willReturn($question);

        $questionHelper->expects(self::exactly(2))
            ->method('ask')
            ->willReturnCallback(function () use ($self) {
                $self->counter++;

                if ($self->counter === 1) {
                    return '';
                }

                return 'Question Val';
            });

        $questionService = new CliQuestionService(
            $questionHelper,
            $consoleInput,
            $consoleOutput,
            $consoleQuestionFactory
        );

        self::assertEquals('Question Val', $questionService->ask('Test Question'));
    }
}
