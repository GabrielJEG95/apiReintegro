<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\countryService;

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
}
