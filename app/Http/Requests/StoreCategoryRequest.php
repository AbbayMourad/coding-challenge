<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public static function rules(): array
    {
        return [
            'categories' => 'array',
            'categories.*.name' => 'required|max:50|regex:/^[a-z ]*$/i',
            'categories.*.parent' => 'nullable|max:50|regex:/^[a-z ]*$/i'
        ];
    }
}
