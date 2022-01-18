<?php

namespace HummNGIN\Models;

class DynamicModel
{
    private mixed $vars;
    private string $table_name;

    /**
     * @param mixed $vars
     */
    public function __construct(string $table_name, mixed $vars)
    {
        $this->vars = $vars;
        $this->table_name = $table_name;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function get($name)
    {
        return $this->vars[$name];
    }

    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function getVarNames(): array
    {
        return array_keys($this->vars);
    }

    public function getValues()
    {
        return array_values($this->vars);
    }

    public function getVars()
    {
        return $this->vars;
    }

}