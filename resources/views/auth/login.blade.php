<!DOCTYPE html>
<html>
<head>
    <title>Login Desa - Smart Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body class="bg-success bg-opacity-10 d-flex justify-content-center align-items-center" style="height: 100vh">

<div class="card shadow" style="width: 400px;">
    <div class="card-body">

        <h4 class="text-center text-success mb-4">
            <strong>Sistem Informasi Desa</strong>
        </h4>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label class="fw-bold">Email / NIK</label>
            <input type="text"
                   name="username"
                   class="form-control mb-3"
                   placeholder="Email admin atau NIK warga"
                   required>

            <label class="fw-bold">Password</label>
            <input type="password"
                   name="password"
                   class="form-control mb-3"
                   required>

            <button class="btn btn-success w-100 mb-2">Login</button>
        </form>

        <hr>

        <div class="text-center">
            <span class="text-muted">Belum punya akun?</span><br>
            <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm mt-2">
                Daftar sebagai Warga
            </a>
        </div>

    </div>
</div>

</body>
</html>
