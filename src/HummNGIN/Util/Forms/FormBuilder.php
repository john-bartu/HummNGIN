<?php

namespace HummNGIN\Util\Forms;

use JetBrains\PhpStorm\Pure;

class FormBuilder implements IFormBuilder
{
    private Form $form;

    #[Pure] public function __construct($apiUrl, $method)
    {
        $this->form = new Form();
        $this->SetURL($apiUrl);
        $this->SetMethod($method);
    }

    public function SetURL(string $url)
    {
        $this->form->setURL($url);
    }

    public function SetMethod(string $method)
    {
        $this->form->setMethod($method);
    }

    public function AddField(string $name, int $type, mixed $value = "")
    {
        if ($this->form->has($name)) {
            throw new \Error("Field " . $name . " already added");
        }

        $this->form->set($name, [
            'type' => $type,
            'value' => $value
        ]);
    }

    public function SetValue(string $name, mixed $value = "")
    {
        if (!$this->form->has($name)) {
            throw new \Error("Field " . $name . " not exists");
        }
        $this->form->set($name, [
            'type' => $this->form->get($name)["type"],
            'value' => $value
        ]);
    }

    public function GetForm(): Form
    {
        return $this->form;
    }

    public function Reset()
    {
        $this->form = new Form();
    }
}

