<?php

use App\Http\Controllers\www\{HomeController, RomFileController, WelcomeController};
use App\Http\Livewire\Game\Create as CreateGame;
use App\Http\Livewire\Game\Edit as EditGame;
use App\Http\Livewire\Game\Index as IndexGame;
use App\Http\Livewire\Game\Show as ShowGame;
use App\Http\Livewire\Rom\Create as CreateRom;
use App\Http\Livewire\Rom\Edit as EditRom;
use App\Http\Livewire\Rom\Index as IndexRom;
use App\Http\Livewire\Rom\Show as ShowRom;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // laravel routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::prefix('rom-files')->group(function () {
        Route::get('/', [RomFileController::class, 'index'])->name('rom-files.index');
        Route::get('/info/{romFile}', [RomFileController::class, 'show'])->name('rom-files.show');
        Route::get('/create', [RomFileController::class, 'create'])->name('rom-files.create')->middleware('admin');
        Route::post('/store', [RomFileController::class, 'store'])->name('rom-files.store');
        Route::delete('/delete/{romFile}', [RomFileController::class, 'destroy'])->name('rom-files.delete');
        Route::post('/{romFile}/download', [RomFileController::class, 'download'])->name('rom-files.download');
    });
    // livewire routes
    Route::prefix('roms')->group(function () {
        Route::get('/', IndexRom::class)->name('roms.index');
        Route::get('/create', CreateRom::class)->name('roms.create')->middleware('admin');
        Route::get('/show/{romId}', ShowRom::class)->name('roms.show');
        Route::get('/edit/{romId}', EditRom::class)->name('roms.edit')->middleware('admin');
    });
    Route::prefix('games')->group(function () {
        Route::get('/', IndexGame::class)->name('games.index');
        Route::get('/create', CreateGame::class)->name('games.create')->middleware('admin');
        Route::get('/show/{gameId}', ShowGame::class)->name('games.show');
        Route::get('/edit/{gameId}', EditGame::class)->name('games.edit')->middleware('admin');
    });
});

