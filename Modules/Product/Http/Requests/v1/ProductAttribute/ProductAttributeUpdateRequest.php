<?php

namespace Modules\Product\Http\Requests\v1\ProductAttribute;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:2', 'max:170'],
            'value' => ['sometimes', 'string', 'min:2', 'max:1000'],
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
