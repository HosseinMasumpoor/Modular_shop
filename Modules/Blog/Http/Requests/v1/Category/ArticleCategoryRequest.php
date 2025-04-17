<?php

namespace Modules\Blog\Http\Requests\V1\Category;

use Illuminate\Foundation\Http\FormRequest;

class ArticleCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:190'],
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
