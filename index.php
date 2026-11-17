<?php
session_start();
require 'koneksi.php';

// Jika belum memilih role/login, arahkan ke halaman login
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}
$is_admin = ($_SESSION['role'] === 'admin');

// Ambil data galeri dari database
$galeri_query = mysqli_query($conn, "SELECT * FROM galeri_web ORDER BY id ASC");
$galeri_list = [];
while ($row = mysqli_fetch_assoc($galeri_query)) {
    $galeri_list[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUMDes Manggis Karangasem</title>
    <meta name="description"
        content="Website Resmi BUMDes Manggis, Karangasem. Menjual produk unggulan desa seperti Sapi, Buah Manggis, dan Minyak VCO.">
    <meta name="keywords" content="BUMDes Manggis, Karangasem, Sapi Bali, Minyak VCO, Buah Manggis, UMKM Desa">
    <meta name="author" content="BUMDes Manggis">
    <meta property="og:title" content="BUMDes Manggis Karangasem - Membangun Ekonomi Desa">
    <meta property="og:description"
        content="Temukan produk unggulan lokal berkualitas dari BUMDes Manggis. Mari dukung UMKM desa!">
    <meta property="og:image" content="gambar-thumbnail.jpg">
    <meta property="og:url" content="https://www.bumdesmanggis.com">
    <meta property="og:type" content="website">
    <link rel="icon" href="logo website bumdes manggis.png" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="user-status-bar"
        style="background: <?= $is_admin ? '#1E4629' : '#2E6F40'; ?>; color: #fff; padding: 8px 20px; font-size: 0.85rem; display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1001;">
        <div>
            <i class="fa-solid <?= $is_admin ? 'fa-user-shield' : 'fa-user-check'; ?>"
                style="margin-right: 8px; color: #8BE78B;"></i>
            Status Login: <b><?= htmlspecialchars($_SESSION['username']); ?></b>
            <?php if ($is_admin): ?>
                <span
                    style="background: #8BE78B; color: #1E4629; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; margin-left: 10px;">AKSES
                    PENUH AKTIF</span>
            <?php endif; ?>
        </div>
        <div>
            <?php if ($is_admin): ?>
                <button id="btnModeEdit" class="btn"
                    style="background: #8BE78B; color: #1E4629; padding: 4px 12px; font-size: 0.75rem; margin-right: 10px; cursor: pointer; border: none; border-radius: 4px;">
                    <i class="fa-solid fa-pen-to-square"></i> Mode Edit Web (CMS)
                </button>
            <?php endif; ?>
            <a href="logout.php" style="color: #ffcccc; text-decoration: underline; font-weight: 500;">Keluar / Ganti
                Akun</a>
        </div>
    </div>

    <div class="loader-wrapper" id="loader-wrapper">
        <div class="loader-content">
            <div class="manggis-cluster">
                <div class="manggis-item manggis-main">
                    <div class="manggis-cap"></div>
                </div>
                <div class="manggis-item manggis-sub-1">
                    <div class="manggis-cap"></div>
                </div>
                <div class="manggis-item manggis-sub-2">
                    <div class="manggis-cap"></div>
                </div>

                <i class="fa-solid fa-leaf leaf-deco leaf-1"></i>
                <i class="fa-solid fa-leaf leaf-deco leaf-2"></i>
                <i class="fa-solid fa-leaf leaf-deco leaf-3"></i>
            </div>

            <div class="loader-text">
                <span class="text-main">Memuat</span>
                <span class="text-village">Desa Manggis</span>
                <div class="load-dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar" id="navbar">
        <div class="container nav-content">
            <a href="index.php" class="logo">
                <i class="fa-solid fa-leaf"></i>
                <div>
                    <h1>BUMDes<br><span>MANGGIS</span></h1>
                    <p>Karangasem</p>
                </div>
            </a>

            <button class="menu-toggle" id="menu-toggle" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="nav-links" id="nav-links">
                <a href="index.php" class="nav-item active">Beranda</a>
                <a href="#tentang" class="nav-item">Tentang Kami</a>
                <a href="#produk" class="nav-item">Produk</a>
                <a href="#galeri" class="nav-item">Galeri</a>
                <a href="#kontak" class="nav-item">Kontak</a>

                <div class="nav-item-dropdown hide-on-mobile">
                    <a href="#iconnet" class="nav-item">
                        <span style="color: navy; font-weight: 600;">ICON</span><span
                            style="color: #088F8F; font-weight: 600;">NET</span>
                        <i class="fa-solid fa-caret-down"
                            style="font-size: 0.8em; margin-left: 5px; color: var(--text-main);"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="pendaftaran-pelanggan.php">Pasang Wi-Fi Iconnet</a>
                        <div class="dropdown-submenu-container">
                            <a href="form-lowongan.php" class="dropdown-sub-toggle">Lowongan Pekerjaan <i
                                    class="fa-solid fa-caret-right"></i></a>
                            <div class="dropdown-submenu">
                                <a href="form-lowongan.php?divisi=mitra-individu">Mitra Individu (Freelance)</a>
                                <a href="form-lowongan.php?divisi=agen-sales">Agen Sales</a>
                                <a href="form-lowongan.php?divisi=teknisi">Teknisi Aktivasi & Pemeliharaan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero" id="beranda">
            <div class="container">
                <div class="hero-wrapper">

                    <div class="hero-image">
                        <div class="hero-team-photo-wrap">
                            <div style="position: relative; height: 100%;">
                                <img src="<?= getKonten($conn, 'foto_sekretaris'); ?>"
                                    alt="Pengurus BUMDes Manggis: I Wayan Sumadi" class="hero-team-photo"
                                    fetchpriority="high">
                                <button class="admin-img-btn"
                                    onclick="bukaModalGambar('foto_sekretaris', 'Foto Sekretaris')"><i
                                        class="fa-solid fa-camera"></i> Ganti</button>
                            </div>

                            <div style="position: relative; height: 100%;">
                                <img src="<?= getKonten($conn, 'foto_bendahara'); ?>"
                                    alt="Pengurus BUMDes Manggis: Ni Komang Ayu Suari Dewi"
                                    class="hero-team-photo photo-tengah" fetchpriority="high">
                                <button class="admin-img-btn"
                                    onclick="bukaModalGambar('foto_bendahara', 'Foto Bendahara')"><i
                                        class="fa-solid fa-camera"></i> Ganti</button>
                            </div>

                            <div style="position: relative; height: 100%;">
                                <img src="<?= getKonten($conn, 'foto_direktur'); ?>"
                                    alt="Pengurus BUMDes Manggis: I Gede Saputra Wisnawa, SE" class="hero-team-photo"
                                    fetchpriority="high">
                                <button class="admin-img-btn"
                                    onclick="bukaModalGambar('foto_direktur', 'Foto Direktur')"><i
                                        class="fa-solid fa-camera"></i> Ganti</button>
                            </div>
                        </div>

                        <div class="hero-team-labels" aria-label="Susunan pengurus BUMDes Manggis">
                            <div class="hero-person-card border-kiri">
                                <span class="role">SEKRETARIS</span>
                                <span class="name"
                                    data-kunci="nama_sekretaris"><?= getKonten($conn, 'nama_sekretaris'); ?></span>
                            </div>

                            <div class="hero-person-card border-tengah">
                                <span class="role">BENDAHARA</span>
                                <span class="name"
                                    data-kunci="nama_bendahara"><?= getKonten($conn, 'nama_bendahara'); ?></span>
                            </div>

                            <div class="hero-person-card border-kanan">
                                <span class="role">DIREKTUR</span>
                                <span class="name" data-kunci="nama_direktur"
                                    style="white-space: nowrap;"><?= getKonten($conn, 'nama_direktur'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-content">
                        <h2 data-kunci="hero_judul"><?= getKonten($conn, 'hero_judul'); ?></h2>
                        <p data-kunci="hero_deskripsi"><?= getKonten($conn, 'hero_deskripsi'); ?></p>
                        <div class="hero-buttons">
                            <a href="#produk" class="btn btn-brand"><i class="fa-solid fa-leaf"></i> Lihat Produk</a>
                            <a href="#kontak" class="btn btn-outline"><i class="fa-brands fa-whatsapp"></i> Hubungi
                                WhatsApp</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="welcome-marquee">
            <div class="marquee-track">
                <div class="marquee-content">
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                </div>
                <div class="marquee-content" aria-hidden="true">
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                    <span><i class="fa-solid fa-store"></i> BUMDes Manggis x <b><span
                                class="iconnet-icon">ICON</span><span class="iconnet-net">NET</span></b></span>
                </div>
            </div>
        </div>

        <section class="section-padding reveal" id="tentang">
            <div class="container">
                <div class="about-wrap">

                    <div class="about-left">
                        <div class="about-img-box hover-float" style="position: relative;">
                            <img src="<?= getKonten($conn, 'foto_struktur'); ?>" alt="Struktur BUMDes Manggis"
                                width="600" height="400" loading="lazy" decoding="async">
                            <button class="admin-img-btn"
                                onclick="bukaModalGambar('foto_struktur', 'Gambar Struktur Organisasi')"><i
                                    class="fa-solid fa-camera"></i> Ganti Foto Struktur</button>
                        </div>

                        <div class="vm-grid">
                            <div class="vm-item">
                                <div class="vm-icon"><i class="fa-solid fa-eye"></i></div>
                                <div>
                                    <h4>Visi</h4>
                                    <p data-kunci="visi_teks"><?= getKonten($conn, 'visi_teks'); ?></p>
                                </div>
                            </div>
                            <div class="vm-item">
                                <div class="vm-icon"><i class="fa-solid fa-bullseye"></i></div>
                                <div>
                                    <h4>Misi</h4>
                                    <p data-kunci="misi_teks"><?= getKonten($conn, 'misi_teks'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="about-text">
                        <div class="section-tag">Tentang Kami</div>
                        <h3 class="section-title" data-kunci="tentang_judul"><?= getKonten($conn, 'tentang_judul'); ?>
                        </h3>

                        <p data-kunci="tentang_deskripsi"><?= getKonten($conn, 'tentang_deskripsi'); ?></p>
                    </div>

                </div>
            </div>
            <div class="wave-deco"></div>
        </section>

        <div class="brosur-wrapper" style="position: relative;">
            <img src="<?= getKonten($conn, 'brosur_1'); ?>" alt="Brosur BUMDes Manggis" class="img-brosur img-elevated"
                width="1200" height="675" loading="lazy" decoding="async">
            <button class="admin-img-btn" onclick="bukaModalGambar('brosur_1', 'Gambar Brosur Utama')"><i
                    class="fa-solid fa-camera"></i> Ganti Brosur 1</button>
        </div>

        <section class="section-padding products-bg reveal" id="produk">
            <div class="container">
                <div class="section-header">
                    <div class="section-tag">Produk Unggulan</div>
                    <h3 class="section-title">Produk Utama Kami</h3>
                </div>
                <div class="products-grid">

                    <!-- Produk 1: Ketahanan Pangan -->
                    <div class="product-card hover-float" style="position: relative;">
                        <?php if ($is_admin): ?>
                            <button class="admin-img-btn"
                                onclick="bukaModalGambar('img_produk_1', 'Foto Produk Ketahanan Pangan')"
                                style="display:inline-flex; top: 15px; right: 15px;"><i class="fa-solid fa-camera"></i>
                                Ganti Foto</button>
                        <?php endif; ?>
                        <div class="product-img-wrap organic-shape">
                            <img src="<?= getKonten($conn, 'img_produk_1') ?: 'contoh-peternakan-sapi.jpeg'; ?>"
                                alt="Unit Peternakan Sapi" width="400" height="300" loading="lazy" decoding="async">
                        </div>
                        <h4 data-kunci="judul_produk_1">
                            <?= getKonten($conn, 'judul_produk_1') ?: 'Program <br>Ketahanan Pangan'; ?></h4>
                        <p data-kunci="desc_produk_1">
                            <?= getKonten($conn, 'desc_produk_1') ?: 'Terdapat sapi berkualitas yang dapat sesuai dengan kebutuhan/keinginan anda.'; ?>
                        </p>
                        <a href="sapi.php" class="btn btn-product">
                            <i class="fa-brands"></i>Lihat
                        </a>
                    </div>

                    <!-- Produk 2: Produk Tahunan -->
                    <div class="product-card hover-float" style="position: relative;">
                        <?php if ($is_admin): ?>
                            <button class="admin-img-btn" onclick="bukaModalGambar('img_produk_2', 'Foto Produk Tahunan')"
                                style="display:inline-flex; top: 15px; right: 15px;"><i class="fa-solid fa-camera"></i>
                                Ganti Foto</button>
                        <?php endif; ?>
                        <div class="product-img-wrap organic-shape">
                            <img src="<?= getKonten($conn, 'img_produk_2') ?: 'contoh-produk-tahunan.jpg'; ?>"
                                alt="Unit Pertanian Manggis" width="400" height="300" loading="lazy" decoding="async">
                        </div>
                        <h4 data-kunci="judul_produk_2">
                            <?= getKonten($conn, 'judul_produk_2') ?: 'Produk <br>Tahunan'; ?></h4>
                        <p data-kunci="desc_produk_2">
                            <?= getKonten($conn, 'desc_produk_2') ?: 'Terdapat produk-produk tahunan/musiman yg menarik, seperti buah manggis, dsb.'; ?>
                        </p>
                        <a href="tahunan.php" class="btn btn-product">
                            <i class="fa-brands"></i>Lihat
                        </a>
                    </div>

                    <!-- Produk 3: Minyak VCO -->
                    <div class="product-card hover-float" style="position: relative;">
                        <?php if ($is_admin): ?>
                            <button class="admin-img-btn" onclick="bukaModalGambar('img_produk_3', 'Foto Minyak VCO')"
                                style="display:inline-flex; top: 15px; right: 15px;"><i class="fa-solid fa-camera"></i>
                                Ganti Foto</button>
                        <?php endif; ?>
                        <div class="product-img-wrap organic-shape">
                            <img src="<?= getKonten($conn, 'img_produk_3') ?: 'contoh-vco.jpg'; ?>"
                                alt="Unit Olahan Kelapa" width="400" height="300" loading="lazy" decoding="async">
                        </div>
                        <h4 data-kunci="judul_produk_3"><?= getKonten($conn, 'judul_produk_3') ?: 'Minyak <br>VCO'; ?>
                        </h4>
                        <p data-kunci="desc_produk_3">
                            <?= getKonten($conn, 'desc_produk_3') ?: 'Memproduksi minyak bersih untuk kebutuhan anda yg terbuat dari parutan kelapa murni.'; ?>
                        </p>
                        <a href="minyak.php" class="btn btn-product">
                            <i class="fa-brands"></i>Lihat
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <div class="brosur-wrapper" style="position: relative;">
            <img src="<?= getKonten($conn, 'brosur_2'); ?>" alt="Brosur BUMDes Manggis" class="img-brosur img-elevated"
                width="1500" height="675" loading="lazy" decoding="async">
            <button class="admin-img-btn" onclick="bukaModalGambar('brosur_2', 'Gambar Brosur Kedua')"><i
                    class="fa-solid fa-camera"></i> Ganti Brosur 2</button>
        </div>

        <section class="section-padding products-bg reveal" id="galeri">
            <div class="container">
                <div class="section-header">
                    <div class="section-tag">Aktivitas Desa</div>
                    <h3 class="section-title">Dokumentasi & Galeri Kerja</h3>
                    <?php if ($is_admin): ?>
                        <div style="margin-top: 20px;">
                            <button onclick="document.getElementById('modalTambahGaleri').classList.add('open')"
                                class="btn btn-brand">
                                <i class="fa-solid fa-plus"></i> Tambah Foto Galeri Baru
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- CAROUSEL WRAPPER (MEMPERTAHANKAN SISTEM PERULANGAN SLIDER) -->
                <div class="gallery-carousel-wrapper">
                    <button class="gallery-arrow gallery-prev" id="galleryPrev" aria-label="Halaman Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <div class="gallery-slider-track" id="gallerySliderTrack">
                        <?php
                        // Memecah data galeri per 8 item untuk membentuk halaman/slide baru secara otomatis
                        $chunks = array_chunk($galeri_list, 8);
                        if (empty($chunks)) {
                            $chunks = [[]];
                        }
                        foreach ($chunks as $page_items):
                            ?>
                            <div class="gallery-page">
                                <div class="gallery-grid">
                                    <?php foreach ($page_items as $item): ?>
                                        <div class="gallery-item" style="position: relative;">
                                            <img src="<?= htmlspecialchars($item['foto']); ?>"
                                                alt="<?= htmlspecialchars($item['judul']); ?>" width="400" height="300"
                                                loading="lazy" decoding="async">
                                            <div class="gallery-overlay">
                                                <div class="gallery-caption">
                                                    <h4><?= htmlspecialchars($item['judul']); ?></h4>
                                                    <i class="fa-solid fa-expand"></i>
                                                </div>
                                            </div>

                                            <!-- Tombol Edit & Hapus khusus admin pada tiap foto dokumentasi -->
                                            <?php if ($is_admin): ?>
                                                <div
                                                    style="position: absolute; top: 10px; right: 10px; z-index: 30; display: flex; gap: 5px;">
                                                    <button
                                                        onclick="bukaModalEditGaleri(<?= $item['id']; ?>, '<?= htmlspecialchars($item['judul'], ENT_QUOTES); ?>')"
                                                        class="btn"
                                                        style="background: #ffb703; color: #000; padding: 4px 8px; font-size: 0.7rem; border-radius: 4px; border:none; cursor:pointer;"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pen"></i> Edit
                                                    </button>
                                                    <a href="admin_proses.php?aksi=hapus_galeri&id=<?= $item['id']; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus foto dokumentasi ini?');"
                                                        class="btn"
                                                        style="background: #e63946; color: #fff; padding: 4px 8px; font-size: 0.7rem; border-radius: 4px; text-decoration:none;"
                                                        title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="gallery-arrow gallery-next" id="galleryNext" aria-label="Halaman Selanjutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                <div class="gallery-dots" id="galleryDots"></div>
            </div>
        </section>

        <section class="section-padding reveal" id="wisata">
            <div class="container">

                <div class="section-header">
                    <div class="section-tag">Destinasi Wisata</div>
                    <h3 class="section-title" data-kunci="wisata_judul"><?= getKonten($conn, 'wisata_judul'); ?></h3>
                </div>

                <div class="wisata-container">
                    <div class="wisata-card">
                        <div class="wisata-img-box" style="position: relative;">
                            <div class="wisata-img-link">
                                <img src="<?= getKonten($conn, 'wisata_foto'); ?>" alt="Wisata Desa Manggis"
                                    loading="lazy">
                                <div class="map-overlay-hint">
                                    <i class="fa-solid fa-location-dot"></i> Lokasi belum tersedia di Google Maps
                                </div>
                            </div>
                            <button class="admin-img-btn"
                                onclick="bukaModalGambar('wisata_foto', 'Foto Destinasi Wisata')"><i
                                    class="fa-solid fa-camera"></i> Ganti Foto Wisata</button>
                        </div>

                        <div class="wisata-info-box">
                            <h4>Informasi & Daya Tarik</h4>
                            <p data-kunci="wisata_deskripsi"><?= getKonten($conn, 'wisata_deskripsi'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="kontak">
        <div class="mascot-pointer">
            <span class="pointer-text">Klik saya!</span>
            <svg class="pointer-arrow" viewBox="0 0 100 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 10 Q 50 10 85 60" stroke="#00b3c0" stroke-width="3" stroke-dasharray="6,4"
                    stroke-linecap="round" fill="none" />
                <path d="M72 55 L87 62 L82 46" stroke="#00b3c0" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round" fill="none" />
            </svg>
        </div>

        <div class="mascot-container">
            <a href="https://iconnet.netlify.app/" target="_blank" rel="noopener noreferrer">
                <img src="coni-diam.png" alt="Mascot Diam" class="mascot-diam" width="100" height="100" loading="lazy"
                    decoding="async">
                <img src="coni-halo.png" alt="Mascot Halo" class="mascot-halo" width="100" height="100" loading="lazy"
                    decoding="async">
            </a>
        </div>
        <div class="cta-banner">
            <div class="container cta-content">
                <div>
                    <h3>Siap Berkolaborasi Bersama Kami?</h3>
                    <p style="color: rgba(255,255,255,0.9);">Hubungi layanan WhatsApp center resmi kami untuk pemesanan
                        dalam skala besar maupun kecil.</p>
                </div>
                <a href="https://wa.me/6282147740808/?text=Halo%20Pak%20Gede%20%2C%20Saya%20ingin..." target="_blank"
                    rel="noopener noreferrer" class="btn btn-cta-wa"><i class="fa-brands fa-whatsapp"
                        style="font-size: 1.3rem;"></i> Hubungi WhatsApp Sekarang</a>
            </div>
        </div>

        <div class="main-footer">
            <div class="container footer-grid">
                <div>
                    <div class="logo footer-logo">
                        <i class="fa-solid fa-leaf" style="color: var(--white);"></i>
                        <div>
                            <h1 style="color: var(--white);">BUMDes<br><span style="color: #8BE78B;">MANGGIS</span></h1>
                            <p style="color: #768E7E;">Karangasem</p>
                        </div>
                    </div>
                    <p style="font-size: 0.9rem; line-height: 1.6;">Lembaga usaha milik desa yang berkomitmen membangun
                        kemandirian ekonomi masyarakat Manggis secara inklusif dan berkelanjutan.</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/share/1DAnN1XqUu/" aria-label="Facebook"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/caturmandalamanggis?stkn=MWxueGl6dWpwemY5cQ=="
                            aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://wa.me/6282147740808/?text=Halo%20Pak%20Gede%20%2C%20Saya%20ingin..."
                            target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i
                                class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="footer-title">Alamat & Kantor</h4>
                    <div class="footer-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <p style="font-size: 0.9rem;">Desa Manggis, Kecamatan Manggis<br>Kabupaten Karangasem, Bali</p>
                    </div>
                    <div class="footer-item">
                        <i class="fa-regular fa-clock"></i>
                        <div style="font-size: 0.9rem;">
                            <p>Senin - Jumat : 08.00 - 17.00 WITA</p>
                            <p>Sabtu & Minggu : Tutup</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="footer-title">Hubungi Kami</h4>
                    <div class="footer-item">
                        <i class="fa-solid fa-phone"></i>
                        <p style="font-size: 0.9rem;">+62 821-4774-0808</p>
                    </div>
                    <div class="footer-item">
                        <i class="fa-brands fa-whatsapp"></i>
                        <p style="font-size: 0.9rem;">+62 821-4774-0808</p>
                    </div>
                    <div class="footer-item">
                        <i class="fa-solid fa-envelope"></i>
                        <p style="font-size: 0.9rem;">bumdescaturmandala@gmail.com</p>
                    </div>
                </div>

                <div>
                    <h4 class="footer-title">Lokasi Peta</h4>
                    <div class="map-box">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.0566037810436!2d115.51649707470683!3d-8.493877691547615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd20f812bda2193%3A0x8fbaca94cf8e61a8!2sKantor%20BUMDes%20Catur%20Mandala%20Manggis!5e0!3m2!1sid!2sid!4v1785382222868!5m2!1sid!2sid"
                            width="100%" height="200" loading="lazy" allowfullscreen=""
                            title="Peta Lokasi BUMDes Manggis"></iframe>
                        <div class="map-label"><i class="fa-solid fa-location-dot" style="color: var(--brand);"></i>
                            BUMDes MANGGIS</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>© 2026 BUMDes Manggis Karangasem. Semua Hak Dilindungi.</p>
        </div>
    </footer>


    <div class="iconnet-mobile-container">
        <div id="iconnetMobileMenu" class="iconnet-mobile-menu">
            <a href="pendaftaran-pelanggan.php">Pasang Wi-Fi Iconnet</a>

            <a href="#" id="mobileSubmenuToggle"
                style="display: flex; justify-content: space-between; align-items: center;">
                Lowongan Pekerjaan <i class="fa-solid fa-caret-down"></i>
            </a>

            <div id="mobileSubmenu" class="mobile-submenu">
                <a href="form-lowongan.php?divisi=agen-sales">- Agen Sales</a>
                <a href="form-lowongan.php?divisi=mitra-individu">- Mitra Individu</a>
                <a href="form-lowongan.php?divisi=teknisi">- Teknisi Aktivasi</a>
            </div>
        </div>

        <button id="iconnetMobileBtn" class="iconnet-mobile-btn">
            <div class="iconnet-text">
                <span style="color: navy;">ICON</span><br>
                <span style="color: #088F8F;">NET</span>
            </div>
        </button>
    </div>

    <button id="scrollTopBtn" class="scroll-top-btn" aria-label="Kembali ke atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <div id="lightbox-modal" class="lightbox-modal">
        <span class="lightbox-close">×</span>
        <img class="lightbox-content" id="lightbox-img" alt="Pratinjau" width="800" height="600">
        <div id="lightbox-caption" class="lightbox-caption-text"></div>
    </div>

    <?php if ($is_admin): ?>
        <div id="modalGantiGambar" class="cms-modal">
            <div class="cms-modal-box">
                <h3 id="judulModalGambar" style="margin-bottom: 15px; color: var(--brand-dark);">Ganti Foto</h3>
                <form action="admin_proses.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="aksi" value="ganti_gambar">
                    <input type="hidden" name="kunci" id="inputKunciGambar">
                    <div class="form-group">
                        <label>Pilih File Foto Baru (JPG/PNG)</label>
                        <input type="file" name="file_gambar" accept="image/*" required>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="btn btn-brand" style="flex: 1;">Simpan Foto</button>
                        <button type="button" onclick="document.getElementById('modalGantiGambar').classList.remove('open')"
                            class="btn" style="background: #ccc; border: none; cursor: pointer;">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalTambahGaleri" class="cms-modal">
            <div class="cms-modal-box">
                <h3 style="margin-bottom: 15px; color: var(--brand-dark);">Tambah Dokumentasi Galeri</h3>
                <form action="admin_proses.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="aksi" value="tambah_galeri">
                    <div class="form-group">
                        <label>Judul / Keterangan Foto</label>
                        <input type="text" name="judul" placeholder="Contoh: Rapat Desa 2026" required>
                    </div>
                    <div class="form-group">
                        <label>Pilih Foto</label>
                        <input type="file" name="foto_galeri" accept="image/*" required>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="btn btn-brand" style="flex: 1;">Upload ke Galeri</button>
                        <button type="button"
                            onclick="document.getElementById('modalTambahGaleri').classList.remove('open')" class="btn"
                            style="background: #ccc; border: none; cursor: pointer;">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalEditGaleri" class="cms-modal">
            <div class="cms-modal-box">
                <h3 style="margin-bottom: 15px; color: var(--brand-dark);">Edit Info & Foto Galeri</h3>
                <form action="admin_proses.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="aksi" value="edit_galeri">
                    <input type="hidden" name="id" id="editGaleriId">
                    <div class="form-group">
                        <label>Judul / Keterangan Foto</label>
                        <input type="text" name="judul" id="editGaleriJudul" required>
                    </div>
                    <div class="form-group">
                        <label>Ganti Foto (Kosongkan jika tidak ingin ganti foto)</label>
                        <input type="file" name="foto_galeri" accept="image/*">
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="btn btn-brand" style="flex: 1;">Simpan Perubahan</button>
                        <button type="button" onclick="document.getElementById('modalEditGaleri').classList.remove('open')"
                            class="btn" style="background: #ccc; border: none; cursor: pointer;">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function bukaModalGambar(kunci, judul) {
                document.getElementById('inputKunciGambar').value = kunci;
                document.getElementById('judulModalGambar').innerText = "Ganti " + judul;
                document.getElementById('modalGantiGambar').classList.add('open');
            }

            function bukaModalEditGaleri(id, judul) {
                document.getElementById('editGaleriId').value = id;
                document.getElementById('editGaleriJudul').value = judul;
                document.getElementById('modalEditGaleri').classList.add('open');
            }

            const btnModeEdit = document.getElementById('btnModeEdit');
            if (btnModeEdit) {
                btnModeEdit.addEventListener('click', function () {
                    const editableElements = document.querySelectorAll('[data-kunci]');
                    const isEditing = document.body.classList.toggle('admin-editing-mode');

                    if (isEditing) {
                        this.innerHTML = '<i class="fa-solid fa-check"></i> Selesai & Simpan Semua';
                        this.style.background = '#ffb703';
                        alert("MODE EDIT AKTIF:\n1. Klik teks mana saja untuk mengedit.\n2. Klik tombol 'Ganti' pada gambar untuk mengganti foto.");

                        editableElements.forEach(el => {
                            el.contentEditable = "true";
                        });
                    } else {
                        this.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Mode Edit Web (CMS)';
                        this.style.background = '#8BE78B';

                        editableElements.forEach(el => {
                            el.contentEditable = "false";
                            const kunci = el.getAttribute('data-kunci');
                            const nilai = el.innerHTML;

                            const formData = new FormData();
                            formData.append('aksi', 'simpan_teks');
                            formData.append('kunci', kunci);
                            formData.append('nilai', nilai);

                            fetch('admin_proses.php', {
                                method: 'POST',
                                body: formData
                            });
                        });

                        alert("Semua perubahan berhasil disimpan ke database!");
                    }
                });
            }
        </script>
    <?php endif; ?>

    <script src="script.js" defer></script>
</body>

</html>