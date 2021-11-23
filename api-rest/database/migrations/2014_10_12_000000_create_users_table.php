<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->string("ultimonome");
            $table->string("foto_url")->nullable();
            $table->string("visibilidade")->nullable();
            $table->string("estado")->nullable();
            $table->String("tipo_cadastro")->nullable();
            $table->string("tipo_online")->nullable();
            $table->string('genero')->nullable();
            $table->string('bi')->nullable();
            $table->string('id_loja')->nullable();
            $table->string('genero')->nullable();
            $table->string('datanascimento')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
