<?php

namespace Modules\Product\Http\Requests\v1\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'image' => ['sometimes', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
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
