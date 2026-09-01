<?php
session_start();
if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = uniqid('user_', true);
}
$current_user_token = $_SESSION['user_token'];
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Minyak Kelapa - BUMDes Manggis</title>
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
                <a href="minyak.php" class="nav-item active">Minyak VCO</a>
                <a href="form_olahan.php" class="nav-item">Form</a>
            </div>
            <button class="menu-toggle" id="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Section Katalog Minyak Kelapa -->
    <section class="section-padding products-bg" style="margin-top: 50px;">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Katalog Olahan Murni</div>
                <h3 class="section-title">Daftar Minyak VCO</h3>
            </div>
            
            <div class="products-grid">
                <?php
                $query_tampil = "SELECT * FROM produk_minyak ORDER BY id DESC";
                $result = mysqli_query($koneksi, $query_tampil);

                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                <!-- Kartu Produk Minyak (Diubah menjadi Link ke Detail Produk) -->
                <a href="detail_produk.php?id=<?php echo $row['id']; ?>&kategori=minyak" class="product-card">
                    
                    <div class="product-img-wrap organic-shape">
                        <img src="uploads/<?php echo !empty($row['foto']) ? $row['foto'] : 'default-minyak.jpg'; ?>" alt="Foto Minyak">
                    </div>
                    
                    <div class="product-info">
                        <h4><i class="fa-solid fa-flask"></i> <?php echo htmlspecialchars($row['jenis_minyak']); ?></h4>
                    </div>

                </a>
                <?php 
                    } 
                } else {
                    echo "<p class='empty-state'>Belum ada data minyak vco yang ditawarkan.</p>";
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