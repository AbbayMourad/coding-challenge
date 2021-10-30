<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CategoryProductRepository;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    private ProductValidator $productValidator;

    private ProductRepository $productRepository;

    private CategoryProductService $categoryProductService;

    public function __construct(
        ProductValidator $productValidator,
        ProductRepository $productRepository,
        CategoryProductService $categoryProductService
    ) {
        $this->productValidator = $productValidator;
        $this->productRepository = $productRepository;
        $this->categoryProductService = $categoryProductService;
    }

    public function create(array $productData)
    {
        $this->productValidator->validate($productData);
        $product = $this->productRepository->create($productData);

        $categoriesIds = $productData['categories_ids'];
        $this->categoryProductService->join($product, $categoriesIds);

        return $product;
    }

    public function getManyByCategory(?string $categoryName, array $sortOptions)
    {
        if (!$categoryName) {
            return $this->productRepository->getMany([], $sortOptions);
        }

        return $this->productRepository->getManyByCategory($categoryName, $sortOptions);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
}
