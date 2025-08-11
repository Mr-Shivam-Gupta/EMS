<?php

use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;


Route::get('/setup/requirements', [SetupController::class, 'check'])->name('setup.requirements');

Route::group(['prefix' => 'setup', 'middleware' => ['check.requirement']], function () {
    Route::get('/', [SetupController::class, 'index'])->name('setup.index');
    Route::post('/database', [SetupController::class, 'saveDatabase'])->name('setup.db');
    Route::get('/admin', [SetupController::class, 'adminForm'])->name('setup.admin');
    Route::post('/admin', [SetupController::class, 'saveAdmin'])->name('setup.admin.save');
});
Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('check.installed');
