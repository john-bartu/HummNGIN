<?php

namespace HummNGIN\Core\Endpoint;

use Error;
use Exception;
use InvalidArgumentException;
use HummNGIN\Core\Http\Request;
use HummNGIN\Guard\IGuard;
use ReflectionFunction;


class CallbackEndpoint implements IEndpoint
{
    private string $name;
    private string $path;
    private $callback;
    private array $vars = [];
    private ?string $middleware;


    private array $methods;

    public function __construct(string $name, string $path, callable $callback, array $methods = ['GET'])
    {
        if ($methods === []) {
            throw new InvalidArgumentException('Endpoint needs implement at least one method!');
        }
        $this->name = $name;
        $this->path = $path;
        $this->callback = $callback;
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
    public function handle(Request|null $request)
    {
        if (isset($this->middleware)) {
            $ware = new $this->middleware;
            if (!$ware->auth()) {
                /** @var IGuard $ware */
                return $ware->UnauthorizedResponse();
            }
        }

        if (!is_callable($this->getCallback())) {
            throw new Error("Controller: " . $this->getName() . "<br>URL:<br>Method:" . implode(",", $this->getMethods()) . "<br>But no handling function found<br>" . $this->getCallback(), 404);
        } else {
            $controller = $this->getCallback();


            $methodParameters = (new ReflectionFunction($controller))->getParameters();

            if (count($methodParameters) > 0 && $methodParameters[0]->getType() == Request::class) {
                $parameters = array_merge([$request], array_values($this->getVariables()));
                return $controller(...$parameters);
            } else {
                return $controller(...array_values($this->getVariables()));
            }

        }
    }

    protected function getCallback(): callable
    {
        return $this->callback;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function getVariables(): array
    {
        return $this->vars;
    }

    public function Guard($guard_name)
    {
        $this->middleware = $guard_name;
    }

    public function hasVariables(): bool
    {
        return $this->getVariablesNames() !== [];
    }


}