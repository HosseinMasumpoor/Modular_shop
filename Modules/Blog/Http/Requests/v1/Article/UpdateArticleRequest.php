<?php

namespace Modules\Blog\Http\Requests\v1\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:190'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'slug' => ['nullable', 'unique:articles,slug', 'max:190'],
            'category_id' => ['sometimes', 'exists:article_categories,id'],
            'image' => ['sometimes', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1024'],
            'read_time' => ['nullable', 'numeric', 'min:0', 'max:10000'],
            'alt' => ['nullable', 'string', 'max:190'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_keyword' => ['nullable', 'string', 'max:190'],

            'sections' => ['sometimes', "array"],
            'sections.*.title' => ['sometimes', 'string', 'max:190'],
            'sections.*.body' => ['sometimes', 'string'],
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
