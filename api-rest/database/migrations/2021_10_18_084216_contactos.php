<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contactos extends Migration
{
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('id-usuario');
            $table->unsignedBigInteger('id-tipo-contactos');
            $table->string('descricao');
            $table->foreign("id-usuario")->references("id")->on("users");
            $table->foreign("id-tipo-contactos")->references("id")->on("tipo-contactos");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactos');
    }
}
