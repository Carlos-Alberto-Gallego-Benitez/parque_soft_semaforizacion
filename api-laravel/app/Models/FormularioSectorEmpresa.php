<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioSectorEmpresa extends Model
{
    use HasFactory;
    protected $table = 'formulario_sector_empresa';
    protected $fillable = ['id','id_formulario','id_sector'];

    public function sector(){
        return $this->belongsTo('App\Models\SectorEmpresa','id_sector','id');
    }

    public function formulario(){
        return $this->belongsTo('App\Models\Formulario','id_formulario','id');
    }
}
