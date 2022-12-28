<?php

namespace App\Services;

use App\Models\cuentaContable;
use App\Models\cuentaContableUser;
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

    public function listarCuentaContableUser($perPage)
    {
        $cuentas = cuentaContableUser::select(
            array(
                DB::raw("case
                when relacioncuentaContableUser.status = 1 then 'Activo'
                else 'Inactivo'
                end as status"),
                'relacioncuentaContableUser.Id','relacioncuentaContableUser.Users',
                'cuentaContableReintegro.CuentaContable','cuentaContableReintegro.Descripcion',
                'relacioncuentaContableUser.fechaCreacion'
                )
        )
        ->join('cuentaContableReintegro','cuentaContableReintegro.IdCuentaContable','=','relacioncuentaContableUser.IdCuentaContable')
        //->where('relacioncuentaContableUser.status','=',1)
        ->paginate($perPage);

        return $cuentas;
    }

    public function createCuentaContableUser($request)
    {
        $usuario = $request["Users"];
        $cuenta = $request["IdCuentaContable"];

        $exist = self::validateExistCuentaUser($usuario, $cuenta);
        //return $exist[0]["Id"];
        if(isset($exist[0]["Id"])) return ["mensaje"=>"La cuenta contable ya se encuentra asociada al usuario"];

        cuentaContableUser::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

    public function romoveCuentaContableUser($Id, $request)
    {
        $usuarioAnulacion = $request["Users"];

        cuentaContableUser::where('Id','=',$Id)->update(['status'=>0,'usuarioAnulacion'=>$usuarioAnulacion]);

        return ["mensaje"=>"Registro anulado con exito"];
    }

    private function validateExistCuentaUser($user,$cuentaContable)
    {
        $result = cuentaContableUser::select('Id')
        ->where('Users','=',$user)
        ->where('IdCuentaContable','=',$cuentaContable)
        ->get();

        return $result;
    }
}
