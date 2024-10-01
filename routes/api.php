<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', action: function (Request $request) {
//     return $request->user();
// });

Route::get("/produtos/ativo", [ProdutoController::class, "active"]);
Route::get("/produtos/ativo/{produto}", [ProdutoController::class,"activeFromId"]);
Route::get("/produtos", [ProdutoController::class, "index"]);
Route::get("/produtos/{produto}", [ProdutoController::class, "show"]);

Route::get("/categorias/{categoria}", [CategoriaController::class, "index"]);
Route::get("/categorias/{categoria}", action: [CategoriaController::class, "show"]);