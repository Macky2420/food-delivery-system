-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 09:46 AM
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
-- Database: `nwssufood_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Foods'),
(2, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_feedback` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_name`, `user_feedback`, `timestamp`, `rating`) VALUES
(4, 'Julyver27', 'Hay salamat my website na para pag pa reserve sa canteen kay pila perme pag lunch.', '2023-05-16 21:00:53', 5),
(5, 'Angielyn14', 'Yeyss. Thank you manggud uraura. ', '2023-05-16 21:01:43', 4),
(6, 'Pitopits24', 'This is very efficient to every student!Kudos to one who created this website :)', '2023-05-16 23:01:28', 5),
(7, 'iamme0', 'very nice, very good', '2023-05-17 02:44:35', 5),
(8, 'lalaine123', 'updated na an canteen dire na gyap amoy adobo pag gawas', '2023-05-17 03:10:08', 4),
(9, 'Jaybee31', 'Butangi na halo-halo kay mapaso sa canteen', '2023-05-17 03:23:14', 5),
(10, 'Angielyn14', 'kaupay', '2023-05-18 05:33:56', 4),
(11, 'renzo21', 'karasa', '2023-05-18 05:49:02', 5),
(12, 'carm02', 'maaslom', '2023-05-18 05:59:16', 3);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `disable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `category_id`, `disable`, `thumbnail`, `users_token`) VALUES
(1, 'Burger', NULL, 'no', '1679809784.png', NULL),
(66, 'Burger', 1, 'no', '1635777529.png', '51f76949defe4d55f3d002421e27a8c0f0dbc15aa4c2228f7d20372a3d3359a9'),
(69, 'Pancit', 1, 'no', '1635777491.png', '51f76949defe4d55f3d002421e27a8c0f0dbc15aa4c2228f7d20372a3d3359a9'),
(70, 'Inasal', 1, 'no', '1635773516.png', '51f76949defe4d55f3d002421e27a8c0f0dbc15aa4c2228f7d20372a3d3359a9'),
(74, 'Halo-Halo', 2, 'no', '1635779029.png', '51f76949defe4d55f3d002421e27a8c0f0dbc15aa4c2228f7d20372a3d3359a9'),
(83, 'Linaga', 1, 'no', '1635777481.png', '153862152009d81d91591c811c6bbdbc5b98b51b4723a9fed4e7797a37be31af'),
(84, 'Coffee', 2, 'no', '1635778899.png', '153862152009d81d91591c811c6bbdbc5b98b51b4723a9fed4e7797a37be31af'),
(85, 'Shake', 2, 'no', '1635778855.png', '51f76949defe4d55f3d002421e27a8c0f0dbc15aa4c2228f7d20372a3d3359a9');

-- --------------------------------------------------------

--
-- Table structure for table `menu_options`
--

CREATE TABLE `menu_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_options`
--

