<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\AdministradorController;
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

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/estadisticas', function () {
        return view('adminPages.estadisticas');
    })->name('admin.estadisticas');

    // Usuarios
    Route::get('/usuarios', function () {
        return view('adminPages.usuarios');
    })->name('admin.usuarios');

    Route::get('/administradores/api', [AdministradorController::class, 'data'])
         ->name('admin.administradores.data');
    Route::resource('administradores', AdministradorController::class)
         ->names([
             'index'   => 'admin.administradores.index',
             'create'  => 'admin.administradores.create',
             'store'   => 'admin.administradores.store',
             'show'    => 'admin.administradores.show',
             'edit'    => 'admin.administradores.edit',
             'update'  => 'admin.administradores.update',
             'destroy' => 'admin.administradores.destroy',
         ]);

    // Rutas para trabajadores
    Route::get('/trabajadores/api', [TrabajadorController::class, 'data'])
         ->name('admin.trabajadores.data');
    Route::resource('trabajadores', TrabajadorController::class)
         ->names([
             'index'   => 'admin.trabajadores.index',
             'create'  => 'admin.trabajadores.create',
             'store'   => 'admin.trabajadores.store',
             'show'    => 'admin.trabajadores.show',
             'edit'    => 'admin.trabajadores.edit',
             'update'  => 'admin.trabajadores.update',
             'destroy' => 'admin.trabajadores.destroy',
         ]);

});


