<?php
session_start();

$page = $_GET['page'] ?? 'home';

/**
 * Halaman yang butuh login
 */
$protected_pages = [
    'katalog',
    'peminjaman',
    'buku',
    'report'
];

/**
 * Halaman khusus petugas
 */
$petugas_only = ['buku', 'report'];

/**
 *Belum login tapi akses halaman terproteksi
 */
if (in_array($page, $protected_pages) && !isset($_SESSION['login'])) {
    header("Location: index.php?page=login");
    exit;
}

/**
 * Login tapi bukan petugas
 */
if (
    in_array($page, $petugas_only)
    && isset($_SESSION['login'])
    && $_SESSION['role'] !== 'petugas'
) {
    header("Location: index.php?page=home");
    exit;
}

/**
 *Sudah login tapi buka login
 */
if ($page === 'login' && isset($_SESSION['login'])) {
    header("Location: index.php?page=katalog");
    exit;
}

/**
 * Routing halaman
 */
switch ($page) {
    case 'login':
        $page = 'login.php';
        break;

    case 'register':
        $page = 'register.php';
        break;

    case 'List_Pinjaman_anggota':
        $page = 'List_Pinjaman_anggota.php';
        break;

    case 'peminjaman_buku':
        $page = 'peminjaman_buku.php';
        break;

    case 'input_buku':
    $page = 'input_buku.php';
    break;

    case 'peminjaman_ots':
    $page = 'peminjaman_ots.php';
    break;

    case 'report':
        $page = 'report_peminjaman_petugas.php';
        break;

    case 'home':
    default:
        $page = 'home.php';
}

include 'template.php';
