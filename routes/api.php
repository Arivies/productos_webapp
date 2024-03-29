<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('registro', [AuthenticationController::class, 'store']);
Route::post('login', [AuthenticationController::class, 'login']);



Route::middleware('auth:api')->group(
    function(){
       Route::get('index', [AuthenticationController::class, 'index']);
       Route::post('logout', [AuthenticationController::class, 'logout']);
       Route::post('show/{id}', [AuthenticationController::class, 'show']);
       Route::post('edit/{id}', [AuthenticationController::class, 'edit']);
       Route::put('actualiza/{id}', [AuthenticationController::class, 'actualiza']);
       Route::delete('elimina/{id}', [AuthenticationController::class, 'elimina']);
    }
);

