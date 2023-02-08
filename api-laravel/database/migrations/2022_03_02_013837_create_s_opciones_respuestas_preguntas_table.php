<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSOpcionesRespuestasPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_opciones_respuestas_preguntas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pregunta')->unsigned();
            $table->foreign('id_pregunta')->references('id')->on('s_preguntas_seccion');
            $table->string('opcion');
            $table->integer('puntaje');
            $table->enum('activo',['S','N'])->default('S');
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
        Schema::dropIfExists('s_opciones_respuestas_preguntas');
    }
}
