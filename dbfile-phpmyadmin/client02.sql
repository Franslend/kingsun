-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 04, 2023 at 02:54 AM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `client02`
--

-- --------------------------------------------------------

--
-- Table structure for table `employ`
--

DROP TABLE IF EXISTS `employ`;
CREATE TABLE IF NOT EXISTS `employ` (
  `id` int NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int NOT NULL,
  `supplier` int DEFAULT NULL,
  `product` int DEFAULT NULL,
  `quantity_ordered` int DEFAULT NULL,
  `quantity_received` int DEFAULT NULL,
  `quantity_remaining` int DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `batch` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier` (`supplier`),
  KEY `product` (`product`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `supplier`, `product`, `quantity_ordered`, `quantity_received`, `quantity_remaining`, `status`, `batch`, `created_by`, `created_at`, `updated_at`) VALUES
(0, 5, 11, 20, 20, 0, 'complete', 1689158434, 13, '2023-07-12 12:40:34', '2023-07-12 12:40:34'),
(3, 9, 17, 50, 50, 0, 'complete', 1684052155, 1, '2023-05-14 10:15:55', '2023-05-14 10:15:55'),
(5, 11, 16, 20, 17, 3, 'pending', 1684052228, 1, '2023-05-14 10:17:08', '2023-05-14 10:17:08'),
(8, 9, 17, 5, 4, 1, 'pending', 1684052506, 1, '2023-05-14 10:21:46', '2023-05-14 10:21:46'),
(9, 10, 15, 5, 3, 2, 'incomplete', 1684052506, 1, '2023-05-14 10:21:46', '2023-05-14 10:21:46'),
(10, 11, 16, 5, 5, 0, 'complete', 1684052506, 1, '2023-05-14 10:21:46', '2023-05-14 10:21:46'),
(11, 5, 14, 5, 2, 3, 'incomplete', 1684052541, 1, '2023-05-14 10:22:21', '2023-05-14 10:22:21'),
(12, 5, 11, 2, 2, 0, 'complete', 1684052541, 1, '2023-05-14 10:22:21', '2023-05-14 10:22:21'),
(14, 11, 16, 0, NULL, NULL, 'pending', 1684053651, 1, '2023-05-14 10:40:51', '2023-05-14 10:40:51'),
(15, 5, 14, 0, NULL, NULL, 'pending', 1684053651, 1, '2023-05-14 10:40:51', '2023-05-14 10:40:51'),
(16, 8, 13, 0, NULL, NULL, 'pending', 1684053651, 1, '2023-05-14 10:40:51', '2023-05-14 10:40:51'),
(17, 9, 17, 0, NULL, NULL, 'pending', 1684053651, 1, '2023-05-14 10:40:51', '2023-05-14 10:40:51'),
(18, 9, 17, 30, 26, 4, 'incomplete', 1684053696, 1, '2023-05-14 10:41:36', '2023-05-14 10:41:36'),
(19, 5, 14, 10, 9, 1, 'incomplete', 1684053696, 1, '2023-05-14 10:41:36', '2023-05-14 10:41:36'),
(20, 5, 11, 15, 15, 0, 'complete', 1684053696, 1, '2023-05-14 10:41:36', '2023-05-14 10:41:36'),
(21, 11, 16, 40, 45, -5, 'pending', 1684053696, 1, '2023-05-14 10:41:36', '2023-05-14 10:41:36'),
(22, 8, 13, 30, 30, 0, 'complete', 1684053696, 1, '2023-05-14 10:41:36', '2023-05-14 10:41:36'),
(23, 10, 15, 0, NULL, NULL, 'pending', 1684389919, 13, '2023-05-18 08:05:19', '2023-05-18 08:05:19'),
(24, 11, 16, 0, NULL, NULL, 'pending', 1684389919, 13, '2023-05-18 08:05:19', '2023-05-18 08:05:19'),
(25, 9, 17, 3, 3, 0, 'complete', 1684909416, 13, '2023-05-24 08:23:36', '2023-05-24 08:23:36'),
(28, 9, 17, 12, 12, 0, 'complete', 1688619177, 13, '2023-07-06 06:52:57', '2023-07-06 06:52:57'),
(29, 10, 15, 2, NULL, NULL, 'pending', 1693458237, 22, '2023-08-31 05:03:57', '2023-08-31 05:03:57'),
(30, 5, 11, 1, 1, 0, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(31, 11, 11, 2, 2, 0, 'complete', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(32, 8, 13, 2, 2, 0, 'complete', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(33, 12, 13, 3, 3, 0, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(34, 11, 13, 4, 4, 0, 'complete', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(35, 5, 18, 213, 1, 212, 'pending', 1695616477, 27, '2023-09-25 04:34:38', '2023-09-25 04:34:38'),
(36, 5, 16, 213, NULL, NULL, 'pending', 1695617596, 27, '2023-09-25 04:53:16', '2023-09-25 04:53:16'),
(37, 5, 16, 1, 1, 0, 'complete', 1695786853, 27, '2023-09-27 03:54:13', '2023-09-27 03:54:13'),
(38, 5, 14, 2, 2, 0, 'complete', 1695786853, 27, '2023-09-27 03:54:13', '2023-09-27 03:54:13'),
(39, 11, 14, 3, 1, 2, 'pending', 1695786853, 27, '2023-09-27 03:54:13', '2023-09-27 03:54:13'),
(40, 5, 18, 1, 1, 0, 'pending', 1695787492, 27, '2023-09-27 04:04:52', '2023-09-27 04:04:52'),
(41, 5, 19, 23, NULL, NULL, 'pending', 1695787895, 27, '2023-09-27 04:11:35', '2023-09-27 04:11:35'),
(42, 10, 19, 3, NULL, NULL, 'pending', 1695787895, 27, '2023-09-27 04:11:35', '2023-09-27 04:11:35'),
(43, 11, 19, 41, NULL, NULL, 'pending', 1695787895, 27, '2023-09-27 04:11:35', '2023-09-27 04:11:35'),
(44, 8, 17, 2, 2, 0, 'complete', 1695788745, 27, '2023-09-27 04:25:45', '2023-09-27 04:25:45'),
(45, 9, 17, 3, 3, 0, 'complete', 1695788745, 27, '2023-09-27 04:25:45', '2023-09-27 04:25:45'),
(46, 10, 15, 1, NULL, NULL, 'pending', 1695789994, 27, '2023-09-27 04:46:34', '2023-09-27 04:46:34'),
(47, 11, 15, 2, NULL, NULL, 'pending', 1695789994, 27, '2023-09-27 04:46:34', '2023-09-27 04:46:34'),
(48, 5, 19, 3, NULL, NULL, 'pending', 1695789994, 27, '2023-09-27 04:46:34', '2023-09-27 04:46:34'),
(49, 10, 19, 4, NULL, NULL, 'pending', 1695789994, 27, '2023-09-27 04:46:34', '2023-09-27 04:46:34'),
(50, 11, 19, 5, NULL, NULL, 'pending', 1695789994, 27, '2023-09-27 04:46:34', '2023-09-27 04:46:34'),
(51, 5, 19, 5, NULL, NULL, 'pending', 1695791444, 27, '2023-09-27 05:10:44', '2023-09-27 05:10:44'),
(52, 10, 19, 4, NULL, NULL, 'pending', 1695791444, 27, '2023-09-27 05:10:44', '2023-09-27 05:10:44'),
(53, 11, 19, 3, 3, 0, 'complete', 1695791444, 27, '2023-09-27 05:10:44', '2023-09-27 05:10:44'),
(54, 5, 18, 2, NULL, NULL, 'pending', 1695791444, 27, '2023-09-27 05:10:44', '2023-09-27 05:10:44'),
(55, 10, 15, 2, NULL, NULL, 'pending', 1695791444, 27, '2023-09-27 05:10:44', '2023-09-27 05:10:44'),
(56, 11, 15, 1, NULL, NULL, 'pending', 1695791444, 27, '2023-09-27 05:10:44', '2023-09-27 05:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_product_history`
--

DROP TABLE IF EXISTS `order_product_history`;
CREATE TABLE IF NOT EXISTS `order_product_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_product_id` int NOT NULL,
  `qty_received` int NOT NULL,
  `date_received` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_id` (`order_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product_history`
--

INSERT INTO `order_product_history` (`id`, `order_product_id`, `qty_received`, `date_received`, `date_updated`) VALUES
(1, 0, 20, '2023-07-12 12:50:53', '2023-07-12 12:50:53'),
(6, 1, 20, '2023-05-13 05:49:55', '2023-05-13 05:49:55'),
(7, 17, 1, '2023-05-13 05:50:43', '2023-05-13 05:50:43'),
(8, 1, 20, '2023-05-13 09:21:23', '2023-05-13 09:21:23'),
(9, 1, 300, '2023-05-13 09:22:46', '2023-05-13 09:22:46'),
(10, 5, 32, '2023-05-13 09:23:32', '2023-05-13 09:23:32'),
(11, 6, 10000, '2023-05-13 09:23:32', '2023-05-13 09:23:32'),
(12, 7, 34, '2023-05-13 09:23:32', '2023-05-13 09:23:32'),
(13, 8, 200, '2023-05-13 09:23:32', '2023-05-13 09:23:32'),
(14, 15, 14, '2023-05-13 09:24:01', '2023-05-13 09:24:01'),
(15, 21, 4, '2023-05-14 07:39:47', '2023-05-14 07:39:47'),
(16, 22, 5, '2023-05-14 07:39:47', '2023-05-14 07:39:47'),
(17, 20, 5, '2023-05-14 07:54:36', '2023-05-14 07:54:36'),
(18, 18, 1, '2023-05-14 07:54:36', '2023-05-14 07:54:36'),
(19, 18, 1, '2023-05-14 07:55:42', '2023-05-14 07:55:42'),
(20, 3, 50, '2023-05-14 10:23:24', '2023-05-14 10:23:24'),
(21, 5, 15, '2023-05-14 10:23:34', '2023-05-14 10:23:34'),
(22, 8, 4, '2023-05-14 10:23:56', '2023-05-14 10:23:56'),
(23, 9, 3, '2023-05-14 10:23:56', '2023-05-14 10:23:56'),
(24, 10, 5, '2023-05-14 10:23:56', '2023-05-14 10:23:56'),
(25, 11, 2, '2023-05-14 10:24:14', '2023-05-14 10:24:14'),
(26, 12, 2, '2023-05-14 10:24:14', '2023-05-14 10:24:14'),
(27, 19, 9, '2023-05-14 10:43:46', '2023-05-14 10:43:46'),
(28, 20, 15, '2023-05-14 10:43:46', '2023-05-14 10:43:46'),
(29, 22, 30, '2023-05-14 10:43:46', '2023-05-14 10:43:46'),
(30, 18, 26, '2023-05-14 10:43:46', '2023-05-14 10:43:46'),
(31, 21, 45, '2023-05-14 10:43:46', '2023-05-14 10:43:46'),
(32, 25, 3, '2023-05-24 08:24:29', '2023-05-24 08:24:29'),
(33, 26, 25, '2023-06-08 05:00:45', '2023-06-08 05:00:45'),
(34, 27, 50, '2023-06-12 17:45:45', '2023-06-12 17:45:45'),
(35, 35, 1, '2023-09-28 03:02:36', '2023-09-28 03:02:36'),
(36, 44, 1, '2023-09-28 03:03:59', '2023-09-28 03:03:59'),
(37, 45, 3, '2023-09-28 03:03:59', '2023-09-28 03:03:59'),
(38, 38, 2, '2023-09-28 03:05:36', '2023-09-28 03:05:36'),
(39, 39, 1, '2023-09-28 03:05:36', '2023-09-28 03:05:36'),
(40, 37, 1, '2023-09-28 03:05:36', '2023-09-28 03:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL,
  `item_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stocks` int NOT NULL,
  `price` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int DEFAULT '0',
  `click_notif` int DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `item_code`, `product_name`, `description`, `category`, `img`, `stocks`, `price`, `created_by`, `created_at`, `updated_at`, `status`, `click_notif`, `deleted_at`, `deleted`) VALUES
(11, 'FRN043', 'R22 Freons', ' refregerant R22 30klg											<br />										', 'Freon', 'product-1684124284.jpeg', 5, 600, 1, '2023-05-05 17:24:09', '2023-10-01 07:22:12', 1, 1, '2023-10-01 18:14:54', 1),
(13, '0', 'Silver Rod', '  basta kanni								', 'Others', 'product-1684124176.jpeg', 325, 23, 1, '2023-05-06 20:28:01', '2023-08-31 13:16:10', 0, 0, NULL, 0),
(14, '0', 'Compressor', '  Parts to cool the car																			', 'Compressor', 'product-1686193153.jpg', 5, 32000, 1, '2023-05-14 10:06:32', '2023-05-14 10:06:32', 1, 1, NULL, 0),
(15, '0', 'Refregenrant oil', ' just oil											<br />										', 'Others', 'product-1684124152.jpeg', 10, 320, 1, '2023-05-14 10:12:15', '2023-05-14 10:12:15', 0, 0, NULL, 0),
(16, '0', 'Fiber Glass', ' Para dli mugawas aircons							', 'Others', 'product-1684124142.jpeg', 64, 120, 1, '2023-05-14 10:14:00', '2023-08-31 08:47:16', 0, 0, NULL, 0),
(17, '0', 'Insolatiosn Tubess', 'agianan sa aircon lol										', 'Others', 'product-1693802835.jpeg', 85, 50, 1, '2023-05-14 10:15:23', '2023-09-04 06:47:15', 0, 0, NULL, 0),
(18, 'FRN044s', 'R134A', '13.6 kg', 'Freon', 'product-1693803654.jpg', 14, 6500, 1, '2023-09-04 07:00:54', '2023-09-17 16:11:45', 0, 0, NULL, 0),
(19, '123123WWD', 'R404A', '10.9kg', 'Freon', 'product-1693805847.jpg', 9, 7400, 1, '2023-09-04 07:37:27', '2023-10-01 06:30:32', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `productsuppliers`
--

DROP TABLE IF EXISTS `productsuppliers`;
CREATE TABLE IF NOT EXISTS `productsuppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier` int NOT NULL,
  `product` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `updated_at`, `created_at`) VALUES
(29, 5, 14, '2023-06-08 04:59:13', '2023-06-08 04:59:13'),
(44, 5, 0, '2023-07-12 15:50:37', '2023-07-12 15:50:37'),
(51, 10, 0, '2023-08-31 05:27:18', '2023-08-31 05:27:18'),
(52, 0, 0, '2023-08-31 05:30:14', '2023-08-31 05:30:14'),
(78, 10, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 5, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 8, 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 8, 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 9, 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 11, 13, '2023-09-17 15:55:42', '2023-09-17 15:55:42'),
(106, 11, 14, '2023-09-17 15:55:42', '2023-09-17 15:55:42'),
(107, 11, 15, '2023-09-17 15:55:42', '2023-09-17 15:55:42'),
(112, 5, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 5, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 10, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 11, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 5, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 9, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 11, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_location` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `c_number` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_location`, `email`, `c_number`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(5, 'Nemia', 'Ozamis', 'nemiasing@gmail.com', '', 1, '2023-05-03 21:01:23', '2023-05-03 21:01:23', NULL, 0),
(8, 'Ajax Ent.', 'bukidnon', 'delmonte@gmail.com', '', 13, '2023-05-03 21:04:32', '2023-05-03 21:04:32', NULL, 0),
(9, 'Sulfur corp.', 'Davao', 'sulfur@gmail.com', '', 1, '2023-05-14 10:08:16', '2023-05-14 10:08:16', NULL, 0),
(10, 'Lex Corp.', 'Quezon', 'lex.corp@gmail.com', '', 1, '2023-05-14 10:08:51', '2023-05-14 10:08:51', NULL, 0),
(11, 'Json Ent.', 'Cebu-tad', 'json.ent@gmail.com', '', 1, '2023-05-14 10:10:23', '2023-05-14 10:10:23', NULL, 0),
(12, 'Carrier corp.', 'Iligan City', 'carrier.corp@gmail.com', '123123', 13, '2023-05-19 17:25:18', '2023-05-19 17:25:18', NULL, 0),
(13, 'jose rizal', 'dapitan', '', '', 1, '2023-09-07 05:13:35', '2023-09-07 05:13:35', '2023-10-01 18:00:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

DROP TABLE IF EXISTS `tbl_cart`;
CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `time_order` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_id` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `qty` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(45) COLLATE utf8mb4_general_ci DEFAULT 'rejected',
  `discounted` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_order` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`cart_id`, `time_order`, `product_id`, `qty`, `status`, `discounted`, `date_order`) VALUES
(1, '1695870957', '11', '1', 'rejected', NULL, NULL),
(2, '1695870957', '13', '1', 'rejected', NULL, NULL),
(3, '1695871190', '11', '1', 'rejected', NULL, NULL),
(4, '1695871190', '14', '1', 'rejected', NULL, NULL),
(5, '1695871199', '11', '1', 'completed', NULL, NULL),
(6, '1695871199', '14', '1', 'completed', NULL, NULL),
(7, '1695871428', '11', '1', 'rejected', NULL, NULL),
(8, '1695871428', '13', '1', 'rejected', NULL, NULL),
(9, '1695871428', '14', '1', 'rejected', NULL, NULL),
(10, '1695871478', '11', '1', 'completed', NULL, NULL),
(11, '1695871478', '13', '1', 'completed', NULL, NULL),
(12, '1695872018', '16', '1', 'rejected', NULL, NULL),
(13, '1695872574', '11', '1', 'completed', '2', NULL),
(14, '1695872574', '13', '1', 'completed', '2', NULL),
(15, '1695872574', '14', '1', 'rejected', NULL, NULL),
(16, '1695872935', '11', '1', 'completed', '5', '2023-09-28 03:49:04'),
(17, '1695872935', '13', '1', 'completed', '5', '2023-09-28 03:49:04'),
(18, '1695948687', '11', '1', 'rejected', NULL, NULL),
(19, '1695948687', '14', '1', 'rejected', NULL, NULL),
(20, '1695949862', '11', '1', 'rejected', NULL, NULL),
(21, '1695949862', '13', '1', 'rejected', NULL, NULL),
(22, '1695949952', '11', '1', 'rejected', NULL, NULL),
(23, '1695949973', '11', '1', 'rejected', NULL, NULL),
(24, '1695949973', '13', '1', 'rejected', NULL, NULL),
(25, '1695950324', '11', '1', 'rejected', NULL, NULL),
(26, '1695950438', '11', '1', 'rejected', NULL, NULL),
(27, '1695950589', '11', '1', 'rejected', NULL, NULL),
(28, '1695950589', '13', '1', 'rejected', NULL, NULL),
(29, '1695950589', '14', '1', 'rejected', NULL, NULL),
(30, '1695950589', '19', '1', 'rejected', NULL, NULL),
(31, '1695950589', '18', '1', 'rejected', NULL, NULL),
(32, '1695950589', '15', '1', 'rejected', NULL, NULL),
(33, '1695950609', '11', '1', 'rejected', NULL, NULL),
(34, '1695950858', '11', '3', 'rejected', NULL, NULL),
(35, '1695950858', '13', '4', 'rejected', NULL, NULL),
(36, '1695950930', '11', '4', 'rejected', NULL, NULL),
(37, '1695950945', '11', '2', 'rejected', NULL, NULL),
(38, '1695951023', '11', '5', 'rejected', NULL, NULL),
(39, '1695951080', '13', '3', 'rejected', NULL, NULL),
(40, '1695951116', '11', '1', 'rejected', NULL, NULL),
(41, '1695951116', '13', '1', 'rejected', NULL, NULL),
(43, '1695951616', '11', '1', 'rejected', NULL, NULL),
(44, '1695951616', '13', '1', 'rejected', NULL, NULL),
(45, '1695951616', '14', '1', 'rejected', NULL, NULL),
(46, '1695951616', '15', '1', 'rejected', NULL, NULL),
(47, '1695951669', '11', '1', 'rejected', NULL, NULL),
(48, '1695951669', '13', '1', 'rejected', NULL, NULL),
(49, '1695951669', '14', '1', 'rejected', NULL, NULL),
(50, '1695951669', '18', '1', 'rejected', NULL, NULL),
(51, '1695951669', '19', '1', 'rejected', NULL, NULL),
(52, '1695951669', '17', '1', 'rejected', NULL, NULL),
(53, '1695951692', '11', '1', 'rejected', NULL, NULL),
(54, '1695951706', '11', '1', 'rejected', NULL, NULL),
(55, '1695951706', '13', '1', 'rejected', NULL, NULL),
(56, '1695951706', '14', '1', 'rejected', NULL, NULL),
(57, '1695951706', '15', '1', 'rejected', NULL, NULL),
(58, '1695951706', '18', '1', 'rejected', NULL, NULL),
(67, '1695951846', '11', '1', 'rejected', NULL, NULL),
(68, '1695951846', '13', '1', 'rejected', NULL, NULL),
(69, '1695951846', '14', '1', 'rejected', NULL, NULL),
(70, '1695951846', '15', '1', 'rejected', NULL, NULL),
(71, '1695951846', '16', '1', 'rejected', NULL, NULL),
(72, '1695951888', '11', '1', 'rejected', NULL, NULL),
(74, '1695951888', '14', '1', 'rejected', NULL, NULL),
(75, '1695951888', '15', '1', 'rejected', NULL, NULL),
(76, '1695951888', '16', '1', 'rejected', NULL, NULL),
(77, '1695951888', '17', '1', 'rejected', NULL, NULL),
(78, '1695951888', '18', '1', 'rejected', NULL, NULL),
(79, '1695951888', '19', '1', 'rejected', NULL, NULL),
(80, '1695951932', '11', '1', 'rejected', NULL, NULL),
(81, '1695951932', '13', '1', 'rejected', NULL, NULL),
(82, '1695951932', '14', '1', 'rejected', NULL, NULL),
(83, '1695951932', '15', '1', 'rejected', NULL, NULL),
(84, '1695951988', '11', '1', 'rejected', NULL, NULL),
(85, '1695951988', '13', '1', 'rejected', NULL, NULL),
(86, '1695951988', '14', '1', 'rejected', NULL, NULL),
(87, '1695951988', '15', '1', 'rejected', NULL, NULL),
(88, '1695951988', '19', '1', 'rejected', NULL, NULL),
(89, '1695951988', '18', '1', 'rejected', NULL, NULL),
(90, '1695951988', '17', '1', 'rejected', NULL, NULL),
(92, '1695952032', '11', '1', 'rejected', NULL, NULL),
(93, '1695952214', '11', '1', 'rejected', NULL, NULL),
(94, '1695952254', '14', '1', 'rejected', NULL, NULL),
(95, '1695952262', '11', '1', 'rejected', NULL, NULL),
(96, '1695952284', '11', '1', 'rejected', NULL, NULL),
(97, '1695952316', '11', '1', 'rejected', NULL, NULL),
(98, '1695952429', '13', '1', 'rejected', NULL, NULL),
(99, '1695952441', '13', '1', 'rejected', NULL, NULL),
(100, '1695952483', '11', '1', 'rejected', NULL, NULL),
(101, '1695952528', '11', '1', 'rejected', NULL, NULL),
(102, '1695952548', '11', '1', 'rejected', NULL, NULL),
(103, '1695952618', '13', '1', 'rejected', NULL, NULL),
(104, '1695952639', '11', '1', 'rejected', NULL, NULL),
(105, '1695952655', '11', '1', 'completed', '', '2023-09-29 01:57:47'),
(106, '1695952684', '11', '1', 'rejected', NULL, NULL),
(107, '1695952768', '13', '1', 'completed', '', '2023-09-29 01:59:33'),
(108, '1695952847', '11', '1', 'completed', '', '2023-09-29 02:00:59'),
(109, '1695952847', '13', '1', 'completed', '', '2023-09-29 02:00:59'),
(110, '1695952921', '11', '1', 'completed', '', '2023-09-29 02:02:04'),
(111, '1695952977', '11', '1', 'completed', '', '2023-09-29 02:03:00'),
(112, '1695952996', '11', '1', 'completed', '', '2023-09-29 02:03:19'),
(113, '1695952996', '13', '1', 'rejected', NULL, NULL),
(114, '1695953032', '11', '1', 'rejected', NULL, NULL),
(115, '1695953032', '13', '1', 'rejected', NULL, NULL),
(116, '1695953188', '13', '1', 'rejected', NULL, NULL),
(117, '1695953233', '11', '1', 'rejected', NULL, NULL),
(118, '1695953254', '11', '1', 'completed', '', '2023-09-29 02:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chats`
--

DROP TABLE IF EXISTS `tbl_chats`;
CREATE TABLE IF NOT EXISTS `tbl_chats` (
  `chat_id` int NOT NULL AUTO_INCREMENT,
  `room_id` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `msg` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `send_by` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chats`
--

INSERT INTO `tbl_chats` (`chat_id`, `room_id`, `msg`, `send_by`) VALUES
(1, '1', 'awd', '27'),
(2, NULL, 'awd', '27'),
(3, NULL, 'awd', '27'),
(4, '1', 'awd', '27'),
(5, NULL, 'awd', '27'),
(6, '1', 'awd', '27'),
(7, '1', 'awd', '27'),
(8, '1', 'awd', '27'),
(9, '1', 'awdawd', '27'),
(10, '1', 'awd', '27'),
(11, NULL, 'awd', '27'),
(12, NULL, 'awd', '27'),
(13, NULL, 'awd', '27'),
(14, '1', 'awd2222', '27'),
(15, '1', 'awd2222', '27'),
(16, '1', 'awd2222', '27'),
(17, '1', 'awd2222', '27'),
(18, '1', 'awd2222', '27'),
(19, '1', 'awd2222', '27'),
(20, NULL, 'awd2222', '27'),
(21, NULL, 'awd2222', '27'),
(22, NULL, 'awd2222', '27'),
(23, '1', 's', '27'),
(24, '1', 'ss', '27'),
(25, '1', 's', '27'),
(26, '1', 's', '27'),
(27, '1', 'awd', '27'),
(28, '1', 'awd', '27'),
(29, '1', 'awd', '27'),
(30, '1', 'awd', '27'),
(31, '1', 'awd', '27'),
(32, NULL, 'awd', '27'),
(33, '1', 'awd', '27'),
(34, '1', 'awd', '27'),
(35, '1', 'awd', '27'),
(36, '1', 'awd', '27'),
(37, '1', 'awd', '27'),
(38, '1', 'awd', '27'),
(39, '1', 'awd', '27'),
(40, '1', 'awd', '27'),
(41, '1', 'awdawd', '27'),
(42, '1', 'awd', '27'),
(43, '1', 'awd', '27'),
(44, '1', 'awd', '27'),
(45, '1', 'hehehhee', '27'),
(46, '1', 'okay', '27'),
(47, '1', 'awd', '27'),
(48, '1', 'awd', '27'),
(49, '1', 'awd', '27'),
(50, '1', 'awd', '27'),
(51, '1', 'awdawd', '27'),
(52, '3', 'awd', '27'),
(53, '3', 'awd', '27'),
(54, '5', 'awd', '27'),
(55, '5', 'awd', '27'),
(56, '8', 'awd', '27'),
(57, '8', 'awd', '27'),
(58, '8', 'awd', '27'),
(59, '8', 'ddw', '27'),
(60, '8', '2dwad', '27'),
(61, '8', 'awd', '27'),
(62, '11', 'awd', '27'),
(63, '11', 'okay2', '27'),
(64, '11', 'awd', '27'),
(65, '11', '???', '27'),
(66, '11', '??', '27'),
(67, '11', 'awdawd', '27'),
(68, '11', 'awdawd', '27'),
(69, '11', 'awd', '27'),
(70, '11', 'sige2', '27'),
(71, '11', 'awd', '27'),
(72, '11', 'awd', '27'),
(73, '11', 'oaky2', '27'),
(74, '1', '??', '27'),
(75, '1', '???', '27'),
(76, '1', '????213123', '27'),
(77, '1', '????213123', '27'),
(78, '1', '????213123', '27'),
(79, '1', '????213123', '27'),
(80, '1', '????213123', '27'),
(81, '1', '????213123s', '27'),
(82, '1', '????213123ss', '27'),
(83, '1', 'awdawdawd', '27'),
(84, '1', 'awdawdawd', '27'),
(85, '1', 'awdawdawd123', '27'),
(86, '1', 'awdawdawd123 okay2', '27'),
(87, '1', 'awdawdawd123 okay2??', '27'),
(88, '1', 'awdawdawd123 okay2??', '27'),
(89, '1', 'awdawdawd123 okay2??', '27'),
(90, '1', 'awdawdawd123 okay2??', '27'),
(91, '1', 'awdawdawd123 okay2??', '27'),
(92, '1', 'awdawdawd123 okay2??', '27'),
(93, '1', 'awdawdawd123 okay2??', '27'),
(94, '1', 'awdawdawd123 okay2??', '27'),
(95, '1', 'awdawdawd123 okay2??', '27'),
(96, '1', 'awdawdawd123 okay2??', '27'),
(97, '1', 'awdawdawd123 okay2??', '27'),
(98, '1', 'awdawdawd123 okay2??', '27'),
(99, '1', 'awdawdawd123 okay2??', '27'),
(100, '1', 'awdawdawd123 okay2??', '27'),
(101, '1', 'awdawdawd123 okay2??', '27'),
(102, '1', 'awdawdawd123 okay2??', '27'),
(103, '1', 'awdawdawd123 okay2??', '27'),
(104, '1', 'awdawdawd123 okay2??', '27'),
(105, '1', 'awdawdawd123 okay2??', '27'),
(106, '1', 'awdawdawd123 okay2??', '27'),
(107, '1', 'awdawdawd123 okay2??', '27'),
(108, '2', 'awdawdawd123 okay2??', '27'),
(109, '2', 'awdawdawd123 okay2??', '27'),
(110, '2', 'awdawdawd123 okay2??', '27'),
(111, '2', 'awdawdawd123 okay2??', '27'),
(112, '2', 'awdawdawd123 okay2??s', '27'),
(113, '2', 'awdawdawd123 okay2??s23', '27'),
(114, '2', 'awdawdawd123 okay2??s23', '27'),
(115, '2', 'awdawdawd123 okay2??s23123123', '27'),
(116, '2', 'awdawdawd123 okay2??s23123123', '27'),
(117, '2', 'awdawdawd123 okay2??s23123123', '27'),
(118, '2', 'awdawdawd123 okay2??s23123123', '27'),
(119, '2', 'awdawdawd123 okay2??s23123123', '27'),
(120, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(121, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(122, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(123, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(124, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(125, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(126, '8', 'awdawdawd123 okay2??s23123123awd', '27'),
(127, '3', 'awdawdawd123 okay2??s23123123awd', '27'),
(128, '3', 'awd', '27'),
(129, '11', 'awd', '27'),
(130, '11', 'awdawd', '27'),
(131, '11', '???', '27'),
(132, '11', 'okay', '27'),
(133, '1', 'sige2', '27'),
(134, '1', 'opo', '27'),
(135, NULL, 'awd', '27'),
(136, '1', 'awd', '27'),
(137, '1', 'awdawd', '27'),
(138, '1', 'awdawdawd', '27'),
(139, '1', '????', '27'),
(140, '1', 'awd', '27'),
(141, '1', 'awd', '27'),
(142, '1', 'awdawd2', '27'),
(143, '1', '12312awdawd', '27'),
(144, '1', 'awdawdawdawd333', '27'),
(145, '1', 'hehehehehehe', '27'),
(146, '1', 'awd', '27'),
(147, '2', '123123123', '27'),
(148, '2', 'wd', '27'),
(149, '3', 'awdawdawd', '27'),
(150, '1', '1123123', '27'),
(151, '1', 'awdawd', '27'),
(152, '1', 'adadaw3', '27'),
(153, '1', 'awdawdawd', '27'),
(154, '1', 'awdaw33123', '27'),
(155, '1', 'awd', '27'),
(156, '1', 'awd', '27'),
(157, '1', 'sige2', '1'),
(158, '1', 'okay', '1'),
(159, '1', 'awd', '1'),
(160, '1', 'awed', '1'),
(161, '1', '???', '1'),
(162, '20', 'awd', '1'),
(163, '1', 'awd', '1'),
(164, '1', 'awd', '1'),
(165, '1', '333', '1'),
(166, '1', '1111', '1'),
(167, '1', 'awdawd', '1'),
(168, '1', '3333', '1'),
(169, '1', 'awdawd', '1'),
(170, '1', '123123123awd', '1'),
(171, '1', 'awd', '27'),
(172, '1', 'w', '27'),
(173, '1', 'd', '27'),
(174, '1', 'okay', '27'),
(175, '1', 'okay?', '27'),
(176, '1', 'awd', '27'),
(177, '1', 'awd', '27'),
(178, '1', '???', '27'),
(179, '9', 'awd', '27'),
(180, '7', 'awd', '27'),
(181, '7', '??', '22'),
(182, '7', 'okay', '22'),
(183, '7', 'awd', '22'),
(184, '19', 'awd', '22'),
(185, NULL, '😅', '22'),
(186, NULL, '😅', '22'),
(187, NULL, '😅', '22'),
(188, NULL, '😅', '22'),
(189, NULL, '😅', '22'),
(190, '19', '😅', '22'),
(191, '19', '😅', '22'),
(192, '19', '😅', '22'),
(193, '7', '😄', '22'),
(194, '7', '😂', '22'),
(195, '7', '😃', '22'),
(196, '7', '👽', '22'),
(197, '7', '👽', '22'),
(198, '7', '😄', '22'),
(199, '7', '😄', '22'),
(200, '7', '😂okay', '22'),
(201, '7', '😂😂😂😂😂😂👽👽', '22'),
(202, '7', '👽👽okay', '22'),
(203, '7', '??😂', '22'),
(204, '7', 'awdawd😂', '22'),
(205, '7', '👽👽👽', '22'),
(206, '7', '😂😂', '22'),
(207, '19', 'HAHAHAHAHAHA', '1'),
(208, '19', 'ok', '22'),
(209, '19', 'Hahaha', '1'),
(210, '19', '😂', '22'),
(211, '19', 'U', '1'),
(212, '19', '😂', '22'),
(213, '19', 'awd', '22'),
(214, '19', 'daw', '22'),
(215, '19', '😂', '22'),
(216, '19', 'Hahaha', '1'),
(217, '19', '2', '22'),
(218, '19', 'S', '1'),
(219, '19', 'awd', '22'),
(220, '19', '👽', '22'),
(221, '19', '?', '1'),
(222, '19', 'Hshshsh', '1'),
(223, '19', 'awdawdawd', '22'),
(224, '7', 'awd', '22'),
(225, '19', 'awd', '22'),
(226, '13', 'hi vian', '1'),
(227, '13', '😂', '1'),
(228, '19', 'ikaw ni😄', '22'),
(229, '19', 'hello😃', '1'),
(230, '16', 'hio', '1'),
(231, '17', 'maam', '1'),
(232, '19', 'https://quillbot.com/', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

DROP TABLE IF EXISTS `tbl_rooms`;
CREATE TABLE IF NOT EXISTS `tbl_rooms` (
  `room_id` int NOT NULL AUTO_INCREMENT,
  `users` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`room_id`, `users`) VALUES
(1, '27|1'),
(2, '27|4'),
(3, '27|12'),
(4, '27|13'),
(5, '27|15'),
(6, '27|20'),
(7, '27|22'),
(8, '27|19'),
(9, '27|26'),
(10, '27|'),
(11, '27|27'),
(12, '1|1'),
(13, '1|4'),
(14, '1|12'),
(15, '1|13'),
(16, '1|15'),
(17, '1|19'),
(18, '1|20'),
(19, '1|22'),
(20, '1|26'),
(21, '22|4'),
(22, '22|13'),
(23, '22|20'),
(24, '22|26'),
(25, '22|19'),
(26, '22|15'),
(27, '22|12'),
(28, '22|'),
(29, '1|');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `v_code` int DEFAULT NULL,
  `c_number` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `first_name`, `last_name`, `role`, `email`, `password`, `created_at`, `updated_at`, `v_code`, `c_number`, `deleted_at`, `deleted`) VALUES
(1, '012345', 'Jay', 'Intig', 'manager', 'jay@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2022-12-13 14:30:26', '2022-12-13 14:30:26', NULL, NULL, NULL, 0),
(4, '012346', 'Vivian', 'Lumactod', 'manager', 'vivian.lumactod02@gmail.com', '1234', '2022-12-15 19:07:49', '2022-12-15 19:07:49', NULL, NULL, NULL, 0),
(12, '012347', 'jay ann', 'abella', 'manager', 'jayannabella@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2022-12-18 03:40:16', '2022-12-18 03:40:16', NULL, NULL, NULL, 0),
(13, '012348', 'Hilda', 'Baje', 'manager', 'hilda@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2022-12-18 21:27:26', '2022-12-18 21:27:26', NULL, NULL, NULL, 0),
(15, '012349', 'King', 'Sun', 'manager', 'kingsun@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-02-11 19:40:34', '2023-08-07 06:52:50', NULL, NULL, NULL, 0),
(19, '012310', 'jay', 'ann', 'manager', 'jan@gmail.com', '$2y$10$BsYv3GZetYv7i2Q5GUPUuOLU6q2Thp/kMWRCue3Q3aYifbYyw5/wy', '2023-03-20 19:54:06', '2023-03-20 19:54:06', NULL, NULL, NULL, 0),
(20, '012311', 'cecilia', 'heart', 'manager', 'cecilia@gmail.com', '$2y$10$K5SLEfZU9cJ5Yy.ps1drL.7fKbEMJ.1KyTFbHXr0brSblErt6519u', '2023-04-23 15:15:27', '2023-05-06 07:42:14', NULL, NULL, '2023-10-01 16:50:11', 0),
(22, '012312', 'cherry', 'blossom', 'manager', 'cherryblossom@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-05-22 05:27:42', '2023-08-07 06:52:47', NULL, NULL, NULL, 0),
(27, '123', 'awdawd', 'awdawd', 'manager', '123', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-08-28 12:49:22', '2023-08-28 12:49:22', 1234, '123123', '2023-10-01 16:46:22', 1),
(28, '012315', 'fra', 'raf', 'employee', '121212', '$2y$10$cWbmjtV5Sb34TIoPbYTIleVjouy45pGq9SdKBy55t.FF9bKKbF9RK', '2023-08-31 13:12:57', '2023-09-18 01:13:10', NULL, '123', NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `fk_order_product_product` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
