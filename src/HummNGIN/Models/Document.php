<?php

namespace HummNGIN\Models;

class Document
{
    private int $id;
    private string $name;
    private string $description;
    private int $module;
    private int $document;

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param int $module
     * @param int $document
     */
    public function __construct(int $id, string $name, string $description, int $module, int $document)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->module = $module;
        $this->document = $document;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getModule(): int
    {
        return $this->module;
    }

    /**
     * @param int $module
     */
    public function setModule(int $module): void
    {
        $this->module = $module;
    }

    /**
     * @return int
     */
    public function getDocument(): int
    {
        return $this->document;
    }

    /**
     * @param int $document
     */
    public function setDocument(int $document): void
    {
        $this->document = $document;
    }


}