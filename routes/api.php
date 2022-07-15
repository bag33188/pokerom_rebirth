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

Route::name('api.')->group(function () {
    // no auth
    Route::name('auth.')->prefix('auth')->group(function () {
        Route::post('/login', [UserController::class, 'login'])->name('login');
        Route::post('/register', [UserController::class, 'register'])->name('register');
    });

    // auth
    Route::middleware('auth:sanctum')->group(function () {
        // api resource routes
        Route::apiResources([
            '/roms' => RomController::class,
            '/games' => GameController::class,
            '/users' => UserController::class
        ]);
        Route::apiResource('/rom-files', RomFileController::class)->only(['index', 'show', 'destroy'])
            ->names([
                'index' => 'rom-files.index',
                'show' => 'rom-files.show',
                'destroy' => 'rom-files.destroy'
            ]);

        // auth routes
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::get('/me', [UserController::class, 'showMe'])->name('me');
            Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        });

        // other rom-file routes
        Route::prefix('rom-files')->name('rom-files.')->group(function () {
            // gridfs routes
            Route::prefix('grid')->name('grid.')->group(function () {
                Route::get('/{romFileId}/download', [RomFileController::class, 'download'])->name('download');
                Route::post('/upload', [RomFileController::class, 'upload'])->name('upload');
            });
            // storage routes
            Route::prefix('disk')->name('disk.')->group(function () {
                Route::get('/list-files', [RomFileController::class, 'listFilesInRomFilesStorage'])->name('list-files');
                Route::get('/list-roms', [RomFileController::class, 'listRomsInRomFilesStorage'])->name('list-roms');
            });

            // rom files metadata
            Route::get('/metadata/all', function () {
                $columns = array('filename', 'filetype', 'filesize');
                return Response::json(DB::connection('mongodb')->table('rom_files.info')->get($columns));
            })->middleware('admin')->name('metadata.all');
        });

        // relationships
        Route::name('relations.')->group(function () {
            Route::get('/roms/{romId}/game', [RomController::class, 'indexGame'])->name('roms.game');
            Route::get('/roms/{romId}/rom-file', [RomController::class, 'indexRomFile'])->name('roms.rom-file');
            Route::get('/games/{gameId}/rom', [GameController::class, 'indexRom'])->name('games.rom');
            Route::get('/rom-files/{romFileId}/rom', [RomFileController::class, 'indexRom'])->name('rom-files.rom');
            // relationship actions
            Route::patch('/roms/{romId}/link-romFile', [RomController::class, 'linkRomToRomFile'])->name('roms.link-romFile');
        });

    });

    // experimental routes (debug only)
    if (App::environment('local')) {
        Route::prefix('dev')->name('dev.')->group(function () {
            Route::get('/rom-files/grid/{romFileId}/download', [RomFileController::class, 'download'])
                ->name('rom-files.grid.download');
        });
    }
});
