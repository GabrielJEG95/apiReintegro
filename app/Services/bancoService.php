<?php

namespace App\Services;

use App\Models\banco;

class bancoService
{
    public function listarBancos()
    {
        $data = banco::select('banco.IdBanco','banco.Banco','Paises.Pais')
        ->join('Paises','Paises.IdPais','=','banco.Pais')
        ->paginate(10);

        return $data;
    }

    public function listarBancoByPais($request)
    {
        $data = banco::select('banco.IdBanco','banco.Banco','Paises.Pais')
        ->join('Paises','Paises.IdPais','=','banco.Pais')
        ->where('banco.Pais','=',$request["Pais"])
        ->get();

        return $data;
    }

    public function createBanco($request)
    {
        banco::create($request->all());

        return ["mensaje"=>"Registro creado con exito"];
    }
}
