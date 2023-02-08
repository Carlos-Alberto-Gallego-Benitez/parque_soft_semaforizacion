<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionesRespuestaPreguntaSecciones extends Model
{
    use HasFactory;
    protected $table = 's_opciones_respuestas_preguntas';
    protected $fillable = ['id','id_pregunta','opcion','puntaje'];

    public function pregunta(){
        return $this->belongsTo('App\Models\Preguntasecciones','id_pregunta','id');
    }
}
