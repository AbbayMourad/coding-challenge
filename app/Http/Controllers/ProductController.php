<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function store(Request $request, CategoryController $categoryController) {
        // convert product image from base64 to file
        $product = $request->input('product');
        $product['image'] = $this->base64ToFile($product['image'] ?? '');
        $request->merge(['product' => $product]);

        // validate
        $request->validate($this->rules());

        // handle categories creation if needed
        $categoriesNames = $request->input("categories", []);
        $categories = $this->toCategories($categoriesNames);
        $request->merge(['categories' => $categories]);
        $categories = $categoryController->store($request);

        //create product
        $input = $request->input();
        $product = $this->productService->create(['product' => $input['product']], ['categories' => $categories]);
        return new ProductResource($product);
    }

    public function destroy(Request $request) {
        $id = $request->route('product');
        return $this->productService->delete(['id' => $id]);
    }

    public function index(Request $request) {
        $query = $request->query();
        $conditions = [];
        if (isset($query['category'])) $conditions['category'] = $query['category'];
        $products = $this->productService->getMany($conditions, $query);
        return ProductResource::collection($products);
    }

    private function rules(): array {
        return [
            'product.name' => 'required|max:50|regex:/^[a-z0-9- ]*$/i',
            'product.description' => 'nullable|max:255|regex:/^[a-z0-9-\' ]*$/i',
            'product.price' => 'required|numeric|min:0',
            'product.image' => 'required|file|image|max:1024', // 1MB
            'categories' => 'nullable|array'
        ];
    }

    private function toCategories(array $categoriesNames): array
    {
        $result = [];
        foreach ($categoriesNames as $categoryName) {
            array_push($result, ['name' => $categoryName]);
        }
        return $result;
    }

    private function base64ToFile($base64): UploadedFile
    {
        // decode the base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        return new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );
    }
}
