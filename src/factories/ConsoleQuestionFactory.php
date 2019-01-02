<?php
declare(strict_types=1);

namespace corbomite\cli\factories;

use Symfony\Component\Console\Question\Question;

class ConsoleQuestionFactory
{
    public function make(string $question): Question
    {
        return new Question($question);
    }
}
