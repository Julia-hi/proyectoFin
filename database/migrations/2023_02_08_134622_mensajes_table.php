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
            $table->unsignedBigInteger('anuncio_id')->onUpdate('cascade');
            $table->unsignedBigInteger('remitente_id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('recipiente_id')->onUpdate('cascade')->onDelete('cascade');
            $table->mediumText('texto');
            $table->timestamps();
            $table->foreign('anuncio_id')->references('id')->on('anuncios');
            $table->foreign('remitente_id')->references('id')->on('users');
            $table->foreign('recipiente_id')->references('id')->on('users');
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
