<?php

namespace HummNGIN\Core\Endpoint;

use Exception;
use InvalidArgumentException;
use HummNGIN\Core\Http\Request;
use HummNGIN\Guard\IGuard;
use ReflectionClass;


class ClassEndpoint implements IEndpoint
{
    private string $name;
    private string $path;
    private array $parameters = [];
    private array $vars = [];
    private ?string $middleware;

    private array $methods;

    public function __construct(string $name, string $path, array $parameters, array $methods = ['GET'])
    {
        if ($methods === []) {
            throw new InvalidArgumentException('Endpoint needs implement at least one method!');
        }
        $this->name = $name;
        $this->path = $path;
        $this->parameters = $parameters;
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
        $parameters = $this->getParameters();

        $controllerName = $parameters[0];
        $methodName = $parameters[1] ?? 'index';


        if (isset($request))
            $controller = new $controllerName($request);
        else
            $controller = new $controllerName();


        if (!is_callable($controller)) {
            $controller = [$controller, $methodName];
        }

        if (isset($this->middleware)) {
            $ware = new $this->middleware;
            if (!$ware->auth()) {
                /** @var IGuard $ware */
                return $ware->UnauthorizedResponse();
            }
        }

        if (!is_callable($controller)) {
            throw new Exception("Controller: " . $this->getName() . "<br>URL:<br>Method:" . implode(",", $this->getMethods()) . "<br>But no handling function found<br>" . $this->getParameters()[0] . "->" . $methodName, 404);
        } else {

            $classParameters = (new ReflectionClass($controllerName))->getMethod($methodName)->getParameters();

            if (count($classParameters) > 0 && $classParameters[0]->getType() == Request::class) {
                $parameters = array_merge([$request], array_values($this->getVariables()));
                return $controller(...$parameters);
            } else {
                return $controller(...array_values($this->getVariables()));
            }

        }

    }

    protected function getParameters(): array
    {
        return $this->parameters;
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