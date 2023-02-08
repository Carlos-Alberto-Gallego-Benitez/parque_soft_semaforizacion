<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SRespuestasUsuario extends Model
{
    use HasFactory;
    protected $table = 's_respuestas_usuario';
    protected $fillable = ['id','id_usuario','id_formulario','fecha'];

    public function usuario(){
        return $this->belongsTo('App\Models\User','id_usuario','id');
    }

    public function formulario(){
        return $this->belongsTo('App\Models\SFormulario','id_formulario','id');
    }

    public function detalles(){
        return $this->hasMany('App\Models\SDetallesRespuestasUsuario','id_respuesta','id');
    }

    public function detalles_secciones(){
        return $this->hasMany('App\Models\SDetallesRespuestasSecciones','id_respuesta','id');
    }
}
