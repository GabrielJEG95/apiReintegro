<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\centroCosto;

class centroCostoController extends Controller
{
    public function getCentroCosto(Request $request)
    {
        $perPage = $request["perPage"];
        $centroCosto = centroCosto::paginate($perPage);

        return \response()->json($centroCosto,200);
    }
}
