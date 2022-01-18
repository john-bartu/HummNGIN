<?php

namespace HummNGIN\Core\Http;

use HummNGIN\Controllers\AppController;
use const ENT_QUOTES;

class RedirectResponse extends Response
{

    public function __construct(string $url, $status = Response::HTTP_FOUND, array $headers = [])
    {
        parent::__construct('', $status, $headers);

        $controller = new AppController();
        $redirect_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $html = $controller->only_render(
            "redirect",
            ['redirect' =>
                [
                    'reason' => Response::$statusTexts[$status],
                    'code' => $status,
                    'url' => $redirect_url
                ]
            ]
        );


        $this->setContent($html);
        $this->headers->set('Location', $url);
    }
}