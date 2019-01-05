<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use corbomite\cli\ActionConfigCollector;

define('APP_BASE_PATH', __DIR__);

require_once 'vendor/autoload.php';

var_dump(Di::get(ActionConfigCollector::class)());
