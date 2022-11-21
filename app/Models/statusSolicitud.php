<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusSolicitud extends Model
{
    protected $primaryKey = "CodEstado";
    protected $keyType = "string";
    public $timestamps = false;
    protected $fillable = ['CodEstado','Descripcion'];
    protected $table = 'fnica.reiEstadoSolicitud';
}
