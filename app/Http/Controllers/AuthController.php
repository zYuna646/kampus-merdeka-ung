<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Role;
use App\Models\Studi;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function password(Request $request)
    {
        try {
            // dd($request);
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required',
            ]);
            // dd(Hash::check($request->current_password, Auth::user()->password));

            if (Hash::check($request->current_password, Auth::user()->password)) {
                Auth::user()->password = bcrypt($request->new_password);
                Auth::user()->save();

                return redirect()->back()->with('success', 'Password Berhasil Diubah');
            } else {
                return redirect()->back()->with('error', 'Password Lama Salah');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function profile(Request $request)
    {
    
       
        $user = Auth::user();   

    if ($user->role->slug == 'admin' || $user->role->slug == 'operator') {
        $request->validate([
            'username' => 'required',
        ]);

        $user->update([
            'username' => $request->username,
        ]);
    } elseif ($user->role->slug == 'mahasiswa') {
        // dd($request->kelurahan);

        $request->validate([
            'nim' => 'required',
            'name' => 'required',
            'studi_id' => 'required',
            'username' => 'required',
            'no_hp' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'alamat' => 'required',
        ]);

        
        $user->update([
            'username' => $request->username,
        ]);

        // dd($request->alamat);
        $user->mahasiswa->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'studi_id' => $request->studi_id,
            'no_hp' => $request->no_hp,
            'village_id' => $request->kelurahan,
            'alamat' => $request->alamat,
        ]);
    } elseif ($user->role->slug == 'dosen') {
        $request->validate([
            'nidn' => 'required',
            'name' => 'required',
            'studi_id' => 'required',
            'username' => 'required',
        ]);

        $user->update([
            'username' => $request->username,
        ]);

        $user->dosen->update([
            'name' => $request->name,
            'nidn' => $request->nidn,
            'studi_id' => $request->studi_id,
        ]);
    } elseif ($user->role->slug == 'guru') {
        $request->validate([
            'nik' => 'required',
            'name' => 'required',
            'username' => 'required',
        ]);

        $user->update([
            'username' => $request->username,
        ]);

        $user->guru->update([
            'name' => $request->name,
            'nik' => $request->nik,
        ]);
    }

    return redirect()->back()->with('success', 'Profile Berhasil Diubah');
}





    public function authenticate(Request $request)
    {

        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Kolom nama pengguna harus diisi.',
            'password.required' => 'Kolom kata sandi harus diisi.',
        ]);
        

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            $role = Auth::user()->role->slug;
            switch ($role) {
                case 'admin':
                    return redirect()->intended('/dashboard/admin');
                case 'dosen':
                    return redirect()->intended('/dashboard/dpl');
                case 'mahasiswa':
                    return redirect()->intended('/dashboard/student');
                case 'guru':
                    return redirect()->intended('/dashboard/pamong');
                case 'operator':
                    return redirect()->intended('/dashboard/operator');
                // Add more cases for other roles if needed
                default:
                    return redirect()->intended('/dashboard_default');
            }
        }

        return back()->with('loginError', 'Username Atau Password Salah');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Membuang sesi autentikasi pengguna

        $request->session()->invalidate(); // Mematikan sesi

        $request->session()->regenerateToken(); // Membuat token baru untuk mencegah serangan CSRF

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.'); // Mengarahkan pengguna ke halaman login dengan pesan sukses
    }


    public function userProfile()
    {

        $data = [
            'fakultas' => Fakultas::all(),
            'jurusan' => Jurusan::all(),
            'prodi' => Studi::all(),
            'provinsi' => Province::pluck('name', 'id'),
        ];
        return view('admin.profile_setting')->with('data', $data);
    }

    public function register()
    {
        return view('auth.register');
    }
    
    public function showForm($step)
    {
        // Pastikan step ada dalam range yang valid
        if (!in_array($step, [1, 2, 3])) {
            return redirect()->route('register.form', ['step' => 1]);
        }

        $data = [];
        if ($step == 2) {
            $data['provinsi'] = Province::pluck('name', 'id');
        }

        return view('auth.register.step' . $step, $data);
    }

    public function processForm(Request $request, $step)
    {
        // Validasi data berdasarkan langkah
        $this->validate($request, $this->getValidationRules($step));

        // Simpan data ke session
        Session::put('register_step' . $step, $request->all());

        // Redirect ke langkah berikutnya atau simpan data ke database jika selesai
        if ($step < 3) {
            return redirect()->route('register.form', ['step' => $step + 1]);
        } else {
            // Simpan data ke database
            $this->saveDataToDatabase();
            return redirect()->route('login');
        }
    }

    private function getValidationRules($step)
    {
        $rules = [];
        switch ($step) {
            case 1:
                $rules = [
                    'nim' => 'required',
                    'nama' => 'required'
                ];
                break;
            case 2:
                $rules = [
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'kelurahan' => 'required'
                ];
                break;
            case 3:
                $rules = [
                    'alamat' => 'required'
                ];
                break;
           
        }
        return $rules;
    }

    public function getData(Request $request)
    {
        $type = $request->query('type');
        $parent_id = $request->query('parent_id');

        $data = [];

        if ($type == 'kabupaten') {
            $data = Regency::where('province_id', $parent_id)->pluck('name', 'id');
        } elseif ($type == 'kecamatan') {
            $data = District::where('regency_id', $parent_id)->pluck('name', 'id');
        } elseif ($type == 'kelurahan') {
            $data = Village::where('district_id', $parent_id)->pluck('name', 'id');
        }
        return response()->json($data);
    }

    private function saveDataToDatabase()
    {
        // Gabungkan semua data dari session
        $data = array_merge(
            Session::get('register_step1', []),
            Session::get('register_step2', []),
            Session::get('register_step3', []),
        );

        // dd($data);
        $mahasiswa = Mahasiswa::where('nim', $data['nim'])->first();

        if($mahasiswa){
            return redirect()->route('register.form', 1)->with('error', 'NIM Sudah digunakan');
        }
        // Simpan data ke database (contoh menggunakan model User)
        $role = Role::where('slug', 'mahasiswa')->first();


        $user = User::create([
            'username' => $data['nim'],
            'password' => bcrypt($data['password']),
            'role_id' => $role->id,
        ]);

        Mahasiswa::create([
            'nim' => $data['nim'],
            'name' => $data['nama'],
            // 'studi_id' => Studi here
            'village_id' => $data['kelurahan'],
            'alamat' => $data['alamat'],
            'user_id' => $user->id,
            'angkatan' => $data['angkatan']
        ]);

        // Hapus data dari session
        Session::forget('register_step1');
        Session::forget('register_step2');
        Session::forget('register_step3');
        
        // return redirect()->route('login');
    }


}
