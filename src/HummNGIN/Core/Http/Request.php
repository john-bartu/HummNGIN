<?php

namespace HummNGIN\Core\Http;

use JetBrains\PhpStorm\Pure;
use HummNGIN\Util\Package;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';
//    public const METHOD_HEAD = 'HEAD';
//    public const METHOD_PATCH = 'PATCH';
//    public const METHOD_PURGE = 'PURGE';
//    public const METHOD_OPTIONS = 'OPTIONS';
//    public const METHOD_TRACE = 'TRACE';
//    public const METHOD_CONNECT = 'CONNECT';

    protected Package $get;
    protected Package $post;
    protected Package $cookie;
    protected Package $files;
    protected Package $server;
    protected Package $jsonBody;

    #[Pure] public function __construct()
    {
        $this->get = new Package($_GET);
        $this->post = new Package($_POST);
        $this->cookie = new Package($_COOKIE);
        $this->files = new Package($_FILES);
        $this->server = new Package($_SERVER);

        if ($this->server->get("CONTENT_TYPE") == "application/json")
            $this->jsonBody = new Package(json_decode(file_get_contents("php://input"), true));

    }

    #[Pure] public static function capture(): Request
    {
        return new Request();
    }

    public function getUri(): string
    {
        return $this->server->get('REQUEST_URI', "/");
    }

    public function getMethod(): string
    {
        return $this->server->get('REQUEST_METHOD', Request::METHOD_GET);
    }

    public function &GET(): Package
    {
        return $this->get;
    }

    public function &SERVER(): Package
    {
        return $this->server;
    }

    public function &POST(): Package
    {
        return $this->post;
    }

    public function &COOKIE(): Package
    {
        return $this->cookie;
    }

    public function &FILES(): Package
    {
        return $this->files;
    }

    public function &JSON(): Package
    {
        return $this->jsonBody;
    }
}