-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 04:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parfum2`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(25, '2014_10_12_000000_create_users_table', 1),
(26, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(27, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(35, '2023_04_09_002743_agen', 2),
(36, '2023_04_09_002750_parfum', 2),
(37, '2023_04_11_105259_transaksi', 3),
(38, '2023_04_11_122430_stok', 4),
(39, '2023_04_11_140144_tb_transaksi_detail', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_agen`
--

CREATE TABLE `tb_agen` (
  `kode_agen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_agen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_agen`
--

INSERT INTO `tb_agen` (`kode_agen`, `nama_agen`, `status`, `created_at`, `updated_at`) VALUES
('AG001', 'Sulton', '0', '2023-04-11 04:07:35', '2023-04-11 04:07:35'),
('PU001', 'Pusat', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_parfum`
--

CREATE TABLE `tb_parfum` (
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_beli` bigint(20) NOT NULL,
  `h_agen` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_parfum`
--

INSERT INTO `tb_parfum` (`kode_barang`, `nama_barang`, `h_beli`, `h_agen`, `created_at`, `updated_at`) VALUES
('A001', 'Angel Shelecher Man', 175000, 180000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('A002', 'Angel Shelecher Woman', 175000, 180000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B001', 'B. 75 ml Man', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B002', 'B. 75 ml Woman', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B003', 'B. Blue Paradiso', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B004', 'B. Body Spray', 60000, 65000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B005', 'B. Essens', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B006', 'B. Jeans Man (Set)', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B007', 'B. Jeans Man (Tanpa set)', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B008', 'B. Jeans Woman (Set)', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B009', 'B. Pure Sport Man (Hijau)', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B010', 'B. Pure Sport Woman (Set)', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('B011', 'B. Sport Woman Red (Set)', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('C001', 'Corduroy', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('F001', 'Ferari Pasion', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('F002', 'Ferre B 50 ml', 160000, 165000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('F003', 'Ferre K 30 ml', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('F004', 'Friends', 160000, 165000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('F005', 'Fujiyama', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('M001', 'Maxmara Besar', 215000, 220000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('M002', 'Maxmara Silk', 175000, 180000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('R001', 'Roberto Veriro Aqua', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('R002', 'Roberto Veriro Rose', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('R003', 'Roberto Veriro Tropic', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('T001', 'Tous Gold 30 ml', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('T002', 'Tous Limited edition', 160000, 165000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('T003', 'Tous Man', 155000, 160000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('T004', 'Tous Touch 30 ml', 135000, 140000, '2023-04-11 04:39:27', '2023-04-11 04:39:27'),
('T005', 'Tous Touch 50 ml', 160000, 165000, '2023-04-11 04:39:27', '2023-04-11 04:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stok`
--

CREATE TABLE `tb_stok` (
  `kode_stok` int(255) NOT NULL,
  `kode_agen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_stok`
--

INSERT INTO `tb_stok` (`kode_stok`, `kode_agen`, `kode_barang`, `jumlah`, `created_at`, `updated_at`) VALUES
(9, 'PU001', 'B001', '5', '2023-04-12 06:22:15', '2023-04-12 06:22:15'),
(10, 'PU001', 'A001', '1', '2023-04-12 06:22:15', '2023-04-12 06:22:15'),
(11, 'PU001', 'C001', '1', '2023-04-12 06:22:15', '2023-04-12 06:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_agen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`kode_transaksi`, `kode_agen`, `tanggal`, `jenis`, `valid`, `created_at`, `updated_at`) VALUES
('Ngaw', 'PU001', '2023-04-11', 'Masuk', 0, NULL, NULL),
('T190423001', 'PU001', '2023-04-19', 'Setor', 0, '2023-04-11 04:45:45', '2023-04-11 04:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_detail`
--

CREATE TABLE `tb_transaksi_detail` (
  `kode_detail` int(255) NOT NULL,
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi_detail`
--

INSERT INTO `tb_transaksi_detail` (`kode_detail`, `kode_transaksi`, `kode_barang`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 'Ngaw', 'B001', '5', '2023-04-12 05:46:22', '2023-04-12 05:46:22'),
(2, 'Ngaw', 'A001', '1', '2023-04-12 05:46:28', '2023-04-12 05:46:28'),
(3, 'Ngaw', 'C001', '1', '2023-04-12 06:15:31', '2023-04-12 06:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, '123', '$2y$10$1YWxACiAjFbtDpxW4Y5CH.aKBTmXRT2MXrtxrFZPZULjjzUgNZ3vy', NULL, '2023-04-11 04:04:30', '2023-04-11 04:04:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tb_agen`
--
ALTER TABLE `tb_agen`
  ADD PRIMARY KEY (`kode_agen`);

--
-- Indexes for table `tb_parfum`
--
ALTER TABLE `tb_parfum`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `tb_stok`
--
ALTER TABLE `tb_stok`
  ADD PRIMARY KEY (`kode_stok`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`kode_transaksi`);

--
-- Indexes for table `tb_transaksi_detail`
--
ALTER TABLE `tb_transaksi_detail`
  ADD PRIMARY KEY (`kode_detail`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_stok`
--
ALTER TABLE `tb_stok`
  MODIFY `kode_stok` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_transaksi_detail`
--
ALTER TABLE `tb_transaksi_detail`
  MODIFY `kode_detail` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
