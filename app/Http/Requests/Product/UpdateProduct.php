<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'description' => 'string',
            'additional_information' => 'string|nullable',
            'price' => 'numeric',
            'category_id' => 'integer|exists:categories,id',
            'tags' => 'array',
            'tags.id' => 'integer|required_with:tags|exists:tags,id'
        ];
    }
}
