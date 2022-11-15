<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\solicitudReintegro;
use App\Services\solReintegroService;

class solReintegroController extends Controller
{
    public function getSolReintegro(Request $request)
    {
        $solicitudes = solReintegroService::listarSolicitudes($request);
        return \response()->json($solicitudes,200);
    }

    public function getSolReintegroById($IdSolicitud)
    {
        $solicitud = solReintegroService::obtenerSolicitudId($IdSolicitud);
        return response()->json($solicitud,200);
    }

    public function postReintegro(Request $request)
    {
        $solicitud = solReintegroService::createSolicitud($request);
        return response()->json($solicitud,200);
    }

}
