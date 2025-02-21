<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\ReporteController;
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
    Route::get('/ciudadanos/api', [CiudadanoController::class, 'data'])
         ->name('admin.ciudadanos.data');
    Route::resource('ciudadanos', CiudadanoController::class)
         ->names([
             'index'   => 'admin.ciudadanos.index',
             'create'  => 'admin.ciudadanos.create',
             'store'   => 'admin.ciudadanos.store',
             'show'    => 'admin.ciudadanos.show',
             'edit'    => 'admin.ciudadanos.edit',
             'update'  => 'admin.ciudadanos.update',
             'destroy' => 'admin.ciudadanos.destroy',
         ]);

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

        // Rutas para camiones
        Route::get('/trucks/api', [TruckController::class, 'data'])
        ->name('admin.trucks.data');
   Route::resource('trucks', TruckController::class)
        ->names([
            'index'   => 'admin.trucks.index',
            'create'  => 'admin.trucks.create',
            'store'   => 'admin.trucks.store',
            'show'    => 'admin.trucks.show',
            'edit'    => 'admin.trucks.edit',
            'update'  => 'admin.trucks.update',
            'destroy' => 'admin.trucks.destroy',
        ]);

        Route::get('/rutas/api', [RutasController::class, 'getRutas'])
        ->name('admin.rutas.getRutas');
       Route::resource('rutas', RutasController::class)
            ->names([
           'index'   => 'admin.rutas.index',
           'store' => 'admin.rutas.store',
           'destroy' => 'admin.rutas.destroy'
       ]);

       Route::get('/reportes/getPoints', [ReporteController::class, 'getPoints'])
       ->name('admin.reportes.getPoints');



});


