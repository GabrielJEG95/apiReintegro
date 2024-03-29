<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\solicitudReintegro;
use App\Services\solReintegroService;
use App\Services\emailService;
use App\Providers\AppServiceProvider;

class solReintegroController extends Controller
{
    public function getSolReintegro(Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $solicitudes = solReintegroService::listarSolicitudes($request);
        return \response()->json($solicitudes,200);
    }

    public function getSolReintegroById($IdSolicitud, Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }
        $IdRole = $request["IdRole"];
        $paises = $request["Pais"];
        $user = $request["user"];

        $solicitud = solReintegroService::obtenerSolicitudId($IdSolicitud,$IdRole,$paises,$user);
        return response()->json($solicitud,200);
    }

    public function getSolReintegroByRol(Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $IdRole = $request["IdRole"];
        $perPage = $request["perPage"];
        $user = $request["user"];
        $paises = $request["Pais"];

        $solicitudes = solReintegroService::listarSolicitudesByRol($IdRole,$perPage,$paises,$user);
        return \response()->json($solicitudes,200);
    }

    public function getSolReintegroByBeneficiario(Request $request)
    {
        $perPage = $request["perPage"];
        $paises = $request["Pais"];
        $beneficiario = $request["beneficiario"];
        $user = $request["user"];

        $solicitudes = solReintegroService::listarSolicitudesByBeneficiario($perPage,$paises,$beneficiario,$user);
        return \response()->json($solicitudes,200);
    }

    public function getSolReintegroByFechas(Request $request)
    {
        $perPage = $request["perPage"];
        $paises = $request["Pais"];
        $fechas = array("inicio"=>$request["fechaInicio"],"fin"=>$request["fechaFin"]);
        $user = $request["user"];

        $solicitudes = solReintegroService::listarSolicitudesByFechas($perPage,$paises,$fechas,$user);
        return response()->json($solicitudes,200);
    }

    public function postReintegro(Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $solicitud = solReintegroService::createSolicitud($request);

        $usuario = $request["USUARIO"];
        $Monto = $request["Monto"];

        return response()->json($solicitud,200);
    }

    public function getDetalleSolicitudById(Request $request, $IdSolicitud)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $detalles = solReintegroService::listarDetalleSolicitudById($IdSolicitud);
        return response()->json($detalles,200);
    }

    public function deleteLinea($IdSolicitud, Request $request)
    {

        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $detalles = solReintegroService::deleteLineaDetalle($IdSolicitud,$request);
        return response()->json($detalles,200);
    }

    public function putDetalleSolicitud($IdSolicitud, Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $detalles = solReintegroService::updateDetalleSolicitud($IdSolicitud,$request);

        return response()->json($detalles,200);
    }

    public function getStadisticSolicitud(Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $user = $request["user"];
        $paises = $request["Pais"];

        $stadistic = solReintegroService::stadisticSolicitud($user,$paises);

        return response()->json($stadistic,200);
    }

    public function putStatusSolicitud($IdSolicitud,Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $upt = solReintegroService::updateStatusSolicitud($IdSolicitud, $request);

        return \response()->json($upt,200);
    }

    public function getNumeroSolicitud()
    {
        $numero = solReintegroService::lastId();

        return response()->json($numero,200);
    }

}
