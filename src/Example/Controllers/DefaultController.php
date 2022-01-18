<?php

namespace Example\Controllers;

use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Http\Response;
use HummNGIN\Repository\DynamicRepository;

class DefaultController extends AppController
{

    protected DynamicRepository $pageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->pageRepository = new DynamicRepository('hb_pages');
    }


    public function index(): ?Response
    {
        $pages = $this->pageRepository->getAll('time_creation', "DESC");
        return $this->render_layout('default', ['pages'=>$pages]);
    }


}