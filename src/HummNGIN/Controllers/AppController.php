<?php

namespace HummNGIN\Controllers;

use eftec\bladeone\BladeOne;
use Error;
use Exception;
use HummNGIN\Core\Http\RedirectResponse;
use HummNGIN\Core\Http\Response;
use HummNGIN\Util\Debug;

class AppController
{
    private mixed $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function render_layout(string $template = null, array $variables = []): ?Response
    {
        try {
            return new Response($this->only_render($template, $variables));
        } catch (Exception $e) {
            $this->error(new Error($e->getMessage(), 1002));
            return null;
        }
    }

    public function only_render(string $template = null, array $variables = []): ?string
    {
        Debug::Debug("Template", $template);
        Debug::Debug("Controller", get_class($this));

        $views = ['../views', '../views/debug', '../views/admin'];
        $cache = '../views/cache';

        $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

        try {
            return $blade->run($template, $variables);
        } catch (Exception $e) {
            $this->error(new Error($e->getMessage(), 1002));
            return null;
        }
    }

    function error(Error $error): ?Response
    {
        return new RedirectResponse("/", $error->getCode() <= 0 ? 404 : $error->getCode());
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(string $template = null, array $variables = []): ?Response
    {
        Debug::Debug("View", $template);
        Debug::Debug("Controller", get_class($this));
        $templatePath = 'public/views/' . $template . '.php';

        if (file_exists($templatePath)) {
            extract($variables);
            ob_start();
            include $templatePath;
            return new Response(ob_get_clean());
        } else {
            return $this->error(new Error("View not found '" . $template . "'", 1001));
        }
    }
}