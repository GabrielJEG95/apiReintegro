<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipoPago;

class tipoPagoController extends Controller
{
    public function getTipoPago(Request $request)
    {
        $perPage = $request["perPage"];
        $tipoPago = tipoPago::paginate($perPage);

        return response()->json($tipoPago,200);
    }
}
