<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends Repository
{
    protected array $allowedFields = ['name', 'description', 'price', 'image'];

    protected array $sortableFields = ['name', 'price'];

    protected int $perPage = 5;

    public function __construct()
    {
        parent::__construct('Product');
    }

    public function create(array $productData): Product
    {
        $productData = $this->filterData($productData);

        return Product::create($productData);
    }

    public function getManyByCategory(Category $category, array $sortOptions): LengthAwarePaginator
    {
        $products = $category->products();
        $sortOptions = $this->filterSortOptions($sortOptions);
        $this->orderBy($products, $sortOptions);

        return $products->paginate($this->perPage);
    }
}
