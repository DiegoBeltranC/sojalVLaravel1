<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CiudadanoControllerAPI;
use App\Http\Controllers\API\ReporteControllerApi;
use App\Http\Controllers\API\RutaControllerApi;
use App\Http\Controllers\API\TruckControllerApi;

Route::apiResource('ciudadanos', CiudadanoControllerAPI::class);
Route::apiResource('camiones', TruckControllerApi::class);
Route::apiResource('reporte', ReporteControllerApi::class);
Route::apiResource('ruta', RutaControllerApi::class);
Route::apiResource('trabajadores', CiudadanoControllerAPI::class);
Route::apiResource('administradores', CiudadanoControllerAPI::class);



