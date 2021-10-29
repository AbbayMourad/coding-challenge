<?php

namespace App\Console\Commands;

use App\Services\CategoryService;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    protected $signature = 'category:delete {id}';

    protected $description = 'Delete a category';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CategoryService $categoryService)
    {
        $id = $this->argument("id");
        $categoryService->delete($id);
        $this->info("category deleted successfully");

        return 0;
    }
}
