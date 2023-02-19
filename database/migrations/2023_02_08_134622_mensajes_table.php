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
            $table->unsignedBigInteger('anuncio_id');
            $table->foreign('anuncio_id')->references('id')->on('anuncios');
            $table->unsignedBigInteger('estino_id');
            $table->foreign('estino_id')->references('user_id')->on('anuncios');
            $table->unsignedBigInteger('remitente_id');
            $table->foreign('remitente_id')->references('id')->on('users');
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
