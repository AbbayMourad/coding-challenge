<?php

namespace App\Console\Commands;

use App\Services\CategoryService;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    protected $signature = 'category:delete {id}';

    protected $description = 'Delete a category';

    public function handle(CategoryService $categoryService): int
    {
        $id = $this->argument("id");
        $result = $categoryService->delete($id);
        $this->info($result['deleted_count']." category has been deleted");

        return 0;
    }
}
