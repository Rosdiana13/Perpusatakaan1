<?php
require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/Peminjaman.php';
require_once __DIR__ . '/katalog.php';

// Hanya petugas yang bisa akses
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'petugas'){
    header("Location: index.php?page=login");
    exit;
}

$db = new Database();
$conn = $db->conn;
$peminjaman = new Peminjaman($conn);

// Ambil daftar anggota aktif
$sql = "SELECT id, nama FROM anggota WHERE is_aktive='1'";
$result = $conn->query($sql);
$anggotaList = [];
while($row = $result->fetch_assoc()){
    $anggotaList[] = $row;
}

// Ambil daftar buku aktif
$katalog = new katalog_buku($conn);
$daftarBuku = $katalog->getAllBuku();

$error = '';
$success = '';

// Submit form
if(isset($_POST['pinjam'])){
    $anggota_id   = $_POST['anggota_id'] ?? '';
    $buku_id      = $_POST['buku_id'] ?? '';
    $nama_petugas = trim($_POST['nama_petugas'] ?? '');

    if(!$anggota_id || !$buku_id || !$nama_petugas){
        $error = "Harap isi semua field.";
    } else {
        try {
            $peminjaman->pinjamBuku(
                $anggota_id,
                $buku_id,
                'pickup',        // jenis peminjaman on the spot = pickup
                '',              // alamat kosong
                $nama_petugas    // created_by & nama_petugas
            );
            $success = "Buku berhasil dipinjam oleh anggota!";
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    }
}
?>

<div class="container mt-4">
    <h2>Peminjaman On The Spot</h2>

    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nama Petugas</label>
            <input type="text" name="nama_petugas" class="form-control" placeholder="Masukkan nama petugas" required>
        </div>

        <div class="mb-3">
            <label>Anggota</label>
            <select name="anggota_id" class="form-select" required>
                <option value="">-- Pilih Anggota --</option>
                <?php foreach($anggotaList as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Buku</label>
            <select name="buku_id" class="form-select" required>
                <option value="">-- Pilih Buku --</option>
                <?php foreach($daftarBuku as $b): ?>
                    <option value="<?= $b['id'] ?>">
                        <?= htmlspecialchars($b['judul']) ?> (Stok: <?= $b['stok'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="pinjam" class="btn btn-success">Pinjam Buku</button>
    </form>
</div>
