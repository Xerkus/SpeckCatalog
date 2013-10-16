<?php

namespace SpeckCatalogTest\Domain\Model;

use SpeckCatalog\Domain\Model\Category;
use SpeckCatalog\Domain\Model\CategoryDescription;
use SpeckCatalogTest\Helper\ProtectedSetterAccessor;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
    public function testNewCategorySetsName()
    {
        $category = new Category('name');
        $this->assertEquals('name', $category->getName());
    }

    public function testNewCategorySetsDescription()
    {
        $description = new CategoryDescription('');
        $category = new Category('name', $description);
        $this->assertSame($description, $category->getDescription());
    }

    public function testNewCategoryHaveEmptyDescription()
    {
        $category = new Category('name');
        $this->assertInstanceOf('SpeckCatalog\Domain\Model\CategoryDescription', $category->getDescription());
    }

    public function testEmptyNameShouldThrowException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $category = new Category('');
    }

    public function testNewCategoryHaveNoId()
    {
        $category = new Category('name');
        $this->assertEquals(null, $category->getCategoryId());
    }

    public function testSetCategoryId()
    {
        $category = new Category('name');
        $accessor = new ProtectedSetterAccessor($category);
        $accessor->setCategoryId(1);
        $this->assertEquals(1, $category->getCategoryId());
    }

    public function testInitialParentIdIsNull()
    {
        $category = new Category('name');
        $this->assertEquals(null, $category->getParentId());
    }

    public function testSetParentShouldSetParentId()
    {
        $parent = new Category('parent');
        $accessor = new ProtectedSetterAccessor($parent);
        $accessor->setCategoryId(1);

        $category = new Category('name');
        $category->setParent($parent);
        $this->assertEquals(1, $category->getParentId());
    }

    public function testSetChildShouldSetParentId()
    {
        $parent = new Category('parent');
        $accessor = new ProtectedSetterAccessor($parent);
        $accessor->setCategoryId(1);

        $child = new Category('child');
        $parent->addChild($child);
        $this->assertEquals(1, $child->getParentId());
    }
}

