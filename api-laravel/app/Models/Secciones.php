<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
    use HasFactory;
    protected $table = 's_seccion_formulario';
    protected $fillable = ['id','id_formulario','nombre','activo','puntaje_maximo','numero_preguntas','nivel_deseado'];

    public function preguntas(){
        return $this->hasMany('App\Models\PreguntaSecciones','id_seccion', 'id');
    }

    public function formulario(){
        return $this->belongsTo('App\Models\SFormulario','id_formulario','id');
    }
}
