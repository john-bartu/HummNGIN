<?php

namespace HummNGIN\Core\Http;

interface IResponse
{
    public function send(): object;
}