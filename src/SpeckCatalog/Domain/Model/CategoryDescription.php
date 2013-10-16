<?php

namespace SpeckCatalog\Domain\Model;

class CategoryDescription
{
    protected $description;

    public function __construct($description = '')
    {
        $this->description = (string)$description;
    }

    public function getDescription()
    {
        return $description;
    }

}
