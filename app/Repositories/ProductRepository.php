<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository extends Repository
{
    private string $table = 'products';

    protected array $allowedFields = ['name', 'description', 'price', 'image'];

    protected array $sortableFields = ['name', 'price'];

    private int $perPage = 5;

    public function create(array $productData, Collection $categories)
    {
        $productData = $this->filterData($productData);
        $id = DB::table($this->table)->insertGetId($productData);

        $association = [];
        foreach ($categories as $category) {
            array_push($association, ['category_id' => $category->id, 'product_id' => $id]);
        }
        DB::table('category_product')->insert($association);

        return $this->get(['id' => $id]);
    }

    public function get(array $conditions) {
        return DB::table($this->table)->where($conditions)->first();
    }

    public function getMany($categoryName, array $sortOptions)
    {
        $query = DB::table($this->table);
        if ($categoryName) {
            $query
                ->join('category_product', 'products.id', '=', 'product_id')
                ->join('categories', 'categories.id', '=', 'category_id')
                ->where('categories.name', '=', $categoryName);
        }
        $sortOptions = $this->filterSortOptions($sortOptions);
        foreach ($sortOptions as $field => $order)   $query->orderBy($field, $order);
        return $query->get('products.*');
    }

    public function delete($id) {
        return DB::table($this->table)->delete(['id' => $id]);
    }
}
