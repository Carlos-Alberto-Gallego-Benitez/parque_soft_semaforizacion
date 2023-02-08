<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSPreguntasSeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_preguntas_seccion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_seccion')->unsigned();
            $table->foreign('id_seccion')->references('id')->on('s_seccion_formulario');
            $table->enum('tipo_pregunta',['A', 'C']);
            $table->text('nombre');
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
        Schema::dropIfExists('s_preguntas_seccion');
    }
}
