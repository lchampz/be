<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Usuario::where('USUARIO_EMAIL', $request->email)->first();

        

        if (!$user) {
            return response()->json(['error' => true,'data' => 'Usuário não encontrado.'], 401);
        }

        if (Hash::check($request->pass, $user->USUARIO_SENHA)) {

            $token = JWTAuth::fromUser($user);
            return response()->json(['error' => false,'token' => $token, 'data' => 'Login feito com sucesso.'], 200);
        } else {
            return response()->json(['error' => true,'data' => 'Senha ou Email incorretos.'], 401);
        }
    }

    public function verifyToken(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['error' => true,'data' => 'Usuário não encontrado'], status: 401);
        }

        return response()->json(compact('user'));


    }
}