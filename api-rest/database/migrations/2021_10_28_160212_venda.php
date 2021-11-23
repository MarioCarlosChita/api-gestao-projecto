<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Venda extends Migration
{

    public function up()
    {
        Schema::create('venda', function (Blueprint $table) {
            $table->id();
            $table->double('total-venda');
            $table->integer('quantidade-produtos');
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->enum('estado-venda',['CANCELADA','VENDIDO']);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('venda');
    }
}
