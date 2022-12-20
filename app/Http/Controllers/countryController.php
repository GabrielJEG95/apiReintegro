<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\countryService;
use App\Helpers\response;

class countryController extends Controller
{
    public function getCountry() {
        $country = countryService::listarPaises();

        return response()->json($country,200);
    }

    public function getCountryByUser(Request $request) {
        $user = $request["user"];

        $country = countryService::listarPaisesByUser($user);

        return response()->json($country,200);
    }

    public function postCountry(Request $request) {
        $country = countryService::createCountry($request);

        return response()->json($country,200);
    }

    public function postRelationCountryUser(Request $request) {
        $country = countryService::createRelationCountryUser($request);

        return response()->json($country,200);
    }

    public function deleteRelacionCountryUser($Id,Request $request) {
        try {

            $relacion = countryService::anularPaisUsuario($Id, $request);
            return response()->json($relacion,200);

        } catch (\Exception $ex) {
            $response = response::apiResponse($ex);
            return response()->json($response["response"],$response["statusCode"]);
        }

    }
}
