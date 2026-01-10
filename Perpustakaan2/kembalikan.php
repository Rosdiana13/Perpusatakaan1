<?php
require "koneksi.php";
session_start();

// hanya petugas
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'petugas'){
    header("Location: index.php?page=login");
    exit;
}

$db = new Database();
$conn = $db->conn;

$id = $_GET['id'] ?? null;

if($id){
    // ambil semua buku dari peminjaman
    $sqlDetail = "SELECT katalog_buku_id FROM detail_peminjaman WHERE peminjaman_id = ?";
    $stmt = $conn->prepare($sqlDetail);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $buku_id = $row['katalog_buku_id'];
        // tambah stok kembali
        $sqlUpdateStok = "UPDATE katalog_buku SET stok = stok + 1 WHERE id = ?";
        $stmtStok = $conn->prepare($sqlUpdateStok);
        $stmtStok->bind_param("s", $buku_id);
        $stmtStok->execute();
    }

    // update peminjaman menjadi selesai
    $sqlUpdate = "UPDATE peminjaman SET is_aktive = '0' WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("s", $id);
    $stmtUpdate->execute();

    // redirect kembali ke report
    header("Location: report_peminjaman_petugas.php");
    exit;
} else {
    echo "ID peminjaman tidak valid.";
}
