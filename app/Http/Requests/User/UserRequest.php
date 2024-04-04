<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'fullname' => 'required|min:10',
            'document_type' => 'required|in:cpf,cnpj',
            'cpf' => 'required_if:document_type,cpf|unique:users,document|cpf',
            'cnpj' => 'required_if:document_type,cnpj|unique:users,document|cnpj',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'phone' => 'required',
            'user_type' => 'required|in:seller,buyer,engineer',
            'company_name' => 'required_if:document_type,cnpj',
            'state_registration' => 'required_if:document_type,cnpj',
        ];
    }
}
