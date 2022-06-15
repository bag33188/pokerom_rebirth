<?php

use App\Http\Controllers\www\HomeController;
use App\Http\Controllers\www\WelcomeController;
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

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/roms', App\Http\Livewire\Roms\Index::class)->name('roms.index');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});
