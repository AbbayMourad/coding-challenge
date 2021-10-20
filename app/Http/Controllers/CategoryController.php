<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request) {
        $request->validate($this->rules());
        $categoriesData = $request->input("categories");
        $categories = $this->categoryService->createMany($categoriesData);
        return CategoryResource::collection($categories);
    }

    public function destroy(Request $request) {
        $id = $request->route('category');
        return $this->categoryService->delete([ 'id' => $id ]);
    }

    public function index(Request $request) {
        $categories = $this->categoryService->getMany();
        return CategoryResource::collection($categories);
    }

    private function rules(): array
    {
        return [
            'categories.*.name' => 'required|max:50|regex:/^[a-z ]*$/i',
            'categories.*.parent' => 'nullable|max:50|regex:/^[a-z ]*$/i'
        ];
    }
}
