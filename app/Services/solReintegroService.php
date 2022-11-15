<?php

namespace App\Services;

use App\Models\solicitudReintegro;
use App\Models\solicitudReintegroDetalle;
use Carbon\Carbon;

class solReintegroService 
{
    private function lastId()
    {
        return $lastId = intval(solicitudReintegro::max('IdSolicitud'))+1 ;
    }

    public function listarSolicitudes($request)
    {
        $per_page = $request["perPage"];
        $solicitudes = solicitudReintegro::paginate($per_page);
        return $solicitudes;
    }

    public function obtenerSolicitudId($IdSolicitud)
    {
        $solicitud = solicitudReintegro::find($IdSolicitud);
        return $solicitud;
    }

    public function createSolicitud($request)
    {
        
        $IdSolicitud = self::lastId();
        $fechaRegistro = Carbon::now('America/Managua');
        $fechaAsientoContable="null";
        $NumCheque="null";
        $asiento="null";
        $fechaUpt=Carbon::now('America/Managua');
        $anulado=0;
        $flgAsientoGenerado=0;

        $items = $request["items"];

        $request->merge(['FECHAREGISTRO'=>$fechaRegistro,'FechaAsientoContable'=>null,'NumCheque'=>$NumCheque,'Asiento'=>$asiento,'FECHAUPDATE'=>$fechaUpt,
        'Anulada'=>$anulado,'flgAsientoGenerado'=>$flgAsientoGenerado,'IdSolicitud'=>$IdSolicitud]);

        $solicitud = solicitudReintegro::create($request->all());
        return self::createDetalleSolicitud($items,$IdSolicitud);
    }

    private function createDetalleSolicitud($items,$IdSolicitud)
    {
        try 
        {
            foreach($items as $key => $value)
            {
                $value["IdSolicitud"]=$IdSolicitud;
                solicitudReintegroDetalle::create($value);
            }

            return ["mensaje"=>"Solicitud Registrada con Exito","Solicitud"=>$IdSolicitud];

        } 
        catch (\Throwable $th) 
        {
            return ["error"=>$th,"mensaje"=>"Error en el servidor"];
        }
    }
}