<?php

namespace HummNGIN\Core\Router;


use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;

interface IRouter
{
    public static function handle(Request $request): Response;
    public static function generateUrl(string $name, array $parameters = []): string;
}