<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'admin','middleware' =>['admin','auth']], function(){
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');    
});

Route::group(['prefix'=>'user','middleware' =>['user','auth']], function(){
   Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
});