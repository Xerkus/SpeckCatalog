<?php

namespace SpeckCatalog\Model\Category;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\Category as Base;

class Relational extends Base
{
    protected $parent;
    protected $categories;
    protected $products;

    /**
     * @return categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function addCategory($category)
    {
        $category->setParent($this);
        $this->categories[] = $category;
        return $this;
    }

    /**
     * @param $categories
     * @return self
     */
    public function setCategories($categories)
    {
        $this->categories = [];

        foreach ($categories as $category) {
            $this->addCategory($category);
        }

        return $this;
    }

    /**
     * @return products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param $products
     * @return self
     */
    public function setProducts(\Zend\Paginator\Paginator $products = null)
    {
        if ($products !== null) {
            foreach ($products as $product) {
                $product->setParent($this);
            }
        }

        $this->products = $products;

        return $this;
    }

    public function __toString()
    {
        $name = $this->getName();
        $parent = parent::__toString();
        return ($name ?: $parent);
    }

    /**
     * @return parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent
     * @return self
     */
    public function setParent(AbstractModel $parent)
    {
        $this->parent = $parent;
        return $this;
    }
}
