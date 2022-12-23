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
    // retorna el ultimo ID insertado
    private function lastId()
    {
        return $lastId = intval(solicitudReintegro::max('IdSolicitud'))+1 ;
    }

    // evalua que funcion ejecutar para retornar una lista de solicitudes
    public function listarSolicitudes($request)
    {

        $per_page = $request["perPage"];
        $usuario = $request["user"];
        $estado = $request["status"];
        $paises = $request["Pais"];
        $solicitudes = '';

        if($usuario !== null) {
            $solicitudes = self::listarSolicitudesByUser($usuario,$per_page,$paises);
        } else if($estado){
            $solicitudes = self::listarSolicitudesByStatus($estado,$per_page,$paises);
        } else {
            $solicitudes = self::listarAllSolicitudes($per_page);
        }

        return $solicitudes;
    }
    // retorna todas las solicitudes (no toma en cuenta rol, estado, etc)
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
    // retorna lista de solicitudes que cada usuario a hecho
    public function listarSolicitudesByUser($usuario,$perPage,$paises)
    {
        $country = explode(",",$paises);

        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->where('fnica.reiSolicitudReintegroDePago.USUARIO','=',$usuario)
        //->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
        ->paginate($perPage);

        return $solicitudes;
    }

    // retorna lista de solicitudes por filtro de estados (no toma en cuenta rol, solo estado)
    public function listarSolicitudesByStatus($status,$perPage,$paises)
    {
        $country = explode(",",$paises);

        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->where('fnica.reiSolicitudReintegroDePago.CodEstado','=',$status)
        ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
        ->paginate($perPage);

        return $solicitudes;
    }

    // retornada una lista de solicitudes en dependencia de los estados que cada rol puede ver.
    public function listarSolicitudesByRol($IdRol,$perPage,$paises)
    {
        $estados = statusService::statusByRole($IdRol);
        $country = explode(",",$paises);


        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->whereIn('fnica.reiSolicitudReintegroDePago.CodEstado',$estados)
        ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
        ->paginate($perPage);

        return $solicitudes;
    }

    public function listarSolicitudesByBeneficiario($perPage,$paises,$beneficiario)
    {
        $country = explode(",",$paises);


        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->where('fnica.reiSolicitudReintegroDePago.Beneficiario','like','%'.$beneficiario.'%')
        ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
        ->paginate($perPage);

        return $solicitudes;
    }
    public function listarSolicitudesByFechas($perPage,$paises,$fechas)
    {
        $country = explode(",",$paises);
        $inicio = $fechas["inicio"];
        $fin = $fechas["fin"];

        $solicitudes = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
        'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
        'fnica.reiSolicitudReintegroDePago.USUARIO')
        ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
        ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
        ->whereBetween('fnica.reiSolicitudReintegroDePago.FechaSolicitud',[$inicio,$fin])
        ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
        ->paginate($perPage);

        return $solicitudes;
    }

    // filtrar solicitud por ID, retorna un unico registro
    public function obtenerSolicitudId($IdSolicitud, $IdRole,$paises)
    {
        $country = explode(",",$paises);

        if($IdRole !== 0) {
            $estados = statusService::statusByRole($IdRole);

            $solicitud = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
            'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
            'fnica.reiSolicitudReintegroDePago.USUARIO')
            ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
            ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
            ->where('fnica.reiSolicitudReintegroDePago.IdSolicitud','=',$IdSolicitud)
            ->whereIn('fnica.reiSolicitudReintegroDePago.CodEstado',$estados)
            ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
            ->paginate(10);
        } else {
            $solicitud = solicitudReintegro::select('IdSolicitud','fnica.reiTipoEmisionPago.Descripcion','CENTRO_COSTO','FechaSolicitud','Monto','EsDolar','Beneficiario',
            'Concepto','CUENTA_BANCO','NumCheque','FECHAREGISTRO','fnica.reiSolicitudReintegroDePago.CodEstado','fnica.reiEstadoSolicitud.Descripcion AS nameStatus',
            'fnica.reiSolicitudReintegroDePago.USUARIO')
            ->join('fnica.reiTipoEmisionPago','fnica.reiSolicitudReintegroDePago.TipoPago','=','fnica.reiTipoEmisionPago.TipoPago')
            ->join('fnica.reiEstadoSolicitud','fnica.reiSolicitudReintegroDePago.CodEstado','=','fnica.reiEstadoSolicitud.CodEstado')
            ->where('fnica.reiSolicitudReintegroDePago.IdSolicitud','=',$IdSolicitud)
            ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
            ->paginate(10);
        }

        return $solicitud;
    }

    // crear nueva solicitud (recibe una cabecera y un arreglo de objetos que contiene los detalles de la solicitud)
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
    // inserta los detalles de la solicitud creada
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
    // ejecuta procedimiento almacenado que retorna n lineas en dependencia del concepto
    public function spProrrateo($concepto,$monto)
    {
        return DB::select("EXEC dbo.spReintegroConceptosProrrateo $concepto,$monto");
    }
    // retorna lista de detalles de una solicitud por el ID de la sol
    public function listarDetalleSolicitudById($IdSolicitud)
    {
        return $detalles = solicitudReintegroDetalle::where('IdSolicitud','=',$IdSolicitud)->get();

    }
    // eliminar detalle de una solicitud por linea y ID sol
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
    //actualiza el estado de la solicitud y genera un asiento en caso de que el estado a cambiar sea el codigo "7" o "CON"
    public function updateStatusSolicitud($IdSolicitud, $request)
    {
        $solicitud = self::obtenerSolicitudId($IdSolicitud,0);
        $statusSol = $solicitud[0]["CodEstado"];
        $estado = $request["status"];
        $respuesta = array();

        if($estado === "7" || $estado === "CON") { // 7 = generar asiento.  CON = asiento generado. estado que envia el usuario
            if($statusSol === "3" || $statusSol === "ATE") // Estado en que se encuentra actualmente la solicitud. 3 = atendido. ATE = atentida
            {
                solicitudReintegro::where('IdSolicitud','=',$IdSolicitud)->update(['CodEstado'=>$estado]);

                $asiento = self::generarAsiento($IdSolicitud);
                $respuesta = ["mensaje"=>"Se actualizo el estado de la solicitud","Solicitud"=>$IdSolicitud, "asiento"=>$asiento];

            } else if($statusSol === "CON" || $statusSol === "FIR" || $statusSol === "4") {
                $respuesta = ["mensaje"=>"No se puede realizar esta acción. Ya se genero un asiento para esta solicitud","Solicitud"=>$IdSolicitud];
            } else if ($statusSol === "INI"){
                $respuesta = ["mensaje"=>"No se puede generar asiento de una solicitud que aún no ha sido atentida por administración","Solicitud"=>$IdSolicitud];
            } else if($statusSol === "6" || $statusSol === "ANU") {
                $respuesta = ["mensaje"=>"No se puede generar asiento de una solicitud que ha sido rechazada/anulada","Solicitud"=>$IdSolicitud];
            }
        } else if($estado === "1" ||  $estado === "INI") {
            $respuesta = ["mensaje"=>"Esta solicitud ya ha sido cambiada de estado Pendiente/Inicializado, por lo cual no se puede actualizar al estado solicitado","Solicitud"=>$IdSolicitud];
        } else if ($estado === "FIN" || $estado === "5") {
            if($statusSol === "CON" || $statusSol === "7") {
                solicitudReintegro::where('IdSolicitud','=',$IdSolicitud)->update(['CodEstado'=>$estado]);
                $respuesta = ["mensaje"=>"Se actualizo el estado de la solicitud a finalizado","Solicitud"=>$IdSolicitud];
            } else {
                $respuesta = ["mensaje"=>"No se puede finalizar una solicitud que no se le ha generado asiento","Solicitud"=>$IdSolicitud];
            }
        } else if($estado === "3" || $estado === "ATE") {
            if($statusSol === "6" || $statusSol === "ANU") {
                $respuesta = ["mensaje"=>"No se puede cambiar de estado una solicitud que ha sido rechazada/anulada","Solicitud"=>$IdSolicitud];
            }
        } else {
            solicitudReintegro::where('IdSolicitud','=',$IdSolicitud)->update(['CodEstado'=>$estado]);
            $respuesta = ["mensaje"=>"Se actualizo el estado de la solicitud","Solicitud"=>$IdSolicitud];
        }

        return $respuesta;
    }
    // esta funcion esta hecha para los datos que necesita los graficos del dashboard de la patanlla principal
    public function stadisticSolicitud($user,$paises) {

        $country = explode(",",$paises);

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
                    when CodEstado = '7' then 'Asiento Generado'
                    else CodEstado
                    end as title"),
                    DB::raw("count(*) as total")
            )
        )
        ->groupBy('CodEstado')
        ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
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
        ->whereIn('fnica.reiSolicitudReintegroDePago.Pais',$country)
        ->orderBy('CodEstado','asc')
        ->get();
        }


        return $stadistic;
    }

    private function generarAsiento($IdSolicitud) {
        $fecha = Carbon::now('America/Managua');
        $asiento = "@AsientoOutput";

        return DB::select("declare @AsientoOutput nvarchar(10) EXEC fnica.uspreiCreaAsientoASolicitud $IdSolicitud,'$fecha', $asiento OUTPUT select $asiento as asiento");
    }



}
