<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// 1. Simpan Teks CMS (termasuk Produk Utama)
if ($aksi === 'simpan_teks') {
    $kunci = $_POST['kunci'];
    $nilai = $_POST['nilai'];
    
    // Cek apakah kunci sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM konten_web WHERE kunci = '$kunci'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE konten_web SET isi = '$nilai' WHERE kunci = '$kunci'");
    } else {
        mysqli_query($conn, "INSERT INTO konten_web (kunci, isi) VALUES ('$kunci', '$nilai')");
    }
    exit();
}

// 2. Ganti Gambar Umum / Produk Utama / Wisata / Brosur
if ($aksi === 'ganti_gambar') {
    $kunci = $_POST['kunci'];
    if (isset($_FILES['file_gambar']) && $_FILES['file_gambar']['error'] === 0) {
        $namaFile = time() . '_' . $_FILES['file_gambar']['name'];
        $tmpName = $_FILES['file_gambar']['tmp_name'];
        
        // Simpan ke root folder utama
        if (move_uploaded_file($tmpName, $namaFile)) {
            $cek = mysqli_query($conn, "SELECT * FROM konten_web WHERE kunci = '$kunci'");
            if (mysqli_num_rows($cek) > 0) {
                mysqli_query($conn, "UPDATE konten_web SET isi = '$namaFile' WHERE kunci = '$kunci'");
            } else {
                mysqli_query($conn, "INSERT INTO konten_web (kunci, isi) VALUES ('$kunci', '$namaFile')");
            }
        }
    }
    header("Location: index.php#produk");
    exit();
}

// 3. Tambah Galeri (Disimpan ke folder "galeri/")
if ($aksi === 'tambah_galeri') {
    $judul = $_POST['judul'];
    if (isset($_FILES['foto_galeri']) && $_FILES['foto_galeri']['error'] === 0) {
        $namaFile = time() . '_' . $_FILES['foto_galeri']['name'];
        $tmpName = $_FILES['foto_galeri']['tmp_name'];
        
        // Pastikan folder 'galeri' ada, jika belum buat otomatis
        if (!is_dir('galeri')) {
            mkdir('galeri', 0777, true);
        }
        
        $tujuan = 'galeri/' . $namaFile;
        if (move_uploaded_file($tmpName, $tujuan)) {
            mysqli_query($conn, "INSERT INTO galeri_web (judul, foto) VALUES ('$judul', '$tujuan')");
        }
    }
    header("Location: index.php#galeri");
    exit();
}

// 4. Edit Galeri
if ($aksi === 'edit_galeri') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    
    if (isset($_FILES['foto_galeri']) && $_FILES['foto_galeri']['error'] === 0) {
        $namaFile = time() . '_' . $_FILES['foto_galeri']['name'];
        $tmpName = $_FILES['foto_galeri']['tmp_name'];
        
        if (!is_dir('galeri')) {
            mkdir('galeri', 0777, true);
        }
        
        $tujuan = 'galeri/' . $namaFile;
        if (move_uploaded_file($tmpName, $tujuan)) {
            mysqli_query($conn, "UPDATE galeri_web SET judul = '$judul', foto = '$tujuan' WHERE id = '$id'");
        }
    } else {
        mysqli_query($conn, "UPDATE galeri_web SET judul = '$judul' WHERE id = '$id'");
    }
    header("Location: index.php#galeri");
    exit();
}

// 5. Hapus Galeri (MEMPERBAIKI ERROR LAYAR PUTIH)
if ($aksi === 'hapus_galeri') {
    $id = $_GET['id'];
    
    // Ambil data foto untuk menghapus file fisiknya jika perlu
    $q = mysqli_query($conn, "SELECT foto FROM galeri_web WHERE id = '$id'");
    if ($row = mysqli_fetch_assoc($q)) {
        if (file_exists($row['foto'])) {
            unlink($row['foto']);
        }
    }
    
    mysqli_query($conn, "DELETE FROM galeri_web WHERE id = '$id'");
    header("Location: index.php#galeri");
    exit();
}
?>