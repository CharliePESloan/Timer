<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LoginController;

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

Route::redirect('/', 'project-list');
Route::get('login', function () {
    return view('login');
})->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->name('login-post');
Route::group(['middleware'=>['auth']], function () {
    Route::get('project-list', [ProjectController::class, 'projectList'])->name('project-list');
    Route::get('project-view/{id}', [ProjectController::class, 'projectView'])->name('project-view');
    Route::post('create-project', [ProjectController::class, 'createProject']);
    Route::get('delete-project/{id}', [ProjectController::class, 'deleteProject']);
    Route::post('start-timing/{id}', [ProjectController::class, 'startTiming']);
    Route::post('stop-timing/{id}', [ProjectController::class, 'stopTiming']);
    Route::get('undo-segment/{id}', [ProjectController::class, 'undoSegment']);
    Route::post('reset-total/{id}', [ProjectController::class, 'resetTotal']);
    Route::post('add-time/{id}', [ProjectController::class, 'addTime']);
    Route::get('cancel-timer/{id}', [ProjectController::class, 'cancelTimer']);
});
