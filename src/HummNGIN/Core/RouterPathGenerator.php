<?php

namespace HummNGIN\Core;

use Error;
use HummNGIN\Core\Endpoint\IEndpoint;
use HummNGIN\Core\Router\Router;

class RouterPathGenerator
{

    public function generate(string $name, array $parameters = []): string
    {
        $routes = Router::$routes;

        if (!array_key_exists($name, $routes)) {
            throw new Error(
                "Route $name not found",
                500
            );
        }

        $route = $routes[$name];
        if ($route->hasVariables() === true && $parameters === []) {
            throw new Error(
                $name . "route need parameters: " . implode(',', $route->getVariablesNames()),
                500
            );
        }
        return self::resolveUrl($route, $parameters);
    }

    private static function resolveUrl(IEndpoint $route, array $parameters): string
    {
        $uri = $route->getPath();
        foreach ($route->getVariablesNames() as $variable) {
            $varName = trim($variable, '{\}');
            if (array_key_exists($varName, $parameters) === false) {
                throw new Error(
                    "$varName not found in parameters to generate url",
                    500
                );
            }
            $uri = str_replace($variable, $parameters[$varName], $uri);
        }
        return $uri;
    }
}