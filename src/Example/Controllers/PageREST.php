<?php

namespace Example\Controllers;

use HummNGIN\Controllers\Api\DefaultRESTController;
use HummNGIN\Repository\DynamicRepository;

class PageREST extends DefaultRESTController
{
    public function __construct()
    {
        parent::__construct(new DynamicRepository("hb_pages"));
    }
}