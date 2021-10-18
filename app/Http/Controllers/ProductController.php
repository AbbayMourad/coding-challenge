<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function store(Request $request, CategoryController $categoryController) {
        // validate
        $request->validate($this->rules());

        // handle categories creation if needed
        $categoriesNames = $request->input("categories", []);
        $categories = $this->toCategories($categoriesNames);
        $request->merge(['categories' => $categories]);
        $categories = $categoryController->store($request);

        //create product
        $input = $request->input();
        $product = $this->productService->create(['product' => $input['product']], ['categories' => $categories]);
        return response($product);
    }

    public function destroy(Request $request) {
        $id = $request->route('product');
        return $this->productService->delete(['id' => $id]);
    }

    public function index(Request $request) {
        $query = $request->query();
        $conditions = [];
        if (isset($query['category'])) $conditions['category'] = $query['category'];
        return $this->productService->getMany($conditions, $query);
    }

    private function rules(): array {
        return [
            'product.name' => 'required|max:50|regex:/^[a-z0-9- ]*$/i',
            'product.description' => 'nullable|max:255|regex:/^[a-z0-9-\' ]*$/i',
            'product.price' => 'required|numeric|min:0',
            'categories' => 'nullable|array'
        ];
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
