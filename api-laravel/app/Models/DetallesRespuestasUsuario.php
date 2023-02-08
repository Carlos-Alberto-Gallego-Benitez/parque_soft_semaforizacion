<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesRespuestasUsuario extends Model
{
    use HasFactory;
    protected $table = 'detalles_respuestas_usuario';
    protected $fillable = ['id','id_respuesta','respuesta','id_pregunta','puntaje'];

    public function respuesta(){
        return $this->belongsTo('App\Models\RespuestasUsuario','id_respuesta','id');
    }

    public function pregunta(){
        return $this->belongsTo('App\Models\PreguntasFormulario','id_pregunta','id');
    }
}
