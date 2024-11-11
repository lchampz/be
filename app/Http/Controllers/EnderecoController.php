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

        if(JWTAuth::parseToken()->authenticate()->USUARIO_ID != $request->usuario_id){
            return response()->json(['message' => 'Usuário não autorizado'], 401);
        }

        $endereco = new Endereco([
            'USUARIO_ID' => $request->user,
            'ENDERECO_NOME' => $request->nome,
            'ENDERECO_CEP' => $request->cep,
            'ENDERECO_CIDADE' => $request->cidade,
            'ENDERECO_ESTADO' => $request->estado,
            'ENDERECO_NUMERO' => $request->numero,
            'ENDERECO_LOGRADOURO' => $request->logradouro,
            'ENDERECO_COMPLEMENTO' => $request->complemento
        ]);

        $endereco->save();

        return response()->json(['message' => 'Endereço cadastrado com sucesso'], 201);
    }

    function update(Request $request, Endereco $endereco){
        if(JWTAuth::parseToken()->authenticate()->USUARIO_ID != $endereco->USUARIO_ID){
            return response()->json(['message' => 'Usuário não autorizado'], 401);
        }

        $endereco->update([
            'ENDERECO_NOME' => $request->nome,
            'ENDERECO_CEP' => $request->cep,
            'ENDERECO_CIDADE' => $request->cidade,
            'ENDERECO_ESTADO' => $request->estado,
            'ENDERECO_NUMERO' => $request->numero,
            'ENDERECO_LOGRADOURO' => $request->logradouro,
            'ENDERECO_COMPLEMENTO' => $request->complemento
        ]);
        return response()->json(['message' => 'Endereço atualizado com sucesso'], 200);
    }


    public function destroy($id){
        $endereco = Endereco::find($id);

        if(JWTAuth::parseToken()->authenticate()->USUARIO_ID != $endereco->USUARIO_ID){
            return response()->json(['message' => 'Usuário não autorizado'], 401);
        }

        $endereco->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso'], 200);
    }

}