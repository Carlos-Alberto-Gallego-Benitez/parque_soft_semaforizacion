<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesRespuestasEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_respuestas_etapas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_respuesta')->unsigned();
            $table->foreign('id_respuesta')->references('id')->on('respuestas_usuario');
            $table->bigInteger('id_etapa')->unsigned();
            $table->foreign('id_etapa')->references('id')->on('etapas');
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
        Schema::dropIfExists('detalles_respuestas_etapas');
    }
}
