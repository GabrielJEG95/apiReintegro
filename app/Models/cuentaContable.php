<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cuentaContable extends Model
{
    protected $primaryKey = "IdCuentaContable";
    public $timestamps = false;
    protected $fillable = ['CuentaContable','Descripcion'];
    protected $table = 'cuentaContableReintegro';
}
