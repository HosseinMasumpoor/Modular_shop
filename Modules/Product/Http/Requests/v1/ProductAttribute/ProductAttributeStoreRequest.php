<?php

namespace Modules\Product\Http\Requests\v1\ProductAttribute;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'name' => ['required', 'string', 'min:2', 'max:170'],
            'value' => ['required', 'string', 'min:2', 'max:1000'],
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
