<?php

namespace Example\Controllers;


use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Http\Response;
use HummNGIN\Repository\DynamicRepository;

class PageController extends DefaultController
{

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
        $pages = $this->pageRepository->getAll('name');
        $page = $this->pageRepository->getOne('id', $id);

        return $this->render_layout(
            'PageShow',
            array(
                'pages' => $pages,
                'page' => $page,
            )
        );
    }
}