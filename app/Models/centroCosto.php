<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class centroCosto extends Model
{
    //protected $primaryKey = "CENTRO_COSTO";
    public $timestamps = false;
    protected $fillable = ['CentroCosto','Descripcion','Pais','UsuarioRegistro'];
    protected $table = 'centroCostoReintegro';
}
