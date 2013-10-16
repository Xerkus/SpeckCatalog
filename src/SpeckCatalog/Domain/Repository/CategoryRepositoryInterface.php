<?php

namespace SpeckCatalog\Domain\Repository;

use SpeckCatalog\Domain\Model\Category;

interface CategoryRepositoryInterface
{
    public function addCategory(Category $category);
    public function removeCategory(Category $category);
    public function findCategory($id);
    public function findChildCategories(Category $category);
}
