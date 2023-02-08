<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasUsuario extends Model
{
    use HasFactory;
    protected $table = 'respuestas_usuario';
    protected $fillable = ['id','id_usuario','id_formulario','fecha'];

    public function usuario(){
        return $this->belongsTo('App\Models\User','id_usuario','id');
    }

    public function formulario(){
        return $this->belongsTo('App\Models\Formulario','id_formulario','id');
    }

    public function detalles(){
        return $this->hasMany('App\Models\DetallesRespuestasUsuario','id_respuesta','id');
    }

    public function detalles_etapas(){
        return $this->hasMany('App\Models\DetallesRespuestasEtapas','id_respuesta','id');
    }
}
