<?php
declare(strict_types=1);

define('APP_BASE_PATH', __DIR__);

require_once 'vendor/autoload.php';
(new \corbomite\cli\ActionConfigCollector())();
