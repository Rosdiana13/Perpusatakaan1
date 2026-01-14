<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <!-- @yield('title') → judul halaman bisa diubah dari view lain Kalau tidak diisi → default: Sistem Perpustakaan -->
    <title>@yield('title', 'Sistem Perpustakaan')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="d-flex flex-column min-vh-100">

<!-- ================= HEADER / NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            📚 Perpustakaan
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
    <!-- {{-- Semua user bisa lihat Home --}} -->
    <li class="nav-item">
        <a class="nav-link {{ request()->is('/') || request()->is('home') ? 'active' : '' }}" href="{{ url('/') }}">
            Home
        </a>
    </li>

    <!--adalah cara Laravel untuk mengambil data dari Session (penyimpanan sementara user). -->
    <?php if(\Illuminate\Support\Facades\Session::get('role') == 'anggota'): ?>
        <li class="nav-item">
                <!--Menandai menu aktif jika sedang di halaman home. Sesuai Rooter yang di buat -->
                <a class="nav-link {{ request()->is('peminjaman') ? 'active' : '' }}" href="{{ url('/peminjaman') }}">
                    List Peminjaman
                </a>
            </li>
        <?php elseif(\Illuminate\Support\Facades\Session::get('role') == 'petugas'): ?>
            <!-- {{-- Menu untuk petugas --}} -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('katalog/input') ? 'active' : '' }}" href="{{ url('/katalog/input') }}">
                    Input Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('peminjaman/online') ? 'active' : '' }}" href="{{ url('/peminjaman/online') }}">
                    List Online
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('peminjaman/all') ? 'active' : '' }}" 
                href="{{ url('/peminjaman/all') }}">
                    List All Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pinjam-offline*') ? 'active' : '' }}" 
                href="{{ url('/pinjam-offline') }}">
                    Pinjam Offline
                </a>
            </li>
        <?php endif; ?>

        <!-- {{-- Logout muncul jika sudah login --}} -->
        <?php if(\Illuminate\Support\Facades\Session::has('role')): ?>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ url('/login') }}">
                    Login
                </a>
            </li>
        <?php endif; ?>
    </ul>

        </div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<main class="flex-fill">
    <div class="container py-4">
        @yield('content')
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">
        <small>
            © {{ date('Y') }} Sistem Perpustakaan | LSP
        </small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
