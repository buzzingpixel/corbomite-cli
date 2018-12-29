<?php
declare(strict_types=1);

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
