<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\bancoService;

class bancoController extends Controller
{
    public function postBanco(Request $request)
    {
        $response = bancoService::createBanco($request);

        return response()->json($response,200);
    }

    public function getBancos(Request $request)
    {
        if(isset($request["Pais"]))
        {
            $data = bancoService::listarBancoByPais($request);
        }
        else {
            $data = bancoService::listarBancos();
        }

        return response()->json($data,200);
    }
}
