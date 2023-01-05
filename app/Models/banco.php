<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banco extends Model
{
    //protected $primaryKey = "CENTRO_COSTO";
    public $timestamps = false;
    protected $fillable = ['Banco','Pais','UsuarioRegistro'];
    protected $table = 'banco';
}
