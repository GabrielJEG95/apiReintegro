<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class centroCostoUser extends Model
{
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = ['IdCentroCosto','Users','usuarioCreacion'];
    protected $table = 'relacionCentroCostoUser';
}
