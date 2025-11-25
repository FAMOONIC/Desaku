@extends('layout.main')

@section('content')

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">Antrian Online</h3>

        <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAntrian" style="border-radius: 8px;">
            + Buat Antrian Baru
        </button>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-body">

            <p class="text-secondary mb-3">
                Berikut adalah daftar antrian layanan masyarakat desa.
            </p>

            <!-- ALERT SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>No Antrian</th>
                        <th>Nama Warga</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @if (session('antrian') && count(session('antrian')) > 0)
                        @foreach (session('antrian') as $item)
                            <tr>
                                <td class="fw-bold">{{ $item['nomor'] }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['layanan'] }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                </td>
                                <td>
                                    <span class="text-secondary">Detail | Hapus</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">
                                Belum ada antrian dibuat.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- ============================
     MODAL TAMBAH ANTRIAN
============================= -->
<div class="modal fade" id="modalTambahAntrian" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Buat Antrian Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formTambahAntrian" action="{{ route('antrian.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="fw-bold">Nama Warga</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama warga">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Jenis Layanan</label>
                        <select name="layanan" class="form-control" required>
                            <option value="">Pilih Layanan</option>
                            <option>Surat Pengantar</option>
                            <option>Surat Keterangan Domisili</option>
                            <option>Surat Keterangan Usaha</option>
                            <option>Pembuatan SKTM</option>
                            <option>Administrasi Lainnya</option>
                        </select>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahAntrian" class="btn btn-success">Simpan</button>
            </div>

        </div>
    </div>
</div>

@endsection
