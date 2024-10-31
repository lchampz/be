<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public static function login(Request $request) 
{
    $user = Usuario::where('USUARIO_EMAIL', $request->email)->first();
    if (!$user) {
        return response()->json(['data' => 'Usuário não encontrado.'], 401);
    }

    if (Hash::check($request->pass, $user->USUARIO_SENHA)) {

        $customClaims = [
            'email' => $user->USUARIO_EMAIL,
            'name' => $user->USUARIO_NOME 
        ];

        
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json(['token' => $token, 'data' => 'Login feito com sucesso.'], 200);
    } else {
        return response()->json(['data' => 'Senha ou Email incorretos.'], 401);
    }
}
}