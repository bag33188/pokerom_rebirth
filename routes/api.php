<?php

use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\RomController;
use App\Http\Controllers\api\RomFileController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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
        'version' => config('app.version')
    ], HttpResponse::HTTP_OK))
    ->name('api.version');

// no auth
Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);
    });
});

// auth
Route::middleware('auth:sanctum')->group(function () {
    // api resource routes
    Route::apiResources([
        '/roms' => RomController::class,
        '/games' => GameController::class,
        '/users' => UserController::class
    ]);
    Route::apiResource('/rom-files', RomFileController::class)->only('index', 'show', 'destroy');

    // auth routes
    Route::prefix('auth')->group(function () {
        Route::get('/me', [UserController::class, 'showMe']);
        Route::post('/logout', [UserController::class, 'logout']);
    });

    // other rom-file routes
    Route::prefix('rom-files')->group(function () {
        // gridfs routes
        Route::prefix('grid')->group(function () {
            Route::get('/{romFileId}/download', [RomFileController::class, 'download']);
            Route::post('/upload', [RomFileController::class, 'upload']);
        });
        // storage routes
        Route::prefix('disk')->group(function () {
            Route::get('/list-files', [RomFileController::class, 'listFilesInRomFilesStorage']);
            Route::get('/list-roms', [RomFileController::class, 'listRomsInRomFilesStorage']);
        });
    });

    // relationships
    Route::get('/roms/{romId}/game', [RomController::class, 'indexGame']);
    Route::get('/roms/{romId}/file', [RomController::class, 'indexFile']);
    Route::get('/games/{gameId}/rom', [GameController::class, 'indexRom']);
    Route::get('/rom-files/{romFileId}/rom', [RomFileController::class, 'indexRom']);
    // relationship actions
    Route::patch('/roms/{romId}/link-file', [RomController::class, 'linkRomToFile']);
});


// experimental routes (debug only)
if (App::environment('local')) {
    Route::prefix('dev')->group(function () {
        Route::get('/rom-files/grid/{romFileId}/download', [RomFileController::class, 'download'])
            ->name('api.dev.rom-files.download');
    });
}

# \DB::connection('mongodb')->table('rom_files.info')->get();
