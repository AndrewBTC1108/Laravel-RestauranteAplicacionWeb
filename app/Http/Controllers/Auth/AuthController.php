<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistroRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    //
    public function register(RegistroRequest $request)
    {
        //Validar el registro
        $data = $request->validated();

        //crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']) //hashear password
        ]);

        // Envía el correo de verificación
        event(new Registered($user));

        //retornar una respuesta
        return [
            'token' => $user->createToken('token')->plainTextToken, //crear token para personal_acces_token
            'user' => $user
        ];
    }
    public function login(LoginRequest $request)
    {
        //validar
        $data = $request->validated();

        // Intentar autenticar si el correo electrónico está verificado
        if (!Auth::attempt($data)) {
            return response([
                'errors' => ['email' => ['El email o la contraseña son incorrectos']]
            ], 422);
        }
        //Autenticar al usuario
        //retornar una respuesta
        $user = Auth::user();

        return [
            'token' => $user->createToken('token')->plainTextToken, //crear token para personal_acces_token
            'user' => $user
        ];

    }

    public function logout(Request $request)
    {
        //identificar que usuario esta haciendo el request
        $user = $request->user();
        //remover el token
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
