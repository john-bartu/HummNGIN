<?php

namespace HummNGIN\Util\Forms;

interface IFormBuilder
{
    public function AddField(string $name, int $type, mixed $value = "");

    public function GetForm(): Form;

    public function SetURL(string $url);

    public function SetMethod(string $url);

    public function Reset();
}