<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TipoUsuario extends Migration
{

    public function up()
    {
        Schema::create('tipousuario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->foreign("id_tipo")->references("id")->on("tipo");
            $table->string("descricao");
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->unsignedBigInteger("id_tipo")->unsigned();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tipousuario');
    }
}
