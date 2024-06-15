<?php

namespace App\Http\Controllers;

use App\Charts\ProgramChart;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Lokasi;
use App\Models\Mahasiswa;
use App\Models\ProgramKampus;
use App\Models\Role;
use App\Models\Studi;
use App\Models\User;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function admin(ProgramChart $programChart)
    {
        $role_op = Role::where("slug","operator")->first();

        $operator = User::where('role_id', $role_op->id)->count();
        $data = [
            'pengelola' => $operator,
            'mahasiswa' => Mahasiswa::all()->count(),
            'dosen' => Dosen::all()->count(),
            'mitra' => Guru::all()->count(),
            'program' => ProgramKampus::all()->count(),
            'lokasi' => Lokasi::all()->count(),
            'fakultas' => Fakultas::all()->count(),
            'jurusan' => Jurusan::all()->count(),
            'studi' => Studi::all()->count(),
            'programchart' => $programChart->build()

        ];
        return view('admin.superadmin.dashboard_superadmin')->with('data',$data);
    }
    
}
