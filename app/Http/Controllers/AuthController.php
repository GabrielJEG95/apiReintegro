<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\globalusuario;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = $request["USUARIO"];
        $pass = $request["PASSWORD"];

       $login = globalusuario::where('usuario','=',$user)
                                ->where('password','=',$pass)
                                ->get();

        $acceso = globalusuario::select('fnica.globalusuario.USUARIO','fnica.secUsuarioRole.IDROLE')
        ->join('fnica.secUsuarioRole','fnica.globalusuario.USUARIO','=','fnica.secUsuarioRole.USUARIO')
        ->where('fnica.globalusuario.USUARIO','=',$user)
        ->where('fnica.secUsuarioRole.IDMODULO','=',1500)
        ->get();

       if(count($login) === 0) {
            return response()->json(['mensaje'=>'Usuario o Contraseña Incorrecto'],404);
       } else if(count($acceso) === 0){
        return response()->json(['mensaje'=>'Su usuario no tiene acceso al Sitema de Reintegro'],404);
       } else {
                $secretKey = "00e3d043e7725fa6006e634f79c770c79d30b7f2a4b86afe5188cfe7bf6250b8"; //"formunica_2022*";
                $date = Carbon::now('America/Managua');
                $expire_at = $date->addMinutes(480); //modify('+480 minutes')->getTimestamp();
                $expire_at = $expire_at->toDateTimeString();
                $expire_at = strtotime($expire_at);
                $dominio = "formunica.com";

                $request_data = [
                'iat' => $date->getTimestamp(),
                'iss' => $dominio,
                'nbf' => $date->getTimestamp(),
                'exp' => $expire_at,
                'username' => $request["USUARIO"]
                ];

                return response()->json([
                    'token'=>JWT::encode($request_data,$secretKey,"HS512"),
                    'user'=>$request["USUARIO"],
                    'rol' => $acceso[0]["IDROLE"]
                ],200
            );
       }

    }

    public function getUser($user){
        $user = globalusuario::where('USUARIO','=',$user)->where('ACTIVO','=',1)->get();
        if(count($user) === 0) {
            return response()->json(['mensaje'=>'Invalido'],200);
        }

        return response()->json(['mensaje'=>'OK'],200);
    }

}
