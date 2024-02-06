<?php

declare(strict_types=1);


use App\Utils\Error;
use FastRoute;

final class Router
{
    private FastRoute\Dispatcher $dispatcher;

    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->dispatcher = FastRoute\simpleDispatcher(static function (FastRoute\RouteCollector $r) use ($routes): void {
            foreach ($routes as $route_values) {
                $r->addGroup($route_values["path"], static function (FastRoute\RouteCollector $r) use ($route_values): void {
                    foreach ($route_values["routes"] as $route) {
                        $r->addRoute($route[0], $route[1], $route[2]);
                    }
                });
            }
        });
    }
}
