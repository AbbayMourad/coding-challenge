<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    private ProductRepository $productRepository;

    private CategoryService $categoryService;

    public function __construct(ProductRepository $productRepository, CategoryService $categoryService)
    {
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
    }

    public function create(array $productData, array $categoriesNames)
    {
        $categoriesData = array_map(function ($name) { return ['name' => $name]; }, $categoriesNames);
        $categories = $this->categoryService->createMany($categoriesData);

        return $this->productRepository->create($productData, $categories);
    }

    public function getMany($categoryName, array $sortOptions)
    {
        return $this->productRepository->getMany($categoryName, $sortOptions);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
}
