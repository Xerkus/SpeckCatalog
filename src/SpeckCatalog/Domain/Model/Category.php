<?php

namespace SpeckCatalog\Domain\Model;

use InvalidArgumentException;

class Category
{
    protected $categoryId;
    protected $name;
    protected $parentId;
    protected $description;

    public function __construct($name, CategoryDescription $description = null)
    {
        $this->setName($name);
        if ($description === null) {
            $description = new CategoryDescription();
        }
        $this->setDescription($description);
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function changeName($name)
    {
        // @todo triggerDomainEvent?
        $this->setName($name);
    }

    /**
     * getDescription
     *
     * @return CategoryDescription
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function changeDescription(CategoryDescription $description)
    {
        // @todo triggerDomainEvent
        $this->setDescription($description);
    }

    public function addChild(Category $category)
    {
        $category->setParent($this);
    }

    public function setParent(Category $category)
    {
        $this->setParentId($category->getCategoryId());
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    /*
     * below are protected setters for logic for object reconstitution in infrastructure layer
     */

    protected function setName($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new InvalidArgumentException('Category name must be nonempty string');
        }

        $this->name = $name;
    }

    protected function setCategoryId($id)
    {
        $this->categoryId = $id;
    }

    protected function setDescription(CategoryDescription $description)
    {
        $this->description = $description;
    }

    protected function setParentId($id)
    {
        $this->parentId = $id;
    }
}
