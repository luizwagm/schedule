<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => 'required|min:10',
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')->whereNull('deleted_at')
            ],
            'password' => 'required|min:6',
        ];
    }
}
