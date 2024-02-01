<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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

Route::get('/', [HomeController::class, 'showlogin'])->name('showlogin');
Route::post('/login', [HomeController::class, 'login'])->name('login');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/registraUsuario', [HomeController::class, 'registraUsuario'])->name('registraUsuario');
Route::post('/registro', [HomeController::class, 'registro'])->name('registro');

Route::middleware(['chktoken'])->group(function () {

Route::resource('productos', ProductController::class)->names('productos');
Route::get('/listaUsuarios', [HomeController::class, 'listaUsuarios'])->name('listaUsuarios');
Route::get('/muestraUsuario/{id}', [HomeController::class, 'muestraUsuario'])->name('muestraUsuario');
Route::get('/editaUsuario/{id}', [HomeController::class, 'editaUsuario'])->name('editaUsuario');
Route::put('/actualizaUsuario', [HomeController::class, 'actualizaUsuario'])->name('actualizaUsuario');
Route::delete('/eliminarUsuario/{id}', [HomeController::class, 'eliminarUsuario'])->name('eliminarUsuario');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

//Route::resource('productos', ProductController::class)->names('productos')->middleware('chktoken');


