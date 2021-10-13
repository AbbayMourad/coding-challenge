<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRepository extends Repository
{
    public function __construct()
    {
        parent::__construct('Category');
    }

    public function create(array $models)
    {
        $category = $models['category'];
        $parent = $models['parent'] ?? null;
        $category->parent()->associate($parent);
        $category->save();
        return $category;
    }
}
