<?php

use App\Actions\RomFileActions;
use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\RomController;
use App\Http\Controllers\api\RomFileController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
    ], ResponseAlias::HTTP_OK))
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
    // general api routes
    Route::apiResources(['/roms' => RomController::class, '/games' => GameController::class]);
    Route::apiResource('/users', UserController::class)->only('index', 'show', 'destroy')
        ->parameter('user', 'userId');
    Route::apiResource('/rom-files', RomFileController::class)->only('index', 'show', 'destroy')
        ->parameter('file', 'romFileId');

    // api route groups
    Route::prefix('auth')->group(function () {
        Route::get('/me', [UserController::class, 'showMe']);
        Route::post('/logout', [UserController::class, 'logout']);
    });
    Route::prefix('rom-files/grid')->group(function () {
        Route::get('/list', [RomFileActions::class, 'listStorageFiles'])->middleware('admin');
        Route::post('/upload', [RomFileController::class, 'upload']);
        Route::get('/{romFileId}/download', [RomFileController::class, 'download']);
    });

    // relationships
    Route::get('/roms/{romId}/game', [RomController::class, 'indexGame']);
    Route::get('/roms/{romId}/file', [RomController::class, 'indexFile']);
    Route::get('/rom-files/{romFileId}/rom', [RomFileController::class, 'indexRom']);
    Route::get('/games/{gameId}/rom', [GameController::class, 'indexRom']);
    Route::patch('/roms/{romId}/linkFile', [RomController::class, 'linkRomToFile']);
});


Route::post('/rom-files/grid/{romFileId}/download', [RomFileController::class, 'download'])
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->name('api.rom-files.download');

if (App::environment('local')) {
    Route::prefix('dev')->group(function () {
        Route::get('/rom-files/grid/{romFileId}/download', [RomFileController::class, 'download']);
    });
}
