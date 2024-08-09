-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 11:16 AM
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
-- Database: `laravel_product_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

CREATE TABLE `barcodes` (
  `ID` int(11) NOT NULL,
  `BRAND` varchar(10) NOT NULL DEFAULT '',
  `B_CODE` varchar(15) NOT NULL DEFAULT '',
  `NUMBER` decimal(10,0) NOT NULL DEFAULT 0,
  `REMARK` varchar(50) NOT NULL DEFAULT '',
  `STATUS` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barcodes`
--

INSERT INTO `barcodes` (`ID`, `BRAND`, `B_CODE`, `NUMBER`, `REMARK`, `STATUS`) VALUES
(1, 'OP', '88500802', 6, '8279', 'OP'),
(2, 'OTHER', '', 0, 'ไม่ต้องมี Barcode', 'ALL'),
(3, 'RI', '88500802', 0, 'Brand Ri En', 'OP'),
(4, 'BD', '88500803', 0, '0', 'CP'),
(5, 'CPS', '88500807', 0, '0', 'CP'),
(6, 'HOUSE HOLD', '88500808', 0, '0', 'CP'),
(7, 'MM', '88500803', 0, '0', 'CP'),
(8, 'OT', '88500803', 0, '0', 'CP'),
(9, 'SPICES', '88500803', 0, '0', 'CP'),
(10, 'VN', '88500803', 0, '0', 'CP');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อบริษัท',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = รออนุมัติ, 1 = อนุมัติ',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `company_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'OP', 1, NULL, NULL, '2024-06-18 06:43:01', '2024-06-18 06:43:01'),
(2, 'Cute Press', 1, NULL, NULL, '2024-06-18 06:43:01', '2024-06-18 06:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'รหัสโพสต์',
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-07-03 04:00:12', '2024-07-03 04:00:12'),
(2, 1, 1, '2024-07-03 04:00:12', '2024-07-03 04:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `DOC_TP` varchar(10) NOT NULL DEFAULT '',
  `DOC_SYS` varchar(10) DEFAULT '',
  `DOC_NO` varchar(10) DEFAULT '',
  `NUMBER` decimal(10,0) DEFAULT 0,
  `FIELD` varchar(20) DEFAULT '',
  `DOC_ST` decimal(2,0) DEFAULT 0,
  `REMARK` varchar(50) DEFAULT '',
  `REMARK_EDIT` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`DOC_TP`, `DOC_SYS`, `DOC_NO`, `NUMBER`, `FIELD`, `DOC_ST`, `REMARK`, `REMARK_EDIT`) VALUES
('OP', '', '', 6, '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'ชื่ออาหาร',
  `price` double(8,2) DEFAULT NULL COMMENT 'ชื่ออาหาร',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homes`
--

CREATE TABLE `homes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manage_menus`
--

CREATE TABLE `manage_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อ',
  `url` varchar(255) DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'main menu id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `url`, `seq`, `status`, `created_at`, `updated_at`) VALUES
(1, 'NPD Request', NULL, 1, 1, '2021-04-03 18:58:21', '2021-04-03 18:58:21'),
(2, 'ทะเบียนสินค้า', NULL, 2, 1, '2021-04-03 18:58:21', '2021-04-03 18:58:21'),
(3, 'Marketing', NULL, 3, 1, '2021-04-03 18:58:21', '2021-04-03 18:58:21'),
(4, 'Managemenu', NULL, 4, 1, '2024-06-28 07:48:31', '2024-06-28 07:48:34'),
(5, 'อื่นๆ', NULL, 5, 1, '2024-07-02 03:36:12', '2024-07-02 03:36:12'),
(6, '5', NULL, 6, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_relations`
--

