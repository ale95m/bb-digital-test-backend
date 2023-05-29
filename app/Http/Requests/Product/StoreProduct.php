<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'sku' => 'string|required|unique:products,sku',
            'name' => 'string|required',
            'description' => 'string|required',
            'additional_information' => 'string|nullable',
            'price' => 'numeric|required',
            'category_id' => 'integer|required|exists:categories,id',
            'images' => 'array',
            'images.url' => 'active_url|required_with:images',
            'tags' => 'array',
            'tags.id' => 'integer|required_with:tags|exists:tags,id'
        ];
    }
}
