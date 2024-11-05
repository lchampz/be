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

    function update(Request $request){
        if(JWTAuth::parseToken()->authenticate()->USUARIO_ID != $request->id){
            return response()->json(['data' => 'Usuário não autorizado', 'error' => true], 401);
        }

        Usuario::where('USUARIO_ID', '=',$request->id)->update([
            'USUARIO_NOME' => $request->name,
            'USUARIO_EMAIL' => $request->email,
            'USUARIO_CPF' => $request->cpf,
            'USUARIO_SENHA' => $request->pass,
        ]);

        return response()->json(['data' => 'Usuário atualizado com sucesso', 'error' => false], 200);
    }
}