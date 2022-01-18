<?php

namespace Example\Controllers;

use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Http\Response;

class AdminController extends AppController
{

    public function index(): int|Response|null
    {
        return $this->render_layout('AdminHome', []);
    }

}