<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesRespuestasEtapas extends Model
{
    use HasFactory;
    protected $table = 'detalles_respuestas_etapas';
    protected $fillable = ['id','id_etapa','id_respuesta','puntaje_total'];

    public function etapa(){
        return $this->belongsTo('App\Models\Etapa','id_etapa','id');
    }

    public function respuesta(){
        return $this->belongsTo('App\Models\DetallesRespuestasUsuario','id_respuesta','id');
    }
}
