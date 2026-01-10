<?php
require "koneksi.php";
require "katalog.php";
require "Peminjaman.php";


// hanya anggota
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'anggota'){
    header("Location: index.php?page=login");
    exit;
}

$db = new Database();
$conn = $db->conn;

// ambil buku
$buku_id = $_GET['buku_id'] ?? null;
$katalog = new katalog_buku($conn);
$buku = $katalog->getBukuById($buku_id);

if(!$buku){
    echo "<p class='text-danger'>Buku tidak ditemukan.</p>";
    exit;
}

// instance class Peminjaman
$peminjamanClass = new Peminjaman($conn);

// submit form
$success = "";
$error = "";
if(isset($_POST['pinjam'])){
    $jenis = $_POST['jenis_peminjaman'];
    $alamat = ($jenis === 'delivery') ? $_POST['alamat_kirim'] : '';

    if($peminjamanClass->pinjamBuku($_SESSION['anggota_id'], $buku_id, $jenis, $alamat)){
        $success = "Buku berhasil dipinjam!";
    } else {
        $error = $peminjamanClass->error; // ambil pesan error dari class
    }
}

// default tanggal pinjam & kembali
$tanggal_pinjam = date('Y-m-d');
$tanggal_kembali = date('Y-m-d', strtotime('+7 days'));
$default_ongkir = "Ditanggung penerima";
?>

<div class="container mt-4">
    <h1>Pinjam Buku</h1>

    <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <div class="row">
        <div class="col-md-4">
            <img src="uploads/buku/<?= htmlspecialchars($buku['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($buku['judul']) ?>">
        </div>
        <div class="col-md-8">
            <h3><?= htmlspecialchars($buku['judul']) ?></h3>
            <p><strong>Pengarang:</strong> <?= htmlspecialchars($buku['pengarang']) ?></p>
            <p><strong>Penerbit:</strong> <?= htmlspecialchars($buku['penerbit']) ?> (<?= htmlspecialchars($buku['tahun']) ?>)</p>

            <form method="POST">
                <div class="mb-3">
                    <label>Tanggal Pinjam</label>
                    <input type="date" class="form-control" value="<?= $tanggal_pinjam ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Tanggal Kembali</label>
                    <input type="date" class="form-control" value="<?= $tanggal_kembali ?>" readonly>
                </div>

                <div class="mb-3">
                    <label>Jenis Peminjaman</label>
                    <select class="form-select" name="jenis_peminjaman" id="jenis_peminjaman" required>
                        <option value="pickup">Pickup</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>

                <div class="mb-3" id="alamat_div" style="display:none;">
                    <label>Alamat Pengiriman</label>
                    <textarea class="form-control" name="alamat_kirim" placeholder="Alamat lengkap"></textarea>
                    <small>Ongkir: <?= $default_ongkir ?></small>
                </div>

                <button type="submit" name="pinjam" class="btn btn-success">Pinjam Buku</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('jenis_peminjaman').addEventListener('change', function(){
    document.getElementById('alamat_div').style.display = this.value === 'delivery' ? 'block' : 'none';
});
</script>
