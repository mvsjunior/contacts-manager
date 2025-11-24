<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home.index');

// Auth
Route::get('/login', [AuthenticatedSessionController::class,'index'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class,'auth'])->name('login.auth');
Route::get('/logout', [AuthenticatedSessionController::class,'logout'])->name('logout');

// People
Route::get('/people', [PersonController::class,'index'])->name('people.index');
Route::get('/people/show/{id}', [PersonController::class,'index'])->name('people.show');

Route::get('/people/create', [PersonController::class,'create'])->name('people.create');
Route::post('/people/create', [PersonController::class,'store'])->name('people.store');

Route::get('/people/edit/{id}/', [PersonController::class,'edit'])->name('people.edit');
Route::post('/people/update/{id}/', [PersonController::class,'update'])->name('people.update');

Route::post('/people/destroy/{id}/', [PersonController::class,'destroy'])->name('people.destroy');