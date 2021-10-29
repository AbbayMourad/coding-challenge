<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    private ProductValidator $productValidator;

    private ProductRepository $productRepository;

    private CategoryService $categoryService;

    public function __construct(
        ProductValidator $productValidator,
        ProductRepository $productRepository,
        CategoryService $categoryService
    ) {
        $this->productValidator = $productValidator;
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
    }

    public function create(array $productData, array $categoriesNames)
    {
        $this->productValidator->validate($productData);

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
