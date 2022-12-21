<?php

namespace App\Services;

use App\Models\cuentaContable;
use Carbon\Carbon;
use DB;


class cuentaContableService
{
    public function listarCuentaContable($perPage)
    {
        $cuentaContable = cuentaContable::select('CuentaContable','Descripcion')->paginate($perPage);

        return $cuentaContable;
    }

    public function createCuentaContable($request)
    {
        $cuenta = $request["cuentaContable"];
        $resultCuenta = self::buscarCuentaContableByCuenta($cuenta);

        if($resultCuenta !== null || $resultCuenta !== []) {
            return ["mensaje"=>"Esta cuenta contable ya existe"];
        }

        cuentaContable::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

    public function buscarCuentaContableByCuenta($cuentaContable)
    {
        $cuentaContable = cuentaContable::select('CuentaContable','Descripcion')->where('CuentaContable','=',$cuentaContable)->get();
        return $cuentaContable;
    }
}
