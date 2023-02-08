<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;
    protected $table = 'etapas';
    protected $fillable = ['id','nombre','activo','puntaje_maximo','numero_preguntas'];

    public function preguntas(){
        return $this->hasMany('App\Models\PreguntasFormulario','id_etapa', 'id');
    }
}
