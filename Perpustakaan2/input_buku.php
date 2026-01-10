<?php


if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'petugas') {
    header("Location: index.php?page=login");
    exit;
}

require "koneksi.php";
require "Buku.php";

$db   = new Database();
$conn = $db->conn;
$buku = new Buku($conn);

$success = "";
$error = "";

if(isset($_POST['simpan'])){

    if(!isset($_SESSION['petugas_id'])){
        $error = "Session petugas tidak ditemukan. Login ulang.";
    } else {

        $data = [
            'judul'       => $_POST['judul'],
            'pengarang'   => $_POST['pengarang'],
            'penerbit'    => $_POST['penerbit'],
            'tahun'       => $_POST['tahun'],
            'stok'        => $_POST['stok'],
            'created_by'  => $_SESSION['petugas_id']
        ];

        if($buku->insert($data, $_FILES)){
            $success = "Buku berhasil ditambahkan";
        } else {
            $error = "Gagal upload gambar atau simpan data";
        }
    }
}
?>


<h3>Input Data Buku</h3>

<?php if($success){ ?>
<div class="alert alert-success"><?= $success ?></div>
<?php } ?>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

    <input name="judul" class="form-control mb-2" placeholder="Judul Buku" required>

    <input name="pengarang" class="form-control mb-2" placeholder="Pengarang" required>

    <input name="penerbit" class="form-control mb-2" placeholder="Penerbit" required>

    <input type="number" name="tahun" class="form-control mb-2" placeholder="Tahun Terbit" required>

    <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" required>

    <input type="file" name="image" class="form-control mb-3" required>

    <button name="simpan" class="btn btn-primary w-100">
        Simpan Buku
    </button>
</form>
