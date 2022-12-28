<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\cuentaContableService;

class cuentaContableController extends Controller
{
    public function getCuentaContable(Request $request)
    {
        $perPage = $request["perPage"];

        $cuentas = cuentaContableService::listarCuentaContable($perPage);

        return response()->json($cuentas,200);
    }

    public function getCuentaContableByCuenta($cuentaContable)
    {
        $cuenta = cuentaContableService::buscarCuentaContableByCuenta($cuentaContable);

        return response()->json($cuenta,200);
    }

    public function postCuentaContable(Request $request)
    {
        $cuenta = cuentaContableService::createCuentaContable($request);

        return response()->json($cuenta,200);
    }

    public function getRelacionCuentaUser(Request $request)
    {
        $perPage = $request["perPage"];

        $cuenta = cuentaContableService::listarCuentaContableUser($perPage);

        return response()->json($cuenta,200);
    }
    public function postRelacionCuentaUser(Request $request)
    {
        $result = cuentaContableService::createCuentaContableUser($request);

        return response()->json($result,200);
    }

    public function deleteRelacioNCuetaUser($Id, Request $request)
    {
        $result = cuentaContableService::romoveCuentaContableUser($Id,$request);

        return response()->json($result,200);
    }
}
