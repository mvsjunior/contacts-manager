<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ContactController;
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
Route::get('/people/show/{id}', [PersonController::class,'show'])->name('people.show');

Route::get('/people/create', [PersonController::class,'create'])->name('people.create');
Route::post('/people/create', [PersonController::class,'store'])->name('people.store');

Route::get('/people/edit/{id}/', [PersonController::class,'edit'])->name('people.edit');
Route::post('/people/update/{id}/', [PersonController::class,'update'])->name('people.update');

Route::post('/people/destroy/{id}/', [PersonController::class,'destroy'])->name('people.destroy');


//Contacts
Route::get('/contact', [ContactController::class,'index'])->name('contacts.index');
Route::get('/contact/show/{id}', [ContactController::class,'index'])->name('contacts.show');

Route::get('/contact/create', [ContactController::class,'create'])->name('contacts.create');
Route::post('/contact/create', [ContactController::class,'store'])->name('contacts.store');

Route::get('/contact/edit/{id}/', [ContactController::class,'edit'])->name('contacts.edit');
Route::post('/contact/update/{id}/', [ContactController::class,'update'])->name('contacts.update');

Route::post('/contact/destroy/{id}/', [ContactController::class,'destroy'])->name('contacts.destroy');