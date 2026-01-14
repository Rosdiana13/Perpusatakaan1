<?php

// memanggil class Route milik Laravel supaya kita bisa memakai fitur routing.
use Illuminate\Support\Facades\Route;

// Digunakan agar route bisa memanggil controller dan model yang dibutuhkan.
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KatalogBukuController;
use App\Models\KatalogBuku;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AnggotaController;

// Jika buka website (/), otomatis diarahkan ke halaman home.
Route::get('/', function () {
    return redirect('/home');   // optional
});

// Menampilkan halaman home yang berisi semua data buku dari database.
Route::get('/home', function () {
    $buku = KatalogBuku::all();
    return view('home', compact('buku'));
});

// Mengatur halaman login, proses login, dan logout pengguna.
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

// Untuk input dan simpan data buku ke katalog.
Route::get('/katalog/input', [KatalogBukuController::class, 'create']);
Route::post('/katalog/simpan', [KatalogBukuController::class, 'store']);

// Menampilkan detail buku yang akan dipinjam dan menyimpan transaksi peminjaman.
Route::get('/pinjam/{id}', [PeminjamanController::class, 'detail']);
Route::post('/pinjam/simpan', [PeminjamanController::class, 'simpan']);

// Menampilkan riwayat peminjaman user.
Route::get('/riwayat-pinjam', [PeminjamanController::class, 'riwayat']);

// Menampilkan daftar peminjaman:
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/online', [PeminjamanController::class, 'listOnline']);
Route::get('/peminjaman/all', [PeminjamanController::class, 'listAll']);

// Untuk pendaftaran anggota baru perpustakaan.
Route::get('/registrasi', [AnggotaController::class, 'create']);
Route::post('/registrasi/simpan', [AnggotaController::class, 'store']);

// Digunakan petugas untuk input peminjaman langsung di tempat (offline).
Route::get('/pinjam-offline', [PeminjamanController::class, 'offlineForm']);
Route::post('/pinjam-offline/simpan', [PeminjamanController::class, 'simpanOffline']);

Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan']);
