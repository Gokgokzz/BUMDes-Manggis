<?php
session_start();
if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = uniqid('user_', true);
}
$current_user_token = $_SESSION['user_token'];
include 'koneksi.php';

// Logika Hapus Data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $cek_kepemilikan = mysqli_query($koneksi, "SELECT * FROM produk_tahunan WHERE id = $id AND user_token = '$current_user_token'");
    
    if (mysqli_num_rows($cek_kepemilikan) > 0) {
        $row_foto = mysqli_fetch_assoc($cek_kepemilikan);
        $file_foto = "uploads/" . $row_foto['foto'];
        if (!empty($row_foto['foto']) && file_exists($file_foto)) {
            unlink($file_foto); 
        }
        
        $query_hapus = "DELETE FROM produk_tahunan WHERE id = $id AND user_token = '$current_user_token'";
        if (mysqli_query($koneksi, $query_hapus)) {
            echo "<script>alert('Data produk tahunan berhasil dihapus!'); window.location.href='tahunan.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data!'); window.location.href='tahunan.php';</script>";
        }
    } else {
        echo "<script>alert('Akses ditolak!'); window.location.href='tahunan.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk Tahunan - BUMDes Manggis</title>
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
                <a href="tahunan.php" class="nav-item active">Produk Tahunan</a>
                <a href="form_tahunan.php" class="nav-item">Form</a>
            </div>
            <button class="menu-toggle" id="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Section Daftar Produk -->
    <section class="section-padding products-bg" style="margin-top: 50px;">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Katalog Pertanian</div>
                <h3 class="section-title">Daftar Produk Tahunan</h3>
            </div>
            
            <div class="products-grid">
                <?php
                $query_tampil = "SELECT * FROM produk_tahunan ORDER BY id DESC";
                $result = mysqli_query($koneksi, $query_tampil);

                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $wa = $row['no_hp'];
                        if(substr($wa, 0, 1) == '0') {
                            $wa = '62' . substr($wa, 1);
                        }
                ?>
                <div class="product-card animated-loop">
                    <div class="product-img-wrap organic-shape">
                        <img src="uploads/<?php echo $row['foto'] ? $row['foto'] : 'default-tahunan.jpg'; ?>" alt="Foto Produk">
                    </div>
                    <h4><i class="fa-solid fa-seedling"></i> <?php echo htmlspecialchars($row['nama_produk']); ?></h4>
                    <p><?php echo htmlspecialchars($row['keterangan']); ?></p>
                    
                    <a href="https://wa.me/<?php echo $wa; ?>" target="_blank" class="btn btn-product" style="background-color: #336e4f; color: white;">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi Penjual
                    </a>

                    <?php if (!empty($row['user_token']) && $row['user_token'] === $current_user_token) { ?>
                        <a href="tahunan.php?hapus=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus penawaran ini?');">
                            <i class="fa-solid fa-trash"></i> Hapus Milik Saya
                        </a>
                    <?php } ?>
                </div>
                <?php 
                    } 
                } else {
                    echo "<p class='empty-state'>Belum ada data produk tahunan yang ditawarkan.</p>";
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