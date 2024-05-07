<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{


    public function getProvinsi()
    {
        $provinsi = Province::all();
        return response()->json($provinsi);
    }

    public function getKabupaten($idProvinsi)
    {
        $kabupaten = Regency::where('province_id',$idProvinsi)->get();
        return response()->json($kabupaten);
    }

    public function getKecamatan($idKabupaten)
    {
        $kecamatan = District::where('regency_id',$idKabupaten)->get();
        return response()->json($kecamatan);
    }

    public function getKelurahan($idKelurahan)
    {
        $kecamatan = Village::where('district_id',$idKelurahan)->get();
        return response()->json($kecamatan);
    }
}
