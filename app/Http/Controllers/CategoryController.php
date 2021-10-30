<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request): CategoryResource
    {
        $categoryData = $request->input("category");
        $category = $this->categoryService->create($categoryData);

        return new CategoryResource($category);
    }

    public function destroy(Request $request): int
    {
        $id = $request->route('category');

        return $this->categoryService->delete($id);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = $this->categoryService->getMany();

        return CategoryResource::collection($categories);
    }
}
