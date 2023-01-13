<?php

namespace App\Services;

use App\Models\centroCostoUser;
use App\Models\centroCosto;
use DB;

class centroCostoService {
    public function centroCostoUser($user){
        $data = centroCostoUser::select('centroCostoReintegro.CentroCosto')
        ->join('centroCostoReintegro','centroCostoReintegro.IdCentroCosto','=','relacionCentroCostoUser.IdCentroCosto')
        ->where('relacionCentroCostoUser.Users','=',$user)
        ->get();

        return $data;
    }

    public function listarCentroCostoUser($request) {
        $perPage = $request["perPage"];
        $user = $request["user"];
        $role = $request["role"];

        if($role === '1500') {
            $data = centroCostoUser::select(
                array(
                    DB::raw("case
                    when relacionCentroCostoUser.status = 1 then 'Activo'
                    else 'Inactivo'
                    end as status"),
                    'relacionCentroCostoUser.Id','relacionCentroCostoUser.Users',
                    'centroCostoReintegro.CentroCosto','centroCostoReintegro.Descripcion',
                    'relacionCentroCostoUser.fechaCreacion'
                    )
                )
            ->join('centroCostoReintegro','centroCostoReintegro.IdCentroCosto','=','relacionCentroCostoUser.IdCentroCosto')
            //->where('relacionCentroCostoUser.Users','=',$user)
            ->paginate($perPage);
        } else {
            $data = centroCostoUser::select(
                array(
                    DB::raw("case
                    when relacionCentroCostoUser.status = 1 then 'Activo'
                    else 'Inactivo'
                    end as status"),
                    'relacionCentroCostoUser.Id','relacionCentroCostoUser.Users',
                    'centroCostoReintegro.CentroCosto','centroCostoReintegro.Descripcion',
                    'relacionCentroCostoUser.fechaCreacion'
                    )
                )
            ->join('centroCostoReintegro','centroCostoReintegro.IdCentroCosto','=','relacionCentroCostoUser.IdCentroCosto')
            ->where('relacionCentroCostoUser.Users','=',$user)
            ->paginate($perPage);
        }

        return $data;
    }

    public function listarCentroCosto($request) {
        $pais = $request["Pais"];
        $pais = explode(",",$pais);
        //return $pais;

        $data = centroCosto::select('IdCentroCosto','CentroCosto','Descripcion')
        ->where('status','=',1)
        ->whereIn('Pais',$pais)
        ->get();

        return $data;
    }

    public function createCentroCostoUser($request) {

        centroCostoUser::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

    public function obtenerCentroCosto($ceco) {
        $data = centroCosto::select('Descripcion')->where('CentroCosto','=',$ceco)->get();

        return $data;
    }

}
