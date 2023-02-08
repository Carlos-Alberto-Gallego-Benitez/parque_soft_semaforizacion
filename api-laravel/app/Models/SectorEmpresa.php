<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectorEmpresa extends Model
{
    use HasFactory;
    protected $table = 'sectores_empresa';
    protected $fillable = ['id','nombre','activo'];
}
