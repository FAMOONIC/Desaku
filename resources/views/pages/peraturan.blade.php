@extends('layout.main')

@section('content')

<div class="container">

    <!-- header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">Peraturan Desa</h3>

        <div class="d-flex gap-2">
            <a href="{{ route('peraturan.printAll') }}" class="btn btn-outline-primary">
                Cetak Semua PDF
            </a>

            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPeraturan">
                + Tambah Peraturan
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- tabel -->
    <div class="card shadow-sm" style="border-radius:12px;">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Judul</th>
                        <th>Nomor</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php $peraturan = session('peraturan', []); @endphp

                    @forelse ($peraturan as $item)
                        <!-- baris data -->
                        <tr id="row-{{ $item['id'] }}">
                            <td>{{ $item['judul'] }}</td>
                            <td>{{ $item['nomor'] }}</td>
                            <td>{{ $item['tahun'] }}</td>
                            <td>
                                <!-- tombol detail akan toggle collapse row berikutnya -->
                                <a href="#" class="text-primary btn-detail" data-target="#detail-{{ $item['id'] }}">
                                    Detail
                                </a>
                            </td>
                        </tr>

                        <!-- baris detail (collapse) -->
                        <tr class="collapse-row">
                            <td colspan="4" class="p-0">
                                <div id="detail-{{ $item['id'] }}" class="collapse-content" style="display:none; padding:16px; border-top:1px solid #e9ecef;">
                                    <div class="bg-white" style="padding:12px; border-radius:8px;">
                                        <h5 class="mb-1">{{ $item['judul'] }}</h5>
                                        <div class="text-muted mb-2">Peraturan Desa Nomor <strong>{{ $item['nomor'] }}</strong> Tahun <strong>{{ $item['tahun'] }}</strong></div>

                                        <ol>
                                            @foreach ($item['poin'] as $p)
                                                <li>{{ $p }}</li>
                                            @endforeach
                                        </ol>

                                        <div class="mt-3">
                                            <button class="btn btn-sm btn-primary btn-edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditPeraturan{{ $item['id'] }}">
                                                Edit
                                            </button>

                                            <a href="{{ url('/peraturan/delete/' . $item['id']) }}"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin hapus peraturan ini?')">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">
                                Belum ada peraturan ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Peraturan -->
<div class="modal fade" id="modalTambahPeraturan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Peraturan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formTambahPeraturan" action="{{ route('peraturan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nomor</label>
                            <input type="text" name="nomor" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tahun</label>
                            <input type="number" name="tahun" class="form-control" min="1990" max="2100" required>
                        </div>
                    </div>

                    <hr>
                    <h6>Poin Peraturan</h6>

                    <div id="poin-list">
                        <!-- initial satu input -->
                        <div class="input-group mb-2">
                            <input type="text" name="poin[]" class="form-control" placeholder="Poin peraturan" required>
                            <button type="button" class="btn btn-outline-danger btn-remove" style="display:none;">-</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" id="tambahPoinBtn" class="btn btn-sm btn-outline-success">+ Tambah Poin</button>
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

<!-- Modal Edit Peraturan (per item) -->
@php $allPeraturan = session('peraturan', []) @endphp
@foreach ($allPeraturan as $item)
<div class="modal fade" id="modalEditPeraturan{{ $item['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Peraturan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('peraturan.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] }}">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ $item['judul'] }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nomor</label>
                            <input type="text" name="nomor" class="form-control" value="{{ $item['nomor'] }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tahun</label>
                            <input type="number" name="tahun" class="form-control" min="1990" max="2100" value="{{ $item['tahun'] }}" required>
                        </div>
                    </div>

                    <hr>
                    <h6>Poin Peraturan</h6>

                    <div class="poin-edit-list mb-2">
                        @foreach ($item['poin'] as $p)
                            <div class="input-group mb-2">
                                <input type="text" name="poin[]" class="form-control" value="{{ $p }}" required>
                                <button type="button" class="btn btn-outline-danger btn-remove">-</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-outline-success tambah-poin-edit">+ Tambah Poin</button>
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

<!-- JS kecil untuk accordion expand-row dan dynamic poin -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Toggle detail (expand-row)
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('data-target'));
            if (!target) return;

            // simple toggle display
            const isShown = target.style.display === 'block';
            // hide all details first (optional: allow multiple opens by removing this block)
            document.querySelectorAll('.collapse-content').forEach(c => c.style.display = 'none');

            if (!isShown) {
                target.style.display = 'block';
                // scroll to target for UX
                target.scrollIntoView({behavior: 'smooth', block: 'center'});
            } else {
                target.style.display = 'none';
            }
        });
    });

    // Tambah poin di modal tambah
    const poinList = document.getElementById('poin-list');
    const tambahPoinBtn = document.getElementById('tambahPoinBtn');

    tambahPoinBtn.addEventListener('click', function () {
        const wrapper = document.createElement('div');
        wrapper.className = 'input-group mb-2';

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'poin[]';
        input.className = 'form-control';
        input.placeholder = 'Poin peraturan';
        input.required = true;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-outline-danger btn-remove';
        removeBtn.textContent = '-';
        removeBtn.addEventListener('click', () => wrapper.remove());

        wrapper.appendChild(input);
        wrapper.appendChild(removeBtn);

        poinList.appendChild(wrapper);
    });

    // Remove on existing remove buttons (for edit lists)
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('.input-group');
            if (row) row.remove();
        });
    });

    // Tambah poin di modal edit (per modal)
    document.querySelectorAll('.tambah-poin-edit').forEach(button => {
        button.addEventListener('click', function () {
            const container = this.closest('.modal-content').querySelector('.poin-edit-list');
            if (!container) return;

            const wrapper = document.createElement('div');
            wrapper.className = 'input-group mb-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'poin[]';
            input.className = 'form-control';
            input.placeholder = 'Poin peraturan';
            input.required = true;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-outline-danger btn-remove';
            removeBtn.textContent = '-';
            removeBtn.addEventListener('click', () => wrapper.remove());

            wrapper.appendChild(input);
            wrapper.appendChild(removeBtn);

            container.appendChild(wrapper);
        });
    });

    // attach remove handlers that appear later (mutation)
    document.body.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-remove')) {
            const row = e.target.closest('.input-group');
            if (row) row.remove();
        }
    });

});
</script>
@endpush

@endsection
