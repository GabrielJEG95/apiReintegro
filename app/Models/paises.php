<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paises extends Model
{
    protected $primaryKey = "IdPais";
    public $timestamps = false;
    protected $fillable = ['Pais','UsuarioRegistro'];
    protected $table = 'Paises';
}
