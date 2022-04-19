<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\BoardController;
use App\Http\Controllers\V1\BoardListController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });
    Route::prefix('board')->group(function () {
        Route::post('/', [BoardController::class, 'create']);
        Route::get('/', [BoardController::class, 'getAllBoards']);
        Route::get('/{id}', [BoardController::class, 'getBoardDetail']);
        Route::post('/{board_id}/list', [BoardListController::class, 'create']);
        Route::put('/{board_id}/list', [BoardListController::class, 'update']);

    });
});

