<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(Request $request): ProductResource
    {
        $productData = $request->input('product', []);
        $product = $this->productService->create($productData);

        return new ProductResource($product);
    }

    public function destroy(Request $request): int
    {
        $id = $request->route('product');

        return $this->productService->delete($id);
    }

    public function index(Request $request)
    {
        $categoryName = $request->query('category');
        $sortOptions = $request->query('sort', []);
        return $products = $this->productService->getManyByCategory($categoryName, $sortOptions);

//        return ProductResource::collection($products);
    }
}
