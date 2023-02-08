<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresas';
    protected $fillable = ['id','id_sector','id_usuario','id_cantidad_trabajadores','nombre','nit','direccion','telefono','email','representante','cc_representante'];

    public function sector(){
        return $this->belongsTo('App\Models\SectorEmpresa','id_sector','id');
    }

    public function trabajador(){
        return $this->belongsTo('App\Models\CantidadTrabajadores','id_cantidad_trabajadores','id');
    }
}
