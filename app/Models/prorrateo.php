<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prorrateo extends Model
{
    public $timestamps = false;
    protected $fillable = ['IdConcepto','strDescripcionConcepto','IdLinea','strCeCo','strDescripcionCeco','intEmpleados','intTotalEmpleados','decMontoPro'];
}