<?php

namespace App\Http\Requests;

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
        $user = $this->route('user');
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . ($user ? $user->id : 'null'),
            'role' => 'required|string|in:super-admin,admin,user',
            'password' => 'required_if:password,!=,null|string|min:8|confirmed',
        ];
    }
    public function messages(): array{
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'role.required' => 'O papel é obrigatório.',
            'role.in' => 'O papel deve ser um dos seguintes: super-admin, admin, user.',
            'password.required_if' => 'A password é obrigatória.',
            'password.min' => 'A password deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'As passwords não coincidem.',
        ];
    }
}
