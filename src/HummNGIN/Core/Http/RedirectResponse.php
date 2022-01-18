<?php

namespace HummNGIN\Core\Http;

use const ENT_QUOTES;

class RedirectResponse extends Response
{

    public function __construct(string $url, $status = Response::HTTP_FOUND, array $headers = [])
    {
        parent::__construct('', $status, $headers);
        $this->setContent(
            sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url=\'%1$s\'" />

        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to <a href="%1$s">%1$s</a>.
    </body>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8')));
        $this->headers->set('Location', $url);
    }
}