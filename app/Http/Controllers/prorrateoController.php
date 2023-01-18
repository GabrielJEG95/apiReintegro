<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\solReintegroService;
use App\Providers\AppServiceProvider;

class prorrateoController extends Controller
{
    public function getProrrateo(Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $concepto = $request["concepto"];
        $monto = $request["monto"];
        $pais = $request["pais"];

        return solReintegroService::spProrrateo($concepto,$monto,$pais[0]);

    }
}
