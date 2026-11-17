<?php
$host = "localhost";
$user = "root"; // sesuaikan dengan user database-mu
$pass = ""; // sesuaikan jika ada password (untuk tahap development biasanya dikosongkan/plain text)
$db   = "bumdes_manggis";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function getKonten($conn, $kunci) {
    $q = mysqli_query($conn, "SELECT nilai FROM konten_web WHERE kunci = '$kunci'");
    if ($row = mysqli_fetch_assoc($q)) {
        return $row['nilai'];
    }
    return "";
}
?>