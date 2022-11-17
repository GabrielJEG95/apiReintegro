<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::get('login/{user}', 'App\Http\Controllers\AuthController@getUser');

Route::get('concepto','App\Http\Controllers\conceptoReiController@getConcepto');

Route::get('centrocosto','App\Http\Controllers\centroCostoController@getCentroCosto');

Route::get('tipopago','App\Http\Controllers\tipoPagoController@getTipoPago');

Route::get('reintegro','App\Http\Controllers\solReintegroController@getSolReintegro');
Route::get('reintegro/{IdSolicitud}','App\Http\Controllers\solReintegroController@getSolReintegroById');
Route::post('reintegro','App\Http\Controllers\solReintegroController@postReintegro');
Route::get('reintegrodetalle/{IdSolicitud}','App\Http\Controllers\solReintegroController@getDetalleSolicitudById');
Route::delete('reintegro/{IdSolicitud}','App\Http\Controllers\solReintegroController@deleteLinea');

Route::get('prorrateo','App\Http\Controllers\prorrateoController@getProrrateo');
