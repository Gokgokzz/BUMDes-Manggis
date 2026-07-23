<?php
// Memulai sesi untuk mengenali perangkat/pengguna
session_start();

// Jika pengguna belum memiliki session_id unik di browser ini, buatkan satu
if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = uniqid('user_', true);
}
$current_user_token = $_SESSION['user_token'];

// Memanggil koneksi database
include 'koneksi.php';

// Logika untuk menghapus data (dengan validasi keamanan token)
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // Pastikan data yang akan dihapus benar-benar milik token user ini
    $cek_kepemilikan = mysqli_query($koneksi, "SELECT * FROM produk_sapi WHERE id = $id AND user_token = '$current_user_token'");
    
    if (mysqli_num_rows($cek_kepemilikan) > 0) {
        $row_foto = mysqli_fetch_assoc($cek_kepemilikan);
        $file_foto = "uploads/" . $row_foto['foto'];
        
        // Hapus file fisik gambar jika ada
        if (!empty($row_foto['foto']) && file_exists($file_foto)) {
            unlink($file_foto); 
        }
        
        // Query hapus data dari database
        $query_hapus = "DELETE FROM produk_sapi WHERE id = $id AND user_token = '$current_user_token'";
        if (mysqli_query($koneksi, $query_hapus)) {
            echo "<script>alert('Data sapi Anda berhasil dihapus!'); window.location.href='sapi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data!'); window.location.href='sapi.php';</script>";
        }
    } else {
        // Jika mencoba menghapus data milik orang lain lewat URL/Inspect Element
        echo "<script>alert('Akses ditolak! Anda tidak berhak menghapus data milik orang lain.'); window.location.href='sapi.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sapi Tersedia - BUMDes Manggis</title>
    <link rel="icon" href="logo website bumdes manggis.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar -->
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
                <a href="sapi.php" class="nav-item active">Produk Sapi</a>
                <a href="form_sapi.php" class="nav-item">Form</a>
            </div>
            <button class="menu-toggle" id="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Section Hasil Input (Daftar Sapi) -->
    <section class="section-padding products-bg" style="margin-top: 50px;">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Katalog Peternakan</div>
                <h3 class="section-title">Daftar Sapi Tersedia</h3>
            </div>
            
            <div class="products-grid">
                <?php
                $query_tampil = "SELECT * FROM produk_sapi ORDER BY id DESC";
                $result = mysqli_query($koneksi, $query_tampil);

                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $wa = $row['no_hp'];
                        if(substr($wa, 0, 1) == '0') {
                            $wa = '62' . substr($wa, 1);
                        }
                ?>
                <!-- Kartu Produk Sapi -->
                <div class="product-card animated-loop">
                    <div class="product-img-wrap organic-shape">
                        <img src="uploads/<?php echo $row['foto'] ? $row['foto'] : 'default-sapi.jpg'; ?>" alt="Foto Sapi">
                    </div>
                    <h4><i class="fa-solid fa-cow"></i> <?php echo htmlspecialchars($row['jenis_sapi']); ?></h4>
                    <p><?php echo htmlspecialchars($row['keterangan']); ?></p>
                    
                    <!-- Tombol Hubungi WhatsApp -->
                    <a href="https://wa.me/<?php echo $wa; ?>" target="_blank" class="btn btn-product" style="background-color: #336e4f; color: white;">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi Pemilik
                    </a>

                    <!-- Tombol Hapus: Hanya muncul jika data ini milik sesi browser yang sedang aktif -->
                    <?php if (!empty($row['user_token']) && $row['user_token'] === $current_user_token) { ?>
                        <a href="sapi.php?hapus=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus penawaran sapi ini?');">
                            <i class="fa-solid fa-trash"></i> Hapus Milik Saya
                        </a>
                    <?php } ?>
                </div>
                <?php 
                    } 
                } else {
                    echo "<p class='empty-state'>Belum ada data sapi yang ditawarkan.</p>";
                }
                ?>
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