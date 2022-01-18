<?php

namespace HummNGIN\Util\Validators;

class PasswordValidator extends ValidatorBuilder
{


    public function __construct()
    {
        parent::__construct();

        $this->hasAtLeastLowerCaseLetter();
        $this->hasAtLeastSymbol();
        $this->hasAtLeastUpperCaseLetter();

    }
}