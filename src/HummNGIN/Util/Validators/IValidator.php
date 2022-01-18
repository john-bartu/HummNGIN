<?php

namespace HummNGIN\Util\Validators;

interface IValidator
{
    public function check($value): bool;
}