<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnderecoController extends Controller {

    public function show()
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        if(!$user) return response()->json(['data' => 'Usuário não autorizado', 'error' => true], status: 401);

        $enderecos = Endereco::where("USUARIO_ID", "=", $user->USUARIO_ID)->where("ENDERECO_APAGADO", "=", 0)->get();
        return response()->json($enderecos, 200);
    }

    public function store(Request $request)
    {
        $usuarioController = new UsuarioController();
        $user = $usuarioController->getUserInfo();

        $endereco = new Endereco([
            'USUARIO_ID' => $user->USUARIO_ID,
            'ENDERECO_NOME' => $request->name,
            'ENDERECO_CEP' => $request->cep,
            'ENDERECO_CIDADE' => $request->city,
            'ENDERECO_ESTADO' => $request->state,
            'ENDERECO_NUMERO' => $request->number,
            'ENDERECO_LOGRADOURO' => $request->address,
            'ENDERECO_COMPLEMENTO' => $request->complement
        ]);

        if ($endereco->save()) {
            return response()->json([
                'data' => 'Endereço cadastrado com sucesso!',
                'error' => false
            ], 201);
        } else {
            return response()->json([
                'data' => 'Erro ao criar usuário.',
                'error' => true
            ], 400);
        }
    }

    function update(Request $request){
        if(JWTAuth::parseToken()->authenticate()->USUARIO_ID != $request->userId){
            return response()->json(['data' => 'Usuário não autorizado', 'error' => true], 401);
        }

        Endereco::where('ENDERECO_ID', '=',$request->id)->update([
            'ENDERECO_NOME' => $request->name,
            'ENDERECO_CEP' => $request->cep,
            'ENDERECO_CIDADE' => $request->city,
            'ENDERECO_ESTADO' => $request->state,
            'ENDERECO_NUMERO' => $request->number,
            'ENDERECO_LOGRADOURO' => $request->address,
            'ENDERECO_COMPLEMENTO' => $request->complement
        ]);

        return response()->json(['data' => 'Endereço atualizado com sucesso'], 200);
    }


    public function destroy($id){
        $endereco = Endereco::find($id);
        
        if(JWTAuth::parseToken()->authenticate()->USUARIO_ID != $endereco->USUARIO_ID){
            return response()->json(['data' => 'Usuário não autorizado', 'error' => true], 401);
        }

        Endereco::where('ENDERECO_ID', '=',$id)->update([
           "ENDERECO_APAGADO" => 1
        ]);

        return response()->json(['data' => 'Endereço deletado com sucesso', 'error' => false], 200);
    }

}