<?php

namespace HummNGIN\Controllers\Api;

use HummNGIN\Repository\DynamicRepository;

class PageREST extends DefaultRESTController
{
    public function __construct()
    {
        parent::__construct(new DynamicRepository("his_pages"));
    }
}