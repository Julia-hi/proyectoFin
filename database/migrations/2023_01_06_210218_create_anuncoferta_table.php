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
        Schema::create('anuncoferta', function (Blueprint $table) {
            $table->foreignId('id')->constrained('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('titulo')->constrained('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('descripcion')->constrained('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->string('rasa', 10);
            $table->string('genero', 10);
            $table->date('fecha_nac');
            $table->string('com_autonoma');
            $table->string('provincia');
            $table->string('localidad');
            $table->string('calle');
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
        Schema::dropIfExists('anuncoferta');
    }
};
