<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request)
    {
        $categoriesData = $request->input("categories");
        return $categories = $this->categoryService->createMany($categoriesData);
//        return CategoryResource::collection($categories);
    }

    public function destroy(Request $request)
    {
        $id = $request->route('category');
        return $this->categoryService->delete($id);
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getMany();
        return CategoryResource::collection($categories);
    }
}
