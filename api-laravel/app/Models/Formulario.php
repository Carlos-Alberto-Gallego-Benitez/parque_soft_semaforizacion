<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;
    protected $table = 'formularios';
    protected $fillable = ['id','nombre','activo'];

    public function formulario_sector(){
        return $this->hasMany('App\Models\FormularioSectorEmpresa','id_formulario','id');
    }
}
