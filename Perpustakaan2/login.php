<?php

require "koneksi.php";
require "Auth.php";

$db = new Database();
$auth = new Auth($db->conn);

$error = "";

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $user = $auth->login($username, $password);

    if($user){
        $_SESSION['login'] = true;
        $_SESSION['role']  = $user['role'];
        $_SESSION['user_id'] = $user['id']; // id anggota/petugas
        $_SESSION['nama'] = $user['nama'];  // nama untuk navbar

       if($user['role'] === 'anggota'){
            $_SESSION['anggota_id'] = $user['anggota_id'];
        }

        if($user['role'] === 'petugas'){
            $_SESSION['petugas_id'] = $user['petugas_id'];
        }


        header("Location: index.php?page=katalog");
        exit;
    } else {
        $error = "Email / Username atau password salah!";
    }
}
?>

<h3>Login</h3>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">
    <input type="text" name="username" class="form-control mb-2"
           placeholder="Email (anggota) / Username (petugas)" required>

    <input type="password" name="password" class="form-control mb-2"
           placeholder="Password" required>

    <button name="login" class="btn btn-primary w-100">
        Login
    </button>
</form>
