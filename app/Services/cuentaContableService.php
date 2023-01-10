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
        $cuentaContable = cuentaContable::select('IdCuentaContable','CuentaContable','Descripcion')->paginate($perPage);

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

    public function obtenerCuentaContableUser($user) {
        $data = cuentaContableUser::select('cuentaContableReintegro.CuentaContable')
        ->join('cuentaContableReintegro','relacioncuentaContableUser.IdCuentaContable','=','cuentaContableReintegro.IdCuentaContable')
        ->where('relacioncuentaContableUser.Users','=',$user)
        ->get();

        return $data;
    }

    public function createCuentaContableUser($request)
    {
        if(is_bool(self::validateDataRelation($request)) === false) {
            return ["mensaje"=> "Campos incompletos, no se pudo completar el registro, favor revisar"];
        }
        $usuario = $request["Users"];
        $cuenta = $request["IdCuentaContable"];

        $exist = self::validateExistCuentaUser($usuario, $cuenta);
        //return $exist[0]["Id"];
        if(isset($exist[0]["Id"])) return ["mensaje"=>"La cuenta contable ya se encuentra asociada al usuario"];

        cuentaContableUser::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }

    private function validateDataRelation($request) {
        $user = $request["Users"];
        $cuenta = $request["IDCuentaContable"];

        if($user === '' || $user === null) return false;
        if($cuenta === 0 || $cuenta === null) return false;

        return true;
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

    public function reactivateCuentaUser($Id, $request)
    {
        cuentaContableUser::where('Id','=',$Id)->update(['status'=>1,'usuarioAnulacion'=>null,'fechaAnulacion'=>null]);

        return ["mensaje"=>"Registro actualizado con exito"];
    }

}
