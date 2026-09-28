-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Sep 2026 pada 07.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bumdes_manggis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_admin`
--

CREATE TABLE `akun_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'Kepala BUMDes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun_admin`
--

INSERT INTO `akun_admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin1234', 'Kepala BUMDes');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran_kerja`
--

CREATE TABLE `lamaran_kerja` (
  `id` int(11) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `berkas_cv` varchar(255) NOT NULL,
  `tanggal_submit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lamaran_kerja`
--

INSERT INTO `lamaran_kerja` (`id`, `posisi`, `nama_lengkap`, `whatsapp`, `alamat`, `berkas_cv`, `tanggal_submit`) VALUES
(3, 'Mitra Individu (Freelance)', 'Dewa Putu Kresna', '089652611366', 'Jalan gunung salak gg lumba-lumba', '1788749128_10268458003_7041939546_1775205384459.png', '2026-09-07 02:45:28'),
(4, 'Mitra Individu (Freelance)', 'Putu Egik Krisnanta', '0896523166', 'jalan warmadewa ubung kaja', '1788749151_10268458003_7041939546_1775205828415.png', '2026-09-07 02:45:51'),
(5, 'Mitra Individu (Freelance)', 'Egik', '089634912424', 'zzzzzzzzzzz', '1789710133_WhatsAppImage2026-09-15at10.38.49.jpeg', '2026-09-18 05:42:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_minyak`
--

CREATE TABLE `produk_minyak` (
  `id` int(11) NOT NULL,
  `jenis_minyak` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `user_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_sapi`
--

CREATE TABLE `produk_sapi` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `jumlah_sapi` int(11) NOT NULL,
  `jenis_sapi` varchar(50) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk_sapi`
--

INSERT INTO `produk_sapi` (`id`, `foto`, `jumlah_sapi`, `jenis_sapi`, `no_hp`, `keterangan`, `tanggal_input`, `user_token`) VALUES
(14, 'WhatsApp Image 2026-09-15 at 10.38.49.jpeg', 0, 'Sapi gargit', '089634912424', 'sehat', '2026-09-18 03:57:49', 'user_6aacb422b6e096.80784746');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_tahunan`
--

CREATE TABLE `produk_tahunan` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `user_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun_admin`
--
ALTER TABLE `akun_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lamaran_kerja`
--
ALTER TABLE `lamaran_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk_minyak`
--
ALTER TABLE `produk_minyak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk_sapi`
--
ALTER TABLE `produk_sapi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk_tahunan`
--
ALTER TABLE `produk_tahunan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun_admin`
--
ALTER TABLE `akun_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lamaran_kerja`
--
ALTER TABLE `lamaran_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `produk_minyak`
--
ALTER TABLE `produk_minyak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `produk_sapi`
--
ALTER TABLE `produk_sapi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `produk_tahunan`
--
ALTER TABLE `produk_tahunan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
