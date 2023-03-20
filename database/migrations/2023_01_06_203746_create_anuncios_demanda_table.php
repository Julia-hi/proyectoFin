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
        Schema::create('anuncios_demanda', function (Blueprint $table) {
            $table->foreignId('id');
            $table->foreign('id')->references('id')->on('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->string('titulo', 30);
            $table->mediumText('descripcion', 300);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('anuncios_demanda');
    }
};
