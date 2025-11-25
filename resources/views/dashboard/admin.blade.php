@extends('layout.main')

@section('content')

<h3 class="fw-bold mb-3">Dashboard</h3>
<p>Selamat datang di Sistem Informasi Desa Jawir</p>

<div class="row g-3">

    <div class="col-md-3">
        <div class="card card-info p-3">
            <small>Total Penduduk</small>
            <h3 class="fw-bold">2,847</h3>
            <span class="text-success">+5% dari tahun lalu</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-info p-3">
            <small>Jumlah Keluarga</small>
            <h3 class="fw-bold">687</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-info p-3">
            <small>Kegiatan Bulan Ini</small>
            <h3 class="fw-bold">12</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-info p-3">
            <small>Antrian Aktif</small>
            <h3 class="fw-bold">8</h3>
        </div>
    </div>

</div>

<div class="row mt-4 g-3">
    <div class="col-md-8">
        <div class="card card-info p-3">
            <h5 class="fw-bold">Pengumuman Terbaru</h5>
            <hr>
            <p>Gotong Royong Desa — 15 Des 2025</p>
            <p>Bantuan Sosial Tersedia — 12 Des 2025</p>
            <p>Rapat RT/RW — 10 Des 2025</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info p-3">
            <h5 class="fw-bold">Profil Desa</h5>
            <p>Nama Desa: Jawir</p>
            <p>Kepala Desa: Bapak Radja</p>
            <p>Kecamatan: Kec. Sejahtera</p>
            <p>Kabupaten: Jawir Jaya</p>
            <button class="btn btn-success w-100">Lihat Profil Lengkap</button>
        </div>
    </div>
</div>

@endsection
