<?php

use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\RomController;
use App\Http\Controllers\API\RomFileController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\JsonResponse;
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

Route::get('version', fn() => response()
    ->json([
        'success' => true,
        'version' => config('app.version')
    ], HttpResponse::HTTP_OK))
    ->name('api.version');

Route::name('api.')->group(function () {
    // no auth
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', [UserController::class, 'login'])->name('login');
        Route::post('register', [UserController::class, 'register'])->name('register');
    });

    // sanctum auth
    Route::middleware('auth:sanctum')->group(function () {
        // api resource routes
        Route::apiResources([
            'roms' => RomController::class,
            'games' => GameController::class,
            'users' => UserController::class
        ]);
        Route::apiResource('rom-files', RomFileController::class)->only(['index', 'show', 'destroy'])
            ->names([
                'index' => 'rom-files.index',
                'show' => 'rom-files.show',
                'destroy' => 'rom-files.destroy'
            ]);

        // auth routes
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::get('me', [UserController::class, 'showMe'])->name('me');
            Route::get('token', [UserController::class, 'getCurrentUserBearerToken'])->name('token');
            Route::post('logout', [UserController::class, 'logout'])->name('logout');
        });

        // other rom-file routes
        Route::prefix('rom-files')->name('rom-files.')->group(function () {
            // gridfs routes
            Route::prefix('grid')->name('grid.')->group(function () {
                Route::get('{romFileId}/download', [RomFileController::class, 'download'])->name('download');
                Route::post('upload', [RomFileController::class, 'upload'])->name('upload');
            });
            // storage routes
            Route::prefix('disk')->name('disk.')->group(function () {
                Route::get('list-files', [RomFileController::class, 'listFilesInRomFilesStorage'])->name('list-files');
                Route::get('list-roms', [RomFileController::class, 'listRomsInRomFilesStorage'])->name('list-roms');
            });
            // rom files metadata
            Route::get('metadata/all', function (): ?JsonResponse {
                Gate::authorize('viewAny-romFile');
                if (Request::acceptsJson()) {
                    $columns = array('filename', 'filetype', 'filesize');
                    $data = DB::connection('mongodb')->table('rom_files.info')->get($columns);
                    return Response::json(['success' => true, 'data' => $data->chunk(10)], HttpResponse::HTTP_OK);
                }
                return null;
            })->name('metadata.all');
        });

        // relationships
        Route::name('relations.')->group(function () {
            Route::get('roms/{romId}/game', [RomController::class, 'indexGame'])->name('roms.game');
            Route::get('roms/{romId}/rom-file', [RomController::class, 'indexRomFile'])->name('roms.rom-file');
            Route::get('games/{gameId}/rom', [GameController::class, 'indexRom'])->name('games.rom');
            Route::get('rom-files/{romFileId}/rom', [RomFileController::class, 'indexRom'])->name('rom-files.rom');
            // actions
            Route::patch('roms/{romId}/link-romFile', [RomController::class, 'linkRomToRomFile'])->name('roms.link-romFile');
        });
    });
});

if (App::environment('local', 'debug')) {
    Route::prefix('dev')->name('api.dev.')->group(function () {
        Route::get('roms', [RomController::class, 'index'])->name('roms.index');
        Route::get('rom-files/{romFileId}/download', [RomFileController::class, 'download'])->name('rom-files.download');
    });
}
