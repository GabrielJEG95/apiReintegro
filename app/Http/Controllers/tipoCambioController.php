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
}
