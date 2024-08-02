<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BebidaController;

use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\OrdenController;

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\SucursalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    
    Route::get('/dashboard-datos', [DashboardController::class, 'obtenerDatosDashboard']);
    
    
    Route::get('/corte', [DashboardController::class, 'corte'])->name('corte');


    Route::get('/sucursales', [SucursalController::class, 'sucursales'])->name('sucursales');
    Route::post('/sucursales', [SucursalController::class, 'store'])->name('sucursales.store');

    Route::put('/sucursales/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');
    Route::delete('/sucursales/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');
    
    Route::get('/datos-filtrados', [OrdenController::class, 'datosfiltrados']);
    
    Route::get('/inventario', [DashboardController::class, 'inventario'])->name('inventario');
    Route::get('/ingrediBebidas', [IngredienteController::class, 'ingrediBebidas'])->name('ingrediBebidas');

    Route::get('/ordens', [OrdenController::class, 'index']);
    Route::post('/ordens', [OrdenController::class, 'store']);
    Route::put('/ordens/{id}', [OrdenController::class, 'update']);
    
    
    Route::post('/inventario', [InventarioController::class, 'store']);

    Route::put('/inventario/{id}', [InventarioController::class, 'update']);
    
    
    Route::post('/ingredientes', [IngredienteController::class, 'agregarIngrediente'])->name('ingredientes.agregar');
    Route::put('/ingredientes/{id}', [IngredienteController::class, 'editarIngrediente'])->name('ingredientes.editar');
    Route::delete('/ingredientes/{id}', [IngredienteController::class, 'eliminarIngrediente'])->name('ingredientes.eliminar');
    Route::post('/bebidas', [IngredienteController::class, 'agregarBebida'])->name('bebidas.agregar');
    Route::put('/bebidas/{id}', [IngredienteController::class, 'editarBebida'])->name('bebidas.editar');
    Route::delete('/bebidas/{id}', [IngredienteController::class, 'eliminarBebida'])->name('bebidas.eliminar');
    
    Route::post('/categorias', [CategoriasController::class, 'store']);

    Route::post('/items', [ItemsController::class, 'store']);
    Route::put('/items/{id}', [ItemsController::class, 'update']);
    Route::delete('/items/{id}', [ItemsController::class, 'destroy']);
    
});



