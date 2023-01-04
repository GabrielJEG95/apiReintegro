<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\emailService;

class emailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $usuario = $request["usuario"];
        $mensaje = "Nueva solicitud ingresada por ";
        $subject = "Nueva solicitud de Reintegro";

        $result = emailService::sendEmail($mensaje,$usuario,$subject);

        return response()->json($result,200);
    }

    public function email(Request $request)
    {
        $usuario = $request["usuario"];
        $monto = $request["monto"];
        $result = emailService::enviarEmail($usuario,$monto);

        return response()->json($result,200);
    }
}
