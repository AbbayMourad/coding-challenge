<?php

namespace App\Http\Requests;

use App\Utils\FileCreator;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $product = $this->input('product');
        $product['base64Image'] = $product['image'];
        $product['image'] = FileCreator::fromBase64($product['image'] ?? '');
        $this->merge(['product' => $product]);
    }

    protected function passedValidation()
    {
        $product = $this->input('product');
        $product['image'] = $product['base64Image'];
        unset($product['base64Image']);
        $this->merge(['product' => $product]);
    }

    public static function rules(): array
    {
        return [
            'product.name' => 'required|max:50|regex:/^[a-z0-9- ]*$/i',
            'product.description' => 'nullable|max:255|regex:/^[a-z0-9-\' ]*$/i',
            'product.price' => 'required|numeric|min:0',
            'product.image' => 'required|file|image|max:1024', // 1MB
            'categories' => 'nullable|array'
        ];
    }
}
