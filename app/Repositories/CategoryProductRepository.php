<?php

namespace App\Repositories;

use App\Models\Product;

class CategoryProductRepository
{
    public function createMany(Product $product, array $categoriesIds)
    {
        $product->categories()->attach($categoriesIds);
    }

}
