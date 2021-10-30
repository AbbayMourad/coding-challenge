<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends Repository
{
    protected array $allowedFields = ['name', 'parent_id'];

    public function __construct()
    {
        parent::__construct('Category');
    }

    public function create(array $categoryData): Category
    {
        $categoryData = $this->filterData($categoryData);

        return Category::create($categoryData);
    }

    public function get(array $conditions): ?Category
    {
        return Category::where($conditions)->first();
    }
}
