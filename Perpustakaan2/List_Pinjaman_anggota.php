<?php
require "koneksi.php";

// hanya anggota
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'anggota'){
    header("Location: index.php?page=login");
    exit;
}

$db = new Database();
$conn = $db->conn;

$anggota_id = $_SESSION['anggota_id'];

// Query ambil daftar peminjaman + detail buku
// Tambahkan filter is_aktive = '1'
$sql = "SELECT p.id as peminjaman_id,
               p.tanggal_pinjam,
               p.tanggal_kembali,
               k.judul,
               k.pengarang,
               k.penerbit,
               p.is_aktive
        FROM peminjaman p
        INNER JOIN detail_peminjaman d ON p.id = d.peminjaman_id
        INNER JOIN katalog_buku k ON d.katalog_buku_id = k.id
        WHERE p.anggota_id = ? AND p.is_aktive = '1'
        ORDER BY p.tanggal_pinjam DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $anggota_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <h1>Daftar Peminjaman Saya</h1>

    <?php if($result->num_rows === 0): ?>
        <div class="alert alert-info">Belum ada buku yang dipinjam.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['pengarang']) ?></td>
                        <td><?= htmlspecialchars($row['penerbit']) ?></td>
                        <td><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></td>
                        <td><?= date('d M Y', strtotime($row['tanggal_kembali'])) ?></td>
                        <td>
                            <?= $row['is_aktive'] == '1' ? 'On Going' : '' ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
