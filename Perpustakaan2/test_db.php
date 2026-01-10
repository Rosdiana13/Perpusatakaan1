<?php
require "koneksi.php";

$db = new Database();
$conn = $db->conn;

echo "<h3>Koneksi berhasil!</h3>";

$sql = "SHOW TABLES";
$result = $conn->query($sql);

echo "<b>Daftar tabel:</b><br>";

while($row = $result->fetch_array()){
    echo $row[0] . "<br>";
}
