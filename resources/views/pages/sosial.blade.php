@extends('layout.main')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">Kegiatan Sosial</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('sosial.print', request()->query()) }}" class="btn btn-outline-primary">Cetak (PDF)</a>
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSosial">+ Tambah Kegiatan</button>
        </div>
    </div>

    {{-- FILTER --}}
    <form class="row g-2 mb-3" method="GET" action="{{ url('/kegiatan-sosial') }}">
        <div class="col-auto"><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
        <div class="col-auto"><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
        <div class="col-auto"><input type="text" name="lokasi" class="form-control" placeholder="Lokasi" value="{{ request('lokasi') }}"></div>
        <div class="col-auto"><input type="text" name="q" class="form-control" placeholder="Cari..." value="{{ request('q') }}"></div>
        <div class="col-auto">
            <button class="btn btn-outline-success">Filter</button>
            <a href="{{ url('/kegiatan-sosial') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-success">
                    <tr><th>Nama</th><th>Tanggal</th><th>Lokasi</th><th>PJ</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @php $list = $sosial ?? []; @endphp

                    @forelse ($list as $item)
                        <tr id="row-{{ $item['id'] }}">
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>{{ $item['lokasi'] }}</td>
                            <td>{{ $item['pj'] }}</td>
                            <td><a href="#" class="text-primary btn-detail" data-target="#detail-{{ $item['id'] }}">Detail</a></td>
                        </tr>

                        <tr>
                            <td colspan="5" class="p-0">
                                <div id="detail-{{ $item['id'] }}" class="collapse-content" style="display:none; padding:16px;">
                                    <h5>{{ $item['nama'] }}</h5>
                                    <p class="text-muted">Tanggal: {{ $item['tanggal'] }} | Lokasi: {{ $item['lokasi'] }} | PJ: {{ $item['pj'] }}</p>
                                    <p>{{ $item['deskripsi'] }}</p>

                                    @if(!empty($item['file']))
                                        <p>Lampiran: <a href="{{ asset('uploads/sosial/'.$item['file']) }}" target="_blank">Lihat / Unduh</a></p>
                                    @endif

                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditSosial{{ $item['id'] }}">Edit</button>
                                        <a href="{{ url('/kegiatan-sosial/delete/' . $item['id']) }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal fade" id="modalTambahSosial" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content" style="border-radius:12px;">
        <div class="modal-header bg-success text-white"><h5 class="modal-title">Tambah Kegiatan</h5><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <form action="{{ route('sosial.store') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="modal-body">
                <div class="mb-3"><label class="fw-bold">Nama</label><input type="text" name="nama" class="form-control" required></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="fw-bold">Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="fw-bold">Lokasi</label><input type="text" name="lokasi" class="form-control"></div></div>
                <div class="mb-3"><label class="fw-bold">Penanggung Jawab</label><input type="text" name="pj" class="form-control"></div>
                <div class="mb-3"><label class="fw-bold">Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
                <div class="mb-3"><label class="fw-bold">Lampiran (foto/pdf)</label><input type="file" name="file" class="form-control"></div>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-success">Simpan</button></div>
        </form>
    </div></div>
</div>

<!-- modal edit (buat untuk setiap item yang tampil di list) -->
@foreach($list as $item)
<div class="modal fade" id="modalEditSosial{{ $item['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content" style="border-radius:12px;">
        <div class="modal-header bg-primary text-white"><h5 class="modal-title">Edit Kegiatan</h5><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <form action="{{ route('sosial.update') }}" method="POST" enctype="multipart/form-data">@csrf
            <input type="hidden" name="id" value="{{ $item['id'] }}">
            <div class="modal-body">
                <div class="mb-3"><label class="fw-bold">Nama</label><input type="text" name="nama" class="form-control" value="{{ $item['nama'] }}" required></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="fw-bold">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ $item['tanggal'] }}" required></div>
                <div class="col-md-6 mb-3"><label class="fw-bold">Lokasi</label><input type="text" name="lokasi" class="form-control" value="{{ $item['lokasi'] }}"></div></div>
                <div class="mb-3"><label class="fw-bold">Penanggung Jawab</label><input type="text" name="pj" class="form-control" value="{{ $item['pj'] }}"></div>
                <div class="mb-3"><label class="fw-bold">Deskripsi</label><textarea name="deskripsi" class="form-control">{{ $item['deskripsi'] }}</textarea></div>
                <div class="mb-3"><label class="fw-bold">Lampiran (ubah jika perlu)</label><input type="file" name="file" class="form-control"></div>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary">Simpan</button></div>
        </form>
    </div></div>
</div>
@endforeach

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.btn-detail').forEach(btn=>{
        btn.addEventListener('click', function(e){
            e.preventDefault();
            const t = document.querySelector(this.dataset.target);
            document.querySelectorAll('.collapse-content').forEach(x=>x.style.display='none');
            t.style.display = (t.style.display === 'block') ? 'none' : 'block';
        });
    });
});
</script>
@endpush

@endsection