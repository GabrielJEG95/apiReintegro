<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\centroCosto;

class centroCostoController extends Controller
{
    public function getCentroCosto(Request $request)
    {
        $perPage = $request["perPage"];
        $pais = $request["pais"];

        $centroCosto = centroCosto::where('Pais','=',$pais)->paginate($perPage);

        return \response()->json($centroCosto,200);
    }
}
