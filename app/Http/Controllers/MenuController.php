<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // halaman
    public function arsip()      { return view('pages.arsip'); }
    public function jadwal()     { return view('pages.jadwal'); }
    public function peraturan()  { return view('pages.peraturan'); }
    public function sosial()     { return view('pages.sosial'); }
    public function penduduk()   { return view('pages.penduduk'); }
    public function antrian()    { return view('pages.antrian'); }

    // tambah jadwal
    public function storeJadwal(Request $request)
    {
        $jadwal = session('jadwal', []);
        $jadwal[] = [
            'nama'    => $request->nama,
            'rtrw'    => $request->rtrw,
            'tanggal' => $request->tanggal,
            'jam'     => $request->jam,
        ];
        session(['jadwal' => $jadwal]);
        return redirect('/jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // tambah antrian
    public function storeAntrian(Request $request)
    {
        $antrian = session('antrian', []);
        $nomor = 'A' . str_pad(count($antrian) + 1, 3, '0', STR_PAD_LEFT);
        $antrian[] = [
            'nomor'   => $nomor,
            'nama'    => $request->nama,
            'layanan' => $request->layanan,
            'status'  => 'Menunggu',
        ];
        session(['antrian' => $antrian]);
        return redirect('/antrian')->with('success', 'Antrian berhasil dibuat!');
    }

    // tambah arsip
    public function storeArsip(Request $request)
    {
        $arsip = session('arsip', []);
        $fileName = time() . '-' . $request->file->getClientOriginalName();
        $request->file->move(public_path('uploads/arsip'), $fileName);

        $arsip[] = [
            'id'       => count($arsip) + 1,
            'judul'    => $request->judul,
            'kategori' => $request->kategori,
            'tahun'    => $request->tahun,
            'file'     => $fileName,
        ];
        session(['arsip' => $arsip]);
        return redirect('/arsip')->with('success', 'Arsip berhasil ditambahkan!');
    }

    // hapus arsip
    public function deleteArsip($id)
    {
        $arsip = session('arsip', []);
        $arsip = array_filter($arsip, fn($item) => $item['id'] != $id);
        session(['arsip' => $arsip]);
        return redirect('/arsip')->with('success', 'Arsip berhasil dihapus!');
    }

    // update arsip
    public function updateArsip(Request $request)
    {
        $arsip = session('arsip', []);
        foreach ($arsip as &$item) {
            if ($item['id'] == $request->id) {
                $item['judul'] = $request->judul;
                $item['kategori'] = $request->kategori;
                $item['tahun'] = $request->tahun;

                if ($request->file) {
                    $fileName = time() . '-' . $request->file->getClientOriginalName();
                    $request->file->move(public_path('uploads/arsip'), $fileName);
                    $item['file'] = $fileName;
                }
            }
        }
        unset($item);
        session(['arsip' => $arsip]);
        return redirect('/arsip')->with('success', 'Arsip berhasil diperbarui!');
    }

    // tambah peraturan
    public function storePeraturan(Request $request)
    {
        $peraturan = session('peraturan', []);
        $poin = array_values(array_filter($request->poin, fn($v) => trim($v) !== ''));

        $peraturan[] = [
            'id'    => count($peraturan) + 1,
            'judul' => $request->judul,
            'nomor' => $request->nomor,
            'tahun' => $request->tahun,
            'poin'  => $poin,
        ];

        session(['peraturan' => $peraturan]);
        return redirect('/peraturan')->with('success', 'Peraturan berhasil ditambahkan!');
    }

    // update peraturan
    public function updatePeraturan(Request $request)
    {
        $peraturan = session('peraturan', []);
        foreach ($peraturan as &$item) {
            if ($item['id'] == $request->id) {
                $item['judul'] = $request->judul;
                $item['nomor'] = $request->nomor;
                $item['tahun'] = $request->tahun;
                $item['poin'] = array_values(array_filter($request->poin, fn($v) => trim($v) !== ''));
            }
        }
        unset($item);
        session(['peraturan' => $peraturan]);
        return redirect('/peraturan')->with('success', 'Peraturan berhasil diperbarui!');
    }

    // hapus peraturan
    public function deletePeraturan($id)
    {
        $peraturan = session('peraturan', []);
        $peraturan = array_values(array_filter($peraturan, fn($item) => $item['id'] != $id));

        foreach ($peraturan as $k => &$it) {
            $it['id'] = $k + 1;
        }
        unset($it);

        session(['peraturan' => $peraturan]);
        return redirect('/peraturan')->with('success', 'Peraturan berhasil dihapus!');
    }

    // cetak semua peraturan
    public function printAllPeraturan()
    {
        $peraturan = session('peraturan', []);
        $pdfView = view('pages.peraturan_pdf', compact('peraturan'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
            return \PDF::loadHTML($pdfView)
                       ->setPaper('a4', 'portrait')
                       ->stream('kumpulan_peraturan_' . date('Ymd_His') . '.pdf');
        }

        return response($pdfView);
    }
}
