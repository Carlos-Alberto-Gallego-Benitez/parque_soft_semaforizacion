<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSSeccionFormularioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_seccion_formulario', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->enum('activo',['S','N'])->default('S');
            $table->integer('puntaje_maximo');
            $table->integer('numero_preguntas');
            $table->bigInteger('id_formulario')->unsigned();
            $table->foreign('id_formulario')->references('id')->on('s_formularios');
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
        Schema::dropIfExists('s_seccion_formulario');
    }
}
