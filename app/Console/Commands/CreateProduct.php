<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use App\Traits\CommandLogger;
use App\Utils\FileCreator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CreateProduct extends Command
{
    use CommandLogger;

    protected $signature = 'product:create';

    protected $description = 'Create a product';

    private array $loggableFields = ['id', 'name', 'price', 'description'];

    public function handle(ProductService $productService): int
    {
        $productData = $this->getProductData();

        $productImage = $this->getProductImage($productData['image-path']);
        if (!$productImage) {
            $this->error('image not found');

            return -1;
        }
        $productData['image'] = base64_encode($productImage->getContent());

        try {
            $product = $productService->create($productData);
            $this->info("product successfully created");
            $this->logModel($product);

            return 0;
        } catch (ValidationException $e) {
            $this->logErrors('error creating product', $e->errors());

            return -1;
        }
    }

    private function getProductData(): array
    {
        $productData = [];
        $productData['name'] = $this->ask('product name');
        $productData['price'] = $this->ask('product price');
        $productData['image-path'] = $this->ask('product image path (relative to /home/mourad)');
        $productData['description'] = $this->ask('product description (optional)');
        $productData['categories_ids'] = $this->getCategoriesIds();

        return $productData;
    }

    private function getCategoriesIds(): array
    {
        $categoriesIds = $this->ask('product categories ids (id1,id2,....)') ?? '';

        return preg_split("#,\s*#", $categoriesIds, -1, PREG_SPLIT_NO_EMPTY);
    }


    private function getProductImage(?string $imagePath): ?UploadedFile
    {
        $local = Storage::disk('local');
        try {
            $fileData = $local->get($imagePath);

            return FileCreator::fromString($fileData);
        } catch (FileNotFoundException $e) {
            return null;
        }
    }
}
