<?php

namespace Modules\Admin\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:190', 'unique:admins'],
            'password' => ['required', 'string'],
            'name' => ['required', 'string', 'max:190'],
            'role_id' => ['nullable', 'exists:roles,id'],
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
