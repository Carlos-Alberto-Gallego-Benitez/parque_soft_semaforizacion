<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioSectorEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario_sector_empresa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_formulario')->unsigned();
            $table->foreign('id_formulario')->references('id')->on('formularios');
            $table->bigInteger('id_sector')->unsigned();
            $table->foreign('id_sector')->references('id')->on('sectores_empresa');
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
        Schema::dropIfExists('formulario_sector_empresa');
    }
}
