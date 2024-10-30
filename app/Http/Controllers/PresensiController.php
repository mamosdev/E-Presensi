<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tanggal_presensi', $hariini)->where('nik', $nik)->count();
        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $image = $request->image;

        $folderPath = "public/uploads/absensi/";
        $formatName = $nik."-".$tanggal_presensi;
        $image_parts = explode(";base64" , $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        $data = [
            'nik' => $nik,
            'tanggal_presensi' => $tanggal_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi

        ];

        $cek = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nik', $nik)->count();
        if ($cek > 0) {
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi

            ];
            $update = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nik', $nik)->update($data_pulang);
            if ($update) {
                echo "Success|Terimakasih, Hati hati dijalan|out";
                Storage::put($file, $image_base64);
            }
            else {
            echo "Error|Maaf Gagal Absen, Silahkan Hubungi IT|out";
            }
        
        }
        else{
            $data_masuk = [
            'nik' => $nik,
            'tanggal_presensi' => $tanggal_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi

            ];
            $simpan = DB::table('presensi')->insert($data_masuk);
            if ($simpan) {
                echo "Success|Terimakasih, Selamat Bekerja|in";
                Storage::put($file, $image_base64);
            }
            else {
                echo "Error|Maaf Gagal Absen, Silahkan Hubungi IT|in";
            }
    }
    }
}