CREATE TABLE `menu_relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position_id` int(11) NOT NULL COMMENT 'รหัสตำแหน่ง',
  `menu_id` int(11) NOT NULL COMMENT 'รหัสเมนู',
  `submenu_id` int(11) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `create` int(11) DEFAULT NULL,
  `edit` int(11) DEFAULT NULL,
  `delete` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_relations`
--

INSERT INTO `menu_relations` (`id`, `position_id`, `menu_id`, `submenu_id`, `view`, `create`, `edit`, `delete`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 1, 1, 1, 1, 1, NULL, NULL, '2023-01-19 18:07:36', '2023-01-19 18:07:36'),
(2, 1, 2, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2023-01-19 18:07:36', '2023-01-19 18:07:36'),
(3, 5, 1, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2023-01-19 18:07:38', '2023-01-19 18:07:38'),
(4, 1, 5, NULL, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL),
(5, 1, 5, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2024-07-18 02:47:52', '2024-07-18 02:47:52'),
(6, 1, 5, 2, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(7, 1, 5, 3, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(8, 1, 6, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(9, 1, 6, 9, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(10, 1, 6, 10, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(35, 7, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 6, 1, NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_02_135513_create_homes_table', 1),
(6, '2024_05_02_143813_create_food_table', 1),
(7, '2024_05_03_013728_create_trn_dona_totambons_table', 1),
(8, '2024_05_06_070843_create_product_images_table', 1),
(10, '2024_06_05_030301_create_manage_menus_table', 1),
(15, '2024_05_31_020058_create_products_table', 2),
(16, '2024_06_18_061507_create_brands_table', 2),
(17, '2024_06_25_072051_create_menu_relations_table', 3),
(19, '2024_07_03_031800_create_positions_table', 4),
(20, '2024_07_03_035414_create_posts_table', 5),
(21, '2024_07_03_035448_create_comments_table', 5),
(23, '2024_07_09_030557_create_submenus_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `npd_categorys`
--

CREATE TABLE `npd_categorys` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `npd_categorys`
--

INSERT INTO `npd_categorys` (`ID`, `DESCRIPTION`) VALUES
('001', 'Face'),
('002', 'Body'),
('003', 'Hair'),
('004', 'Toiletries'),
('005', 'Personal Care'),
('006', 'Make Up'),
('007', 'Household'),
('008', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `npd_cos`
--

CREATE TABLE `npd_cos` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `npd_cos`
--

INSERT INTO `npd_cos` (`ID`, `DESCRIPTION`) VALUES
('002', 'Intira Klaewban'),
('008', 'Pinyamon Seekaw'),
('012', 'Mullika Kidarn'),
('013', 'Budsara Soontaratta'),
('014', 'Praepan Upalagool'),
('015', 'Thanayut Mangkhlat');

-- --------------------------------------------------------

--
-- Table structure for table `npd_pdms`
--

CREATE TABLE `npd_pdms` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `npd_pdms`
--

INSERT INTO `npd_pdms` (`ID`, `DESCRIPTION`) VALUES
('001', 'Apaiporn Srisook');

-- --------------------------------------------------------

--
-- Table structure for table `npd_textures`
--

CREATE TABLE `npd_textures` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `npd_textures`
--

INSERT INTO `npd_textures` (`ID`, `DESCRIPTION`) VALUES
('001', 'Cream'),
('002', 'Gel'),
('003', 'Lotion'),
('004', 'Oil'),
('005', 'Foam'),
('006', 'Emultion'),
('007', 'Mask'),
('008', 'Powder'),
('009', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 21, 'token', '2436d243389b413db0908a8b92c0acc281b4776522122722e23a63fc6f825f9b', '[\"*\"]', NULL, NULL, '2024-06-12 19:35:30', '2024-06-12 19:35:30'),
(2, 'App\\Models\\User', 21, 'token', 'c12d4b29c3309c772327a2fc61e25b4905c33f97f54de4f536ed3f365aad5076', '[\"*\"]', NULL, NULL, '2024-06-12 19:37:48', '2024-06-12 19:37:48'),
(3, 'App\\Models\\User', 21, 'token', 'b12b7621bf8d88f80d75b534a6fd59928c50e8c63b5c86ce8f5fbcc64426d023', '[\"*\"]', NULL, NULL, '2024-06-12 19:39:55', '2024-06-12 19:39:55'),
(4, 'App\\Models\\User', 21, 'token', '9e95cee18142a834812755aad941bf318150b83175c646d9514d3364b90bc2fd', '[\"*\"]', NULL, NULL, '2024-06-12 19:42:10', '2024-06-12 19:42:10'),
(5, 'App\\Models\\User', 21, 'token', 'f62117b0dd17b4a334b75ebf2a5df8b56831b4e604749402c99a3daf9e9937b7', '[\"*\"]', NULL, NULL, '2024-06-12 19:43:20', '2024-06-12 19:43:20'),
(6, 'App\\Models\\User', 21, 'token', 'a5538d66f23b8ebe7a487f836a97abcb932596990474efdb28f205dc74ef4717', '[\"*\"]', NULL, NULL, '2024-06-12 19:43:34', '2024-06-12 19:43:34'),
(7, 'App\\Models\\User', 21, 'token', '3f00d3a68b2cd8ff2194b03a16847dde2ee38e604fb75dde790690bb1251b4d5', '[\"*\"]', NULL, NULL, '2024-06-12 19:45:15', '2024-06-12 19:45:15'),
(8, 'App\\Models\\User', 21, 'token', '4eae7afe92ba7eaa77cd279fa1c9feb0fdb2f732b9f669ce56799b6c34fade97', '[\"*\"]', NULL, NULL, '2024-06-12 19:45:30', '2024-06-12 19:45:30'),
(9, 'App\\Models\\User', 21, 'token', 'a3e505f1a8249797d49c8108e0a48bebf1cbe4dc69921495d32d16ae8cd0874c', '[\"*\"]', NULL, NULL, '2024-06-12 19:52:28', '2024-06-12 19:52:28'),
(10, 'App\\Models\\User', 21, 'productMastertoken', '1be007dbee7cd3fb7d27404d684dff8ed495e4479d9bb629d06f7b860d630f3d', '[\"*\"]', NULL, NULL, '2024-06-12 19:54:14', '2024-06-12 19:54:14'),
(11, 'App\\Models\\User', 21, 'productMastertoken', 'f6f06bb3eb9f5cbe7242e124cf833247ece25eea5cb1c27ca3f02da3f570aeb2', '[\"*\"]', NULL, NULL, '2024-06-12 19:56:09', '2024-06-12 19:56:09'),
(12, 'App\\Models\\User', 21, 'productMastertoken', 'de007513813a774484876cbe540dbdc5ab2843c05de961997c8985998d9f3e1c', '[\"*\"]', NULL, NULL, '2024-06-12 19:56:26', '2024-06-12 19:56:26'),
(13, 'App\\Models\\User', 21, 'productMastertoken', '5125e88d435a3305a38727013e0442adaecd332370f936d156a0862a6d7b4e92', '[\"*\"]', NULL, NULL, '2024-06-12 19:56:45', '2024-06-12 19:56:45'),
(14, 'App\\Models\\User', 21, 'productMastertoken', '4e6361efd115dcd8d5efe13900badfee20a413788f20d0cf830965353d23b120', '[\"*\"]', NULL, NULL, '2024-06-18 18:48:51', '2024-06-18 18:48:51'),
(15, 'App\\Models\\User', 21, 'productMastertoken', 'be75d5e5a267457784700e7be2cd330da7e9dd38f6a8578ddf01663050e698e5', '[\"*\"]', NULL, NULL, '2024-06-18 20:59:44', '2024-06-18 20:59:44'),
(16, 'App\\Models\\User', 21, 'productMastertoken', '95e710312222430cc226ef5c187948db557cd83c3b961ea84c8e538f91cea219', '[\"*\"]', NULL, NULL, '2024-06-19 00:03:51', '2024-06-19 00:03:51'),
(17, 'App\\Models\\User', 21, 'productMastertoken', 'e4930a1d85255afe49a41a7f6c0b222b788c173905094cc5a5f82c98747c9bab', '[\"*\"]', NULL, NULL, '2024-06-19 00:33:11', '2024-06-19 00:33:11'),
(18, 'App\\Models\\User', 21, 'productMastertoken', 'a005ad9baf9e41c0d27c61ea30ad7b1a5d69207b70a1642e1d0fbc7b72a99005', '[\"*\"]', NULL, NULL, '2024-06-19 18:42:44', '2024-06-19 18:42:44'),
(19, 'App\\Models\\User', 21, 'productMastertoken', '229b927bafafda68e22f69e229bd551e3625eef36b45c15630c11260508dabd9', '[\"*\"]', NULL, NULL, '2024-06-19 20:58:29', '2024-06-19 20:58:29'),
(20, 'App\\Models\\User', 21, 'productMastertoken', '64e5009667746876e91a77aa12d30fef943e60241cfa62e0bc34e556f45c28f1', '[\"*\"]', NULL, NULL, '2024-06-19 20:59:58', '2024-06-19 20:59:58'),
(21, 'App\\Models\\User', 21, 'productMastertoken', 'bec7ce838c6ee94b50139c9b15b0d0c91178299e1e33e64aace8c5065860fd88', '[\"*\"]', NULL, NULL, '2024-06-19 21:02:03', '2024-06-19 21:02:03'),
(22, 'App\\Models\\User', 21, 'productMastertoken', 'd575196f97c44b33c37b5549f7a3592e61e692cd104e1f4b1188f96cc179e1ff', '[\"*\"]', NULL, NULL, '2024-06-19 21:04:43', '2024-06-19 21:04:43'),
(23, 'App\\Models\\User', 21, 'productMastertoken', '2fd5db58565ac77762f2901fe0747eba7281b0f44f4de298bbb9dc2c89f04ce2', '[\"*\"]', NULL, NULL, '2024-06-19 21:06:13', '2024-06-19 21:06:13'),
(24, 'App\\Models\\User', 21, 'productMastertoken', '2d1f99db9c62fae9c8d3407a302bcaf6b2db460a7112d9ad9f2c88a85e00fbda', '[\"*\"]', NULL, NULL, '2024-06-19 21:06:55', '2024-06-19 21:06:55'),
(25, 'App\\Models\\User', 21, 'productMastertoken', '2d08d462074f0640c1e7dc9966c7df358888d7a8266a3536cd36391043444338', '[\"*\"]', NULL, NULL, '2024-06-20 03:24:13', '2024-06-20 03:24:13'),
(26, 'App\\Models\\User', 21, 'productMastertoken', 'afd9966d12492cd20e0021dfcc22ab890a120cba94748e6eef8c03c3b092363f', '[\"*\"]', NULL, NULL, '2024-06-20 19:59:31', '2024-06-20 19:59:31'),
(27, 'App\\Models\\User', 21, 'productMastertoken', 'ce07293d5330058e642357c7d0689e5030a6634566c8c9c20c80ad162f392baf', '[\"*\"]', NULL, NULL, '2024-06-23 18:37:08', '2024-06-23 18:37:08'),
(28, 'App\\Models\\User', 21, 'productMastertoken', '03822f552439452768f6a075b53e39ffba32d2981d44f9976c39e8d58a34fb5e', '[\"*\"]', NULL, NULL, '2024-06-24 02:11:00', '2024-06-24 02:11:00'),
(29, 'App\\Models\\User', 21, 'productMastertoken', 'bf2551fa4d52ba78585a569af7323a33dad57fc59e19c7e1510432c7391251bc', '[\"*\"]', NULL, NULL, '2024-06-24 02:21:05', '2024-06-24 02:21:05'),
(30, 'App\\Models\\User', 21, 'productMastertoken', '0e34f37e1e7560f85cc1974c295a66f12acb0aac73acab0db2aef5104b5b745f', '[\"*\"]', NULL, NULL, '2024-06-24 03:03:32', '2024-06-24 03:03:32'),
(31, 'App\\Models\\User', 21, 'productMastertoken', '3ba4731b2456e2670e424853b72c80bcad9395ee92499eff422c43938fa97191', '[\"*\"]', NULL, NULL, '2024-06-24 18:35:49', '2024-06-24 18:35:49'),
(32, 'App\\Models\\User', 21, 'productMastertoken', 'fd3a3b4ee000780ba816753c6b8991f84888975f907a1abc5982209d90ec7135', '[\"*\"]', NULL, NULL, '2024-06-24 21:14:17', '2024-06-24 21:14:17'),
(33, 'App\\Models\\User', 21, 'productMastertoken', 'dfe18ec3d763ac8f148d5ac942b5dc1889379eaf8707bce2cb37bf510155d015', '[\"*\"]', NULL, NULL, '2024-06-24 21:18:01', '2024-06-24 21:18:01'),
(34, 'App\\Models\\User', 21, 'productMastertoken', '23808effd7cb55eb53c23173fc1e4646b9040b614e4f7d95d0a7f63b24a6f06d', '[\"*\"]', NULL, NULL, '2024-06-24 21:18:12', '2024-06-24 21:18:12'),
(35, 'App\\Models\\User', 21, 'productMastertoken', '80cf6eed556e51562949ec47f34dd2a71e9a0853d71f368b767666126cb2662e', '[\"*\"]', NULL, NULL, '2024-06-24 23:23:48', '2024-06-24 23:23:48'),
(36, 'App\\Models\\User', 21, 'productMastertoken', '4d1aed63a81021b73fd7b7feddd5fa7ebd8cd63780ddcaad233799bf10666ed6', '[\"*\"]', NULL, NULL, '2024-06-25 03:35:31', '2024-06-25 03:35:31'),
(37, 'App\\Models\\User', 21, 'productMastertoken', 'eb0e767d3bcfdb2339acb56784f2ecc66c2b6ec1cae3d6b4365288d9b2a93444', '[\"*\"]', NULL, NULL, '2024-06-25 19:02:26', '2024-06-25 19:02:26'),
(38, 'App\\Models\\User', 21, 'productMastertoken', '32cd8edbc01bbb994f3f534d20f06622177605a1cb3c03d274ea9ec03570d28e', '[\"*\"]', NULL, NULL, '2024-06-26 00:12:48', '2024-06-26 00:12:48'),
(39, 'App\\Models\\User', 21, 'productMastertoken', '7bf46907932b298792c95deb8c86a580e2245b4b2d2b4b767079a0d96d339474', '[\"*\"]', NULL, NULL, '2024-06-26 18:29:11', '2024-06-26 18:29:11'),
(40, 'App\\Models\\User', 21, 'productMastertoken', '20ff50700ec46a7d0bc0a7f1154f57333d1dc59a367617a5ee6c75e090d410d1', '[\"*\"]', NULL, NULL, '2024-06-26 20:54:50', '2024-06-26 20:54:50'),
(41, 'App\\Models\\User', 23, 'productMastertoken', 'be2ca76e00d93e31d2149ed7765fbd658177c3400445401d8efc7870075aad73', '[\"*\"]', NULL, NULL, '2024-06-26 21:04:31', '2024-06-26 21:04:31'),
(42, 'App\\Models\\User', 21, 'productMastertoken', '66353bbf7c8445a2501db140a7e56a0d8dfbf50a2149a79b697e2e1c20fd855a', '[\"*\"]', NULL, NULL, '2024-06-26 21:19:16', '2024-06-26 21:19:16'),
(43, 'App\\Models\\User', 21, 'productMastertoken', '6f9e695c2076a984a573cc9b2db478d03138f50be54b174b3358cabaa8554684', '[\"*\"]', NULL, NULL, '2024-06-26 23:46:39', '2024-06-26 23:46:39'),
(44, 'App\\Models\\User', 23, 'productMastertoken', '1da9080bbd2c2ba1eff88841ea9bc9627ba671848a181dece3012a41441ab51a', '[\"*\"]', NULL, NULL, '2024-06-26 23:47:40', '2024-06-26 23:47:40'),
(45, 'App\\Models\\User', 23, 'productMastertoken', '08d1920149b02ea17db75350258e2d39bdbf8eb75455faea9b8e7e2c2c590a86', '[\"*\"]', NULL, NULL, '2024-06-26 23:48:43', '2024-06-26 23:48:43'),
(46, 'App\\Models\\User', 21, 'productMastertoken', '236bed5d8f0bf03e47808afee632e788577e240ea408c532735956a8a16f69c4', '[\"*\"]', NULL, NULL, '2024-06-26 23:49:17', '2024-06-26 23:49:17'),
(47, 'App\\Models\\User', 23, 'productMastertoken', '750c461ed63083d104a211bab1dba9d36afda3ef40966d7575a2bc7eb85b3fbc', '[\"*\"]', NULL, NULL, '2024-06-26 23:50:10', '2024-06-26 23:50:10'),
(48, 'App\\Models\\User', 21, 'productMastertoken', '90b894b6617fac6628db8c962b5e7f9925cae97a5b1f708159c372f919bbe366', '[\"*\"]', NULL, NULL, '2024-06-27 00:01:13', '2024-06-27 00:01:13'),
(49, 'App\\Models\\User', 21, 'productMastertoken', '172be104dd1c2bb45a5d89fcda51b4788888949900d9534db657bb1d126bff6a', '[\"*\"]', NULL, NULL, '2024-06-27 19:06:24', '2024-06-27 19:06:24'),
(50, 'App\\Models\\User', 23, 'productMastertoken', '5846d7012c7f77e1672ca0ab799c038734e9f87e8756e4787e44f2e3f8a1287f', '[\"*\"]', NULL, NULL, '2024-06-27 20:16:51', '2024-06-27 20:16:51'),
(51, 'App\\Models\\User', 24, 'productMastertoken', '050af50bf26a189dba7a14d9a040ca5e7692d5a67f17b312ccc2f24c29491f83', '[\"*\"]', NULL, NULL, '2024-06-27 20:19:31', '2024-06-27 20:19:31'),
(52, 'App\\Models\\User', 24, 'productMastertoken', '71855b162f8f7194f3ef6f5fbcbb4bd4672d85e16860d1b13a104464fc082026', '[\"*\"]', NULL, NULL, '2024-06-27 20:21:19', '2024-06-27 20:21:19'),
(53, 'App\\Models\\User', 21, 'productMastertoken', '725c0304701eb152e82383069219e5f97e1fd1e932a334e14b8192d9897c6b08', '[\"*\"]', NULL, NULL, '2024-06-27 23:19:01', '2024-06-27 23:19:01'),
(54, 'App\\Models\\User', 24, 'productMastertoken', '82d8eecd16ddbfbb55bbdbfb3da01c9818ff4f849e028f44a10738da859c34ca', '[\"*\"]', NULL, NULL, '2024-06-27 23:19:37', '2024-06-27 23:19:37'),
(55, 'App\\Models\\User', 23, 'productMastertoken', 'c8d87d0ba456cd61d0d8897a34672e828a784d24e69191f0075a116dec5f4291', '[\"*\"]', NULL, NULL, '2024-06-28 00:52:01', '2024-06-28 00:52:01'),
(56, 'App\\Models\\User', 21, 'productMastertoken', '355f844976d9cf617531dcf8d010eea2c2d16447bac52d26ac4e3b567725d5a2', '[\"*\"]', NULL, NULL, '2024-06-30 18:17:54', '2024-06-30 18:17:54'),
(57, 'App\\Models\\User', 21, 'productMastertoken', 'c38921fda5ac0294fee36b73b31e3a917f799d9e5b3652ede05b276ec7be8aac', '[\"*\"]', NULL, NULL, '2024-07-01 20:03:59', '2024-07-01 20:03:59'),
(58, 'App\\Models\\User', 21, 'productMastertoken', 'e53028db9c2848d3d1fb228ec0863d3b7c666a3ac1e1ed97339c7d72c40a8ee7', '[\"*\"]', NULL, NULL, '2024-07-01 23:13:57', '2024-07-01 23:13:57'),
(59, 'App\\Models\\User', 24, 'productMastertoken', '11fa9f2dce76d6dfadd595febc3ce6a246fbf44590e9049771be4d251d8bb52f', '[\"*\"]', NULL, NULL, '2024-07-02 02:26:25', '2024-07-02 02:26:25'),
(60, 'App\\Models\\User', 23, 'productMastertoken', '93e7fa397d09e07230e2c960c9a910ff024e82adf334f294ac6d2fcb84d043ba', '[\"*\"]', NULL, NULL, '2024-07-02 02:28:47', '2024-07-02 02:28:47'),
(61, 'App\\Models\\User', 21, 'productMastertoken', '1e10725c8984d1a0d5c6329da652d864324eb5c9b53e3736650c87c20289d8d4', '[\"*\"]', NULL, NULL, '2024-07-02 19:19:43', '2024-07-02 19:19:43'),
(62, 'App\\Models\\User', 21, 'productMastertoken', '78007010b421994ed1cb35638f4beccc8ac4413c5e9afba14aebc09681fe9aec', '[\"*\"]', NULL, NULL, '2024-07-02 23:51:29', '2024-07-02 23:51:29'),
(63, 'App\\Models\\User', 21, 'productMastertoken', 'e5fc4b1351f0d7d6dcafe4d7fefc48c7b58d27097c5a9c29a1d0b849c3cb9037', '[\"*\"]', NULL, NULL, '2024-07-02 23:51:41', '2024-07-02 23:51:41'),
(64, 'App\\Models\\User', 21, 'productMastertoken', '4780d8b8ee05c7b2e3a4e7a17dbccf7ed9f0f6bf04da1fa6f3ff17fe3b8e31b1', '[\"*\"]', NULL, NULL, '2024-07-02 23:52:06', '2024-07-02 23:52:06'),
(65, 'App\\Models\\User', 21, 'productMastertoken', '1afcb7247b778c5f9cc20951ac400773e4ef9a3d45ced2ec5002cc13860692f6', '[\"*\"]', NULL, NULL, '2024-07-02 23:53:11', '2024-07-02 23:53:11'),
(66, 'App\\Models\\User', 21, 'productMastertoken', '31f4363c67ba1846fea16bc78db4212c5a76ae6021f1617998a1441443125dc4', '[\"*\"]', NULL, NULL, '2024-07-02 23:53:37', '2024-07-02 23:53:37'),
(67, 'App\\Models\\User', 21, 'productMastertoken', 'ea7cf419bd895bbffc06b22e33733066824a6b3443bc8d14241d864c0e3d287c', '[\"*\"]', NULL, NULL, '2024-07-02 23:55:21', '2024-07-02 23:55:21'),
(68, 'App\\Models\\User', 21, 'productMastertoken', '9f32a6958400d7c5ba46e5b2d9111320e26822890726f70c3630f6bb4e41e877', '[\"*\"]', NULL, NULL, '2024-07-02 23:56:12', '2024-07-02 23:56:12'),
(69, 'App\\Models\\User', 21, 'productMastertoken', 'ac5ebaa774750ea4d78a876105288ea8e206a2a4ae800f11db2cafe6a9c3fd1c', '[\"*\"]', NULL, NULL, '2024-07-02 23:56:52', '2024-07-02 23:56:52'),
(70, 'App\\Models\\User', 21, 'productMastertoken', 'c7382d7c78d314ab3a1469871c2c8cf1ebfb4d55f9d28e8fc8e0b8b3abcdb3b3', '[\"*\"]', NULL, NULL, '2024-07-02 23:57:32', '2024-07-02 23:57:32'),
(71, 'App\\Models\\User', 21, 'productMastertoken', '66f97e39b662fa8937aa574f38295ed7614083e8a99fc22baadedae2db15af13', '[\"*\"]', NULL, NULL, '2024-07-02 23:59:41', '2024-07-02 23:59:41'),
(72, 'App\\Models\\User', 21, 'productMastertoken', '6d742ac6ed30bcc662c8c0613fb6cad400053c6971dc8ef9b418c03699e8db5a', '[\"*\"]', NULL, NULL, '2024-07-02 23:59:53', '2024-07-02 23:59:53'),
(73, 'App\\Models\\User', 21, 'productMastertoken', 'b7a4b132945737d4b9f08f3d9ea38d4850136140afdf56e261c7a3cd78b55de0', '[\"*\"]', NULL, NULL, '2024-07-03 00:01:04', '2024-07-03 00:01:04'),
(74, 'App\\Models\\User', 21, 'productMastertoken', '0be825358692cd04114932af24ab5ecb4bc8bab2551891d02a2f9a6908b99ec3', '[\"*\"]', NULL, NULL, '2024-07-03 00:02:16', '2024-07-03 00:02:16'),
(75, 'App\\Models\\User', 21, 'productMastertoken', '6e5d7791ecf6c1665c255bfe8b5c30156570317313dd33a2d57a904b015facad', '[\"*\"]', NULL, NULL, '2024-07-03 02:30:58', '2024-07-03 02:30:58'),
(76, 'App\\Models\\User', 21, 'productMastertoken', '3c5759db270e42321fca1548ebdca314b9e7c08cc156a2792b9931ce5a09c6f2', '[\"*\"]', NULL, NULL, '2024-07-03 18:53:50', '2024-07-03 18:53:50'),
(77, 'App\\Models\\User', 21, 'productMastertoken', '04c89c067bb465919e63339cf378527c17b2d8912e1ff5f4a88262499932bd62', '[\"*\"]', NULL, NULL, '2024-07-03 23:40:51', '2024-07-03 23:40:51'),
(78, 'App\\Models\\User', 21, 'productMastertoken', '965dc19202395d8cd9a51c37a4f5e7e5431b0242ad1010e6c83ab81a64abb852', '[\"*\"]', NULL, NULL, '2024-07-04 20:29:28', '2024-07-04 20:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_position` varchar(255) DEFAULT NULL COMMENT 'ชื่อบทบาท',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name_position`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', NULL, NULL, NULL, NULL),
(2, 'Manager_Account', NULL, NULL, NULL, NULL),
(3, 'Account', NULL, NULL, NULL, NULL),
(4, 'Category - OP', NULL, NULL, NULL, NULL),
(5, 'Product - OP', NULL, NULL, NULL, NULL),
(6, 'E-Commerce - OP', NULL, NULL, NULL, NULL),
(7, 'Marketing - CPS', NULL, NULL, NULL, NULL),
(8, 'Manager_IBSH', NULL, NULL, NULL, NULL),
(9, 'IBSH', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` int(11) DEFAULT NULL COMMENT 'รหัสแบรนด์',
  `product_id` int(11) DEFAULT NULL COMMENT 'รหัสสินค้า',
  `name` varchar(255) DEFAULT NULL COMMENT 'ชื่อสินค้า',
  `company_products` varchar(255) DEFAULT NULL COMMENT 'สินค้าของบริษัท',
  `seq` varchar(100) DEFAULT NULL COMMENT 'ลำดับ',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = รออนุมัติ, 1 = อนุมัติ',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `product_id`, `name`, `company_products`, `seq`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 20001, 'ครีมทาผิว', 'OP', 'P00001', 1, NULL, NULL, '2024-06-09 17:50:30', '2024-06-09 12:04:49'),
