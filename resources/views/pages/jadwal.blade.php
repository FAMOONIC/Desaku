@extends('layout.main')

@section('content')

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">Jadwal Siskamling</h3>

        <!-- Tombol untuk membuka modal -->
        <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal" style="border-radius: 8px;">
            + Tambah Jadwal
        </button>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-body">

            <p class="text-secondary mb-3">
                Berikut adalah daftar jadwal ronda / siskamling yang telah ditentukan oleh pihak desa.
            </p>

            <!-- ALERT SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- TABLE -->
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Nama Warga</th>
                        <th>RT / RW</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @if (session('jadwal') && count(session('jadwal')) > 0)
                        @foreach (session('jadwal') as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ $row['rtrw'] }}</td>
                                <td>{{ $row['tanggal'] }}</td>
                                <td>{{ $row['jam'] }}</td>
                                <td>
                                    <span class="text-secondary">Edit | Hapus</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">
                                Belum ada jadwal ditambahkan.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

        </div>
    </div>
</div>

<!--script popup
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>-->

<!-- ============================
     MODAL TAMBAH JADWAL
============================= -->
<div class="modal fade" id="modalTambahJadwal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Jadwal Siskamling</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- FORM WAJIB ADA action + method -->
                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="fw-bold">Nama Warga</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama warga">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">RT / RW</label>
                        <input type="text" name="rtrw" class="form-control" required placeholder="Contoh: 02/05">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Jam</label>
                        <input type="time" name="jam" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection
