<?php

namespace HummNGIN\Core\Http;

use InvalidArgumentException;
use HummNGIN\Core\Headers\Header;
use HummNGIN\Util\Debug;

class JSONResponse extends Response
{

    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        parent::__construct();

        $this->headers = new Header($headers);
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');

        $this->headers->set('expires', -1);
        $this->headers->set('Cache-Control', "private, must-revalidate");
        $this->headers->set('Content-Type', "application/json");
        $this->headers->set('charset', "utf-8");
    }

}