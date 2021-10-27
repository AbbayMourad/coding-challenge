<?php

namespace App\Console\Commands;

use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use App\Traits\CommandLogger;
use App\Utils\FileCreator;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CreateProduct extends Command
{
    use CommandLogger;

    protected $signature = 'product:create';

    protected $description = 'Create a product';

    private array $loggableFields = ['id', 'name', 'price', 'description'];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ProductService $productService)
    {
        $productData = $this->getProductData();
        $categoriesNames = $this->getCategoriesNames();
        $productImage = $this->getProductImage($productData['image-path']);
        if (!$productImage) {
            $this->error('image not found');
            return -1;
        }
        $productData['image'] = $productImage;

        $data = ['product' => $productData, 'categories' => $categoriesNames];
        $validator = Validator::make($data, StoreProductRequest::rules());
        if ($validator->fails()) {
            $this->logErrors('error creating product', $validator->errors()->all());
            return -1;
        }
        $productData['image'] = base64_encode($productImage->getContent());

        $product = $productService->create($productData, $categoriesNames);
        $this->info("product successfully created");
        $this->logModel($product);
        return 0;
    }

    private function getProductData() {
        $productData = [];
        $productData['name'] = $this->ask('product name');
        $productData['price'] = $this->ask('product price');
        $productData['image-path'] = $this->ask('product image path');
        $productData['description'] = $this->ask('product description (optional)');
        return $productData;
    }

    private function getCategoriesNames() {
        $categoriesNames = $this->ask('product categories (category1,category2,....)') ?? '';
        return preg_split("/,\s*/", $categoriesNames, -1, PREG_SPLIT_NO_EMPTY);
    }

    private function getProductImage($imagePath): ?UploadedFile
    {
        $local = Storage::disk('local');
        if (!$local->exists($imagePath))    return null;
        return FileCreator::fromString($local->get($imagePath));
    }
}
