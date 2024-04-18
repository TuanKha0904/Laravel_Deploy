<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('search');
Route::get('/login/yahoo/callback', [LoginController::class, 'yahooLogin'])->name('login.yahoo.callback');

Route::get('/login/twitter/callback', [LoginController::class, 'twitterLogin'])->name('login.twitter.callback');
Route::get('/employee', [EmployeeController::class, 'index']);

