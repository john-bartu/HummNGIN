<?php

namespace HummNGIN\Util;

class Package
{
    private mixed $pack;

    public function __construct($mixed)
    {
        $this->pack = $mixed;
    }

    public function get(string $key, $default_value = null)
    {
        return $this->pack[$key] ?? $default_value;
    }

    public function set(string $key, $value)
    {
        $this->pack[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->pack);
    }

    public function remove(string $key)
    {
        unset($this->pack[$key]);
    }

    public function count(): int
    {
        return count($this->pack);
    }

    public function &getContent()
    {
        return $this->pack;
    }

}