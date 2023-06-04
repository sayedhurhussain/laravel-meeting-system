<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::controller(MeetingController::class)->prefix('meetings')->group(function () {
        Route::get('/', 'index')->name('meetings.index');
        Route::get('/create', 'create')->name('meetings.create');
        Route::post('/', 'store')->name('meetings.store');
        Route::get('/show/{id}', 'show')->name('meetings.show');
        Route::get('/edit/{id}', 'edit')->name('meetings.edit');
        Route::post('/update/{id}', 'update')->name('meetings.update');
    });
});
