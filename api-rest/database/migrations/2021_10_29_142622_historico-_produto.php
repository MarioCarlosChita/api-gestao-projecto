<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HistoricoProduto extends Migration
{

    public function up()
    {
        Schema::create('historico-produto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->String('nome');
            $table->String('descricao')->nullable();
            $table->String('imagem')->nullable();
            $table->String('quantidade');
            $table->String('preco');
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->enum('historico-estado',['ADICIONADO','DELETADO','ATUALIZADO','VISUALIZADO']);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('historico-produto');
    }
}
