<?php

namespace HummNGIN\Util\Validators;

class ValidatorBuilder implements IValidator
{
    private array $patterns;

    public function __construct()
    {
        $this->patterns = [];
    }

    public function check($value): bool
    {
        foreach ($this->patterns as $pattern) {
            if (!preg_match($pattern, $value))
                return false;
        }

        return true;
    }

    protected function hasAtLeastLowerCaseLetter()
    {
        $this->addValidation("/^(?=.*[a-z])$/");
    }

    protected function addValidation(string $pattern)
    {
        $this->patterns[] = $pattern;
    }

    protected function hasAtLeastUpperCaseLetter()
    {
        $this->addValidation("/^(?=.*[A-Z])$/");
    }

    protected function hasAtLeastLetter()
    {
        $this->addValidation("/^(?=.*[A-Za-z])$/");
    }

    protected function hasAtLeastNumber()
    {
        $this->addValidation("/^(?=.*\d)$/");
    }

    protected function hasAtLeastSymbol()
    {
        $this->addValidation("/^(?=.*[@$!%*?&])$/");
    }

    protected function onlyLetters()
    {
        $this->addValidation("[A-Za-z]$");
    }

    protected function onlyNumbers()
    {
        $this->addValidation("[\d]$");
    }

    protected function onlyLettersAndNumbers()
    {
        $this->addValidation("[A-Za-z\d]$");
    }

    protected function onlyCommonCharacters()
    {
        preg_match("[A-Za-z\d@$!%#%\(\)*?&]$","test");

        $this->addValidation("^[A-Za-z\d@$!%*?&]$");
    }

}