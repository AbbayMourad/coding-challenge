<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    protected $signature = 'product:delete {id}';

    protected $description = 'Delete a product';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ProductService $productService): int
    {
        $id = $this->argument('id');
        $result = $productService->delete($id);
        $this->info($result['deleted_count']." product has been deleted");

        return 0;
    }
}
