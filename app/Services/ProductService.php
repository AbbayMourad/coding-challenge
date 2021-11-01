<?php

namespace App\Services;

use App\Exceptions\CategoryNotFoundException;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService extends Service
{
    private ProductValidator $productValidator;

    private ProductRepository $productRepository;

    private CategoryProductService $categoryProductService;

    private CategoryService $categoryService;

    public function __construct(
        ProductValidator $productValidator,
        ProductRepository $productRepository,
        CategoryProductService $categoryProductService,
        CategoryService $categoryService
    ) {
        parent::__construct($productRepository);
        $this->productValidator = $productValidator;
        $this->productRepository = $productRepository;
        $this->categoryProductService = $categoryProductService;
        $this->categoryService = $categoryService;
    }

    public function create(array $productData): Product
    {
        $this->productValidator->validate($productData);
        $product = $this->productRepository->create($productData);

        $categoriesIds = $productData['categories_ids'];
        $this->categoryProductService->join($product, $categoriesIds);

        return $product;
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function getManyByCategory(?string $categoryName, array $sortOptions): LengthAwarePaginator
    {
        if (!$categoryName) {
            return $this->productRepository->getMany([], $sortOptions);
        }
        $category = $this->categoryService->get(['name' => $categoryName]);
        if (!$category) {
            throw new CategoryNotFoundException('category not found');
        }

        return $this->productRepository->getManyByCategory($category, $sortOptions);
    }
}
