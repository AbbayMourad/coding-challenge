<?php

namespace App\Repositories;


use App\Models\Category;
use App\Models\Product;

class ProductRepository extends Repository
{
    public function __construct() {
        parent::__construct('Product');
    }

    public function create(array $models) {
        $product = $models['product'];
        $product->save();

        $categories = $models['categories'];
        foreach ($categories as $category)  $product->categories()->attach($category->id);
        return $product;
    }

    public function getMany(array $conditions, array $options) {
        if (isset($conditions['category'])) {
            $query = Category::where('name', $conditions['category'])->firstOrFail()->products();
        } else {
            $query = Product::where($conditions);
        }
        // filter sort options
        $orderBys = $this->filterSortOptions($options);
        foreach ($orderBys as $field => $order) {
            $query->orderBy($field, $order);
        }
        return $query->get();
    }



}
