<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AdminController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', [IndexController::class , 'getTablePage'])->name('index.table');
Route::get('/volante/{id}', [IndexController::class , 'getWheelPage'])->name('index.wheel');


Route::get('/login', [AdminController::class , 'getLoginPage'])->name('admin.login');
Route::post('/login', [AdminController::class , 'postLogin'])->name('admin.login.post');

Route::get('/dashboard', [AdminController::class , 'getDashboardPage'])->middleware('admin.login')->name('admin.dashboard');
Route::get('/logout', [AdminController::class , 'getLogoutUser'])->name('admin.logout');


Route::get('/laravel', function () {
    return view('welcome');
});