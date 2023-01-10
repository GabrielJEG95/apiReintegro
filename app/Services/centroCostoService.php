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

    public function listarCentroCostoUser($perPage) {
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
        ->paginate($perPage);

        return $data;
    }

    public function listarCentroCosto() {
        $data = centroCosto::select('IdCentroCosto','CentroCosto','Descripcion')->where('status','=',1)->get();

        return $data;
    }

    public function createCentroCostoUser($request) {

        centroCostoUser::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

}
