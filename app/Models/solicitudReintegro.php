<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudReintegro extends Model 
{
    protected $primaryKey = "IdSolicitud";
    public $timestamps = false;
    protected $fillable = ['IdSolicitud','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','CodEstado',
    'TipoPago','Beneficiario','Concepto','CUENTA_BANCO','USUARIO','FECHAREGISTRO','FechaAsientoContable','NumCheque','Asiento','FECHAUPDATE','',
    'Anulada','flgAsientoGenerado','USUARIO1'];

    protected $table = 'fnica.reiSolicitudReintegroDePago';
}