<?php

use App\Http\Controllers\www\{HomeController, WelcomeController};
use App\Http\Livewire\Game\Create as CreateGame;
use App\Http\Livewire\Game\Delete as DeleteGame;
use App\Http\Livewire\Game\Edit as EditGame;
use App\Http\Livewire\Game\Index as IndexGame;
use App\Http\Livewire\Game\Show as ShowGame;
use App\Http\Livewire\Rom\Create as CreateRom;
use App\Http\Livewire\Rom\Delete as DeleteRom;
use App\Http\Livewire\Rom\Edit as EditRom;
use App\Http\Livewire\Rom\Index as IndexRom;
use App\Http\Livewire\Rom\Show as ShowRom;
use App\Http\Livewire\RomFile\Upload as UploadRomFile;
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
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::prefix('roms')->group(function () {
        Route::get('/', IndexRom::class)->name('roms.index');
        Route::get('/create', CreateRom::class)->name('roms.create')->middleware('admin');
//        Route::post('/store', [CreateRom::class, 'store'])->name('roms.store');
        Route::get('/show/{romId}', ShowRom::class)->name('roms.show');
        Route::get('/edit/{romId}', EditRom::class)->name('roms.edit')->middleware('admin');
//        Route::put('/update/{romId}', [EditRom::class, 'update'])->name('roms.update');
        Route::delete('/delete/{romId}', [DeleteRom::class, 'delete'])->name('roms.delete');
    });
    Route::prefix('games')->group(function () {
        Route::get('/', IndexGame::class)->name('games.index');
        Route::get('/create', CreateGame::class)->name('games.create')->middleware('admin');
        Route::get('/show/{gameId}', ShowGame::class)->name('games.show');
        Route::get('/edit/{gameId}', EditGame::class)->name('games.edit')->middleware('admin');
//        Route::put('/update/{gameId}', [EditGame::class, 'update'])->name('games.update');
        Route::delete('/delete/{gameId}', [DeleteGame::class, 'delete'])->name('games.delete');
    });
    Route::prefix('files')->group(function () {
        Route::get('/create', UploadRomFile::class)->name('files.create')->middleware('admin');
        Route::post('/store', [UploadRomFile::class, 'upload'])->name('files.store');
    });
});
