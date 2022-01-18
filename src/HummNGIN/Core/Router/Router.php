<?php

namespace HummNGIN\Core\Router;

use HummNGIN\Util\Debug;
use Error;
use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Endpoint\CallbackEndpoint;
use HummNGIN\Core\Endpoint\ClassEndpoint;
use HummNGIN\Core\Endpoint\IEndpoint;
use HummNGIN\Core\Endpoint\RedirectEndpoint;
use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;
use HummNGIN\Core\RouterPathGenerator;

class Router implements IRouter
{

    public static array|IEndpoint $routes;

    public static function &get(string $name, string $path, $method): IEndpoint
    {
        return self::Register(new CallbackEndpoint($name, $path, $method, ['GET']));
    }

    public static function &Register(IEndpoint $endpoint): IEndpoint
    {
        self::$routes[$endpoint->getName()] = $endpoint;
        return self::$routes[$endpoint->getName()];
    }

// EndpointCallback

    public static function &any(string $name, string $path, $method): IEndpoint
    {
        return self::Register(new CallbackEndpoint($name, $path, $method, ['GET', 'POST', 'PUT', 'DELETE']));
    }

    public static function &getWithClass(string $name, string $path, string $class, $method): IEndpoint
    {
        return self::Register(new ClassEndpoint($name, $path, [$class, $method], ['GET']));
    }


// EndpointClass

    public static function &anyWithClass(string $name, string $path, string $class, $method): IEndpoint
    {
        return self::Register(new ClassEndpoint($name, $path, [$class, $method], ['GET', 'POST', 'PUT', 'DELETE']));
    }

    public static function run($url, $method): ?Response
    {

        Debug::Debug("Request Url", $url);
        Debug::Debug("Method", $_SERVER['REQUEST_METHOD']);
        Debug::Debug("Code", http_response_code());
        try {

            $route = self::matchFromPath($url, $method);
            return $route->handle();

        } catch (Error $exception) {
            return (new AppController())->error($exception);
        }
    }


// Global

    public static function matchFromPath(string $path, string $method): IEndpoint
    {
        foreach (self::$routes as $route) {
            if ($route->match($path, $method) === false) {
                continue;
            }
            return $route;
        }

        throw new Error("No registred endpoint handling this URL<br>URL:$path<br>Method:$method", 404);
    }

    public static function handle(Request $request): Response
    {
        $route = self::matchFromPath($request->getUri(), $request->getMethod());
        return $route->handle($request);
    }


    public static function location($url = "/")
    {
        header("Location: {$url}");
    }

    public static function routingTable(): array
    {

        $array = array();
        foreach (Router::$routes as $route) {
            $array[] = [$route->GetName(), $route->getPath(), $route->getMethods()];

        }
        return $array;
    }

    public static function Redirect(string $src_url, string $dest_url)
    {
        self::Register(new RedirectEndpoint($src_url, $dest_url));
    }

    public static function generateUrl(string $name, array $parameters = []): string
    {
        $generator = new RouterPathGenerator();
        return $generator->generate($name, $parameters);
    }

}