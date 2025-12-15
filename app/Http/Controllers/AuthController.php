<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    // LOGIN
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // ADMIN DUMMY
        if ($username === 'admin@desa.com' && $password === 'admin') {
            session([
                'logged_in' => true,
                'role' => 'admin',
                'user_name' => 'Administrator',
                'user_email' => $username,
            ]);
            return redirect('/dashboard');
        }

        //WARGA (SESSION)
        $warga = session('warga', []);

        foreach ($warga as $w) {
            if ($w['nik'] === $username && $w['password'] === hash('sha256', $password)) {
                session([
                    'logged_in' => true,
                    'role' => 'warga',
                    'user_name' => $w['nama'],
                    'nik' => $w['nik'],
                ]);
                return redirect('/dashboard');
            }
        }

        return back()->with('error', 'Login gagal. Email/NIK atau password salah.');
    }

    // FORM REGISTER
    public function register()
    {
        return view('auth.register');
    }

    // SIMPAN REGISTER (SESSION)
    public function storeRegister(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'nama' => 'required',
            'password' => 'required|min:6',
        ]);

        $warga = session('warga', []);

        // Cegah NIK ganda
        foreach ($warga as $w) {
            if ($w['nik'] === $request->nik) {
                return back()->with('error', 'NIK sudah terdaftar');
            }
        }

        $warga[] = [
            'nik' => $request->nik,
            'nama' => $request->nama,
            'password' => hash('sha256', $request->password),
        ];

        session(['warga' => $warga]);

        return redirect('/login')->with('error', 'Registrasi berhasil, silakan login');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
