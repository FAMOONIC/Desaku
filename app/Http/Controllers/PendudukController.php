<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;

class PendudukController extends Controller
{
    // tampilkan data penduduk
    public function index()
    {
        $penduduk = Penduduk::all();

        // ambil role dari session login
        $role = session('role', 'warga');

        return view('pages.penduduk', compact('penduduk', 'role'));
    }

    // simpan penduduk
    public function store(Request $request)
    {
        Penduduk::create($request->all());

        return redirect()
            ->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan');
    }

    // hapus penduduk
    public function destroy($nik)
    {
        Penduduk::where('nik', $nik)->delete();

        return redirect()
            ->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus');
    }

    // cetak pdf (sementara placeholder)
    public function pdf($nik)
    {
        return "PDF Penduduk NIK: " . $nik;
    }
}
