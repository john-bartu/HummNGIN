<?php

namespace HummNGIN\Controllers;

use Error;
use HummNGIN\Core\Http\Response;
use HummNGIN\Core\Router\Router;
use HummNGIN\Util\Debug;

class DebugController extends AppController
{

    public function debug(): ?Response
    {
        if (Debug::isDebugMode())
            return $this->render_layout('routing', ['routing' => Router::routingTable()]);
        else
            return $this->error(new Error(Response::$statusTexts[404], Response::HTTP_NOT_FOUND));
    }
}