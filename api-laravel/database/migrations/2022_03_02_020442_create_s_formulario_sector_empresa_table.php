<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSFormularioSectorEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_formulario_sector_empresa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_formulario')->unsigned();
            $table->foreign('id_formulario')->references('id')->on('s_formularios');
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
        Schema::dropIfExists('s_formulario_sector_empresa');
    }
}
