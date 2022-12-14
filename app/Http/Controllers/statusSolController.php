<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\statusSolicitud;
use App\Services\statusService;

class statusSolController extends Controller
{
    public function getStatus()
    {
        $status = statusService::listarEstados();

        return response()->json($status,200);
    }

    public function getStatusByRole(Request $request) {
        $IdRole = $request["IdRole"];

        $status = statusService::listarEstadosByRole($IdRole);

        return response()->json($status,200);
    }
}
