<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Produtos extends Migration
{

    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string("descricao")->nullable();
            $table->string('imagem')->nullable();
            $table->string('quantidade');
            $table->string('preco');
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->string('estado')->default('S');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
