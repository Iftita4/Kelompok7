-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 01:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thrifthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `metode` enum('COD','Transfer') NOT NULL,
  `tanggal` datetime NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `status_pengiriman` varchar(100) DEFAULT 'Diproses',
  `lokasi_pengiriman` varchar(100) DEFAULT 'Gudang',
  `estimasi_tiba` date DEFAULT NULL,
  `diterima` tinyint(1) DEFAULT 0,
  `order_id` varchar(100) DEFAULT NULL,
  `snap_token` varchar(100) DEFAULT NULL,
  `status_pembayaran` varchar(100) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `nama`, `alamat`, `metode`, `tanggal`, `total`, `status_pengiriman`, `lokasi_pengiriman`, `estimasi_tiba`, `diterima`, `order_id`, `snap_token`, `status_pembayaran`, `payment_type`, `transaction_time`) VALUES
(3, 3, 'Farwa Salira', 'palopo', 'COD', '2025-06-26 05:43:16', 80.00, '', 'Makassar', '2025-06-30', 1, NULL, NULL, 'Pembayaran Diterima', NULL, NULL),
(4, 8, 'Fifi', 'makassar', 'COD', '2025-07-07 11:56:57', 10000.00, 'Dikirim', 'Gudang', '0000-00-00', 0, 'THRIFT-883279', NULL, 'Pembayaran Diterima', NULL, NULL),
(5, 8, 'Fifi', 'palopo', 'COD', '2025-07-07 17:53:09', 35000.00, 'Dikirim', 'Makassar', '0000-00-00', 0, 'THRIFT-948093', NULL, 'Pembayaran Diterima', NULL, NULL),
(6, 8, 'Fifi', '', '', '2025-07-07 18:16:35', 20000.00, '', 'Gudang', NULL, 0, 'THRIFT-381417', NULL, 'Pembayaran Diterima', NULL, NULL),
(7, 8, 'Fifi', '', 'COD', '2025-07-07 18:41:16', 20000.00, '', 'Gudang', NULL, 0, 'THRIFT-332818', NULL, 'Pembayaran Diterima', NULL, NULL),
(8, 8, 'Fifi', '', '', '2025-07-07 18:43:13', 35000.00, '', 'Gudang', NULL, 0, 'THRIFT-762523', NULL, 'Pembayaran Diterima', NULL, NULL),
(9, 11, 'isma', 'sempowae', 'COD', '2025-07-08 08:42:26', 20000.00, '', 'palopo', '2025-07-13', 0, 'THRIFT-791414', NULL, 'Pembayaran Diterima', NULL, NULL),
(10, 3, 'Farwa Salira', 'makassar', 'COD', '2025-07-08 09:29:41', 10000.00, '', 'Gudang', '0000-00-00', 0, 'THRIFT-743744', NULL, 'Pembayaran Diterima', NULL, NULL),
(11, 12, 'hery', 'palopo', 'COD', '2025-07-08 09:43:53', 80.00, '', 'Gudang', NULL, 0, 'THRIFT-315144', NULL, '', NULL, NULL),
(12, 13, 'ismawati', 'palopo', 'COD', '2025-07-13 08:03:03', 40000.00, '', 'makassar', '0000-00-00', 0, 'THRIFT-264316', NULL, '', NULL, NULL),
(13, 13, 'ismawati', 'palopo', 'COD', '2025-07-13 09:15:55', 50000.00, '', 'Gudang', '2025-07-14', 0, 'THRIFT-113028', NULL, '', NULL, NULL),
(14, 8, 'Fifi', '', 'COD', '2025-07-13 09:31:31', 20000.00, 'Dalam Perjalanan', 'Makassar', '2025-07-15', 0, 'THRIFT-415777', NULL, 'Pembayaran Diterima', NULL, NULL),
(15, 8, 'Fifi', 'ihkj', 'COD', '2025-07-13 10:01:10', 40000.00, 'Diterima', 'Gudang', '0000-00-00', 0, 'THRIFT-720239', NULL, 'Pembayaran Diterima', NULL, NULL),
(16, 3, 'Farwa Salira', '', 'Transfer', '2025-07-14 01:24:32', 50000.00, 'Belum Diproses', 'Gudang', NULL, 0, 'THRIFT-548289', NULL, 'Pending', NULL, NULL),
(17, 3, 'Farwa Salira', '', 'Transfer', '2025-07-14 01:31:39', 50000.00, 'Belum Diproses', 'Gudang', NULL, 0, 'THRIFT-512836', NULL, 'Pending', NULL, NULL),
(18, 3, 'Farwa Salira', '', 'Transfer', '2025-07-14 01:32:11', 50000.00, 'Belum Diproses', 'Gudang', NULL, 0, 'THRIFT-512836', '\"{\\\"status_code\\\":\\\"201\\\",\\\"status_message\\\":\\\"Success, transaction is found\\\",\\\"transaction_id\\\":\\\"', 'Menunggu Verifikasi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_item`
--

CREATE TABLE `pesanan_item` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_item`
--

INSERT INTO `pesanan_item` (`id`, `pesanan_id`, `produk_id`, `nama`, `harga`, `jumlah`) VALUES
(3, 3, 1, 'Baju', 80.00, 1),
(4, 4, 5, 'Celana tartan (hitam putih)', 10000.00, 1),
(5, 5, 4, 'Adina Loafers (black)', 35000.00, 1),
(6, 6, 2, 'Sakura Shirt (pink)', 20000.00, 1),
(7, 7, 2, 'Sakura Shirt (pink)', 20000.00, 1),
(8, 8, 4, 'Adina Loafers (black)', 35000.00, 1),
(9, 9, 2, 'Sakura Shirt (pink)', 20000.00, 1),
(10, 10, 5, 'Celana tartan (hitam putih)', 10000.00, 1),
(11, 11, 1, 'Baju', 80.00, 1),
(12, 12, 22, 'Celana pendek', 40000.00, 1),
(13, 13, 19, 'celana kulot', 50000.00, 1),
(14, 14, 2, 'Sakura Shirt (pink)', 20000.00, 1),
(15, 15, 42, 'Sepatu biru pudar', 40000.00, 1),
(16, 16, 47, 'sepatu hitam', 50000.00, 1),
(17, 17, 47, 'sepatu hitam', 50000.00, 1),
(18, 18, 47, 'sepatu hitam', 50000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `user_id`, `nama`, `kategori`, `harga`, `deskripsi`, `gambar`, `created_at`) VALUES
(2, 3, 'Sakura Shirt (pink)', 'Kemeja', 20000, 'Pemakaian 1 bulan', 'uploads/kemeja pink.jpg', '2025-07-02 12:59:49'),
(3, 3, 'Sakura Shirt (abu)', 'Kemeja', 15000, 'Pemakaian 1 bulan', 'uploads/kemeja abu.jpg', '2025-07-02 13:00:48'),
(4, 3, 'Adina Loafers (black)', 'Sepatu', 35000, 'Pemakain 1 hari', 'uploads/loafers black.jpg', '2025-07-02 13:02:15'),
(6, 13, 'blouse kayla', 'Kemeja', 50000, '3 kali pemakaian', 'uploads/blouse1.jpg', '2025-07-11 09:33:10'),
(7, 13, 'Blouse Kayla', 'Kemeja', 55000, '1 satu kali pemakaian', 'uploads/blouse.jpg', '2025-07-11 09:43:55'),
(8, 13, 'Blouse Kayla', 'Kemeja', 50000, '5 Kali pemakaian', 'uploads/blouse 2.jpg', '2025-07-11 09:45:26'),
(9, 13, 'Blouse Kayla', 'Kemeja', 40000, '7 kali pemakaian', 'uploads/baju.jpg', '2025-07-11 09:48:45'),
(10, 13, 'Blouse Kayla', 'Kemeja', 50000, '4 kali pemakaian', 'uploads/kemeja.jpg', '2025-07-11 09:49:32'),
(11, 13, 'Blouse Kayla', 'Kemeja', 60000, '1 kali pemakaian', 'uploads/blouse3.jpg', '2025-07-11 09:52:21'),
(12, 13, 'Blouse Kayla', 'Kemeja', 35000, 'muat sampai BB 65', 'uploads/baju pink.jpg', '2025-07-11 09:54:37'),
(13, 13, 'Blouse Kayla', 'Kemeja', 65000, '4 kali pemakaiam muat sampai BB 60', 'uploads/blouse4.jpg', '2025-07-11 09:57:35'),
(14, 13, 'Blouse  sage', 'Kemeja', 50000, '1 kali pemakaian muat sampai BB 65', 'uploads/blouse5.jpg', '2025-07-11 10:01:59'),
(15, 13, 'Blouse Putih', 'Kemeja', 50000, '2 kali pemakaian muat sampai BB 70', 'uploads/blouse6.jpg', '2025-07-11 10:05:43'),
(16, 13, 'kemeja salur', 'Kemeja', 45000, '10 kali pemakaian dan ada robek sedikit muat sampai BB 50', 'uploads/blouse7.jpg', '2025-07-11 10:08:00'),
(17, 13, 'kemeja Coffe', 'Kemeja', 55000, '2 kali pemakaian muat sampai BB 55', 'uploads/kemeja1.jpg', '2025-07-11 10:58:49'),
(18, 13, 'kemeja coklat', 'Kemeja', 45000, '5 kali pemakaian  tidak ada mines muat sampai BB 50', 'uploads/kemeja2.jpg', '2025-07-11 11:01:48'),
(19, 14, 'celana kulot', 'Celana', 50000, '1 kali pemakaian tidak ad minesnya muat BB 70', 'uploads/celana.jpg', '2025-07-11 11:17:29'),
(20, 14, 'Celana cream', 'Celana', 35000, 'sdah lama di pakai tidak ada mines nya muat BB 45', 'uploads/celana cream.jpg', '2025-07-11 11:19:53'),
(21, 14, 'Celana Cutbray', 'Celana', 65000, '5 kali pemakaian  muat BB sampai 65', 'uploads/celana cutbray 1.jpg', '2025-07-11 11:22:18'),
(22, 14, 'Celana pendek', 'Celana', 40000, 'tidak pernah di pakai muat BB sampai 65', 'uploads/celpen 2.jpg', '2025-07-11 11:23:52'),
(23, 14, 'Celana snow black', 'Celana', 70000, '', 'uploads/celana cutbray snow black.jpg', '2025-07-11 11:25:11'),
(24, 15, 'Hoodie hitam', 'Jaket', 80000, '1 kali pemkaian muat pemakain mines tdak talinya', 'uploads/hoodie14.jpg', '2025-07-11 11:34:07'),
(25, 15, 'Hoodie hijau', 'Jaket', 60000, 'ada noda sedikit di bagian lengan', 'uploads/hoodie 15.jpg', '2025-07-11 11:36:48'),
(26, 15, 'Hoodie hitam bergambar', 'Jaket', 85000, 'sudah lama pemakaian dan  berbuluh ', 'uploads/hoodie4.jpg', '2025-07-11 11:39:31'),
(27, 15, 'Hoodie cream ', 'Jaket', 85000, 'warna sdah agak pudar sedikit', 'uploads/hoodie2.jpg', '2025-07-11 11:41:02'),
(28, 15, 'Hoodie putih', 'Jaket', 65000, 'ada noda di bagian belakang dan agak sedikit berbuluh', 'uploads/hoodie3.jpg', '2025-07-11 11:42:31'),
(35, 16, 'handbag pria', 'Tas', 50000, '', 'uploads/tas laki.jpg', '2025-07-11 12:26:36'),
(36, 16, 'tas selempang wanita', 'Tas', 50000, '', 'uploads/tas wanita.jpg', '2025-07-11 12:29:09'),
(37, 16, 'tas selempang wanita hitam', 'Tas', 50000, '', 'uploads/tas wanita 2.jpg', '2025-07-11 12:30:18'),
(38, 16, 'tas selempang wanita hitam', 'Tas', 55000, '', 'uploads/tas cewek.jpg', '2025-07-11 12:31:19'),
(39, 16, 'dompet pria', 'Tas', 40000, '', 'uploads/dompet pria.jpg', '2025-07-11 12:32:26'),
(40, 16, 'handbag pria', 'Tas', 50000, '', 'uploads/handhandbag laki laki.jpg', '2025-07-11 12:34:15'),
(42, 17, 'Sepatu biru pudar', 'Sepatu', 40000, '2 tahun pemakaian sepatunya agak sudah pudar', 'uploads/gydgcf.jpeg', '2025-07-13 03:09:50'),
(43, 17, 'Sepatu vans hitam', 'Sepatu', 40000, '1 tahun pemakaian ada robek di bagian dalam sepatu ', 'uploads/images (1).jpeg', '2025-07-13 03:12:20'),
(44, 17, 'Sepatu coklat', 'Sepatu', 43000, 'Pemakaian 1 stengah tahun ada robek dan terkelupas di bagian depan', 'uploads/images (4).jpeg', '2025-07-13 03:14:45'),
(45, 17, 'Sepatu vans biru tua', 'Sepatu', 40000, 'pemakaian 1  tahun depan sepatu  sdah terkelupas dari alasnya tapi masih bisa di jahit atau di lem', 'uploads/8843d294-f839-4688-9602-1f228b318c3f.jpg', '2025-07-13 03:17:36'),
(46, 17, 'Sepatu cream putih', 'Sepatu', 65000, 'pemakaian stengah tahun tidak ada mines nya dan tidak pudar warnanya', 'uploads/images.jpeg', '2025-07-13 03:22:13'),
(47, 17, 'sepatu hitam', 'Sepatu', 50000, 'pemakaian 2 tahun  terkelupas sedikit bgian dalam sepatu', 'uploads/images (2).jpeg', '2025-07-13 03:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id`, `nama`, `pesan`, `foto`, `created_at`) VALUES
(1, 'Farwa', 'abcg', NULL, '2025-06-21 01:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_seller` tinyint(1) DEFAULT 0,
  `nama_toko` varchar(100) DEFAULT NULL,
  `deskripsi_toko` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat_toko` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `is_seller`, `nama_toko`, `deskripsi_toko`, `telepon`, `alamat_toko`) VALUES
(1, 'Admin', 'admin@thrift.com', '$2y$10$abc123hashed_admin_pass', 'admin', '2025-06-10 00:56:34', 0, NULL, NULL, NULL, NULL),
(2, 'User', 'user@thrift.com', '$2y$10$abc123hashed_user_pass', 'user', '2025-06-10 00:56:34', 0, NULL, NULL, NULL, NULL),
(3, 'Farwa Salira', 'farwasalira@gmail.com', '$2y$10$5/sjgGi.4aqVtAbHgfvZZuTUJ7w9Km3NOXGzXQCCF7N4eH4oAQ1vi', 'user', '2025-06-10 01:00:45', 1, 'Toko Farwa', 'baju lebih hemat', '123', 'palopo'),
(4, 'rifki', 'rifki@gmail.com', '$2y$10$OJUTTIbyvW4hBXRy7KfRmuWI/uzsSdIDEfGdCwvmx4HL5TaQn5ceO', 'user', '2025-06-10 02:36:36', 0, NULL, NULL, NULL, NULL),
(7, 'Wahyuni', 'Uni@gmail.com', '$2y$10$DtKppgju4pSMSTWFiyA86e6QUVPyvXV/hDYMwZxDPN.f3Vcq4JNi6', 'user', '2025-06-10 07:30:35', 0, NULL, NULL, NULL, NULL),
(8, 'Fifi', 'fifi@gmail.com', '$2y$10$xKJYVqIIpgsnu0i3FiCWS.uBcZrlSpAxs79r9z9yT.EUTJWGqieIK', 'user', '2025-06-21 14:40:38', 0, NULL, NULL, NULL, NULL),
(10, 'Admin', 'admin@thrifthub.com', '$2y$10$DdnE5Du0KBUh5ti/mMqQKO6DCEdZXE3iMcpaCEi3W5e3OXuCy6Sw6', 'admin', '2025-06-22 07:57:41', 0, NULL, NULL, NULL, NULL),
(11, 'isma', 'isma11@gmail.com', '$2y$10$dUo76jTRWpTij5ywrkdQ9eGswRTVYnrrUxp4Jjys4zga9LpuQ0SWO', 'user', '2025-07-08 06:40:38', 0, NULL, NULL, NULL, NULL),
(12, 'hery', 'hery@gmail.com', '$2y$10$XpU9PLfS5/MldbQw5lMn5.WC783401qODQxDC9yT0GhKOwqmABz.K', 'user', '2025-07-08 07:40:30', 0, NULL, NULL, NULL, NULL),
(13, 'ismawati', 'isma73372@gmail.com', '$2y$10$EgTyal0TN8gIpFoegwuToO6ozUmNRpmgKRj8exlsEEVA5Za5ygwLu', 'user', '2025-07-11 07:17:04', 1, 'Tara Thriftina', 'Tara Thriftina adalah gadis muda yang penuh gaya dan percaya diri. Ia dikenal sebagai “Ratu Thrift” di kalangan teman-temannya karena kemampuannya mengubah pakaian bekas menjadi outfit yang modis dan unik. Dengan kreativitas tinggi dan kecintaan pada lingkungan, Tara selalu menginspirasi orang lain untuk tampil gaya tanpa harus mahal.', '082196752856', 'Belopa'),
(14, 'Riko', 'i@gmail.com', '$2y$10$xPGKTo2AtOn39LXXXZCDrug8/Yy70VoFjUa4Llh3ehmNmX4mHh1J6', 'user', '2025-07-11 11:13:57', 1, 'Celly Pantsu', 'Celly Pantsu adalah gadis aktif, ceria, dan penuh semangat. Ia dikenal sebagai pecinta celana dengan gaya yang praktis namun tetap fashionable. Dari kulot santai, jeans robek, sampai high-waist trendi, Celly bisa memadukannya dengan gaya personal yang unik. Ia percaya bahwa celana bukan cuma soal kenyamanan, tapi juga ekspresi diri. ', '081123765876', 'MASAMBA kab. luwu utara'),
(15, 'Aril', 'aril@gmail.com', '$2y$10$G6vGL3rs.PV3OyhNd1.aP.tEpPRyvH2htISu0iatdhJCMLwKysra6', 'user', '2025-07-11 11:30:20', 1, 'Hana dan aril hoodie', ' Ia suka warna-warna pastel dan gaya minimalis, tapi tetap mencolok berkat sentuhan gaya pribadinya dan cowok yang cuek tapi stylish, selalu mengenakan hoodie oversized ke mana pun dia pergi. Ia suka warna gelap, desain grafis, dan vibe misterius. Reno bukan anak populer, tapi gayanya selalu mencuri perhatian.', '085456786590', 'Palopo'),
(16, 'priskila', 'kila@gmail.com', '$2y$10$rFKY294bAgaiMQSb2cmJtO3Y0SQTmZHANtMI/JXkb9VdkbzlNh3MS', 'user', '2025-07-11 11:52:21', 1, 'Tasya & Taro Bagz', 'Tasya & Taro Bagz adalah satu karakter dengan dua persona — Tasya mewakili gaya tas wanita yang elegan dan stylish, sedangkan Taro mewakili tas pria yang simpel dan fungsional. Mereka adalah simbol fashion unisex yang mengusung pesan: “Gaya itu universal, tinggal kamu pilih jalannya.”', '08256708765', 'malili kab. luwu timur'),
(17, 'aco', 'aco@gmail.com', '$2y$10$Tz6oL2wu/.FjLaf0l1DPJuQMuhStycATjQpbW2OiE6OdTMKB/jXKa', 'user', '2025-07-13 03:03:29', 1, 'Sapo ( sepatu oke)', 'Sapo adalah tokoh ceria dan penuh gaya yang mewakili dunia sepatu bekas dengan semangat baru. Dulu ia sempat merasa tak berguna karena sudah dipakai dan ditinggalkan, tapi kini Sapo bangkit dengan percaya diri! Ia adalah simbol bahwa barang bekas bukan berarti tak bernilai.', '085789766432', 'makassar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pesanan_user` (`user_id`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `pesanan_item`
--
ALTER TABLE `pesanan_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan_item`
--
ALTER TABLE `pesanan_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Constraints for table `pesanan_item`
--
ALTER TABLE `pesanan_item`
  ADD CONSTRAINT `pesanan_item_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
