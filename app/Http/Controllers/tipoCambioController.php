<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\bcn;

class tipoCambioController extends Controller
{
    public function getTipoCambio()
    {
        $cambio = bcn::obtnerTC();

        return response()->json(["MonedaOrigen"=>"$","MonedaCambio"=>"C$","TipoCambio"=>$cambio],200);
    }

    public function getTipoCambiobyDolar(Request $request)
    {
        $cambio = bcn::obtnerTC();
        $dolar = $request["valor"];
        $resultado = $cambio * $dolar;

        return response()->json(["MonedaOrigen"=>"$","MonedaCambio"=>"C$","TipoCambio"=>$resultado],200);
    }

    public function getTipoCambiobyCordoba(Request $request)
    {
        $cambio = bcn::obtnerTC();
        $cordoba = $request["valor"];
        $resultado =  $cordoba / $cambio;

        return response()->json(["MonedaOrigen"=>"C$","MonedaCambio"=>"$","TipoCambio"=>$resultado],200);
    }
}
