<?php

namespace App\Console\Commands;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\CommandLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateCategory extends Command
{
    use CommandLogger;

    protected $signature = 'category:create {name} {parent?}';

    protected $description = 'Create a category';

    private array $loggableFields = ['id', 'name'];


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CategoryService $categoryService)
    {
        $categoryData = $this->argument();
        $validator = Validator::make(['categories' => [$categoryData]], StoreCategoryRequest::rules());
        if ($validator->fails())
        {
            $this->logErrors("error creating category: data not valid", $validator->errors()->all());
            return -1;
        }

        $category = $categoryService->create($categoryData);

        $this->info("category successfully created");
        $this->logModel($category);
        return 0;
    }
}
