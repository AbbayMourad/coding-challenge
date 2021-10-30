<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Validators\CategoryValidator;

class CategoryService
{
    private CategoryValidator $categoryValidator;

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryValidator $categoryValidator, CategoryRepository $categoryRepository)
    {
        $this->categoryValidator = $categoryValidator;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $categoryData)
    {
        $this->categoryValidator->validate($categoryData);

        return $this->categoryRepository->create($categoryData);
    }

    public function getMany(array $conditions = [])
    {
        return $this->categoryRepository->getMany($conditions);
    }

    public function getManyByIds(array $ids) {
        return $this->categoryRepository->getManyByIds($ids);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
