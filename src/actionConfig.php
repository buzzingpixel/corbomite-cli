<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\cli\actions\ListActionsAction;

return [
    'cli' => [
        'description' => 'Corbomite CLI Commands',
        'commands' => [
            'list-actions' => [
                'description' => 'Lists available actions',
                'class' => ListActionsAction::class,
            ],
        ],
    ],
];
