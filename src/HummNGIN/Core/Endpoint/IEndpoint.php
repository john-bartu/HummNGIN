<?php

namespace HummNGIN\Core\Endpoint;

use HummNGIN\Core\Http\Request;

interface IEndpoint
{
    public function handle(Request|null $request);

    public function match(string $path, string $method);

    public function getPath();

    public function getMethods(): array;

    public function hasVariables();

    public function getVariablesNames();
}