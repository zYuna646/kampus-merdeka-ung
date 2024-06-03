<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
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

}
