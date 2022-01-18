<?php

namespace Example\Controllers;


use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Http\Response;
use HummNGIN\Repository\DynamicRepository;

class PageController extends AppController
{
    private DynamicRepository $pageRepository;


    public function __construct()
    {
        parent::__construct();
        $this->pageRepository = new DynamicRepository('hb_pages');
    }

    public function index(): ?Response
    {
        $pages = $this->pageRepository->getAll('name');

        return $this->render_layout(
            'PageIndex',
            array(
                'pages' => $pages,
            )
        );
    }

    public function get($id): ?Response
    {
        $page = $this->pageRepository->getOne('id', $id);

        return $this->render_layout(
            'PageShow',
            array(
                'page' => $page,
            )
        );
    }
}