<?php

namespace HummNGIN\Core\Endpoint;

use Exception;
use InvalidArgumentException;
use HummNGIN\Guard\IGuard;


class RedirectEndpoint implements IEndpoint
{
    private string $name;
    private string $path;
    private string $callback;
    private array $vars = [];
    private ?string $middleware;


    private array $methods;

    public function __construct(string $path, string $new_path, array $methods = ['GET'])
    {
        if ($methods === []) {
            throw new InvalidArgumentException('Endpoint needs implement at least one method!');
        }
        $this->name = "redirect:" . str_replace("/", "_", $new_path);
        $this->path = $path;
        $this->callback = $new_path;
        $this->methods = $methods;
    }

    public function match(string $path, string $method): bool
    {
        $regex = $this->getPath();

        foreach ($this->getVariablesNames() as $variable) {
            $varName = trim($variable, '{\}');
            $regex = str_replace($variable, '(?P<' . $varName . '>[^/]++)', $regex);
        }

        if (in_array($method, $this->getMethods()) && preg_match('#^' . $regex . '$#sD', self::trimPath($path), $matches)) {
            $values = array_filter($matches, static function ($key) {
                return is_string($key);
            }, ARRAY_FILTER_USE_KEY);
            foreach ($values as $key => $value) {
                $this->vars[$key] = $value;
            }
            return true;
        }
        return false;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getVariablesNames()
    {
        preg_match_all('/{[^}]*}/', $this->path, $matches);
        return reset($matches) ?? [];
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    protected static function trimPath(string $path): string
    {
        return '/' . rtrim(ltrim(trim($path), '/'), '/');
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        if (isset($this->middleware)) {
            $ware = new $this->middleware;
            if (!$ware->auth()) {
                /** @var IGuard $ware */
                $ware->UnauthorizedResponse();
            }
        }

        header("Location: {$this->getCallback()}");
    }

    protected function getCallback()
    {
        return $this->callback;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function Guard($guard_name)
    {
        $this->middleware = $guard_name;
    }

    public function hasVariables(): bool
    {
        return $this->getVariablesNames() !== [];
    }

    protected function getVariables(): array
    {
        return $this->vars;
    }
}