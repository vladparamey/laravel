<?php

namespace App\Http\Requests\Auth\Admin;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class AdminRegisterRequest extends RegisterRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $parentRules = parent::rules();

        $rules = [
            'email' => 'required|string|email|unique:admins,email|unique:users,email',
        ];

        return array_merge($parentRules, $rules);
    }
}
