<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Studi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $request->validate([
                'nim' => 'required',
                'name' => 'required',
                'studi_id' => 'required',
                'username' => 'required',
            ]);

            $user->update([
                'username' => $request->username,
            ]);

            $user->mahasiswa->update([
                'name' => $request->name,
                'nim' => $request->nim,
                'studi_id' => $request->studi_id,
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
                'nidn' => $request->nidn, // Changed from $request->nim to $request->nidn
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
                'nik' => $request->nik, // Changed from $request->nim to $request->nik
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
        ];
        return view('admin.profile_setting')->with('data', $data);
    }


}
