<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () { return view('auth.login');});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/proseslogin', [AuthController::class, 'proseslogin']);