<?php

namespace HummNGIN\Repository;


use JetBrains\PhpStorm\Pure;
use HummNGIN\Core\Database;

class BaseRepository
{
    protected Database $database;

    #[Pure] public function __construct()
    {
        $this->database = new Database();
    }
}