<?php

namespace Modules\Admin\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => ['sometimes', 'string', 'max:190', 'unique:admins,id,' . $this->id],
            'password' => ['sometimes', 'string'],
            'name' => ['sometimes', 'string', 'max:190'],
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
