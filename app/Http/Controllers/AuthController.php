<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Proses login dummy (sementara)
     */
    public function login(Request $request)
    {
        // Dummy akun admin
        $dummyEmail = "admin@desa.com";
        $dummyPass = "admin";

        // Validasi sederhana
        if ($request->email == $dummyEmail && $request->password == $dummyPass) {

            // Simpan sesi role & user
            session([
                'logged_in' => true,
                'role' => 'admin',
                'user_name' => 'Administrator',
                'user_email' => $dummyEmail,
            ]);

            return redirect('/dashboard');
        }

        // Kalau salah
        return back()->with("error", "Email atau password salah (dummy)");
    }

    /**
     * Logout user
     */
    public function logout()
    {
        session()->flush(); // hapus semua session
        return redirect('/login');
    }
}
