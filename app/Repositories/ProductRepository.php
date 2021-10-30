<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends Repository
{
    protected array $allowedFields = ['name', 'description', 'price', 'image'];

    protected array $sortableFields = ['name', 'price'];

    protected int $perPage = 5;

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct('Product');
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $productData): Product
    {
        $productData = $this->filterData($productData);

        return Product::create($productData);
    }

    public function get(array $conditions): ?Product
    {
        return Product::where($conditions)->first();
    }

    public function getManyByCategory(string $categoryName, array $sortOptions): ?LengthAwarePaginator
    {
        $category = $this->categoryRepository->get(['name' => $categoryName]);
        if (!$category) {
            return null;
        }
        $products = $category->products();
        $sortOptions = $this->filterSortOptions($sortOptions);
        $this->orderBy($products, $sortOptions);

        return $products->paginate($this->perPage);
    }
}
