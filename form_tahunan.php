<?php
session_start();
if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = uniqid('user_', true);
}
$current_user_token = $_SESSION['user_token'];
include 'koneksi.php';

// Logika ketika form di-submit (Tetap di halaman form setelah sukses)
if (isset($_POST['submit'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    
    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $path = "uploads/" . $foto;
    
    if(move_uploaded_file($tmp_name, $path) || empty($foto)) {
        $query = "INSERT INTO produk_tahunan (nama_produk, no_hp, keterangan, foto, user_token) 
                  VALUES ('$nama_produk', '$no_hp', '$keterangan', '$foto', '$current_user_token')";

        if (mysqli_query($koneksi, $query)) {
            // Tetap diam di halaman form setelah berhasil
            echo "<script>alert('Data produk berhasil ditawarkan!'); window.location.href='form_tahunan.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penjualan Produk Tahunan - BUMDes Manggis</title>
    <link rel="icon" href="logo website bumdes manggis.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar Sesuai Permintaan -->
    <nav class="navbar" id="navbar">
        <div class="container nav-content">
            <a href="index.html" class="logo">
                <i class="fa-solid fa-leaf"></i>
                <div>
                    <h1>BUMDes<br><span>MANGGIS</span></h1>
                    <p>Karangasem</p>
                </div>
            </a>
            <div class="nav-links" id="nav-links">
                <a href="index.html#produk" class="nav-item">Beranda</a>
                <a href="tahunan.php" class="nav-item">Produk Tahunan</a>
                <a href="form_tahunan.php" class="nav-item active">Form</a>
            </div>
            <button class="menu-toggle" id="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Section Form Tambah Produk -->
    <section class="form-section" style="padding: 60px 0;">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Registrasi Produk</div>
                <h3 class="section-title">Form Penjualan Produk Tahunan</h3>
            </div>
            
            <div class="form-card">
                <form action="form_tahunan.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto"><i class="fa-solid fa-camera"></i> Foto Produk</label>
                        <input type="file" name="foto" id="foto" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk"><i class="fa-solid fa-seedling"></i> Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" placeholder="Contoh: Buah Manggis, Durian, Kelapa..." required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan"><i class="fa-solid fa-align-left"></i> Deskripsi / Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="4" placeholder="Jelaskan kualitas panen, harga borongan/ecer, dll..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp"><i class="fa-brands fa-whatsapp"></i> No WhatsApp Penjual</label>
                        <input type="number" name="no_hp" id="no_hp" placeholder="Contoh: 6281234567890" required>
                    </div>
                    <button type="submit" name="submit" class="btn-submit"><i class="fa-solid fa-paper-plane"></i> Tampilkan Produk</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="copyright">
            <p>&copy; 2026 BUMDes Manggis Karangasem. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>