<?php

namespace HummNGIN\Util;

interface IPackage
{

    public function get(string $key, $default_value = null);

    public function set(string $key, $value);

    public function has(string $key): bool;

    public function remove(string $key);

    public function count(): int;

    public function getContent();

}