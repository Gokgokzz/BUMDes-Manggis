<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    // Menangkap data dari form (nama variabel disesuaikan dengan input name di HTML)
    $jumlah = mysqli_real_escape_string($koneksi, $_POST['jumlah']);
    $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // Pastikan urutan VALUES sesuai dengan urutan kolom di tabel
    $query = "INSERT INTO produk_sapi (jumlah_sapi, jenis_sapi, no_hp, keterangan) 
              VALUES ('$jumlah', '$jenis', '$no_hp', '$keterangan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data sapi berhasil ditawarkan!'); window.location.href='sapi.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>