<?php

namespace HummNGIN\Core;

use Error;
use Exception;
use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;
use HummNGIN\Core\Router\IRouter;
use HummNGIN\Util\Debug;

class Kernel
{
    private static $router;

    public static function RegisterRouter($class)
    {
        /** @var IRouter $class */
        Kernel::$router = $class;
    }

    public static function Handle(Request $request): Response
    {
        Debug::Debug("request_time", microtime(true));
        Debug::Debug("Request Url", $request->getUri());
        Debug::Debug("Method", $request->getMethod());

        try {
            return Kernel::$router::handle($request);
        } catch (Exception|Error $exception) {
            return (new AppController())->error($exception);
        }
    }

    public static function generateUrl(string $name, array $parameters = []): string
    {
        return Kernel::$router::generateUrl($name, $parameters);
    }

}