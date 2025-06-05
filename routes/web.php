<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\taskController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckRoute;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\MessageController;



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
    Route::get('/tasks',[taskController::class,'viewsTasks'])->name('tasks');
    Route::post('/tasks/{id}/update-etat', [TaskController::class, 'updateEtat'])
    ->where('id','[1-9][0-9]*') 
    ->name('tasks.updateEtat');
    Route::get('/task/0',fn()=> view('task.taskShow'))->name('newTask');
    Route::post('/task/0',[taskController::class , 'store']);
    Route::get('/task/{id}',[taskController::class,'showTask'])
        ->where('id','[1-9][0-9]*')
        ->name('task.show');
        Route::post('/task/{id}',[taskController::class , 'store']);
    Route::get('/groupes',[GroupeController::class,'index'])->name('groupes');
});

Route::middleware('auth')->prefix('groupe')->name('groupe.')->group(function () {
    Route::get('/{id}',[GroupeController::class,'show']);
});

Route::middleware('auth')->prefix('message')->name('message.')->group(function () {
    Route::post('addMessageGroupe',[MessageController::class,'storeGroupe']);
    Route::get('getMessageGroupe',[MessageController::class,'getGroupe']);
});




Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {              
        Route::get('/dashboard', fn() => view('dashboard.dashboardAdmin'))
            ->name('dashboard');
});


