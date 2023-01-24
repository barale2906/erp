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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Rutas api para verificar información
Route::apiResource('registro','api\RegistroController')->names('registro');
Route::apiResource('username','api\UseregisController')->names('username');
Route::apiResource('email','api\EmailregisController')->names('email');


