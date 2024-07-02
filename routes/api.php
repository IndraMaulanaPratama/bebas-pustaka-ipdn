<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SimilaritasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * Route kanggo authentication
 */
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


/** Route kanggo Similaritas */
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/similaritas/count/{status?}', [SimilaritasController::class, 'count']); // Ngetang jumlah data dumasar kana status (optional)
    Route::get('/similaritas/', [SimilaritasController::class, 'index']);
});
