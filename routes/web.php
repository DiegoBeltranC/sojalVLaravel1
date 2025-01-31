<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('/estadisticas', function () {
    return view('estadisticas');
});
