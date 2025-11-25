<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Jika belum implementasi database
    // role masih dummy — nanti kita ubah
    $role = session('role', 'admin'); // default admin supaya tes

    if ($role == 'admin') {
        return view('dashboard.admin');
    } else {
        return view('dashboard.warga');
    }
}

}
