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
            $table->unsignedBigInteger('user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->mediumText('texto');
            $table->timestamps();
            $table->foreign('anuncio_id')->references('id')->on('anuncios');
            $table->foreign('user_id')->references('id')->on('users');
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
