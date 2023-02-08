<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSSeccionFormulario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_seccion_formulario', function (Blueprint $table) {
            $table->integer('nivel_deseado')->nullable()->after('id_formulario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('s_seccion_formulario', function (Blueprint $table) {
            if (Schema::hasColumn('s_seccion_formulario', 'nivel_deseado')) {
                $table->dropColumn('nivel_deseado');
            }
        });
    }
}
