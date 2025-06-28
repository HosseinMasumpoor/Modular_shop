<?php

namespace Modules\Product\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:190',
            'slug' => 'nullable|string|unique:brands,slug',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:190',
            'meta_description' => 'nullable|string|max:400',
            'meta_keywords' => 'nullable|string|max:400',
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
