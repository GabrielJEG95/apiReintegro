<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\conceptoReintegro;

class conceptoReiController extends Controller
{
    public function getConcepto(Request $request){
        $per_page = $request["perPage"];

        $ceco = conceptoReintegro::paginate($per_page);
        return response()->json($ceco,200);
    }

}
