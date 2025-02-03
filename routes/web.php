<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrabajadorController;

use Illuminate\Support\Facades\Auth;

// Ruta principal
Route::get('/', function () {
    Auth::logout();
    return view('index');
});
Route::get('/login', function () {
    return view('index');
})->name('login');
// Logout (ya solo una vez)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta protegida para admin
Route::get('/estadisticas', function () {
    // Verifica si el usuario está autenticado
    if (Auth::check()) {
        return view('adminPages.estadisticas');
    } else {
        // Si no está autenticado, redirige a la página principal
        return redirect('/')->with('error', 'Debes iniciar sesión para acceder a esta página.');
    }
})->name('estadisticas')->middleware('auth');

Route::get('/usuarios', function () {
    // Verifica si el usuario está autenticado
    if (Auth::check()) {
        return view('adminPages.usuarios');
    } else {
        // Si no está autenticado, redirige a la página principal
        return redirect('/')->with('error', 'Debes iniciar sesión para acceder a esta página.');
    }
})->name('usuarios')->middleware('auth');

Route::get('/trabajadores', function () {
    // Verifica si el usuario está autenticado
    if (Auth::check()) {
        return view('adminPages.trabajadores');
    } else {
        // Si no está autenticado, redirige a la página principal
        return redirect('/')->with('error', 'Debes iniciar sesión para acceder a esta página.');
    }
})->name('trabajadores')->middleware('auth');

Route::get('trabajadores/api', [TrabajadorController::class, 'data'])->name('trabajadores.data');
