<?php

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

use Modules\User\Http\Controllers\DependentDropdownController;
use Modules\User\Http\Controllers\UserController;

Route::get('dependent-dropdown', [DependentDropdownController::class, 'index'])
    ->name('dependent-dropdown.index');
Route::post('dependent-dropdown', [DependentDropdownController::class, 'store'])
    ->name('dependent-dropdown.store');
Route::post('kecamatan', [DependentDropdownController::class, 'kecamatan'])
    ->name('dependent-dropdown.kecamatan');
Route::post('desa', [DependentDropdownController::class, 'desa'])
    ->name('dependent-dropdown.desa');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('user', 'UserController');
});

Route::get('/profil', [UserController::class, 'profile'])->name('profil')->middleware(['auth', 'verified']);
Route::patch('/profil',  [UserController::class, 'profile_update'])->name('profil.update')->middleware(['auth', 'verified']);
