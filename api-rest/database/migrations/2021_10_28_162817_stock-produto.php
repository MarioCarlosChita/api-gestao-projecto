<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockProduto extends Migration
{

    public function up()
    {
        Schema::create('stock-produto', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string("descricao")->nullable();
            $table->string('imagem')->nullable();
            $table->string('quantidade');
            $table->string('preco');
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->enum('estado-produto-stock',['EMSTOCK','EMVENDA']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock-produto');
    }
}
