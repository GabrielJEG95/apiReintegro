<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoCambio extends Model
{
    //protected $primaryKey = "IdSolicitud";
    public $timestamps = false;
    protected $fillable = ['TIPO_CAMBIO','FECHA','USUARIO','MONTO','NoteExistsFlag','RecordDate',
    'RowPointer','CreateBy','UpdatedBy','CreateDate'];

    protected $table = 'fnica.TIPO_CAMBIO_HIST';
    public $sortable = ['FECHA'];
}
