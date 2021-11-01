<?php

namespace App\Http\Controllers;

use App\Exceptions\CategoryNotFoundException;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): ProductResource
    {
        $productData = $request->input('product', []);
        $product = $this->productService->create($productData);

        return new ProductResource($product);
    }

    public function destroy(Request $request): array
    {
        $id = $request->route('product');

        return $this->productService->delete($id);
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function index(Request $request)
    {
        $categoryName = $request->query('category');
        $sortOptions = $request->query('sort', []);
        $products = $this->productService->getManyByCategory($categoryName, $sortOptions);
        if ($products->isEmpty()) {
            return response()->json(['message' => 'no product found'], 404);
        }

        return ProductResource::collection($products);
    }
}
