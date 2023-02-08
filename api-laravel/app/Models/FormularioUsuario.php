<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioUsuario extends Model
{
    use HasFactory;
    protected $table = 'formulario_usuario';
    protected $fillable = ['id','id_usuario','id_formulario'];
}
