<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;//debe ser true para poder usar
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'email' => ['required', 'email', 'exists:users,email'], //va a buscar en la tabla de usuarios si ese email existe
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El Email es Obligatorio',
            'email.email' => 'El email no es valido',
            'email.exists' => 'La cuenta no existe',
            'password' => 'El password es obligatorio'
        ];
    }
}
