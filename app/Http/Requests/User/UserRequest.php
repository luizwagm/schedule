<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        ];
    }
}
