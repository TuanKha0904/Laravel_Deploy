<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EmployeeController::class, 'index']);
Route::get('/login/yahoo/callback', [LoginController::class, 'yahooLogin'])->name('login.yahoo.callback');

Route::get('/login/twitter/callback', [LoginController::class, 'twitterLogin'])->name('login.twitter.callback');

