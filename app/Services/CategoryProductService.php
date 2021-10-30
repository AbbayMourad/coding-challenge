<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CategoryProductRepository;

class CategoryProductService
{
    private CategoryProductRepository $categoryProductRepository;

    public function __construct(CategoryProductRepository $categoryProductRepository)
    {
        $this->categoryProductRepository = $categoryProductRepository;
    }

    public function join(Product $product, array $categoriesIds)
    {
        $this->categoryProductRepository->createMany($product, $categoriesIds);
    }
}
