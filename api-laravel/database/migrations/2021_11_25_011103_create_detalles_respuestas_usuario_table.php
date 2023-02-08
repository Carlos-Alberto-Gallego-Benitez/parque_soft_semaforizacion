<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesRespuestasUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_respuestas_usuario', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_respuesta')->unsigned();
            $table->foreign('id_respuesta')->references('id')->on('respuestas_usuario');
            $table->bigInteger('id_pregunta')->unsigned();
            $table->foreign('id_pregunta')->references('id')->on('preguntas_formulario');
            $table->string('respuesta');
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
        Schema::dropIfExists('detalles_respuestas_usuario');
    }
}
