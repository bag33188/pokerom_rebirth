<?php

use App\Http\Controllers\www\{HomeController, WelcomeController};
use App\Http\Livewire\Game\Delete as GameDelete;
use App\Http\Livewire\Game\Edit as GameEdit;
use App\Http\Livewire\Game\Index as GameIndex;
use App\Http\Livewire\Game\Show as GameShow;
use App\Http\Livewire\Game\Store as GameStore;
use App\Http\Livewire\Rom\Delete as RomDelete;
use App\Http\Livewire\Rom\Edit as RomEdit;
use App\Http\Livewire\Rom\Index as RomIndex;
use App\Http\Livewire\Rom\Show as RomShow;
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

Route::get('/', [WelcomeController::class, 'renderIndex'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'renderDashboard'])->name('dashboard');
    Route::prefix('roms')->group(function () {
        Route::get('/', RomIndex::class)->name('roms.index');
        Route::get('/show/{romId}', RomShow::class)->name('roms.show');
        Route::get('/edit/{romId}', RomEdit::class)->name('roms.edit')->middleware('admin');
        Route::put('/update/{romId}', [RomEdit::class, 'update'])->name('roms.update');
        Route::delete('/delete/{romId}', [RomDelete::class, 'delete'])->name('roms.delete');
    });
    Route::prefix('games')->group(function () {
        Route::get('/', GameIndex::class)->name('games.index');
        Route::get('/add', GameStore::class)->name('games.add')->middleware('admin');
        Route::get('/show/{gameId}', GameShow::class)->name('games.show');
        Route::get('/edit/{gameId}', GameEdit::class)->name('games.edit')->middleware('admin');
        Route::put('/update/{gameId}', [GameEdit::class, 'update'])->name('games.update');
        Route::delete('/delete/{gameId}', [GameDelete::class, 'delete'])->name('games.delete');
    });
});
