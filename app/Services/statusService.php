<?php

namespace App\Services;

use App\Models\statusSolicitud;
use Carbon\Carbon;
use DB;

class statusService
{
    public function listarEstados()
    {
        $status = statusSolicitud::select('CodEstado','Descripcion')->get();

        return $status;
    }
}
