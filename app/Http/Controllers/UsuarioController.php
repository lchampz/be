<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioController extends Controller
{
    public function register(Request $request)
    {
        $user = new Usuario();

        if (Usuario::where('USUARIO_EMAIL', $request->email)->exists()) {
            return response()->json([
                'data' => 'E-mail já cadastrado!',
                'error' => true
            ], 400);
        }

        if (Usuario::where('USUARIO_CPF', $request->cpf)->exists()) {
            return response()->json([
                'data' => 'CPF já cadastrado!',
                'error' => true
            ], 400);
        }

        $user->USUARIO_NOME = $request->name;
        $user->USUARIO_EMAIL = $request->email;
        $user->USUARIO_SENHA = Hash::make($request->pass);
        $user->USUARIO_CPF = $request->cpf;

        if ($user->save()) {
            return response()->json([
                'data' => 'Usuário cadastrado com sucesso!',
                'error' => true
            ], 201);
        } else {
            return response()->json([
                'data' => 'Erro ao criar usuário.',
                'error' => true
            ], 400);
        }
    }

    public function info(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json(["user" => $user]);
    }
}