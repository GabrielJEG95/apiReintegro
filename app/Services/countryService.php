<?php

namespace App\Services;

use App\Models\paises;
use App\Models\relacionUserPais;
use Carbon\Carbon;
use DB;

class countryService
{
    // retorna toda la lista de paises
    public function listarPaises()
    {
        $country = paises::select('IdPais','Pais')->get();

        return $country;
    }

    //Retorna una lista de paises en dependencia del usuario
    public function listarPaisesByUser($user)
    {
        $country = DB::table('Paises')
        ->select('IdRelacion','relacionUserPais.IdPais','Pais','relacionUserPais.Users')
        ->join('relacionUserPais','Paises.IdPais','=','relacionUserPais.IdPais')
        ->where('relacionUserPais.Users','=',$user)
        ->where('relacionUserPais.status','=',1)
        ->get();

        return $country;
    }

    public function createCountry($request)
    {
        paises::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

    public function createRelationCountryUser($request)
    {
        $isValid = self::validateData($request);

        if(!$isValid) return ["mensaje"=>"Datos incompletos, favor revisar"];

        relacionUserPais::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

    public function anularPaisUsuario($IdRelacion,$request) {
        $fecha = Carbon::now('America/Managua');
        $user = $request["user"];

        $relacion = relacionUserPais::where('IdRelacion','=',$IdRelacion)
        ->update(['status'=>0,"fechaAnulacion"=>$fecha,"UsuarioAnulacion"=>$user]);

        return ["mensaje"=>"Registro anulado con exito"];
    }

    private function validateData($request)
    {
        $user = $request["user"];
        $IdPais = $request["IdPais"];
        $userRegister = $request["userReg"];

        if($user === "") return false;
        if($IdPais === 0) return false;
        if($userRegister === "") return false;

        return true;
    }

}
