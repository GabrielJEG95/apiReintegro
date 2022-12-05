<?php

namespace App\Services;

use App\Models\permisosModel;
use Carbon\Carbon;
use DB;


class permisos
{
    public function listarPermisos($usuario, $role)
    {
        $permisos = permisosModel::select('fnica.globalUSUARIO.USUARIO','fnica.secUSUARIOROLE.IDROLE','fnica.secROLEACCION.IDACCION','fnica.secACCION.Descr as NameAction')
        ->join('fnica.secUSUARIOROLE','fnica.globalUSUARIO.USUARIO','=','fnica.secUSUARIOROLE.USUARIO')
        ->join('fnica.secROLE','fnica.secUSUARIOROLE.IDROLE','=','fnica.secROLE.IDROLE')
        ->join('fnica.secMODULO','fnica.secUSUARIOROLE.IDMODULO','=','fnica.secMODULO.IdModulo')
        ->join('fnica.secROLEACCION','fnica.secROLE.IDROLE','=','fnica.secROLEACCION.IDROLE')
        ->join('fnica.secACCION','fnica.secROLEACCION.IDACCION','=','fnica.secACCION.IDAccion')
        ->where('fnica.globalUSUARIO.USUARIO','=',$usuario)
        ->where('fnica.secUSUARIOROLE.IDMODULO','=',1500)
        ->where('fnica.secUSUARIOROLE.IDROLE','=',$role)
        ->paginate(50);

        return $permisos;
    }
}
