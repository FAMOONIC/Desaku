<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // halaman
    public function arsip()      { return view('pages.arsip'); }
    public function jadwal()     { return view('pages.jadwal'); }
    public function peraturan()  { return view('pages.peraturan'); }
    public function penduduk()   { return view('pages.penduduk'); }
    public function antrian()    { return view('pages.antrian'); }

    // halaman sosial (handle filter di sini)
    public function sosial(Request $request)
    {
        $raw = session('sosial', []); // semua data dari session
        $filtered = $this->applySosialFilter($raw, $request->query()); // apply filter
        return view('pages.sosial', [
            'sosial' => $filtered,
            'rawSosial' => $raw, // optional jika butuh data asli di view
        ]);
    }

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

    // tambah arsip (safe)
    public function storeArsip(Request $request)
    {
        $arsip = session('arsip', []);
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '-' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/arsip'), $fileName);
        }

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

    // update arsip (safe)
    public function updateArsip(Request $request)
    {
        $arsip = session('arsip', []);
        foreach ($arsip as &$item) {
            if ($item['id'] == $request->id) {
                $item['judul'] = $request->judul;
                $item['kategori'] = $request->kategori;
                $item['tahun'] = $request->tahun;

                if ($request->hasFile('file')) {
                    $fileName = time() . '-' . $request->file('file')->getClientOriginalName();
                    $request->file('file')->move(public_path('uploads/arsip'), $fileName);
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
        $poin = array_values(array_filter($request->poin ?? [], fn($v) => trim($v) !== ''));

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
                $item['poin'] = array_values(array_filter($request->poin ?? [], fn($v) => trim($v) !== ''));
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

    // storeSosial (dengan upload)
    public function storeSosial(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string',
            'pj' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $data = session('sosial', []);
        $fileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '-' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/sosial'), $fileName);
        }

        $data[] = [
            'id' => count($data) + 1,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'pj' => $request->pj,
            'deskripsi' => $request->deskripsi,
            'file' => $fileName,
            'created_at' => now()->toDateTimeString()
        ];

        session(['sosial' => $data]);
        return redirect('/kegiatan-sosial')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    // updateSosial
    public function updateSosial(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nama' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string',
            'pj' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $data = session('sosial', []);
        foreach ($data as &$item) {
            if ($item['id'] == $request->id) {
                $item['nama'] = $request->nama;
                $item['tanggal'] = $request->tanggal;
                $item['lokasi'] = $request->lokasi;
                $item['pj'] = $request->pj;
                $item['deskripsi'] = $request->deskripsi;

                if ($request->hasFile('file')) {
                    if (!empty($item['file']) && file_exists(public_path('uploads/sosial/' . $item['file']))) {
                        @unlink(public_path('uploads/sosial/' . $item['file']));
                    }
                    $file = $request->file('file');
                    $fileName = time() . '-' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->move(public_path('uploads/sosial'), $fileName);
                    $item['file'] = $fileName;
                }
                break;
            }
        }
        unset($item);

        session(['sosial' => $data]);
        return redirect('/kegiatan-sosial')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    // deleteSosial
    public function deleteSosial($id)
    {
        $data = session('sosial', []);
        $new = [];
        foreach ($data as $item) {
            if ($item['id'] == $id) {
                if (!empty($item['file']) && file_exists(public_path('uploads/sosial/' . $item['file']))) {
                    @unlink(public_path('uploads/sosial/' . $item['file']));
                }
                continue;
            }
            $new[] = $item;
        }
        foreach ($new as $k => &$it) $it['id'] = $k + 1;
        unset($it);

        session(['sosial' => $new]);
        return redirect('/kegiatan-sosial')->with('success', 'Kegiatan berhasil dihapus!');
    }

    // printSosial (PDF, mendukung filter)
    public function printSosial(Request $request)
    {
        $all = session('sosial', []);
        $filtered = $this->applySosialFilter($all, $request->query());
        $view = view('pages.sosial_pdf', ['sosial' => $filtered])->render();

        if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
            return \PDF::loadHTML($view)->setPaper('a4', 'portrait')->stream('kegiatan_sosial_' . date('Ymd_His') . '.pdf');
        }
        return response($view);
    }

    // sosialStats (JSON)
    public function sosialStats(Request $request)
    {
        $all = session('sosial', []);
        $counts = [];
        foreach ($all as $item) {
            $month = date('Y-m', strtotime($item['tanggal'] ?? $item['created_at']));
            if (!isset($counts[$month])) $counts[$month] = 0;
            $counts[$month]++;
        }
        ksort($counts);
        return response()->json($counts);
    }

    // helper filter (public so view won't call controller statically)
    public function applySosialFilter(array $data, array $query)
    {
        $from = $query['from'] ?? null;
        $to = $query['to'] ?? null;
        $lokasi = $query['lokasi'] ?? null;
        $keyword = $query['q'] ?? null;

        $filtered = array_filter($data, function($item) use ($from, $to, $lokasi, $keyword) {
            $tgl = $item['tanggal'] ?? $item['created_at'];
            if ($from && strtotime($tgl) < strtotime($from)) return false;
            if ($to && strtotime($tgl) > strtotime($to)) return false;
            if ($lokasi && $lokasi !== '' && stripos($item['lokasi'] ?? '', $lokasi) === false) return false;
            if ($keyword && $keyword !== '') {
                $hay = ($item['nama'].' '.$item['deskripsi'].' '.$item['pj'].' '.$item['lokasi']);
                if (stripos($hay, $keyword) === false) return false;
            }
            return true;
        });

        return array_values($filtered);
    }
}
