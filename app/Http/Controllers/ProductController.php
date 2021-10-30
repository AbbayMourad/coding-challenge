<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
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

    public function store(Request $request)
    {
        $input = $request->input();
        $productData = $input['product'];
        $product = $this->productService->create($productData);

        return new ProductResource($product);
    }

    public function destroy(Request $request)
    {
        $id = $request->route('product');

        return $this->productService->delete($id);
    }

    public function index(Request $request)
    {
        $query = $request->query();
        $categoryName = $query['category'] ?? null;
        $sortOptions = $query['sort'] ?? [];
        return $products = $this->productService->getManyByCategory($categoryName, $sortOptions);

//        return ProductResource::collection($products);
    }
}
