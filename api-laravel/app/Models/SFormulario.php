<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SFormulario extends Model
{
    use HasFactory;
    protected $table = 's_formularios';
    protected $fillable = ['id','nombre','id_usuario','activo'];

    public function formulario_sector(){
        return $this->hasMany('App\Models\SFormularioSectorEmpresa','id_formulario','id');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\User','id_usuario','id');
    }

    public function secciones(){
        return $this->hasMany('App\Models\Secciones','id_formulario','id');
    }
}
