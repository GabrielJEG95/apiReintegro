<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\centroCosto;
use App\Services\centroCostoService;

class centroCostoController extends Controller
{
    public function getCentroCosto(Request $request)
    {
        $perPage = $request["perPage"];
        $pais = $request["pais"];

        $centroCosto = centroCosto::where('Pais','=',$pais)->paginate($perPage);

        return \response()->json($centroCosto,200);
    }

    public function getCentroCostoReintegro(Request $request)
    {
        $result = centroCostoService::listarCentroCosto($request);

        return response()->json($result,200);
    }

    public function postCentroCostoUser(Request $request) {
        $result = centroCostoService::createCentroCostoUser($request);

        return response()->json($result,200);
    }

    public function getCentroCostoUser(Request $request) {

        $data = centroCostoService::listarCentroCostoUser($request);

        return response()->json($data,200);
    }
}
