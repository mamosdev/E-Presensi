<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(){
        $hariini = date("Y-m-d");
        $bulanini = date("m");
        $tahunini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik',$nik)->where('tanggal_presensi',$hariini)->first();
        $historybulanini = DB::table('presensi')->whereRaw('MONTH(tanggal_presensi)="' .$bulanini . '"')
        ->whereRaw('YEAR(tanggal_presensi)="' . $tahunini . '"')
        ->orderBy('tanggal_presensi')
        ->get();
        return view('dashboard.dashboard',compact('presensihariini','historybulanini'));
    }
}
