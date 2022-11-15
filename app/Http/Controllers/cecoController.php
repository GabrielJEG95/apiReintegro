<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ceco;

class cecoController extends Controller
{
    public function getCeco(Request $request){
        $per_page = $request["perPage"];

        $ceco = ceco::paginate($per_page);
        return response()->json($ceco,200);
    }

}
