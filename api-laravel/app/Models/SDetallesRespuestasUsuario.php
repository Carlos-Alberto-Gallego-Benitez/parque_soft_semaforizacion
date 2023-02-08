<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SDetallesRespuestasUsuario extends Model
{
    use HasFactory;
    protected $table = 's_detalles_respuestas_usuario';
    protected $fillable = ['id','id_respuesta','respuesta','id_pregunta','puntaje'];

    public function respuesta(){
        return $this->belongsTo('App\Models\SRespuestasUsuario','id_respuesta','id');
    }

    public function pregunta(){
        return $this->belongsTo('App\Models\PreguntaSecciones','id_pregunta','id');
    }
}
