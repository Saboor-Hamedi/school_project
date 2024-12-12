<?php

declare(strict_types=1);

namespace blog\Routes\core;

class Router
{
  protected array $routes = [];
  protected array $namedRoutes = [];
  public array $middlewares = [];


  /**
   * Add a new route to the router.
   */
  public function addRoute(string $method, string $route, $controller, string $action = 'index'): Routes
  {
    if (is_callable($controller)) {
      $routeInstance = new Routes($method, strtolower($route), '', '', $this);
      $this->routes[$method][$routeInstance->uri] = [
        'controller' => $controller,
        'action' => $action,
        'isClosure' => true
      ];
    } else {
      $routeInstance = new Routes($method, strtolower($route), $controller, $action, $this);
      $this->routes[$method][$routeInstance->uri] = [
        'controller' => $routeInstance->controller,
        'action' => $routeInstance->action,
        'isClosure' => false
      ];
    }
    return $routeInstance;
  }




  public function get(string $route, $controller, string $action = 'index'): Routes
  {
    return $this->addRoute('GET', $route, $controller, $action);
  }

  public function post(string $route, $controller, string $action = 'index'): Routes
  {
    return $this->addRoute('POST', $route, $controller, $action);
  }

  public function put(string $route, $controller, string $action = 'update'): Routes
  {
    return $this->addRoute('PUT', $route, $controller, $action);
  }

  public function delete(string $route, $controller, string $action = 'destroy'): Routes
  {
    return $this->addRoute('DELETE', $route, $controller, $action);
  }


  /**
   * Match a given URI with the registered routes.
   */
  private function compileRoute(string $route): string
  {
    $pattern = preg_replace('#\{(\w+)\}#', '(?P<\1>[^/]+)', $route);
    return '#^' . $pattern . '$#';
  }


  public function match(string $httpMethod, string $uri): ?array
  {
    if (!isset($this->routes[$httpMethod])) {
      return null;
    }
    foreach ($this->routes[$httpMethod] as $route => $routeInfo) {
      $regexRoute = $this->compileRoute($route);
      if (preg_match($regexRoute, $uri, $matches)) {
        // Extract named parameters
        $params = [];
        foreach ($matches as $key => $value) {
          if (!is_int($key)) {
            $params[$key] = $value;
          }
        }
        // Check if there are middlewares for this route
        $middlewares = $this->middlewares[$route] ?? [];
        return ['routeInfo' => $routeInfo, 'params' => $params, 'middlewares' => $middlewares];
      }
    }
    return null;
  }


  /**
   * Get the URL for a named route.
   */
  public function route(string $routeName, array $params = []): string
  {
    if (!isset($this->namedRoutes[$routeName])) {
      return $routeName;
    }

    $route = $this->namedRoutes[$routeName]['route'];
    foreach ($params as $key => $value) {
      $route = str_replace("{" . $key . "}", $value, $route);
    }

    return $route;
  }

  /**
   * Register a named route.
   */
  public function registerNamedRoute(Routes $route): void
  {
    if ($route->name) {
      $this->namedRoutes[$route->name] = [
        'method' => $route->method,
        'route' => $route->uri
      ];
    }
  }
}
