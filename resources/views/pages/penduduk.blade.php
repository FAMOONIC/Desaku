@extends('layout.main')

@section('content')
<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-success mb-0">Data Penduduk</h3>
            <small class="text-muted">Daftar penduduk terdaftar di desa</small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-success">
                Export Excel
            </button>
            <button class="btn btn-outline-secondary">
                Cetak Semua PDF
            </button>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card shadow-sm mb-3" style="border-radius:12px;">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="fw-bold">Cari</label>
                    <input type="text" class="form-control" placeholder="Cari NIK atau Nama">
                </div>

                <div class="col-md-2">
                    <label class="fw-bold">RT</label>
                    <select class="form-control">
                        <option value="">Semua</option>
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="fw-bold">RW</label>
                    <select class="form-control">
                        <option value="">Semua</option>
                        <option>01</option>
                        <option>02</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="fw-bold">Status</label>
                    <select class="form-control">
                        <option value="">Semua</option>
                        <option value="aktif">Aktif</option>
                        <option value="pindah">Pindah</option>
                        <option value="meninggal">Meninggal</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-secondary w-100">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL -->
    <div class="card shadow-sm" style="border-radius:12px;">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-success">
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>RT/RW</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $penduduk = session('penduduk', []);
                    @endphp

                    @forelse($penduduk as $p)
                        <tr>
                            <td>{{ $p['nik'] }}</td>
                            <td>{{ $p['nama'] }}</td>
                            <td>{{ $p['rt'] }}/{{ $p['rw'] }}</td>
                            <td>{{ $p['jk'] ?? '-' }}</td>
                            <td>
                                @if(($p['status'] ?? 'aktif') === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($p['status'] === 'pindah')
                                    <span class="badge bg-warning text-dark">Pindah</span>
                                @else
                                    <span class="badge bg-danger">Meninggal</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#detail{{ $p['nik'] }}">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL DETAIL -->
                        <div class="modal fade" id="detail{{ $p['nik'] }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius:12px;">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">Detail Penduduk</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="30%">NIK</th>
                                                <td>{{ $p['nik'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td>{{ $p['nama'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tempat, Tanggal Lahir</th>
                                                <td>{{ $p['tempat_lahir'] ?? '-' }}, {{ $p['tanggal_lahir'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td>{{ $p['jk'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $p['alamat'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>RT / RW</th>
                                                <td>{{ $p['rt'] }}/{{ $p['rw'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pekerjaan</th>
                                                <td>{{ $p['pekerjaan'] ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ ucfirst($p['status'] ?? 'aktif') }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button class="btn btn-success">Cetak PDF</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-5">
                                <strong>Belum ada data penduduk</strong><br>
                                <small>Data akan muncul setelah warga melakukan pendaftaran</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
