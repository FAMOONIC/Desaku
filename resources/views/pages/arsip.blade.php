@extends('layout.main')

@section('content')

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">Arsip Desa</h3>

        <button class="btn btn-success shadow-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahArsip"
                style="border-radius: 8px;">
            + Tambah Dokumen
        </button>
    </div>

    <!-- FILTER KATEGORI -->
    <div class="mb-3 d-flex gap-2">
        <a href="/arsip" class="btn btn-outline-success {{ request('kategori') ? '' : 'active' }}">Semua</a>
        <a href="/arsip?kategori=Peraturan Desa" class="btn btn-outline-success {{ request('kategori')=='Peraturan Desa' ? 'active' : '' }}">Peraturan Desa</a>
        <a href="/arsip?kategori=Keuangan" class="btn btn-outline-success {{ request('kategori')=='Keuangan' ? 'active' : '' }}">Keuangan</a>
        <a href="/arsip?kategori=Sosial" class="btn btn-outline-success {{ request('kategori')=='Sosial' ? 'active' : '' }}">Sosial</a>
        <a href="/arsip?kategori=Lainnya" class="btn btn-outline-success {{ request('kategori')=='Lainnya' ? 'active' : '' }}">Lainnya</a>
    </div>

    <!-- SEARCH BAR -->
    <form method="GET" action="/arsip" class="mb-3">
        <div class="input-group">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari judul dokumen..."
                   value="{{ request('search') }}">
            <button class="btn btn-success">Cari</button>
        </div>
    </form>

    <!-- CARD -->
    <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-body">

            <p class="text-secondary mb-3">
                Berikut adalah dokumen arsip yang telah diunggah oleh pihak desa.
            </p>

            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            <!-- TABEL ARSIP -->
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $arsip = session('arsip', []);
                        $filter = request('kategori');
                        $search = request('search');

                        // Filter kategori
                        if ($filter) {
                            $arsip = array_filter($arsip, fn($i) => $i['kategori'] == $filter);
                        }

                        // Search judul
                        if ($search) {
                            $arsip = array_filter($arsip, fn($i) =>
                                str_contains(strtolower($i['judul']), strtolower($search))
                            );
                        }
                    @endphp

                    @if(count($arsip) > 0)
                        @foreach ($arsip as $item)
                            <tr>
                                <td>{{ $item['judul'] }}</td>
                                <td>{{ $item['kategori'] }}</td>
                                <td>{{ $item['tahun'] }}</td>

                                <td>
                                    <a href="{{ asset('uploads/arsip/' . $item['file']) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        Lihat
                                    </a>
                                </td>

                                <td>
                                    <a href="#"
                                       class="text-primary"
                                       data-bs-toggle="modal"
                                       data-bs-target="#modalEditArsip{{ $item['id'] }}">
                                        Edit
                                    </a>
                                    |
                                    <a href="/arsip/delete/{{ $item['id'] }}"
                                       class="text-danger"
                                       onclick="return confirm('Yakin hapus arsip?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">
                                Belum ada arsip ditambahkan.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- ===========================================
     MODAL TAMBAH ARSIP
=========================================== -->
<div class="modal fade" id="modalTambahArsip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Arsip Desa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formTambahArsip" action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-bold">Judul Dokumen</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option>Peraturan Desa</option>
                            <option>Keuangan</option>
                            <option>Sosial</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Tahun</label>
                        <input type="number" name="tahun" class="form-control" min="1990" max="2100" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">File Dokumen (PDF)</label>
                        <input type="file" name="file" class="form-control" accept="application/pdf" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- ===========================================
     MODAL EDIT ARSIP
=========================================== -->
@php $arsipAll = session('arsip', []) @endphp

@foreach ($arsipAll as $item)
<div class="modal fade" id="modalEditArsip{{ $item['id'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Arsip</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('arsip.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <input type="hidden" name="id" value="{{ $item['id'] }}">

                    <div class="mb-3">
                        <label class="fw-bold">Judul Dokumen</label>
                        <input type="text" name="judul" class="form-control"
                               value="{{ $item['judul'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option {{ $item['kategori']=='Peraturan Desa' ? 'selected':'' }}>Peraturan Desa</option>
                            <option {{ $item['kategori']=='Keuangan' ? 'selected':'' }}>Keuangan</option>
                            <option {{ $item['kategori']=='Sosial' ? 'selected':'' }}>Sosial</option>
                            <option {{ $item['kategori']=='Lainnya' ? 'selected':'' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Tahun</label>
                        <input type="number" name="tahun" class="form-control"
                               value="{{ $item['tahun'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">File Baru (Opsional)</label>
                        <input type="file" name="file" class="form-control" accept="application/pdf">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach

@endsection
