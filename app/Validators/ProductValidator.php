<?php

namespace App\Validators;

use App\Utils\FileCreator;
use Illuminate\Validation\Factory;

class ProductValidator
{
    private Factory $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    private function preValidation(array &$data)
    {
        $data['base64Image'] = $data['image'];
        $data['image'] = FileCreator::fromBase64($data['image'] ?? '');
    }

    private function postValidation(array &$data)
    {
        $data['image'] = $data['base64Image'];
        unset($data['base64Image']);
    }

    public function validate(array $data) {
        $this->preValidation($data);

        $this->validator->validate($data, $this->rules());

        $this->postValidation($data);
    }

    private function rules(): array {
        return [
            'name' => 'required|max:50|regex:/^[a-z0-9- ]*$/i',
            'description' => 'nullable|max:255|regex:/^[a-z0-9-\' ]*$/i',
            'price' => 'required|numeric|min:0',
            'image' => 'required|file|image|max:1024',
            'categories_ids' => 'nullable|array|exists:categories,id'
        ];
    }
}
