<?php

namespace App\Console\Commands;

use App\Services\CategoryService;
use App\Traits\CommandLogger;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class CreateCategory extends Command
{
    use CommandLogger;

    protected $signature = 'category:create {name} {parent_id?}';

    protected $description = 'Create a category';

    private array $loggableFields = ['id', 'name'];

    public function handle(CategoryService $categoryService): int
    {
        $categoryData = $this->argument();
        try {
            $category = $categoryService->create($categoryData);
            $this->info("category successfully created");
            $this->logModel($category);

            return 0;
        } catch (ValidationException $e) {
            $this->logErrors("error creating category: data not valid", $e->errors());

            return -1;
        }
    }
}
