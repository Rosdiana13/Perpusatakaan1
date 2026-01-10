<?php
require "koneksi.php";
require "katalog.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db   = new Database();
$conn = $db->conn;

$katalog = new katalog_buku($conn);

// Ambil keyword dari URL
$keyword = trim($_GET['keyword'] ?? '');

// Query buku langsung dari database
$filteredBuku = [];

if ($keyword !== '') {
    $sql = "SELECT * FROM katalog_buku 
            WHERE judul LIKE ? 
               OR pengarang LIKE ? 
               OR penerbit LIKE ?
            ORDER BY judul ASC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Prepare Error: " . $conn->error);
    }

    $likeKeyword = "%$keyword%";
    $stmt->bind_param("sss", $likeKeyword, $likeKeyword, $likeKeyword);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $filteredBuku[] = $row;
    }
} else {
    // Jika keyword kosong, tampilkan semua buku
    $filteredBuku = $katalog->getAllBuku();
}
?>

<div class="container mt-4">
    <h1>Hasil Pencarian Buku</h1>

    <form method="GET" action="search.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari buku..." value="<?= htmlspecialchars($keyword) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="row">
        <?php if (!empty($filteredBuku)) : ?>
            <?php foreach ($filteredBuku as $b) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="uploads/buku/<?= htmlspecialchars($b['image']) ?>" class="card-img-top" style="height:200px; object-fit:cover;" alt="<?= htmlspecialchars($b['judul']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($b['judul']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($b['pengarang']) ?></p>
                            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($b['penerbit']) ?> (<?= htmlspecialchars($b['tahun']) ?>)</small></p>

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
