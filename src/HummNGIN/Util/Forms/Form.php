<?php

namespace HummNGIN\Util\Forms;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use HummNGIN\Util\Package;

class Form extends Package
{
    public const FieldNumber = 0;
    public const FieldText = 1;
    public const FieldTextArea = 2;

    private string $url;
    private string $method;

    #[Pure]
    public function __construct($url = "", $method = "")
    {
        parent::__construct(array());
        $this->url = $url;
        $this->method = $method;
    }


    #[Pure]
    #[ArrayShape(['api_url' => "string", 'method' => "string", 'form' => "mixed"])]
    public function Serialize(): array
    {
        return [
            'api_url' => $this->getUrl(),
            'method' => $this->getMethod(),
            'form' => $this->getContent()
        ];
    }

    #[Pure]
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $apiUrl
     */
    public function setURL(string $apiUrl): void
    {
        $this->url = $apiUrl;
    }

    #[Pure]
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
}