<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('login', function (){
    return view('login');
})->name('login');

Route::post('login',  [ AuthController::class, 'login']);

Route::get('loginAdmin', function (){
    return view('loginAdmin');
})->name('loginAdmin');


Route::post('loginAdmin', [AuthController::class, 'login'])->defaults('role', 'admin');


Route::get('signUp', function (){
    return view('signUp');
});

Route::post('signUp',  [ AuthController::class, 'register']);

Route::get('logOut' ,[ AuthController::class, 'logout'] )->name('logOut');


Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', fn() =>view('dashboard.dashboardUser'))
        ->name('dashboard');
});

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {              
        Route::get('/dashboard', fn() => view('dashboard.dashboardAdmin'))
            ->name('dashboard');
});

