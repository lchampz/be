<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\ItemPedido;
use App\Models\Pedido;
use DB;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function payment(Request $request)
{
    $userController = new UsuarioController();
    $user = $userController->getUserInfo();

    if (!$user) {
        return response()->json(['data' => 'Usuário não encontrado', 'error' => true], 401);
    }

    DB::beginTransaction();
    try {
        $order = Pedido::create([
            'USUARIO_ID' => $user->USUARIO_ID,
            'ENDERECO_ID' => $request->address,
            'STATUS_ID' => 1,
            'PEDIDO_DATA' => now()->format('Y-m-d')
        ]);

        foreach ($request->cart as $item) {
            
            Estoque::where('PRODUTO_ID', "=",$item['PRODUTO_ID'])->decrement('PRODUTO_QTD', $item['qtd']);

            ItemPedido::create([
                'PRODUTO_ID' => $item['PRODUTO_ID'],
                'PEDIDO_ID' => $order->PEDIDO_ID,
                'ITEM_QTD' => $item['qtd'],
                'ITEM_PRECO' => (float) $item['PRODUTO_PRECO'] - (float) $item['PRODUTO_DESCONTO']
            ]);
        }

        DB::commit();
        return response()->json(['data' => 'Pedido realizado com sucesso!', 'error' => false], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['data' => 'Erro ao processar o pedido', 'error' => true, "e"=>$e->getMessage()], 500);
    }
}


}
