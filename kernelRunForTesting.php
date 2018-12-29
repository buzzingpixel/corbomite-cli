<?php
declare(strict_types=1);

use corbomite\di\Di;
use corbomite\cli\Kernel;

define('APP_BASE_PATH', __DIR__);
define('ENTRY_POINT', 'asdf');

require_once 'vendor/autoload.php';

Di::get(Kernel::class)($argv);
