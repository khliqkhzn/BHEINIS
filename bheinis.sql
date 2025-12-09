-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bheinis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `totp_secret` varchar(64) NOT NULL,
  `last_otp_verified` datetime DEFAULT NULL,
  `otp_skip_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password_hash`, `totp_secret`, `last_otp_verified`, `otp_skip_until`) VALUES
(1, 'khliqkhzz', '', '6260fc73266fb3b1ba4872dc6a115b942fa7f080', '', NULL, NULL),
(7, 'bheinis', '', '$2y$10$b8wbXkcmJkfEOGSSgNvhl.s8ZXM7VW.15', 'QJHZ6OMUYIM5ZRXK', NULL, NULL),
(11, 'suhainisuliman', 'suhainisuliman.ss@gmail.com', '$2y$10$c69FYd8tE0htQcGc7iMuT.iguqpqrtacYWITi/Ya/gYwJbBMMXrOC', 'D6K4XNJVRKAIAYPX', NULL, '2025-10-24 19:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('open','checkout') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `status`, `created_at`) VALUES
(1, 5, 'open', '2025-06-20 12:37:24'),
(2, 6, 'open', '2025-06-22 12:33:17'),
(3, 7, 'open', '2025-06-22 13:15:37'),
(4, 8, 'open', '2025-08-21 09:02:28'),
(5, 10, '', '2025-08-28 11:48:57'),
(6, 10, '', '2025-10-02 08:34:24'),
(7, 10, '', '2025-10-02 09:32:02'),
(8, 10, '', '2025-10-10 13:56:14'),
(9, 10, '', '2025-10-10 17:24:32'),
(10, 10, '', '2025-10-10 17:32:30'),
(11, 10, '', '2025-10-13 04:45:55'),
(12, 10, '', '2025-10-13 06:04:04'),
(13, 10, '', '2025-10-13 06:08:20'),
(14, 10, '', '2025-10-21 09:04:37'),
(15, 10, '', '2025-10-21 09:55:28'),
(16, 10, '', '2025-10-21 10:01:13'),
(17, 10, '', '2025-10-21 10:07:03'),
(18, 10, '', '2025-10-21 10:24:09'),
(19, 10, '', '2025-10-21 10:32:36'),
(20, 10, '', '2025-10-21 10:37:35'),
(21, 10, '', '2025-10-21 10:45:08'),
(22, 10, '', '2025-10-21 10:49:19'),
(23, 10, '', '2025-10-21 10:55:02'),
(24, 10, '', '2025-10-21 10:57:54'),
(25, 10, '', '2025-10-21 10:59:11'),
(26, 10, '', '2025-10-21 11:00:18'),
(27, 10, '', '2025-10-21 11:07:23'),
(28, 10, '', '2025-10-21 11:08:48'),
(29, 10, '', '2025-10-23 11:53:14'),
(30, 10, '', '2025-10-23 11:55:39'),
(31, 10, '', '2025-10-23 11:58:07'),
(32, 10, '', '2025-10-23 12:10:37'),
(33, 10, '', '2025-10-23 12:26:56'),
(34, 10, '', '2025-10-23 12:53:13'),
(35, 10, '', '2025-10-27 15:08:59'),
(36, 10, '', '2025-10-27 15:12:14'),
(37, 10, '', '2025-10-28 06:52:53'),
(38, 10, '', '2025-10-31 05:37:27'),
(39, 10, '', '2025-10-31 06:12:20'),
(40, 10, '', '2025-10-31 06:15:59'),
(41, 10, '', '2025-11-02 11:37:02'),
(42, 11, '', '2025-11-05 10:22:09'),
(43, 11, '', '2025-11-18 06:18:04'),
(44, 11, '', '2025-11-18 06:23:43'),
(45, 11, '', '2025-11-18 06:49:45'),
(46, 11, '', '2025-11-18 06:57:17'),
(47, 11, '', '2025-11-18 07:02:12'),
(48, 11, '', '2025-11-18 07:11:54'),
(49, 11, '', '2025-11-18 07:15:50'),
(50, 11, '', '2025-11-18 07:22:51'),
(51, 11, '', '2025-11-18 07:27:47'),
(52, 11, '', '2025-11-18 07:30:40'),
(53, 11, '', '2025-11-18 07:40:35'),
(54, 11, '', '2025-11-18 07:45:37'),
(55, 10, 'open', '2025-11-21 07:07:48'),
(56, 11, '', '2025-12-01 17:08:00'),
(57, 12, '', '2025-12-02 16:48:26'),
(58, 12, '', '2025-12-02 16:55:55'),
(59, 12, '', '2025-12-02 18:51:49'),
(60, 11, 'open', '2025-12-03 07:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `size`, `quantity`, `color`) VALUES
(2, 1, 28, NULL, 1, NULL),
(3, 1, 16, NULL, 1, NULL),
(4, 1, 29, NULL, 3, NULL),
(5, 1, 26, NULL, 1, NULL),
(6, 1, 36, NULL, 1, NULL),
(9, 1, 42, 'XS', 1, NULL),
(10, 1, 43, 'L', 1, NULL),
(11, 1, 43, 'XXL', 1, NULL),
(14, 2, 43, 'XS', 2, NULL),
(15, 3, 46, 'XS', 1, NULL),
(16, 1, 46, 'XS', 4, NULL),
(18, 4, 50, 'M', 1, NULL),
(19, 4, 48, '30', 1, NULL),
(20, 4, 47, 'XS', 1, NULL),
(21, 4, 51, 'Free Size', 1, NULL),
(23, 5, 51, 'Free Size', 1, NULL),
(24, 6, 47, 'XS', 1, NULL),
(25, 7, 46, 'XS', 1, NULL),
(26, 7, 47, 'S', 1, NULL),
(27, 7, 48, '8', 1, NULL),
(28, 8, 46, 'XS', 1, NULL),
(29, 8, 46, 'S', 1, NULL),
(30, 9, 50, 'XS', 1, NULL),
(31, 10, 51, 'Free Size', 1, NULL),
(32, 11, 46, 'XS', 1, NULL),
(33, 12, 49, '12', 1, NULL),
(34, 13, 51, 'Free Size', 1, NULL),
(35, 13, 50, 'XS', 1, NULL),
(36, 14, 49, '6', 1, NULL),
(37, 15, 43, 'XS', 1, NULL),
(38, 16, 46, 'XS', 1, NULL),
(39, 17, 51, 'Free Size', 1, NULL),
(40, 18, 46, 'XS', 1, NULL),
(41, 19, 50, 'M', 1, NULL),
(42, 20, 48, '12', 1, NULL),
(43, 21, 46, 'L', 1, NULL),
(44, 22, 45, 'XS', 1, NULL),
(45, 23, 48, '14', 1, NULL),
(46, 24, 47, 'M', 1, NULL),
(47, 25, 48, '30', 1, NULL),
(48, 26, 48, '10', 1, NULL),
(49, 27, 46, 'M', 1, NULL),
(50, 28, 51, 'Free Size', 1, NULL),
(51, 29, 49, '6', 1, NULL),
(52, 30, 45, 'XXL', 1, NULL),
(53, 31, 50, 'M', 1, NULL),
(54, 32, 43, 'XXL', 1, NULL),
(55, 33, 45, 'XS', 1, NULL),
(56, 34, 48, '8', 1, NULL),
(57, 35, 48, '14', 1, NULL),
(58, 36, 48, '14', 1, NULL),
(59, 37, 43, 'M', 1, NULL),
(60, 38, 51, 'Free Size', 1, NULL),
(61, 39, 43, 'L', 1, NULL),
(62, 40, 46, 'S', 1, NULL),
(63, 41, 52, 'Free Size', 1, NULL),
(64, 42, 43, 'XXL', 1, NULL),
(65, 43, 55, 'XS', 1, NULL),
(66, 44, 49, '28', 1, NULL),
(67, 45, 43, 'M', 1, NULL),
(68, 46, 54, 'M', 1, NULL),
(69, 47, 51, 'Free Size', 1, NULL),
(70, 48, 52, 'Free Size', 1, NULL),
(71, 49, 51, 'Free Size', 1, NULL),
(72, 50, 43, 'XXL', 1, NULL),
(73, 51, 49, '6', 1, NULL),
(74, 52, 48, '24', 1, NULL),
(75, 53, 51, 'Free Size', 1, NULL),
(76, 54, 54, 'XS', 1, NULL),
(82, 57, 114, 'Free Size', 1, 'cream'),
(83, 58, 75, 'XS', 1, NULL),
(84, 58, 79, 'XS', 1, NULL),
(85, 59, 78, 'XS', 1, NULL),
(86, 59, 69, 'S', 1, NULL),
(87, 56, 113, 'Free Size', 1, 'redwood'),
(88, 56, 75, 'M', 1, NULL),
(89, 60, 80, 'XS', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`) VALUES
(1, 'Men', '2025-06-02 07:21:58'),
(2, 'Women', '2025-06-02 07:21:58'),
(3, 'Kids', '2025-06-02 07:21:58'),
(4, 'Scarf', '2025-06-02 07:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `category_sizes`
--

CREATE TABLE `category_sizes` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_sizes`
--

INSERT INTO `category_sizes` (`id`, `category_id`, `size_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 2, 1),
(8, 2, 2),
(9, 2, 3),
(10, 2, 4),
(11, 2, 5),
(12, 2, 6),
(13, 3, 8),
(14, 3, 9),
(15, 3, 10),
(16, 3, 11),
(17, 3, 12),
(18, 3, 13),
(19, 3, 14),
(20, 3, 15),
(21, 3, 16),
(22, 3, 17),
(23, 3, 18),
(24, 3, 19),
(25, 3, 20),
(26, 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `customer_activity`
--

CREATE TABLE `customer_activity` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_details` text DEFAULT NULL,
  `activity_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_activity`
--

INSERT INTO `customer_activity` (`activity_id`, `user_id`, `activity_type`, `activity_details`, `activity_time`) VALUES
(470, 11, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-12-01 13:05:34'),
(471, 11, 'View Category', 'Visited Women category page', '2025-12-01 13:05:38'),
(472, 11, 'View Category', 'Visited Women category page', '2025-12-01 13:07:05'),
(473, 11, 'View Category', 'Visited Women category page', '2025-12-01 16:14:13'),
(474, 11, 'View Category', 'Visited Scarf category page', '2025-12-01 17:03:00'),
(475, 11, 'Add to Cart', 'Added product: Bawal Satin (Size: Free Size, Qty: 1, Color: cream)', '2025-12-01 17:08:00'),
(476, 11, 'View Category', 'Visited Women category page', '2025-12-01 17:08:10'),
(477, 11, 'View Category', 'Visited Men category page', '2025-12-01 17:08:21'),
(478, 11, 'View Category', 'Visited Kids category page', '2025-12-01 17:08:24'),
(479, 11, 'View Category', 'Visited Scarf category page', '2025-12-01 17:08:27'),
(480, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:08:53'),
(481, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:09:13'),
(482, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:09:20'),
(483, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:09:25'),
(484, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:09:33'),
(485, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:09:51'),
(486, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:09:56'),
(487, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:10:02'),
(488, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:10:05'),
(489, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:10:09'),
(490, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:10:11'),
(491, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:10:11'),
(492, 11, 'View Category', 'Visited All Products page', '2025-12-01 17:10:16'),
(493, 11, 'View Category', 'Visited Women category page', '2025-12-01 17:10:28'),
(494, 11, 'View Category', 'Visited Scarf category page', '2025-12-01 17:10:41'),
(495, 11, 'View Category', 'Visited Women category page', '2025-12-01 17:10:52'),
(496, 12, 'Login', 'User logged in after OTP verification', '2025-12-02 16:34:11'),
(497, 12, 'View Category', 'Visited Women category page', '2025-12-02 16:42:57'),
(498, 12, 'View Category', 'Visited All Products page', '2025-12-02 16:47:05'),
(499, 12, 'Add to Cart', 'Added product: Bawal Satin (Size: Free Size, Qty: 1, Color: cream)', '2025-12-02 16:48:26'),
(500, 12, 'View Category', 'Visited Women category page', '2025-12-02 16:49:17'),
(501, 12, 'Payment', 'Payment completed using Ewallet (Order ID: 67)', '2025-12-02 16:53:40'),
(502, 12, 'View Category', 'Visited Women category page', '2025-12-02 16:55:52'),
(503, 12, 'Add to Cart', 'Added product: Kurung Ariana (Size: XS, Qty: 1)', '2025-12-02 16:55:55'),
(504, 12, 'View Category', 'Visited Women category page', '2025-12-02 17:30:52'),
(505, 12, 'View Category', 'Visited Men category page', '2025-12-02 17:31:00'),
(506, 12, 'View Category', 'Visited Women category page', '2025-12-02 17:32:11'),
(507, 12, 'Add to Cart', 'Added product: Kurung Alia (Size: XS, Qty: 1)', '2025-12-02 17:32:14'),
(508, 12, 'Payment', 'Payment completed using Card (Order ID: 68)', '2025-12-02 17:32:40'),
(509, 12, 'View Category', 'Visited Men category page', '2025-12-02 18:48:15'),
(510, 12, 'View Category', 'Visited Women category page', '2025-12-02 18:51:46'),
(511, 12, 'Add to Cart', 'Added product: Kurung Alia (Size: XS, Qty: 1)', '2025-12-02 18:51:49'),
(512, 12, 'View Category', 'Visited Men category page', '2025-12-02 18:51:52'),
(513, 12, 'Add to Cart', 'Added product: Kurta Faqih (Size: S, Qty: 1)', '2025-12-02 18:51:54'),
(514, 12, 'Payment', 'Payment completed using Card (Order ID: 69)', '2025-12-02 18:52:09'),
(515, 12, 'Login', 'User logged in after OTP verification', '2025-12-03 03:45:37'),
(516, 12, 'Logout', 'User logged out from the system', '2025-12-03 03:53:00'),
(517, 11, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-12-03 03:53:16'),
(518, 11, 'View Category', 'Visited Scarf category page', '2025-12-03 03:53:22'),
(519, 11, 'Add to Cart', 'Added product: Bawal Satin (Size: Free Size, Qty: 1, Color: redwood)', '2025-12-03 03:53:29'),
(520, 11, 'View Category', 'Visited Women category page', '2025-12-03 03:53:31'),
(521, 11, 'Add to Cart', 'Added product: Kurung Ariana (Size: M, Qty: 1)', '2025-12-03 03:53:33'),
(522, 11, 'Payment', 'Payment completed using Card (Order ID: 70)', '2025-12-03 03:53:46'),
(523, 11, 'Logout', 'User logged out from the system', '2025-12-03 03:55:43'),
(524, 11, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-12-03 07:19:34'),
(525, 11, 'View Category', 'Visited Women category page', '2025-12-03 07:20:06'),
(526, 11, 'View Category', 'Visited Women category page', '2025-12-03 07:20:09'),
(527, 11, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-12-03 07:34:08'),
(528, 11, 'View Category', 'Visited Men category page', '2025-12-03 07:34:10'),
(529, 11, 'View Category', 'Visited Kids category page', '2025-12-03 07:34:11'),
(530, 11, 'View Category', 'Visited Scarf category page', '2025-12-03 07:34:21'),
(531, 11, 'View Category', 'Visited Women category page', '2025-12-03 07:35:44'),
(532, 11, 'Add to Cart', 'Added product: Kurung Alia (Size: XS, Qty: 1)', '2025-12-03 07:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `customer_activity_archive`
--

CREATE TABLE `customer_activity_archive` (
  `activity_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_details` text DEFAULT NULL,
  `activity_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_activity_archive`
--

INSERT INTO `customer_activity_archive` (`activity_id`, `user_id`, `activity_type`, `activity_details`, `activity_time`) VALUES
(73, 10, 'View Category', 'Visited Women category page', '2025-10-10 13:54:29'),
(74, 10, 'View Category', 'Visited Scarf category page', '2025-10-10 13:54:31'),
(75, 10, 'View Category', 'Visited Women category page', '2025-10-10 13:56:11'),
(76, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-10 13:56:14'),
(77, 10, 'View Category', 'Visited Women category page', '2025-10-10 13:57:29'),
(78, 10, 'View Category', 'Visited Women category page', '2025-10-10 16:47:03'),
(79, 10, 'View Category', 'Visited Scarf category page', '2025-10-10 16:47:04'),
(80, 10, 'View Category', 'Visited Women category page', '2025-10-10 17:04:49'),
(81, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: S, Qty: 1)', '2025-10-10 17:04:51'),
(82, 10, 'View Category', 'Visited Mens category page', '2025-10-10 17:24:29'),
(83, 10, 'Add to Cart', 'Added product: Kurta (Size: XS, Qty: 1)', '2025-10-10 17:24:32'),
(84, 10, 'View Category', 'Visited Women category page', '2025-10-10 17:32:21'),
(85, 10, 'View Category', 'Visited Scarf category page', '2025-10-10 17:32:25'),
(86, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-10 17:32:30'),
(87, 10, 'View Category', 'Visited Mens category page', '2025-10-10 17:39:18'),
(88, 10, 'View Category', 'Visited Mens category page', '2025-10-10 17:39:23'),
(89, 10, 'View Category', 'Visited Women category page', '2025-10-13 04:45:52'),
(90, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-13 04:45:55'),
(91, 10, 'View Category', 'Visited Women category page', '2025-10-13 05:46:22'),
(92, 10, 'View Category', 'Visited Mens category page', '2025-10-13 05:46:43'),
(93, 10, 'View Category', 'Visited Kids category page', '2025-10-13 05:46:45'),
(94, 10, 'View Category', 'Visited Scarf category page', '2025-10-13 05:46:47'),
(95, 10, 'View Category', 'Visited Women category page', '2025-10-13 05:46:52'),
(96, 10, 'View Category', 'Visited Kids category page', '2025-10-13 05:46:52'),
(97, 10, 'View Category', 'Visited Women category page', '2025-10-13 05:46:57'),
(98, 10, 'View Category', 'Visited Kids category page', '2025-10-13 06:04:01'),
(99, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 12, Qty: 1)', '2025-10-13 06:04:04'),
(100, 10, 'View Category', 'Visited Women category page', '2025-10-13 06:08:13'),
(101, 10, 'View Category', 'Visited Kids category page', '2025-10-13 06:08:15'),
(102, 10, 'View Category', 'Visited Scarf category page', '2025-10-13 06:08:17'),
(103, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-13 06:08:20'),
(104, 10, 'View Category', 'Visited Mens category page', '2025-10-14 06:52:42'),
(105, 10, 'Add to Cart', 'Added product: Kurta (Size: XS, Qty: 1)', '2025-10-14 06:52:47'),
(106, 10, 'View Category', 'Visited Women category page', '2025-10-14 06:56:07'),
(107, 10, 'View Category', 'Visited Mens category page', '2025-10-14 07:01:49'),
(108, 10, 'View Category', 'Visited Kids category page', '2025-10-14 07:01:56'),
(109, 10, 'View Category', 'Visited Scarf category page', '2025-10-14 07:01:57'),
(110, 10, 'View Category', 'Visited Women category page', '2025-10-14 07:02:01'),
(111, 10, 'View Category', 'Visited Women category page', '2025-10-14 07:02:05'),
(112, 10, 'View Category', 'Visited Women category page', '2025-10-14 07:02:09'),
(113, 10, 'View Category', 'Visited Kids category page', '2025-10-21 09:04:26'),
(114, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 6, Qty: 1)', '2025-10-21 09:04:37'),
(115, 10, 'View Category', 'Visited Mens category page', '2025-10-21 09:55:25'),
(116, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: XS, Qty: 1)', '2025-10-21 09:55:28'),
(117, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:01:09'),
(118, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-21 10:01:13'),
(119, 10, 'View Category', 'Visited Scarf category page', '2025-10-21 10:07:00'),
(120, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-21 10:07:03'),
(121, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:24:06'),
(122, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-21 10:24:09'),
(123, 10, 'View Category', 'Visited Mens category page', '2025-10-21 10:32:33'),
(124, 10, 'Add to Cart', 'Added product: Kurta (Size: M, Qty: 1)', '2025-10-21 10:32:36'),
(125, 10, 'View Category', 'Visited Mens category page', '2025-10-21 10:37:27'),
(126, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:37:32'),
(127, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 12, Qty: 1)', '2025-10-21 10:37:35'),
(128, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:45:06'),
(129, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: L, Qty: 1)', '2025-10-21 10:45:08'),
(130, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:49:16'),
(131, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-21 10:49:19'),
(132, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:54:59'),
(133, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 14, Qty: 1)', '2025-10-21 10:55:02'),
(134, 10, 'View Category', 'Visited Mens category page', '2025-10-21 10:57:46'),
(135, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:57:47'),
(136, 10, 'View Category', 'Visited Scarf category page', '2025-10-21 10:57:48'),
(137, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:57:52'),
(138, 10, 'Add to Cart', 'Added product: Blouse Dahlia (Size: M, Qty: 1)', '2025-10-21 10:57:54'),
(139, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:59:08'),
(140, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 30, Qty: 1)', '2025-10-21 10:59:11'),
(141, 10, 'View Category', 'Visited Kids category page', '2025-10-21 11:00:16'),
(142, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 10, Qty: 1)', '2025-10-21 11:00:18'),
(143, 10, 'View Category', 'Visited Women category page', '2025-10-21 11:07:20'),
(144, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: M, Qty: 1)', '2025-10-21 11:07:23'),
(145, 10, 'View Category', 'Visited Kids category page', '2025-10-21 11:08:43'),
(146, 10, 'View Category', 'Visited Scarf category page', '2025-10-21 11:08:46'),
(147, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-21 11:08:48'),
(148, 10, 'View Category', 'Visited Kids category page', '2025-10-23 11:53:11'),
(149, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 6, Qty: 1)', '2025-10-23 11:53:14'),
(150, 10, 'View Category', 'Visited Scarf category page', '2025-10-23 11:55:28'),
(151, 10, 'View Category', 'Visited Kids category page', '2025-10-23 11:55:32'),
(152, 10, 'View Category', 'Visited Mens category page', '2025-10-23 11:55:35'),
(153, 10, 'View Category', 'Visited Women category page', '2025-10-23 11:55:36'),
(154, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XXL, Qty: 1)', '2025-10-23 11:55:39'),
(155, 10, 'View Category', 'Visited Mens category page', '2025-10-23 11:58:05'),
(156, 10, 'Add to Cart', 'Added product: Kurta (Size: M, Qty: 1)', '2025-10-23 11:58:07'),
(157, 10, 'View Category', 'Visited Mens category page', '2025-10-23 12:10:35'),
(158, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: XXL, Qty: 1)', '2025-10-23 12:10:37'),
(159, 10, 'View Category', 'Visited Scarf category page', '2025-10-23 12:26:51'),
(160, 10, 'View Category', 'Visited Women category page', '2025-10-23 12:26:54'),
(161, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-23 12:26:56'),
(162, 10, 'View Category', 'Visited Kids category page', '2025-10-23 12:53:11'),
(163, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 8, Qty: 1)', '2025-10-23 12:53:13'),
(164, 10, 'View Category', 'Visited Scarf category page', '2025-10-27 15:08:51'),
(165, 10, 'View Category', 'Visited Kids category page', '2025-10-27 15:08:55'),
(166, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 14, Qty: 1)', '2025-10-27 15:08:59'),
(167, 10, 'View Category', 'Visited Kids category page', '2025-10-27 15:12:11'),
(168, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 14, Qty: 1)', '2025-10-27 15:12:14'),
(169, 10, 'View Category', 'Visited Scarf category page', '2025-10-27 15:13:46'),
(170, 10, 'View Category', 'Visited Mens category page', '2025-10-27 15:18:28'),
(171, 10, 'View Category', 'Visited Women category page', '2025-10-27 15:18:30'),
(172, 10, 'View Category', 'Visited Women category page', '2025-10-27 15:19:02'),
(173, 10, 'View Category', 'Visited Mens category page', '2025-10-28 06:52:48'),
(174, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: M, Qty: 1)', '2025-10-28 06:52:53'),
(175, 10, 'View Category', 'Visited Women category page', '2025-10-31 04:17:07'),
(176, 10, 'View Category', 'Visited Mens category page', '2025-10-31 04:17:12'),
(177, 10, 'View Category', 'Visited Kids category page', '2025-10-31 04:17:14'),
(178, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 04:17:15'),
(179, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:33'),
(180, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:48'),
(181, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:54'),
(182, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:57'),
(183, 10, 'Logout', 'User logged out from the system', '2025-10-31 05:35:30'),
(184, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 05:37:24'),
(185, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-31 05:37:27'),
(186, 10, 'View Category', 'Visited Mens category page', '2025-10-31 06:12:17'),
(187, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: L, Qty: 1)', '2025-10-31 06:12:20'),
(188, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 06:15:53'),
(189, 10, 'View Category', 'Visited Women category page', '2025-10-31 06:15:57'),
(190, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: S, Qty: 1)', '2025-10-31 06:15:59'),
(191, 10, 'Payment', 'Payment completed using Card (Order ID: 50)', '2025-10-31 06:16:16'),
(192, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:43:44'),
(193, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:50:20'),
(194, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:58:16'),
(195, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:15:44'),
(196, 10, 'Login', 'User logged in after OTP verification', '2025-10-31 07:16:07'),
(197, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:16:16'),
(198, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-10-31 07:16:23'),
(199, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:16:37'),
(73, 10, 'View Category', 'Visited Women category page', '2025-10-10 13:54:29'),
(74, 10, 'View Category', 'Visited Scarf category page', '2025-10-10 13:54:31'),
(75, 10, 'View Category', 'Visited Women category page', '2025-10-10 13:56:11'),
(76, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-10 13:56:14'),
(77, 10, 'View Category', 'Visited Women category page', '2025-10-10 13:57:29'),
(78, 10, 'View Category', 'Visited Women category page', '2025-10-10 16:47:03'),
(79, 10, 'View Category', 'Visited Scarf category page', '2025-10-10 16:47:04'),
(80, 10, 'View Category', 'Visited Women category page', '2025-10-10 17:04:49'),
(81, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: S, Qty: 1)', '2025-10-10 17:04:51'),
(82, 10, 'View Category', 'Visited Mens category page', '2025-10-10 17:24:29'),
(83, 10, 'Add to Cart', 'Added product: Kurta (Size: XS, Qty: 1)', '2025-10-10 17:24:32'),
(84, 10, 'View Category', 'Visited Women category page', '2025-10-10 17:32:21'),
(85, 10, 'View Category', 'Visited Scarf category page', '2025-10-10 17:32:25'),
(86, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-10 17:32:30'),
(87, 10, 'View Category', 'Visited Mens category page', '2025-10-10 17:39:18'),
(88, 10, 'View Category', 'Visited Mens category page', '2025-10-10 17:39:23'),
(89, 10, 'View Category', 'Visited Women category page', '2025-10-13 04:45:52'),
(90, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-13 04:45:55'),
(91, 10, 'View Category', 'Visited Women category page', '2025-10-13 05:46:22'),
(92, 10, 'View Category', 'Visited Mens category page', '2025-10-13 05:46:43'),
(93, 10, 'View Category', 'Visited Kids category page', '2025-10-13 05:46:45'),
(94, 10, 'View Category', 'Visited Scarf category page', '2025-10-13 05:46:47'),
(95, 10, 'View Category', 'Visited Women category page', '2025-10-13 05:46:52'),
(96, 10, 'View Category', 'Visited Kids category page', '2025-10-13 05:46:52'),
(97, 10, 'View Category', 'Visited Women category page', '2025-10-13 05:46:57'),
(98, 10, 'View Category', 'Visited Kids category page', '2025-10-13 06:04:01'),
(99, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 12, Qty: 1)', '2025-10-13 06:04:04'),
(100, 10, 'View Category', 'Visited Women category page', '2025-10-13 06:08:13'),
(101, 10, 'View Category', 'Visited Kids category page', '2025-10-13 06:08:15'),
(102, 10, 'View Category', 'Visited Scarf category page', '2025-10-13 06:08:17'),
(103, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-13 06:08:20'),
(104, 10, 'View Category', 'Visited Mens category page', '2025-10-14 06:52:42'),
(105, 10, 'Add to Cart', 'Added product: Kurta (Size: XS, Qty: 1)', '2025-10-14 06:52:47'),
(106, 10, 'View Category', 'Visited Women category page', '2025-10-14 06:56:07'),
(107, 10, 'View Category', 'Visited Mens category page', '2025-10-14 07:01:49'),
(108, 10, 'View Category', 'Visited Kids category page', '2025-10-14 07:01:56'),
(109, 10, 'View Category', 'Visited Scarf category page', '2025-10-14 07:01:57'),
(110, 10, 'View Category', 'Visited Women category page', '2025-10-14 07:02:01'),
(111, 10, 'View Category', 'Visited Women category page', '2025-10-14 07:02:05'),
(112, 10, 'View Category', 'Visited Women category page', '2025-10-14 07:02:09'),
(113, 10, 'View Category', 'Visited Kids category page', '2025-10-21 09:04:26'),
(114, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 6, Qty: 1)', '2025-10-21 09:04:37'),
(115, 10, 'View Category', 'Visited Mens category page', '2025-10-21 09:55:25'),
(116, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: XS, Qty: 1)', '2025-10-21 09:55:28'),
(117, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:01:09'),
(118, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-21 10:01:13'),
(119, 10, 'View Category', 'Visited Scarf category page', '2025-10-21 10:07:00'),
(120, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-21 10:07:03'),
(121, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:24:06'),
(122, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-21 10:24:09'),
(123, 10, 'View Category', 'Visited Mens category page', '2025-10-21 10:32:33'),
(124, 10, 'Add to Cart', 'Added product: Kurta (Size: M, Qty: 1)', '2025-10-21 10:32:36'),
(125, 10, 'View Category', 'Visited Mens category page', '2025-10-21 10:37:27'),
(126, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:37:32'),
(127, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 12, Qty: 1)', '2025-10-21 10:37:35'),
(128, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:45:06'),
(129, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: L, Qty: 1)', '2025-10-21 10:45:08'),
(130, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:49:16'),
(131, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-21 10:49:19'),
(132, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:54:59'),
(133, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 14, Qty: 1)', '2025-10-21 10:55:02'),
(134, 10, 'View Category', 'Visited Mens category page', '2025-10-21 10:57:46'),
(135, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:57:47'),
(136, 10, 'View Category', 'Visited Scarf category page', '2025-10-21 10:57:48'),
(137, 10, 'View Category', 'Visited Women category page', '2025-10-21 10:57:52'),
(138, 10, 'Add to Cart', 'Added product: Blouse Dahlia (Size: M, Qty: 1)', '2025-10-21 10:57:54'),
(139, 10, 'View Category', 'Visited Kids category page', '2025-10-21 10:59:08'),
(140, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 30, Qty: 1)', '2025-10-21 10:59:11'),
(141, 10, 'View Category', 'Visited Kids category page', '2025-10-21 11:00:16'),
(142, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 10, Qty: 1)', '2025-10-21 11:00:18'),
(143, 10, 'View Category', 'Visited Women category page', '2025-10-21 11:07:20'),
(144, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: M, Qty: 1)', '2025-10-21 11:07:23'),
(145, 10, 'View Category', 'Visited Kids category page', '2025-10-21 11:08:43'),
(146, 10, 'View Category', 'Visited Scarf category page', '2025-10-21 11:08:46'),
(147, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-21 11:08:48'),
(148, 10, 'View Category', 'Visited Kids category page', '2025-10-23 11:53:11'),
(149, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 6, Qty: 1)', '2025-10-23 11:53:14'),
(150, 10, 'View Category', 'Visited Scarf category page', '2025-10-23 11:55:28'),
(151, 10, 'View Category', 'Visited Kids category page', '2025-10-23 11:55:32'),
(152, 10, 'View Category', 'Visited Mens category page', '2025-10-23 11:55:35'),
(153, 10, 'View Category', 'Visited Women category page', '2025-10-23 11:55:36'),
(154, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XXL, Qty: 1)', '2025-10-23 11:55:39'),
(155, 10, 'View Category', 'Visited Mens category page', '2025-10-23 11:58:05'),
(156, 10, 'Add to Cart', 'Added product: Kurta (Size: M, Qty: 1)', '2025-10-23 11:58:07'),
(157, 10, 'View Category', 'Visited Mens category page', '2025-10-23 12:10:35'),
(158, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: XXL, Qty: 1)', '2025-10-23 12:10:37'),
(159, 10, 'View Category', 'Visited Scarf category page', '2025-10-23 12:26:51'),
(160, 10, 'View Category', 'Visited Women category page', '2025-10-23 12:26:54'),
(161, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: XS, Qty: 1)', '2025-10-23 12:26:56'),
(162, 10, 'View Category', 'Visited Kids category page', '2025-10-23 12:53:11'),
(163, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 8, Qty: 1)', '2025-10-23 12:53:13'),
(164, 10, 'View Category', 'Visited Scarf category page', '2025-10-27 15:08:51'),
(165, 10, 'View Category', 'Visited Kids category page', '2025-10-27 15:08:55'),
(166, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 14, Qty: 1)', '2025-10-27 15:08:59'),
(167, 10, 'View Category', 'Visited Kids category page', '2025-10-27 15:12:11'),
(168, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 14, Qty: 1)', '2025-10-27 15:12:14'),
(169, 10, 'View Category', 'Visited Scarf category page', '2025-10-27 15:13:46'),
(170, 10, 'View Category', 'Visited Mens category page', '2025-10-27 15:18:28'),
(171, 10, 'View Category', 'Visited Women category page', '2025-10-27 15:18:30'),
(172, 10, 'View Category', 'Visited Women category page', '2025-10-27 15:19:02'),
(173, 10, 'View Category', 'Visited Mens category page', '2025-10-28 06:52:48'),
(174, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: M, Qty: 1)', '2025-10-28 06:52:53'),
(0, 10, 'View Category', 'Visited Women category page', '2025-10-31 04:17:07'),
(0, 10, 'View Category', 'Visited Mens category page', '2025-10-31 04:17:12'),
(0, 10, 'View Category', 'Visited Kids category page', '2025-10-31 04:17:14'),
(0, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 04:17:15'),
(0, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:33'),
(0, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:48'),
(0, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:54'),
(0, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:57'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 05:35:30'),
(0, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 05:37:24'),
(0, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-31 05:37:27'),
(0, 10, 'View Category', 'Visited Mens category page', '2025-10-31 06:12:17'),
(0, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: L, Qty: 1)', '2025-10-31 06:12:20'),
(0, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 06:15:53'),
(0, 10, 'View Category', 'Visited Women category page', '2025-10-31 06:15:57'),
(0, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: S, Qty: 1)', '2025-10-31 06:15:59'),
(0, 10, 'Payment', 'Payment completed using Card (Order ID: 50)', '2025-10-31 06:16:16'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:43:44'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:50:20'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:58:16'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:15:44'),
(0, 10, 'Login', 'User logged in after OTP verification', '2025-10-31 07:16:07'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:16:16'),
(0, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-10-31 07:16:23'),
(0, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:16:37'),
(175, 10, 'View Category', 'Visited Women category page', '2025-10-31 04:17:07'),
(176, 10, 'View Category', 'Visited Mens category page', '2025-10-31 04:17:12'),
(177, 10, 'View Category', 'Visited Kids category page', '2025-10-31 04:17:14'),
(178, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 04:17:15'),
(179, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:33'),
(180, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:48'),
(181, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:54'),
(182, 10, 'View Category', 'Visited Women category page', '2025-10-31 05:27:57'),
(183, 10, 'Logout', 'User logged out from the system', '2025-10-31 05:35:30'),
(184, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 05:37:24'),
(185, 10, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-10-31 05:37:27'),
(186, 10, 'View Category', 'Visited Mens category page', '2025-10-31 06:12:17'),
(187, 10, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: L, Qty: 1)', '2025-10-31 06:12:20'),
(188, 10, 'View Category', 'Visited Scarf category page', '2025-10-31 06:15:53'),
(189, 10, 'View Category', 'Visited Women category page', '2025-10-31 06:15:57'),
(190, 10, 'Add to Cart', 'Added product: Baju Kurung (Size: S, Qty: 1)', '2025-10-31 06:15:59'),
(191, 10, 'Payment', 'Payment completed using Card (Order ID: 50)', '2025-10-31 06:16:16'),
(192, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:43:44'),
(193, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:50:20'),
(194, 10, 'Logout', 'User logged out from the system', '2025-10-31 06:58:16'),
(195, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:15:44'),
(196, 10, 'Login', 'User logged in after OTP verification', '2025-10-31 07:16:07'),
(197, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:16:16'),
(198, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-10-31 07:16:23'),
(199, 10, 'Logout', 'User logged out from the system', '2025-10-31 07:16:37'),
(200, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-02 11:36:56'),
(201, 10, 'View Category', 'Visited Scarf category page', '2025-11-02 11:36:58'),
(202, 10, 'Add to Cart', 'Added product: Shawl Ombra (Size: Free Size, Qty: 1)', '2025-11-02 11:37:02'),
(203, 10, 'Payment', 'Payment completed using Card (Order ID: 51)', '2025-11-02 11:37:24'),
(204, 10, 'View Category', 'Visited Women category page', '2025-11-02 11:43:36'),
(205, 10, 'View Category', 'Visited Women category page', '2025-11-02 11:43:52'),
(206, 10, 'View Category', 'Visited Women category page', '2025-11-02 11:53:43'),
(207, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-04 14:07:30'),
(208, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:07:57'),
(209, 10, 'View Category', 'Visited Mens category page', '2025-11-04 14:07:58'),
(210, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:07:58'),
(211, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 14:07:59'),
(212, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:13:11'),
(213, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:13:24'),
(214, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:13:34'),
(215, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:17:42'),
(216, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:23:59'),
(217, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:24:13'),
(218, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:24:16'),
(219, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:28:56'),
(220, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:29:12'),
(221, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:29:22'),
(222, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:29:24'),
(223, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:29:30'),
(224, 10, 'View Category', 'Visited Mens category page', '2025-11-04 14:29:40'),
(225, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:29:45'),
(226, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:31:26'),
(227, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:34:13'),
(228, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:35:12'),
(229, 10, 'View Category', 'Visited Mens category page', '2025-11-04 14:35:21'),
(230, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:35:22'),
(231, 10, 'View Category', 'Visited Mens category page', '2025-11-04 14:35:29'),
(232, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:35:31'),
(233, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:40:32'),
(234, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:40:56'),
(235, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:40:59'),
(236, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:41:03'),
(237, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:41:11'),
(238, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:41:11'),
(239, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:41:15'),
(240, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:41:18'),
(241, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:49:29'),
(242, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:49:30'),
(243, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:49:33'),
(244, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:50:06'),
(245, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:50:07'),
(246, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:50:09'),
(247, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:50:11'),
(248, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:50:14'),
(249, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:50:16'),
(250, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:50:17'),
(251, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:50:18'),
(252, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:50:20'),
(253, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:50:31'),
(254, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:50:33'),
(255, 10, 'View Category', 'Visited Women category page', '2025-11-04 14:54:07'),
(256, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:54:08'),
(257, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 14:54:09'),
(258, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 14:54:51'),
(259, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:55:23'),
(260, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:55:24'),
(261, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 14:55:27'),
(262, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:55:29'),
(263, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 14:55:32'),
(264, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 14:58:26'),
(265, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:58:28'),
(266, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:58:29'),
(267, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:58:31'),
(268, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:58:31'),
(269, 10, 'View Category', 'Visited Men category page', '2025-11-04 14:58:33'),
(270, 10, 'View Category', 'Visited Kids category page', '2025-11-04 14:58:35'),
(271, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:00:41'),
(272, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:00:42'),
(273, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:00:44'),
(274, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:08:28'),
(275, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:12:10'),
(276, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:12:13'),
(277, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:12:15'),
(278, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:12:46'),
(279, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:12:49'),
(280, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:12:50'),
(281, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:12:53'),
(282, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:12:55'),
(283, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:13:49'),
(284, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:13:55'),
(285, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:13:57'),
(286, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:00'),
(287, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:14:01'),
(288, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:02'),
(289, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:14:05'),
(290, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:06'),
(291, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:14:08'),
(292, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:14:09'),
(293, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:14:10'),
(294, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:11'),
(295, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:34'),
(296, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:34'),
(297, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:14:36'),
(298, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:15:09'),
(299, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:15:10'),
(300, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:15:12'),
(301, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:22:05'),
(302, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:22:27'),
(303, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:22:29'),
(304, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:22:38'),
(305, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:22:40'),
(306, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:32:25'),
(307, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:32:26'),
(308, 10, 'View Category', 'Visited Kids category page', '2025-11-04 15:32:26'),
(309, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:32:26'),
(310, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:32:58'),
(311, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:35:00'),
(312, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 15:51:00'),
(313, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:51:04'),
(314, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:51:07'),
(315, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:51:08'),
(316, 10, 'View Category', 'Visited Men category page', '2025-11-04 15:51:09'),
(317, 10, 'View Category', 'Visited Women category page', '2025-11-04 15:51:10'),
(318, 10, 'View Category', 'Visited Men category page', '2025-11-04 16:17:19'),
(319, 10, 'View Category', 'Visited All Products page', '2025-11-04 16:22:24'),
(320, 10, 'View Category', 'Visited All Products page', '2025-11-04 16:25:47'),
(321, 10, 'View Category', 'Visited All Products page', '2025-11-04 16:25:47'),
(322, 10, 'View Category', 'Visited All Products page', '2025-11-04 16:25:48'),
(323, 10, 'View Category', 'Visited Women category page', '2025-11-04 16:25:51'),
(324, 10, 'View Category', 'Visited Women category page', '2025-11-04 16:31:14'),
(325, 10, 'View Category', 'Visited Women category page', '2025-11-04 16:33:43'),
(326, 10, 'View Category', 'Visited All Products page', '2025-11-04 16:33:47'),
(327, 10, 'View Category', 'Visited Women category page', '2025-11-04 16:37:57'),
(328, 10, 'View Category', 'Visited Scarf category page', '2025-11-04 16:54:44'),
(329, 10, 'Logout', 'User logged out from the system', '2025-11-04 16:56:36'),
(330, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-04 16:57:08'),
(331, 10, 'View Category', 'Visited Women category page', '2025-11-04 16:59:21'),
(332, 10, 'Logout', 'User logged out from the system', '2025-11-04 17:08:04'),
(333, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-04 17:08:26'),
(334, 10, 'Logout', 'User logged out from the system', '2025-11-04 17:23:00'),
(335, 11, 'Login', 'User logged in after OTP verification', '2025-11-04 17:27:20'),
(336, 11, 'Logout', 'User logged out from the system', '2025-11-04 17:28:04'),
(337, 11, 'Login', 'User logged in after OTP verification', '2025-11-04 17:37:45'),
(338, 11, 'Logout', 'User logged out from the system', '2025-11-04 17:44:55'),
(339, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-04 17:45:02'),
(340, 10, 'Logout', 'User logged out from the system', '2025-11-04 17:45:06'),
(341, 11, 'Login', 'User logged in after OTP verification', '2025-11-04 17:45:46'),
(342, 11, 'Logout', 'User logged out from the system', '2025-11-04 17:47:05'),
(343, 11, 'Login', 'User logged in after OTP verification', '2025-11-05 10:21:33'),
(344, 11, 'View Category', 'Visited Women category page', '2025-11-05 10:21:38'),
(345, 11, 'View Category', 'Visited Men category page', '2025-11-05 10:21:40'),
(346, 11, 'View Category', 'Visited Kids category page', '2025-11-05 10:21:42'),
(347, 11, 'View Category', 'Visited Scarf category page', '2025-11-05 10:21:43'),
(348, 11, 'View Category', 'Visited Men category page', '2025-11-05 10:22:06'),
(349, 11, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: XXL, Qty: 1)', '2025-11-05 10:22:09'),
(350, 11, 'Payment', 'Payment completed using Card (Order ID: 52)', '2025-11-05 10:23:51'),
(351, 11, 'View Category', 'Visited Scarf category page', '2025-11-05 10:24:02'),
(352, 11, 'Logout', 'User logged out from the system', '2025-11-05 11:13:22'),
(353, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-05 11:13:34'),
(354, 10, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-05 12:25:03'),
(355, 10, 'View Category', 'Visited Women category page', '2025-11-05 12:26:55'),
(356, 10, 'View Category', 'Visited Women category page', '2025-11-05 12:29:19'),
(357, 10, 'View Category', 'Visited All Products page', '2025-11-05 12:29:27'),
(358, 10, 'View Category', 'Visited Men category page', '2025-11-05 12:29:51'),
(359, 10, 'View Category', 'Visited Kids category page', '2025-11-05 12:29:53'),
(360, 10, 'View Category', 'Visited Scarf category page', '2025-11-05 12:29:54'),
(361, 10, 'Logout', 'User logged out from the system', '2025-11-05 12:31:50'),
(362, 11, 'Login', 'User logged in after OTP verification', '2025-11-18 06:17:46'),
(363, 11, 'View Category', 'Visited Women category page', '2025-11-18 06:17:59'),
(364, 11, 'Add to Cart', 'Added product: Kurung Mia (Size: XS, Qty: 1)', '2025-11-18 06:18:04'),
(365, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 53)', '2025-11-18 06:18:18'),
(366, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 54)', '2025-11-18 06:23:13'),
(367, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 55)', '2025-11-18 06:23:30'),
(368, 11, 'View Category', 'Visited Kids category page', '2025-11-18 06:23:39'),
(369, 11, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 28, Qty: 1)', '2025-11-18 06:23:43'),
(370, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 56)', '2025-11-18 06:23:53'),
(371, 11, 'View Category', 'Visited Men category page', '2025-11-18 06:49:41'),
(372, 11, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: M, Qty: 1)', '2025-11-18 06:49:45'),
(373, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 57)', '2025-11-18 06:49:54'),
(374, 11, 'View Category', 'Visited Men category page', '2025-11-18 06:57:11'),
(375, 11, 'View Category', 'Visited Kids category page', '2025-11-18 06:57:14'),
(376, 11, 'View Category', 'Visited Women category page', '2025-11-18 06:57:15'),
(377, 11, 'Add to Cart', 'Added product: Kurung Amelia (Size: M, Qty: 1)', '2025-11-18 06:57:17'),
(378, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 58)', '2025-11-18 06:57:25'),
(379, 11, 'View Category', 'Visited Scarf category page', '2025-11-18 07:02:10'),
(380, 11, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-11-18 07:02:12'),
(381, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 59)', '2025-11-18 07:02:19'),
(382, 11, 'View Category', 'Visited Scarf category page', '2025-11-18 07:11:50'),
(383, 11, 'Add to Cart', 'Added product: Shawl Ombra (Size: Free Size, Qty: 1)', '2025-11-18 07:11:54'),
(384, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 60)', '2025-11-18 07:12:02'),
(385, 11, 'View Category', 'Visited Scarf category page', '2025-11-18 07:15:46'),
(386, 11, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-11-18 07:15:50'),
(387, 11, 'View Category', 'Visited Women category page', '2025-11-18 07:16:59'),
(388, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 61)', '2025-11-18 07:17:14'),
(389, 11, 'View Category', 'Visited Men category page', '2025-11-18 07:22:49'),
(390, 11, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: XXL, Qty: 1)', '2025-11-18 07:22:51'),
(391, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 62)', '2025-11-18 07:23:00'),
(392, 11, 'View Category', 'Visited Kids category page', '2025-11-18 07:27:45'),
(393, 11, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 6, Qty: 1)', '2025-11-18 07:27:47'),
(394, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 63)', '2025-11-18 07:27:54'),
(395, 11, 'View Category', 'Visited Kids category page', '2025-11-18 07:30:38'),
(396, 11, 'Add to Cart', 'Added product: Baju Melayu Cekak Musang (Size: 24, Qty: 1)', '2025-11-18 07:30:40'),
(397, 11, 'Payment', 'Payment completed using Card (Order ID: 64)', '2025-11-18 07:30:59'),
(398, 11, 'View Category', 'Visited Scarf category page', '2025-11-18 07:40:31'),
(399, 11, 'Add to Cart', 'Added product: Bawal  (Size: Free Size, Qty: 1)', '2025-11-18 07:40:35'),
(400, 11, 'Payment', 'Payment completed using Card (Order ID: 65)', '2025-11-18 07:40:53'),
(401, 11, 'View Category', 'Visited Scarf category page', '2025-11-18 07:43:17'),
(402, 11, 'View Category', 'Visited Women category page', '2025-11-18 07:45:34'),
(403, 11, 'Add to Cart', 'Added product: Kurung Amelia (Size: XS, Qty: 1)', '2025-11-18 07:45:37'),
(404, 11, 'Payment', 'Payment completed using Ewallet (Order ID: 66)', '2025-11-18 07:45:45'),
(405, 11, 'Logout', 'User logged out from the system', '2025-11-18 07:46:12'),
(406, 11, 'Login', 'User logged in after OTP verification', '2025-11-18 07:55:45'),
(407, 11, 'Logout', 'User logged out from the system', '2025-11-18 07:55:50'),
(408, 11, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-18 07:56:00'),
(409, 10, 'Login', 'User logged in after OTP verification', '2025-11-21 06:05:08'),
(410, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:05:12'),
(411, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:17:06'),
(412, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:17:10'),
(413, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:17:48'),
(414, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:17:51'),
(415, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:18:23'),
(416, 10, 'View Category', 'Visited Kids category page', '2025-11-21 06:21:46'),
(417, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:21:49'),
(418, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:44:29'),
(419, 10, 'View Category', 'Visited Men category page', '2025-11-21 06:50:35'),
(420, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:50:36'),
(421, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:50:39'),
(422, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:50:43'),
(423, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 06:50:44'),
(424, 10, 'Add to Cart', 'Added product: Shawl Ombra (Size: Free Size, Qty: 1, Color: blue black)', '2025-11-21 07:15:21'),
(425, 10, 'View Category', 'Visited Kids category page', '2025-11-21 07:15:26'),
(426, 10, 'Add to Cart', 'Added product: Baju Melayu Teluk Belanga (Size: 6, Qty: 1)', '2025-11-21 07:15:30'),
(427, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 07:15:38'),
(428, 10, 'Add to Cart', 'Added product: Shawl Ombra (Size: Free Size, Qty: 1, Color: grey)', '2025-11-21 07:15:43'),
(429, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 07:16:23'),
(430, 10, 'View Category', 'Visited Women category page', '2025-11-21 07:22:41'),
(431, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 07:22:44'),
(432, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 07:38:52'),
(433, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 07:55:35'),
(434, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 09:21:45'),
(436, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 09:58:25'),
(437, 10, 'Add to Cart', 'Added product: Shawl Pleated (Size: Free Size, Qty: 1, Color: brownsugar)', '2025-11-21 09:58:42'),
(438, 10, 'View Category', 'Visited Women category page', '2025-11-21 09:58:48'),
(439, 10, 'View Category', 'Visited Women category page', '2025-11-21 10:08:55'),
(440, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:09:00'),
(441, 10, 'View Category', 'Visited Women category page', '2025-11-21 10:09:16'),
(442, 10, 'View Category', 'Visited Men category page', '2025-11-21 10:09:37'),
(443, 10, 'View Category', 'Visited Kids category page', '2025-11-21 10:09:43'),
(444, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:15:26'),
(445, 10, 'View Category', 'Visited Women category page', '2025-11-21 10:31:40'),
(446, 10, 'View Category', 'Visited Men category page', '2025-11-21 10:31:42'),
(447, 10, 'View Category', 'Visited Kids category page', '2025-11-21 10:31:45'),
(448, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:31:47'),
(449, 10, 'View Category', 'Visited Kids category page', '2025-11-21 10:31:56'),
(450, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:31:57'),
(451, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:32:10'),
(452, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:32:26'),
(453, 10, 'View Category', 'Visited Women category page', '2025-11-21 10:32:35'),
(454, 10, 'View Category', 'Visited Men category page', '2025-11-21 10:32:39'),
(455, 10, 'View Category', 'Visited Kids category page', '2025-11-21 10:32:43'),
(456, 10, 'View Category', 'Visited Scarf category page', '2025-11-21 10:32:45'),
(457, 10, 'View Category', 'Visited Kids category page', '2025-11-21 10:32:55'),
(458, 11, 'Login', 'User logged in after OTP verification', '2025-11-26 03:21:26'),
(459, 11, 'Logout', 'User logged out from the system', '2025-11-26 03:21:33'),
(460, 11, 'Login', 'User logged in after OTP verification', '2025-11-26 03:30:21'),
(461, 11, 'Login', 'User logged in using trusted browser (skip OTP)', '2025-11-26 03:46:04'),
(462, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:47:56'),
(463, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:07'),
(464, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:08'),
(465, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:09'),
(466, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:16'),
(467, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:17'),
(468, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:27'),
(469, 11, 'View Category', 'Visited All Products page', '2025-11-26 03:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `feedback_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `product_id`, `user_id`, `rating`, `comment`, `feedback_date`, `admin_reply`) VALUES
(1, 50, 8, 5, 'good product', '2025-08-26 05:55:08', NULL),
(2, 47, 10, 5, 'wowww', '2025-10-02 10:53:28', 'yeayy'),
(3, 79, 12, 5, 'Materials is gooddd! <3', '2025-12-02 16:49:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `email` varchar(255) NOT NULL,
  `attempts` int(11) DEFAULT 0,
  `last_attempt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`email`, `attempts`, `last_attempt`) VALUES
('imnsraa09@gmail.com', 3, '2025-12-03 18:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  `payment_status` enum('Pending','Paid','Failed') NOT NULL DEFAULT 'Paid',
  `shipment_status` enum('Pending','Processing','Shipped') NOT NULL DEFAULT 'Pending',
  `delivery_status` enum('Not Delivered','In Transit','Delivered','Returned') NOT NULL DEFAULT 'Not Delivered',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `order_date`, `status`, `payment_status`, `shipment_status`, `delivery_status`, `total_amount`, `delivery_date`) VALUES
(5, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-09-29 19:59:24', 'Completed', 'Paid', 'Shipped', 'Delivered', 25.00, NULL),
(6, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-09-29 20:01:50', 'Processing', 'Paid', '', '', 25.00, NULL),
(7, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-02 16:38:28', 'Completed', 'Paid', 'Shipped', 'Delivered', 49.00, '2025-11-05'),
(8, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-02 18:26:57', 'Completed', 'Paid', 'Shipped', 'Delivered', 288.00, NULL),
(9, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-11 01:05:16', 'Completed', 'Paid', 'Shipped', 'Delivered', 300.00, NULL),
(10, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-11 01:24:57', 'Processing', 'Paid', '', '', 79.00, NULL),
(11, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-11 01:32:58', 'Processing', 'Paid', '', '', 25.00, NULL),
(12, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-13 12:46:26', 'Processing', 'Paid', '', '', 150.00, NULL),
(13, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-13 14:04:37', 'Processing', 'Paid', '', '', 89.00, NULL),
(14, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-14 14:54:58', 'Processing', 'Paid', '', '', 104.00, NULL),
(15, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 17:27:22', 'Processing', 'Paid', '', '', 89.00, NULL),
(16, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 17:45:00', 'Processing', 'Paid', '', '', 0.00, NULL),
(17, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 17:55:38', 'Processing', 'Paid', '', '', 129.00, NULL),
(18, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:01:23', 'Processing', 'Paid', '', '', 150.00, NULL),
(19, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:07:12', 'Processing', 'Paid', '', '', 25.00, NULL),
(20, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:08:34', 'Processing', 'Paid', '', '', 0.00, NULL),
(21, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:10:00', 'Processing', 'Paid', '', '', 0.00, NULL),
(22, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:11:53', 'Processing', 'Paid', '', '', 0.00, NULL),
(23, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:14:06', 'Processing', 'Paid', '', '', 0.00, NULL),
(24, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:14:11', 'Processing', 'Paid', '', '', 0.00, NULL),
(25, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:24:20', 'Processing', 'Paid', '', '', 150.00, NULL),
(26, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:32:43', 'Processing', 'Paid', '', '', 79.00, NULL),
(27, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:37:43', 'Processing', 'Paid', '', '', 89.00, NULL),
(28, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:45:15', 'Processing', 'Paid', '', '', 150.00, NULL),
(29, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:49:25', 'Processing', 'Paid', '', '', 150.00, NULL),
(30, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:55:09', 'Processing', 'Paid', '', '', 89.00, NULL),
(31, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:58:00', 'Processing', 'Paid', '', '', 49.00, NULL),
(32, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 18:59:17', 'Processing', 'Paid', '', '', 89.00, NULL),
(33, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 19:00:25', 'Processing', 'Paid', '', '', 89.00, NULL),
(34, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 19:07:34', 'Processing', 'Paid', '', '', 150.00, NULL),
(35, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-21 19:08:55', 'Processing', 'Paid', '', '', 25.00, NULL),
(36, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-23 19:53:25', 'Processing', 'Paid', '', '', 89.00, NULL),
(37, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-23 19:56:04', 'Processing', 'Paid', '', '', 150.00, NULL),
(38, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-23 19:58:14', 'Processing', 'Paid', '', '', 79.00, NULL),
(39, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-23 20:10:44', 'Processing', 'Paid', '', '', 129.00, NULL),
(40, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-23 20:27:03', 'Completed', 'Paid', 'Shipped', 'Delivered', 150.00, NULL),
(41, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-23 20:53:21', 'Processing', 'Paid', '', '', 89.00, NULL),
(42, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-27 23:10:58', 'Processing', 'Paid', '', '', 89.00, NULL),
(43, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-27 23:12:22', 'Processing', 'Paid', '', '', 89.00, NULL),
(44, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-28 14:53:16', 'Processing', 'Paid', '', '', 129.00, NULL),
(45, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-31 13:53:36', 'Processing', 'Paid', '', '', 25.00, NULL),
(46, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-31 13:53:39', 'Processing', 'Paid', '', '', 25.00, NULL),
(47, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-31 14:07:07', 'Processing', 'Paid', '', '', 25.00, NULL),
(48, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-31 14:12:00', 'Processing', 'Paid', '', '', 25.00, NULL),
(49, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-31 14:12:35', 'Processing', 'Paid', '', '', 129.00, NULL),
(50, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-10-31 14:16:16', 'Processing', 'Paid', '', '', 150.00, NULL),
(51, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '2025-11-02 19:37:24', 'Processing', 'Paid', '', '', 18.00, NULL),
(52, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-05 18:23:51', 'Completed', 'Paid', 'Shipped', 'Delivered', 129.00, '2025-11-05'),
(53, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 14:18:18', 'Processing', 'Paid', '', '', 299.00, NULL),
(54, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 14:23:13', 'Processing', 'Paid', '', '', 0.00, NULL),
(55, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 14:23:30', 'Processing', 'Paid', '', '', 0.00, NULL),
(56, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 14:23:53', 'Processing', 'Paid', '', '', 89.00, NULL),
(57, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 14:49:54', 'Processing', 'Paid', '', '', 129.00, NULL),
(58, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 14:57:25', 'Processing', 'Paid', '', '', 240.00, NULL),
(59, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:02:19', 'Processing', 'Paid', '', '', 25.00, NULL),
(60, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:12:02', 'Processing', 'Paid', '', '', 18.00, NULL),
(61, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:17:14', 'Processing', 'Paid', '', '', 25.00, NULL),
(62, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:23:00', 'Processing', 'Paid', '', '', 129.00, NULL),
(63, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:27:54', 'Processing', 'Paid', '', '', 89.00, NULL),
(64, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:30:59', 'Processing', 'Paid', '', '', 89.00, NULL),
(65, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:40:53', 'Processing', 'Paid', '', '', 25.00, NULL),
(66, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-11-18 15:45:45', 'Processing', 'Paid', '', '', 240.00, NULL),
(67, 'Iman Maisarah', 'imnsraa09@gmail.com', '2025-12-03 00:53:40', 'Completed', 'Paid', 'Shipped', 'Delivered', 15.00, '2025-12-03'),
(68, 'Iman Maisarah', 'imnsraa09@gmail.com', '2025-12-03 01:32:40', 'Completed', 'Paid', 'Shipped', 'Delivered', 358.00, '2025-12-03'),
(69, 'Iman Maisarah', 'imnsraa09@gmail.com', '2025-12-03 02:52:08', 'Completed', 'Paid', 'Shipped', 'Delivered', 278.00, '2025-12-03'),
(70, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '2025-12-03 11:53:46', 'Completed', 'Paid', 'Shipped', 'Delivered', 174.00, '2025-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(4, 5, 51, 1, 25.00),
(5, 6, 51, 1, 25.00),
(6, 7, 47, 1, 49.00),
(7, 8, 46, 1, 150.00),
(8, 8, 47, 1, 49.00),
(9, 8, 48, 1, 89.00),
(10, 9, 46, 1, 150.00),
(11, 9, 46, 1, 150.00),
(12, 10, 50, 1, 79.00),
(13, 11, 51, 1, 25.00),
(14, 12, 46, 1, 150.00),
(15, 13, 49, 1, 89.00),
(16, 14, 51, 1, 25.00),
(17, 14, 50, 1, 79.00),
(18, 15, 49, 1, 89.00),
(19, 17, 43, 1, 129.00),
(20, 18, 46, 1, 150.00),
(21, 19, 51, 1, 25.00),
(22, 25, 46, 1, 150.00),
(23, 26, 50, 1, 79.00),
(24, 27, 48, 1, 89.00),
(25, 28, 46, 1, 150.00),
(26, 29, 45, 1, 150.00),
(27, 30, 48, 1, 89.00),
(28, 31, 47, 1, 49.00),
(29, 32, 48, 1, 89.00),
(30, 33, 48, 1, 89.00),
(31, 34, 46, 1, 150.00),
(32, 35, 51, 1, 25.00),
(33, 36, 49, 1, 89.00),
(34, 37, 45, 1, 150.00),
(35, 38, 50, 1, 79.00),
(36, 39, 43, 1, 129.00),
(37, 40, 45, 1, 150.00),
(38, 41, 48, 1, 89.00),
(39, 42, 48, 1, 89.00),
(40, 43, 48, 1, 89.00),
(41, 44, 43, 1, 129.00),
(42, 45, 51, 1, 25.00),
(43, 46, 51, 1, 25.00),
(44, 47, 51, 1, 25.00),
(45, 48, 51, 1, 25.00),
(46, 49, 43, 1, 129.00),
(47, 50, 46, 1, 150.00),
(48, 51, 52, 1, 18.00),
(49, 52, 43, 1, 129.00),
(50, 53, 55, 1, 299.00),
(51, 56, 49, 1, 89.00),
(52, 57, 43, 1, 129.00),
(53, 58, 54, 1, 240.00),
(54, 59, 51, 1, 25.00),
(55, 60, 52, 1, 18.00),
(56, 61, 51, 1, 25.00),
(57, 62, 43, 1, 129.00),
(58, 63, 49, 1, 89.00),
(59, 64, 48, 1, 89.00),
(60, 65, 51, 1, 25.00),
(61, 66, 54, 1, 240.00),
(62, 67, 114, 1, 15.00),
(63, 68, 75, 1, 159.00),
(64, 68, 79, 1, 199.00),
(65, 69, 78, 1, 199.00),
(66, 69, 69, 1, 79.00),
(67, 70, 113, 1, 15.00),
(68, 70, 75, 1, 159.00);

-- --------------------------------------------------------

--
-- Table structure for table `otp_skip_settings`
--

CREATE TABLE `otp_skip_settings` (
  `id` int(11) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `skip_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_skip_settings`
--

INSERT INTO `otp_skip_settings` (`id`, `role`, `skip_days`) VALUES
(1, 'admin', 7),
(2, 'user', 30);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Card','Ewallet') NOT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ewallet_type` varchar(50) DEFAULT NULL,
  `ewallet_id` varchar(100) DEFAULT NULL,
  `payment_token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `payment_date`, `ewallet_type`, `ewallet_id`, `payment_token`) VALUES
(6, 6, 10, 25.00, 'Card', 'Pending', NULL, '2025-09-29 12:01:50', NULL, NULL, 'TOKEN6_863409'),
(7, 7, 10, 49.00, 'Card', 'Pending', NULL, '2025-10-02 08:38:28', NULL, NULL, 'TOKEN7_67469'),
(8, 8, 10, 288.00, 'Card', 'Pending', NULL, '2025-10-02 10:26:57', NULL, NULL, 'TOKEN8_747116'),
(9, 9, 10, 300.00, 'Card', 'Pending', NULL, '2025-10-10 17:05:16', NULL, NULL, 'TOKEN9_533176'),
(10, 10, 10, 79.00, 'Card', 'Pending', NULL, '2025-10-10 17:24:57', NULL, NULL, 'TOKEN10_424532'),
(11, 11, 10, 25.00, 'Card', 'Pending', NULL, '2025-10-10 17:32:58', NULL, NULL, 'TOKEN11_523133'),
(12, 12, 10, 150.00, 'Card', 'Pending', NULL, '2025-10-13 04:46:26', NULL, NULL, 'TOKEN12_342068'),
(13, 13, 10, 89.00, 'Card', 'Pending', NULL, '2025-10-13 06:04:37', NULL, NULL, 'TOKEN13_140942'),
(14, 14, 10, 104.00, 'Card', 'Pending', NULL, '2025-10-14 06:54:58', NULL, NULL, 'TOKEN14_678508'),
(15, 15, 10, 89.00, '', 'Pending', NULL, '2025-10-21 09:27:22', 'tng', '0184610552', 'TOKEN15_969713'),
(16, 16, 10, 0.00, '', 'Pending', NULL, '2025-10-21 09:45:00', 'tng', '0184610552', 'TOKEN16_813041'),
(17, 17, 10, 129.00, '', 'Pending', NULL, '2025-10-21 09:55:38', 'tng', '0184610552', 'TOKEN17_156065'),
(18, 18, 10, 150.00, '', 'Pending', NULL, '2025-10-21 10:01:23', 'tng', '0184610552', 'TOKEN18_341204'),
(19, 19, 10, 25.00, '', 'Pending', NULL, '2025-10-21 10:07:12', 'tng', '0184610552', 'TOKEN19_237828'),
(20, 20, 10, 0.00, '', 'Pending', NULL, '2025-10-21 10:08:34', 'tng', '0184610552', 'TOKEN20_165525'),
(21, 21, 10, 0.00, '', 'Pending', NULL, '2025-10-21 10:10:00', 'tng', '0184610552', 'TOKEN21_114144'),
(22, 22, 10, 0.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:11:53', NULL, NULL, 'TOKEN22_74143'),
(23, 23, 10, 0.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:14:06', NULL, NULL, 'TOKEN23_28283'),
(24, 24, 10, 0.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:14:11', NULL, NULL, 'TOKEN24_918988'),
(25, 25, 10, 150.00, '', 'Pending', NULL, '2025-10-21 10:24:20', 'tng', '0184610552', 'TOKEN25_510092'),
(26, 26, 10, 79.00, '', 'Pending', NULL, '2025-10-21 10:32:43', 'tng', '0184610552', 'TOKEN26_793498'),
(27, 27, 10, 89.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:37:43', NULL, NULL, 'TOKEN27_437214'),
(28, 28, 10, 150.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:45:15', NULL, NULL, 'TOKEN28_805574'),
(29, 28, 10, 150.00, '', 'Paid', 'TXN1761043515988', '2025-10-21 10:45:15', 'tng', 'TNG-5988', 'TOKEN29_716231'),
(30, 29, 10, 150.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:49:25', NULL, NULL, 'TOKEN30_164432'),
(31, 29, 10, 150.00, '', 'Paid', 'TXN1761043765939', '2025-10-21 10:49:25', 'tng', 'TNG-5939', 'TOKEN31_673470'),
(32, 30, 10, 89.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:55:09', NULL, NULL, 'TOKEN32_874053'),
(33, 30, 10, 89.00, '', 'Paid', 'TXN1761044109697', '2025-10-21 10:55:09', 'tng', 'TNG-9697', 'TOKEN33_349857'),
(34, 31, 10, 49.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:58:00', NULL, NULL, 'TOKEN34_127125'),
(35, 31, 10, 49.00, '', 'Paid', 'TXN1761044280148', '2025-10-21 10:58:00', 'tng', 'TNG-0148', 'TOKEN35_586057'),
(36, 32, 10, 89.00, 'Ewallet', 'Pending', NULL, '2025-10-21 10:59:17', NULL, NULL, 'TOKEN36_548909'),
(37, 32, 10, 89.00, '', 'Paid', 'TXN1761044357662', '2025-10-21 10:59:17', 'tng', 'TNG-7662', 'TOKEN37_986376'),
(38, 33, 10, 89.00, 'Ewallet', 'Pending', NULL, '2025-10-21 11:00:25', NULL, NULL, 'TOKEN38_285154'),
(39, 33, 10, 89.00, '', 'Paid', 'TXN1761044425161', '2025-10-21 11:00:25', 'grabpay', 'GRABPAY-5161', 'TOKEN39_466642'),
(40, 34, 10, 150.00, 'Ewallet', 'Pending', NULL, '2025-10-21 11:07:34', NULL, NULL, 'TOKEN40_477748'),
(41, 34, 10, 150.00, '', 'Paid', 'TXN1761044854143', '2025-10-21 11:07:34', 'grabpay', 'GRABPAY-4143', 'TOKEN41_988814'),
(42, 35, 10, 25.00, 'Ewallet', 'Pending', NULL, '2025-10-21 11:08:55', NULL, NULL, 'TOKEN42_510827'),
(43, 35, 10, 25.00, '', 'Paid', 'TXN1761044935835', '2025-10-21 11:08:55', 'shopeepay', 'SHOPEEPAY-5835', 'TOKEN43_587693'),
(44, 36, 10, 89.00, 'Ewallet', 'Pending', NULL, '2025-10-23 11:53:25', NULL, NULL, 'TOKEN44_405985'),
(45, 36, 10, 89.00, '', 'Paid', 'TXN1761220405613', '2025-10-23 11:53:25', 'tng', 'TNG-5613', 'TOKEN45_266847'),
(46, 37, 10, 150.00, 'Ewallet', 'Pending', NULL, '2025-10-23 11:56:04', NULL, NULL, 'TOKEN46_116279'),
(47, 37, 10, 150.00, '', 'Paid', 'TXN1761220564615', '2025-10-23 11:56:04', 'shopeepay', 'SHOPEEPAY-4615', 'TOKEN47_780854'),
(48, 38, 10, 79.00, 'Ewallet', 'Pending', NULL, '2025-10-23 11:58:14', NULL, NULL, 'TOKEN48_555436'),
(49, 38, 10, 79.00, '', 'Pending', 'TXN1761220694271', '2025-10-23 11:58:14', 'shopeepay', 'SHOPEEPAY-4271', 'TOKEN49_434618'),
(50, 38, 10, 79.00, '', 'Pending', 'TXN1761220769673', '2025-10-23 11:59:29', 'shopeepay', 'SHOPEEPAY-9673', 'TOKEN50_506784'),
(51, 38, 10, 79.00, '', 'Pending', 'TXN1761221249207', '2025-10-23 12:07:29', 'shopeepay', 'SHOPEEPAY-9207', 'TOKEN51_230064'),
(52, 38, 10, 79.00, '', 'Pending', 'TXN1761221348529', '2025-10-23 12:09:08', 'shopeepay', 'SHOPEEPAY-8529', 'TOKEN52_629967'),
(53, 39, 10, 129.00, 'Ewallet', 'Pending', NULL, '2025-10-23 12:10:44', NULL, NULL, 'TOKEN53_459646'),
(54, 39, 10, 129.00, '', 'Pending', 'TXN1761221444658', '2025-10-23 12:10:44', 'grabpay', 'GRABPAY-4658', 'TOKEN54_408331'),
(55, 39, 10, 129.00, '', 'Pending', 'TXN1761221504569', '2025-10-23 12:11:44', 'grabpay', 'GRABPAY-4569', 'TOKEN55_662716'),
(56, 39, 10, 129.00, '', 'Pending', 'TXN1761221619853', '2025-10-23 12:13:39', 'grabpay', 'GRABPAY-9853', 'TOKEN56_88590'),
(57, 39, 10, 129.00, '', 'Pending', 'TXN1761221674175', '2025-10-23 12:14:34', 'grabpay', 'GRABPAY-4175', 'TOKEN57_454799'),
(58, 39, 10, 129.00, '', 'Pending', 'TXN1761221903173', '2025-10-23 12:18:23', 'grabpay', 'GRABPAY-3173', 'TOKEN58_8227'),
(59, 39, 10, 129.00, '', 'Pending', 'TXN1761221982448', '2025-10-23 12:19:42', 'grabpay', 'GRABPAY-2448', 'TOKEN59_676739'),
(60, 39, 10, 129.00, '', 'Pending', 'TXN1761222072193', '2025-10-23 12:21:12', 'grabpay', 'GRABPAY-2193', 'TOKEN60_359015'),
(61, 39, 10, 129.00, '', 'Pending', 'TXN1761222284248', '2025-10-23 12:24:44', 'grabpay', 'GRABPAY-4248', 'TOKEN61_764859'),
(62, 39, 10, 129.00, '', 'Pending', 'TXN1761222372701', '2025-10-23 12:26:12', 'grabpay', 'GRABPAY-2701', 'TOKEN62_747248'),
(63, 40, 10, 150.00, 'Ewallet', 'Paid', NULL, '2025-10-23 12:27:03', NULL, NULL, 'TOKEN63_441665'),
(64, 40, 10, 150.00, '', 'Paid', 'TXN1761222423751', '2025-10-23 12:27:03', 'shopeepay', 'SHOPEEPAY-3751', 'TOKEN64_966580'),
(65, 40, 10, 150.00, '', 'Paid', 'TXN1761222744314', '2025-10-23 12:32:24', 'shopeepay', 'SHOPEEPAY-4314', 'TOKEN65_507906'),
(66, 40, 10, 150.00, '', 'Paid', 'TXN1761222899517', '2025-10-23 12:34:59', 'shopeepay', 'SHOPEEPAY-9517', 'TOKEN66_639792'),
(67, 40, 10, 150.00, '', 'Paid', 'TXN1761223032657', '2025-10-23 12:37:12', 'shopeepay', 'SHOPEEPAY-2657', 'TOKEN67_675244'),
(68, 40, 10, 150.00, '', 'Paid', 'TXN1761223180285', '2025-10-23 12:39:40', 'shopeepay', 'SHOPEEPAY-0285', 'TOKEN68_456841'),
(69, 40, 10, 150.00, '', 'Paid', 'TXN1761223204720', '2025-10-23 12:40:04', 'shopeepay', 'SHOPEEPAY-4720', 'TOKEN69_258475'),
(70, 40, 10, 150.00, '', 'Paid', 'TXN1761223235170', '2025-10-23 12:40:35', 'shopeepay', 'SHOPEEPAY-5170', 'TOKEN70_921854'),
(71, 40, 10, 150.00, '', 'Paid', 'TXN1761223272783', '2025-10-23 12:41:12', 'shopeepay', 'SHOPEEPAY-2783', 'TOKEN71_833843'),
(72, 40, 10, 150.00, '', 'Paid', 'TXN1761223911633', '2025-10-23 12:51:51', 'shopeepay', 'SHOPEEPAY-1633', 'TOKEN72_403653'),
(73, 41, 10, 89.00, 'Ewallet', 'Paid', NULL, '2025-10-23 12:53:21', NULL, NULL, 'TOKEN73_516736'),
(74, 41, 10, 89.00, '', 'Paid', 'TXN1761224001957', '2025-10-23 12:53:21', 'grabpay', 'GRABPAY-1957', 'TOKEN74_372722'),
(75, 42, 10, 89.00, 'Ewallet', 'Paid', NULL, '2025-10-27 15:10:58', NULL, NULL, 'TOKEN75_313405'),
(76, 42, 10, 89.00, '', 'Paid', 'TXN1761577858682', '2025-10-27 15:10:58', 'grabpay', 'GRABPAY-8682', 'TOKEN76_448856'),
(77, 43, 10, 89.00, 'Ewallet', 'Paid', NULL, '2025-10-27 15:12:22', NULL, NULL, 'TOKEN77_304068'),
(78, 43, 10, 89.00, '', 'Paid', 'TXN1761577942825', '2025-10-27 15:12:22', 'tng', 'TNG-2825', 'TOKEN78_173772'),
(79, 44, 10, 129.00, 'Ewallet', 'Paid', NULL, '2025-10-28 06:53:16', NULL, NULL, 'TOKEN79_956655'),
(80, 44, 10, 129.00, '', 'Paid', 'TXN1761634396345', '2025-10-28 06:53:16', 'tng', 'TNG-6345', 'TOKEN80_261962'),
(81, 45, 10, 25.00, 'Card', 'Pending', NULL, '2025-10-31 05:53:36', NULL, NULL, 'TOKEN81_439842'),
(82, 46, 10, 25.00, 'Card', 'Pending', NULL, '2025-10-31 05:53:39', NULL, NULL, 'TOKEN82_413328'),
(83, 47, 10, 25.00, 'Card', 'Pending', NULL, '2025-10-31 06:07:07', NULL, NULL, 'TOKEN83_747115'),
(84, 48, 10, 25.00, 'Card', 'Pending', NULL, '2025-10-31 06:12:00', NULL, NULL, 'TOKEN84_495590'),
(85, 49, 10, 129.00, 'Card', 'Pending', NULL, '2025-10-31 06:12:35', NULL, NULL, 'TOKEN85_236607'),
(86, 50, 10, 150.00, 'Card', 'Pending', NULL, '2025-10-31 06:16:16', NULL, NULL, 'TOKEN86_696265'),
(87, 51, 10, 18.00, 'Card', 'Pending', NULL, '2025-11-02 11:37:24', NULL, NULL, 'TOKEN87_771506'),
(88, 52, 11, 129.00, 'Card', 'Pending', NULL, '2025-11-05 10:23:51', NULL, NULL, 'TOKEN88_768734'),
(89, 53, 11, 299.00, 'Ewallet', 'Pending', NULL, '2025-11-18 06:18:18', NULL, NULL, 'TOKEN89_529154'),
(90, 53, 11, 299.00, '', 'Pending', 'TXN1763446920623', '2025-11-18 06:22:00', 'tng', 'TNG-0623', 'TOKEN90_339567'),
(91, 54, 11, 0.00, 'Ewallet', 'Pending', NULL, '2025-11-18 06:23:13', NULL, NULL, 'TOKEN91_110374'),
(92, 55, 11, 0.00, 'Ewallet', 'Pending', NULL, '2025-11-18 06:23:30', NULL, NULL, 'TOKEN92_533170'),
(93, 56, 11, 89.00, 'Ewallet', 'Pending', NULL, '2025-11-18 06:23:53', NULL, NULL, 'TOKEN93_334728'),
(94, 56, 11, 89.00, '', 'Pending', 'TXN1763447033952', '2025-11-18 06:23:53', 'tng', 'TNG-3952', 'TOKEN94_74132'),
(95, 56, 11, 89.00, '', 'Pending', 'TXN1763447072987', '2025-11-18 06:24:32', 'tng', 'TNG-2987', 'TOKEN95_366477'),
(96, 57, 11, 129.00, 'Ewallet', 'Pending', NULL, '2025-11-18 06:49:54', NULL, NULL, 'TOKEN96_609988'),
(97, 58, 11, 240.00, 'Ewallet', 'Pending', NULL, '2025-11-18 06:57:25', NULL, NULL, 'TOKEN97_950508'),
(98, 59, 11, 25.00, 'Ewallet', 'Pending', NULL, '2025-11-18 07:02:19', NULL, NULL, 'TOKEN98_880281'),
(99, 60, 11, 18.00, 'Ewallet', 'Pending', NULL, '2025-11-18 07:12:02', NULL, NULL, ''),
(100, 60, 11, 18.00, 'Ewallet', 'Paid', 'TXN1763449922833', '2025-11-18 07:12:08', 'tng', 'TNG-2833', 'a201ef9b8acc15d42558159179d1ad5a'),
(102, 61, 11, 25.00, '', 'Pending', 'TXN1763450234557', '2025-11-18 07:17:14', 'tng', 'TNG-4557', '4f99d81ff10bed58ea0543f36758bb75'),
(103, 61, 11, 25.00, '', 'Paid', 'TXN1763450294577', '2025-11-18 07:18:21', 'tng', 'TNG-4577', 'a7e54c6928baa56fc300162795e980c6'),
(105, 62, 11, 129.00, '', 'Pending', 'TXN17634506491006', '2025-11-18 07:24:09', 'grabpay', 'GRABPAY-1006', '9418ffa4b765e368b62a0f2a8cc4e0d3'),
(106, 62, 11, 129.00, '', 'Paid', 'TXN17634506932717', '2025-11-18 07:24:56', 'grabpay', 'GRABPAY-2717', 'd1d210b594ebcc5ebf2bcbabf2ec3703'),
(108, 63, 11, 89.00, '', 'Paid', 'TXN1763450874167', '2025-11-18 07:28:00', 'tng', 'TNG-4167', 'f7691e838c5b3469f180e50038c59e9c'),
(112, 66, 11, 240.00, '', 'Paid', 'TXN1763451945378', '2025-11-18 07:45:51', 'tng', 'TNG-5378', '21580f0ea36c37af64881c4c9bbcdc2e'),
(114, 67, 12, 15.00, '', 'Paid', 'TXN1764694420464', '2025-12-02 16:55:00', 'tng', 'TNG-0464', '7d46e185102f9079aa330af59e96e167');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `colors` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`, `colors`, `created_at`) VALUES
(43, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 129.00, 36, '7a743c9f-249d-4977-b56f-526dbfed7417.jpg', 1, NULL, '2025-06-22 11:17:24'),
(45, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 34, 'KURUNG 3.jpg', 2, NULL, '2025-06-22 12:38:46'),
(46, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 39, 'KURUNG 1.jpg', 2, NULL, '2025-06-22 12:39:45'),
(47, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 23, 'KURUNG 6.jpg', 2, NULL, '2025-06-23 14:18:04'),
(48, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 31, 'CEKAK 1.jpg', 3, NULL, '2025-06-23 14:20:27'),
(49, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 14, 'CEKAK 3.jpg', 3, NULL, '2025-06-23 14:21:30'),
(50, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 129.00, 21, '0b5ea8d0-e8ce-4ff5-aec9-b4d39cd5397b.jpg', 1, NULL, '2025-06-23 14:23:40'),
(51, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 20, '756f90a3-2f4e-4153-9375-65caa20d6cf8.jpg', 4, '', '2025-06-23 14:26:45'),
(52, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 10, '676f6034-e395-421c-8f61-a5342960eae3.jpg', 4, '', '2025-06-23 14:29:20'),
(54, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 55, 'KURUNG 7.jpg', 2, NULL, '2025-11-04 14:34:09'),
(55, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 36, 'KURUNG 4.jpg', 2, NULL, '2025-11-04 14:35:09'),
(56, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 18, 'KURUNG 5.jpg', 2, NULL, '2025-11-21 04:50:56'),
(57, 'Kurung Mia', 'A timeless traditional outfit that combines elegance and comfort. This Baju Kurung features a classic long top with a matching skirt, perfect for work, events, or festive occasions. Designed with soft fabric and a modest cut for a graceful look.', 150.00, 19, 'KURUNG 2.jpg', 2, NULL, '2025-11-21 04:51:45'),
(58, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 129.00, 18, '10ec4ee1-fdc7-40a1-b6f7-3006511dae80.jpg', 1, NULL, '2025-11-21 04:58:26'),
(59, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 129.00, 20, '87a32cbc-dd34-4deb-9632-74f722d784fc.jpg', 1, NULL, '2025-11-21 04:59:03'),
(60, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 129.00, 17, '89d7486f-0d00-46f2-837a-5a8412944707.jpg', 1, NULL, '2025-11-21 04:59:45'),
(61, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 129.00, 15, '04764355-285e-4611-8e18-6104058213ba.jpg', 1, NULL, '2025-11-21 05:00:16'),
(62, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 18, 'KURTA 1.jpg', 1, NULL, '2025-11-21 05:03:33'),
(63, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 18, 'KURTA 2.jpg', 1, NULL, '2025-11-21 05:04:07'),
(64, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 18, 'KURTA 3.jpg', 1, NULL, '2025-11-21 05:04:44'),
(65, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 20, 'KURTA 5.jpg', 1, NULL, '2025-11-21 05:06:10'),
(66, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 12, 'KURTA 4.jpg', 1, NULL, '2025-11-21 05:06:52'),
(67, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 19, 'KURTA 6.jpg', 1, NULL, '2025-11-21 05:07:29'),
(68, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 15, 'KURTA 7.jpg', 1, NULL, '2025-11-21 05:08:04'),
(69, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 16, 'KURTA 8.jpg', 1, NULL, '2025-11-21 05:08:39'),
(70, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 14, 'KURTA 9.jpg', 1, NULL, '2025-11-21 05:09:25'),
(71, 'Kurta Faqih', 'A simple yet stylish traditional wear for any occasion. Made with comfortable, breathable fabric, this Kurta Faqih offers a modern fit with a neat collar and minimal detailing. Perfect for daily wear, Friday prayers, or festive gatherings.', 79.00, 13, 'KURTA 10.jpg', 1, NULL, '2025-11-21 05:09:59'),
(72, 'Kurung Ariana', 'Kurung Ariana is designed for women who love a soft, graceful look with a touch of modern elegance. Crafted from high-quality satin, the set drapes beautifully and gives a natural, subtle shine that enhances every movement. The top features a comfortable straight-cut design, paired with a matching skirt that flows smoothly for all-day comfort. Lightweight, breathable, and effortlessly classy, Kurung Alia is perfect for formal events, celebrations, or weekend outings.', 159.00, 19, 'ARIANA1.jpg', 2, NULL, '2025-11-21 05:20:27'),
(73, 'Kurung Ariana', 'Kurung Ariana is designed for women who love a soft, graceful look with a touch of modern elegance. Crafted from high-quality satin, the set drapes beautifully and gives a natural, subtle shine that enhances every movement. The top features a comfortable straight-cut design, paired with a matching skirt that flows smoothly for all-day comfort. Lightweight, breathable, and effortlessly classy, Kurung Alia is perfect for formal events, celebrations, or weekend outings.', 159.00, 16, 'ARIANA2.jpg', 2, NULL, '2025-11-21 05:21:11'),
(74, 'Kurung Ariana', 'Kurung Ariana is designed for women who love a soft, graceful look with a touch of modern elegance. Crafted from high-quality satin, the set drapes beautifully and gives a natural, subtle shine that enhances every movement. The top features a comfortable straight-cut design, paired with a matching skirt that flows smoothly for all-day comfort. Lightweight, breathable, and effortlessly classy, Kurung Alia is perfect for formal events, celebrations, or weekend outings.', 159.00, 17, 'ARIANA3.jpg', 2, NULL, '2025-11-21 05:21:46'),
(75, 'Kurung Ariana', 'Kurung Ariana is designed for women who love a soft, graceful look with a touch of modern elegance. Crafted from high-quality satin, the set drapes beautifully and gives a natural, subtle shine that enhances every movement. The top features a comfortable straight-cut design, paired with a matching skirt that flows smoothly for all-day comfort. Lightweight, breathable, and effortlessly classy, Kurung Alia is perfect for formal events, celebrations, or weekend outings.', 159.00, 15, 'ARIANA4.jpg', 2, NULL, '2025-11-21 05:22:22'),
(76, 'Kurung Ariana', 'Kurung Ariana is designed for women who love a soft, graceful look with a touch of modern elegance. Crafted from high-quality satin, the set drapes beautifully and gives a natural, subtle shine that enhances every movement. The top features a comfortable straight-cut design, paired with a matching skirt that flows smoothly for all-day comfort. Lightweight, breathable, and effortlessly classy, Kurung Alia is perfect for formal events, celebrations, or weekend outings.', 159.00, 17, 'ARIANA5.jpg', 2, NULL, '2025-11-21 05:22:58'),
(77, 'Kurung Alia', 'Kurung Alia combines comfort and femininity in one timeless design. Made from soft, breathable cotton, this kurung is perfect for daily wear or special occasions. The highlight of this piece is its delicate lace detailing, adding a touch of elegance without compromising comfort. The top is designed with a relaxed cut for easy movement, while the matching skirt falls nicely to create a flattering silhouette.', 199.00, 16, 'ALIA1.jpg', 2, NULL, '2025-11-21 05:24:19'),
(78, 'Kurung Alia', 'Kurung Alia combines comfort and femininity in one timeless design. Made from soft, breathable cotton, this kurung is perfect for daily wear or special occasions. The highlight of this piece is its delicate lace detailing, adding a touch of elegance without compromising comfort. The top is designed with a relaxed cut for easy movement, while the matching skirt falls nicely to create a flattering silhouette.', 199.00, 17, 'ALIA2.jpg', 2, NULL, '2025-11-21 05:24:55'),
(79, 'Kurung Alia', 'Kurung Alia combines comfort and femininity in one timeless design. Made from soft, breathable cotton, this kurung is perfect for daily wear or special occasions. The highlight of this piece is its delicate lace detailing, adding a touch of elegance without compromising comfort. The top is designed with a relaxed cut for easy movement, while the matching skirt falls nicely to create a flattering silhouette.', 199.00, 15, 'ALIA3.jpg', 2, NULL, '2025-11-21 05:25:35'),
(80, 'Kurung Alia', 'Kurung Alia combines comfort and femininity in one timeless design. Made from soft, breathable cotton, this kurung is perfect for daily wear or special occasions. The highlight of this piece is its delicate lace detailing, adding a touch of elegance without compromising comfort. The top is designed with a relaxed cut for easy movement, while the matching skirt falls nicely to create a flattering silhouette.', 199.00, 15, 'ALIA4.jpg', 2, NULL, '2025-11-21 05:26:05'),
(81, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 31, 'CEKAK 2.jpg', 3, NULL, '2025-11-21 05:35:10'),
(82, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 31, 'CEKAK 4.jpg', 3, NULL, '2025-11-21 05:36:57'),
(83, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 28, 'CEKAK 5.jpg', 3, NULL, '2025-11-21 05:37:45'),
(84, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 28, 'CEKAK 6.jpg', 3, NULL, '2025-11-21 05:38:28'),
(85, 'Baju Melayu Cekak Musang', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 89.00, 26, 'CEKAK 7.jpg', 3, NULL, '2025-11-21 05:39:19'),
(86, 'Baju Melayu Teluk Belanga', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 79.00, 41, 'TELUK 1.jpg', 3, NULL, '2025-11-21 05:40:47'),
(87, 'Baju Melayu Teluk Belanga', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 79.00, 32, 'TELUK 2.jpg', 3, NULL, '2025-11-21 05:41:43'),
(88, 'Baju Melayu Teluk Belanga', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 79.00, 33, 'TELUK 3.jpg', 3, NULL, '2025-11-21 05:42:26'),
(89, 'Baju Melayu Teluk Belanga', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 79.00, 37, 'TELUK 4.jpg', 3, NULL, '2025-11-21 05:43:58'),
(90, 'Baju Melayu Teluk Belanga', 'A classic and timeless traditional wear made for comfort and elegance. This Baju Melayu features a modern cutting with a neat collar and matching pants, perfect for formal events, prayers, or festive celebrations. Easy to wear and suitable for all ages.', 79.00, 24, 'TELUK 5.jpg', 3, NULL, '2025-11-21 05:44:43'),
(91, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 10, 'c1ea3197-3161-4c28-a4bb-585a16811842.jpg', 4, NULL, '2025-11-21 05:49:48'),
(92, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 10, 'c5a7635d-a87f-4b16-8996-3fe706142160.jpg', 4, NULL, '2025-11-21 05:50:18'),
(93, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 10, 'ca420bf8-aef8-4755-9580-383d4b683c05.jpg', 4, NULL, '2025-11-21 05:50:42'),
(94, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 10, 'eacbff9d-3414-49c4-bbe5-9303b78ce26e.jpg', 4, NULL, '2025-11-21 05:51:05'),
(95, 'Bawal Aisyah', 'A must-have for everyday wear. Tudung Bawal Aisyah offers a simple, neat look with easy styling. Made from comfortable, lightweight fabric — perfect for work, classes, or casual outings.', 25.00, 10, 'ef59de36-8b45-46d8-83e8-83d394996cab.jpg', 4, NULL, '2025-11-21 05:51:34'),
(96, 'Shawl Ombra', 'Soft, stylish, and effortless. Shawl Ombra features a beautiful ombre colour effect that adds a unique touch to your daily look. Made from lightweight, breathable fabric — easy to style for both casual and formal occasions.', 18.00, 10, 'Shawl Ombra 1.jpg', 4, 'blue black, grey, grey pekat', '2025-11-21 05:53:46'),
(97, 'Shawl Ombra', 'Soft, stylish, and effortless. Shawl Ombra features a beautiful ombre colour effect that adds a unique touch to your daily look. Made from lightweight, breathable fabric — easy to style for both casual and formal occasions.', 18.00, 18, 'Shawl Ombra 2.jpg', 4, '', '2025-11-21 05:54:33'),
(98, 'Shawl Ombra', 'Soft, stylish, and effortless. Shawl Ombra features a beautiful ombre colour effect that adds a unique touch to your daily look. Made from lightweight, breathable fabric — easy to style for both casual and formal occasions.', 18.00, 20, 'Shawl Ombra 3.jpg', 4, '', '2025-11-21 05:55:00'),
(99, 'Shawl Satin', 'Wrap yourself in the smooth, silky comfort of our Satin Shawl. Made from premium satin, this shawl drapes effortlessly, adding a subtle shine and sophistication to any outfit. Lightweight yet luxurious, it is perfect for both casual wear and formal occasions. Its soft texture ensures all-day comfort, while the sleek finish elevates your look with a touch of elegance.', 15.00, 20, 'SATIN1.jpg', 4, 'black, brown, grey, soft grey, turquoise, soft green, yellow', '2025-11-21 07:35:43'),
(100, 'Shawl Satin', 'Wrap yourself in the smooth, silky comfort of our Satin Shawl. Made from premium satin, this shawl drapes effortlessly, adding a subtle shine and sophistication to any outfit. Lightweight yet luxurious, it is perfect for both casual wear and formal occasions. Its soft texture ensures all-day comfort, while the sleek finish elevates your look with a touch of elegance.', 15.00, 10, 'SATIN2.jpg', 4, 'purple, dusty pink, pinky, off pink, soft blue', '2025-11-21 07:43:44'),
(101, 'Shawl Satin', 'Wrap yourself in the smooth, silky comfort of our Satin Shawl. Made from premium satin, this shawl drapes effortlessly, adding a subtle shine and sophistication to any outfit. Lightweight yet luxurious, it is perfect for both casual wear and formal occasions. Its soft texture ensures all-day comfort, while the sleek finish elevates your look with a touch of elegance.', 15.00, 10, 'SATIN3.jpg', 4, 'mustard, soft mustard, orange, rich brown, dark brown', '2025-11-21 07:45:49'),
(102, 'Shawl Satin', 'Wrap yourself in the smooth, silky comfort of our Satin Shawl. Made from premium satin, this shawl drapes effortlessly, adding a subtle shine and sophistication to any outfit. Lightweight yet luxurious, it is perfect for both casual wear and formal occasions. Its soft texture ensures all-day comfort, while the sleek finish elevates your look with a touch of elegance.', 15.00, 10, 'SATIN4.jpg', 4, 'red, peach, pink, soft pink, cream', '2025-11-21 07:47:16'),
(103, 'Shawl Pleated', 'Elevate your outfit with our Pleated Shawl, designed to combine style and sophistication. Crafted from soft, high-quality fabric, the fine pleats create a graceful texture that drapes beautifully over the shoulders. Lightweight and versatile, this shawl adds a delicate, fashionable touch to both casual and formal ensembles.', 20.00, 10, 'PLEATED1.jpg', 4, 'blueblack, peach, sepia, cinnamon, mustard, brownsugar, clay', '2025-11-21 07:49:22'),
(104, 'Shawl Pleated', 'Elevate your outfit with our Pleated Shawl, designed to combine style and sophistication. Crafted from soft, high-quality fabric, the fine pleats create a graceful texture that drapes beautifully over the shoulders. Lightweight and versatile, this shawl adds a delicate, fashionable touch to both casual and formal ensembles.', 20.00, 10, 'PLEATED2.jpg', 4, 'salmon, crepe, nude, khaki, watermelon, rosewood, rouge, blush', '2025-11-21 07:50:59'),
(105, 'Shawl Pleated', 'Elevate your outfit with our Pleated Shawl, designed to combine style and sophistication. Crafted from soft, high-quality fabric, the fine pleats create a graceful texture that drapes beautifully over the shoulders. Lightweight and versatile, this shawl adds a delicate, fashionable touch to both casual and formal ensembles.', 20.00, 10, 'PLEATED3.jpg', 4, 'coffe, rosy, coral, brownsugar, darkbrown, craft, hibisbus, bubblegum, thulian', '2025-11-21 07:52:44'),
(106, 'Shawl Pleated', 'Elevate your outfit with our Pleated Shawl, designed to combine style and sophistication. Crafted from soft, high-quality fabric, the fine pleats create a graceful texture that drapes beautifully over the shoulders. Lightweight and versatile, this shawl adds a delicate, fashionable touch to both casual and formal ensembles.', 20.00, 10, 'PLEATED4.jpg', 4, 'dijon, flaxen, pine, seaweed, fern, jungle, mint', '2025-11-21 07:54:00'),
(107, 'Shawl Pleated', 'Elevate your outfit with our Pleated Shawl, designed to combine style and sophistication. Crafted from soft, high-quality fabric, the fine pleats create a graceful texture that drapes beautifully over the shoulders. Lightweight and versatile, this shawl adds a delicate, fashionable touch to both casual and formal ensembles.', 20.00, 10, 'PLEATED5.jpg', 4, 'florenine, fossil, heather, thistle, mause', '2025-11-21 07:55:06'),
(108, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE1.jpg', 4, 'salmon, lemonade, crepe, heather, african', '2025-11-21 10:00:37'),
(109, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE2.jpg', 4, 'fiord, steel, denim', '2025-11-21 10:01:42'),
(110, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE3.jpg', 4, 'pigeon, mediumblue, blueblack', '2025-11-21 10:02:47'),
(111, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE4.jpg', 4, 'brown, whisper, chocolate, ash, pecan', '2025-11-21 10:05:07'),
(112, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE5.jpg', 4, 'army, lightgrey, laurel, teal, darkteal, thunder, trout', '2025-11-21 10:06:39'),
(113, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE6.jpg', 4, 'blush, redwood, burgundy, flamingo, peach', '2025-11-21 10:07:44'),
(114, 'Bawal Satin', 'Add a touch of elegance to your look with our Bawal Satin. Made from premium satin, this scarf offers a smooth, silky texture that drapes effortlessly for a sleek, polished appearance. Lightweight and soft, it is comfortable for all-day wear while adding a subtle shimmer to any outfit. Perfect for formal events, casual outings, or festive celebrations, the Bawal Satin is a versatile wardrobe essential.', 15.00, 10, 'MATTE7.jpg', 4, 'cream, black, bone', '2025-11-21 10:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `quantity`) VALUES
(106, 43, 'XS', 6),
(107, 43, 'S', 0),
(108, 43, 'M', 17),
(109, 43, 'L', 8),
(110, 43, 'XL', 0),
(111, 43, 'XXL', 5),
(172, 45, 'XS', 4),
(173, 45, 'S', 6),
(174, 45, 'M', 9),
(175, 45, 'L', 12),
(176, 45, 'XL', 0),
(177, 45, 'XXL', 3),
(238, 47, 'XS', 3),
(239, 47, 'S', 5),
(240, 47, 'M', 6),
(241, 47, 'L', 5),
(242, 47, 'XL', 2),
(243, 47, 'XXL', 2),
(244, 54, 'XS', 10),
(245, 54, 'S', 10),
(246, 54, 'M', 10),
(247, 54, 'L', 10),
(248, 54, 'XL', 10),
(249, 54, 'XXL', 5),
(250, 55, 'XS', 9),
(251, 55, 'S', 7),
(252, 55, 'M', 10),
(253, 55, 'L', 4),
(254, 55, 'XL', 4),
(255, 55, 'XXL', 2),
(256, 56, 'XS', 3),
(257, 56, 'S', 4),
(258, 56, 'M', 4),
(259, 56, 'L', 2),
(260, 56, 'XL', 4),
(261, 56, 'XXL', 1),
(262, 57, 'XS', 3),
(263, 57, 'S', 4),
(264, 57, 'M', 2),
(265, 57, 'L', 3),
(266, 57, 'XL', 4),
(267, 57, 'XXL', 3),
(268, 46, 'XS', 10),
(269, 46, 'S', 7),
(270, 46, 'M', 3),
(271, 46, 'L', 11),
(272, 46, 'XL', 3),
(273, 46, 'XXL', 5),
(286, 50, 'XS', 3),
(287, 50, 'S', 4),
(288, 50, 'M', 3),
(289, 50, 'L', 4),
(290, 50, 'XL', 4),
(291, 50, 'XXL', 3),
(316, 58, 'XS', 3),
(317, 58, 'S', 3),
(318, 58, 'M', 4),
(319, 58, 'L', 4),
(320, 58, 'XL', 3),
(321, 58, 'XXL', 1),
(322, 59, 'XS', 3),
(323, 59, 'S', 3),
(324, 59, 'M', 5),
(325, 59, 'L', 4),
(326, 59, 'XL', 3),
(327, 59, 'XXL', 2),
(328, 60, 'XS', 3),
(329, 60, 'S', 4),
(330, 60, 'M', 4),
(331, 60, 'L', 2),
(332, 60, 'XL', 3),
(333, 60, 'XXL', 1),
(334, 61, 'XS', 2),
(335, 61, 'S', 4),
(336, 61, 'M', 3),
(337, 61, 'L', 3),
(338, 61, 'XL', 2),
(339, 61, 'XXL', 1),
(453, 72, 'XS', 3),
(454, 72, 'S', 3),
(455, 72, 'M', 4),
(456, 72, 'L', 4),
(457, 72, 'XL', 3),
(458, 72, 'XXL', 2),
(459, 73, 'XS', 3),
(460, 73, 'S', 3),
(461, 73, 'M', 3),
(462, 73, 'L', 3),
(463, 73, 'XL', 3),
(464, 73, 'XXL', 1),
(465, 74, 'XS', 3),
(466, 74, 'S', 3),
(467, 74, 'M', 4),
(468, 74, 'L', 2),
(469, 74, 'XL', 2),
(470, 74, 'XXL', 3),
(471, 75, 'XS', 3),
(472, 75, 'S', 3),
(473, 75, 'M', 2),
(474, 75, 'L', 3),
(475, 75, 'XL', 2),
(476, 75, 'XXL', 2),
(477, 76, 'XS', 3),
(478, 76, 'S', 3),
(479, 76, 'M', 4),
(480, 76, 'L', 3),
(481, 76, 'XL', 2),
(482, 76, 'XXL', 2),
(483, 77, 'XS', 2),
(484, 77, 'S', 3),
(485, 77, 'M', 3),
(486, 77, 'L', 3),
(487, 77, 'XL', 3),
(488, 77, 'XXL', 2),
(489, 78, 'XS', 3),
(490, 78, 'S', 3),
(491, 78, 'M', 3),
(492, 78, 'L', 3),
(493, 78, 'XL', 2),
(494, 78, 'XXL', 3),
(495, 79, 'XS', 2),
(496, 79, 'S', 3),
(497, 79, 'M', 2),
(498, 79, 'L', 2),
(499, 79, 'XL', 3),
(500, 79, 'XXL', 3),
(501, 80, 'XS', 3),
(502, 80, 'S', 3),
(503, 80, 'M', 4),
(504, 80, 'L', 2),
(505, 80, 'XL', 2),
(506, 80, 'XXL', 1),
(507, 62, 'XS', 4),
(508, 62, 'S', 3),
(509, 62, 'M', 4),
(510, 62, 'L', 4),
(511, 62, 'XL', 2),
(512, 62, 'XXL', 1),
(513, 63, 'XS', 4),
(514, 63, 'S', 2),
(515, 63, 'M', 3),
(516, 63, 'L', 4),
(517, 63, 'XL', 2),
(518, 63, 'XXL', 3),
(519, 64, 'XS', 3),
(520, 64, 'S', 4),
(521, 64, 'M', 3),
(522, 64, 'L', 2),
(523, 64, 'XL', 5),
(524, 64, 'XXL', 1),
(525, 65, 'XS', 2),
(526, 65, 'S', 3),
(527, 65, 'M', 5),
(528, 65, 'L', 4),
(529, 65, 'XL', 5),
(530, 65, 'XXL', 1),
(531, 66, 'XS', 2),
(532, 66, 'S', 2),
(533, 66, 'M', 3),
(534, 66, 'L', 2),
(535, 66, 'XL', 1),
(536, 66, 'XXL', 2),
(537, 67, 'XS', 2),
(538, 67, 'S', 3),
(539, 67, 'M', 4),
(540, 67, 'L', 5),
(541, 67, 'XL', 3),
(542, 67, 'XXL', 2),
(543, 68, 'XS', 3),
(544, 68, 'S', 2),
(545, 68, 'M', 3),
(546, 68, 'L', 3),
(547, 68, 'XL', 2),
(548, 68, 'XXL', 2),
(549, 69, 'XS', 4),
(550, 69, 'S', 4),
(551, 69, 'M', 3),
(552, 69, 'L', 2),
(553, 69, 'XL', 2),
(554, 69, 'XXL', 1),
(555, 70, 'XS', 3),
(556, 70, 'S', 3),
(557, 70, 'M', 3),
(558, 70, 'L', 3),
(559, 70, 'XL', 2),
(560, 70, 'XXL', 0),
(561, 71, 'XS', 3),
(562, 71, 'S', 3),
(563, 71, 'M', 2),
(564, 71, 'L', 2),
(565, 71, 'XL', 2),
(566, 71, 'XXL', 1),
(567, 48, '6', 3),
(568, 48, '8', 4),
(569, 48, '10', 4),
(570, 48, '12', 4),
(571, 48, '14', 4),
(572, 48, '16', 3),
(573, 48, '18', 0),
(574, 48, '20', 2),
(575, 48, '22', 0),
(576, 48, '24', 1),
(577, 48, '26', 2),
(578, 48, '28', 2),
(579, 48, '30', 2),
(593, 49, '6', 1),
(594, 49, '8', 2),
(595, 49, '10', 0),
(596, 49, '12', 2),
(597, 49, '14', 2),
(598, 49, '16', 0),
(599, 49, '18', 0),
(600, 49, '20', 2),
(601, 49, '22', 2),
(602, 49, '24', 1),
(603, 49, '26', 0),
(604, 49, '28', 2),
(605, 49, '30', 0),
(657, 81, '6', 2),
(658, 81, '8', 2),
(659, 81, '10', 2),
(660, 81, '12', 2),
(661, 81, '14', 2),
(662, 81, '16', 3),
(663, 81, '18', 3),
(664, 81, '20', 3),
(665, 81, '22', 3),
(666, 81, '24', 3),
(667, 81, '26', 2),
(668, 81, '28', 2),
(669, 81, '30', 2),
(670, 82, '6', 2),
(671, 82, '8', 2),
(672, 82, '10', 2),
(673, 82, '12', 2),
(674, 82, '14', 2),
(675, 82, '16', 2),
(676, 82, '18', 3),
(677, 82, '20', 3),
(678, 82, '22', 3),
(679, 82, '24', 3),
(680, 82, '26', 3),
(681, 82, '28', 2),
(682, 82, '30', 2),
(683, 83, '6', 1),
(684, 83, '8', 1),
(685, 83, '10', 2),
(686, 83, '12', 0),
(687, 83, '14', 3),
(688, 83, '16', 3),
(689, 83, '18', 3),
(690, 83, '20', 3),
(691, 83, '22', 3),
(692, 83, '24', 3),
(693, 83, '26', 3),
(694, 83, '28', 2),
(695, 83, '30', 1),
(696, 84, '6', 1),
(697, 84, '8', 2),
(698, 84, '10', 1),
(699, 84, '12', 3),
(700, 84, '14', 1),
(701, 84, '16', 2),
(702, 84, '18', 2),
(703, 84, '20', 2),
(704, 84, '22', 2),
(705, 84, '24', 3),
(706, 84, '26', 3),
(707, 84, '28', 3),
(708, 84, '30', 3),
(709, 85, '6', 2),
(710, 85, '8', 2),
(711, 85, '10', 2),
(712, 85, '12', 2),
(713, 85, '14', 2),
(714, 85, '16', 2),
(715, 85, '18', 2),
(716, 85, '20', 2),
(717, 85, '22', 2),
(718, 85, '24', 2),
(719, 85, '26', 2),
(720, 85, '28', 2),
(721, 85, '30', 2),
(787, 86, '6', 2),
(788, 86, '8', 2),
(789, 86, '10', 3),
(790, 86, '12', 3),
(791, 86, '14', 3),
(792, 86, '16', 3),
(793, 86, '18', 4),
(794, 86, '20', 4),
(795, 86, '22', 4),
(796, 86, '24', 3),
(797, 86, '26', 4),
(798, 86, '28', 4),
(799, 86, '30', 2),
(800, 87, '6', 3),
(801, 87, '8', 3),
(802, 87, '10', 3),
(803, 87, '12', 3),
(804, 87, '14', 3),
(805, 87, '16', 3),
(806, 87, '18', 4),
(807, 87, '20', 3),
(808, 87, '22', 3),
(809, 87, '24', 1),
(810, 87, '26', 1),
(811, 87, '28', 1),
(812, 87, '30', 1),
(813, 88, '6', 2),
(814, 88, '8', 2),
(815, 88, '10', 2),
(816, 88, '12', 2),
(817, 88, '14', 2),
(818, 88, '16', 2),
(819, 88, '18', 3),
(820, 88, '20', 3),
(821, 88, '22', 3),
(822, 88, '24', 3),
(823, 88, '26', 3),
(824, 88, '28', 3),
(825, 88, '30', 3),
(826, 89, '6', 2),
(827, 89, '8', 2),
(828, 89, '10', 2),
(829, 89, '12', 2),
(830, 89, '14', 2),
(831, 89, '16', 2),
(832, 89, '18', 3),
(833, 89, '20', 3),
(834, 89, '22', 4),
(835, 89, '24', 4),
(836, 89, '26', 4),
(837, 89, '28', 3),
(838, 89, '30', 4),
(839, 90, '6', 1),
(840, 90, '8', 1),
(841, 90, '10', 1),
(842, 90, '12', 1),
(843, 90, '14', 1),
(844, 90, '16', 1),
(845, 90, '18', 3),
(846, 90, '20', 3),
(847, 90, '22', 3),
(848, 90, '24', 3),
(849, 90, '26', 2),
(850, 90, '28', 2),
(851, 90, '30', 2),
(859, 91, 'Free Size', 10),
(860, 92, 'Free Size', 10),
(861, 93, 'Free Size', 10),
(862, 94, 'Free Size', 10),
(863, 95, 'Free Size', 10),
(872, 96, 'Free Size', 10),
(873, 97, 'Free Size', 18),
(874, 98, 'Free Size', 20),
(876, 99, 'Free Size', 20),
(879, 100, 'Free Size', 10),
(881, 101, 'Free Size', 10),
(883, 102, 'Free Size', 10),
(885, 103, 'Free Size', 10),
(887, 104, 'Free Size', 10),
(889, 105, 'Free Size', 10),
(891, 106, 'Free Size', 10),
(893, 107, 'Free Size', 10),
(895, 108, 'Free Size', 10),
(897, 109, 'Free Size', 10),
(899, 110, 'Free Size', 10),
(901, 111, 'Free Size', 10),
(903, 112, 'Free Size', 10),
(905, 113, 'Free Size', 10),
(907, 114, 'Free Size', 10),
(909, 51, 'Free Size', 20),
(910, 52, 'Free Size', 10);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `order_id`, `product_id`, `quantity`, `reason`, `image`, `email`, `user_id`, `status`, `request_date`) VALUES
(1, 8, 46, 1, 'Wrong Item', 'uploads/returns/1759400970_Shawl Ombra 1.jpg', 'nrkhaliqkha@gmail.com', 0, 'Pending', '2025-10-02 10:29:30'),
(3, 6, 51, 1, 'Other', 'uploads/returns/1760115669_KURUNG 3.jpg', 'nrkhaliqkha@gmail.com', 0, 'Pending', '2025-10-10 17:01:09'),
(8, 5, 51, 1, 'Damaged', 'uploads/returns/1760116317_BLOUSE AIRA.jpg', 'nrkhaliqkha@gmail.com', 0, 'Approved', '2025-10-10 17:11:57'),
(9, 68, 75, 1, 'Wrong Item', 'uploads/returns/1764701236_BLOUSE AIRA.jpg', 'imnsraa09@gmail.com', 0, 'Pending', '2025-12-02 18:47:16'),
(10, 69, 78, 1, 'Other', 'uploads/returns/1764701568_BLOUSE AIRA.jpg', 'imnsraa09@gmail.com', 0, 'Approved', '2025-12-02 18:52:48'),
(11, 70, 113, 1, 'Wrong Item', 'uploads/returns/1764734103_KURUNG 1.jpg', 'khaliqzaini00@gmail.com', 0, 'Pending', '2025-12-03 03:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`order_id`, `customer_name`, `product_name`, `quantity`, `total_price`, `order_date`) VALUES
(1, 'John Doe', 'Graphic T-shirt', 2, 49.98, '2025-05-06 14:25:00'),
(2, 'Jane Smith', 'Casual T-shirt', 1, 29.99, '2025-05-06 15:45:00'),
(3, 'Alex Brown', 'Hoodie', 3, 89.97, '2025-05-06 16:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL'),
(6, 'XXL'),
(7, 'Free Size'),
(8, '6'),
(9, '8'),
(10, '10'),
(11, '12'),
(12, '14'),
(13, '16'),
(14, '18'),
(15, '20'),
(16, '22'),
(17, '24'),
(18, '26'),
(19, '28'),
(20, '30');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `ticket_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Pending','Resolved') DEFAULT 'Pending',
  `submitted_at` datetime DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trusted_browsers`
--

CREATE TABLE `trusted_browsers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `browser_token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trusted_browsers`
--

INSERT INTO `trusted_browsers` (`id`, `user_id`, `browser_token`, `expires_at`, `created_at`) VALUES
(1, 10, '4da8551ee3d7e48978718b0ebbd74ad84837cb6f2b6216facf327a087aba44e4', '2025-11-11 16:24:46', '2025-10-12 14:24:46'),
(2, 10, '8cda1d72b85f5d84306268f6576511845db7721de60e1952f6886cc952d81aad', '2025-11-11 18:17:57', '2025-10-12 16:17:57'),
(3, 10, 'a152fac5df64e9b3666538acd6c701f3c2f6a9faa49fa48eed8879ac25215414', '2025-11-27 07:51:28', '2025-10-28 06:51:28'),
(4, 10, '78da9ff6a0f9113e5cbfcac5431adefe16c0caaaea2937f86aba541e94eca35a', '2025-11-29 14:00:05', '2025-10-30 13:00:05'),
(5, 11, '2c04972b1529991234394689e190d85e037ddfee26b5b3f26aacfcf231fb7cbb', '2025-11-25 08:55:45', '2025-11-18 07:55:45'),
(6, 11, '725c25fe7c8a19474677f64e3bdd637e564544b748bbefd7274b244de66528bd', '2025-12-26 04:30:21', '2025-11-26 03:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `trusted_browsers_admin`
--

CREATE TABLE `trusted_browsers_admin` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `browser_token` varchar(255) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trusted_browsers_admin`
--

INSERT INTO `trusted_browsers_admin` (`id`, `admin_id`, `browser_token`, `expiry_date`, `created_at`) VALUES
(1, 11, 'b74fecc2978fee1a25650294d501daf39c4f7f03f85d01d5c8c5d3fcc46f46e7', '2025-10-26 18:03:04', '2025-10-12 16:03:04'),
(2, 11, '4bae99b0bedc301804c2820478ab2aec52c1aad14871c4cf1032f1dba7e80abf', '2025-10-26 18:05:37', '2025-10-12 16:05:37'),
(3, 11, '1913dd205c5d6e2676566e375fcf5e92896a7d3d017b3d188acc073b4b2debca', '2025-10-26 18:16:14', '2025-10-12 16:16:14'),
(4, 11, '78419d17757dba50d2a51251a32b629b3ac04dcadacb5267538d862c2324136a', '2025-10-26 18:16:34', '2025-10-12 16:16:34'),
(5, 11, '8a40b432066cea621e7925069126fb17d08285ed6c3e751b7068a91fdfc52d79', '2025-10-27 04:15:46', '2025-10-13 02:15:46'),
(6, 11, 'b64165553e5f6cfebb87d284c434fc624243da2e7d7777094afcf9b0a153c66e', '2025-10-27 04:17:55', '2025-10-13 02:17:55'),
(7, 11, '6f82978f91bc0fc8db3527ec07de002652bfcd2d2f000cd2604b548eb6aba77a', '2025-10-27 04:44:37', '2025-10-13 02:44:37'),
(8, 11, '04f7e52bac1c3d913ec2b92ab68ef9e54bfa1e20dc5f0d713e075b2f6ebd9d4e', '2025-10-27 05:00:05', '2025-10-13 03:00:05'),
(12, 11, '3a7434f33dbf2aa07fdecc4649537b60faf03e7a43c4f4cfc4201068e820cca0', '2025-10-27 07:45:12', '2025-10-13 05:45:12'),
(17, 11, 'bb1ccd55b0fe9dda0efecf3cc3f4d2131a8994d735cbf3657bae456bc242064a', '2025-12-06 13:34:20', '2025-11-29 12:34:20'),
(18, 11, 'ab75ca4a0d036ff72397dd019129f68717d7a802285c1a1160a6170e34ce85a9', '2025-12-06 13:54:15', '2025-11-29 12:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `remember_token` text DEFAULT NULL,
  `totp_secret` varchar(255) DEFAULT NULL,
  `last_otp_verified` datetime DEFAULT NULL,
  `otp_skip_until` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `updated_at`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `remember_token`, `totp_secret`, `last_otp_verified`, `otp_skip_until`, `reset_token`, `reset_expires`, `role`) VALUES
(8, 'Zaini Sairi', 'zainisairi71@gmail.com', NULL, '$2y$10$e3wh27TCJcfnPl0eTMGTnOmKP1TaJiurfV/AZluXtHipV3jTaoKg2', '2025-08-21 09:01:33', '2025-09-23 11:11:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '39b0f20d6e4d900f5fc433fcc351e31ae0937f4ad3eb001887766e67677548e3', '2025-09-23 14:11:38', 'user'),
(10, 'Nur Khaliqkha', 'nrkhaliqkha@gmail.com', '018 461 0552', '$2y$10$2iXCGBp1N9G3HULEfuPkVOxVHUxAV9aQGEuisoDegCCYm8NCvRwCG', '2025-08-28 11:23:19', '2025-10-09 17:22:47', 'No 53, Jalan Puteri 2/4', 'Taman Puteri Wangsa', 'Ulu Tiram', 'Johor', '81800', NULL, 'G32Y2IIHNQXOLH43', NULL, '2025-10-13 11:48:36', 'bf9a68340f9f0e1daf7f76c24663b86346bdfd3284ae91f3ca2eefb3ab47aa88', '2025-10-09 20:22:47', 'user'),
(11, 'Khairina Alisa', 'khaliqzaini00@gmail.com', '0184610552', '$2y$10$Bskq8POIycSTSA5I49Qi9ubsmqcvTyfstjE2qvXvlDSb1tosDmZZC', '2025-11-04 17:25:49', '2025-11-26 03:13:44', 'No 44, Jalan Nenas 26', 'Taman Kota Masai', 'Pasir Gudang', 'Johor', '81700', NULL, 'RRDT4MOS2IYUDWKY', NULL, NULL, NULL, NULL, 'user'),
(12, 'Iman Maisarah', 'imnsraa09@gmail.com', '0183853863', '$2y$10$YX5KOPad2u5Tk4TeRaE9weZVbabCr2QYR1l7uGgDIlp8h20Dvg4sa', '2025-12-02 16:30:21', '2025-12-02 16:44:17', 'No 6 Jalan Melewar 6', 'Taman Melewar', 'Batu Pahat', 'Johor', '86400', NULL, 'TFBDSFWEBMVLFTDU', NULL, NULL, NULL, NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_sizes`
--
ALTER TABLE `category_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `customer_activity`
--
ALTER TABLE `customer_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `otp_skip_settings`
--
ALTER TABLE `otp_skip_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_token` (`payment_token`),
  ADD UNIQUE KEY `payment_token_2` (`payment_token`),
  ADD UNIQUE KEY `payment_token_3` (`payment_token`),
  ADD UNIQUE KEY `payment_token_4` (`payment_token`),
  ADD UNIQUE KEY `payment_token_5` (`payment_token`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `trusted_browsers`
--
ALTER TABLE `trusted_browsers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trusted_browsers_admin`
--
ALTER TABLE `trusted_browsers_admin`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category_sizes`
--
ALTER TABLE `category_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customer_activity`
--
ALTER TABLE `customer_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `otp_skip_settings`
--
ALTER TABLE `otp_skip_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=924;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trusted_browsers`
--
ALTER TABLE `trusted_browsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trusted_browsers_admin`
--
ALTER TABLE `trusted_browsers_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_sizes`
--
ALTER TABLE `category_sizes`
  ADD CONSTRAINT `category_sizes_ibfk_1` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`);

--
-- Constraints for table `customer_activity`
--
ALTER TABLE `customer_activity`
  ADD CONSTRAINT `customer_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `trusted_browsers`
--
ALTER TABLE `trusted_browsers`
  ADD CONSTRAINT `trusted_browsers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
