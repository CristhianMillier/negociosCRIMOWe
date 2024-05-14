<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DniController;
use App\Http\Controllers\RucController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CajaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', [HomeController::class, 'index'])->name('panel');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::resource('clientes', ClienteController::class);
Route::resource('proveedores', ProveedoreController::class);
Route::resource('marcas', MarcaController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('compras', CompraController::class);
Route::resource('ventas', VentaController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('profile', ProfileController::class);
Route::resource('cajas', CajaController::class);

Route::get('/consultar-dni/{dni}', [DniController::class, 'consultarDni'])->name('consultar-dni');
Route::get('/consultar-ruc/{ruc}', [RucController::class, 'consultarRuc'])->name('consultar-ruc');