(2, 1, 20002, 'ครีมทาหน้า', 'OP', 'P00002', 1, NULL, NULL, NULL, '2024-06-17 14:14:32'),
(3, 1, 20003, 'aaa', 'OP', 'T000003', 1, NULL, NULL, '2024-06-10 11:45:13', '2024-06-17 14:12:29'),
(4, 1, 20004, 'aaaaa', 'OP', 'T000004', 1, NULL, NULL, '2024-06-10 17:50:26', '2024-06-16 16:36:14'),
(5, 1, 20005, 'eeeee', 'OP', 'T000005', 2, NULL, NULL, '2024-06-10 19:02:59', '2024-06-16 16:26:45'),
(6, 1, 20006, 'ttttt', 'OP', 'T000006', 2, NULL, NULL, '2024-06-10 19:35:45', '2024-06-16 16:26:32'),
(7, 2, 70001, 'jjj', 'Cute Press', 'T000007', 2, NULL, NULL, '2024-06-16 17:57:36', '2024-06-16 20:18:42'),
(8, NULL, NULL, NULL, NULL, 'T000008', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'ชื่อไฟล์',
  `image_path` varchar(255) DEFAULT NULL COMMENT 'ชื่อพาร์ท',
  `seq` int(11) NOT NULL DEFAULT 0 COMMENT 'ลำดับไฟล์',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1= active 0= deactive',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_develops`
--

CREATE TABLE `pro_develops` (
  `BRAND` varchar(10) NOT NULL DEFAULT '',
  `DOC_NO` varchar(20) DEFAULT '',
  `REF_DOC` varchar(20) DEFAULT '',
  `REVISE_NO` decimal(6,0) DEFAULT 0,
  `EDIT_DT` date DEFAULT '1900-01-01',
  `USER_EDIT` varchar(15) DEFAULT '',
  `STATUS` varchar(5) DEFAULT '',
  `REMARK_ST` varchar(100) DEFAULT '',
  `CUST_OEM` varchar(100) DEFAULT '',
  `JOB_REFNO` varchar(20) DEFAULT '',
  `DOC_DT` date DEFAULT '1900-01-01',
  `NPD` varchar(50) DEFAULT '',
  `PDM` varchar(50) DEFAULT '',
  `NAME_ENG` varchar(70) DEFAULT '',
  `PRODUCT` varchar(15) DEFAULT '',
  `BARCODE` varchar(15) NOT NULL DEFAULT '',
  `CATEGORY` varchar(20) DEFAULT '',
  `CAPACITY` varchar(20) DEFAULT '',
  `Q_SMELL` decimal(6,2) DEFAULT 0.00,
  `Q_COLOR` decimal(6,2) DEFAULT 0.00,
  `TARGET_GRP` varchar(20) DEFAULT '',
  `TARGET_STK` date DEFAULT '1900-01-01',
  `PRICE_FG` varchar(30) DEFAULT '',
  `PRICE_COST` varchar(30) DEFAULT '',
  `PRICE_BULK` varchar(30) DEFAULT '',
  `P_CONCEPT` varchar(1000) DEFAULT '',
  `P_BENEFIT` varchar(1000) DEFAULT '',
  `TEXTURE` varchar(20) DEFAULT '',
  `TEXTURE_OT` varchar(30) DEFAULT '',
  `COLOR1` varchar(70) DEFAULT '',
  `COLOR2` varchar(70) DEFAULT '',
  `COLOR3` varchar(70) DEFAULT '',
  `FRANGRANCE` varchar(70) DEFAULT '',
  `INGREDIENT` varchar(1000) DEFAULT '',
  `STD` varchar(70) DEFAULT '',
  `PK` varchar(70) DEFAULT '',
  `OTHER` varchar(70) DEFAULT '',
  `DOCUMENT` varchar(70) DEFAULT '',
  `FIRST_ORD` decimal(12,0) DEFAULT 0,
  `OEM` varchar(1) DEFAULT '0',
  `REASON1` varchar(1) DEFAULT '',
  `REASON1_DES` varchar(100) DEFAULT '',
  `REASON2` varchar(1) DEFAULT '',
  `REASON2_DES` varchar(100) DEFAULT '',
  `REASON3` varchar(1) DEFAULT '',
  `REASON3_DES` varchar(100) DEFAULT '',
  `REF_COLOR` varchar(100) DEFAULT '',
  `REF_FRAGRANCE` varchar(100) DEFAULT '',
  `OEM_STD` varchar(100) DEFAULT '',
  `PACKAGE_BOX` varchar(1) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pro_develops`
--

INSERT INTO `pro_develops` (`BRAND`, `DOC_NO`, `REF_DOC`, `REVISE_NO`, `EDIT_DT`, `USER_EDIT`, `STATUS`, `REMARK_ST`, `CUST_OEM`, `JOB_REFNO`, `DOC_DT`, `NPD`, `PDM`, `NAME_ENG`, `PRODUCT`, `BARCODE`, `CATEGORY`, `CAPACITY`, `Q_SMELL`, `Q_COLOR`, `TARGET_GRP`, `TARGET_STK`, `PRICE_FG`, `PRICE_COST`, `PRICE_BULK`, `P_CONCEPT`, `P_BENEFIT`, `TEXTURE`, `TEXTURE_OT`, `COLOR1`, `COLOR2`, `COLOR3`, `FRANGRANCE`, `INGREDIENT`, `STD`, `PK`, `OTHER`, `DOCUMENT`, `FIRST_ORD`, `OEM`, `REASON1`, `REASON1_DES`, `REASON2`, `REASON2_DES`, `REASON3`, `REASON3_DES`, `REF_COLOR`, `REF_FRAGRANCE`, `OEM_STD`, `PACKAGE_BOX`) VALUES
('OP', 'OP00001', 'IBH-F155', 11, '2015-01-13', 'sa', '', '', '-', 'OP/IBHS/NP31/49', '2006-05-25', '', '', 'Cuticle Hair Treatment (New Formula)', '', '8850080200010', 'Hair Care', '125 ml', 1.00, 1.00, '20-50', '2007-03-01', '295', '-', '', 'เจลวิตามินบำรุงเส้นผมสูตรเข้มข้น เนื้อบางเบา ซ่อมแซมและป้องกันไม่ให้ผมแตกปลายด้วยการเชื่อม\r\nประสานคิวติเคิลของเส้นผม ให้ผมเรียบลื่น เงางาม ไม่เปราะขาดง่าย \r\n', 'อุดมคุณค่าสารสกัดที่ช่วยเคลือปกป้องเส้นผมจากมลภาวะ ให้เส้นผมนุ่มมาก และ เงางาม จัดทรงง่าย \r\nเป็นธรรมชาติ\r\n', 'เจล', '-', 'ไม่มีสี', '', '', 'เหมือน Cuticle Hair Treatment plus Sunscreen for Long Hair', '-', 'Satinique hi Gloss Serum', 'ใช้ร่วม Cuticle Hair Treatment plus Sunscreen for Long Hair', 'หาก develop แล้วให้ทำ blind test', '-', 0, 'Y', 'Y', '', 'Y', 'Reason 2', 'Y', 'Reason 3', 'Ref Color ---', 'Ref Fragrance ---', 'OEM Benchmark ---', 'N'),
('OP', 'OP00002', 'IBH-F155', 0, '1900-01-01', '', '', '', '2', '2', '2024-08-05', '002', '001', '2', '', '8850080200027', '001', '2', 2.00, 2.00, '2', '2024-08-05', '2', '2', '2', '2', '2', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'N', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', 'OP00003', 'IBH-F155', 0, '1900-01-01', '', '', '', '3', '3', '2024-08-05', '002', '001', '3', '', '8850080200034', '001', '3', 3.00, 3.00, '3', '2024-08-05', '3', '3', '3', '3', '3', '001', '3', '3', '', '', '3', '3', '3', '3', '3', '3', 3, 'N', 'Y', '', 'Y', '3', 'Y', '3', '3', '3', '3', NULL),
('OP', 'OP00004', 'IBH-F155', 0, '1900-01-01', '', '', '', '4', '4', '2024-08-06', '002', '001', '4', '', '8850080200041', '001', '4', 4.00, 4.00, '4', '2024-08-06', '4', '4', '4', '4', '4', '001', '4', '4', '', '', '4', '4', '4', '4', '4', '4', 4, 'N', 'Y', '', 'Y', '4', 'Y', '4', '4', '4', '4', NULL),
('OP', 'OP00005', 'IBH-F155', 0, '1900-01-01', '', '', '', '5', '5', '2024-08-06', '012', '001', '5', '', '8850080200058', '002', '5', 5.00, 5.00, '5', '2024-08-06', '5', '5', '5', '5', '5', '001', '5', '5', '', '', '5', '5', '5', '5', '5', '5', 5, 'N', 'Y', '', 'Y', '5', 'Y', '5', '5', '5', '5', NULL),
('OP', 'OP00006', 'IBH-F155', 0, '1900-01-01', '', '', '', '6', '6', '2024-08-07', '002', '001', '6', '', '8850080200065', '001', '6', 6.00, 6.00, '6', '2024-08-07', '6', '6', NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', '', 'N', NULL, 'N', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE `submenus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'ชื่อเมนูย่อย',
  `url` varchar(255) DEFAULT NULL,
  `seq` int(11) NOT NULL DEFAULT 0 COMMENT 'ลำดับเมนูย่อย',
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submenus`
--

INSERT INTO `submenus` (`id`, `menu_id`, `name`, `url`, `seq`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'Product', '1', 1, 1, NULL, NULL, '2024-07-09 07:51:44', '2024-07-09 07:51:44'),
(2, 5, 'Billing', '2', 2, 1, NULL, NULL, '2024-07-09 07:51:44', '2024-07-09 07:51:44'),
(3, 5, 'Invoice', '3', 3, 1, NULL, NULL, '2024-07-09 01:00:47', '2024-07-09 01:00:47'),
(9, 6, '5.1', '5.1', 1, 1, NULL, NULL, '2024-07-31 04:28:26', '2024-07-31 04:28:26'),
(10, 6, '5.2', '5.2', 2, 1, NULL, NULL, '2024-07-31 04:28:26', '2024-07-31 04:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id_tech` bigint(20) NOT NULL,
  `name_tech` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID เต้นท์',
  `position` int(11) NOT NULL COMMENT 'ตำแหน่งงาน',
  `status` int(11) NOT NULL DEFAULT 1,
  `sig_path` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='ตารางช่าง';

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id_tech`, `name_tech`, `name_en`, `user_id`, `position`, `status`, `sig_path`, `updated_at`, `created_at`) VALUES
(1, 'ประยูร อุ่นไทย', 'ประยูร อุ่นไทย', NULL, 0, 0, 'uploads/tech/1/signature/1_sig.png', '2020-07-01 08:35:43', '2020-07-01 08:35:43'),
(2, 'ปฐมพร ทองอินทร', 'ปฐมพร ทองอินทร', NULL, 0, 0, 'uploads/tech/2/signature/2_sig.png', '2020-07-01 08:41:21', '2020-07-01 08:41:21'),
(3, 'ณัฐพล สังขพุทธิ', 'Nuttapon Sangkaputti', NULL, 0, 1, 'uploads/tech/3/signature/3_sig.png', '2020-07-01 08:41:37', '2020-07-01 08:41:37'),
(4, 'พีรพงษ์ ศรีสวรรค์', 'Perapong Srisawan', NULL, 1, 1, 'uploads/tech/4/signature/4_sig.png', '2021-03-24 17:17:50', '2021-02-16 15:33:08'),
(5, 'เอกลักษ์', 'Aekkalux', NULL, 0, 1, 'uploads/tech/5/signature/5_sig.png', '2021-03-26 14:26:22', '2021-03-26 14:26:22'),
(6, 'ฉัตรชัย เรืองแสง', 'Chatchai  Rungsaeng', NULL, 0, 1, 'uploads/tech/6/signature/6_sig.png', '2021-03-26 14:28:29', '2021-03-26 14:28:29'),
(7, 'ช่างโบ้', 'bo', NULL, 0, 1, 'uploads/tech/7/signature/7_sig.png', '2022-05-27 15:19:32', '2022-03-01 12:34:16'),
(8, 'ช่างฟิมล์', 'file', NULL, 0, 1, 'uploads/tech/8/signature/8_sig.png', '2022-03-01 12:35:00', '2022-03-01 12:34:58'),
(9, 'ช่างโก้', 'ko', NULL, 0, 1, 'uploads/tech/9/signature/9_sig.png', '2022-03-01 12:35:19', '2022-03-01 12:35:17'),
(10, 'ช่างบอยๅ', 'boy1', NULL, 0, 0, 'uploads/tech/10/signature/10_sig.png', '2022-04-18 16:48:39', '2022-03-01 12:35:32'),
(11, 'ช่างบอย2', 'boy2', NULL, 0, 1, 'uploads/tech/11/signature/11_sig.png', '2022-03-01 12:36:00', '2022-03-01 12:35:59'),
(12, 'ช่างตี๋', 'tee', NULL, 0, 1, 'uploads/tech/12/signature/12_sig.png', '2022-03-01 12:36:19', '2022-03-01 12:36:18'),
(13, 'ช่างเอิร์ท', 'earth', NULL, 0, 1, 'uploads/tech/13/signature/13_sig.png', '2022-03-01 12:36:33', '2022-03-01 12:36:32'),
(14, 'ช่างนนท์', 'non', NULL, 0, 1, 'uploads/tech/14/signature/14_sig.png', '2022-03-01 12:36:46', '2022-03-01 12:36:44'),
(15, 'ช่างหลัน', 'lun', NULL, 0, 1, 'uploads/tech/15/signature/15_sig.png', '2022-03-01 12:37:08', '2022-03-01 12:37:07'),
(16, 'ช่างต้อม', 'tom', NULL, 0, 1, 'uploads/tech/16/signature/16_sig.png', '2022-03-01 12:37:29', '2022-03-01 12:37:28'),
(17, 'ช่างโชค', 'chok', NULL, 0, 1, 'uploads/tech/17/signature/17_sig.png', '2022-03-01 12:37:50', '2022-03-01 12:37:48'),
(18, 'ช่างมัส', 'mas', NULL, 0, 1, 'uploads/tech/18/signature/18_sig.png', '2022-03-01 14:37:29', '2022-03-01 14:37:28'),
(19, 'ช่างกวาง', 'kwang', NULL, 0, 1, 'uploads/tech/19/signature/19_sig.png', '2022-03-01 14:37:45', '2022-03-01 14:37:44'),
(20, 'ช่างใหม่', 'mai', NULL, 0, 1, 'uploads/tech/20/signature/20_sig.png', '2022-03-16 12:57:17', '2022-03-16 12:47:33'),
(21, 'ttb-Technician', 'ttb-Technician', 30, 0, 1, 'tech/21/signature/21_sig.png', '2022-08-29 17:21:10', '2022-08-29 17:21:09'),
(22, 'ปรัชญา ภมรสุขนิรันดิ์', 'PRACHAYA P', 15, 0, 1, 'tech/22/signature/22_sig.jpg', '2022-09-07 16:32:32', '2022-09-07 16:32:32'),
(23, 'อันดามัน มาศเมฆ', 'Andaman Masmek', 33, 0, 1, 'tech/23/signature/23_sig.png', '2022-09-07 17:05:49', '2022-09-07 16:38:03'),
(24, 'จีรศักดิ์ ชาสุรีย์', 'Jeerasak Chasuree', 31, 0, 1, 'tech/24/signature/24_sig.jpg', '2022-09-07 17:09:16', '2022-09-07 17:00:29'),
(25, 'ตี๋เอง', 'AEB', 37, 0, 1, 'tech/25/signature/25_sig.png', '2022-09-20 16:28:46', '2022-09-07 17:03:30'),
(26, 'ปลายเขตต์ พูลสวัสดิ์', 'Plykhet Poolsawat', 38, 0, 1, 'tech/26/signature/26_sig.png', '2022-09-22 16:27:34', '2022-09-07 17:05:13'),
(27, 'จิรายุส รักษาล้ำ', 'Jirayut Raksalam', 40, 0, 1, 'tech/27/signature/27_sig.jpg', '2022-09-07 17:09:29', '2022-09-07 17:06:51'),
(28, 'ธีรพล ชูช่วย', 'theerapon chuchuay', 39, 0, 1, 'tech/28/signature/28_sig.jpg', '2022-09-07 17:13:58', '2022-09-07 17:11:52'),
(29, 'ธรรณธร เจือจันทร์', 'THANNATHON CHUEACHAN', 34, 0, 1, 'tech/29/signature/29_sig.jpg', '2022-09-07 17:16:20', '2022-09-07 17:16:20'),
(30, 'รอซซาลัน ยีละงู', 'Rossalan yeelangu', 35, 0, 1, 'tech/30/signature/30_sig.png', '2022-09-07 17:26:20', '2022-09-07 17:26:20'),
(31, 'บรรพต กูจาง', 'banphod kuchang', 36, 0, 1, 'tech/31/signature/31_sig.jpg', '2022-09-07 17:41:37', '2022-09-07 17:30:02'),
(32, 'ภานุวันฒน์ กัสนุกา', 'Mr.Phanuwat Kussanuka', 22, 0, 1, 'tech/32/signature/32_sig.png', '2022-09-08 11:06:34', '2022-09-08 11:05:41'),
(33, 'มงคลพันธุ์ พิมพ์หล่อ', 'MONGKHONPHAN PHIMLO', 23, 0, 1, 'tech/33/signature/33_sig.jpg', '2022-09-10 11:21:40', '2022-09-10 11:21:40'),
(34, 'dd', 'dd', 36, 0, 0, 'tech/34/signature/34_sig.jpg', '2023-01-03 16:42:50', '2022-10-19 11:05:27'),
(35, 'เอกวิทย์ บรรเลง', 'Aekkawit Bunleng', 36, 0, 1, 'tech/35/signature/35_sig.jpg', '2022-12-29 10:49:21', '2022-12-29 10:49:21'),
(36, 'banphod', 'ล้อเทียน', 36, 0, 1, 'tech/36/signature/36_sig.jpg', '2023-01-03 16:43:29', '2023-01-03 16:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `tents`
--

CREATE TABLE `tents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tax_id` varchar(13) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `districts` int(11) DEFAULT NULL,
  `amphures` int(11) DEFAULT NULL,
  `provinces` int(11) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL COMMENT 'รหัสไปษณีย์',
  `map` text DEFAULT NULL,
  `tel_main` varchar(255) DEFAULT NULL,
  `tel_more` varchar(255) DEFAULT NULL,
  `contract_main` varchar(255) DEFAULT NULL,
  `contract_more` varchar(255) DEFAULT NULL,
  `tent_status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'theme options' CHECK (json_valid(`options`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tents`
--

INSERT INTO `tents` (`id`, `tax_id`, `company_name`, `address`, `districts`, `amphures`, `provinces`, `postalcode`, `map`, `tel_main`, `tel_more`, `contract_main`, `contract_more`, `tent_status`, `created_at`, `updated_at`, `options`) VALUES
(1, NULL, 'Orico', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(2, NULL, 'Mighty', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(3, NULL, 'Auto League', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(4, NULL, '29 Auto Mobile', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(5, NULL, '54 นิวัฒน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(6, NULL, '786 ยนตรกิจ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(7, NULL, '84 CarCenter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(8, NULL, 'A.R Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(9, NULL, 'AK Carcenter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(10, NULL, 'Asap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(11, NULL, 'Banana พระราม2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(12, NULL, 'BB Smart Car (สาขา 5)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(13, NULL, 'BB Smart Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(14, NULL, 'BEST SERVICE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(15, NULL, 'Big Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(16, NULL, 'BK ภูเก็ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(17, NULL, 'Boy Auto Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(18, NULL, 'Breton Sure', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(19, NULL, 'Car 2 Hand / คาร์คาเฟ่', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(20, NULL, 'DD AUTO 1999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(21, NULL, 'DDS/ดวงดีศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(22, NULL, 'DS ยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(23, NULL, 'Eddy Smart Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(24, NULL, 'Exclusive Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(25, NULL, 'J Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(26, NULL, 'K Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(27, NULL, 'K&N Auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(28, NULL, 'Ks speed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(29, NULL, 'LK.AUTO TREAD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(30, NULL, 'MPV', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(31, NULL, 'Mccoy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(32, NULL, 'MG Good Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(33, NULL, 'ไมค์คาร์ (คาร์เซ็นเตอร์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(34, NULL, 'N&B Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(35, NULL, 'NBP Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(36, NULL, 'Nitinan Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(37, NULL, 'NL Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(38, NULL, 'N Auto Villa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(39, NULL, 'Oat-Art Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(40, NULL, 'Open Road', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(41, NULL, 'Perfect Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(42, NULL, 'PPK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(43, NULL, 'PR Carcenter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(44, NULL, 'PRM  (นิว.พีอาร์เอ็ม)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(45, NULL, 'โรจนะ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(46, NULL, 'SCC Motor (สระแก้ว)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(47, NULL, 'Sia Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(48, NULL, 'SK Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(49, NULL, 'Sumo Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(50, NULL, 'Sure Moter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(51, NULL, 'TR Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(52, NULL, 'Theerawut Auto Sale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(53, NULL, 'Toyota Sure (Big A อุบล)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(54, NULL, 'TPM Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(55, NULL, 'TTT Used Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(56, NULL, 'Unicorn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(57, NULL, 'Unique', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(58, NULL, 'วี ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(59, NULL, 'V Auto House', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(60, NULL, 'VM รัตนยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(61, NULL, 'W auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(62, NULL, 'Zunn Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(63, NULL, 'เก่งพระราม 9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(64, NULL, 'เจ้โบ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(65, NULL, 'เดียวสมาร์ทคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(66, NULL, 'เพชรยนต์ (3 สาขา)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(67, NULL, 'เมืองชลยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(68, NULL, 'เสรีไทย รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(69, NULL, 'เอ็นนาญ กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(70, NULL, 'แนท รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(71, NULL, 'แหลมเจริญยนต์อุบล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(72, NULL, 'โยรัชดา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(73, NULL, 'โอเค คาร์ เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(74, NULL, 'ใหญ่ยนต์เซอร์วิส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(75, NULL, 'ไปรท์รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(76, NULL, 'กฤษฎา กู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(77, NULL, 'กวงเส็ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(78, NULL, 'ก้องเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(79, NULL, 'Gorilla Car / กอริลล่า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(80, NULL, 'ก้านเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(81, NULL, 'กิจรุ่งโรจน์ (เจริญยนต์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(82, NULL, 'กิจรุ่งโรจน์ (ธุรกิจ)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(83, NULL, 'ครอบครัว ออลคัฟเวอร์ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(84, NULL, 'คิงคอง บิ๊กคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(85, NULL, 'เจริญยานยนต์ (ภูเก็ต)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(86, NULL, 'จ่าเจต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(87, NULL, 'จีระศักดิ์ ยนตรกิจ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(88, NULL, 'ชมรมใต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(89, NULL, 'ชมรมปทุมธานี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(90, NULL, 'ชมรมมีนบุรี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(91, NULL, 'ชมรมลาดปลาเค้า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(92, NULL, 'ชาลี คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(93, NULL, 'ดีว่าคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(94, NULL, 'ดีที่สุด คาร์ (สระแก้ว)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(95, NULL, 'ตันน้ำรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(96, NULL, 'ตั้ม พีพีคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(97, NULL, 'ตี๋ย์รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(98, NULL, 'ตุ้มยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(99, NULL, 'นพดล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(100, NULL, 'นภัทร รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(101, NULL, 'นิลมิตรมอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(102, NULL, 'บจก. กิจรุ่งโรจน์ ธุรกิจ (สุพรรณ)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(103, NULL, 'บอย รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(104, NULL, 'บุเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(105, NULL, 'ป.รุ่งเรือง ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(106, NULL, 'ปฎิพัทธ์ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(107, NULL, 'ป.ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(108, NULL, 'พิพัฒน์ คาร์ เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(109, NULL, 'พูลผล คาร์เซ็นเตอร์ (786)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(110, NULL, 'มงคล คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(111, NULL, 'มังกร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(112, NULL, 'มังกร (โนนสูง)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(113, NULL, 'มังกร (ดงลิง)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(114, NULL, 'มังกร (นาดี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(115, NULL, 'มาจากเว็บขายดี...มงคล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(116, NULL, 'มาริโอ้ มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(117, NULL, 'ยนตรกาญ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(118, NULL, 'ยุทธดีเวอร์ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(119, NULL, 'รถดีเดย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(120, NULL, 'รถบ้าน คุณเอ็กซ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(121, NULL, 'รถบ้าน น้องปาย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(122, NULL, 'รถบ้าน ภูมิเจริญ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(123, NULL, 'รถบ้าน ศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(124, NULL, 'รถบ้าน สุขุมวิท', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(125, NULL, '999 รถบ้านสุวิทย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(126, NULL, 'ร้านพระบาทยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(127, NULL, 'Regent Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(128, NULL, 'รุ่งคลองสามรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(129, NULL, 'วชิระยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(130, NULL, 'วรชัย คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(131, NULL, 'วิชุดาสุวรรณภูมิ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(132, NULL, 'ศักดิ์สยาม คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(133, NULL, 'สหยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(134, NULL, 'สูงเนินรวมรถ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(135, NULL, 'หจก.ดีเอสยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(136, NULL, 'หนุ่มอุบลคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(137, NULL, 'หรั่งคูคตรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(138, NULL, 'อ๊อกเลต ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(139, NULL, 'อาร์ตี้ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(140, NULL, 'เปาอินทร์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(141, NULL, 'ราชประดิษฐ์ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(142, NULL, 'ดีเดย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(143, NULL, 'S&W car center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(144, NULL, 'Cooper Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(145, NULL, 'ดูคาร์ มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(146, NULL, 'Kinetic Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(147, NULL, 'NIG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(148, NULL, 'เสน่ห์ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(149, NULL, 'ขงเบ้ง (S.P)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(150, NULL, 'ธนาเดช ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(151, NULL, 'ภูมิเจริญ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(152, NULL, 'รุ่งนิรันดร์ กลการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(153, NULL, 'ล้ำเลิศคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(154, NULL, 'อาร์ต คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(155, NULL, 'บีทีออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(156, NULL, 'I Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(157, NULL, 'The One', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(158, NULL, 'Standard Autocar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(159, NULL, 'นาเดียรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(160, NULL, 'ลาดปลาเค้า (ทีมไทยแลนด์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(161, NULL, 'SWN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(162, NULL, 'Um Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(163, NULL, 'Toyota Sure (ดีเยี่ยมชัวร์ยูสคาร์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(164, NULL, 'คาร์ คาเฟ่', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(165, NULL, 'ทัดยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(166, NULL, 'บิวทูคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(167, NULL, 'RB64 รถบ้านเสรีไทย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(168, NULL, 'สามเหลี่ยม ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(169, NULL, 'เก่งสามพราน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(170, NULL, '2B Millemium', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(171, NULL, 'ไมค์คาร์ (แกลเลอรี่)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(172, NULL, '1112 Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(173, NULL, 'AM 789 มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(174, NULL, 'สมยงค์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(175, NULL, 'ตันมะขาม ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(176, NULL, 'สมชาย (คาร์เซ็นเตอร์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(177, NULL, 'เอสซี ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(178, NULL, 'Panda Speed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(179, NULL, 'P.I. Quality Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(180, NULL, 'Auto Perfecr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(181, NULL, 'Chev Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(182, NULL, 'สมชาย ออโต้คาร์/อายคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(183, NULL, '999 Smart Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(184, NULL, 'หนุ่ย โกเด้นท์คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(185, NULL, 'สุวรรณโณ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(186, NULL, 'เอกภพ คาร์ กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(187, NULL, 'SC Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(188, NULL, 'ดีพรรณรัตน์ 1999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(189, NULL, 'แจ็คยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(190, NULL, 'รถบ้าน เที่ยงธรรม', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(191, NULL, 'เชฟ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(192, NULL, 'เวอริฟาย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(193, NULL, 'นิตินันท์ โฮมคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(194, NULL, 'หนุ่ยโกลเด้นคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(195, NULL, 'ลดาวัลย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(196, NULL, 'รถบ้าน คุณป๊อบ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(197, NULL, 'TOP ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(198, NULL, 'BT Auto Speed Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(199, NULL, 'รถบ้าน สมชาย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(200, NULL, 'พงษ์นิเวศน์ กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(201, NULL, 'สิงโต กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(202, NULL, 'ราชพฤกษ์ พี คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(203, NULL, 'C Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(204, NULL, 'พระบาทยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(205, NULL, 'JIB Auto Car (สาขาใหญ่ ชลบุรี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(206, NULL, 'The W Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(207, NULL, 'โจ๊ก ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(208, NULL, 'Benz A8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(209, NULL, 'กรุงไทย ออโต้ลีส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(210, NULL, 'นครสวรรค์ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(211, NULL, 'แนชรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(212, NULL, 'ติ่งลี่ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(213, NULL, 'เสรีไทย กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(214, NULL, 'AR Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(215, NULL, 'PS อ่างศิลา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(216, NULL, 'VKK Use Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(217, NULL, 'My Best Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(218, NULL, '300 Garage Life', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(219, NULL, 'รถบ้าน วิทยายานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(220, NULL, 'คูเปอร์ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(221, NULL, '69 Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(222, NULL, 'PS Auto By คุณแพรว', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(223, NULL, 'PS Auto By คุณจ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(224, NULL, 'เบนซ์ 88 ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(225, NULL, 'รัตน์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(226, NULL, 'เพียวคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(227, NULL, 'อินฟินิท ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(228, NULL, 'อาย คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(229, '1', '2002 ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(230, NULL, 'รถบ้านสุวิทย์ ถูกและดี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(231, NULL, 'PB Used Cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(232, NULL, 'Daddy Good Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(233, NULL, 'รถบ้าน อินเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(234, NULL, 'Ms Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(235, '0105560073678', 'Wsmart', '1122 อาคารวสุธากรุ๊ป ถนน พระราม 9 แขวง สวนหลวง เขตสวนหลวง กรุงเทพมหานคร 10250', NULL, 18, 1, NULL, NULL, '020571234', '0651191111', 'Wsmart Call center', 'คุณออฟ', 1, '2021-03-25 09:52:55', '2022-05-27 00:55:56', NULL),
(236, NULL, 'Trusty (สาขา กรุงเทพ)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(237, NULL, 'MEC Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(238, NULL, 'ลัคกี้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(239, NULL, 'K&T AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(240, NULL, 'BB Smart Car (สาขา 1)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(241, NULL, 'BB Smart Car (สาขา 2)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(242, NULL, 'BB Smart Car (สาขา 3)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(243, NULL, 'BB Smart Car (สาขา 4)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(244, NULL, 'เพชรยนต์ (สาขา 1)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(245, NULL, 'เพชรยนต์ (สาขา 2)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(246, NULL, 'เพชรยนต์ (สาขา 3)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(247, NULL, 'รถบ้าน สมชาย (มีนบุรี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(248, NULL, 'คิเนติ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(249, NULL, 'ตั้ม พีพีคาร์ (สาขา 3)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(250, NULL, 'ตั้ม พีพีคาร์ (สาขา 2)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(251, NULL, 'ตั้ม พีพีคาร์ (สาขา 1)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(252, NULL, 'TJ Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(253, NULL, 'ไลอ้อน คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(254, NULL, 'ชินพัฒน์รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(255, NULL, 'โอ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(256, NULL, 'ตั้ม พีพีคาร์ (สาขา 4)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(257, NULL, 'โต รถดี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(258, NULL, 'เด่น ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(259, NULL, 'ตั้ม พีพีคาร์ (สาขา 5)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(260, NULL, 'วาสนา ยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(261, NULL, 'JIB Auto Car (บ้านบึง)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(262, NULL, 'พงศกร กู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(263, NULL, 'หนุ่ย ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(264, NULL, '19 โพธิ์ศรีทอง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(265, NULL, 'Chon Good Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(266, NULL, 'PR Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(267, NULL, 'มังกร (พัทยา)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(268, NULL, 'Trusty (สาขา โคราช)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(269, NULL, 'TWIN AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(270, NULL, 'C Home Car (สาขา 1) หนองมน-บางแสน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(271, NULL, 'C Home Car (สาขา 2) เครือสหพัฒน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(272, NULL, 'C Home Car (สาขา 3) อมตะนคร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(273, NULL, 'C Home Car (สาขา 4) ร้านแม็คยาง&#8203; เครือสหพัฒน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(274, NULL, 'C Home Car (สาขา 5) นาป่า-สุขประยูร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(275, NULL, 'ดารา ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(276, NULL, 'มังกร (รถหรู)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(277, NULL, 'ลาดปลาเค้า (คลองหลวง)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(278, NULL, '999รถบ้านสุวิทย์ (สาขา 2) เทพารักษ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(279, NULL, 'PM Car Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(280, NULL, '999รถบ้านสุวิทย์ (สาขา 3) พัฒนาการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(281, NULL, '999รถบ้านสุวิทย์ (สาขา 1) ศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(282, NULL, 'House Of Cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(283, NULL, 'ดา ศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(284, NULL, 'DSK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(285, NULL, 'X Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(286, NULL, '555 Auto Garage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(287, NULL, 'รวยสมบัติ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(288, NULL, 'เค มอเตอร์เซลล์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(289, NULL, 'Yes Car Outlet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(290, NULL, 'โอ ออโต้คาร์ (อ๋า ธุรกิจ)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(291, NULL, 'รถบ้าน สุขุมวิท (สาขา 2) สุขุมวิท 105', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(292, NULL, 'Nc Autos Trade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(293, NULL, 'Sv Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(294, NULL, 'ภัทรวิทย์ ออโต้ (999รถบ้านสุวิทย์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(295, NULL, 'เต็นท์ออนไลน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(296, NULL, 'SP Home Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(297, NULL, 'หมูป่า คิงดอม', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(298, NULL, 'เพ้ง101 (สาขา 1)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(299, NULL, 'เพ้ง101 (สาขา 2)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(300, NULL, '999รถบ้านสุวิทย์ (บางปลา)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(301, NULL, 'อาม่า รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(302, NULL, 'ภัทระ ลิสซิ่ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(303, NULL, 'CIMB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(304, NULL, 'แก้ว ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(305, NULL, 'แสงอรุณ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(306, NULL, 'เอพลัส ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(307, NULL, 'เอ็นคาร์ปาร์ค', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(308, NULL, 'DK คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(309, NULL, 'PP Car Quality', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(310, NULL, 'BP and family', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(311, NULL, 'รุ่งเรืองรถยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(312, NULL, 'แชมป์รถบ้านดอนเมือง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(313, NULL, 'เอ็นที รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(314, NULL, 'แชมป์ ออโต้ รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(315, NULL, 'ซุปเปอพี 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(316, NULL, 'Racing Station รถมือสอง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(317, NULL, 'ธาวิท ออโต่คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(318, NULL, 'แม็ก กู๊ด คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(319, NULL, 'สุราษฏร์รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(320, NULL, 'ยศฐวัช (ACN ยูสคาร์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(321, NULL, 'ไมค์ กู๊ดคาร์ 999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(322, NULL, 'เบสท์ คาร์ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(323, NULL, 'ศูนย์รวมรถบ้านรามอินทราซอย5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(324, NULL, 'เพอร์เฟ็ค คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(325, NULL, 'เอก ออโต้ คาร์ เทรดดิ้ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(326, NULL, 'มากมี ออลคาร์ เซอร์วิส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:55', '2021-03-25 09:52:55', NULL),
(327, NULL, 'มาวินออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(328, NULL, 'โอ๊ด อาร์ต โฮมคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(329, NULL, 'สหยนต์ 777', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(330, NULL, 'กิจรุ่งโรจน์&#8203;ธุรกิจ&#8203;', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(331, NULL, 'เอ็ม.พี.วี. ออโต้เซลส์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(332, NULL, 'จีระศักดิ์ ยนตรกิจ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(333, NULL, 'อโยธยา ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(334, NULL, 'ฉัตรชัย กู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(335, NULL, 'รถบ้านคุณฉัตรชัย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(336, NULL, 'เฉลิมชัยคาร์เซ็นเตอร์ (เฉลิมชัยรถบ้าน)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(337, NULL, 'เชียร์ ออโต้ ควอลิตี้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(338, NULL, 'รุ่งเรืองรถยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(339, NULL, 'ต๋องอินเตอร์คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(340, NULL, 'ชัยชนะยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(341, NULL, 'ก้องยนต์ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(342, NULL, 'เอส ซี ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(343, NULL, 'ชีวา โฮม คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(344, NULL, 'NC Autocar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL);
INSERT INTO `tents` (`id`, `tax_id`, `company_name`, `address`, `districts`, `amphures`, `provinces`, `postalcode`, `map`, `tel_main`, `tel_more`, `contract_main`, `contract_more`, `tent_status`, `created_at`, `updated_at`, `options`) VALUES
(345, NULL, 'Easy Usedcar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(346, NULL, 'เอ็ม ซี เก้าเก้าเก้า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(347, NULL, 'รถบ้านโชคยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(348, NULL, 'BENZ MOTOR MALL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(349, NULL, 'Big Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(350, NULL, 'JW SmartCar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(351, NULL, 'เอ.พี.ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(352, NULL, 'นายรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(353, NULL, 'ธนดล ยูสคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(354, NULL, '59 Autodrive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(355, NULL, 'NP AUTO TRADE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(356, NULL, 'มิกกี้ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(357, NULL, 'ดวงใจ เอส.บี.คาร์ เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(358, NULL, 'ซี.เค.ออโตเซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(359, NULL, 'โตโยต้า พาราก้อน ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(360, NULL, 'ดีดีออโต้ 1999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(361, NULL, 'ภาษาเก๋ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(362, NULL, 'เอ็มอีซี ออโต้ เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(363, NULL, 'ทีที สมาย คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(364, NULL, 'บจก.สมโภชน์กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(365, NULL, 'ติงลี้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(366, NULL, 'คาร์ทูแฮนด์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(367, NULL, 'บ้านรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(368, NULL, 'ดี 12 ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(369, NULL, 'เดียว สมาร์ทคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(370, NULL, 'C&C Autoland', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(371, NULL, 'ณัฎฐา ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(372, NULL, 'Car On Earth', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(373, NULL, 'เค.บี.ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(374, NULL, 'เอทีเอ็มกู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(375, NULL, 'ดียนต์กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(376, NULL, 'D CAR CONNER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(377, NULL, 'THE ONE USED CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(378, NULL, 'เจริญสินออโต้ลิสซิ่ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(379, NULL, 'เวอริฟาย ออโต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(380, NULL, 'โอเค ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(381, NULL, 'GKO Auto Prime', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(382, NULL, 'เบนอมรรัชดา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(383, NULL, '3 โชกุน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(384, NULL, 'Car Avenue Plus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(385, NULL, 'เรน Monkey car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(386, NULL, 'สายฟ้ารถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(387, NULL, 'เอื้อง79', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(388, NULL, 'ราชประดิษฐ์ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(389, NULL, 'ปกรณ์ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(390, NULL, 'นภัทร รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(391, NULL, 'The One', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(392, NULL, 'วีออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(393, NULL, 'อยุธยา พรีเมี่ยมคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(394, NULL, 'กฤตออโต้เซ็นเตอร์ (รถบ้านพนาสนธิ์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(395, NULL, 'ศรีรุ่งคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(396, NULL, 'เอ.บี.พรีเมี่ยมกรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(397, NULL, 'ปุ๋มรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(398, NULL, 'หงส์ประสิทธิ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(399, NULL, 'แจ๊ค', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(400, NULL, 'กิจรุ่งโรจน์เจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(401, NULL, 'Maximum Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(402, NULL, 'เดียร์คาร์เซ็นเตอร์68', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(403, NULL, 'กอล์ฟ ธุรกิจยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(404, NULL, 'จักรพันธ์รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(405, NULL, 'กัลปพฤกษ์ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(406, NULL, 'อ้วนยูสคาร์54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(407, NULL, '29 Autorace', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(408, NULL, 'LALINN AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(409, NULL, 'อั่งเปา คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(410, NULL, 'ซีเอสออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(411, NULL, 'B1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(412, NULL, 'สุรชัย CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(413, NULL, 'ชาตรี Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(414, NULL, 'พร้อมทรัพย์ ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(415, NULL, 'CH Auto cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(416, NULL, 'Pretty Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(417, NULL, 'แก่นยงค์เซอร์วิส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(418, NULL, 'U&I Carcenter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(419, NULL, 'มิตรคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(420, NULL, '4 ดี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(421, NULL, 'ทรัพย์บุญแสง ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(422, NULL, 'เค ออโต้ คาร์ (พีอาร์ ออโต้คาร์)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(423, NULL, 'KP Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(424, NULL, 'ร่มเกล้า กู๊ด คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(425, NULL, 'A Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(426, NULL, 'เชียงใหม่อัษฎาธร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(427, NULL, 'บางอ้อคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(428, NULL, 'กิจเจริญรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(429, NULL, 'โจโจ้แอน คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(430, NULL, 'ศูนย์รวมรถยนต์เอเชีย (ASIA CAR CENTER)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(431, NULL, 'DK SMART CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(432, NULL, 'ใหญ่ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(433, NULL, 'เบนซ์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(434, NULL, 'เอ็กซ์เพรส ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(435, NULL, 'เอ็มอีซี ออโต้ชลบุรี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(436, NULL, 'บารมีรักษา โย่งรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(437, NULL, 'หกสองการาจ&#8203; (62 GARAGE)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(438, NULL, 'เอ.ที. คาร์เซลส์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(439, NULL, 'ดาราออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(440, NULL, 'ศรียาภัยยิ่งเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(441, NULL, 'ปูรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(442, NULL, 'ศุภนิต คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(443, NULL, 'ภวัต ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(444, NULL, 'สี่สิบห้าคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(445, NULL, 'เอสซีซี สระแก้ว มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(446, NULL, 'BIGAPPLE CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(447, NULL, 'รีเจ้นท์โฮม คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(448, NULL, 'รถบ้านสหยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(449, NULL, 'เจียรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(450, NULL, 'Tom auto air (Panasonic Shop)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(451, NULL, 'หนุ่มอุบล คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(452, NULL, 'ทรูออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(453, NULL, 'ดับบลิว ซีเอส คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(454, NULL, 'สุราษฎร์ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(455, NULL, 'ช่างดำครบุรี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(456, NULL, 'ดับเบิ้ลยู ยูสด์คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(457, NULL, 'ดีเดย์ ยานยนต์ชนชาวไทย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(458, NULL, 'โตโยต้า ชัวร์ สุรินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(459, NULL, 'สองพี่น้องรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(460, NULL, 'วชิระยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(461, NULL, 'ธวัชชัยยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(462, NULL, 'TIP Motor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(463, NULL, 'รันนิ่ง ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(464, NULL, 'ชัยคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(465, NULL, 'วี 88 เอส.เค', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(466, NULL, 'โอเคคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(467, NULL, 'วิทยายนตรการ (วิทยารถบ้าน)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(468, NULL, 'TJ SMART CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(469, NULL, 'โต ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(470, NULL, 'ธนากรดีลลิ่งคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(471, NULL, 'LEK AUTO CARS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(472, NULL, 'วิสาร ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(473, NULL, 'เพิ่มพูลคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(474, NULL, 'บอย ราชารถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(475, NULL, 'P.R.M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(476, NULL, 'สตาร์คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(477, NULL, 'ฮีโร่ ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(478, NULL, 'นิลมิตร มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(479, NULL, 'สันติรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(480, NULL, 'Sunny Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(481, NULL, 'บีเจ ออโต้ สปอร์ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(482, NULL, 'GM Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(483, NULL, '9 Perfect car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(484, NULL, '2P AUTO CARS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(485, NULL, 'พรีเมี่ยม ยูสคาร์ อุดรธานี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(486, NULL, 'มันนี่โกลด์ มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(487, NULL, 'JM Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(488, NULL, 'เศรษฐ์สัณห์เจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(489, NULL, 'เจมส์รถสวย-หมวยรถซิ่ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(490, NULL, 'รถบ้านเลขที่ 9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(491, NULL, '59Auto Car Gallery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(492, NULL, 'แอล สมาทคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(493, NULL, 'พญาแลยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(494, NULL, 'ศรีทองออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(495, NULL, 'สมบัติยนตรการสุรินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(496, NULL, 'KR AUTO CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(497, NULL, 'สมยศ ยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(498, NULL, 'เคเอสบี ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(499, NULL, 'รถบ้านอินดี้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(500, NULL, 'คาร์คอนเนอร์ & เอเอฟ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(501, NULL, 'PK Smart Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(502, NULL, 'Sm Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(503, NULL, 'โจ๊ก ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(504, NULL, 'สมานชัยมอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(505, NULL, 'โอปอลคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(506, NULL, 'ทีพีเอ อินเตอร์ เทรด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(507, NULL, 'NEED CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(508, NULL, 'Exchange Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(509, NULL, 'บ้านโพนมอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(510, NULL, 'ยนตรกาญ ยูสคาร์ กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(511, NULL, '395 สุขเสริมทรัพย์ (AR.AUTOCARS)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(512, NULL, 'เสมคำรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(513, NULL, 'สามารถคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(514, NULL, '32 Auto Cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(515, NULL, 'รถดีขับสบาย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(516, NULL, 'พีดี คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(517, NULL, 'รถบ้านอินเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(518, NULL, 'เอ ดี มอเตอร์สปอร์ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(519, NULL, 'ดีดี ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(520, NULL, 'ลีลา คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(521, NULL, 'T.S. CARSENTER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(522, NULL, 'อิทธิกร 61', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(523, NULL, 'ดี พรรณรัตน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(524, NULL, 'โตโยต้าชัวร์ดีเยี่ยม', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(525, NULL, 'โตโยต้าบัสส์ สาขาที่ 00012(รัชดา)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(526, NULL, 'เอ็น.บี.พี. ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(527, NULL, 'บางใหญ่ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(528, NULL, 'วิกรมยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(529, NULL, 'KTP&#8203; Srinakarin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(530, NULL, '7auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(531, NULL, 'ธัญญเจริญ 59 (เสน่ห์รถบ้าน)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(532, NULL, 'นำสินรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(533, NULL, 'ยิ่งเจริญคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(534, NULL, 'เจเอพี ออโต้คาร์ (JAP AUTOCAR)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(535, NULL, 'ขุมทรัพย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(536, NULL, 'ไอ ออโต้เซลส์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(537, NULL, 'บีบี ยูสคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(538, NULL, 'ภูมิเจริญวังสามหมอ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(539, NULL, 'เจ มอเตอร์ เทรด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(540, NULL, 'คิระ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(541, NULL, 'ต.อินเตอร์คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(542, NULL, 'หจก.ปิ่นวิชย์กุล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(543, NULL, 'วุฒิ รถซิ่ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(544, NULL, 'รถบ้านสวย เทพารักษ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(545, NULL, 'wutrewadee auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(546, NULL, 'GUN2Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(547, NULL, 'เต้นท์ ศรชัย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(548, NULL, 'เต้นท์ศรีเนตร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(549, NULL, 'รถบ้านนิลคูหา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(550, NULL, 'A3 ตลาดรถยนต์ศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(551, NULL, 'เต้นวัชรศักดิ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(552, NULL, 'พรสมใจ ออโต้ จรเข้สามพัน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(553, NULL, 'กิตติออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(554, NULL, 'Hi Light Car Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(555, NULL, 'รพิรัตร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(556, NULL, '22 Auto Trade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(557, NULL, 'เต้นท์เกษม', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(558, NULL, 'เต้นท์สมคิด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(559, NULL, 'บริษัท กฤษฏ์ ออโต้ ริช', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(560, NULL, 'CHE used cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(561, NULL, '77 Auto used car ออโต้ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(562, NULL, 'TPA IN TERD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(563, NULL, 'กรกต มอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(564, NULL, 'KCS AUTO CARS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(565, NULL, 'บริษัท กรุงไทยออโต้ลีส จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(566, NULL, 'เต้นธนสาร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(567, NULL, 'นิวยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(568, NULL, 'SunMotor ซันมอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(569, NULL, 'CAR STATION', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(570, NULL, 'เอส.พี.เซ็นเตอร์คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(571, NULL, 'Doyo Auto Cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(572, NULL, 'เต๊นท์กำธร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(573, NULL, 'เต้นท์ กิตติศักดิ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(574, NULL, 'กฤษดา คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(575, NULL, 'เฮงเฮงเฮง2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(576, NULL, 'เต้นท์สมบูรณ์ยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(577, NULL, 'P.P. Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(578, NULL, 'DJM Carland Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(579, NULL, 'G2car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(580, NULL, 'แก้วอนงค์ กลการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(581, NULL, 'โกเกี้ย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(582, NULL, 'โก้ไก่', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(583, NULL, 'กิจเจริญยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(584, NULL, 'ตลาดรถ OK เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(585, NULL, 'Car factory Outlet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(586, NULL, 'รถบ้านคาร์ทูไดรว์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(587, NULL, '999 MOTOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(588, NULL, 'เบสท์คาร์ ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(589, NULL, 'รวมรถดี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(590, NULL, 'Bestcar (CartoSale)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(591, NULL, 'ห้างหุ้นส่วนจำกัด ดียนต์กรุ๊ป', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(592, NULL, '111 รถบ้านสวยจัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(593, NULL, 'ไฮไลท์ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(594, NULL, 'Auto Delight Co.,Ltd.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(595, NULL, 'จักรพรรดิ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(596, NULL, 'รวมรถดี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(597, NULL, 'MMS ออโต้เซลล์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(598, NULL, 'พูนทวี ออโต้พลัส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(599, NULL, 'PK AUTO-TRADE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(600, NULL, 'B2K', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(601, NULL, 'เต้นท์ เกต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(602, NULL, 'เกริกไกรคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(603, NULL, 'ภาทรัพย์เจริญ อุดรธานี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(604, NULL, 'ยูโด ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(605, NULL, 'Car Avenue ศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(606, NULL, 'click car center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(607, NULL, 'สิริ ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(608, NULL, 'LJ ธุรกิจยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(609, NULL, 'Strade69 จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(610, NULL, 'รถบ้านกาแฟสด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(611, NULL, 'เมืองใหม่รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(612, NULL, 'เต้นท์จารุวัฒน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(613, NULL, 'เล้งออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(614, NULL, 'โชคดี ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(615, NULL, 'Jing nascar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(616, NULL, 'สุพจน์มอเตอร์เซลล์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(617, NULL, 'เทพกษัตรีคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(618, NULL, 'เต้นท์ จิรายุ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(619, NULL, 'OK GOOD CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(620, NULL, 'บ.จีระศักดิ์ยนตร์กิจจำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(621, NULL, 'พยุหะคีรี นครสวรรค์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(622, NULL, 'JJ Auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(623, NULL, 'เต้นท์ แจ๊ค', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(624, NULL, 'เต็นท์ พ่อโจรถบ้านอุดร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(625, NULL, 'เชียงรายยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(626, NULL, 'ตุนกะตังนิว บางกอก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(627, NULL, 'ศรีรุ่งคาร์เซนเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(628, NULL, 'สรศักร์ คาร์ คอมเมอร์เชียล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(629, NULL, 'TK LUXKY CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(630, NULL, 'สมโภชน์คาร์เซ็นเตอร์(อุดรธานี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(631, NULL, 'รถบ้านAA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(632, NULL, 'เต้นสีแยกโองการโทรศัพท์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(633, NULL, 'พี่น้องยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(634, NULL, 'J.P เจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(635, NULL, 'รถบ้านสวนหลวง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(636, NULL, 'T.A auto cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(637, NULL, 'B auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(638, NULL, 'พอเพียงออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(639, NULL, 'คิว ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(640, NULL, 'หจก. อมรินทร์มอเตอร์(ปักธงชัย)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(641, NULL, 'ของดีเมืองนนท์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(642, NULL, 'รวมใหม่ โคราช', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(643, NULL, 'เต้นท์ รังสิมา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(644, NULL, 'ยูสมายคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(645, NULL, 'ชวลิตรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(646, NULL, 'เชิดพงษ์ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(647, NULL, 'เต็นท์สุพรรณเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(648, NULL, '2car center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(649, NULL, 'พินิจธรรม ยนตการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(650, NULL, 'คุณสุทัศษา อันลือชัย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(651, NULL, 'TG AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(652, NULL, 'มังกร ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(653, NULL, 'กวักรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(654, NULL, 'เต้นท์ฐิตวัฒน์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(655, NULL, 'หจก.อุดรเจริญบริการ1999 (อุดรธานี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(656, NULL, 'กฤษณออโต้เซล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(657, NULL, 'ดาวทองรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(658, NULL, 'มิตรชัยเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(659, NULL, 'Surasak CAR CENTER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(660, NULL, 'AP AUTO CAR ตลาดรถดีขับสบาย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(661, NULL, 'สมาร์ทฮอนด้า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(662, NULL, 'ศูนย์รถ ดวงดี ศรีภูษิต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(663, NULL, 'ปัณณวัชร์ auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(664, NULL, 'the d used car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(665, NULL, 'โชครถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(666, NULL, 'ท.กลการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(667, NULL, 'MK Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(668, NULL, 'ปอนด์ รถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(669, NULL, 'บริษัท ราชารถตู้ 2002 จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(670, NULL, 'บริษัท ขุนเดชยนตรการ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(671, NULL, 'Siam Motoring', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(672, NULL, 'หจก.แก้ววิเชียร2558 (อุดรธานี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(673, NULL, 'โจโฉรถซิ่ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(674, NULL, '45 car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(675, NULL, 'สามเหลี่ยมคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(676, NULL, 'First Auto Leasing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(677, NULL, 'เต็นท์ 4 D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(678, NULL, 'K2car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(679, NULL, 'เต้นท์ ดับเบิ้ลเอส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(680, NULL, 'เสรียนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(681, NULL, 'บริษัท พรเจริญกลการ จำกัด (อุดรธานี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(682, NULL, 'เต้นป๋าป.รถบ้าน(อุดรธานี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(683, NULL, 'เต็นท์ทุนอิน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(684, NULL, 'พิมพ์พิศารถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(685, NULL, 'บจก.4499 เคเอ็นซี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(686, NULL, 'ออร์ก้า ยูสด์ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL);
INSERT INTO `tents` (`id`, `tax_id`, `company_name`, `address`, `districts`, `amphures`, `provinces`, `postalcode`, `map`, `tel_main`, `tel_more`, `contract_main`, `contract_more`, `tent_status`, `created_at`, `updated_at`, `options`) VALUES
(687, NULL, 'หนุ่มรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(688, NULL, 'ดี.ดี. คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(689, NULL, 'อีซี่คาร์ เทพารักษ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(690, NULL, 'อีซี่คาร์ เทพารักษ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(691, NULL, 'ทีเค ออโต้ คาร์ 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(692, NULL, 'Aop 32 รถงามมาก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(693, NULL, 'เต้นท์ อัจฉรา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(694, NULL, 'คิงคอง กู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(695, NULL, 'อนัญญา ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(696, NULL, 'รถบ้านคุณจุ้ย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(697, NULL, 'เต็นท์ไพโรจน์ยนตรกิจ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(698, NULL, 'City Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(699, NULL, 'เต้นท์ ขุนพล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(700, NULL, 'เกาะแก้ว', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(701, NULL, 'TG Auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(702, NULL, 'SKT autosale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(703, NULL, 'มังกรคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(704, NULL, 'แชมป์รถบ้านดอนเมือง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(705, NULL, 'ทีทีคาร์เชอร์วิท', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(706, NULL, 'โคราช ยูส คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(707, NULL, 'ธนบุรี สมาร์ทคาร์ สาขา2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(708, NULL, '3D Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(709, NULL, 'เต้นท์โชครุ่งเรืองทรัพย์รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(710, NULL, 'ห้างฉัตร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(711, NULL, 'หจก.ทีไซเคิล(อุดรธานี)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(712, NULL, 'เต้นท์รถยนต์ลุงแก้ว', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(713, NULL, 'เต้นท์อนาจักรรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(714, NULL, 'หจก.เอก.พิษณุยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(715, NULL, 'exchang center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(716, NULL, 'GT คาร์ดเซนเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(717, NULL, 'Siamraj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(718, NULL, 'เต้นท์ ปทัย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(719, NULL, 'รถบ้านคุณติ้ก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(720, NULL, 'รถบ้านมหาเฮง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(721, NULL, 'เต้นท์ พี่ๆน้องๆ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(722, NULL, 'Lion Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(723, NULL, 'แดงรถดี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(724, NULL, 'ไพโรจน์ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(725, NULL, 'ตั๊กรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(726, NULL, 'เต๊นท์คาร์พลัส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(727, NULL, 'รัษฎายนต์ ภูเก็ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(728, NULL, 'Toto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(729, NULL, 'หจก.ประภาศิต รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(730, NULL, 'smkautocar ภูเก็ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(731, NULL, 'สกาย ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(732, NULL, 'TT CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(733, NULL, 'เสี่ยทอม เมืองคง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(734, NULL, 'SLออโต้เซนเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(735, NULL, 'ห้างหุ้นส่วนสามัญ ปากน้ำ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(736, NULL, 'NP carstation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(737, NULL, 'เต็นท์โกเปีย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(738, NULL, 'แองเจิ้ล คารท', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(739, NULL, 'นนทบุรีคาร์เซนเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(740, NULL, 'สโมสรรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(741, NULL, 'ตี๋ย์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(742, NULL, 'นัดรถบ้านโคราช', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(743, NULL, 'เต็นท์วิทอินเตอร์เทรด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(744, NULL, 'Tapp Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(745, NULL, 'CC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(746, NULL, 'ยอดเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(747, NULL, 'จิ๋ว ชัวร์ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(748, NULL, 'ลีโอ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(749, NULL, 'VIPAuto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(750, NULL, 'หลี่ธงยนตรการ อุดรธานี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(751, NULL, 'Lek7.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(752, NULL, 'อโยธยา คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(753, NULL, 'เต้นคุณวัลภา ศรีนครินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(754, NULL, 'รถดีออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(755, NULL, 'หจก.ต.เจริญยนต์อุดรธานี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(756, NULL, 'พัณณภา ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(757, NULL, 'บีวัน ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(758, NULL, 'ซีคาร์สเซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(759, NULL, 'นส.รจนา ทองคำ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(760, NULL, 'น.ส. วรรณา ลือบุญ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(761, NULL, 'Pretty2Car พริตตี้ทูคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(762, NULL, 't&t รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(763, NULL, 'กิ่งแก้วมหายนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(764, NULL, 'เต็นท์วันออโต้คาร์&#8203;', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(765, NULL, 'น้าติ สุดทางเทพ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(766, NULL, 'นิวภูเก็ตยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(767, NULL, 'ตั๊้มเรดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(768, NULL, 'TNS AUTOCAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(769, NULL, 'ส.ธนวุธ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(770, NULL, 'บ้านทุมไอโฟนคาร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(771, NULL, 'นาย ณัฐชาคริต พูนเกษ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(772, NULL, 'อมรา คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(773, NULL, 'KSB AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(774, NULL, 'นาย นณกร ศรีธรรม', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(775, NULL, 'กอล์ฟ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(776, NULL, 'พงษ์เจริญบริการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(777, NULL, 'น้อย ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(778, NULL, 'smart car online', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(779, NULL, 'ธนากร คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(780, NULL, 'CNY Auto Import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(781, NULL, 'นุออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(782, NULL, 'นายประพันธ์ เตชะผลาคุณ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(783, NULL, 'เอ็กซ์ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(784, NULL, 'นายวรศักดิ์ ยาวิละ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(785, NULL, 'วีระ โภคะกุล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(786, NULL, 'เอ.ที.ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(787, NULL, 'นาย ศราวุธ ศิริสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(788, NULL, 'นายสถาพร แพ่งสุภา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(789, NULL, 'นายสมบูรณ์ เมฆฉาย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(790, NULL, 'เอสเอสดี คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(791, NULL, 'น้ำทิพย์ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(792, NULL, 'รถบ้านรัชดา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(793, NULL, 'นิพิฐ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(794, NULL, 'Rut auto Zone', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(795, NULL, 'เกรทวัน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(796, NULL, '555', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(797, NULL, 'บวร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(798, NULL, 'เจ้าฟ้ามอเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(799, NULL, 'เค.พีแอลที', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(800, NULL, 'ตลาดรถ99', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(801, NULL, 'เกาะแก้วฝากรถ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(802, NULL, 'CK รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(803, NULL, 'เกรซวัน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(804, NULL, 'แก่นนครคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(805, NULL, 'บิ๊กบอส ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(806, NULL, 'ATS ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(807, NULL, 'อุ้ยออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(808, NULL, 'Car Outlet รามคำแหง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(809, NULL, 'Scan car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(810, NULL, 'บุญทวี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(811, NULL, 'SA.user cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(812, NULL, 'เพชรบางกุ้ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(813, NULL, 'บุญชัย ดีสุข', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(814, NULL, 'อนันต์ ออโตคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(815, NULL, 'วริศยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(816, NULL, 'บุญสม', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(817, NULL, 'ปูมออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(818, NULL, 'ACS Autocar Service', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(819, NULL, 'พัฒนายูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(820, NULL, 'ทรัพย์ทวีรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(821, NULL, 'บ.เต่า ออโต้ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(822, NULL, 'garage 888', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(823, NULL, 'B.Tan.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(824, NULL, 'เต้นท์เจ๊เล๊ก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(825, NULL, 'มดแดง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(826, NULL, 'ประเสริฐ โตจันทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(827, NULL, 'Benzz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(828, NULL, 'บ.บรรพตธนพัฒน์ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(829, NULL, 'คุณแบงค์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(830, NULL, 'BANKKER CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(831, NULL, 'ปรีชากู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(832, NULL, 'แดงออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(833, NULL, 'ธาวัน ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(834, NULL, '28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(835, NULL, 'KB Auto สาขา2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(836, NULL, 'POP AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(837, NULL, 'เลิศประสงค์ เอ็มโซ่ เซอร์วิส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(838, NULL, 'ตุนกะตัง นิวบางกอก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(839, NULL, '2P Good Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(840, NULL, 'Chanontcarcenter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(841, NULL, 'แมนออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(842, NULL, 'เต้นรถระพีพร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(843, NULL, 'The Great Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(844, NULL, 'หมวยAUTOพระราม9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(845, NULL, 'เต็นท์พรใจรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(846, NULL, 'ธีระภัณฑ์ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(847, NULL, 'The CARS VGR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(848, NULL, 'P.PhuketCar Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(849, NULL, 'รถบ้านกัปตันโจ๊ก', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(850, NULL, 'THEP USEDCARS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(851, NULL, 'บ้านโพนมอเตอร์ สาขา2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(852, NULL, 'ร่มโพธิ์ยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(853, NULL, 'เต็นท์ อัษฏรทร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(854, NULL, 'โก๊ะBKyanyont ภูเก็ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(855, NULL, 'Carnin888', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(856, NULL, 'JOJO Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(857, NULL, 'ยุทธนา A8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(858, NULL, 'เต้นท์คุณพ้ง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(859, NULL, 'พิเชฐ ASAP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(860, NULL, 'JO AUTOCAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(861, NULL, 'NS Car Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(862, NULL, 'N.S. Autocar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(863, NULL, 'ธนารินทร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(864, NULL, 'ส.ประเสริฐ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(865, NULL, 'PC CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(866, NULL, 'PKJD Autosale ภูเก็ต', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(867, NULL, 'ชิวชิวออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(868, NULL, 'บจก บิ๊กออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(869, NULL, 'บริษัท วี วี คาร์เซ็นเตอร์ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(870, NULL, 'PP Carcenter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(871, NULL, 'ณัฐพล ออโต้ ซิตี้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(872, NULL, 'BN auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(873, NULL, 'ดวงกมลรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(874, NULL, 'สมาร์ทฮอนด้า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(875, NULL, 'แดงเจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(876, NULL, 'ต้นอ้อออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(877, NULL, 'ต.ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(878, NULL, 'บจก ออโต้ เซลส์ แอนด์ เซอร์วิส', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(879, NULL, 'น้ำทิพย์ ยูสคาร์2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(880, NULL, 'Giant autosale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(881, NULL, 'Goodcar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(882, NULL, 'บัดดี้คาร์การประมูล', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(883, NULL, 'บี๑', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(884, NULL, 'ตี๋รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(885, NULL, 'Siam car garden', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(886, NULL, '7รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(887, NULL, 'สังข์ทอง กู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(888, NULL, 'BBG AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(889, NULL, 'บริษัท ดิเอ็กซ์คลูซีฟ มอเตอร์ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(890, NULL, 'ต้นเอกแหล่งรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(891, NULL, 'โตโยต้านนทบุรี ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(892, NULL, 'TK Auto cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(893, NULL, 'ปัญญา ออโต้ เซลล์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(894, NULL, 'ชัย ลำปาง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(895, NULL, 'กท9999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(896, NULL, 'Pretty Car พริตตี้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(897, NULL, 'ไซเบอร์ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(898, NULL, 'วี ยูสคาร์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(899, NULL, 'เต็นท์วีรวิชญ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(900, NULL, 'CTV Used Cars ซีทีวียูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(901, NULL, 'บริษัท สยามพัฒน์ ออโต้เซลล์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(902, NULL, 'TC car Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(903, NULL, 'Start Autocar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(904, NULL, 'รถบ้านมีคุณ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(905, NULL, 'TC auto car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(906, NULL, 'ทองมั่น', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(907, NULL, 'SIA AUTO SALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(908, NULL, 'JUV AUTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(909, NULL, 'JK CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(910, NULL, 'เทพเสถียร ยนตรการ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(911, NULL, 'รถบ้านปารมีราชบุรี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(912, NULL, 'ทีเค คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(913, NULL, 'ธนบูรณ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(914, NULL, 'วิน เจริญยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(915, NULL, 'KN Autotrade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(916, NULL, 'ฟอร์จูน 88', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(917, NULL, 'สุดถวิล คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(918, NULL, 'บีเจ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(919, NULL, 'ธรทอง เจริญทรัพย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(920, NULL, 'บริษัท เบสออโต้ยูสคาร์ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(921, NULL, 'V 88 cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(922, NULL, 'วาสนาคาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(923, NULL, 'แปะ รถบ้านบ่อทอง', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(924, NULL, 'เต๊นท์อาณาจักรรถตู้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(925, NULL, 'Pe Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(926, NULL, 'จหก.ธีระภัณฑ์รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(927, NULL, 'B4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(928, NULL, 'เต้นท์ลดาวัลย์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(929, NULL, 'เต้นท์วรันยา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(930, NULL, '123 Auto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(931, NULL, 'มณฑลทอง คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(932, NULL, 'สาคร กู๊ดคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(933, NULL, 'PL บ้านรถสวย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(934, NULL, 'ทองเจริญรถบ้าน(', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(935, NULL, 'วัชรพล คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(936, NULL, 'ภาลิณีย์ รถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(937, NULL, 'วายุพัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(938, NULL, 'ณัฐพรรษ์ คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(939, NULL, 'พระบาทตากผ้า', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(940, NULL, 'อินเตอร์ ยูสคาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(941, NULL, 'PT USEDCAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(942, NULL, 'คมกิตติยานยนต์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(943, NULL, 'พี ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(944, NULL, 'PIE CARS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(945, NULL, 'เต้นท์ ลัดดา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(946, NULL, 'WP CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(947, NULL, 'Xรัชดา', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(948, NULL, 'ซิตี้ คาร์เซ็นเตอร์ อุดรธานี', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(949, NULL, 'megacar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(950, NULL, 'Express used car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(951, NULL, 'เต๊นเอ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(952, NULL, 'บจก.ญาดา ออโต้ คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(953, NULL, 'อาดำ ออโต้คาร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(954, NULL, 'Used Shop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(955, NULL, 'Poom Auto Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(956, NULL, 'บริษัท ทรูออโต้ จำกัด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(957, NULL, 'ซี-แคท คาร์เซ็นเตอร์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(958, NULL, 'เดอะเกรทออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(959, NULL, 'นิยมรถบ้าน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(960, NULL, 'V-Group Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(961, NULL, 'เต้นท์พีรพงษ์', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(962, NULL, 'เฮงเฮง ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(963, NULL, 'เต้นท์ มณเทียร', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(964, NULL, 'PLATINUM CAR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(965, NULL, 'เต็นท์ ภาคิน', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(966, NULL, 'หจก.สมเด็จง่วนเชียง(กาฬสินธุ์ )', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(967, NULL, 'จักริน ออโต้', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(968, NULL, 'Natt Cars', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(969, NULL, 'N Good Car', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-25 09:52:56', '2021-03-25 09:52:56', NULL),
(970, NULL, 'BB Smart Car 1', '780 สี่แยกมไหสรรค์ ถนนรัชดาภิเษก-ท่าพระ แขวงบุคคโล เขตธนบุรี กรุงเทพ', 101504, 15, 1, '10600', NULL, '0887999999', NULL, '0887999999', NULL, 1, '2022-01-19 19:10:50', '2022-04-03 22:28:15', NULL),
(971, NULL, 'ttb', '1122 ถนน พระราม 9', 104604, 46, 1, '10250', NULL, '020000000', NULL, '-', NULL, 1, '2022-05-26 02:02:49', '2022-05-26 02:02:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trn_dona_totambons`
--

CREATE TABLE `trn_dona_totambons` (
  `id` int(10) UNSIGNED NOT NULL,
  `doc_datetime` datetime DEFAULT NULL COMMENT 'วันเวลาที่บริจาค',
  `doc_no` varchar(50) DEFAULT NULL COMMENT 'เลขที่รายการ',
  `event` varchar(50) DEFAULT NULL COMMENT 'รูปแบบการบริจาค',
  `doc_refer` varchar(50) DEFAULT NULL COMMENT 'เลขที่กิจกรรมบริจาค',
  `flag` varchar(5) DEFAULT NULL COMMENT 'ยกเลิก',
  `cancel_date` datetime DEFAULT NULL COMMENT 'วันที่ยกเลิก',
  `cancel_user` varchar(30) DEFAULT NULL COMMENT 'ผู้ยกเลิก',
  `member_id` varchar(50) DEFAULT NULL COMMENT 'รหัสสมาชิก',
  `do_befor` decimal(12,2) DEFAULT NULL COMMENT 'ยอดบริจาคเริ่ม',
  `do_reedem` decimal(12,2) DEFAULT NULL COMMENT 'ยอดบริจาคใช้',
  `do_balance` decimal(12,2) DEFAULT NULL COMMENT 'ยอดบริจาคคงเหลือ',
  `donation_use` decimal(12,2) DEFAULT NULL COMMENT 'บริจากให้ รร',
  `tb_id` varchar(20) DEFAULT NULL COMMENT 'รหัสตำบล',
  `school_id` varchar(50) DEFAULT NULL COMMENT 'รหัส รร.=กองทุนโรงเรียน/center=กองกลาง',
  `remark` varchar(200) DEFAULT NULL COMMENT 'หมายเหตุ',
  `type_member` varchar(5) DEFAULT NULL COMMENT 'กลุ่มผู้ร่วมบริจาค',
  `reg_user` varchar(50) DEFAULT NULL COMMENT 'รหัสผู้สร้างrecord',
  `reg_time` datetime DEFAULT NULL COMMENT 'วันเวลาสร้างrecord',
  `upd_user` varchar(50) DEFAULT NULL COMMENT 'รหัสผู้update record',
  `upd_time` datetime DEFAULT NULL COMMENT 'วันเวลาผู้update record',
  `time_up` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันเวลาเปลี่ยนแปลงล่าสุด',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trn_dona_totambons`
--

INSERT INTO `trn_dona_totambons` (`id`, `doc_datetime`, `doc_no`, `event`, `doc_refer`, `flag`, `cancel_date`, `cancel_user`, `member_id`, `do_befor`, `do_reedem`, `do_balance`, `donation_use`, `tb_id`, `school_id`, `remark`, `type_member`, `reg_user`, `reg_time`, `upd_user`, `upd_time`, `time_up`, `created_at`, `updated_at`) VALUES
(1, '2024-05-01 00:00:00', 'RT20240000000001', '', '', '', '0000-00-00 00:00:00', '', '0805932760030', 38.40, 38.00, 0.40, 0.00, '740202', '1074590060', '', '', '0805932760030', '2024-05-01 16:54:31', '0805932760030', '2024-05-01 16:54:31', '2024-04-30 19:54:31', NULL, NULL),
(2, '2024-05-01 00:00:00', 'RT20240000000002', '', '', '', '0000-00-00 00:00:00', '', '0934146324030', 20.70, 20.00, 0.70, 0.00, '700202', '1070480273', '', '', '0934146324030', '2024-05-01 17:38:13', '0934146324030', '2024-05-01 17:38:13', '2024-04-30 20:38:13', NULL, NULL),
(3, '2024-05-01 00:00:00', 'RT20240000000003', '', '', '', '0000-00-00 00:00:00', '', '0956078207030', 20.70, 20.00, 0.70, 0.00, '191006', '1019600148', '', '', '0956078207030', '2024-05-01 17:42:34', '0956078207030', '2024-05-01 17:42:34', '2024-04-30 20:42:34', NULL, NULL),
(4, '2024-05-01 00:00:00', 'RT20240000000004', '', '', '', '0000-00-00 00:00:00', '', '0804156998055', 23.00, 23.00, 0.00, 0.00, '310202', '1031260189', '', '', '0804156998055', '2024-05-01 17:44:56', '0804156998055', '2024-05-01 17:44:56', '2024-04-30 20:44:56', NULL, NULL),
(5, '2024-05-01 00:00:00', 'RT20240000000005', '', '', '', '0000-00-00 00:00:00', '', '0925828490030', 20.70, 20.00, 0.70, 0.00, '480110', '1048190047', '', '', '0925828490030', '2024-05-01 18:07:23', '0925828490030', '2024-05-01 18:07:23', '2024-04-30 21:07:23', NULL, NULL),
(6, '2024-05-01 00:00:00', 'RT20240000000006', '', '', '', '0000-00-00 00:00:00', '', '0628646460030', 20.70, 20.00, 0.70, 0.00, '480604', '1048190338', '', '', '0628646460030', '2024-05-01 18:08:17', '0628646460030', '2024-05-01 18:08:17', '2024-04-30 21:08:17', NULL, NULL),
(7, '2024-05-01 00:00:00', 'RT20240000000007', '', '', '', '0000-00-00 00:00:00', '', '0967989624030', 20.70, 20.00, 0.70, 0.00, '430201', '1043660158', '', '', '0967989624030', '2024-05-01 18:10:51', '0967989624030', '2024-05-01 18:10:51', '2024-04-30 21:10:51', NULL, NULL),
(8, '2024-05-01 00:00:00', 'RT20240000000008', '', '', '', '0000-00-00 00:00:00', '', '0961679617030', 20.70, 20.00, 0.70, 0.00, '190203', '1019600067', '', '', '0961679617030', '2024-05-01 18:12:45', '0961679617030', '2024-05-01 18:12:45', '2024-04-30 21:12:45', NULL, NULL),
(9, '2024-05-01 00:00:00', 'RT20240000000009', '', '', '', '0000-00-00 00:00:00', '', '0928969677030', 20.70, 20.00, 0.70, 0.00, '190202', '1019600037', '', '', '0928969677030', '2024-05-01 18:23:06', '0928969677030', '2024-05-01 18:23:06', '2024-04-30 21:23:06', NULL, NULL),
(10, '2024-05-01 00:00:00', 'RT20240000000010', '', '', '', '0000-00-00 00:00:00', '', '0643068615030', 17.70, 17.00, 0.70, 0.00, '190202', '1019600037', '', '', '0643068615030', '2024-05-01 18:32:20', '0643068615030', '2024-05-01 18:32:20', '2024-04-30 21:32:20', NULL, NULL),
(11, '2024-05-01 00:00:00', 'RT20240000000011', '', '', '', '0000-00-00 00:00:00', '', '0860318228030', 17.70, 17.00, 0.70, 0.00, '311106', '1031260548', '', '', '0860318228030', '2024-05-01 19:38:08', '0860318228030', '2024-05-01 19:38:08', '2024-04-30 22:38:08', NULL, NULL),
(12, '2024-05-01 00:00:00', 'RT20240000000012', '', '', '', '0000-00-00 00:00:00', '', '0848742212029', 32.10, 32.00, 0.10, 0.00, '160702', '1016490308', '', '', '0848742212029', '2024-05-01 19:38:11', '0848742212029', '2024-05-01 19:38:11', '2024-04-30 22:38:11', NULL, NULL),
(13, '2024-05-01 00:00:00', 'RT20240000000013', '', '', '', '0000-00-00 00:00:00', '', '0821903570030', 20.70, 20.00, 0.70, 0.00, '240507', '3024200401', '', '', '0821903570030', '2024-05-01 20:32:31', '0821903570030', '2024-05-01 20:32:31', '2024-04-30 23:32:31', NULL, NULL),
(14, '2024-05-02 00:00:00', 'RT20240000000014', '', '', '', '0000-00-00 00:00:00', '', '0956718246031', 35.40, 35.00, 0.40, 0.00, '670108', '1067380032', '', '', '0956718246031', '2024-05-02 09:27:51', '0956718246031', '2024-05-02 09:27:51', '2024-05-01 12:27:51', NULL, NULL),
(15, '2024-05-02 00:00:00', 'RT20240000000015', '', '', '', '0000-00-00 00:00:00', '', '0953614146031', 17.70, 10.00, 7.70, 0.00, '450108', '1045450052', '', '', '0953614146031', '2024-05-02 10:01:36', '0953614146031', '2024-05-02 10:01:36', '2024-05-01 13:01:36', NULL, NULL),
(16, '2024-05-03 00:00:00', 'RT20240000000016', '', '', '', '0000-00-00 00:00:00', '', '0802118637031', 20.70, 20.00, 0.70, 0.00, '500514', '1050130145', '', '', '0802118637031', '2024-05-02 13:22:09', '0802118637031', '2024-05-02 13:22:09', '2024-05-01 16:22:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `name` varchar(255) DEFAULT NULL COMMENT 'ชื่อ',
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=ใช้งาน, 0=ไม่ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'Administrator', 'admin@gmail.com', NULL, '$2y$10$3rjn/Q80C2udNQorwpEo8.SPQknet8o1i..hJAXzNUzL7vaIJcjO.', 'lG9ZTgVdT63LWF3EE1uFxzf1fgZpLUWJVl19wGyt0SLVv9UZgaJe5gTkaU3s', 1, '2020-07-21 13:16:54', '2024-06-10 01:57:30'),
(2, 'panadda', 'Panadda Tingmahain', 'panadda.t@schicer.com', NULL, '$2y$10$nCf4c8Cw0KWGBmxNwrGpEOYGzR5RiVQv6Ls7lz.lovJrPZUWvKGD.', NULL, 1, '2021-03-23 18:51:36', '2024-06-09 21:28:01'),
(3, 'markawan', 'Markawan Maneesinthop', 'markawan@mail.com', NULL, '$2y$10$PWB7OepESELIfTbzlz.8HO/FMmuxT2.XKglYh/RbKsn0HmhWtlznq', NULL, 1, '2021-03-23 20:40:29', '2024-06-09 21:29:28'),
(7, 'tent1', 'Tent Example', 'tent1@gmail.com', NULL, '$2y$10$VIy2UhwGaVDwZbVhdbucS.Jf7ZLcUy2K9wrSfXJF8TUBeCzAfD6UG', NULL, 1, '2021-04-26 15:06:30', '2021-04-26 15:06:30'),
(8, 'tent2', 'tent2', 'tent2@mail.com', NULL, '$2y$10$l967vwQtA74YAn10wx2XM.X1cqa/KvHy7/jadcTsJT09K.9QZmR9q', NULL, 1, '2021-08-30 14:22:12', '2021-08-30 14:25:26'),
(9, 'bb_smartcar1', 'BB Smart Car (สาขา 1)', 'bbsmartcar1@gmail.com', NULL, '$2y$10$.FK7OqclU7cVHUIfZCl4AO6QSFg88vN/M3jcTqfJJA0cpoH0TfGXq', NULL, 1, '2022-01-19 19:14:47', '2022-01-19 19:14:47'),
(10, 'bb_smartcar2', 'BB Smart Car (สาขา 2)', 'bbsmartcar2@gmail.com', NULL, '$2y$10$3j1BfNiE/cDVDMq16g5pI.JwVotGWSfCd8uBiWAnK5otXZvtbh8TO', NULL, 1, '2022-01-19 19:24:46', '2022-01-19 19:24:46'),
(11, 'bo', 'ช่างโบ้', 'test@gmail.com', NULL, '$2y$10$qNXabFcf0l5rqJOoS/iaMOg0X0ljVJ4m8TxMvxE5WFJPXRO5DBZem', 'TyE0I46e23zpM6lWHXHXww79aNFKikpGWJo94KEWkoclxikPwWhW9Nqu3tZA', 1, '2022-02-28 15:21:57', '2022-10-02 22:22:30'),
(12, 'file', 'ช่างฟิล์ม', 'test2@gmail.com', NULL, '$2y$10$oDK5H2V30XtEany.YHQDs.P56/0L2Bx/W/dgVkKT8Fi6w2gajl5re', NULL, 1, '2022-02-28 15:23:35', '2022-02-28 15:23:35'),
(21, NULL, 'test1', 'test1@gmail.com', NULL, '$2y$10$XY8os2I.PICMI9eznO96CuUVO2EkiNSpVh9FJ.lJyF.idv.3b7iLm', NULL, 1, '2024-06-07 03:19:36', '2024-06-07 03:19:36'),
(25, '00d750', NULL, NULL, NULL, NULL, 'TQYFJ6BFmL0HXjcUTtJ0DmYIKTq60aeyN61U0vdk92pX47te5d1sxjwSXPMG', 1, '2024-08-05 03:22:25', '2024-08-05 03:22:25'),
(26, '00d752', NULL, NULL, NULL, NULL, 'g5oE76tjQFAO6UbQ1ECCATtPuAtTJwHtZAobUXc9PrNlYjAGdv1fbqSL6q0v', 1, '2024-08-05 18:50:00', '2024-08-05 18:50:00'),
(27, '006631', NULL, NULL, NULL, NULL, 'IRnZ0kDtYPOaO68d1QtsreqPQIpjxYc8i8yxmCx0T4ExbXX9i1dH61NhQBAm', 1, '2024-08-07 01:15:19', '2024-08-07 01:15:19'),
(28, '006935', NULL, NULL, NULL, NULL, NULL, 1, '2024-08-07 01:17:59', '2024-08-07 01:17:59'),
(29, '003559', NULL, NULL, NULL, NULL, 'wKeR7kAzlvANIeBaD71ADpPAyyLtvWVp16tpqWP4MABt6wfjOezYf3wiNYdU', 1, '2024-08-07 23:41:47', '2024-08-07 23:41:47'),
(30, '00C648', NULL, NULL, NULL, NULL, 'JYg0S1VU15z1n33xE6Aq4rFE6132Nrw6GAbZ7sszVxHvainm423rJ2wG4XfO', 1, '2024-08-07 23:50:00', '2024-08-07 23:50:00'),
(32, '00d751', NULL, NULL, NULL, NULL, 'eV991mAPSjVDrtbstWdyeQRzdjBGYtThR2Ib4hQPvIxWQypaw65zqvZrdqmq', 1, '2024-08-08 23:37:47', '2024-08-08 23:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `tent_id` bigint(20) DEFAULT NULL,
  `position_id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `user_id`, `tent_id`, `position_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, NULL, '2021-06-09 12:28:31'),
(2, 21, 1, 2, '2021-03-24 15:33:51', '2021-03-24 15:33:51'),
(15, 25, NULL, 7, '2022-03-01 12:30:07', '2022-03-01 12:30:07'),
(22, 29, NULL, 4, '2022-03-01 12:30:41', '2022-03-01 12:30:41'),
(23, 30, NULL, 5, '2022-03-01 12:30:47', '2022-03-01 12:30:47'),
(25, 26, NULL, 1, '2022-03-01 12:32:54', '2022-03-01 12:32:54'),
(46, 46, 235, 8, '2022-09-07 11:25:30', '2022-09-07 11:25:30'),
(47, 47, 235, 8, '2022-09-07 11:25:30', '2022-09-07 11:25:30'),
(51, 32, NULL, 6, '2024-08-09 06:37:48', '2024-08-09 06:37:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `BRAND` (`BRAND`) USING BTREE;

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`DOC_TP`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homes`
--
ALTER TABLE `homes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage_menus`
--
ALTER TABLE `manage_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_relations`
--
ALTER TABLE `menu_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `npd_categorys`
--
ALTER TABLE `npd_categorys`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `npd_cos`
--
ALTER TABLE `npd_cos`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `npd_pdms`
--
ALTER TABLE `npd_pdms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `npd_textures`
--
ALTER TABLE `npd_textures`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_develops`
--
ALTER TABLE `pro_develops`
  ADD PRIMARY KEY (`BARCODE`) USING BTREE;

--
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trn_dona_totambons`
--
ALTER TABLE `trn_dona_totambons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barcodes`
--
ALTER TABLE `barcodes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homes`
--
ALTER TABLE `homes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manage_menus`
--
ALTER TABLE `manage_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `menu_relations`
--
ALTER TABLE `menu_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submenus`
--
ALTER TABLE `submenus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `trn_dona_totambons`
--
ALTER TABLE `trn_dona_totambons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
