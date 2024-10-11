<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/get', [CategoriaController::class, 'get']);

Route::post('/categorias', [CategoriaController::class, 'store']);
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);



Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/get', [ProdutoController::class, 'get']);
Route::post('/produtos', [ProdutoController::class, 'store']);
Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
Route::get('/produtos/excel', [ProdutoController::class, 'excel']);
Route::get('/produtos/pdf', [ProdutoController::class, 'pdf'])->name('produtos.pdf');
Route::get('/produtos/txt', [ProdutoController::class, 'txt']);
