<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index() {
        return Produto::with(["Imagens", "Estoque", "Categoria"])->get();
    }

    public function show($produto) {
        return Produto::with(["Imagens", "Estoque", "Categoria"])->findOrFail($produto);
    }

    public function active() {
        return Produto::with(["Imagens", "Estoque", "Categoria"])->where("PRODUTO_ATIVO", "=", 1)->get();
    }

    public function activeFromId($produto) {
        return Produto::with(["Imagens", "Estoque", "Categoria"])->where("PRODUTO_ATIVO", "=", 1)->findOrFail($produto);
    }
}
