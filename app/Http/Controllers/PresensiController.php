<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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
        //seting lokasi kantor manual (Pake Koordinat MAN)
        // $latitudekantor = -7.540059309844185;
        // $longitudekantor = 110.82576449824755;

        //setting lokasi manual dirumah (pake koordinat rumah
        $latitudekantor = -7.529307425169945;
        $longitudekantor = 110.82477752242694;

        $lokasiuser = explode(",",$lokasi);
        $latitudeuser = $lokasiuser[0]; 
        $longitudeuser = $lokasiuser[1]; 

        $jarak = $this->distance($latitudekantor,$longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak ["meters"]);

        $cek = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nik', $nik)->count();
        if ($cek > 0) {
            $ket = "out";
        }else {
            $ket = "in";
        }
        $image = $request->image;

        $folderPath = "public/uploads/absensi/";
        $formatName = $nik."-".$tanggal_presensi . "-" . $ket;
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

        if ($radius > 200) {
            echo "Error|Maaf, Anda sedang diluar jangkauan radius, Jarak anda ".$radius." meter dari kantor|radius";
        }

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

    //Menghitung Jarak radius kooordinat
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view ('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        }
        else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];   
        }

        $update = DB::table('karyawan')->where('nik',$nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->back()->with(['success' => 'Berhasil Update Data']); 
        }
        else {
            return redirect()->back()->with(['error' => 'Gagal Update Data']);
        }
    }
}
