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
        Schema::create('anuncio_ofertas', function (Blueprint $table) {
            $table->foreignId('id');
            $table->foreign('id')->references('id')->on('anuncios')->onUpdate('cascade')->onDelete('cascade');
            $table->string('titulo', 100)->collation('utf8mb4_unicode_ci');
            $table->mediumText('descripcion', 300)->collation('utf8mb4_unicode_ci');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->string('rasa', 10)->collation('utf8mb4_unicode_ci');
            $table->string('genero', 10)->collation('utf8mb4_unicode_ci');
            $table->date('fecha_nac');
            $table->string('com_autonoma', 100)->collation('utf8mb4_unicode_ci');
            $table->string('provincia', 100)->collation('utf8mb4_unicode_ci');
            $table->string('localidad', 30)->collation('utf8mb4_unicode_ci');
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
