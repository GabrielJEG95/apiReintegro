<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\permisos;
use App\Providers\AppServiceProvider;

class permisosController extends Controller
{
    public function getPermisos($usuario, Request $request)
    {
        $header = $request->header('Authorization');

        if($header == null){
            return response()->json('unauthorized',401);
        }
        $validate = AppServiceProvider::validateToken($header);
        if($validate !== 'ok'){
            return response()->json(["mensaje"=> "invalid","error"=>$validate],401);
        }

        $role = $request["role"];
        $permisos = permisos::listarPermisos($usuario,$role);

        return response()->json($permisos,200);
    }
}
