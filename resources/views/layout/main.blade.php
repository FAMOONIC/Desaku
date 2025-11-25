<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Desa</title>

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #152533;
            color: #d9e3ec;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            transition: width .2s ease;
        }

        .sidebar.minimized {
            width: 80px;
        }

        .sidebar.minimized .menu-text,
        .sidebar.minimized .logo-text {
            display: none;
        }

        .sidebar.minimized .logo {
            justify-content: center;
        }

        .sidebar-content {
            display: flex;
            flex-direction: column;
        }

        .sidebar-footer {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-bottom: 20px;
        }

        .toggle-btn {
            background: #0f1c26;
            border: none;
            padding: 8px;
            color: #d9e3ec;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .toggle-btn:hover { background: #1f3345; }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .icon-wrapper {
            background: #356b4f;
            color: white;
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
        }

        .logo-title {
            color: #ffffff;
            font-size: 17px;
            font-weight: bold;
        }

        .logo-sub {
            color: #c5d3dd;
            font-size: 12px;
        }

        .menu-title {
            text-transform: uppercase;
            margin-bottom: 15px;
            font-size: 12px;
            color: #8fa6b3;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            color: #d9e3ec;
            text-decoration: none;
            font-size: 14px;
            transition: 0.1s;
        }

        .menu-item:hover { color: white; }

        .menu-icon svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
        }

        .logout { color: #ffb3b3 !important; }

        .content {
            margin-left: 260px;
            padding: 30px;
            transition: margin-left .2s ease;
        }

        .sidebar.minimized + .content {
            margin-left: 80px;
        }
    </style>
</head>

<body>

<div class="sidebar" id="sidebar">

    <div class="sidebar-content">

        <!-- LOGO / HEADER -->
        <div class="logo">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>

            <div class="logo-text">
                <div class="logo-title">Desa Jawir</div>
                <div class="logo-sub">Sistem Informasi Desa</div>
            </div>
        </div>

        <div class="menu-title">Menu Utama</div>

        <!-- MENU -->
        <a href="/dashboard" class="menu-item">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke-width="1.5" d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5"/>
                </svg>
            </span>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="/arsip" class="menu-item">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke-width="1.5" d="M4 6h16M4 10h16M4 14h10"/>
                </svg>
            </span>
            <span class="menu-text">Arsip Online</span>
        </a>
        <a href="/antrian" class="menu-item">
            <span class="menu-icon">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>

            </span>
            <span class="menu-text">Antrian Online</span>
        </a>


        <a href="/jadwal" class="menu-item">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="1.5"/>
                    <path stroke-width="1.5" d="M12 7v5l3 2"/>
                </svg>
            </span>
            <span class="menu-text">Jadwal Siskamling</span>
        </a>

        <a href="/peraturan" class="menu-item">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke-width="1.5" d="M6 4h12v16H6zM9 8h6M9 12h6"/>
                </svg>
            </span>
            <span class="menu-text">Peraturan Desa</span>
        </a>

        <a href="/kegiatan-sosial" class="menu-item">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="3" stroke-width="1.5"/>
                    <circle cx="17" cy="7" r="3" stroke-width="1.5"/>
                    <path stroke-width="1.5" d="M3 21v-2a6 6 0 0 1 12 0v2"/>
                    <path stroke-width="1.5" d="M15 15a5 5 0 0 1 5 5v1"/>
                </svg>
            </span>
            <span class="menu-text">Kegiatan Sosial</span>
        </a>

        <a href="/data-penduduk" class="menu-item">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4" stroke-width="1.5"/>
                    <path stroke-width="1.5" d="M5 21v-1a7 7 0 0 1 14 0v1"/>
                </svg>
            </span>
            <span class="menu-text">Data Penduduk</span>
        </a>
    </div>

    <!-- FOOTER / LOGOUT -->
    <div class="sidebar-footer">
        <a href="/logout" class="menu-item logout">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke-width="1.5" d="M15 3h6v18h-6M9 17l-5-5 5-5M4 12h12"/>
                </svg>
            </span>
            <span class="menu-text">Keluar</span>
        </a>
    </div>

</div>

<!-- CONTENT AREA -->
<div class="content" id="content">
    @yield('content')
</div>

<!-- SIDEBAR TOGGLE SCRIPT -->
<script>
    // Cegah error kalau elemen tidak ada
    const toggleBtn = document.getElementById("toggleSidebar");
    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("minimized");
            document.getElementById("content").classList.toggle("content-minimized");
        });
    }
</script>

<!-- BOOTSTRAP JS MODAL  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