INSERT INTO `menu_options` (`id`, `menu_id`, `name`, `cost`) VALUES
(1, 1, 'Hamburger w/ Chesse', 20.00),
(2, 1, 'Burger w/ Hotdog', 22.00),
(139, 69, 'Shrimp', 20.00),
(140, 69, 'Chicken', 20.00),
(141, 70, 'Chicken', 30.00),
(142, 70, 'Pork', 40.00),
(147, 74, 'Large', 50.00),
(148, 74, 'Medium', 40.00),
(149, 74, 'Small', 30.00),
(158, 66, 'Small', 30.00),
(171, 83, 'Manok', 50.00),
(172, 83, 'Isda', 60.00),
(173, 83, 'Baboy', 80.00),
(174, 84, 'Coffee black', 30.00),
(175, 84, 'Coffee White', 40.00),
(176, 85, 'Watermelon', 25.00),
(177, 85, 'Buko', 25.00),
(178, 85, 'Leche flan', 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `reserve_orders`
--

CREATE TABLE `reserve_orders` (
  `id` bigint(20) NOT NULL,
  `reserve_id` bigint(20) NOT NULL,
  `total` double(8,2) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `cus_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reserve_orders`
--

INSERT INTO `reserve_orders` (`id`, `reserve_id`, `total`, `user_id`, `cus_token`) VALUES
(30, 1684212520, 50.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(31, 1684213020, 0.00, 164, '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6'),
(32, 1684213089, 120.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(33, 1684213342, 230.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(34, 1684213874, 80.00, 164, '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6'),
(35, 1684214473, 30.00, 164, '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6'),
(36, 1684263081, 150.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(37, 1684263443, 180.00, 169, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(38, 1684278012, 100.00, 164, 'ec8f4e7be72b17e64059000d18544c6f0195b16b838cee3c0c9fd82c3cbf2ee0'),
(39, 1684279156, 50.00, 164, 'ec8f4e7be72b17e64059000d18544c6f0195b16b838cee3c0c9fd82c3cbf2ee0'),
(40, 1684291351, 145.00, 164, 'e45cdd33648de05381c16c0fffe3b1b3c4c7f2bdbff65dacfe5f8f286cc4bbe0'),
(41, 1684292217, 45.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(42, 1684292820, 185.00, 164, '418430d764675d3de0e2910f77876d890f715eb739fa0896d682d006c298c75b'),
(43, 1684293600, 150.00, 164, 'd9bce84460cfa67cb593cacd576aefab3730e7869f349b1611bb7993057aaebe'),
(44, 1684294471, 200.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(45, 1684294936, 200.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(46, 1684387871, 75.00, 164, 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(47, 1684388772, 100.00, 169, 'af7a6a3b1acc62919149803340c0d218ddab499407bf3ae021819e2a5bc69c91'),
(48, 1684389418, 80.00, 164, '6927fbdcdee42725915907b106dc0e602ccbe5b9814ab5856fb7916b35ad33a9'),
(49, 1684465908, 100.00, 164, '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6'),
(50, 1684466068, 155.00, 164, '75ccdffc8fa7161de1b5301cc0c355a039570c657e059c94cdbf48b892602891'),
(51, 1684466112, 50.00, 164, '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`) VALUES
(1, 'admin'),
(2, 'staff'),
(3, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_orders`
--

CREATE TABLE `temporary_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_option_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `users_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temporary_orders`
--

INSERT INTO `temporary_orders` (`id`, `user_id`, `menu_id`, `menu_option_id`, `quantity`, `total_cost`, `created_at`, `updated_at`, `users_token`) VALUES
(249, 164, 66, 158, 2, '60.00', '0000-00-00 00:00:00', '2023-05-17 16:00:00', 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(250, 164, 85, 176, 1, '25.00', '0000-00-00 00:00:00', '2023-05-17 16:00:00', 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(251, 169, 83, 171, 1, '50.00', '0000-00-00 00:00:00', '2023-05-17 16:00:00', 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5'),
(252, 169, 84, 174, 1, '30.00', '0000-00-00 00:00:00', '2023-05-17 16:00:00', 'ec29cd498e1ebd67f24b181a15f1868682e8a5302048bebcce822d5a56942ee5');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_option_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completion_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `users_token` varchar(255) DEFAULT NULL,
  `total_cost` decimal(8,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `meal_time` varchar(50) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `menu_id`, `menu_option_id`, `quantity`, `remarks`, `completion_status`, `payment_status`, `created_at`, `updated_at`, `users_token`, `total_cost`, `payment_method`, `meal_time`, `order_id`, `order_type`) VALUES
(134, 164, 70, 141, 1, 'vvav z', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6', '30.00', 'cash only', 'Breakfast (6:00 am - 9:00 am)', 49, 'Dine-in'),
(135, 164, 69, 139, 1, 'vvav z', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6', '20.00', 'cash only', 'Breakfast (6:00 am - 9:00 am)', 49, 'Dine-in'),
(136, 164, 74, 147, 1, 'vvav z', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6', '50.00', 'cash only', 'Breakfast (6:00 am - 9:00 am)', 49, 'Dine-in'),
(137, 164, 69, 139, 1, 'azbsdb', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '75ccdffc8fa7161de1b5301cc0c355a039570c657e059c94cdbf48b892602891', '20.00', 'cash only', 'Lunch (10:00 pm - 2:00 pm)', 50, 'Dine-in'),
(138, 164, 66, 158, 2, 'azbsdb', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '75ccdffc8fa7161de1b5301cc0c355a039570c657e059c94cdbf48b892602891', '60.00', 'cash only', 'Lunch (10:00 pm - 2:00 pm)', 50, 'Dine-in'),
(139, 164, 74, 147, 1, 'azbsdb', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '75ccdffc8fa7161de1b5301cc0c355a039570c657e059c94cdbf48b892602891', '50.00', 'cash only', 'Lunch (10:00 pm - 2:00 pm)', 50, 'Dine-in'),
(140, 164, 85, 176, 1, 'azbsdb', '', '', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '75ccdffc8fa7161de1b5301cc0c355a039570c657e059c94cdbf48b892602891', '25.00', 'cash only', 'Lunch (10:00 pm - 2:00 pm)', 50, 'Dine-in'),
(141, 164, 70, 141, 1, 'vaabad', 'yes', 'yes', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6', '30.00', 'cash only', 'Breakfast (6:00 am - 9:00 am)', 51, 'Take-out'),
(142, 164, 69, 139, 1, 'vaabad', 'yes', 'yes', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6', '20.00', 'cash only', 'Breakfast (6:00 am - 9:00 am)', 51, 'Take-out'),
(143, 164, 74, 148, 1, 'vaabad', 'no', 'no', '0000-00-00 00:00:00', '2023-05-18 16:00:00', '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6', '40.00', 'cash only', 'Breakfast (6:00 am - 9:00 am)', 51, 'Take-out');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `time_updated` time DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `date_updated`, `time_updated`, `verified`, `status`, `token`) VALUES
(164, 'Station 20', 'markietan14@gmail.com', '$2y$10$s.xeqThUYAxDNakZzAQdC.Q9Yd6yqv14LMeF2S43WsAoAfpcV0O1S', 2, '2023-04-24', '01:47:13', 1, 0, '51f76949defe4d55f3d002421e27a8c0f0dbc15aa4c2228f7d20372a3d3359a9'),
(166, 'Admin 1', 'ymike4018@gmail.com', '$2y$10$FzmvfUqMhwvyqWvdsR6O0uYNN6QyRzJ2lD5EzbXPrITAPtd1WCjnK', 1, '2023-05-02', '05:35:05', 1, 0, '45dbdae147b00a7fed4f1e62cb8cea402b645612555da161960f0413574aeb44'),
(168, 'Angielyn14', 'markietaneo14@gmail.com', '$2y$10$PFiSQNjT846bRtXj.9Wn0uEVml3rKvY2bIJhRB/0QgvCGchh8omta', 3, '2023-05-05', '10:30:51', 1, 1, '75ccdffc8fa7161de1b5301cc0c355a039570c657e059c94cdbf48b892602891'),
(169, 'Station 2', 'ronquilloangielyn75@gmail.com', '$2y$10$gXaIV4AYIEePXQT.LVOhaOPh7BNgroxf1yZ5ONg3XbEigP0.QDykm', 2, '2023-05-05', '12:22:12', 1, 0, '153862152009d81d91591c811c6bbdbc5b98b51b4723a9fed4e7797a37be31af'),
(171, 'Julyver27', 'taneomarkie7@gmail.com', '$2y$10$oPa5q.ycU01RkScO652rU.hNMfLlwd.l0kkzKL3Pdzvkge1RUG4WK', 3, '2023-05-12', '06:02:41', 1, 0, '4950c4bb20bb62ba84931f0656c6a28736a228a2599784babc2f862eef93cfe6'),
(174, 'Pitopits24', 'lynronquillo5@gmail.com', '$2y$10$zyIkWMwD9A1Onqs.BfvMLOVlFciB0m1pgJ3ahttZ3D6vRUBiV5Q76', 3, '2023-05-17', '06:55:34', 1, 0, 'ec8f4e7be72b17e64059000d18544c6f0195b16b838cee3c0c9fd82c3cbf2ee0'),
(175, 'iamme0', 'itsdunkindonut@gmail.com', '$2y$10$834H8MuIfx5Kti73ZWJyFOy56EJjlIwdRyv2IRvr4Qli/Z6tvwbLm', 3, '2023-05-17', '10:39:09', 1, 0, 'e45cdd33648de05381c16c0fffe3b1b3c4c7f2bdbff65dacfe5f8f286cc4bbe0'),
(178, 'lalaine123', 'lalainemontermoso77@gmail.com', '$2y$10$ip4uVUUQWG5/kTrHTWsr/u3g1loHIJ5nTciuyr/Xi44KO/pi7JGSC', 3, '2023-05-17', '11:02:41', 1, 0, '418430d764675d3de0e2910f77876d890f715eb739fa0896d682d006c298c75b'),
(179, 'Jaybee31', 'jayklash958@gmail.com', '$2y$10$ErhK4XP0Ao6V/PrW7nA6duUOmOm6Q1KFQI4l/ESSI.Zb9kWhFvP3S', 3, '2023-05-17', '11:13:39', 1, 0, 'd9bce84460cfa67cb593cacd576aefab3730e7869f349b1611bb7993057aaebe'),
(181, 'renzo21', 'markrenzo40@gmail.com', '$2y$10$EwCY9cmOqIuDtQ5I1bqXqeQLxBVFOlZ1WYMQQZvWey24gYh2je4Fy', 3, '2023-05-18', '01:41:39', 1, 0, 'af7a6a3b1acc62919149803340c0d218ddab499407bf3ae021819e2a5bc69c91'),
(182, 'carm02', 'johnsmithsaloritos@gmail.com', '$2y$10$p/ZbFzDa/k9VsVQC3Ppo2.J3FnnYfKxN0SUTuvwLBhIfFwRyhThde', 3, '2023-05-18', '01:53:48', 1, 0, '6927fbdcdee42725915907b106dc0e602ccbe5b9814ab5856fb7916b35ad33a9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menus_category_id` (`category_id`) USING BTREE,
  ADD KEY `users_token` (`users_token`);

--
-- Indexes for table `menu_options`
--
ALTER TABLE `menu_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menus_id` (`menu_id`);

--
-- Indexes for table `reserve_orders`
--
ALTER TABLE `reserve_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `temporary_orders`
--
ALTER TABLE `temporary_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menus_orders_id` (`menu_id`),
  ADD KEY `fk_menu_option_id` (`menu_option_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `users_token` (`users_token`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `menu_option_id` (`menu_option_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `menu_options`
--
ALTER TABLE `menu_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `reserve_orders`
--
ALTER TABLE `reserve_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `temporary_orders`
--
ALTER TABLE `temporary_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_options`
--
ALTER TABLE `menu_options`
  ADD CONSTRAINT `fk_menus_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `temporary_orders`
--
ALTER TABLE `temporary_orders`
  ADD CONSTRAINT `fk_menu_option_id` FOREIGN KEY (`menu_option_id`) REFERENCES `menu_options` (`id`),
  ADD CONSTRAINT `fk_menus_orders_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `menu_option_id` FOREIGN KEY (`menu_option_id`) REFERENCES `menu_options` (`id`),
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `reserve_orders` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
