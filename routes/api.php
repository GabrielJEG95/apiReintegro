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
Route::get('permisos/{usuario}', 'App\Http\Controllers\permisosController@getPermisos');

Route::get('concepto','App\Http\Controllers\conceptoReiController@getConcepto');

Route::get('centrocosto','App\Http\Controllers\centroCostoController@getCentroCosto');

Route::get('tipopago','App\Http\Controllers\tipoPagoController@getTipoPago');

Route::get('reintegro','App\Http\Controllers\solReintegroController@getSolReintegro');
Route::get('reintegrobyrol','App\Http\Controllers\solReintegroController@getSolReintegroByRol');
Route::get('reintegrobybeneficiario','App\Http\Controllers\solReintegroController@getSolReintegroByBeneficiario');
Route::get('reintegrobyfechas','App\Http\Controllers\solReintegroController@getSolReintegroByFechas');
Route::get('reintegro/{IdSolicitud}','App\Http\Controllers\solReintegroController@getSolReintegroById');
Route::post('reintegro','App\Http\Controllers\solReintegroController@postReintegro');
Route::get('reintegrodetalle/{IdSolicitud}','App\Http\Controllers\solReintegroController@getDetalleSolicitudById');
Route::delete('reintegro/{IdSolicitud}','App\Http\Controllers\solReintegroController@deleteLinea');
Route::put('reintegro/{IdSolicitud}','App\Http\Controllers\solReintegroController@putDetalleSolicitud');
Route::get('estadistica','App\Http\Controllers\solReintegroController@getStadisticSolicitud');
Route::put('reintegroStatus/{IdSolicitud}','App\Http\Controllers\solReintegroController@putStatusSolicitud');

Route::get('prorrateo','App\Http\Controllers\prorrateoController@getProrrateo');

Route::get('person/{user}','App\Http\Controllers\userController@person');
Route::get('user','App\Http\Controllers\userController@getUserByReintegro');
Route::get('users','App\Http\Controllers\userController@getUsers');
Route::put('user/{user}','App\Http\Controllers\userController@updatePassword');

Route::get('status','App\Http\Controllers\statusSolController@getStatus');
Route::get('statusbyrole','App\Http\Controllers\statusSolController@getStatusByRole');

Route::get('tipocambio','App\Http\Controllers\tipoCambioController@getTipoCambio');
Route::get('tipocambiodol','App\Http\Controllers\tipoCambioController@getTipoCambiobyDolar');
Route::get('tipocambiocor','App\Http\Controllers\tipoCambioController@getTipoCambiobyCordoba');

Route::get('country','App\Http\Controllers\countryController@getCountry');
Route::post('country','App\Http\Controllers\countryController@postCountry');
Route::get('countrybyuser','App\Http\Controllers\countryController@getCountryByUser');
Route::post('countrybyuser','App\Http\Controllers\countryController@postRelationCountryUser');
Route::delete('countrybyuser/{Id}','App\Http\Controllers\countryController@deleteRelacionCountryUser');


Route::get('cuentacontable','App\Http\Controllers\cuentaContableController@getCuentaContable');
Route::get('cuentacontableuser','App\Http\Controllers\cuentaContableController@getRelacionCuentaUser');
Route::get('cuentacontable/{cuentaContable}','App\Http\Controllers\cuentaContableController@getCuentaContableByCuenta');
Route::post('cuentacontable','App\Http\Controllers\cuentaContableController@postCuentaContable');
Route::post('cuentacontableuser','App\Http\Controllers\cuentaContableController@postRelacionCuentaUser');
Route::delete('cuentacontableuser/{Id}','App\Http\Controllers\cuentaContableController@deleteRelacioNCuetaUser');
Route::put('cuentacontableuser/{Id}','App\Http\Controllers\cuentaContableController@activateRelacionCuentaUser');

Route::get('email','App\Http\Controllers\emailController@sendEmail');
Route::get('mail','App\Http\Controllers\emailController@email');
