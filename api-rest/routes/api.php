<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'cors',
    'middleware' => 'api',
    'prefix' => 'auth'
        ], function ($router) {


    // authenticacao do usuario
    Route::post('login', 'AuthController@login');
    Route::post('logout' ,'AuthController@logout');
    Route::get('perfil','AuthController@perfil');

    // Usuaio
    Route::post('usuario','AuthController@registro');

    // Funcionario
    Route::get('funcionario','FuncionarioController@listar');
    Route::get('funcionario-venda/{id}','FuncionarioController@funcionarioVendas');

    // produtos
    Route::post('produto','ProdutoController@Adicionar');
    Route::delete('produto/{id}','ProdutoController@deletar');
    Route::put('produto/{id}','ProdutoController@atualizar');
    Route::get('produto/{id}','ProdutoController@obter');
    Route::get('produto','ProdutoController@listar');


    //venda
    Route::post('venda','VendaController@Adicionar');
    Route::get('venda/{id}','VendaController@Obter');
    Route::get('venda','VendaController@Listar');

});

