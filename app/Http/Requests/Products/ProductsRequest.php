<?php

namespace App\Http\Requests\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255', 'min:3'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'article_id' => ['required', 'integer', 'exists:articles,id'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'bought_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
