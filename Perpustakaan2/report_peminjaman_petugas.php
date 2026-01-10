<?php
require "koneksi.php";

if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'petugas'){
    header("Location: index.php?page=login");
    exit;
}

$db = new Database();
$conn = $db->conn;

// Query ambil semua peminjaman, gabungkan dengan detail buku
$sql = "SELECT p.id AS peminjaman_id,
               p.tanggal_kembali,
               p.tanggal_pinjam,
               p.nama_petugas AS petugas_nama,
               k.judul,
               k.pengarang,
               k.penerbit,
               k.stok,
               p.is_aktive
        FROM peminjaman p
        INNER JOIN detail_peminjaman d ON p.id = d.peminjaman_id
        INNER JOIN katalog_buku k ON d.katalog_buku_id = k.id
        ORDER BY p.nama_petugas ASC, p.tanggal_pinjam DESC";

$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h1>Report Peminjaman per Petugas</h1>

    <?php if($result->num_rows === 0): ?>
        <div class="alert alert-info">Belum ada data peminjaman.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Petugas</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Stok Saat Ini</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['petugas_nama'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['pengarang']) ?></td>
                        <td><?= htmlspecialchars($row['penerbit']) ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal_pinjam'])) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal_kembali'])) ?></td>
                        <td><?= $row['is_aktive'] == '1' ? 'On Going' : 'Selesai' ?></td>
                        <td>
                            <?php if($row['is_aktive'] == '1'): ?>
                                <a href="kembalikan.php?id=<?= $row['peminjaman_id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin mengembalikan buku ini?');">
                                    Kembalikan
                                </a>
                            <?php else: ?>
                                Sudah Dikembalikan
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
