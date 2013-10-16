<?php

namespace SpeckCatalog\Domain\Service;

use SpeckCatalog\Domain\Category;
use SpeckCatalog\Domain\Repository\CategoryRepositoryInterface;

class CategoryService
{
    public function deleteCategory(Category $category)
    {
        $repository = $this->getCategoryRepository();
        $childs = $repository->findChildCategories($category);
        foreach ($childs as $child) {
            $this->deleteCategory($child);
        }
        $repository->removeCatgegory($category);
        //$this->domainEvent('category deleted');
    }

    /**
     * getCategoryRepository
     *
     * @return CategoryRepositoryInterface
     */
    public function getCategoryRepository()
    {

    }
}
