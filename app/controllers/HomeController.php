<?php

declare(strict_types=1);

namespace blog\controllers;

use blog\controllers\Controller;


class HomeController extends Controller
{
  public function home()
  {
    return $this->views("/home", ["title" => 'Home']);
  }
}
