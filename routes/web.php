<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SweepstakeController;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', [IndexController::class, 'getTablePage'])->name('index.table');
Route::get('/volante/{id}', [IndexController::class, 'getWheelPage'])->name('index.wheel');

Route::get('/login', [AdminController::class, 'getLoginPage'])->name('login');
Route::post('/login', [AdminController::class, 'postLogin'])->name('login.post');
Route::get('/logout', [AdminController::class, 'getLogoutUser'])->name('admin.logout');

Route::put('/participants/{id}/update/dozens', [ParticipantController::class, 'putParticipantDozens'])->name('participants.update.dozens');

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', [AdminController::class, 'getDashboardPage'])->name('admin.dashboard');
	Route::get('/participant/{id}/edit', [AdminController::class, 'getParticipantEditPage'])->name('participant.edit');

	Route::put('/sweepstakes', [SweepstakeController::class, 'putLatestSweepstake'])->name('sweepstakes.update');

	Route::get('/participants/csv', [ParticipantController::class, 'getParticipantsCsv'])->name('participants.csv');
	Route::post('/participants', [ParticipantController::class, 'postParticipant'])->name('participants.create');
	Route::put('/participants/reset', [ParticipantController::class, 'putResetParticipants'])->name('participants.reset');
	Route::put('/participants/{id}/update', [ParticipantController::class, 'putParticipant'])->name('participants.update');
	Route::delete('/participants/{id}/delete', [ParticipantController::class, 'deleteParticipant'])->name('participants.delete');
});

Route::get('/laravel', function () {
	return view('welcome');
});
