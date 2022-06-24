<?php

use App\Http\Controllers\www\{HomeController, WelcomeController};
use App\Http\Livewire\Roms\Edit as RomsEdit;
use App\Http\Livewire\Roms\Index as RomsIndex;
use App\Http\Livewire\Roms\Show as RomsShow;
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
    Route::get('/roms', RomsIndex::class)->name('roms.index');
    Route::get('/roms/show/{romId}', RomsShow::class)->name('roms.show');
    Route::get('/roms/edit/{romId}', RomsEdit::class)->name('roms.edit')->middleware('admin');
    Route::patch('/roms/update/{romId}', [RomsEdit::class, 'update'])->name('roms.update');
});
