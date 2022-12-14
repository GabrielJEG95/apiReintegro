<?php

namespace App\Services;

use App\Models\solicitudReintegro;
use App\Models\solicitudReintegroDetalle;
use App\Models\prorrateo;
use App\Services\statusService;
use Carbon\Carbon;
use DB;

class solReintegroService
{
    private function lastId()
    {
        return $lastId = intval(solicitudReintegro::max('IdSolicitud'))+1 ;
    }

    public function listarSolicitudes($request)
    {

        $per_page = $request["perPage"];
        $usuario = $request["user"];
        $estado = $request["status"];
        $solicitudes = '';

        if($usuario !== null) {
            $solicitudes = self::listarSolicitudesByUser($usuario,$per_page);
        } else if($estado){
            $solicitudes = self::listarSolicitudesByStatus($estado,$per_page);
        } else {
            $solicitudes = self::listarAllSolicitudes($per_page);
        }

        return $solicitudes;
    }

    public function listarAllSolicitudes($perPage)
    {
        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
                'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
                'fnica.reiSolicitudReintegroDePago.USUARIO')
                ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
                ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
                ->paginate($perPage);

        return $solicitudes;
    }
    public function listarSolicitudesByUser($usuario,$perPage)
    {
        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->where('fnica.reiSolicitudReintegroDePago.USUARIO','=',$usuario)
        ->paginate($perPage);

        return $solicitudes;
    }

    public function listarSolicitudesByStatus($status,$perPage)
    {
        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->where('fnica.reiSolicitudReintegroDePago.CodEstado','=',$status)
        ->paginate($perPage);

        return $solicitudes;
    }

    public function listarSolicitudesByRol($IdRol,$perPage)
    {
        $estados = statusService::statusByRole($IdRol);

        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->whereIn('fnica.reiSolicitudReintegroDePago.CodEstado',$estados)
        ->paginate($perPage);

        return $solicitudes;
    }

    public function obtenerSolicitudId($IdSolicitud)
    {
        $solicitud = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->where('fnica.reiSolicitudReintegroDePago.IdSolicitud','=',$IdSolicitud)
        ->paginate(10);
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
        'Anulada'=>$anulado,'flgAsientoGenerado'=>$flgAsientoGenerado,'IdSolicitud'=>$IdSolicitud,'FechaSolicitud'=>Carbon::now('America/Managua'),'Concepto'=>$items[0]["Concepto"]]);

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

    public function spProrrateo($concepto,$monto)
    {
        return DB::select("EXEC dbo.spReintegroConceptosProrrateo $concepto,$monto");
    }

    public function listarDetalleSolicitudById($IdSolicitud)
    {
        return $detalles = solicitudReintegroDetalle::where('IdSolicitud','=',$IdSolicitud)->get();

    }

    public function deleteLineaDetalle($IdSolicitud, $request) {
        $linea = $request["Linea"];
        $centroCosto = $request["centroCosto"];
        $sol = self::obtenerDetalleSolicitudId($IdSolicitud,$linea);
        $solCabecera = self::obtenerSolicitudId($IdSolicitud);

        $montoSol = $solCabecera["Monto"];
        $montoLinea = $sol[0]["Monto"];

        $nuevoMonto = $montoSol - $montoLinea;
        //return $nuevoMonto;

        $lineaDetalle = solicitudReintegroDetalle::where('CENTRO_COSTO','=',$centroCosto)
        ->where('Linea','=',$linea)
        ->where('IdSolicitud','=',$IdSolicitud)
        ->delete();

        self::updateMontoSolicitud($IdSolicitud,$nuevoMonto);

        return ["mensaje"=>"Registro Eliminado con Exito","Linea"=>$linea,"Solicitud"=>$IdSolicitud];
    }

    private function obtenerDetalleSolicitudId($IdSolicitud,$linea) {
        //return $IdSolicitud."-".$linea;
        $detalles = solicitudReintegroDetalle::where('IdSolicitud','=',$IdSolicitud)
        ->where('Linea','=',$linea)
        ->get();

        return $detalles;
    }

    private function updateMontoSolicitud($IdSolicitud,$nuevoMonto) {
        solicitudReintegro::where('IdSolicitud','=',$IdSolicitud)
        ->update(['Monto'=>$nuevoMonto]);
    }

    private function statusSolicitud($IdSolicitud)
    {
        return $detalles = solicitudReintegro::where('IdSolicitud','=',$IdSolicitud)->get();
    }

    public function updateDetalleSolicitud($IdSolicitud,$request)
    {
        try
        {
            $items = $request["items"];
            $sol = self::statusSolicitud($IdSolicitud);

            if($sol[0]["CodEstado"] !== '1')
            {
                return ["mensaje"=>"Esta solicitud ya se encuentra en proceso. No se puede actualizar"];
            }

            foreach ($items as $key => $value)
            {

                $upt = solicitudReintegroDetalle::where('IdSolicitud','=',$IdSolicitud)
                ->where('Linea','=',$value["Linea"])
                ->update(['CENTRO_COSTO'=>$value["CENTRO_COSTO"],'Cuenta_Contable'=>$value["Cuenta_Contable"],
                'NombreEstablecimiento_Persona'=>$value["NombreEstablecimiento_Persona"],'NumeroFactura'=>$value["NumeroFactura"]]);


            }

            return ["mensaje"=>"Se actualizacion los detalles con exito!","Solicitud"=>$IdSolicitud];

        } catch (\Throwable $th) {
            return ["error"=>strval($th),"mensaje"=>"Error en el servidor"];
        }

    }

    public function updateStatusSolicitud($IdSolicitud, $request)
    {
        $estado = $request["status"];
        solicitudReintegro::where('IdSolicitud','=',$IdSolicitud)->update(['CodEstado'=>$estado]);

        return ["mensaje"=>"Se actualizo el estado de la solicitud","Solicitud"=>$IdSolicitud];
    }

    public function stadisticSolicitud($user) {
        if($user === '' || $user === null) {
            $stadistic = solicitudReintegro::select(
                array(
                    DB::raw("case
                    when CodEstado = '1' then 'Pendiente'
                    when CodEstado = '2' then 'Aprobado'
                    when CodEstado = '3' then 'Atendido'
                    when CodEstado = '4' then 'En Firma'
                    when CodEstado = '5' then 'Finalizado'
                    when CodEstado = '6' then 'Rechazado'
                    else CodEstado
                    end as title"),
                    DB::raw("count(*) as total")
            )
        )
        ->groupBy('CodEstado')
        ->orderBy('CodEstado','asc')
        ->get();
        } else {
            $stadistic = solicitudReintegro::select(
                array(
                    DB::raw("case
                    when CodEstado = '1' then 'Pendiente'
                    when CodEstado = '2' then 'Aprobado'
                    when CodEstado = '3' then 'Atendido'
                    when CodEstado = '4' then 'En Firma'
                    when CodEstado = '5' then 'Finalizado'
                    when CodEstado = '6' then 'Rechazado'
                    else CodEstado
                    end as title"),
                    DB::raw("count(*) as total")
            )
        )
        ->groupBy('CodEstado')
        ->where('USUARIO','=',$user)
        ->orderBy('CodEstado','asc')
        ->get();
        }


        return $stadistic;
    }



}
