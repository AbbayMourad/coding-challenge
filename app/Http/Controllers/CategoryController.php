<?php

namespace App\Http\Controllers;

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
        return $this->categoryService->createMany($categoriesData);
    }

    private function rules(): array
    {
        return [
            'categories.*.name' => 'required|max:50|regex:/^[a-z ]*$/i',
            'categories.*.parent' => 'nullable|max:50|regex:/^[a-z ]*$/i'
        ];
    }
}
