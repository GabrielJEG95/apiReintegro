<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class permisosModel extends Model
{
    protected $table = 'fnica.globalusuario';
    protected $fillable = ['USUARIO','PASSWORD'];
    public $timestamps = false;

}
