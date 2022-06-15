<?php

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FileController;
use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\RomController;
use Illuminate\Support\Facades\Route;

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

Route::get('/version', fn() => response()
    ->json([
        'version' => floatval(config('app.version'))
    ], 202))
    ->name('api.version');

// no auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});

// auth
Route::middleware('auth:sanctum')->group(function () {
    // general api routes
    Route::apiResources(['/roms' => RomController::class, '/games' => GameController::class],
        ['parameters' => [
            'roms' => 'romId',
            'games' => 'gameId'
        ]]
    );
    Route::apiResource('/users', UserController::class)->only('index', 'show', 'destroy')
        ->parameter('user', 'userId');
    Route::apiResource('/files', FileController::class)->only('index', 'show', 'destroy')
        ->parameter('file', 'fileId');

    // custom api routes
    Route::prefix('auth')->group(function () {
        Route::get('/me', [UserController::class, 'showMe']);
        Route::post('/logout', [UserController::class, 'logout']);
    });
    Route::prefix('files')->group(function () {
        Route::post('/upload', [FileController::class, 'upload']);
        Route::get('/{fileId}/download', [FileController::class, 'download']);
    });

    // relationships
    Route::get('/roms/{romId}/game', [RomController::class, 'indexGame']);
    Route::get('/roms/{romId}/file', [RomController::class, 'indexFile']);
    Route::get('/files/{fileId}/rom', [FileController::class, 'indexRom']);
    Route::get('/games/{gameId}/rom', [GameController::class, 'indexRom']);
    Route::patch('/roms/{romId}/linkFile', [RomController::class, 'linkRomToFile']);
});

if (App::environment('local')) {
    Route::prefix('dev')->group(function () {
        // todo: find/add a way to send token to download link (in order to authenticate)
        Route::get('/files/{fileId}/download', [FileController::class, 'download']);
    });
}
