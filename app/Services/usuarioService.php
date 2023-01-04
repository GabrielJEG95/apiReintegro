<?php

namespace App\Services;

use App\Models\globalusuario;
use Carbon\Carbon;
use DB;


class usuarioService
{
    public function listarUserReintegro()
    {
        $user = globalusuario::select('fnica.secusuariorole.USUARIO')
        ->join('fnica.secusuariorole','fnica.secusuariorole.USUARIO','=','fnica.globalusuario.USUARIO')
        ->where('fnica.secusuariorole.IDMODULO','=',1500)
        ->where('fnica.globalusuario.ACTIVO','=',1)
        ->get();

        return $user;
    }

    public function listarUsuarios($user,$key)
    {
        $secret_key = "b969a2fb51d1b84d10a4bcd470403f049651ad723e5151e332312cbf3c768f4738ad7509a83ec76afe1b59a657ed9167f5d1e35870a2042de64cf2f1c247bdb7";
        if($secret_key !== $key) return ["mensaje"=>"No esta autorizado para consultar el API, proporcione una Key"];
        $data = globalusuario::select('USUARIO','DESCR','PASSWORD')->where('USUARIO','=',$user)->get();
        return $data;
    }

    public function buscarUsuariobyUsername($user)
    {
        $user = globalusuario::select('email')->where('USUARIO','=',$user)
        ->get();

        return $user;
    }
}
