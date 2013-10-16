<?php

namespace SpeckCatalog\Domain\Model;

class Product
{
    protected $productId;

    public function getId()
    {
        return $this->productId;
    }

    protected function setId($id)
    {
        $this->productId = $id;
    }
}
