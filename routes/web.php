<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\taskController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckRoute;



Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin === 'true') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return view('welcome');
})->name('/');

Route::get('login', function (){
    if (Auth::check()) {
        if (Auth::user()->is_admin === 'true') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return view('login');
})->name('login');

Route::post('login',  [ AuthController::class, 'login']);

Route::get('loginAdmin', function (){
    if (Auth::check()) {
        if (Auth::user()->is_admin === 'true') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
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
    Route::get('/tasks',[taskController::class,'viewsTask'])->name('tasks');
    Route::get('/task/0',fn()=> view('task.newTask'))->name('newTask');
    Route::post('/task/0',[taskController::class , 'store']);
});

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {              
        Route::get('/dashboard', fn() => view('dashboard.dashboardAdmin'))
            ->name('dashboard');
});


