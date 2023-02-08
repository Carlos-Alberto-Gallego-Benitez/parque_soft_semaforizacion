<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSDetallesRespuestasSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_detalles_respuestas_secciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_respuesta')->unsigned();
            $table->foreign('id_respuesta')->references('id')->on('s_respuestas_usuario');
            $table->bigInteger('id_seccion')->unsigned();
            $table->foreign('id_seccion')->references('id')->on('s_seccion_formulario');
            $table->integer('puntaje_total');
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
        Schema::dropIfExists('s_detalles_respuestas_secciones');
    }
}
