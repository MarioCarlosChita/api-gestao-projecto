<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VendaProdutos extends Migration
{

    public function up()
    {
        Schema::create('venda_produtos', function (Blueprint $table) {
            $table->id();
            $table->double('preco');
            $table->integer('quantidade-produto');
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->unsignedBigInteger("id_venda")->unsigned();
            $table->double('total');
            $table->unsignedBigInteger("id_produto")->unsigned();
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->foreign('id_venda')->references('id')->on('venda');
            $table->foreign('id_produto')->references('id')->on('produtos');
            $table->enum('estado-produto',['CANCELADA','VENDIDO']);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('venda_produtos');
    }
}
