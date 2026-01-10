<?php
session_start();

// hapus semua session
$_SESSION = [];

// hancurkan session
session_destroy();

// redirect ke home
header("Location: index.php?page=home");
exit;
