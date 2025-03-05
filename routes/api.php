<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CiudadanoControllerAPI;

Route::apiResource('ciudadanos', CiudadanoControllerAPI::class);
Route::apiResource('trabajadores', CiudadanoControllerAPI::class);
Route::apiResource('administradores', CiudadanoControllerAPI::class);
