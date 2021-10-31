<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Validators\CategoryValidator;

class CategoryService extends Service
{
    private CategoryValidator $categoryValidator;

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryValidator $categoryValidator, CategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $this->categoryValidator = $categoryValidator;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $categoryData): Category
    {
        $this->categoryValidator->validate($categoryData);

        return $this->categoryRepository->create($categoryData);
    }

    public function get(array $condition = []): ?Category
    {
        return $this->categoryRepository->get($condition);
    }
}
