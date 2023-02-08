<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionesRespuestaPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opciones_respuesta_preguntas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pregunta')->unsigned();
            $table->foreign('id_pregunta')->references('id')->on('preguntas_formulario');
            $table->string('opcion');
            $table->integer('puntaje');
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
        Schema::dropIfExists('opciones_respuesta_preguntas');
    }
}
