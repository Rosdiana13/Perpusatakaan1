<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .container.mt-4 {
        flex: 1; /* agar konten mengisi sisa tinggi layar */
    }

    footer {
        flex-shrink: 0; /* jangan mengecil */
    }
</style>

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- <a class="navbar-brand" href="index.php">Perpustakaan</a> -->
       <a class="navbar-brand" href="index.php">
    <i class="bi bi-person-circle"></i>
    <?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Perpustakaan'; ?>
</a>




        <ul class="navbar-nav ms-auto">
            <ul class="navbar-nav ms-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Home</a>
                </li>

<?php if(isset($_SESSION['login'])){ ?>

            <?php if($_SESSION['role'] === 'anggota'){ ?>
                <!-- MENU ANGGOTA -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=List_Pinjaman_anggota">List Pinjaman</a>
                </li>
            <?php } ?>

            <?php if($_SESSION['role'] === 'petugas'){ ?>
                <!-- MENU PETUGAS -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=input_buku">Input Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=report">Report Peminjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=peminjaman_ots">Peminjaman on thespot</a>
                </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link text-warning" href="logout.php">Logout</a>
            </li>

        <?php } else { ?>

            <!-- BELUM LOGIN -->
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=register">Daftar</a>
            </li>

        <?php } ?>

        </ul>


        </ul>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">
    <?php
    if(file_exists($page)){
        include $page;
    } else {
        echo "<div class='alert alert-danger'>Halaman tidak ditemukan</div>";
    }
    ?>
</div>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-3 mt-5">
    Sistem Perpustakaan © <?= date('Y') ?>
</footer>

</body>
</html>
