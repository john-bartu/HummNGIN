<?php

namespace HummNGIN\Controllers;

use HummNGIN\Core\Http\Response;

class DefaultController extends AppController
{


    public function index(): ?Response
    {
        return $this->render_layout('default');
    }


    public function dashboard(): ?Response
    {
        return $this->render_layout('dashboard');
    }


}