<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PatientController::class)
->prefix('patient')
->name('patient.')
->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/', 'destroy')->name('destroy');
    Route::get('/{id}', 'pdf')->name('pdf');
    Route::post('/xls', 'excel')->name('excel');
});

Route::prefix('v1')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::get('index', [UserController::class, 'index']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('profile', [UserController::class, 'getProfile']);
        Route::put('update-profile', [UserController::class, 'updateProfile']);
        Route::put('change', [UserController::class, 'changePassword']);
    });
    Route::post('password-forgot', [UserController::class, 'forgotPassword']);
    Route::post('password-reset', [UserController::class, 'resetPassword'])->name('password.reset');    
});