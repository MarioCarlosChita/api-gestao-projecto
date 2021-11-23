<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tipo extends Migration
{

    public function up()
    {
        Schema::create('tipo', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('descricao');
            $table->string('estado')->default('N');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo');
    }
}
