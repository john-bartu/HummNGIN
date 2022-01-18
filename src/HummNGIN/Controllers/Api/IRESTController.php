<?php

namespace HummNGIN\Controllers\Api;

use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;

interface IRESTController
{
    public function post(Request $request): Response;
    public function get(Request $request): Response;
    public function put(Request $request): Response;
    public function delete(Request $request): Response;
}