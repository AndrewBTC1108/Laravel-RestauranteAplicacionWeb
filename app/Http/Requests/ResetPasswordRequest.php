<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRules::min(8)->letters()->symbols()->numbers()],
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'no hay un token',
            'email.required' => 'El Email es Obligatorio',
            'email.email' => 'El email no es valido',
            'password' => 'El password debe contener almenos 8 caracteres, un simbolo y un numero'
        ];
    }
}
