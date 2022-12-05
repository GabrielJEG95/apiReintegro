<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;
use SoapClient;
use App\Models\tipoCambio;
use DB;
use Mtownsend\XmlToArray\XmlToArray;

class bcn
{
    public function obtnerTC()
    {
        $Fecha="";
        $Valor="";

        //            sqlsrv_query($conn,$tsql);
        $servicio = "https://servicios.bcn.gob.ni/Tc_Servicio/ServicioTC.asmx?WSDL"; //url del servicio
        $parametros = array(); //parametros de la llamada

            $parametros['Dia'] = date("d");
            $parametros['Mes'] = date("m");
            $parametros['Ano'] = date("Y");
            libxml_disable_entity_loader(false);
            $opts = array(
                'ssl'   => array(
                        'verify_peer'          => false
                    ),
                'https' => array(
                        'curl_verify_ssl_peer'  => false,
                        'curl_verify_ssl_host'  => false
                )
            );
            $streamContext = stream_context_create($opts);

        $client = new \SoapClient($servicio,array(
                'stream_context'    => $streamContext
            ));
            $result = $client->RecuperaTC_Dia($parametros); //llamamos al métdo que nos interesa con los parámetros
            $TasaDiaria = ($result->RecuperaTC_DiaResult);

            $resultMes = $client->RecuperaTC_Mes($parametros);
            $TasaMes = ($resultMes->RecuperaTC_MesResult);

        //return $TasaMes;
        return \number_format($TasaDiaria,2);

        //return $TasaMes;

    }

    public function saveTipoCambio($request)
    {
        $FECHA = Carbon::now();
        $RecordDate = Carbon::now();
        $CreateDate = Carbon::now();
        $CreatedBy = "gespinoza";
        $UpdatedBy = "gespinoza";
        $RowPointer = (String) Str::uuid();

        tipoCambio::create();
    }
}
