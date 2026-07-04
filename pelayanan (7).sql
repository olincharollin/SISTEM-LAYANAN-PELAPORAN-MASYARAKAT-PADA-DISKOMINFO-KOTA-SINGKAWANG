-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jun 19, 2026 at 05:55 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelayanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `aktivitas` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `aktivitas`, `created_at`) VALUES
(1, 1, 'Login berhasil', '2026-05-06 03:10:59'),
(2, 2, 'Login berhasil', '2026-05-06 03:59:03'),
(3, 2, 'Logout', '2026-05-06 03:59:12'),
(4, 1, 'Login berhasil', '2026-05-06 03:59:16'),
(5, 1, 'Login berhasil', '2026-05-06 03:59:50'),
(6, 2, 'Login berhasil', '2026-05-06 03:59:59'),
(7, 2, 'Logout', '2026-05-06 04:00:17'),
(8, 1, 'Login berhasil', '2026-05-06 04:00:21'),
(9, 1, 'Logout', '2026-05-06 04:38:57'),
(10, 2, 'Login berhasil', '2026-05-06 04:39:02'),
(11, 2, 'Logout', '2026-05-06 04:39:04'),
(12, 1, 'Login berhasil', '2026-05-07 15:13:25'),
(13, 1, 'Login berhasil', '2026-05-07 15:36:40'),
(14, 1, 'Login berhasil', '2026-05-07 15:45:31'),
(15, 2, 'Login berhasil', '2026-05-07 15:45:39'),
(16, 2, 'Logout', '2026-05-07 15:45:43'),
(17, 1, 'Login berhasil', '2026-05-07 15:45:47'),
(18, 3, 'Login berhasil', '2026-05-07 15:46:07'),
(19, 3, 'Logout', '2026-05-07 15:46:48'),
(20, 1, 'Login berhasil', '2026-05-07 15:48:45'),
(21, 1, 'Login berhasil', '2026-05-07 16:01:01'),
(22, 1, 'Logout', '2026-05-07 16:01:30'),
(23, 2, 'Login berhasil', '2026-05-07 16:01:41'),
(24, 2, 'Logout', '2026-05-07 16:02:47'),
(25, 1, 'Login berhasil', '2026-05-07 16:02:53'),
(26, 1, 'Logout', '2026-05-07 16:03:38'),
(27, 1, 'Login berhasil', '2026-05-08 02:57:57'),
(28, 1, 'Logout', '2026-05-08 02:59:34'),
(29, 2, 'Login berhasil', '2026-05-08 02:59:49'),
(30, 1, 'Login berhasil', '2026-05-08 03:14:06'),
(31, 2, 'Login berhasil', '2026-05-09 06:43:28'),
(32, 2, 'Logout', '2026-05-09 07:17:05'),
(33, 2, 'Login berhasil', '2026-05-09 07:17:30'),
(34, 2, 'Logout', '2026-05-09 07:18:38'),
(35, 2, 'Login berhasil', '2026-05-09 07:19:42'),
(36, 2, 'Login berhasil', '2026-05-09 13:46:47'),
(37, 2, 'Login berhasil', '2026-05-11 01:29:59'),
(38, 2, 'Logout', '2026-05-11 01:30:01'),
(39, 1, 'Login berhasil', '2026-05-11 01:30:08'),
(40, 1, 'Logout', '2026-05-11 06:06:41'),
(41, 1, 'Login berhasil', '2026-05-11 06:09:58'),
(42, 1, 'Login berhasil', '2026-05-12 02:02:19'),
(43, 1, 'Logout', '2026-05-12 02:02:25'),
(44, 2, 'Login berhasil', '2026-05-12 03:46:32'),
(45, 2, 'Logout', '2026-05-12 07:25:26'),
(46, 1, 'Login berhasil', '2026-05-12 07:25:34'),
(47, 1, 'Login berhasil', '2026-05-12 07:57:01'),
(48, 1, 'Export data pengaduan ke Excel', '2026-05-12 08:32:29'),
(49, 1, 'Logout', '2026-05-12 08:37:30'),
(50, 2, 'Login berhasil', '2026-05-12 08:37:34'),
(51, 2, 'Login berhasil', '2026-05-12 08:49:08'),
(52, 2, 'Logout', '2026-05-12 08:49:15'),
(53, 1, 'Login berhasil', '2026-05-12 08:49:19'),
(54, 1, 'Logout', '2026-05-12 08:50:04'),
(55, 1, 'Login berhasil', '2026-05-13 01:08:57'),
(56, 1, 'Logout', '2026-05-13 01:30:00'),
(57, 2, 'Login berhasil', '2026-05-13 01:30:05'),
(58, 2, 'Logout', '2026-05-13 02:17:29'),
(59, 1, 'Login berhasil', '2026-05-13 02:17:33'),
(60, 1, 'Logout', '2026-05-13 02:34:48'),
(61, 1, 'Login berhasil', '2026-05-13 02:34:51'),
(62, 1, 'Logout', '2026-05-13 07:36:45'),
(63, 1, 'Login berhasil', '2026-05-13 07:36:47'),
(64, 1, 'Login berhasil', '2026-05-18 01:00:45'),
(65, 2, 'Login berhasil', '2026-05-18 03:06:52'),
(66, 1, 'Login berhasil', '2026-05-18 04:31:46'),
(67, 2, 'Login berhasil', '2026-05-18 04:43:01'),
(68, 2, 'Logout', '2026-05-18 04:43:19'),
(69, 2, 'Login berhasil', '2026-05-18 05:08:49'),
(70, 2, 'Login berhasil', '2026-05-19 07:53:50'),
(71, 1, 'Login berhasil', '2026-05-20 04:56:26'),
(72, 2, 'Login berhasil', '2026-05-20 07:17:45'),
(73, 1, 'Login berhasil', '2026-05-20 07:18:38'),
(74, 2, 'Login berhasil', '2026-05-20 07:19:18'),
(75, 2, 'Login berhasil', '2026-05-20 07:20:03'),
(76, 1, 'Login berhasil', '2026-05-20 07:20:30'),
(77, 2, 'Login berhasil', '2026-05-20 07:20:48'),
(78, 1, 'Login berhasil', '2026-05-20 07:36:45'),
(79, 2, 'Login berhasil', '2026-05-20 07:37:20'),
(80, 1, 'Login berhasil', '2026-05-20 07:38:15'),
(81, 1, 'Login berhasil', '2026-05-21 01:14:30'),
(82, 1, 'Logout', '2026-05-21 01:14:53'),
(83, 2, 'Login berhasil', '2026-05-21 01:15:02'),
(84, 1, 'Login berhasil', '2026-05-21 01:15:43'),
(85, 3, 'Login berhasil', '2026-05-21 01:16:13'),
(86, 1, 'Login berhasil', '2026-05-21 01:31:24'),
(87, 1, 'Login berhasil', '2026-05-21 04:56:39'),
(88, 1, 'Logout', '2026-05-21 04:56:48'),
(89, 1, 'Login berhasil', '2026-05-21 13:48:59'),
(90, 1, 'Login berhasil', '2026-05-21 15:25:18'),
(91, 1, 'Export data pengaduan ke Excel', '2026-05-21 15:26:57'),
(92, 1, 'Logout', '2026-05-21 15:28:11'),
(93, 3, 'Login berhasil', '2026-05-21 15:28:17'),
(94, 3, 'Logout', '2026-05-21 15:29:37'),
(95, 3, 'Login berhasil', '2026-05-22 05:33:11'),
(96, 3, 'Logout', '2026-05-22 05:33:16'),
(97, 3, 'Login berhasil', '2026-05-25 01:09:38'),
(98, 3, 'Login berhasil', '2026-05-29 07:34:58'),
(99, 3, 'Logout', '2026-05-29 07:35:00'),
(100, 1, 'Login berhasil', '2026-05-29 07:35:05'),
(101, 1, 'Logout', '2026-05-29 07:35:15'),
(102, 1, 'Login berhasil', '2026-05-29 07:38:50'),
(103, 1, 'Logout', '2026-05-29 07:38:56'),
(104, 4, 'Login berhasil', '2026-05-29 07:41:04'),
(105, 1, 'Login berhasil', '2026-05-29 07:41:18'),
(106, 4, 'Login berhasil', '2026-05-29 07:41:43'),
(107, 4, 'Membuat pengaduan baru', '2026-05-29 07:52:11'),
(108, 1, 'Login berhasil', '2026-05-29 07:52:21'),
(109, 1, 'Login berhasil', '2026-05-29 07:54:50'),
(110, 1, 'Memberi tanggapan pengaduan ID 1', '2026-05-29 08:04:02'),
(111, 4, 'Login berhasil', '2026-05-29 08:04:23'),
(112, 4, 'Login berhasil', '2026-05-29 08:04:59'),
(113, 1, 'Login berhasil', '2026-05-29 08:05:11'),
(114, 1, 'Update status pengaduan ID 1 menjadi Diproses', '2026-05-29 08:05:18'),
(115, 1, 'Memberi tanggapan pengaduan ID 1', '2026-05-29 08:05:24'),
(116, 4, 'Login berhasil', '2026-05-29 08:05:33'),
(117, 1, 'Login berhasil', '2026-05-29 09:54:52'),
(118, 1, 'Mengedit tanggapan pengaduan ID 1', '2026-05-29 10:04:43'),
(119, 1, 'Mengedit tanggapan pengaduan ID 1', '2026-05-29 10:21:00'),
(120, 1, 'Login berhasil', '2026-05-29 11:57:39'),
(121, 1, 'Logout', '2026-05-29 12:32:54'),
(122, 4, 'Login berhasil', '2026-05-29 12:33:05'),
(123, 4, 'Membuat pengaduan baru', '2026-05-29 12:38:49'),
(124, 1, 'Login berhasil', '2026-05-29 12:39:01'),
(125, 1, 'Login berhasil', '2026-05-30 14:06:20'),
(126, 1, 'Mengedit tanggapan pengaduan ID 2', '2026-05-30 14:52:50'),
(127, 4, 'Login berhasil', '2026-05-30 14:53:04'),
(128, 1, 'Login berhasil', '2026-05-30 16:44:55'),
(129, 4, 'Login berhasil', '2026-05-30 16:45:15'),
(130, 1, 'Login berhasil', '2026-06-02 01:24:58'),
(131, 4, 'Login berhasil', '2026-06-02 01:46:03'),
(132, 1, 'Login berhasil', '2026-06-02 02:12:51'),
(133, 1, 'Login berhasil', '2026-06-02 03:45:26'),
(134, 1, 'Mengedit tanggapan pengaduan ID 2', '2026-06-02 03:45:51'),
(135, 1, 'Update status pengaduan ID 2 menjadi Diproses', '2026-06-02 03:49:55'),
(136, 1, 'Update status pengaduan ID 1 menjadi Menunggu', '2026-06-02 03:50:01'),
(137, 1, 'Update status pengaduan ID 1 menjadi Diproses', '2026-06-02 04:01:31'),
(138, 1, 'Export data pengaduan ke Excel', '2026-06-02 08:14:32'),
(139, 2, 'Login berhasil', '2026-06-02 08:16:04'),
(140, 2, 'Logout', '2026-06-02 08:18:40'),
(141, 4, 'Login berhasil', '2026-06-02 08:18:46'),
(142, 4, 'Membuat pengaduan baru', '2026-06-02 08:26:26'),
(143, 1, 'Login berhasil', '2026-06-02 08:26:36'),
(144, 1, 'Login berhasil', '2026-06-02 08:26:57'),
(145, 4, 'Login berhasil', '2026-06-02 08:27:06'),
(146, 4, 'Logout', '2026-06-02 08:47:50'),
(147, 4, 'Login berhasil', '2026-06-02 08:47:58'),
(148, 4, 'Logout', '2026-06-02 08:48:05'),
(149, 4, 'Login berhasil', '2026-06-02 08:48:13'),
(150, 1, 'Login berhasil', '2026-06-02 08:50:31'),
(151, 4, 'Login berhasil', '2026-06-02 08:50:50'),
(152, 1, 'Login berhasil', '2026-06-02 08:55:30'),
(153, 4, 'Login berhasil', '2026-06-02 08:59:25'),
(154, 4, 'Logout', '2026-06-02 12:32:26'),
(155, 1, 'Login berhasil', '2026-06-02 12:38:39'),
(156, 5, 'Login berhasil', '2026-06-02 12:41:37'),
(157, 5, 'Logout', '2026-06-02 12:50:06'),
(158, 5, 'Login berhasil', '2026-06-02 13:17:26'),
(159, 2, 'Login berhasil', '2026-06-02 13:17:48'),
(160, 2, 'Logout', '2026-06-02 14:34:53'),
(161, 1, 'Login berhasil', '2026-06-02 14:34:57'),
(162, 2, 'Login berhasil', '2026-06-02 14:40:07'),
(163, 2, 'Logout', '2026-06-02 15:10:05'),
(164, 1, 'Login berhasil', '2026-06-02 15:10:12'),
(165, 1, 'Login berhasil', '2026-06-03 01:44:44'),
(166, 3, 'Login berhasil', '2026-06-03 01:45:25'),
(167, 3, 'Logout', '2026-06-03 02:24:04'),
(168, 3, 'Login berhasil', '2026-06-03 02:24:06'),
(169, 1, 'Login berhasil', '2026-06-04 01:13:40'),
(170, 1, 'Logout', '2026-06-04 01:14:57'),
(171, 4, 'Login berhasil', '2026-06-04 01:15:32'),
(172, 4, 'Logout', '2026-06-04 04:33:03'),
(173, 2, 'Login berhasil', '2026-06-04 04:33:08'),
(174, 2, 'Logout', '2026-06-04 05:02:12'),
(175, 1, 'Login berhasil', '2026-06-04 05:02:19'),
(176, 1, 'Login berhasil', '2026-06-04 08:06:04'),
(177, 1, 'Logout', '2026-06-04 08:18:46'),
(178, 3, 'Login berhasil', '2026-06-04 08:18:52'),
(179, 3, 'Login berhasil', '2026-06-04 08:19:16'),
(180, 3, 'Login berhasil', '2026-06-04 08:20:30'),
(181, 3, 'Logout', '2026-06-04 08:20:35'),
(182, 3, 'Login berhasil', '2026-06-04 08:20:36'),
(183, 3, 'Login berhasil', '2026-06-04 08:27:53'),
(184, 1, 'Login berhasil', '2026-06-04 08:45:35'),
(185, 1, 'Login berhasil', '2026-06-04 08:47:13'),
(186, 1, 'Logout', '2026-06-04 08:47:18'),
(187, 2, 'Login berhasil', '2026-06-04 08:48:52'),
(188, 2, 'Logout', '2026-06-04 08:49:11'),
(189, 2, 'Login berhasil', '2026-06-04 08:49:18'),
(190, 1, 'Login berhasil', '2026-06-04 09:43:55'),
(191, 1, 'Logout', '2026-06-04 09:46:31'),
(192, 1, 'Login berhasil', '2026-06-04 09:46:33'),
(193, 1, 'Logout', '2026-06-04 09:46:37'),
(194, 5, 'Login berhasil', '2026-06-04 09:46:59'),
(195, 1, 'Login berhasil', '2026-06-04 09:48:17'),
(196, 1, 'Logout', '2026-06-04 09:48:21'),
(197, 6, 'Login berhasil', '2026-06-04 09:50:10'),
(198, 6, 'Logout', '2026-06-04 09:51:25'),
(199, 1, 'Login berhasil', '2026-06-04 09:51:58'),
(200, 1, 'Update status pengaduan ID 3 menjadi Menunggu', '2026-06-04 09:57:57'),
(201, 6, 'Login berhasil', '2026-06-04 10:02:56'),
(202, 1, 'Login berhasil', '2026-06-04 10:03:25'),
(203, 6, 'Login berhasil', '2026-06-04 10:03:48'),
(204, 6, 'Logout', '2026-06-04 10:04:01'),
(205, 1, 'Login berhasil', '2026-06-04 10:04:03'),
(206, 1, 'Login berhasil', '2026-06-08 01:07:47'),
(207, 4, 'Login berhasil', '2026-06-08 01:08:13'),
(208, 1, 'Login berhasil', '2026-06-10 13:57:11'),
(209, 1, 'Login berhasil', '2026-06-11 02:17:17'),
(210, 1, 'Memblokir pengguna: mona', '2026-06-11 02:59:45'),
(211, 1, 'Membuka blokir pengguna: mona', '2026-06-11 02:59:51'),
(212, 1, 'Memblokir pengguna: mona', '2026-06-11 02:59:55'),
(213, 1, 'Membuka blokir pengguna: mona', '2026-06-11 02:59:57'),
(214, 1, 'Logout', '2026-06-11 03:02:56'),
(215, 1, 'Berhasil masuk ke sistem', '2026-06-11 03:02:58'),
(216, 1, 'Memblokir pengguna: brigita febriani', '2026-06-11 03:03:11'),
(217, 1, 'Membuka blokir pengguna: brigita febriani', '2026-06-11 03:03:30'),
(218, 1, 'Berhasil masuk ke sistem', '2026-06-11 03:03:32'),
(219, 1, 'Logout', '2026-06-11 03:03:40'),
(220, 4, 'Berhasil masuk ke sistem', '2026-06-11 03:03:46'),
(221, 1, 'Berhasil masuk ke sistem', '2026-06-11 03:04:05'),
(222, 4, 'Berhasil masuk ke sistem', '2026-06-11 03:04:23'),
(223, 4, 'Logout', '2026-06-11 14:15:03'),
(224, 7, 'Berhasil masuk ke sistem', '2026-06-11 14:25:20'),
(225, 7, 'Logout', '2026-06-11 14:25:25'),
(226, 8, 'Berhasil masuk ke sistem', '2026-06-11 14:31:24'),
(227, 8, 'Logout', '2026-06-11 14:31:27'),
(228, 1, 'Berhasil masuk ke sistem', '2026-06-12 03:52:00'),
(229, 1, 'Logout', '2026-06-12 03:53:13'),
(230, 1, 'Berhasil masuk ke sistem', '2026-06-12 03:53:26'),
(231, 4, 'Berhasil masuk ke sistem', '2026-06-12 03:57:21'),
(232, 4, 'Logout', '2026-06-12 03:57:37'),
(233, 9, 'Berhasil mengubah password (Lupa Password)', '2026-06-12 04:36:13'),
(234, 9, 'Berhasil masuk ke sistem', '2026-06-12 04:37:10'),
(235, 9, 'Logout', '2026-06-12 04:46:03'),
(236, 1, 'Berhasil masuk ke sistem', '2026-06-15 03:25:42'),
(237, 1, 'Logout', '2026-06-15 06:54:45'),
(238, 4, 'Berhasil masuk ke sistem', '2026-06-15 06:54:54'),
(239, 4, 'Logout', '2026-06-15 06:55:16'),
(240, 4, 'Berhasil masuk ke sistem', '2026-06-15 08:18:42'),
(241, 4, 'Logout', '2026-06-15 08:18:46'),
(242, 1, 'Berhasil masuk ke sistem', '2026-06-15 08:18:58'),
(243, 4, 'Berhasil masuk ke sistem', '2026-06-15 08:21:40'),
(244, 1, 'Berhasil masuk ke sistem', '2026-06-15 08:24:05'),
(245, 1, 'Memblokir pengguna: alexsander jerry', '2026-06-15 08:24:39'),
(246, 1, 'Membuka blokir pengguna: alexsander jerry', '2026-06-15 08:24:40'),
(247, 4, 'Berhasil masuk ke sistem', '2026-06-15 13:15:17'),
(248, 4, 'Logout', '2026-06-15 13:17:01'),
(249, 4, 'Berhasil masuk ke sistem', '2026-06-17 06:12:38'),
(250, 1, 'Berhasil masuk ke sistem', '2026-06-17 06:27:02'),
(251, 1, 'Logout', '2026-06-17 06:30:18'),
(252, 1, 'Berhasil masuk ke sistem', '2026-06-17 06:32:34'),
(253, 1, 'Logout', '2026-06-17 06:32:55'),
(254, 4, 'Berhasil masuk ke sistem', '2026-06-17 06:33:02'),
(255, 1, 'Berhasil masuk ke sistem', '2026-06-17 06:33:35'),
(256, 4, 'Berhasil masuk ke sistem', '2026-06-17 06:33:45'),
(257, 1, 'Berhasil masuk ke sistem', '2026-06-17 06:34:44'),
(258, 4, 'Logout', '2026-06-17 06:38:10'),
(259, 1, 'Berhasil masuk ke sistem', '2026-06-17 06:38:20'),
(260, 1, 'Berhasil masuk ke sistem', '2026-06-17 06:43:24'),
(261, 1, 'Logout', '2026-06-17 06:57:48'),
(262, 1, 'Berhasil masuk ke sistem', '2026-06-17 07:01:42'),
(263, 1, 'Logout', '2026-06-17 07:22:20'),
(264, 4, 'Berhasil masuk ke sistem', '2026-06-17 07:22:33'),
(265, 4, 'Logout', '2026-06-17 07:27:52'),
(266, 4, 'Berhasil masuk ke sistem', '2026-06-17 07:29:03'),
(267, 4, 'Logout', '2026-06-17 07:29:24'),
(268, 4, 'Berhasil masuk ke sistem', '2026-06-17 07:45:27'),
(269, 1, 'Berhasil masuk ke sistem', '2026-06-17 07:45:33'),
(270, 1, 'Berhasil masuk ke sistem', '2026-06-17 07:46:25'),
(271, 1, 'Logout', '2026-06-17 07:48:00'),
(272, 4, 'Berhasil masuk ke sistem', '2026-06-17 07:48:06'),
(273, 1, 'Berhasil masuk ke sistem', '2026-06-17 07:54:04'),
(274, 1, 'Export data pengaduan ke Excel', '2026-06-17 08:00:23'),
(275, 1, 'Logout', '2026-06-17 08:07:48'),
(276, 11, 'Berhasil masuk ke sistem', '2026-06-17 08:07:53'),
(277, 11, 'Membuat pengaduan baru', '2026-06-17 08:20:23'),
(278, 1, 'Berhasil masuk ke sistem', '2026-06-17 08:20:30'),
(279, 11, 'Berhasil masuk ke sistem', '2026-06-17 08:22:18'),
(280, 1, 'Berhasil masuk ke sistem', '2026-06-17 08:22:42'),
(281, 1, 'Export data pengaduan ke Excel', '2026-06-17 08:22:46'),
(282, 11, 'Berhasil masuk ke sistem', '2026-06-17 08:23:28'),
(283, 11, 'Membuat pengaduan baru', '2026-06-17 08:24:34'),
(284, 1, 'Berhasil masuk ke sistem', '2026-06-17 08:24:41'),
(285, 11, 'Berhasil masuk ke sistem', '2026-06-17 08:32:16'),
(286, 4, 'Berhasil masuk ke sistem', '2026-06-17 13:50:18'),
(287, 4, 'Logout', '2026-06-17 14:19:35'),
(288, 1, 'Berhasil masuk ke sistem', '2026-06-17 14:19:39'),
(289, 4, 'Berhasil masuk ke sistem', '2026-06-17 14:30:45'),
(290, 1, 'Berhasil masuk ke sistem', '2026-06-17 14:32:04'),
(291, 1, 'Logout', '2026-06-17 14:40:46'),
(292, 1, 'Berhasil masuk ke sistem', '2026-06-17 15:03:59'),
(293, 4, 'Berhasil masuk ke sistem', '2026-06-17 15:41:42'),
(294, 1, 'Berhasil masuk ke sistem', '2026-06-18 00:44:46'),
(295, 1, 'Berhasil masuk ke sistem', '2026-06-18 13:17:09'),
(296, 1, 'Export data pengaduan ke Excel', '2026-06-18 13:17:33'),
(297, 1, 'Logout', '2026-06-18 13:19:28'),
(298, 4, 'Berhasil masuk ke sistem', '2026-06-18 13:19:40'),
(299, 4, 'Membuat pengaduan baru', '2026-06-18 13:20:40'),
(300, 1, 'Berhasil masuk ke sistem', '2026-06-18 13:20:47'),
(301, 1, 'Update status pengaduan ID 7 menjadi Diproses', '2026-06-18 13:21:11'),
(302, 1, 'Mengedit tanggapan pengaduan ID 7', '2026-06-18 13:30:25'),
(303, 4, 'Berhasil masuk ke sistem', '2026-06-18 13:31:02'),
(304, 4, 'Logout', '2026-06-18 13:31:30'),
(305, 4, 'Berhasil masuk ke sistem', '2026-06-18 13:31:36'),
(306, 1, 'Berhasil masuk ke sistem', '2026-06-18 13:31:45'),
(307, 1, 'Memblokir pengguna: brigita febriani', '2026-06-18 13:31:59'),
(308, 1, 'Memblokir pengguna: yusta', '2026-06-18 13:32:37'),
(309, 1, 'Membuka blokir pengguna: brigita febriani', '2026-06-18 13:33:06'),
(310, 1, 'Membuka blokir pengguna: yusta', '2026-06-18 13:33:08'),
(311, 1, 'Update status pengaduan ID 7 menjadi Ditolak', '2026-06-18 13:34:46'),
(312, 1, 'Mengedit tanggapan pengaduan ID 7', '2026-06-18 13:34:56'),
(313, 4, 'Berhasil masuk ke sistem', '2026-06-18 13:35:14'),
(314, 4, 'Logout', '2026-06-18 13:36:03'),
(315, 1, 'Berhasil masuk ke sistem', '2026-06-18 13:36:17'),
(316, 1, 'Mengedit tanggapan pengaduan ID 6', '2026-06-18 16:23:41'),
(317, 1, 'Logout', '2026-06-18 16:59:35'),
(318, 12, 'Berhasil masuk ke sistem', '2026-06-19 00:28:45'),
(319, 12, 'Membuat pengaduan baru', '2026-06-19 00:35:05'),
(320, 1, 'Berhasil masuk ke sistem', '2026-06-19 00:35:22'),
(321, 1, 'Mengedit tanggapan pengaduan ID 8', '2026-06-19 00:59:02'),
(322, 1, 'Logout', '2026-06-19 01:43:05'),
(323, 1, 'Berhasil masuk ke sistem', '2026-06-19 01:43:07'),
(324, 1, 'Berhasil masuk ke sistem', '2026-06-19 01:46:24'),
(325, 12, 'Berhasil masuk ke sistem', '2026-06-19 01:54:11'),
(326, 12, 'Membuat pengaduan baru', '2026-06-19 01:55:21'),
(327, 1, 'Berhasil masuk ke sistem', '2026-06-19 01:55:54'),
(328, 1, 'Mengedit tanggapan pengaduan ID 9', '2026-06-19 01:56:08'),
(329, 12, 'Berhasil masuk ke sistem', '2026-06-19 01:56:18'),
(330, 1, 'Berhasil masuk ke sistem', '2026-06-19 02:58:35'),
(331, 1, 'Mengedit tanggapan pengaduan ID 9', '2026-06-19 03:01:01'),
(332, 1, 'Memblokir pengguna: jerry', '2026-06-19 03:01:28'),
(333, 1, 'Membuka blokir pengguna: jerry', '2026-06-19 03:01:43'),
(334, 1, 'Export data pengaduan ke Excel', '2026-06-19 03:02:58'),
(335, 1, 'Logout', '2026-06-19 03:03:34'),
(336, 13, 'Berhasil masuk ke sistem', '2026-06-19 03:04:21'),
(337, 13, 'Membuat pengaduan baru', '2026-06-19 03:05:38'),
(338, 13, 'Logout', '2026-06-19 03:06:23'),
(339, 1, 'Berhasil masuk ke sistem', '2026-06-19 03:06:25'),
(340, 1, 'Update status pengaduan ID 10 menjadi Diproses', '2026-06-19 03:06:38'),
(341, 1, 'Mengedit tanggapan pengaduan ID 10', '2026-06-19 03:06:58'),
(342, 13, 'Berhasil masuk ke sistem', '2026-06-19 03:07:07'),
(343, 13, 'Logout', '2026-06-19 03:07:52'),
(344, 9, 'Berhasil mengubah password (Lupa Password)', '2026-06-19 03:10:17'),
(345, 9, 'Berhasil masuk ke sistem', '2026-06-19 03:10:53'),
(346, 9, 'Logout', '2026-06-19 03:11:01'),
(347, 13, 'Berhasil masuk ke sistem', '2026-06-19 03:11:35'),
(348, 1, 'Berhasil masuk ke sistem', '2026-06-19 03:11:42'),
(349, 1, 'Memblokir pengguna: romy', '2026-06-19 03:11:48'),
(350, 1, 'Berhasil masuk ke sistem', '2026-06-19 03:12:51'),
(351, 1, 'Membuka blokir pengguna: romy', '2026-06-19 03:12:57'),
(352, 1, 'Logout', '2026-06-19 03:13:03'),
(353, 13, 'Berhasil masuk ke sistem', '2026-06-19 03:13:09'),
(354, 13, 'Logout', '2026-06-19 03:13:14'),
(355, 1, 'Berhasil masuk ke sistem', '2026-06-19 03:13:18'),
(356, 13, 'Berhasil masuk ke sistem', '2026-06-19 03:13:55'),
(357, 1, 'Berhasil masuk ke sistem', '2026-06-19 03:14:01'),
(358, 1, 'Logout', '2026-06-19 03:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pengaduan`
--

CREATE TABLE `kategori_pengaduan` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_pengaduan`
--

INSERT INTO `kategori_pengaduan` (`id`, `nama_kategori`) VALUES
(6, 'Hoaks & Disinformasi'),
(7, 'Situs / Konten Ilegal'),
(8, 'Spam Nomor & Penipuan Digital'),
(9, 'Gangguan Website / Sistem Pemerintah'),
(10, 'Gangguan Jaringan / WiFi'),
(11, 'Pemantauan / Gangguan CCTV'),
(13, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_login` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `username`, `status_login`, `ip_address`, `created_at`) VALUES
(1, NULL, 'olincha', 'Gagal', '::1', '2026-05-06 03:10:55'),
(2, 1, 'admin', 'Berhasil', '::1', '2026-05-06 03:10:59'),
(3, 2, 'olincha', 'Berhasil', '::1', '2026-05-06 03:59:03'),
(4, 1, 'admin', 'Berhasil', '::1', '2026-05-06 03:59:16'),
(5, 1, 'admin', 'Berhasil', '::1', '2026-05-06 03:59:50'),
(6, 2, 'olincha', 'Berhasil', '::1', '2026-05-06 03:59:59'),
(7, 1, 'admin', 'Berhasil', '::1', '2026-05-06 04:00:21'),
(8, 2, 'olincha', 'Berhasil', '::1', '2026-05-06 04:39:02'),
(9, 1, 'admin', 'Berhasil', '::1', '2026-05-07 15:13:25'),
(10, 1, 'admin', 'Berhasil', '::1', '2026-05-07 15:36:40'),
(11, 1, 'admin', 'Berhasil', '::1', '2026-05-07 15:45:31'),
(12, 2, 'olincha', 'Berhasil', '::1', '2026-05-07 15:45:39'),
(13, 1, 'admin', 'Berhasil', '::1', '2026-05-07 15:45:47'),
(14, 3, 'Teoo', 'Berhasil', '::1', '2026-05-07 15:46:07'),
(15, 1, 'admin', 'Berhasil', '::1', '2026-05-07 15:48:44'),
(16, 1, 'admin', 'Berhasil', '::1', '2026-05-07 16:01:01'),
(17, 2, 'olincha', 'Berhasil', '::1', '2026-05-07 16:01:41'),
(18, 1, 'admin', 'Berhasil', '::1', '2026-05-07 16:02:53'),
(19, 1, 'admin', 'Berhasil', '::1', '2026-05-08 02:57:57'),
(20, 2, 'olincha', 'Berhasil', '::1', '2026-05-08 02:59:49'),
(21, 1, 'admin', 'Berhasil', '127.0.0.1', '2026-05-08 03:14:06'),
(22, 2, 'olincha', 'Berhasil', '::1', '2026-05-09 06:43:28'),
(23, 2, 'olincha', 'Berhasil', '::1', '2026-05-09 07:17:30'),
(24, 2, 'olincha', 'Berhasil', '::1', '2026-05-09 07:19:42'),
(25, 2, 'olincha', 'Berhasil', '::1', '2026-05-09 13:46:47'),
(26, 2, 'olincha', 'Berhasil', '::1', '2026-05-11 01:29:59'),
(27, 1, 'admin', 'Berhasil', '::1', '2026-05-11 01:30:08'),
(28, 1, 'admin', 'Berhasil', '::1', '2026-05-11 06:09:57'),
(29, 1, 'admin', 'Berhasil', '::1', '2026-05-12 02:02:19'),
(30, 2, 'olincha', 'Berhasil', '::1', '2026-05-12 03:46:32'),
(31, 1, 'admin', 'Berhasil', '::1', '2026-05-12 07:25:34'),
(32, 1, 'admin', 'Berhasil', '::1', '2026-05-12 07:57:01'),
(33, 2, 'olincha', 'Berhasil', '::1', '2026-05-12 08:37:34'),
(34, 2, 'olincha', 'Berhasil', '::1', '2026-05-12 08:49:08'),
(35, 1, 'admin', 'Berhasil', '::1', '2026-05-12 08:49:19'),
(36, 1, 'admin', 'Berhasil', '::1', '2026-05-13 01:08:57'),
(37, 2, 'olincha', 'Berhasil', '::1', '2026-05-13 01:30:05'),
(38, 1, 'admin', 'Berhasil', '::1', '2026-05-13 02:17:33'),
(39, 1, 'admin', 'Berhasil', '::1', '2026-05-13 02:34:51'),
(40, 1, 'admin', 'Berhasil', '::1', '2026-05-13 07:36:47'),
(41, 1, 'admin', 'Berhasil', '::1', '2026-05-18 01:00:45'),
(42, 2, 'olincha', 'Berhasil', '::1', '2026-05-18 03:06:52'),
(43, 1, 'admin', 'Berhasil', '::1', '2026-05-18 04:31:46'),
(44, 2, 'olincha', 'Berhasil', '::1', '2026-05-18 04:43:00'),
(45, 2, 'olincha', 'Berhasil', '::1', '2026-05-18 05:08:49'),
(46, 2, 'olincha', 'Berhasil', '::1', '2026-05-19 07:53:50'),
(47, 1, 'admin', 'Berhasil', '::1', '2026-05-20 04:56:26'),
(48, 2, 'olincha', 'Berhasil', '::1', '2026-05-20 07:17:45'),
(49, 1, 'admin', 'Berhasil', '::1', '2026-05-20 07:18:38'),
(50, 2, 'olincha', 'Berhasil', '::1', '2026-05-20 07:19:18'),
(51, 2, 'olincha', 'Berhasil', '::1', '2026-05-20 07:20:03'),
(52, 1, 'admin', 'Berhasil', '::1', '2026-05-20 07:20:30'),
(53, 2, 'olincha', 'Berhasil', '::1', '2026-05-20 07:20:48'),
(54, 1, 'admin', 'Berhasil', '::1', '2026-05-20 07:36:45'),
(55, 2, 'olincha', 'Berhasil', '::1', '2026-05-20 07:37:20'),
(56, 1, 'admin', 'Berhasil', '::1', '2026-05-20 07:38:15'),
(57, 1, 'admin', 'Berhasil', '::1', '2026-05-21 01:14:30'),
(58, 2, 'olincha', 'Berhasil', '::1', '2026-05-21 01:15:02'),
(59, 1, 'admin', 'Berhasil', '::1', '2026-05-21 01:15:43'),
(60, 3, 'Teoo', 'Berhasil', '::1', '2026-05-21 01:16:13'),
(61, 1, 'admin', 'Berhasil', '::1', '2026-05-21 01:31:24'),
(62, 1, 'admin', 'Berhasil', '::1', '2026-05-21 04:56:39'),
(63, 1, 'admin', 'Berhasil', '::1', '2026-05-21 13:48:59'),
(64, 1, 'admin', 'Berhasil', '::1', '2026-05-21 15:25:18'),
(65, 3, 'Teoo', 'Berhasil', '::1', '2026-05-21 15:28:17'),
(66, 3, 'Teoo', 'Berhasil', '::1', '2026-05-22 05:33:11'),
(67, 3, 'Teoo', 'Berhasil', '::1', '2026-05-25 01:09:38'),
(68, 3, 'Teoo', 'Berhasil', '::1', '2026-05-29 07:34:58'),
(69, 1, 'admin', 'Berhasil', '::1', '2026-05-29 07:35:05'),
(70, 1, 'admin', 'Berhasil', '::1', '2026-05-29 07:38:50'),
(71, 4, 'brigit', 'Berhasil', '::1', '2026-05-29 07:41:04'),
(72, 1, 'admin', 'Berhasil', '::1', '2026-05-29 07:41:18'),
(73, 4, 'brigit', 'Berhasil', '::1', '2026-05-29 07:41:43'),
(74, 1, 'admin', 'Berhasil', '::1', '2026-05-29 07:52:21'),
(75, 1, 'admin', 'Berhasil', '::1', '2026-05-29 07:54:50'),
(76, 4, 'brigit', 'Berhasil', '::1', '2026-05-29 08:04:23'),
(77, 4, 'brigit', 'Berhasil', '::1', '2026-05-29 08:04:59'),
(78, 1, 'admin', 'Berhasil', '::1', '2026-05-29 08:05:11'),
(79, 4, 'brigit', 'Berhasil', '::1', '2026-05-29 08:05:33'),
(80, 1, 'admin', 'Berhasil', '::1', '2026-05-29 09:54:52'),
(81, 1, 'admin', 'Berhasil', '::1', '2026-05-29 11:57:39'),
(82, 4, 'brigit', 'Berhasil', '::1', '2026-05-29 12:33:05'),
(83, 1, 'admin', 'Berhasil', '::1', '2026-05-29 12:39:01'),
(84, 1, 'admin', 'Berhasil', '::1', '2026-05-30 14:06:19'),
(85, 4, 'brigit', 'Berhasil', '::1', '2026-05-30 14:53:04'),
(86, 1, 'admin', 'Berhasil', '::1', '2026-05-30 16:44:55'),
(87, 4, 'brigit', 'Berhasil', '::1', '2026-05-30 16:45:15'),
(88, 1, 'admin', 'Berhasil', '::1', '2026-06-02 01:24:58'),
(89, 4, 'brigit', 'Berhasil', '::1', '2026-06-02 01:46:03'),
(90, 1, 'admin', 'Berhasil', '::1', '2026-06-02 02:12:51'),
(91, 1, 'admin', 'Berhasil', '::1', '2026-06-02 03:45:26'),
(92, 2, 'olincha', 'Berhasil', '::1', '2026-06-02 08:16:04'),
(93, 4, 'brigit', 'Berhasil', '::1', '2026-06-02 08:18:46'),
(94, 1, 'admin', 'Berhasil', '::1', '2026-06-02 08:26:36'),
(95, 1, 'admin', 'Berhasil', '::1', '2026-06-02 08:26:57'),
(96, 4, 'brigit', 'Berhasil', '::1', '2026-06-02 08:27:06'),
(97, 4, 'brigit', 'Berhasil', '::1', '2026-06-02 08:47:58'),
(98, 4, 'brigit', 'Berhasil', '::1', '2026-06-02 08:48:13'),
(99, 1, 'admin', 'Berhasil', '::1', '2026-06-02 08:50:31'),
(100, 4, 'brigit', 'Berhasil', '::1', '2026-06-02 08:50:50'),
(101, 1, 'admin', 'Berhasil', '::1', '2026-06-02 08:55:30'),
(102, 4, 'brigit ', 'Berhasil', '::1', '2026-06-02 08:59:25'),
(103, 1, 'admin', 'Berhasil', '::1', '2026-06-02 12:38:39'),
(104, 5, 'pepot', 'Berhasil', '::1', '2026-06-02 12:41:37'),
(105, 5, 'pepot', 'Berhasil', '::1', '2026-06-02 13:17:26'),
(106, 2, 'olincha', 'Berhasil', '::1', '2026-06-02 13:17:48'),
(107, 1, 'admin', 'Berhasil', '::1', '2026-06-02 14:34:57'),
(108, 2, 'olincha', 'Berhasil', '::1', '2026-06-02 14:40:07'),
(109, 1, 'admin', 'Berhasil', '::1', '2026-06-02 15:10:12'),
(110, 1, 'admin', 'Berhasil', '::1', '2026-06-03 01:44:44'),
(111, 3, 'Teoo', 'Berhasil', '::1', '2026-06-03 01:45:25'),
(112, 3, 'Teoo', 'Berhasil', '::1', '2026-06-03 02:24:06'),
(113, 1, 'admin', 'Berhasil', '::1', '2026-06-04 01:13:40'),
(114, NULL, 'brigit', 'Gagal', '::1', '2026-06-04 01:15:24'),
(115, 4, 'brigit', 'Berhasil', '::1', '2026-06-04 01:15:32'),
(116, 2, 'olincha', 'Berhasil', '::1', '2026-06-04 04:33:08'),
(117, 1, 'admin', 'Berhasil', '::1', '2026-06-04 05:02:19'),
(118, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:06:04'),
(119, 3, 'Teoo', 'Berhasil', '::1', '2026-06-04 08:18:52'),
(120, 3, 'Teoo', 'Berhasil', '::1', '2026-06-04 08:19:16'),
(121, 3, 'Teoo', 'Berhasil', '::1', '2026-06-04 08:20:30'),
(122, 3, 'Teoo', 'Berhasil', '::1', '2026-06-04 08:20:36'),
(123, 3, 'Teoo', 'Berhasil', '::1', '2026-06-04 08:27:53'),
(124, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:45:35'),
(125, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:47:13'),
(126, NULL, 'Nando', 'Gagal', '::1', '2026-06-04 08:47:22'),
(127, NULL, 'vernando', 'Gagal', '::1', '2026-06-04 08:47:29'),
(128, NULL, 'nando', 'Gagal', '::1', '2026-06-04 08:47:37'),
(129, NULL, 'nando', 'Gagal', '::1', '2026-06-04 08:48:16'),
(130, 2, 'olincha', 'Berhasil', '::1', '2026-06-04 08:48:52'),
(131, 2, 'yusta', 'Berhasil', '::1', '2026-06-04 08:49:18'),
(132, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:57:25'),
(133, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:57:31'),
(134, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:57:39'),
(135, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:57:58'),
(136, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:58:10'),
(137, 1, 'admin', 'Berhasil', '::1', '2026-06-04 08:59:08'),
(138, NULL, 'brigit', 'Gagal', '::1', '2026-06-04 09:32:04'),
(139, NULL, 'olincha', 'Gagal', '::1', '2026-06-04 09:32:10'),
(140, NULL, 'yusta', 'Gagal', '::1', '2026-06-04 09:32:17'),
(141, 1, 'admin', 'Berhasil', '::1', '2026-06-04 09:32:36'),
(142, NULL, 'pepot', 'Gagal', '::1', '2026-06-04 09:32:56'),
(143, 5, 'pepot', 'Berhasil', '::1', '2026-06-04 09:33:03'),
(144, NULL, 'admin', 'Gagal - Password Salah', '::1', '2026-06-04 09:38:09'),
(145, NULL, 'pepot', 'Gagal - Password Salah', '::1', '2026-06-04 09:38:26'),
(146, 1, 'admin', 'Berhasil', '::1', '2026-06-04 09:39:33'),
(147, NULL, 'admin', 'Gagal', NULL, '2026-06-04 09:43:55'),
(148, NULL, 'admin', 'Gagal', NULL, '2026-06-04 09:46:33'),
(149, NULL, 'yusta', 'Gagal', '::1', '2026-06-04 09:46:42'),
(150, NULL, 'pepot', 'Gagal', NULL, '2026-06-04 09:46:59'),
(151, NULL, 'admin', 'Gagal', NULL, '2026-06-04 09:48:17'),
(152, NULL, 'brigit', 'Gagal', '::1', '2026-06-04 09:48:28'),
(153, NULL, 'nando', 'Gagal', '::1', '2026-06-04 09:48:54'),
(154, NULL, 'vernando', 'Gagal', '::1', '2026-06-04 09:49:02'),
(155, NULL, 'monang', 'Gagal', NULL, '2026-06-04 09:50:10'),
(156, NULL, 'admin', 'Gagal', NULL, '2026-06-04 09:51:58'),
(157, NULL, 'monang', 'Gagal', NULL, '2026-06-04 10:02:56'),
(158, NULL, 'admin', 'Gagal', NULL, '2026-06-04 10:03:25'),
(159, NULL, 'monang', 'Gagal', NULL, '2026-06-04 10:03:48'),
(160, NULL, 'admin', 'Gagal', NULL, '2026-06-04 10:04:03'),
(161, NULL, 'admin', 'Gagal', NULL, '2026-06-08 01:07:47'),
(162, NULL, 'brigit', 'Gagal', '::1', '2026-06-08 01:08:05'),
(163, NULL, 'brigit', 'Gagal', NULL, '2026-06-08 01:08:13'),
(164, NULL, 'admin', 'Gagal', NULL, '2026-06-10 13:57:11'),
(165, NULL, 'admin', 'Gagal', NULL, '2026-06-11 02:17:17'),
(166, 1, 'admin', 'Berhasil', '::1', '2026-06-11 03:02:58'),
(167, NULL, 'brigit', 'Gagal - Akun Diblokir', '::1', '2026-06-11 03:03:21'),
(168, 1, 'admin', 'Berhasil', '::1', '2026-06-11 03:03:32'),
(169, 4, 'brigit', 'Berhasil', '::1', '2026-06-11 03:03:46'),
(170, 1, 'admin', 'Berhasil', '::1', '2026-06-11 03:04:05'),
(171, 4, 'brigit', 'Berhasil', '::1', '2026-06-11 03:04:23'),
(172, NULL, 'brigit', 'Gagal - Username/Password Salah', '::1', '2026-06-11 14:22:22'),
(173, 7, 'teoganteng', 'Berhasil', '::1', '2026-06-11 14:25:20'),
(174, NULL, 'teoganteng', 'Gagal - Username/Password Salah', '::1', '2026-06-11 14:25:33'),
(175, 8, 'pepin', 'Berhasil', '::1', '2026-06-11 14:31:24'),
(176, NULL, 'pepin', 'Gagal - Username/Password Salah', '::1', '2026-06-11 14:31:35'),
(177, 1, 'Admin', 'Berhasil', '192.168.1.201', '2026-06-12 03:52:00'),
(178, 1, 'admin', 'Berhasil', '::1', '2026-06-12 03:53:26'),
(179, 4, 'brigit', 'Berhasil', '::1', '2026-06-12 03:57:21'),
(180, NULL, 'melvinn', 'Gagal - Username/Password Salah', '::1', '2026-06-12 04:37:04'),
(181, 9, 'melvinn', 'Berhasil', '::1', '2026-06-12 04:37:10'),
(182, 1, 'admin', 'Berhasil', '::1', '2026-06-15 03:25:42'),
(183, 4, 'brigit', 'Berhasil', '::1', '2026-06-15 06:54:54'),
(184, 4, 'brigit', 'Berhasil', '::1', '2026-06-15 08:18:42'),
(185, 1, 'admin', 'Berhasil', '::1', '2026-06-15 08:18:58'),
(186, NULL, 'brigit', 'Gagal - Username/Password Salah', '::1', '2026-06-15 08:21:12'),
(187, NULL, 'brigit', 'Gagal - Username/Password Salah', '::1', '2026-06-15 08:21:22'),
(188, 4, 'brigit', 'Berhasil', '::1', '2026-06-15 08:21:40'),
(189, 1, 'admin', 'Berhasil', '::1', '2026-06-15 08:24:05'),
(190, 4, 'brigit', 'Berhasil', '::1', '2026-06-15 13:15:17'),
(191, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 06:12:38'),
(192, 1, 'admin', 'Berhasil', '::1', '2026-06-17 06:27:02'),
(193, 1, 'Admin', 'Berhasil', '192.168.1.201', '2026-06-17 06:32:34'),
(194, 4, 'brigit', 'Berhasil', '192.168.1.201', '2026-06-17 06:33:02'),
(195, 1, 'admin', 'Berhasil', '::1', '2026-06-17 06:33:35'),
(196, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 06:33:45'),
(197, 1, 'admin', 'Berhasil', '::1', '2026-06-17 06:34:44'),
(198, 1, 'admin', 'Berhasil', '192.168.1.201', '2026-06-17 06:38:20'),
(199, 1, 'admin', 'Berhasil', '192.168.1.201', '2026-06-17 06:43:24'),
(200, 1, 'admin', 'Berhasil', '192.168.1.201', '2026-06-17 07:01:42'),
(201, 4, 'brigit', 'Berhasil', '192.168.1.201', '2026-06-17 07:22:33'),
(202, 4, 'brigit', 'Berhasil', '192.168.1.201', '2026-06-17 07:29:03'),
(203, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 07:45:27'),
(204, 1, 'admin', 'Berhasil', '::1', '2026-06-17 07:45:33'),
(205, 1, 'admin', 'Berhasil', '::1', '2026-06-17 07:46:25'),
(206, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 07:48:06'),
(207, 1, 'admin', 'Berhasil', '::1', '2026-06-17 07:54:04'),
(208, 11, 'floo', 'Berhasil', '::1', '2026-06-17 08:07:53'),
(209, 1, 'admin', 'Berhasil', '::1', '2026-06-17 08:20:30'),
(210, 11, 'floo', 'Berhasil', '::1', '2026-06-17 08:22:18'),
(211, 1, 'admin', 'Berhasil', '::1', '2026-06-17 08:22:42'),
(212, 11, 'floo', 'Berhasil', '::1', '2026-06-17 08:23:28'),
(213, 1, 'admin', 'Berhasil', '::1', '2026-06-17 08:24:41'),
(214, 11, 'floo', 'Berhasil', '::1', '2026-06-17 08:32:16'),
(215, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 13:50:18'),
(216, 1, 'admin', 'Berhasil', '::1', '2026-06-17 14:19:39'),
(217, NULL, 'Nando', 'Gagal - Username/Password Salah', '::1', '2026-06-17 14:30:37'),
(218, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 14:30:45'),
(219, 1, 'admin', 'Berhasil', '::1', '2026-06-17 14:32:04'),
(220, 1, 'admin', 'Berhasil', '::1', '2026-06-17 15:03:59'),
(221, 4, 'brigit', 'Berhasil', '::1', '2026-06-17 15:41:42'),
(222, 1, 'admin', 'Berhasil', '::1', '2026-06-18 00:44:46'),
(223, 1, 'admin', 'Berhasil', '::1', '2026-06-18 13:17:09'),
(224, 4, 'brigit', 'Berhasil', '::1', '2026-06-18 13:19:40'),
(225, 1, 'admin', 'Berhasil', '::1', '2026-06-18 13:20:47'),
(226, 4, 'brigit', 'Berhasil', '::1', '2026-06-18 13:31:02'),
(227, 4, 'brigitt', 'Berhasil', '::1', '2026-06-18 13:31:36'),
(228, 1, 'admin', 'Berhasil', '::1', '2026-06-18 13:31:45'),
(229, NULL, 'brigitt', 'Gagal - Akun Diblokir', '::1', '2026-06-18 13:32:12'),
(230, NULL, 'brigitt', 'Gagal - Username/Password Salah', '::1', '2026-06-18 13:35:07'),
(231, 4, 'brigitt', 'Berhasil', '::1', '2026-06-18 13:35:14'),
(232, 1, 'admin', 'Berhasil', '::1', '2026-06-18 13:36:17'),
(233, 12, 'jer01', 'Berhasil', '::1', '2026-06-19 00:28:45'),
(234, 1, 'admin', 'Berhasil', '::1', '2026-06-19 00:35:22'),
(235, 1, 'admin', 'Berhasil', '::1', '2026-06-19 01:43:07'),
(236, 1, 'admin', 'Berhasil', '::1', '2026-06-19 01:46:24'),
(237, 12, 'jer01', 'Berhasil', '::1', '2026-06-19 01:54:11'),
(238, 1, 'admin', 'Berhasil', '::1', '2026-06-19 01:55:53'),
(239, 12, 'jer01', 'Berhasil', '::1', '2026-06-19 01:56:18'),
(240, 1, 'admin', 'Berhasil', '::1', '2026-06-19 02:58:35'),
(241, 13, 'rom', 'Berhasil', '::1', '2026-06-19 03:04:21'),
(242, 1, 'admin', 'Berhasil', '::1', '2026-06-19 03:06:25'),
(243, 13, 'rom', 'Berhasil', '::1', '2026-06-19 03:07:06'),
(244, 9, 'melvinn', 'Berhasil', '::1', '2026-06-19 03:10:53'),
(245, 13, 'rom', 'Berhasil', '::1', '2026-06-19 03:11:35'),
(246, 1, 'admin', 'Berhasil', '::1', '2026-06-19 03:11:42'),
(247, NULL, 'rom', 'Gagal - Akun Diblokir', '::1', '2026-06-19 03:11:59'),
(248, 1, 'admin', 'Berhasil', '::1', '2026-06-19 03:12:51'),
(249, 13, 'rom', 'Berhasil', '::1', '2026-06-19 03:13:09'),
(250, 1, 'admin', 'Berhasil', '::1', '2026-06-19 03:13:18'),
(251, 13, 'rom', 'Berhasil', '::1', '2026-06-19 03:13:55'),
(252, 1, 'admin', 'Berhasil', '::1', '2026-06-19 03:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `nomor_darurat`
--

CREATE TABLE `nomor_darurat` (
  `id` int NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nomor_darurat`
--

INSERT INTO `nomor_darurat` (`id`, `nama_layanan`, `nomor_telepon`, `keterangan`, `created_at`) VALUES
(113, 'PIC PSC 119 Kesehatan (Pak Suharyono)', '0812-5735-294', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(114, 'RS DKT', '(0562) 635171', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(115, 'RSJ Buduk', '(0562) 638995', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(116, 'RS Abdul Aziz', '(0562) 631798', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(117, 'RSUD Abdul Aziz (IGD/Ambulan)', '0813-5005-2983', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(118, 'RS Santo Vincentius', '(0562) 635171 / 0857-8700-0603', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(119, 'RS Harapan Bersama', '(0562) 632589 / 0821-5621-1481', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(120, 'Puskesmas Utara I', '0851-8493-8343', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(121, 'Puskesmas Selatan I', '0838-7457-2250', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(122, 'Call Center COVID-19', '(0562) 6300721', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(123, 'PMI', '(0562) 631141', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(124, 'ASPAR Supir Ambulance', '0896-6969-3966', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(125, '(Informasi RS) Alwi', '0821-5406-7488', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(126, '(Informasi RS) Ipung', '0852-5246-9484', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(127, '(RSUD Abdul Aziz) Kak Mis', '0822-5643-4863', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(128, 'Dinas Kesehatan 119 (WA)', '0823-4374-9119', 'Bidang Kesehatan', '2026-05-13 02:34:24'),
(129, 'PIC DAMKAR (Farhan/Nur/Fajar)', '0817-6817-791 / 0895-3461-77546 / 0898-0672-892', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(130, 'PMK Dwi Tunggal', '(0562) 631032', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(131, 'Pos Lalu Lintas', '(0562) 631024', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(132, '(BPBD) Yanto Lapangan', '0895-7112-30066', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(133, '(BPBD) Imam Lesmana Siang', '0856-5085-0695', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(134, '(BPBD) Fazri Malam', '0812-5724-4057', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(135, 'Babin Polsek Singkawang Selatan', '0822-5161-0282', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(136, 'Patroli Perintis Presisi (Polisi)', '0811-5661-110', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(137, 'Polres Singkawang', '(0562) 631150', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(138, 'Bhabinkamtibmas Setapuk Kecil (Bg Safarudin)', '0812-5469-2789', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(139, 'Bhabin Timur', '0857-5094-0045', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(140, 'Bhabinkamtibmas Bagak Sahwa (Polsek Timur/Frans)', '0857-0502-7465', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(141, 'Bhabinkamtibmas Bukit Batu (Polsek Tengah/Bg Agus)', '0896-6479-9122', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(142, 'Bhabinkamtibmas Kel. Melayu (Polsek Barat/Bg Yudi)', '0852-5249-2424', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(143, 'Bhabinkamtibmas Kel. Jawa (Polsek Tengah/Bg Rahmat)', '0857-0406-2004', 'Bidang Penanggulangan Bencana & Keamanan', '2026-05-13 02:34:24'),
(144, 'Gangguan PLN (Kawan Agung)', '(0562) 631062 / 0858-2238-1777', 'Bidang Layanan Utilitas Publik', '2026-05-13 02:34:24'),
(145, 'Telkom', '(0562) 634480', 'Bidang Layanan Utilitas Publik', '2026-05-13 02:34:24'),
(146, 'Penerangan Jalan Umum', '0811-574-455', 'Bidang Layanan Utilitas Publik', '2026-05-13 02:34:24'),
(147, '(Dishub) Operator Fitri', '0831-5236-1712', 'Bidang Layanan Utilitas Publik', '2026-05-13 02:34:24'),
(148, '(Dishub) Bg Adi Hariadi', '0812-5795-2922', 'Bidang Layanan Utilitas Publik', '2026-05-13 02:34:24'),
(149, '(DLH) Bg Fahmi', '0895-2169-6174', 'Bidang Layanan Utilitas Publik', '2026-05-13 02:34:24'),
(150, 'BPKS Bhakti Suci', '(0562) 631514 / 0851-1972-1981', 'Bidang Sosial dan Pemerintahan', '2026-05-13 02:34:24'),
(151, 'BPKS Mandiri', '(0562) 4202 652 / 0821-5853-7255', 'Bidang Sosial dan Pemerintahan', '2026-05-13 02:34:24'),
(152, 'BPKS Tua Pekong', '(0562) 637473', 'Bidang Sosial dan Pemerintahan', '2026-05-13 02:34:24'),
(153, 'BPKS Widya Bhakti', '(0562) 633304', 'Bidang Sosial dan Pemerintahan', '2026-05-13 02:34:24'),
(154, 'BPKS Dwi Tunggal', '0823-5754-8744', 'Bidang Sosial dan Pemerintahan', '2026-05-13 02:34:24'),
(155, 'Sekretariat FKUB', '0896-0251-3011', 'Bidang Sosial dan Pemerintahan', '2026-05-13 02:34:24'),
(156, 'Call Center PLN', '123', 'Call Center', '2026-05-13 02:34:24'),
(157, 'Call Center Dinas Kesehatan', '119', 'Call Center', '2026-05-13 02:34:24'),
(158, 'Call Center Kepolisian Kota Singkawang', '110', 'Call Center', '2026-05-13 02:34:24'),
(159, 'Call Center Indihome', '188', 'Call Center', '2026-05-13 02:34:24'),
(160, 'Call Center Basarnas', '115', 'Call Center', '2026-05-13 02:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `created_at`, `expired_at`) VALUES
(4, 7, '6755c0a0059e7d68d7fbb0e4de361623', '2026-06-12 03:10:08', '2026-06-12 04:10:08'),
(7, 2, '0d373b2e49498d2f96cd10a87ed14e1e', '2026-06-12 03:12:23', '2026-06-12 04:12:23'),
(10, 10, 'adf93fb3182a3e6b0ff3c5720a4f9b5a', '2026-06-12 03:18:26', '2026-06-12 04:18:26'),
(45, 8, 'd337e8918f63d8d286798e6678eb5ca7', '2026-06-12 04:35:32', '2026-06-12 05:35:32'),
(48, 11, 'a9e1ebb892db46dc0e4d5c3d02aef2bd', '2026-06-15 13:22:14', '2026-06-15 14:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `kategori_id` int NOT NULL,
  `judul` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') COLLATE utf8mb4_general_ci DEFAULT 'Menunggu',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama_user` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_terkait` text COLLATE utf8mb4_general_ci,
  `nomor_terkait` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `user_id`, `kategori_id`, `judul`, `pesan`, `foto`, `latitude`, `longitude`, `status`, `created_at`, `nama_user`, `nama_lokasi`, `link_terkait`, `nomor_terkait`) VALUES
(1, 4, 10, 'wifi kantor walkot rusak', 'rusak', 'foto_6a1945ab778e68.92303572.jpeg', '0.818222', '109.48958599999999', 'Selesai', '2026-05-29 07:52:11', 'brigita febriani', 'Bengkayang,  Kalimantan Barat,  Kalimantan,  79211', '', ''),
(2, 4, 7, 'iklan judol', 'judoll', 'foto_6a1988d9a5af15.58308194.jpeg', NULL, NULL, 'Menunggu', '2026-05-29 12:38:49', 'brigita febriani', 'Tidak diketahui', 'https://www.casino.org/video-poker/free/', ''),
(3, 4, 6, 'ppp', 'ppppp', 'foto_6a1e93b2646c12.25614748.jpeg', '0.8920035512541988', '108.96883770692212', 'Menunggu', '2026-06-02 08:26:26', 'brigita febriani', 'Jalan Ahmad Yani,  Singkawang Barat,  Singkawang,  Kalimantan Barat', 'https://www.youtube.com/watch?v=e5t1XD950Us&list=RDe5t1XD950Us&start_radio=1', ''),
(4, 11, 6, 'berita isu demo', 'terdapat isu demo di walikota singkawanga', 'foto_6a3257095a3be7.29426910.jpeg', '0.8919980662767173', '108.96884004677855', 'Menunggu', '2026-06-17 08:12:57', 'flora', 'Jalan Ahmad Yani,  Singkawang Barat,  Singkawang,  Kalimantan Barat', 'https://id.search.yahoo.com/search?fr=mcafee&type=E210ID714G0&p=berita+hoax', ''),
(5, 11, 6, 'berita isu demo', 'terdapat isu demo di walikota singkawanga', NULL, '0.8920000896507525', '108.96884226413692', 'Menunggu', '2026-06-17 08:20:23', 'flora', 'Jalan Ahmad Yani,  Singkawang Barat,  Singkawang,  Kalimantan Barat', 'https://id.search.yahoo.com/search?fr=mcafee&type=E210ID714G0&p=berita+hoax', ''),
(6, 11, 8, 'telpon tidak dikenal', 'saya mendapatkan spam telpon', 'foto_6a3259c220f6c6.87732336.png', NULL, NULL, 'Menunggu', '2026-06-17 08:24:34', 'flora', 'Tidak diketahui', '', '000000000000000000'),
(7, 4, 8, 'spam nomor', 'terdapat spam nomor di hp saya', 'foto_6a33f0a8cf2914.74019136.jpg', NULL, NULL, 'Ditolak', '2026-06-18 13:20:40', 'brigita febriani', 'Tidak diketahui', '', '080808080'),
(8, 12, 6, 'berita hoax  di rs abdul aziz', 'terdapat berita hoaxs di rs abdul aziz', 'foto_6a348eb997e9c0.38226942.jpeg', '0.8952281541244318', '108.97275298833848', 'Menunggu', '2026-06-19 00:35:05', 'jerry', 'RS. Abdul Azis,  Jalan Dokter Sutomo,  Singkawang Barat,  Singkawang', 'https://artikel.rumah123.com/contoh-berita-hoax', ''),
(9, 12, 7, 'situs judiit', 'testt', 'foto_6a34a1890babe0.24726820.jpeg', NULL, NULL, 'Menunggu', '2026-06-19 01:55:21', 'jerry', 'Tidak diketahui', 'https://id.search.yahoo.com/search?fr=mcafee&type=E210ID714G0&p=judol', ''),
(10, 13, 8, 'spam nomor tidak dikenal', 'sudah 10x spam  nomor di hp saya', 'foto_6a34b202330a34.10690392.jpeg', NULL, NULL, 'Diproses', '2026-06-19 03:05:38', 'romy', 'Tidak diketahui', '', '0893742490');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan_admin`
--

CREATE TABLE `tanggapan_admin` (
  `id` int NOT NULL,
  `pengaduan_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `tanggapan` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tanggapan_admin`
--

INSERT INTO `tanggapan_admin` (`id`, `pengaduan_id`, `admin_id`, `tanggapan`, `created_at`) VALUES
(1, 1, 1, 'okeee', '2026-05-29 08:04:02'),
(2, 1, 1, 'okeee', '2026-05-29 08:05:24'),
(3, 2, 1, 'mantappp', '2026-05-30 14:52:50'),
(4, 7, 1, 'iya terimakasihh ya', '2026-06-18 13:21:20'),
(5, 6, 1, 'siapp', '2026-06-18 16:23:41'),
(6, 8, 1, 'oke', '2026-06-19 00:59:02'),
(7, 9, 1, 'sudah', '2026-06-19 01:56:08'),
(8, 10, 1, 'terimakasih segara ditindaklannjuti', '2026-06-19 03:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('aktif','blokir') COLLATE utf8mb4_general_ci DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `no_hp`, `password`, `role`, `created_at`, `status`) VALUES
(1, 'Administrator', 'admin', 'admin_diskominfo@gmail.com', NULL, '0192023a7bbd73250516f069df18b500', 'admin', '2026-05-06 03:10:44', 'aktif'),
(2, 'olin', 'yusta', 'melvincaroline030725@gmail.com', '00', '202cb962ac59075b964b07152d234b70', 'user', '2026-05-06 03:12:43', 'aktif'),
(3, 'vernando', 'nando', 'teo@gmail.com', '', '12', 'user', '2026-05-06 03:16:26', 'aktif'),
(4, 'brigita febriani', 'brigitt', 'gita@gmail.com', '085245774901', '202cb962ac59075b964b07152d234b70', 'user', '2026-05-29 07:40:51', 'aktif'),
(5, 'yusta', 'pepot', 'yusta@gmail.com', '0000000000000000', '202cb962ac59075b964b07152d234b70', 'user', '2026-06-02 12:41:30', 'aktif'),
(6, 'mona', 'monang', 'mona@gmail.com', '0808080808', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2026-06-04 09:50:01', 'aktif'),
(7, 'Teo Vernando Pauyono', 'teoganteng', 'teovernandopauyono02@gmail.com', '089527962794', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2026-06-11 14:25:05', 'aktif'),
(8, 'apin', 'pepin', 'yustamelvincha03@gmail.com', '090090909009', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2026-06-11 14:31:16', 'aktif'),
(9, 'melvin', 'melvinn', 'yusta4024@shantibhuana.ac.id', '00000000000', '202cb962ac59075b964b07152d234b70', 'user', '2026-06-12 03:15:18', 'aktif'),
(10, 'alexsander jerry', 'alek', 'alexander4002@shantibhuana.ac.id', '8058358948', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2026-06-12 03:18:16', 'aktif'),
(11, 'flora', 'flooo', 'flora.bky22@gmail.com', '089673144531', '202cb962ac59075b964b07152d234b70', 'user', '2026-06-15 13:18:48', 'aktif'),
(12, 'jerry', 'jer01', 'jeri@gmail.com', '00000', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2026-06-19 00:28:37', 'aktif'),
(13, 'romy', 'rom', 'romy@gmail.com', '0856793091', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2026-06-19 03:04:14', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_pengaduan`
--
ALTER TABLE `kategori_pengaduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor_darurat`
--
ALTER TABLE `nomor_darurat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `tanggapan_admin`
--
ALTER TABLE `tanggapan_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_id` (`pengaduan_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT for table `kategori_pengaduan`
--
ALTER TABLE `kategori_pengaduan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `nomor_darurat`
--
ALTER TABLE `nomor_darurat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tanggapan_admin`
--
ALTER TABLE `tanggapan_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pengaduan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tanggapan_admin`
--
ALTER TABLE `tanggapan_admin`
  ADD CONSTRAINT `tanggapan_admin_ibfk_1` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tanggapan_admin_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
