<?php
$host = "localhost";
$user = "root"; // default XAMPP user
$pass = "";     // default XAMPP password kosong
$db   = "kiiuutyy_db"; // ganti sesuai nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
