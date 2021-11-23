<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HistoricoVenda extends Migration
{
    public function up()
    {
        Schema::create('historico-venda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_usuario")->unsigned();
            $table->unsignedBigInteger("id_venda")->unsigned();
            $table->foreign("id_usuario")->references("id")->on("users");
            $table->foreign("id_venda")->references("id")->on("venda");
            $table->enum('historico-estado',['ADICIONADO','ATUALIZADO']);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('historico-venda');
    }

}
