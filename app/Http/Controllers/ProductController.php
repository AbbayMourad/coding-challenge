<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function store(StoreProductRequest $request, CategoryController $categoryController) {
        // handle categories creation if needed
        $categoriesNames = $request->input("categories", []);
        $categories = $this->toCategories($categoriesNames);
        $request->merge(['categories' => $categories]);
        $categories = $categoryController->store($request);

        //create product
        $input = $request->input();
        $product = $this->productService->create(['product' => $input['product']], ['categories' => $categories]);
        return new ProductResource($product);
    }

    public function destroy(Request $request) {
        $id = $request->route('product');
        return $this->productService->delete(['id' => $id]);
    }

    public function index(Request $request) {
        $query = $request->query();
        $conditions = [];
        if (isset($query['category'])) $conditions['category'] = $query['category'];
        $products = $this->productService->getMany($conditions, $query);
        return ProductResource::collection($products);
    }

    private function toCategories(array $categoriesNames): array
    {
        $result = [];
        foreach ($categoriesNames as $categoryName) {
            array_push($result, ['name' => $categoryName]);
        }
        return $result;
    }
}
