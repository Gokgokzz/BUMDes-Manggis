<?php
$host = "localhost";
$user = "root"; // sesuaikan dengan user database-mu
$pass = ""; // sesuaikan jika ada password (untuk tahap development biasanya dikosongkan/plain text)
$db   = "bumdes_manggis";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>