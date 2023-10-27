<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BattleshipGame;
use App\Http\Controllers\BattleshipGameBoard;
use App\Http\Controllers\BattleshipGameMove;
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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('game', BattleshipGame::class)->except(['destroy']);
    Route::apiResource('game.board', BattleshipGameBoard::class)->only(['index', 'store']);
    Route::apiResource('game.move', BattleshipGameMove::class)->only(['index', 'store']);
});