<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;



Route::middleware(["guests"])->group(function () {
    Route::post("/auth/signUp", [UsuarioController::class, "register"]);
    Route::post("/auth/signIn", [AuthController::class, "login"]);
});

Route::middleware(["user"])->group(function () {
    // Produtos
    Route::get("/produtos/ativo", [ProdutoController::class, "active"]);
    Route::get("/produtos/ativo/{produto}", [ProdutoController::class, "activeFromId"]);
    Route::get("/produtos", [ProdutoController::class, "index"]);
    Route::get("/produtos/{produto}", [ProdutoController::class, "show"]);

    // Categorias
    Route::get("/categorias/{categoria}", [CategoriaController::class, "index"]);
    Route::get("/categorias/{categoria}", [CategoriaController::class, "show"]);

    Route::get("/usuario", [UsuarioController::class, "info"]);
    Route::post("/usuario", [UsuarioController::class, "update"]);
});
