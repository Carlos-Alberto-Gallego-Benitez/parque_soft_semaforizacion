<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntasFormulario extends Model
{
    use HasFactory;
    protected $table = 'preguntas_formulario';
    protected $fillable = ['id','id_formulario','id_etapa','tipo_pregunta','nombre'];

    public function etapa(){
        return $this->belongsTo('App\Models\Etapa','id_etapa','id');
    }

    public function formulario(){
        return $this->belongsTo('App\Models\Formulario','id_formulario','id');
    }

    public function opciones(){
        return $this->hasMany('App\Models\OpcionesRespuestaPregunta','id_pregunta','id');
    }
}
