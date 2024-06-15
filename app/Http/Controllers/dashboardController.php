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
use App\Models\News; 
use App\Models\CategoryNews;
use App\Models\Lowongan;
use App\Models\ProgramTransaction;
use App\Models\DPL;
use App\Models\MitraTransaction;




use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function admin(ProgramChart $programChart)
    {
        $role_op = Role::where("slug","operator")->first();

        $operator = User::where('role_id', $role_op->id)->count();
        $peminat = ProgramTransaction::where('status_mahasiswa', 0)->count();
        $peserta = ProgramTransaction::where('status_mahasiswa', true)->count();

        
        $data = [
            'masters' => [
                [
                    'label' => 'Program KM',
                    'count' => ProgramKampus::all()->count(),
                    'icon' => 'fas fa-window-restore',
                ],
                [
                    'label' => 'Fakultas',
                    'count' => Fakultas::all()->count(),
                    'icon' => 'fas fa-university',
                ],
                [
                    'label' => 'Jurusan',
                    'count' => Jurusan::all()->count(),
                    'icon' => 'fas fa-book',
                ],
                [
                    'label' => 'Program Studi',
                    'count' => Studi::all()->count(),
                    'icon' => 'fas fa-book-reader',
                ],
                [
                    'label' => 'Lokasi',
                    'count' => Lokasi::all()->count(),
                    'icon' => 'fas fa-map-marker-alt',
                ],
            ],
            'users' => [
                [
                    'label' => 'Dosen',
                    'count' => Dosen::all()->count(),
                    'icon' => 'fas fa-chalkboard-teacher',
                ],
                [
                    'label' => 'Mahasiswa',
                    'count' => Mahasiswa::all()->count(),
                    'icon' => 'fas fa-user-graduate',
                ],
                [
                    'label' => 'Mitra',
                    'count' => Guru::all()->count(),
                    'icon' => 'fas fa-handshake',
                ],
                [
                    'label' => 'Pengelola',
                    'count' => $operator,
                    'icon' => 'fas fa-user-tie',
                ],
            ],
            'news' => [
                [
                    'label' => 'Berita',
                    'count' => News::all()->count(),
                    'icon' => 'fas fa-newspaper',
                ],
                [
                    'label' => 'Kategori Berita',
                    'count' => CategoryNews::all()->count(),
                    'icon' => 'fas fa-list',
                ],
            ],
            'mbkm' => [
                [
                    'label' => 'Lowongan',
                    'count' => Lowongan::all()->count(),
                    'icon' => 'fas fa-briefcase',
                ],
                [
                    'label' => 'Peminat',
                    'count' => $peminat,
                    'icon' => 'fas fa-user-clock',
                ],
                [
                    'label' => 'Peserta',
                    'count' => $peserta,
                    'icon' => 'fas fa-user-check',
                ],
                [
                    'label' => 'DPL',
                    'count' => DPL::all()->count(),
                    'icon' => 'fas fa-user-tie',
                ],
                [
                    'label' => 'Pamong',
                    'count' => MitraTransaction::all()->count(),
                    'icon' => 'fas fa-users',
                ],
            ],
            'programchart' => $programChart->build()
        ];
        return view('admin.superadmin.dashboard_superadmin')->with('data',$data);
    }
    
}
