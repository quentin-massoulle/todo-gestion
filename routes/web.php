<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function (){
    return view('login');
});
Route::post('login',  [ AuthController::class, 'login']);


Route::get('signUp', function (){
    return view('signUp');
});
Route::post('signUp',  [ AuthController::class, 'register']);

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboardUser');
    })->name('dashboard');
});
