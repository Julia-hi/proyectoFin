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
        $this->down();
        Schema::create('anuncios_oferta', function (Blueprint $table) {
            $table->id();
            $table->foreign('id')->references('id')->on('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->string('titulo', 30);
            $table->mediumText('descripcion', 300);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('raza', 10);
            $table->string('genero', 10);
            $table->date('fecha_nac');
            $table->string('comunidad', 100);
            $table->string('provincia', 100);
            $table->string('poblacion', 30);
            $table->string('lat', 10);
            $table->string('lon', 10);
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
        Schema::dropIfExists('anuncio_ofertas');
    }
};
