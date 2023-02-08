<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anuncio');
            $table->foreign('id_anuncio')->references('id')->on('anuncios');
            $table->unsignedBigInteger('id_destino');
            $table->foreign('id_destino')->references('id_usuario')->on('anuncios');
            $table->unsignedBigInteger('id_remitente');
            $table->foreign('id_remitente')->references('id')->on('users');
            $table->mediumText('texto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensajes');
    }
};
