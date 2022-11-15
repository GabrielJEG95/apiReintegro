<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudReintegroDetalle extends Model
{
    public $timestamps = false;
    protected $fillable = ['IdSolicitud','CENTRO_COSTO','Cuenta_Contable','Linea','Concepto','FechaFactura','NumeroFactura','NombreEstablecimiento_Persona','Monto'];

    protected $table = 'fnica.reiSolicitudReintegroDePagoDetalle';
}