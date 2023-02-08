<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SDetallesRespuestasSecciones extends Model
{
    use HasFactory;
    protected $table = 's_detalles_respuestas_secciones';
    protected $fillable = ['id','id_seccion','id_respuesta','puntaje_total'];

    public function seccion(){
        return $this->belongsTo('App\Models\Secciones','id_seccion','id');
    }

    public function respuesta(){
        return $this->belongsTo('App\Models\SDetallesRespuestasUsuario','id_respuesta','id');
    }
}
