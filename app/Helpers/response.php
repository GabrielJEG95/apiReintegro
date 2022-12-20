<?php

namespace App\Helpers;

class response
{
    public function apiResponse($exception)
    {
        if (\method_exists($exception,'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode)
        {
            case 401:
                    $response["mensaje"]= "Unauthorized";
                break;
            case 403:
                    $response["mensaje"] = "Forbidden";
                break;
            case 404:
                    $response["mensaje"] = "Not Found";
                break;
            case 405:
                    $response["mensaje"] = "Method Not Allowed";
                break;
            case 422:
                    $response["mensaje"] = $exception->original["message"];
                    $response["error"] = $exception->original["errors"];
                break;
            default:
                    $response['mensaje'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }

        $reponse["status"] = $statusCode;

        return $message = ["response"=>$response,"statusCode"=>$statusCode];
    }
}
