<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService extends Service
{

    public function __construct(ProductRepository $productRepository) {
        parent::__construct($productRepository);
    }

    public function create(array $data, array $models = []) {
        $product = new Product($data['product']);
        return $this->repository->create(['product' => $product, 'categories' => $models['categories']]);
    }
}
