<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\globalusuario;

class userController extends Controller
{

    public function person($user) {
        $user = globalusuario::where('USUARIO','=',$user)->where('ACTIVO','=',1)->get();
        if(count($user) === 0) {
            return response()->json(['mensaje'=>'Usuario no encontrado'],200);    
        }

        return response()->json($user,200);
        
    }

    public function updatePassword($user,Request $request){
        $usuario = globalusuario::where('usuario','=',$user)
                                    ->where('password','=',$request["PASSWORD"])
                                    ->get();
        
        //return response()->json($usuario,200);
        
        if(count($usuario) === 0) {
            return response()->json(['mensaje'=>'Contraseña incorrecta'],200);
        }

        $upt = globalusuario::where('USUARIO','=',$user)
        ->update(['PASSWORD'=> $request["newPassword"]]);

        if($upt) {
            return response()->json(['mensaje'=>'Contraseña actualizada con exito!'],200);
        }
        return response()->json(['mensaje'=>'Error al actualizar la contraesña',400]);

    }
}
