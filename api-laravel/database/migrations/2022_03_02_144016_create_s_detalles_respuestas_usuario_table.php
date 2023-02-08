<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSDetallesRespuestasUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_detalles_respuestas_usuario', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_respuesta')->unsigned();
            $table->foreign('id_respuesta')->references('id')->on('s_respuestas_usuario');
            $table->bigInteger('id_pregunta')->unsigned();
            $table->foreign('id_pregunta')->references('id')->on('s_preguntas_seccion');
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
        Schema::dropIfExists('s_detalles_respuestas_usuario');
    }
}
