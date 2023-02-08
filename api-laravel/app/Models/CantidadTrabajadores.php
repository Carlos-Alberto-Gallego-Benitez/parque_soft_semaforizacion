<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CantidadTrabajadores extends Model
{
    use HasFactory;
    protected $table = 'cantidad_trabajadores';
    protected $fillable = ['id','descripcion'];
}
