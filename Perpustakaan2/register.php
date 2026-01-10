<?php
require "koneksi.php";
require "Anggota.php";

$db = new Database();
$anggota = new Anggota($db->conn);

$error = "";
$success = "";

if(isset($_POST['register'])){
    $data = [
        'nama'     => $_POST['nama'],
        'alamat'   => $_POST['alamat'],
        'nohp'     => $_POST['nohp'],
        'email'    => $_POST['email'],
        'password' => $_POST['password']
    ];

    $result = $anggota->register($data);

    if($result['status']){
        $success = $result['message'];
    } else {
        $error = $result['message'];
    }
}
?>

<h3>Daftar Anggota</h3>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<?php if($success){ ?>
<div class="alert alert-success"><?= $success ?></div>
<?php } ?>

<form method="POST">
    <input name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
    <textarea name="alamat" class="form-control mb-2" placeholder="Alamat" required></textarea>
    <input name="nohp" class="form-control mb-2" placeholder="No HP" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

    <button name="register" class="btn btn-success w-100">
        Daftar
    </button>
</form>
