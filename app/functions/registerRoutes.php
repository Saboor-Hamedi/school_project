<?php

declare(strict_types=1);

use blog\controllers\HomeController;
use blog\Routes\core\Router;

function routes(Router $router): void
{
    allRoutes($router);
}

function allRoutes($router)
{
    $router->get('/', HomeController::class, 'home');
}
