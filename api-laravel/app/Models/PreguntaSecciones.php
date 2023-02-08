<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaSecciones extends Model
{
    use HasFactory;
    protected $table = 's_preguntas_seccion';
    protected $fillable = ['id','id_seccion','tipo_pregunta','nombre'];

    public function seccion(){
        return $this->belongsTo('App\Models\Secciones','id_seccion','id');
    }

    public function opciones(){
        return $this->hasMany('App\Models\OpcionesRespuestaPreguntaSecciones','id_pregunta','id');
    }
}
