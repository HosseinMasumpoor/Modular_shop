<?php

namespace Modules\Product\Http\Requests\v1\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'alt' => ['nullable', 'string', 'max:170'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
