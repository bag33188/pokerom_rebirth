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
Route::prefix('auth')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->middleware('guest');
    Route::post('/register', [UserController::class, 'register'])->middleware('guest');
});

// auth
Route::middleware('auth:sanctum')->group(function () {


    // general api routes
    Route::apiResources(['/roms' => RomController::class, '/games' => GameController::class]);
    Route::apiResource('/users', UserController::class)->only('index', 'show', 'destroy')
        ->parameter('user', 'userId');
    Route::apiResource('/rom-files', RomFileController::class)->only('index', 'show', 'destroy')
        ->parameter('file', 'fileId');

    // api route groups
    Route::prefix('auth')->group(function () {
        Route::get('/me', [UserController::class, 'showMe']);
        Route::post('/logout', [UserController::class, 'logout']);
    });
    Route::prefix('rom-files/grid')->group(function () {
        Route::get('/list', [RomFileActions::class, 'listStorageFiles'])->middleware('admin');
        Route::post('/upload', [RomFileController::class, 'upload']);
        Route::get('/{fileId}/download', [RomFileController::class, 'download']);
    });

    // relationships
    Route::get('/roms/{romId}/game', [RomController::class, 'indexGame']);
    Route::get('/roms/{romId}/file', [RomController::class, 'indexFile']);
    Route::get('/rom-files/{fileId}/rom', [RomFileController::class, 'indexRom']);
    Route::get('/games/{gameId}/rom', [GameController::class, 'indexRom']);
    Route::patch('/roms/{romId}/linkFile', [RomController::class, 'linkRomToFile']);
});

if (App::environment('local')) {
    Route::prefix('dev')->group(function () {
        // todo: find/add a way to send token to download link (in order to authenticate) (maybe use a POST request???)
        Route::get('/rom-files/grid/{fileId}/download', [RomFileController::class, 'download']);
        // Route::post('/rom-files/{fileId}/download', [FileController::class, 'download']);
    });
}
