<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    private function create(array $categoryData)
    {
        $category = $this->categoryRepository->get(['name' => $categoryData['name']]);
        if ($category) return $category;

        $parentCategory = null;
        if (isset($categoryData['parent'])) {
            $parentCategory = $this->categoryRepository
                ->getOrCreate(['name' => $categoryData['parent']], ['name' => $categoryData['parent']]);
        }
        return $this->categoryRepository->create($categoryData, $parentCategory);
    }

    public function createMany(array $categoriesData)
    {
        Validator::make(['categories' => $categoriesData], (new StoreCategoryRequest())->rules())->validate();

        $categoriesModels = [];
        foreach ($categoriesData as $categoryData) {
            $category = $this->create($categoryData);
            array_push($categoriesModels, $category);
        }
        return collect($categoriesModels);
    }

    public function getMany(array $conditions = []) {
        return $this->categoryRepository->getMany($conditions);
    }

    public function delete($id) {
        return $this->categoryRepository->delete($id);
    }
}
