<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacionUserPais extends Model
{
    protected $primaryKey = "IdRelacion";
    public $timestamps = false;
    protected $fillable = ['IdPais','usuarioRegistro','Users'];
    protected $table = 'relacionUserPais';
}
