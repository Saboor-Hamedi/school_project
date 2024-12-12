<?php

declare(strict_types=1);

use blog\Routes\core\App;
use blog\Routes\core\Router;
use blog\services\Paths;

$register = Paths::SUGAR . '/registerRoutes.php';
require_once $register;
$router = new Router();
$app = new App($router);
routes($router); // load routes
$app->run();
