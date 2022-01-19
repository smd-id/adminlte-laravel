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

use Modules\Role\Http\Controllers\PermissionController;
use Modules\Role\Http\Controllers\RoleController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('role', 'RoleController', ['only' => ['index', 'store', 'edit', 'destroy']]);
    Route::resource('permission', 'PermissionController', ['only' => ['index','store', 'edit', 'destroy']]);
});
