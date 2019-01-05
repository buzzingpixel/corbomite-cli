<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\cli\factories;

use Symfony\Component\Console\Question\Question;

class ConsoleQuestionFactory
{
    public function make(string $question): Question
    {
        return new Question($question);
    }
}
