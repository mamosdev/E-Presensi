<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if (Auth::guard('karyawan')->attempt(['nik' => $request->nik, 'password' => $request->password])) {
            //Berhasil Login
            return redirect('/dashboard');
        }
        else {
            //Gagal Login
            return redirect('/')->with(['warning' =>'NIK / Password Salah']);
            
        }
    }

    public function proseslogout(){
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            redirect('/');
            
        }
    }
}
