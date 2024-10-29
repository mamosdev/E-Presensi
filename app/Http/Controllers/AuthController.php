<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        $pass = 12345678;
        echo Hash::make($pass);
    }
}
