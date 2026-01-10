<?php
require "koneksi.php";
require "katalog.php";

$db   = new Database();
$conn = $db->conn;

$katalog = new katalog_buku($conn);
$daftarBuku = $katalog->getAllBuku();

// Filter search
$keyword = $_GET['keyword'] ?? '';
$filteredBuku = [];

if($keyword !== ''){
    foreach($daftarBuku as $b){
        if(stripos($b['judul'], $keyword) !== false || stripos($b['pengarang'], $keyword) !== false){
            $filteredBuku[] = $b;
        }
    }
} else {
    $filteredBuku = $daftarBuku;
}
?>

<div class="container mt-4">
    <h1>Daftar Buku Perpustakaan LSP</h1>

    <form method="GET" action="index.php" class="mb-4">
        <input type="hidden" name="page" value="home">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari buku..." value="<?= htmlspecialchars($keyword) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="row">
        <?php if(!empty($filteredBuku)) : ?>
            <?php foreach($filteredBuku as $b) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="uploads/buku/<?= $b['image'] ?>" class="card-img-top" style="height:200px; object-fit:cover;" alt="<?= $b['judul'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $b['judul'] ?></h5>
                            <p class="card-text"><?= $b['pengarang'] ?></p>
                            <p class="card-text"><small class="text-muted"><?= $b['penerbit'] ?> (<?= $b['tahun'] ?>)</small></p>

                            <?php if(isset($_SESSION['login']) && $_SESSION['role'] === 'anggota'): ?>
                                <a href="index.php?page=peminjaman_buku&buku_id=<?= $b['id'] ?>" class="btn btn-success mt-2">Pinjam</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Buku tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</div>
