<?php

declare(strict_types=1);
require_once __DIR__ . '/autoload.php';

use blog\Http\version\PHPVersion;

new PHPVersion('7.4');
require_once __DIR__ . '/assets.php';
require_once __DIR__ . '/dump.php';
require_once __DIR__ . '/route.php';
require_once __DIR__ . '/includes.php';
require_once __DIR__ . '/escape.php';
require_once __DIR__ . '/webRoute.php';
require_once __DIR__ . '/closures.php';
