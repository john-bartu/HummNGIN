<?php

namespace HummNGIN\Core\Headers;

use function is_array;

class Header
{

    protected const UPPER = '_ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    protected const LOWER = '-abcdefghijklmnopqrstuvwxyz';
    protected array $headers = [];

    public function __construct(array $headers = [])
    {
        foreach ($headers as $key => $values) {
            $this->set($key, $values);
        }
    }

    public function set(string $key, $values, bool $replace = true)
    {
        $key = strtr($key, self::UPPER, self::LOWER);

        if (is_array($values)) {
            $values = array_values($values);

            if (true === $replace || !isset($this->headers[$key])) {
                $this->headers[$key] = $values;
            } else {
                $this->headers[$key] = array_merge($this->headers[$key], $values);
            }
        } else {
            if (true === $replace || !isset($this->headers[$key])) {
                $this->headers[$key] = [$values];
            } else {
                $this->headers[$key][] = $values;
            }
        }
    }

    public function allHeadersWithoutCookies(): array
    {
        $headers = $this->allHeaders();
        if (isset($this->headerNames['set-cookie'])) {
            unset($headers[$this->headerNames['set-cookie']]);
        }

        return $headers;
    }

    public function allHeaders(): array
    {
        $headers = [];
        foreach ($this->get() as $name => $value) {
            $headers[$this->headerNames[$name] ?? $name] = $value;
        }

        return $headers;
    }

    public function get(string $key = null)
    {
        if (null !== $key) {
            return $this->headers[strtr($key, self::UPPER, self::LOWER)] ?? [];
        }

        return $this->headers;
    }


}