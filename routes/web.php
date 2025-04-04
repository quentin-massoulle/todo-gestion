<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logIn', function (){
    return view('login');
});
Route::post('logIn',  [ AuthController::class, 'login']);


Route::get('signUp', function (){
    return view('signUp');
});
Route::post('signUp',  [ AuthController::class, 'register']);

Route::get('logOut' ,[ AuthController::class, 'logout'] )->name('logOut');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboardUser');
    })->name('dashboard');
});
