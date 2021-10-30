<?php

namespace App\Validators;

use Illuminate\Validation\Factory;

class CategoryValidator
{
    private Factory $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $data) {
        $this->validator->validate($data, $this->rules());
    }

    private function rules(): array
    {
        return [
            'name' => 'required|max:50|regex:/^[a-z ]*$/i|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}
