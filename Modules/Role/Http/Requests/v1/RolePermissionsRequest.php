<?php

namespace Modules\Role\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'exists:roles,id'],
            'permissions' => ['required', 'array'],
            'permissions.*.id' => ['required', 'exists:permissions,id'],
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
