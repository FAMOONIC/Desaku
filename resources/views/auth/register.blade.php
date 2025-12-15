<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Warga - Sistem Informasi Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>

<body class="bg-success bg-opacity-10 d-flex justify-content-center align-items-center" style="height: 100vh">

<div class="card shadow" style="width: 450px;">
    <div class="card-body">

        <h4 class="text-center text-success mb-3">
            <strong>Daftar Akun Warga</strong>
        </h4>

        <p class="text-center text-muted mb-4" style="font-size: 14px">
            Silakan lengkapi data berikut untuk membuat akun warga
        </p>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="fw-bold">NIK</label>
                <input type="text"
                       name="nik"
                       class="form-control"
                       placeholder="Masukkan NIK (16 digit)"
                       maxlength="16"
                       required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Nama Lengkap</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       placeholder="Nama sesuai KTP"
                       required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Minimal 6 karakter"
                       required>
            </div>

            <button class="btn btn-success w-100 mb-2">
                Daftar
            </button>

            <div class="text-center mt-3">
                <span class="text-muted">Sudah punya akun?</span><br>
                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm mt-1">
                    Kembali ke Login
                </a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
