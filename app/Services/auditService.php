<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;
use SoapClient;
use App\Models\registroLog;
use DB;

class auditService
{
    private function setPropiedadesApp()
    {
        $ip = $this->server->get('REMOTE_ADDR');
        $App = 1;

        return ["ip"=>$ip,"app"=>$App];
    }

    public function createLog($data)
    {
        $defaultValues = self::setPropiedadesApp();

        $tableName = $data["table"];
        $user = $data["user"];
        $action = $data["action"];
        $ip = $defaultValues["ip"];
        $app = $defaultValues["app"];
        $value = $data["value"];

        $data = ["TableName"=>$tableName,"Users"=>$user,"Action"=>$action,"setValue"=>$value,"IP"=>$ip];

        registroLog::create($data);

    }
}
