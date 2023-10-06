-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2023 at 04:34 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

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

CREATE TABLE `employ` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `supplier` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `quantity_ordered` int(11) DEFAULT NULL,
  `quantity_received` int(11) DEFAULT NULL,
  `quantity_remaining` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `supplier`, `product`, `quantity_ordered`, `quantity_received`, `quantity_remaining`, `status`, `batch`, `created_by`, `created_at`, `updated_at`) VALUES
(0, 5, 11, 20, 20, 0, 'complete', 1689158434, 13, '2023-07-12 12:40:34', '2023-07-12 12:40:34'),
(3, 9, 17, 50, 50, 0, 'complete', 1684052155, 1, '2023-05-14 10:15:55', '2023-05-14 10:15:55'),
(5, 11, 16, 20, 15, 5, 'pending', 1684052228, 1, '2023-05-14 10:17:08', '2023-05-14 10:17:08'),
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
(30, 5, 11, 1, NULL, NULL, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(31, 11, 11, 2, NULL, NULL, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(32, 8, 13, 2, NULL, NULL, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(33, 12, 13, 3, NULL, NULL, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23'),
(34, 11, 13, 4, NULL, NULL, 'pending', 1693458263, 22, '2023-08-31 05:04:23', '2023-08-31 05:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_product_history`
--

CREATE TABLE `order_product_history` (
  `id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `qty_received` int(11) NOT NULL,
  `date_received` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product_history`
--

INSERT INTO `order_product_history` (`id`, `order_product_id`, `qty_received`, `date_received`, `date_updated`) VALUES
(0, 0, 20, '2023-07-12 12:50:53', '2023-07-12 12:50:53'),
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
(34, 27, 50, '2023-06-12 17:45:45', '2023-06-12 17:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `stocks` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `item_code`, `product_name`, `description`, `category`, `img`, `stocks`, `price`, `created_by`, `created_at`, `updated_at`) VALUES
(11, 'FRN043', 'R22 Freon', ' refregerant R22 30klg											<br />										', 'Freon', 'product-1684124284.jpeg', 19, 600, 1, '2023-05-05 17:24:09', '2023-08-31 08:47:40'),
(13, '0', 'Silver Rod', '  basta kanni								', 'Others', 'product-1684124176.jpeg', 333, 23, 1, '2023-05-06 20:28:01', '2023-08-31 13:16:10'),
(14, '0', 'Compressor', '  Parts to cool the car																			', 'Compressor', 'product-1686193153.jpg', 3, 32000, 1, '2023-05-14 10:06:32', '2023-05-14 10:06:32'),
(15, '0', 'Refregenrant oil', ' just oil											<br />										', 'Others', 'product-1684124152.jpeg', 10, 320, 1, '2023-05-14 10:12:15', '2023-05-14 10:12:15'),
(16, '0', 'Fiber Glass', ' Para dli mugawas aircons							', 'Others', 'product-1684124142.jpeg', 63, 120, 1, '2023-05-14 10:14:00', '2023-08-31 08:47:16'),
(17, '0', 'Insolatiosn Tubess', 'agianan sa aircon lol										', 'Others', 'product-1693802835.jpeg', 81, 50, 1, '2023-05-14 10:15:23', '2023-09-04 06:47:15'),
(18, 'FRN044', 'R134A', '13.6 kg', 'Freon', 'product-1693803654.jpg', 13, 6500, 1, '2023-09-04 07:00:54', '2023-09-04 07:00:54'),
(19, '', 'R404A', '10.9kg', 'Freon', 'product-1693805847.jpg', 9, 7400, 1, '2023-09-04 07:37:27', '2023-09-04 07:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `productsuppliers`
--

CREATE TABLE `productsuppliers` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `updated_at`, `created_at`) VALUES
(29, 5, 14, '2023-06-08 04:59:13', '2023-06-08 04:59:13'),
(43, 11, 14, '2023-07-12 12:38:39', '2023-07-12 12:38:39'),
(44, 5, 0, '2023-07-12 15:50:37', '2023-07-12 15:50:37'),
(46, 11, 0, '2023-08-29 05:29:45', '2023-08-29 05:29:45'),
(47, 11, 0, '2023-08-29 05:37:04', '2023-08-29 05:37:04'),
(49, 11, 0, '2023-08-31 05:26:35', '2023-08-31 05:26:35'),
(51, 10, 0, '2023-08-31 05:27:18', '2023-08-31 05:27:18'),
(52, 0, 0, '2023-08-31 05:30:14', '2023-08-31 05:30:14'),
(54, 11, 0, '2023-08-31 05:30:14', '2023-08-31 05:30:14'),
(55, 1, 19, '2023-08-31 05:32:48', '2023-08-31 05:32:48'),
(57, 11, 19, '2023-08-31 05:32:48', '2023-08-31 05:32:48'),
(78, 10, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 11, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 5, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 5, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 9, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 11, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 8, 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 11, 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 12, 13, '2023-09-04 06:08:30', '2023-09-04 06:08:30'),
(98, 8, 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 9, 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 5, 18, '2023-09-04 07:00:54', '2023-09-04 07:00:54'),
(101, 10, 19, '2023-09-04 07:37:27', '2023-09-04 07:37:27'),
(102, 5, 19, '2023-09-04 07:37:27', '2023-09-04 07:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(191) NOT NULL,
  `supplier_location` varchar(191) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'Nemia', 'Ozamis', 'nemiasing@gmail.com', 1, '2023-05-03 21:01:23', '2023-05-03 21:01:23'),
(8, 'Ajax Ent.', 'bukidnon', 'delmonte@gmail.com', 13, '2023-05-03 21:04:32', '2023-05-03 21:04:32'),
(9, 'Sulfur corp.', 'Davao', 'sulfur@gmail.com', 1, '2023-05-14 10:08:16', '2023-05-14 10:08:16'),
(10, 'Lex Corp.', 'Quezon', 'lex.corp@gmail.com', 1, '2023-05-14 10:08:51', '2023-05-14 10:08:51'),
(11, 'Json Ent.', 'Cebu-tad', 'json.ent@gmail.com', 1, '2023-05-14 10:10:23', '2023-05-14 10:10:23'),
(12, 'Carrier corp.', 'Iligan City', 'carrier.corp@gmail.com / 0992929292', 13, '2023-05-19 17:25:18', '2023-05-19 17:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `time_order` varchar(45) DEFAULT NULL,
  `product_id` varchar(45) DEFAULT NULL,
  `qty` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`cart_id`, `time_order`, `product_id`, `qty`) VALUES
(1, '1691578650', '11', '1'),
(2, '1691578650', '13', '1'),
(3, '1691578650', '14', '1'),
(12, '1691578840', '14', '1'),
(20, '1691579039', '17', '1'),
(21, '1691579039', '15', '1'),
(22, '1691579039', '13', '1'),
(23, '1691579177', '11', '1'),
(24, '1691579187', '11', '1'),
(25, '1691579201', '11', '1'),
(26, '1691579323', '11', '11'),
(27, '1691579323', '13', '2'),
(28, '1691579365', '11', '13'),
(29, '1691579365', '13', '12'),
(30, '1691579714', '11', '1'),
(31, '1691579735', '11', '2'),
(32, '1691579969', '11', '3'),
(33, '1691580350', '11', '1'),
(34, '1691580350', '15', '2'),
(35, '1691580395', '11', '11'),
(36, '1691580395', '14', '12'),
(37, '1691580406', '11', '28'),
(38, '1691580406', '14', '10'),
(39, '1691580469', '11', '35'),
(40, '1691580497', '11', '26'),
(42, '1691580534', '15', '3'),
(47, '1691580634', '15', '1'),
(48, '1691580712', '11', '35'),
(49, '1691580712', '13', '1'),
(50, '1691580944', '11', '1'),
(51, '1691581011', '11', '8'),
(52, '1691581011', '15', '3'),
(53, '1691581011', '14', '11'),
(54, '1691581011', '16', '11'),
(55, '1691581081', '11', '1'),
(56, '1691581081', '13', '1'),
(57, '1691581081', '14', '1'),
(58, '1691581081', '15', '1'),
(59, '1691581081', '16', '1'),
(60, '1691581081', '17', '1'),
(61, '1691581795', '11', '1'),
(62, '1691583059', '11', '1'),
(63, '1691583080', '11', '1'),
(64, '1691583135', '11', '1'),
(65, '1691583344', '11', '1'),
(67, '1691583373', '13', '1'),
(68, '1691583373', '14', '11'),
(69, '1691583373', '15', '3'),
(70, '1691583373', '16', '9'),
(71, '1691583373', '17', '1'),
(72, '1691583373', '11', '1'),
(73, '1691583515', '11', '17'),
(74, '1691583515', '13', '1'),
(75, '1691583627', '13', '1'),
(76, '1691583627', '14', '1'),
(77, '1693139778', '11', '1'),
(78, '1693139778', '13', '1'),
(105, '1693379224', '13', '1'),
(106, '1693379224', '14', '11'),
(107, '1693379224', '11', '1'),
(108, '1693380105', '11', '1'),
(109, '1693380158', '11', '1'),
(110, '1693380158', '13', '1'),
(111, '1693380158', '14', '1'),
(112, '1693399235', '14', '1'),
(113, '1693399499', '13', '1'),
(115, '1693399643', '14', '1'),
(121, '1693399722', '13', '1'),
(122, '1693399744', '13', '1'),
(127, '1693399837', '14', '1'),
(128, '1693399837', '13', '1'),
(129, '1693399893', '11', '1'),
(130, '1693399893', '13', '1'),
(131, '1693399905', '15', '1'),
(132, '1693399905', '13', '1'),
(134, '1693400568', '15', '1'),
(135, '1693400614', '13', '1'),
(136, '1693400656', '14', '1'),
(137, '1693400703', '14', '1'),
(138, '1693400790', '13', '1'),
(139, '1693400790', '11', '1'),
(140, '1693401261', '14', '1'),
(141, '1693401261', '11', '1'),
(142, '1693401261', '13', '1'),
(143, '1693401324', '13', '1'),
(144, '1693401324', '15', '1'),
(145, '1693401324', '16', '1'),
(146, '1693401324', '11', '1'),
(150, '1693401386', '11', '1'),
(151, '1693401423', '13', '1'),
(155, '1693401484', '14', '1'),
(156, '1693401484', '13', '1'),
(157, '1693401484', '17', '1'),
(158, '1693401597', '11', '1'),
(159, '1693401597', '13', '1'),
(160, '1693401657', '11', '1'),
(163, '1693401694', '11', '1'),
(164, '1693401708', '11', '1'),
(165, '1693401708', '13', '1'),
(173, '1693401719', '13', '1'),
(175, '1693401825', '11', '1'),
(176, '1693401825', '13', '1'),
(177, '1693402102', '11', '1'),
(178, '1693402121', '11', '1'),
(179, '1693402133', '14', '1'),
(180, '1693402133', '15', '1'),
(181, '1693402133', '11', '1'),
(182, '1693402531', '11', '1'),
(183, '1693402570', '11', '1'),
(184, '1693402679', '11', '1'),
(185, '1693402877', '11', '1'),
(186, '1693402877', '13', '1'),
(187, '1693402894', '11', '1'),
(188, '1693402919', '13', '1'),
(189, '1693403032', '11', '1'),
(190, '1693403102', '11', '1'),
(191, '1693403120', '11', '1'),
(192, '1693403163', '11', '1'),
(193, '1693403221', '11', '1'),
(194, '1693403241', '11', '1'),
(205, '1693403374', '11', '1'),
(207, '1693404159', '11', '1'),
(208, '1693404159', '14', '4'),
(209, '1693404591', '11', '1'),
(210, '1693404629', '11', '1'),
(211, '1693404684', '13', '1'),
(212, '1693404684', '14', '1'),
(214, '1693404731', '14', '1'),
(215, '1693404731', '15', '3'),
(216, '1693404731', '16', '1'),
(217, '1693454071', '11', '16'),
(218, '1693454071', '14', '11'),
(219, '1693454071', '13', '28'),
(220, '1693454071', '15', '1'),
(221, '1693454424', '11', '1'),
(222, '1693455068', '11', '2'),
(223, '1693455068', '13', '2'),
(224, '1693455068', '14', '4'),
(225, '1693456048', '11', '1'),
(229, '1693456611', '15', '3'),
(230, '1693456611', '14', '1'),
(231, '1693456739', '11', '1'),
(232, '1693456773', '11', '1'),
(238, '1693882876', '11', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chats`
--

CREATE TABLE `tbl_chats` (
  `chat_id` int(11) NOT NULL,
  `room_id` varchar(45) DEFAULT NULL,
  `msg` varchar(500) DEFAULT NULL,
  `send_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tbl_rooms` (
  `room_id` int(11) NOT NULL,
  `users` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` varchar(30) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `role`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Jay', 'Intig', 'manager', 'jay@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2022-12-13 14:30:26', '2022-12-13 14:30:26'),
(4, 'Vivian', 'Lumactod', 'manager', 'vivian.lumactod02@gmail.com', '1234', '2022-12-15 19:07:49', '2022-12-15 19:07:49'),
(12, 'jay ann', 'abella', 'manager', 'jayannabella@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2022-12-18 03:40:16', '2022-12-18 03:40:16'),
(13, 'Hilda', 'Baje', 'manager', 'hilda@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2022-12-18 21:27:26', '2022-12-18 21:27:26'),
(15, 'King', 'Sun', 'manager', 'kingsun@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-02-11 19:40:34', '2023-08-07 06:52:50'),
(19, 'jay', 'ann', 'manager', 'jan@gmail.com', '$2y$10$BsYv3GZetYv7i2Q5GUPUuOLU6q2Thp/kMWRCue3Q3aYifbYyw5/wy', '2023-03-20 19:54:06', '2023-03-20 19:54:06'),
(20, 'cecilia', 'heart', 'manager', 'cecilia@gmail.com', '$2y$10$K5SLEfZU9cJ5Yy.ps1drL.7fKbEMJ.1KyTFbHXr0brSblErt6519u', '2023-04-23 15:15:27', '2023-05-06 07:42:14'),
(22, 'cherry', 'blossom', 'manager', 'cherryblossom@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-05-22 05:27:42', '2023-08-07 06:52:47'),
(26, 'nemia', 'ang', 'employee', 'nemia@gmail.com', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-05-24 03:49:54', '2023-08-07 06:52:43'),
(27, 'awdawd', 'awdawd', 'manager', '123', '$2y$10$7tgKa/dnLKfcj.CE0jPZnuxFQ8dHs8MmfAf7zUqwx1q/YfrdUnCkS', '2023-08-28 12:49:22', '2023-08-28 12:49:22'),
(28, 'fra', 'raf', 'employee', '121212', '$2y$10$cWbmjtV5Sb34TIoPbYTIleVjouy45pGq9SdKBy55t.FF9bKKbF9RK', '2023-08-31 13:12:57', '2023-08-31 13:12:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employ`
--
ALTER TABLE `employ`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier` (`supplier`),
  ADD KEY `product` (`product`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_id` (`order_product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `tbl_chats`
--
ALTER TABLE `tbl_chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `tbl_chats`
--
ALTER TABLE `tbl_chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
