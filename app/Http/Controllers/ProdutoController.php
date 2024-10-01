<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index() {
        return Produto::with(["Imagens", "Estoque", "Categoria"])->get();
    }
}