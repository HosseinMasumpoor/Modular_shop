<?php

namespace Modules\Category\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes','min:2', 'max:150'],
            'slug' => ['nullable', 'min:2', 'max:190', 'unique:categories,slug,' . $this->id],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'meta_title' => ['nullable', 'string', 'max:150'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keyword' => ['nullable', 'string', 'max:500'],
        ];
    }
}
