<?php

namespace App\Services;

use App\Models\statusSolicitud;
use Carbon\Carbon;
use DB;

class statusService
{
    // retorna toda la lista de estados
    public function listarEstados()
    {
        $status = statusSolicitud::select('CodEstado','Descripcion')->get();

        return $status;
    }

    //Retorna una lista de estados en dependencia del rol
    public function listarEstadosByRole($IdRole) {
        $estados = self::statusByRole($IdRole);

        $status = statusSolicitud::whereIn('CodEstado', $estados)->get();

        return $status;
    }

    public function statusByRole($IdRole) {
        /*

        Esta funcion retorna una lista de codigos de estado dependiendo del rol, dicha relación no fue creada en base de datos, por lo cual se plasma en codigo.
            Estados con codigo numerico fueron creados para la nueva version, estados con abreviación son estados heredados de la version anterior.
            1=pendiente
            2=aprobado
            3=atendido
            4=en firma
            5=finalizado
            6=rechazado
            ANU= anulada
            ATE=Atendida
            CON=Asiento Generado
            EMC= Emision de cheque
            FIN=Finalizado/entragado
            FIR=En firma
            INI=Inicializado
            PND=Pendiente
            SAC= Sin asiento Generado
        */
        $role1500 = array("1","2","3","4","5","6","7","ATE","ANU","FIN","INI","PND","SAC","FIR","EMC","CON");
        $role1503 = array("1","2","3","6","ATE","ANU" );
        $role1502 = array("1","3","4","5","6","7","ATE","EMC","FIR","INI","FIN","CON" );
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
