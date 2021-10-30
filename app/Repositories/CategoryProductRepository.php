<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryProductRepository extends Repository
{
    private string $table = 'category_product';

    public function __construct()
    {
        parent::__construct(null);
    }

    public function createMany(Product $product, array $categoriesIds)
    {
        $product->categories()->attach($categoriesIds);
    }

}
