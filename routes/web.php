<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index']);
Route::get('/dashboard', [LoginController::class, 'dashBoard']);
Route::get('/login/yahoo/callback', [LoginController::class, 'yahooLogin'])->name('login.yahoo.callback');

Route::get('/login/twitter/callback', [LoginController::class, 'twitterLogin'])->name('login.twitter.callback');
