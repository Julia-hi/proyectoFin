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
        Schema::create('anuncdemanda', function (Blueprint $table) {
            $table->foreignId('id')->constrained('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('titulo')->constrained('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('description')->constrained('anuncios')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('anuncdemanda');
    }
};
