<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ceco extends Model 
{
    protected $primaryKey = "IdConcepto";
    public $timestamps = false;
    protected $fillable = ['IdConcepto','strDescripcion','strProveedor','bitActivo'];
    protected $table = 'CatConceptoReintegro';
}