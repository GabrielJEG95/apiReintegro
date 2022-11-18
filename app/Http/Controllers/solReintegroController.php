<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\solicitudReintegro;
use App\Services\solReintegroService;
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

    public function getSolReintegroById($IdSolicitud)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $solicitud = solReintegroService::obtenerSolicitudId($IdSolicitud);
        return response()->json($solicitud,200);
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

}
