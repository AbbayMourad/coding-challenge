<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService extends Service
{

    public function __construct(CategoryRepository $categoryRepository) {
        parent::__construct($categoryRepository);
    }

    public function createMany(array $data): array
    {
        $categories = [];
        foreach ($data as $value) {
            $category = $this->create($value);
            array_push($categories, $category);
        }
        return $categories;
    }

    public function create(array $data, array $models = [])
    {
        $category = $this->repository->get(['name' => $data['name']]);
        if ($category) return $category;

        if (isset($data['parent'])) {
            $models['parent'] = $this->repository->getOrCreate([ 'name' => $data['parent'] ]);
        }
        $models['category'] = new Category(['name' => $data['name']]);
        return $this->repository->create($models);
    }
}
