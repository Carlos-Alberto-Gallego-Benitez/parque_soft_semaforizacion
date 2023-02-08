<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionesRespuestaPregunta extends Model
{
    use HasFactory;
    protected $table = 'opciones_respuesta_preguntas';
    protected $fillable = ['id','id_pregunta','opcion','puntaje'];

    public function pregunta(){
        return $this->belongsTo('App\Models\PreguntasFormulario','id_pregunta','id');
    }


}
