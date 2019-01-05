# Corbomite CLI

Part of BuzzingPixel's Corbomite project.

Provides a light framework for registering and running commands on the PHP CLI.

## Usage

In your CLI front controller, use the dependency injector to call the Kernel (note that `APP_BASE_PATH` must be defined):

```php
<?php
declare(strict_types=1);

use corbomite\di\Di;
use corbomite\cli\Kernel as CliKernel;

define('APP_BASE_PATH', __DIR__);
define('APP_VENDOR_PATH', APP_BASE_PATH . '/vendor');

require APP_VENDOR_PATH . '/autoload.php';

Di::get(CliKernel::class)($argv);
```

## Actions (Commands)

Your app or composer package can provide actions to run on the command line. To do so, set a `cliActionConfigFilePath` key in the `extra` object of your compose.json:

```json
{
    "name": "vendro/name",
    "extra": {
        "cliActionConfigFilePath": "src/actionConfig.php"
    }
}
```

The return of your config file path should be an array formatted like this:

```php
<?php
declare(strict_types=1);

return [
    'group-name' => [
        'description' => 'Very short description of group',
        'commands' => [
            'my-command' => [
                'description' => 'Very short description of command',
                'class' => \some\action\ClassName::class,
                'method' => 'myMethod', // defaults to __invoke()
            ],
            'another-command' => [
                'description' => 'Very short description of command',
                'class' => \some\action\ClassName::class,
            ],
        ],
    ],
    'another-name' => [
        'description' => 'Very short description of group',
        'commands' => [
            'my-command' => [
                'description' => 'Very short description of command',
                'class' => \some\action\ClassName::class,
            ],
        ],
    ],
];
```

The kernel will try to get your class from the [Corbomite Dependency Injector](https://github.com/buzzingpixel/corbomite-di) before `new`ing it up so you can set up dependency injection on your action classes if you desire.

The called action method will receive one argument of `\corbomite\cli\models\CliArgumentsModel`.

## Question Service

You can use the Question Service to ask questions on the console and wait for the user's response:

```php
<?php
declare(strict_types=1);

namespace my\name\space;

use corbomite\cli\models\CliArgumentsModel;
use corbomite\cli\services\CliQuestionService;

class CreateMigrationAction
{
    private $cliQuestionService;

    public function __construct(
        CliQuestionService $cliQuestionService
    ) {
        $this->cliQuestionService = $cliQuestionService;
    }

    public function __invoke(CliArgumentsModel $argModel)
    {
        if (! $val = $argModel->getArgumentByIndex(2)) {
            $name = $this->cliQuestionService->ask(
                '<fg=cyan>Ask some question: </>'
            );
        }

        // ...do something with $val
    }
}
```

## License

Copyright 2018 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
