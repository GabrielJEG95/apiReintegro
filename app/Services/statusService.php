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

    public function listarEstadosByRole($IdRole) {
        $estados = self::statusByRole($IdRole);

        $status = statusSolicitud::whereIn('CodEstado', $estados)->get();

        return $status;
    }

    public function statusByRole($IdRole) {
        $role1500 = array("1","2","3","4","5","6","ATE","ANU","FIN","INI" );
        $role1503 = array("1","2","3","6","ATE","ANU" );
        $role1502 = array("1","2","3","4","5","6" );
        $role1501 = array("INI","ATE","ANU","1","2","3","6");
        $role = array("0");

        switch ($IdRole) {
            case 1501:
                    return $role1501;
                break;
            case 1502:
                    return $role1502;
                break;
            case 1503:
                    return $role1503;
                break;
            case 1500:
                    return $role1500;
                break;
            default:
                    return $role;
                break;
        }
    }
}
