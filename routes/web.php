<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;


Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () { return view('auth.login');})->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);

});

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);
    
    //Presensi
    Route::get('/presensi/create',[PresensiController::class, 'create']);
    Route::post('/presensi/store',[PresensiController::class, 'store']);
    
    //Edit Profile
    Route::get('/editprofile',[PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nik}/updateprofile',[PresensiController::class, 'updateprofile']);
    
    //History
    Route::get('/presensi/history',[PresensiController::class, 'history']);
    Route::post('/gethistory', [PresensiController::class, 'getHistory']);

    
    //Izin
    Route::get('/presensi/izin',[PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin',[PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin',[PresensiController::class, 'storeizin']);
    
});