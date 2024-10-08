-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 12:21 PM
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
-- Table structure for table `accesseries`
--

CREATE TABLE `accesseries` (
  `ID` int(2) NOT NULL,
  `COMPANY` varchar(20) NOT NULL DEFAULT '',
  `BRAND` varchar(20) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT '',
  `REMARK` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accesseries`
--

INSERT INTO `accesseries` (`ID`, `COMPANY`, `BRAND`, `DESCRIPTION`, `REMARK`) VALUES
(1, 'OP', 'OP', 'OP', ''),
(2, 'OP', '', 'KM', 'KM วัสดุสิ้นเปลือง'),
(3, 'CP', 'CP', 'CP', ''),
(4, 'CP', '', 'KM', 'KM วัสดุสิ้นเปลือง'),
(5, 'KU', 'KU', 'KU', '');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cost` double(8,2) DEFAULT NULL COMMENT 'ต้นทุน',
  `perfume_tax` double(8,2) DEFAULT NULL COMMENT 'ภาษีน้ำหอม',
  `cost_perfume_tax` double(8,2) DEFAULT NULL COMMENT 'ต้นทุน + ภาษีน้ำหอม',
  `cost5percent` double(8,2) DEFAULT NULL COMMENT 'ต้นทุน+5%',
  `cost10percent` double(8,2) DEFAULT NULL COMMENT 'ต้นทุน+10%',
  `cost_other` double(8,2) DEFAULT NULL COMMENT ' ต้นทุน+อื่นๆ',
  `sale_km` double(8,2) DEFAULT NULL COMMENT 'ราคาขาย KM',
  `sale_km20percent` double(8,2) DEFAULT NULL COMMENT 'ราคาขาย KM + 20%',
  `sale_km_other` double(8,2) DEFAULT NULL COMMENT 'ราคาขาย KM+อื่นๆ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `cost`, `perfume_tax`, `cost_perfume_tax`, `cost5percent`, `cost10percent`, `cost_other`, `sale_km`, `sale_km20percent`, `sale_km_other`, `created_at`, `updated_at`) VALUES
(1, 100.00, 100.00, 100.00, 100.00, 100.00, 100.00, 100.00, 100.00, 100.00, '2024-08-26 07:35:17', '2024-08-26 07:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `acctypes`
--

CREATE TABLE `acctypes` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acctypes`
--

INSERT INTO `acctypes` (`ID`, `DESCRIPTION`) VALUES
('80004', 'น้ำหอม'),
('90000', 'อื่นๆ');

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

CREATE TABLE `barcodes` (
  `ID` int(11) NOT NULL,
  `COMPANY` varchar(20) NOT NULL DEFAULT '',
  `BRAND` varchar(10) NOT NULL DEFAULT '',
  `B_CODE` varchar(15) NOT NULL DEFAULT '',
  `NUMBER` decimal(10,0) NOT NULL DEFAULT 0,
  `REMARK` varchar(50) NOT NULL DEFAULT '',
  `STATUS` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barcodes`
--

INSERT INTO `barcodes` (`ID`, `COMPANY`, `BRAND`, `B_CODE`, `NUMBER`, `REMARK`, `STATUS`) VALUES
(1, 'OP', 'OP', '88500802', 10, '', 'OP'),
(3, 'OP', 'RI', '88500802', 9007, 'Brand Ri En', 'RI'),
(5, 'CP', 'CP', '88500807', 3, '0', 'CP'),
(11, 'KU', 'KU', '885008011', 0, '', 'KU');

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
-- Table structure for table `brand_ps`
--

CREATE TABLE `brand_ps` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `REMARK` varchar(50) NOT NULL DEFAULT '',
  `BRAND` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_ps`
--

INSERT INTO `brand_ps` (`ID`, `REMARK`, `BRAND`) VALUES
('0000', 'Not Define', NULL),
('0001', 'Basic Nutrition', 'GNC'),
('0002', 'Challenge', 'GNC'),
('0003', 'Gingseng Gold', 'GNC'),
('0004', 'GNC', 'GNC'),
('0005', 'Herbal Plus', 'GNC'),
('0006', 'Natural Brand', 'GNC'),
('0007', 'Nature\'s Fingerprint', 'GNC'),
('0008', 'Optibolic', 'GNC'),
('0009', 'Preventive Nutrition', 'GNC'),
('0010', 'Pro Performance', 'GNC'),
('C0001', 'Coolly', 'CP'),
('C0002', 'Cute Press', 'CP'),
('D0001', 'Diva', 'CP'),
('F0001', 'Feminise', 'CP'),
('G0001', 'GNC', 'CP'),
('KM001', 'KM Brand', 'CP'),
('M0001', 'Mew Mew', 'CP'),
('N0001', 'Naris', 'CP'),
('N0002', 'Natureal', 'CP'),
('O0001', 'OP Salon', 'CP'),
('P0001', 'Primahome', 'CP'),
('S0001', 'Shoop Shoop', 'CP'),
('S0002', 'Spices', 'CP'),
('S0003', 'Swiss Formula', 'CP');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `DESCRIPTION`) VALUES
('80001', 'EQUIPMENT KM'),
('80002', 'ACCESSORY KM'),
('99999', 'NOT DEFINE'),
('AM', 'Ambient Mist, Ambient Spray'),
('BC', 'Body Cream'),
('BD', 'Brow Designer Eyebrow'),
('BF', 'Brush Foot'),
('BG', 'Bag'),
('BL', 'Body Lotion,Body Moisturiser'),
('BM', 'Body Mist,Body Spray,Body Colonge'),
('BO', 'Blush On'),
('BS', 'Body Serum'),
('BX', 'Box'),
('CA', 'Case'),
('CC', 'Body Colonge Cream'),
('CF', 'Cleansing Foam/ Clenser'),
('CG', 'Cleansing Gel'),
('CM', 'Charm'),
('CM.PM', 'Premium'),
('CN', 'Conditioner'),
('CP', 'CAP'),
('CR', 'Moisturiser Cream / Cream'),
('CS', 'Capsule'),
('DC', 'Day Cream / Day Moisturiser'),
('DE', 'Deodorant'),
('DF', 'Diffuser'),
('DL', 'DAY Lotion'),
('DO', 'Deo Spray'),
('DS', 'Day Serum'),
('DT', 'Detox'),
('EC', 'Eye Cream / Eye Moisturiser'),
('EF', 'Eau de Perfume'),
('EG', 'Eye Gel'),
('EN', 'Essence'),
('EO', 'Essential Oil'),
('ET', 'Eau de Toilette'),
('EX', 'Exfoliating'),
('EY', 'Eyelash Curler'),
('FC', 'Foot Cream'),
('FE', 'Feminime Hygiene'),
('FS', 'Foot Spray'),
('GE', 'Gel Vitamin (บำรุง)'),
('GH', 'Hand Gel'),
('HA', 'Alcohol Spray'),
('HC', 'Hand Cream'),
('HD', 'Hair Shadow'),
('HG', 'Styling Gel'),
('HK', 'Hair Mask'),
('HM', 'Hair Mist,Hair Spray,Hair Colonge'),
('HP', 'Hair Spray'),
('HR', 'Hand Serum'),
('HS', 'Hair Serum'),
('HT', 'Hair Tonic'),
('HW', 'Hand Wash,Hand Foam'),
('KC', 'Knee Cream'),
('KTY', 'Katanyu'),
('LB', 'Lip Balm'),
('LC', 'Cheek & Lips'),
('LG', 'Lingerie Mist'),
('LM', 'Linen Mist,Linen Spray'),
('LR', 'Lip Sheer'),
('LS', 'Lipstick'),
('LT', 'Lip Treatment'),
('MA', 'Massage Gel'),
('MB', 'Makeup Brush'),
('MG', 'Mask Gel'),
('MI', 'Mirror'),
('MK', 'Mask Cream'),
('ML', 'Massage Lotion'),
('MM', 'Massage Cream'),
('MN', 'Maincure'),
('MO', 'Massage Oil'),
('MX', 'Set'),
('NB', 'Nail Balm'),
('NC', 'Night Cream/ Night Moisturiser'),
('NL', 'Night Lotion'),
('NS', 'Night Serum'),
('NT', 'Nail Sticker'),
('OC.BA', 'Base'),
('OC.BM', 'Body Makeup'),
('OC.BO', 'Blush On'),
('OC.CE', 'CC Cream'),
('OC.CH', 'Cheek'),
('OC.CL', 'Concealer'),
('OC.CM', 'Cleansing Milk '),
('OC.CO', 'Cleansing Oil'),
('OC.CW', 'Cleansing Water'),
('OC.EB', 'Eyebrow'),
('OC.EE', 'Eyebrow  & Eyeliner'),
('OC.EL', 'Eyeliner'),
('OC.EM', 'Eyebrow & Mascara'),
('OC.EP', 'Eye Primer'),
('OC.ES', 'Eye Shadow'),
('OC.EY', 'Eyes'),
('OC.FO', 'Foundation'),
('OC.HL', 'Highlight & Contour'),
('OC.LC', 'Cheek & Lip'),
('OC.LD', 'Liquid Lip'),
('OC.LI', 'Lip Gloss'),
('OC.LL', 'Lip Liner'),
('OC.LO', 'Loose Pwder'),
('OC.LP', 'Lip Primer '),
('OC.LR', 'Lip Sheer'),
('OC.LS', 'Lip'),
('OC.MC', 'Mascara'),
('OC.MF', 'Make Off'),
('OC.MT', 'Make Up Tools'),
('OC.PM', 'Premium'),
('OC.PO', 'Powder'),
('OC.TL', 'Tint Lip'),
('OS', 'Oil Control Sheet'),
('OT', 'Other'),
('PD', 'Talc,Powder for body'),
('PG', 'Peeling Gel'),
('PM', 'Paper Mask'),
('PP', 'Pump'),
('PU', 'Puff'),
('PW', 'Pre Facial Wash'),
('SB', 'Body Scrub'),
('SC', 'Shower Cream'),
('SE', 'Serum'),
('SG', 'Shower Gel'),
('SH', 'Shampoo'),
('SM', 'Scrub Mask'),
('SN', 'Sponge'),
('SO', 'Soap สบู่ก้อน'),
('SP', 'Spot Treatment Cream'),
('SR', 'Sharpener'),
('SS', 'Time to Shine'),
('ST', 'Styling Cream'),
('SU', 'Styling Mouse'),
('SW', 'Styling Wax'),
('SY', 'Spray'),
('TC', 'Shower cap'),
('TO', 'Toner'),
('TS', 'Treatment Serum'),
('UC', 'Underarm Cream'),
('US', 'Underarm Scrub'),
('UT', 'Underarm Toning'),
('WP', 'Water Spray'),
('WS', 'White Secret');

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
-- Table structure for table `com_products`
--

CREATE TABLE `com_products` (
  `id` int(10) NOT NULL,
  `corporation_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสข้อมูลบริษัท',
  `company_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสบริษัท',
  `product_id` varchar(15) NOT NULL DEFAULT '' COMMENT 'รหัสสินค้า',
  `barcode` varchar(15) NOT NULL DEFAULT '' COMMENT 'barcode',
  `vendor_id` varchar(15) NOT NULL DEFAULT '' COMMENT 'รหัสผู้ขาย',
  `name_thai` varchar(70) NOT NULL DEFAULT '' COMMENT 'ชื่อภาษาไทย',
  `name_eng` varchar(70) NOT NULL DEFAULT '' COMMENT 'ชื่อภาษาอังกฤษ',
  `short_thai` varchar(30) NOT NULL DEFAULT '' COMMENT 'ชื่อย่อภาษาไทย',
  `short_eng` varchar(30) NOT NULL DEFAULT '' COMMENT 'ชื่อย่อภาษาอังกฤษ',
  `price` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ราคาขาย',
  `cost` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ต้นทุน',
  `unit_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสหน่วยสินค้า',
  `currency_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสสกุลเงิน',
  `capacity_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสหน่วยบรรจุ',
  `capacity` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ปริมาณบรรจุ',
  `non_vat` char(1) NOT NULL DEFAULT '' COMMENT 'ไม่คำนวณภาษี',
  `status` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสสถานะสินค้า',
  `warrant_no` varchar(20) NOT NULL DEFAULT '' COMMENT 'เลขที่ใบอนุญาต',
  `gp` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ส่วนลด',
  `return` char(1) NOT NULL DEFAULT '' COMMENT 'คืนซาก',
  `o_product` varchar(15) NOT NULL DEFAULT '' COMMENT 'รหัสสินค้าเก่า',
  `shelf_life` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'อายุการเก็บรักษา (ปี)',
  `storage_temp` char(1) NOT NULL DEFAULT '' COMMENT 'จัดเก็บในห้องรักษาอุณหภูมิ',
  `size_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสหน่วยความยาว',
  `width` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ความกว้าง',
  `long` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ความยาว',
  `height` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ความสูง',
  `weight_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสหน่วยน้ำหนัก',
  `weight` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'น้ำหนัก',
  `control_stk` char(1) NOT NULL DEFAULT '' COMMENT 'คุมสินค้าคงเหลือของสาขา',
  `make_buy` char(1) NOT NULL DEFAULT '' COMMENT 'km ผลิตสินค้า',
  `safety_stock` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'สินค้าคงเหลือขั้นต่ำ',
  `lot_size_min` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'จำนวนการสั่งสินค้าขั้นต่ำ',
  `lot_size_multi` char(1) NOT NULL DEFAULT '0' COMMENT 'สั่งสินค้าเป็น lot',
  `buyer_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสผู้ขอซื้อ',
  `planner_id` varchar(10) NOT NULL DEFAULT '' COMMENT 'รหัสผู้วางแผนการผลิต',
  `lead_time_po` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'lead time การสั่งซื้อ',
  `lead_time_pn` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'lead time การวางแผน',
  `lead_time_inspec` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'lead time การตรวจสอบ',
  `acc_type` varchar(10) NOT NULL DEFAULT '' COMMENT 'ประเภทสินค้าบัญชี',
  `acc_date` date NOT NULL DEFAULT '1900-01-01' COMMENT 'วันที่บันทึก',
  `acc_time` time NOT NULL DEFAULT '00:00:00' COMMENT 'เวลาที่บันทึก',
  `acc_user` varchar(10) NOT NULL DEFAULT '' COMMENT 'ผู้บันทึก',
  `reg_date` date NOT NULL DEFAULT '1900-01-01' COMMENT 'วันที่สร้าง',
  `reg_time` time NOT NULL DEFAULT '00:00:00' COMMENT 'เวลาที่สร้าง',
  `reg_user` varchar(10) NOT NULL DEFAULT '' COMMENT 'ผู้สร้าง',
  `upd_date` date NOT NULL DEFAULT '1900-01-01' COMMENT 'วันที่แก้ไข',
  `upd_time` time NOT NULL DEFAULT '00:00:00' COMMENT 'เวลาที่แก้ไข',
  `upd_user` varchar(10) NOT NULL DEFAULT '' COMMENT 'ผู้แก้ไข',
  `lock` char(1) NOT NULL DEFAULT '' COMMENT 'สถานะการใช้งาน',
  `area` decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT 'พื้นที่ widht*long*hight',
  `pick_qty` decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT 'Pack_size',
  `pick_type` char(1) NOT NULL COMMENT 'ประการจัด  1= qty_pick ต่อ 1 ใบ Pick',
  `qty_pick` decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT 'จำนวนชิ้นต่อใบpick',
  `box_qty` decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT 'จำนวนชิ้นต่อลัง',
  `pallet_qty` decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT 'จำนวนชิ้นต่อ Pallet',
  `group` varchar(10) NOT NULL,
  `name_export` varchar(100) NOT NULL DEFAULT '**',
  `series` varchar(10) NOT NULL DEFAULT 'no',
  `solution` varchar(10) NOT NULL DEFAULT 'no',
  `category` varchar(10) NOT NULL DEFAULT 'no',
  `group2` varchar(10) NOT NULL DEFAULT 'no',
  `net_weight` decimal(14,2) NOT NULL DEFAULT 0.00,
  `check` varchar(1) NOT NULL DEFAULT 'N',
  `duplicate` varchar(1) NOT NULL DEFAULT 'N',
  `active_sta` varchar(1) NOT NULL,
  `product_status` varchar(10) NOT NULL,
  `height_old` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'ความสูงเดิม',
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `run_newsize` varchar(10) NOT NULL DEFAULT 'Y',
  `height_edit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `area_edit` decimal(14,4) NOT NULL DEFAULT 0.0000,
  `box_pallet` varchar(20) NOT NULL,
  `img_url` text NOT NULL,
  `box_ecom` varchar(10) NOT NULL,
  `lead_time_group` int(11) NOT NULL,
  `lead_time_by_product` int(11) NOT NULL,
  `time_stampLeadTime` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `on_wh_stock` varchar(10) NOT NULL COMMENT 'ยังมีอยู่ใน wh_stock ไหม'
) ENGINE=MyISAM DEFAULT CHARSET=tis620 COLLATE=tis620_thai_ci COMMENT='ทะเบียนสินค้า' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `com_products`
--

INSERT INTO `com_products` (`id`, `corporation_id`, `company_id`, `product_id`, `barcode`, `vendor_id`, `name_thai`, `name_eng`, `short_thai`, `short_eng`, `price`, `cost`, `unit_id`, `currency_id`, `capacity_id`, `capacity`, `non_vat`, `status`, `warrant_no`, `gp`, `return`, `o_product`, `shelf_life`, `storage_temp`, `size_id`, `width`, `long`, `height`, `weight_id`, `weight`, `control_stk`, `make_buy`, `safety_stock`, `lot_size_min`, `lot_size_multi`, `buyer_id`, `planner_id`, `lead_time_po`, `lead_time_pn`, `lead_time_inspec`, `acc_type`, `acc_date`, `acc_time`, `acc_user`, `reg_date`, `reg_time`, `reg_user`, `upd_date`, `upd_time`, `upd_user`, `lock`, `area`, `pick_qty`, `pick_type`, `qty_pick`, `box_qty`, `pallet_qty`, `group`, `name_export`, `series`, `solution`, `category`, `group2`, `net_weight`, `check`, `duplicate`, `active_sta`, `product_status`, `height_old`, `time_stamp`, `run_newsize`, `height_edit`, `area_edit`, `box_pallet`, `img_url`, `box_ecom`, `lead_time_group`, `lead_time_by_product`, `time_stampLeadTime`, `on_wh_stock`) VALUES
(219027, '', 'BB', '40435', '885008060400', 'KM', 'บีซู บีซู อิน ฟูล บลูม บอดี้ โลชั่น70 ml', 'In Full Bloom Body Lotion70', '', '', 259.00, 59.48, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2018-11-03', '06:30:12', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', 'I0009', 'B0001', 'P2000', '01', 0.00, 'N', 'N', '', '', 0.00, '2019-11-12 11:02:09', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(216829, '', 'BB', '60001', '8801310001013', 'KM', 'Diamond Powder Pact-bag#1(1295)', 'D.POWDER PACT-BAG#1', '', '', 1295.00, 174.16, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2020-01-06', '10:49:08', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', 'D0018', 'M0001', 'M1000', '01', 0.00, 'N', 'N', '', '', 0.00, '2020-01-06 03:49:08', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(216830, '', 'BB', '60002', '8801310001020', 'KM', 'Diamond Powder Pact-bag#2(1295)', 'D. POWDER PACT-BAG#2', '', '', 1295.00, 174.16, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2020-01-06', '10:49:36', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', 'D0018', 'M0001', 'M1000', '01', 0.00, 'N', 'N', '', '', 0.00, '2020-01-06 03:49:36', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(216831, '', 'BB', '60003', '8800110004019', 'KM', 'Set-Miracle White Two Way Cake#1(1495)', 'SET-MW. TWO WAY#1', '', '', 1495.00, 138.60, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 5.00, 12.50, 15.50, '', 110.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2020-01-06', '10:50:04', 'system', '', 968.7500, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', 'M0019', 'M0001', 'M1000', '01', 0.00, 'N', 'N', '', '', 0.00, '2020-01-06 03:50:04', 'Y', 0.00, 0.0000, '', 'http://192.169.0.5/putaway/com_product/upload/IMG_60003.jpg', '', 0, 0, '1900-01-01 00:00:00', ''),
(216832, '', 'BB', '60004', '8800110004026', 'KM', 'Set-Miracle White Two Way Cake#2(1495)', 'SET-MW. TWO WAY#2', '', '', 1495.00, 138.60, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 5.00, 12.50, 15.00, '', 115.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2020-01-06', '10:50:33', 'system', '', 937.5000, 0.0000, '', 0.0000, 10.0000, 250.0000, 'BB', '**', 'M0019', 'M0001', 'M1000', '01', 0.00, 'N', 'N', '', '', 0.00, '2020-01-06 03:50:33', 'Y', 0.00, 0.0000, '', 'http://192.169.0.5/putaway/com_product/upload/20160704095937.jpg', '', 0, 0, '1900-01-01 00:00:00', ''),
(216833, '', 'BB', '60005', '8800110005016', 'KM', 'Set-Brigntening FD Powder#1(1495)', 'SET-BRIGN FDPOWDER#1', '', '', 1495.00, 188.38, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 5.00, 12.50, 15.50, '', 110.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2020-01-06', '10:51:03', 'system', '', 968.7500, 0.0000, '', 0.0000, 10.0000, 250.0000, 'BB', '**', 'B0021', 'P0004', 'M1000', '01', 0.00, 'N', 'N', '', '', 0.00, '2020-01-06 03:51:03', 'Y', 0.00, 0.0000, '', 'http://192.169.0.5/putaway/com_product/upload/20160704115508.jpg', '', 0, 0, '1900-01-01 00:00:00', ''),
(220614, '', 'CP', '75455', '8850080754551', 'KM', 'สกินนี่เบราว์เพ็นซิล - 01', 'skinny brow pencil - 01', '', '', 129.00, 26.57, '', '', '', 0.00, '', '', '', 0.00, '', '', 3.00, '', '', 4.80, 1.00, 20.50, '', 6.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2024-09-03', '09:25:05', 'system', '', 98.4000, 0.0000, '', 0.0000, 864.0000, 0.0000, '', '**', 'Z0006', 'E0002', 'M1000', '01', 0.00, 'N', 'N', '', '', 0.00, '2024-09-03 02:25:06', 'Y', 0.00, 0.0000, '', 'http://192.169.0.5/putaway/com_product/upload/20230909085307.jpg', '', 0, 0, '1900-01-01 00:00:00', ''),
(208211, '', 'OP', '20528', '8850080205282', 'KM', 'EYE CLOURS REF.02', 'EYE CLOURS REF.02', '', '', 20.00, 27.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', 'OCEC02', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2018-04-07', '06:31:15', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', '99999', '99999', '99999', '01', 0.00, 'N', 'N', '', '', 0.00, '2018-08-21 08:10:23', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(208212, '', 'OP', '20529', '8850080205299', 'KM', 'EYE CLOURS REF.03', 'EYE CLOURS REF.03', '', '', 20.00, 27.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', 'OCEC03', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2018-04-07', '06:31:16', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', '99999', '99999', '99999', '01', 0.00, 'N', 'N', '', '', 0.00, '2018-08-21 08:10:23', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(208213, '', 'OP', '20530', '8850080205305', 'KM', 'EYE CLOURS REF.04', 'EYE CLOURS REF.04', '', '', 20.00, 27.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', 'OCEC04', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2018-04-07', '06:31:18', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', '99999', '99999', '99999', '01', 0.00, 'N', 'N', '', '', 0.00, '2018-08-21 08:10:23', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(195795, '', 'KM', 'HTSGOE4000', 'HTSGOE4000', 'KM', 'ORIENTAL ESSENCE SHOWER GEL', 'ORIENTAL ESSENCE SHOWER GEL', '', '', 150.50, 0.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 1.00, 1.00, 1.00, '', 1.00, '', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '', 1.0000, 0.0000, '', 0.0000, 12.0000, 300.0000, 'KM', '', '00000', '00002', '00001', '01', 1.00, 'N', 'N', 'Y', '', 1.00, '2016-05-18 06:54:05', 'Y', 1.00, 1.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(217561, '', 'KU', '001', '001', 'KM', 'ตู้ใสหนังสือ', '-', '', '', 350.00, 350.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2017-04-09', '10:30:26', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '**', 'no', 'no', 'no', '06', 0.00, 'N', 'N', '', '', 0.00, '2018-08-21 08:10:23', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(205139, '', 'KU', '0801001', '0801001', 'KM', 'โฟร์โมสต์ 225ml รสหวาน', 'โฟร์โมสต์ 225ml รสหวาน', '', '', 10.00, 9.36, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 0.00, 0.00, 0.00, '', 0.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2011-04-29', '10:24:41', 'system', '', 0.0000, 0.0000, '', 0.0000, 0.0000, 0.0000, '', '', '01', '01', '02', '01', 0.00, 'N', 'N', '', '', 0.00, '0000-00-00 00:00:00', 'Y', 0.00, 0.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(203191, '', 'KU', '11001', '8850080110012', 'KM', 'น้ำดื่มกตัญญู ขนาด 600 ml', 'น้ำดื่มกตัญญู ขนาด 600 ml', '', '', 7.00, 3.27, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 1.00, 1.00, 1.00, '', 1.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2016-05-18', '00:26:13', 'system', '', 1.0000, 0.0000, '', 0.0000, 12.0000, 300.0000, 'KM', '', '0101', '0001', '0002', '01', 0.00, 'N', 'N', '', '', 1.00, '2016-05-17 17:26:13', 'Y', 1.00, 1.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(203192, '', 'KU', '11002', '8850080110029', 'KM', 'ข้าวหอมมะลิกตัญญู ขนาด 5 kg', 'ข้าวหอมมะลิกตัญญู ขนาด 5 kg', '', '', 249.00, 191.74, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 1.00, 1.00, 1.00, '', 5.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2016-05-18', '00:26:15', 'system', '', 1.0000, 0.0000, '', 0.0000, 12.0000, 300.0000, 'KM', '', '0101', '0001', '0001', '01', 0.00, 'N', 'N', 'Y', 'Y', 1.00, '2016-05-17 17:26:15', 'Y', 1.00, 1.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(203193, '', 'KU', '11003', '8850080110036', 'KM', 'ข้าวหอมมะลิกตัญญู ขนาด 2 kg', 'ข้าวหอมมะลิกตัญญู ขนาด 2 kg', '', '', 109.00, 67.89, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 18.50, 32.00, 6.50, '', 2.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2016-05-18', '00:26:16', 'system', '', 3848.0000, 0.0000, '', 0.0000, 12.0000, 300.0000, 'KM', '', '0101', '0001', '0001', '01', 0.00, 'N', 'N', '', '', 6.50, '2016-05-17 17:26:16', 'Y', 6.50, 3848.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(203194, '', 'KU', '11004', '8850080110043', 'KM', 'สบู่กตัญญู ขนาด 115 g', 'สบู่กตัญญู ขนาด 115 g', '', '', 0.00, 0.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 1.00, 1.00, 1.00, '', 1.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2011-04-25', '10:23:19', 'system', '', 1.0000, 0.0000, '', 0.0000, 10.0000, 300.0000, 'KM', '', '0301', '0003', '0005', '01', 0.00, 'N', 'N', '', '', 1.00, '2013-07-11 05:23:30', 'Y', 1.00, 1.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', ''),
(203195, '', 'KU', '11005', '8850080110050', 'KM', 'น้ำดื่มกตัญญู ขนาด 220 ml บรรจุ 48 ถ้วย', 'KATANYU Drinking Water 220 ml 48 priece', '', '', 79.40, 65.00, 'ชิ้น', '', '', 0.00, '', '', '', 0.00, '', '', 0.00, '', '', 1.00, 1.00, 1.00, '', 1.00, 'N', '', 0.00, 0.00, '0', '', '', 0.00, 0.00, 0.00, '', '1900-01-01', '00:00:00', '', '1900-01-01', '00:00:00', '', '2016-05-18', '00:26:18', 'system', '', 1.0000, 0.0000, '', 0.0000, 12.0000, 300.0000, 'KU', '', '0101', '0001', '0002', '01', 0.00, 'N', 'N', 'Y', 'Y', 1.00, '2016-09-14 07:47:02', 'Y', 1.00, 1.0000, '', '', '', 0, 0, '1900-01-01 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`ID`, `DESCRIPTION`) VALUES
('C', 'Credit'),
('S', 'Consign');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `COMPANY` varchar(20) NOT NULL DEFAULT '',
  `BRAND` varchar(20) NOT NULL DEFAULT '',
  `DOC_TP` varchar(10) NOT NULL DEFAULT '',
  `DOC_NO` varchar(10) DEFAULT NULL COMMENT 'Prefix',
  `NUMBER` decimal(10,0) DEFAULT 0,
  `FIELD` varchar(20) DEFAULT '',
  `DOC_ST` decimal(2,0) DEFAULT 0,
  `REMARK` varchar(50) DEFAULT '',
  `REMARK_EDIT` varchar(50) DEFAULT '',
  `STATUS` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`COMPANY`, `BRAND`, `DOC_TP`, `DOC_NO`, `NUMBER`, `FIELD`, `DOC_ST`, `REMARK`, `REMARK_EDIT`, `STATUS`) VALUES
('CP', 'CP', 'NPD', 'NCP', 3, '', 1, '', '', 'CP'),
('OP', 'OP', 'NPD', 'NOP', 10, '', 0, 'new product op (20)', '', 'OP'),
('OP', 'RI', 'NPD', 'NRI', 9007, '', 0, 'new product ri (29)', '', 'RI');

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
-- Table structure for table `grp_ps`
--

CREATE TABLE `grp_ps` (
  `GRP_P` varchar(10) NOT NULL DEFAULT '',
  `REMARK` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grp_ps`
--

INSERT INTO `grp_ps` (`GRP_P`, `REMARK`) VALUES
('CM', 'COS MARCHE'),
('OP', 'ORIENTAL PRINCESS'),
('RE', 'RI EN');

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
(1, 'NPD Request', 'new_product_develop', 1, 1, '2021-04-03 18:58:21', '2021-04-03 18:58:21'),
(2, 'Product Master', 'product', 2, 1, '2021-04-03 18:58:21', '2021-04-03 18:58:21'),
(3, 'Product Detail', 'get_users', 3, 1, '2021-04-03 18:58:21', '2021-04-03 18:58:21'),
(4, 'Warehouse', 'warehouse', 4, 1, '2024-06-28 07:48:31', '2024-06-28 07:48:34'),
(5, 'Account', 'account', 5, 1, '2024-07-02 03:36:12', '2024-07-02 03:36:12'),
(6, 'Managemenu', 'manage_menu', 6, 1, NULL, NULL),
(7, 'Approve', NULL, 7, 1, '2024-08-20 01:49:18', '2024-08-20 01:49:18'),
(8, 'จัดการข้อมูลทั่วไป', 'manage_general_information', 8, 1, NULL, NULL);

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
(3, 5, 1, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, '2023-01-19 18:07:38', '2023-01-19 18:07:38'),
(50, 1, 2, NULL, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL),
(90, 1, 4, NULL, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL),
(112, 3, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 3, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 1, 6, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 7, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 6, 1, NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL),
(159, 7, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 1, 8, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(181, 1, 8, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 6, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 8, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 8, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 8, 8, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 8, 8, 1, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 6, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 1, 8, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 1, 4, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 6, 4, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 7, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 7, 4, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 6, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 6, 8, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 6, 8, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 15, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 15, 4, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(23, '2024_07_09_030557_create_submenus_table', 6),
(24, '2024_07_31_034934_create_npd_cos_table', 7),
(25, '2024_07_31_040004_create_npd_pdms_table', 7),
(26, '2024_07_31_042519_create_npd_categorys_table', 7),
(27, '2024_07_31_062319_create_npd_textures_table', 7),
(28, '2024_08_02_013802_create_pro_develops_table', 7),
(29, '2024_08_02_041844_create_barcodes_table', 7),
(30, '2024_08_02_042114_create_documents_table', 7),
(32, '2024_08_15_063623_create_accounts_table', 8),
(33, '2024_08_28_032026_create_product1s_table', 9),
(48, '2024_08_28_093742_create_owners_table', 10),
(49, '2024_08_28_094236_create_type_gs_table', 10),
(50, '2024_08_28_094351_create_solutions_table', 10),
(51, '2024_08_28_094454_create_series_table', 10),
(52, '2024_08_28_094658_create_categories_table', 10),
(53, '2024_08_28_094854_create_sub_categories_table', 10),
(54, '2024_08_28_095003_create_pdms_table', 10),
(55, '2024_08_29_021407_create_grp_ps_table', 10),
(56, '2024_08_29_021446_create_brand_ps_table', 10),
(57, '2024_08_29_022612_create_vendors_table', 10),
(58, '2024_08_29_030352_create_unit_ps_table', 10),
(59, '2024_08_29_030457_create_unit_types_table', 10),
(60, '2024_08_29_030652_create_acctypes_table', 10),
(61, '2024_08_29_032021_create_conditions_table', 10);

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
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `OWNER` varchar(10) NOT NULL DEFAULT '',
  `REMARK` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`OWNER`, `REMARK`) VALUES
('KM', 'KM INTERLAB'),
('OP', 'ORIENTAL PRINCESS');

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
-- Table structure for table `pdms`
--

CREATE TABLE `pdms` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `REMARK` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdms`
--

INSERT INTO `pdms` (`ID`, `REMARK`) VALUES
('99999', 'No Define'),
('G0001', 'Make up PDM'),
('G0002', 'Skincare PDM'),
('G0003', 'B&B, Hair care and Fragrance PDM'),
('G0004', 'Household PDM');

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
(78, 'App\\Models\\User', 21, 'productMastertoken', '965dc19202395d8cd9a51c37a4f5e7e5431b0242ad1010e6c83ab81a64abb852', '[\"*\"]', NULL, NULL, '2024-07-04 20:29:28', '2024-07-04 20:29:28'),
(79, 'App\\Models\\User', 36, 'main', 'b3403024c8cfa64dc874305791b849029ffebae500bd4591d1669262df99124c', '[\"*\"]', NULL, NULL, '2024-09-20 06:43:34', '2024-09-20 06:43:34'),
(80, 'App\\Models\\User', 36, 'main', '7ff393a19226d420f823f84b98a27db792f35c9b1e9c11200e9a6de7351bf227', '[\"*\"]', NULL, NULL, '2024-09-20 06:44:13', '2024-09-20 06:44:13'),
(81, 'App\\Models\\User', 36, 'main', 'd2ad972033296101fa50316a7bd3b9c2dc56f2c59ccdd5f4f0aab896a1d5a891', '[\"*\"]', NULL, NULL, '2024-09-20 06:45:10', '2024-09-20 06:45:10'),
(82, 'App\\Models\\User', 36, 'main', '0efd7af1f9c20b6a72c9b2ea80e29343c5c5501c21458b6cbca365401355c865', '[\"*\"]', NULL, NULL, '2024-09-20 06:49:08', '2024-09-20 06:49:08'),
(83, 'App\\Models\\User', 36, 'main', '7c0689ffc4338746702541063e05d046019572096ca199675ce0803d58d3a004', '[\"*\"]', NULL, NULL, '2024-09-20 06:50:15', '2024-09-20 06:50:15'),
(84, 'App\\Models\\User', 36, 'main', 'cd32c6c34de988195abc4c52e6201abfb39c8166c95f7d87a784d637c4c69e93', '[\"*\"]', NULL, NULL, '2024-09-20 06:51:06', '2024-09-20 06:51:06'),
(85, 'App\\Models\\User', 36, 'main', '8b1b8a9e59d1b04041895a4c2eb0f19b30866a28bf86d7971b4778209c1743b9', '[\"*\"]', NULL, NULL, '2024-09-20 06:51:38', '2024-09-20 06:51:38'),
(86, 'App\\Models\\User', 36, 'main', 'bc5c6fbfe262a50786e07f57ef9a74db2d4d524c88a56c1222ea2e609f21d9fc', '[\"*\"]', NULL, NULL, '2024-09-20 06:53:56', '2024-09-20 06:53:56'),
(87, 'App\\Models\\User', 36, 'main', '16d48e3da6c56c62a75b13e73dbfcc89a66478a01a0cbc2147221c1b992f91bd', '[\"*\"]', NULL, NULL, '2024-09-20 06:55:26', '2024-09-20 06:55:26'),
(88, 'App\\Models\\User', 36, 'main', '00020004b5fdee81209e0dc2d7624508abe3ab75a78e91f056fbb386b1f8a638', '[\"*\"]', NULL, NULL, '2024-09-20 06:57:15', '2024-09-20 06:57:15'),
(89, 'App\\Models\\User', 36, 'main', '2f74f7449f542a2d1cfdbd8702faa0b106117bf4e7498f91c5dd51a191c161d7', '[\"*\"]', NULL, NULL, '2024-09-20 07:00:16', '2024-09-20 07:00:16'),
(90, 'App\\Models\\User', 36, 'main', '294e18408ca4d564db9fde0e8476d43b5218884a83b6a9043ea01d17ce2aaac8', '[\"*\"]', NULL, NULL, '2024-09-20 07:00:46', '2024-09-20 07:00:46'),
(91, 'App\\Models\\User', 36, 'main', 'c81a6ee2c202a26fe006468e3f5f12f53973ebaef16a8ffe5abcda696b66f155', '[\"*\"]', NULL, NULL, '2024-09-20 07:01:41', '2024-09-20 07:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_position` varchar(255) DEFAULT NULL COMMENT 'ชื่อบทบาท',
  `brand` varchar(10) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name_position`, `brand`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', NULL, NULL, NULL, NULL, NULL),
(2, 'Manager_Account', NULL, NULL, NULL, NULL, NULL),
(3, 'Accounting', NULL, NULL, NULL, NULL, NULL),
(4, 'Category - OP', 'OP', NULL, NULL, NULL, NULL),
(5, 'Product - OP', NULL, NULL, NULL, NULL, NULL),
(6, 'E-Commerce - OP', 'OP', NULL, NULL, NULL, NULL),
(7, 'Marketing - CPS', 'CP', NULL, NULL, NULL, NULL),
(8, 'Admin', NULL, NULL, NULL, NULL, NULL);

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
-- Table structure for table `product1s`
--

CREATE TABLE `product1s` (
  `BRAND` varchar(10) DEFAULT NULL,
  `PRODUCT` varchar(15) NOT NULL,
  `BARCODE` varchar(15) NOT NULL,
  `COLOR` varchar(50) DEFAULT NULL,
  `GRP_P` varchar(10) DEFAULT NULL,
  `SUPPLIER` varchar(15) DEFAULT NULL,
  `NAME_THAI` varchar(70) DEFAULT NULL,
  `NAME_ENG` varchar(70) DEFAULT NULL,
  `SHORT_THAI` varchar(70) DEFAULT NULL,
  `SHORT_ENG` varchar(70) DEFAULT '',
  `VENDOR` varchar(10) DEFAULT NULL,
  `PRICE` decimal(8,2) DEFAULT NULL,
  `COST` decimal(8,2) DEFAULT NULL,
  `UNIT` varchar(20) DEFAULT NULL,
  `UNIT_Q` decimal(8,2) DEFAULT NULL,
  `SOLUTION` varchar(10) DEFAULT NULL,
  `SERIES` varchar(10) DEFAULT NULL,
  `CATEGORY` varchar(10) DEFAULT NULL,
  `NON_VAT` varchar(1) DEFAULT NULL,
  `STATUS` varchar(10) DEFAULT NULL,
  `S_CAT` varchar(10) DEFAULT NULL,
  `PDM_GROUP` varchar(10) DEFAULT NULL,
  `BRAND_P` varchar(10) DEFAULT NULL,
  `REGISTER` varchar(20) DEFAULT NULL,
  `CONDITION_SALE` varchar(2) DEFAULT NULL,
  `WHOLE_SALE` decimal(8,2) DEFAULT NULL,
  `GP` decimal(8,2) DEFAULT NULL,
  `RETURN` varchar(1) DEFAULT NULL,
  `O_PRODUCT` varchar(15) DEFAULT NULL,
  `BAR_PACK1` varchar(15) DEFAULT NULL,
  `BAR_PACK2` varchar(15) DEFAULT NULL,
  `BAR_PACK3` varchar(15) DEFAULT NULL,
  `BAR_PACK4` varchar(15) DEFAULT NULL,
  `PACK_SIZE1` decimal(5,0) DEFAULT NULL,
  `PACK_SIZE2` decimal(5,0) DEFAULT NULL,
  `PACK_SIZE3` decimal(5,0) DEFAULT NULL,
  `PACK_SIZE4` decimal(5,0) DEFAULT NULL,
  `REG_DATE` datetime DEFAULT NULL,
  `AGE` varchar(20) DEFAULT NULL,
  `STORAGE_TEMP` varchar(1) DEFAULT NULL,
  `WIDTH` decimal(5,2) DEFAULT NULL,
  `HEIGHT` decimal(5,2) DEFAULT NULL,
  `WIDE` decimal(5,2) DEFAULT NULL,
  `NAME_EXP` varchar(100) DEFAULT NULL,
  `NET_WEIGHT` decimal(12,2) DEFAULT NULL,
  `UNIT_TYPE` varchar(20) DEFAULT NULL,
  `TYPE_G` varchar(2) DEFAULT NULL,
  `CONTROL_STK` varchar(1) DEFAULT NULL,
  `TESTER` varchar(1) DEFAULT NULL,
  `OPT_DATE1` datetime DEFAULT NULL,
  `OPT_DATE2` datetime DEFAULT NULL,
  `OPT_TXT1` varchar(50) DEFAULT NULL,
  `OPT_TXT2` varchar(50) DEFAULT NULL,
  `OPT_NUM1` decimal(15,2) DEFAULT NULL,
  `OPT_NUM2` decimal(15,2) DEFAULT NULL,
  `ACC_TYPE` varchar(10) DEFAULT NULL,
  `ACC_DT` datetime DEFAULT NULL,
  `USER_EDIT` varchar(15) DEFAULT NULL,
  `EDIT_DT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product1s`
--

INSERT INTO `product1s` (`BRAND`, `PRODUCT`, `BARCODE`, `COLOR`, `GRP_P`, `SUPPLIER`, `NAME_THAI`, `NAME_ENG`, `SHORT_THAI`, `SHORT_ENG`, `VENDOR`, `PRICE`, `COST`, `UNIT`, `UNIT_Q`, `SOLUTION`, `SERIES`, `CATEGORY`, `NON_VAT`, `STATUS`, `S_CAT`, `PDM_GROUP`, `BRAND_P`, `REGISTER`, `CONDITION_SALE`, `WHOLE_SALE`, `GP`, `RETURN`, `O_PRODUCT`, `BAR_PACK1`, `BAR_PACK2`, `BAR_PACK3`, `BAR_PACK4`, `PACK_SIZE1`, `PACK_SIZE2`, `PACK_SIZE3`, `PACK_SIZE4`, `REG_DATE`, `AGE`, `STORAGE_TEMP`, `WIDTH`, `HEIGHT`, `WIDE`, `NAME_EXP`, `NET_WEIGHT`, `UNIT_TYPE`, `TYPE_G`, `CONTROL_STK`, `TESTER`, `OPT_DATE1`, `OPT_DATE2`, `OPT_TXT1`, `OPT_TXT2`, `OPT_NUM1`, `OPT_NUM2`, `ACC_TYPE`, `ACC_DT`, `USER_EDIT`, `EDIT_DT`) VALUES
('OP', '20001', '8850080200010', 'Yellow', 'OP', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2001-05-28 00:00:00', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', 'transfer', '2005-12-24 00:00:00'),
('OP', '20002', '8850080200027', 'Yellow', 'OP', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2024-09-10 08:30:13', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', '32', '2005-12-24 00:00:00'),
('OP', '20003', '8850080200034', 'Yellow', 'OP', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2024-09-10 08:32:23', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', '32', '2005-12-24 00:00:00'),
('OP', '20004', '8850080200041', 'Yellow', 'OP', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2024-09-10 08:36:57', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', '32', '2005-12-24 00:00:00'),
('OP', '20005', '8850080200058', NULL, 'OP', '5050', NULL, NULL, NULL, NULL, 'OP', NULL, NULL, NULL, NULL, '80001', NULL, '80001', 'N', 'X', 'DF', 'G0001', '0001', NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 05:39:29', NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32', NULL),
('OP', '20006', '8850080200065', NULL, 'OP', '5050', NULL, NULL, NULL, NULL, 'OP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 04:00:36', NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32', NULL),
('OP', '29001', '8850080290011', 'Yellow', 'RE', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2024-09-13 08:15:27', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', '32', '2005-12-24 00:00:00'),
('OP', '29002', '8850080290028', 'Yellow', 'RE', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2024-09-13 08:17:27', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', '32', '2005-12-24 00:00:00'),
('CP', '70001', '8850080700015', 'Yellow', 'CM', '7162', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์ต.ค.44(กาดสวนแก้ว)', 'ค่าโทรศัพท์', 'Value', 'KM', 2326.92, 100.00, '1', 100.00, '99999', '99999', '99999', 'Y', '', '', '', '', 'XX-X-XXXXXXXXXX', '', 100.00, 0.00, 'Y', '', '', '', '', '', 0, 0, 0, 0, '2024-09-13 08:35:03', '1', 'Y', 1.00, 1.00, 1.00, '', 1.00, '', '01', 'Y', 'Y', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '', '', 0.00, 0.00, '', '1900-01-01 00:00:00', '32', '2005-12-24 00:00:00'),
('KM', 'CP111111', 'CP111111', NULL, 'CP', '5050', NULL, NULL, NULL, NULL, 'KM', NULL, NULL, '01', NULL, '80001', '80001', '80001', 'N', 'D', 'DF', '99999', NULL, NULL, 'C', NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01 04:31:37', NULL, 'N', NULL, NULL, NULL, NULL, NULL, '01', '02', 'N', 'N', NULL, NULL, NULL, NULL, NULL, NULL, '80004', NULL, '32', NULL),
('KM', 'NPD0000001', 'NPD0000001', NULL, 'OP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'E', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 03:05:56', NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32', NULL),
('KM', 'NPD0000002', 'NPD0000002', NULL, 'OP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '80001', NULL, '80001', 'Y', 'E', 'DF', 'G0001', NULL, 'XX-X-XXXXXXXXXX', NULL, NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 02:59:49', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32', NULL),
('KM', 'NPD0000113', 'NPD0000113', NULL, 'OP', '5050', NULL, NULL, NULL, NULL, 'OP', NULL, NULL, NULL, NULL, '80001', NULL, '80001', 'N', 'X', 'DF', 'G0001', NULL, 'XX-X-XXXXXXXXXX', NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-08 05:34:59', NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, '01', 'N', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32', NULL);

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
  `EDIT_DT` datetime DEFAULT '1900-01-01 00:00:00',
  `USER_EDIT` varchar(15) DEFAULT '',
  `STATUS` varchar(5) DEFAULT '',
  `REMARK_ST` varchar(100) DEFAULT '',
  `CUST_OEM` varchar(100) DEFAULT '',
  `JOB_REFNO` varchar(20) DEFAULT '',
  `DOC_DT` date DEFAULT '1900-01-01',
  `NPD` varchar(50) DEFAULT '',
  `PDM` varchar(50) DEFAULT '',
  `NAME_ENG` varchar(70) DEFAULT '',
  `PRODUCT` varchar(15) NOT NULL DEFAULT '',
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
('OP', '', 'IBH-F155', 0, '2024-09-03 03:35:49', '26', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20001', '8850080200010', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', '', 'IBH-F155', 0, '2024-09-10 08:29:02', '32', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20002', '8850080200027', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', '', 'IBH-F155', 0, '2024-09-10 08:29:14', '32', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20003', '8850080200034', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', '', 'IBH-F155', 0, '2024-09-10 08:29:21', '32', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20004', '8850080200041', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', '', 'IBH-F155', 0, '2024-09-10 08:30:32', '32', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20005', '8850080200058', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', '', 'IBH-F155', 0, '2024-09-16 02:30:23', '32', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20006', '8850080200065', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', '', 'IBH-F155', 0, '2024-09-17 10:53:07', '32', 'OP', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '20007', '8850080200072', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('OP', NULL, 'IBH-F155', 0, '2024-09-17 00:00:00', '32', 'OP', '', NULL, NULL, '2024-09-17', '002', '001', NULL, '20008', '8850080200089', '001', NULL, NULL, NULL, NULL, '2024-09-17', NULL, NULL, NULL, NULL, NULL, '001', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', '', 'N', NULL, 'N', NULL, NULL, NULL, NULL, NULL),
('OP', NULL, 'IBH-F155', 0, '2024-10-01 00:00:00', '32', 'OP', '', NULL, NULL, '2024-10-01', '002', '001', NULL, '20009', '8850080200096', '001', NULL, NULL, NULL, NULL, '2024-10-01', NULL, NULL, NULL, NULL, NULL, '001', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', '', 'N', NULL, 'N', NULL, NULL, NULL, NULL, NULL),
('OP', NULL, 'IBH-F155', 0, '2024-10-07 00:00:00', '32', 'OP', '', NULL, NULL, '2024-10-07', '002', '001', NULL, '20010', '8850080200102', '001', NULL, NULL, NULL, NULL, '2024-10-07', NULL, NULL, NULL, NULL, NULL, '001', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', '', 'N', NULL, 'N', NULL, NULL, NULL, NULL, NULL),
('Ri', '', 'IBH-F155', 0, '2024-09-06 10:19:28', '32', 'Ri', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '29001', '8850080290011', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('Ri', '', 'IBH-F155', 0, '2024-09-10 08:30:55', '32', 'Ri', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '29002', '8850080290028', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('Ri', '', 'IBH-F155', 0, '2024-09-10 08:30:59', '32', 'Ri', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '29003', '8850080290035', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('Ri', '', 'IBH-F155', 0, '2024-09-10 08:31:05', '32', 'Ri', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '29004', '8850080290042', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('Ri', '', 'IBH-F155', 0, '2024-09-10 08:31:25', '32', 'Ri', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '29005', '8850080290059', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('Ri', '', 'IBH-F155', 0, '2024-09-17 10:53:00', '32', 'Ri', '', '2', '2', '2024-08-21', '002', '001', 'OP Cuticle Hair Treatment 1', '29006', '8850080290066', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('RI', NULL, 'IBH-F155', 0, '2024-09-17 00:00:00', '32', 'RI', '', NULL, NULL, '2024-09-17', '002', '001', NULL, '29007', '8850080290073', '001', NULL, NULL, NULL, NULL, '2024-09-17', NULL, NULL, NULL, NULL, NULL, '001', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', '', 'N', NULL, 'N', NULL, NULL, NULL, NULL, NULL),
('CP', '', 'IBH-F155', 0, '2024-09-12 02:32:35', '32', 'CP', '', '2', '2', '2024-08-21', '002', '001', 'CP Cuticle Hair Treatment 1', '70001', '8850080700015', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('CP', '', 'IBH-F155', 0, '2024-09-17 10:53:38', '25', 'CP', '', '2', '2', '2024-08-21', '002', '001', 'CP Cuticle Hair Treatment 1', '70002', '8850080700022', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL),
('CP', '', 'IBH-F155', 0, '2024-09-17 10:53:49', '25', 'CP', '', '2', '2', '2024-08-21', '002', '001', 'CP Cuticle Hair Treatment 1', '70003', '8850080700039', '001', '2', 2.00, 2.00, '2', '2024-08-21', '2', '2', '2', '2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ ริมฝีปาก', '001', '2', '2', '', '', '2', '2', '2', '2', '2', '2', 2, 'Y', 'Y', '', 'Y', '2', 'Y', '2', '2', '2', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `p_statuses`
--

CREATE TABLE `p_statuses` (
  `ID` varchar(1) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `p_statuses`
--

INSERT INTO `p_statuses` (`ID`, `DESCRIPTION`) VALUES
('', 'Existing (No Define)'),
('D', 'Discontinue'),
('E', 'Existing'),
('L', 'Limited'),
('N', 'New Product'),
('O', 'Delete'),
('S', 'Sampling'),
('T', 'Tester'),
('X', 'Not Exist');

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`ID`, `DESCRIPTION`) VALUES
('80001', 'EQUIPMENT KM'),
('80002', 'ACCESSORY KM'),
('99999', 'NOT DEFINE'),
('AA', 'All Day Bright'),
('AB', 'Absolute Treatment'),
('AC', 'Natural Acne Care'),
('AD', 'All Day Sun Protection'),
('AG', 'Age Recharge'),
('AL', 'Alluring Moment'),
('AM', 'Acnemise'),
('AN', 'Absolute Nourishing'),
('AO', 'All Day Glow'),
('AR', 'Age Renewal'),
('AU', 'Automatic'),
('AW', 'All Day Wear'),
('AY', 'As You wish'),
('BB', 'BB Secret'),
('BD', 'Brow Designer Eyebrow Pencil'),
('BE', 'Beauty Essence Complex'),
('BG', 'Bag'),
('BJ', 'Beautiful Journey'),
('BK', 'Bikini Care'),
('BM', 'Body Makeup'),
('BN', 'Bene'),
('BS', 'Baby Skin'),
('BT', 'Botanical Lips Expert'),
('BW', 'Brilliant White'),
('CB', 'Closing Bill'),
('CC', 'Cashmere Creamy'),
('CE', 'Cherry Blossom'),
('CF', 'Charisma The  Art Of Fragrance Layering'),
('CG', 'Collagen'),
('CH', 'Cuticle Hair Treatment'),
('CL', 'Soft Cushion Lip Cream'),
('CM', 'Curl Maximising'),
('CP', 'Shower Cap'),
('CR', 'Cherish'),
('CS', 'Cuticle Professional Hair Care'),
('CU', 'Cushion'),
('CY', 'Creamy Matte'),
('DA', 'Dazzle Glow'),
('DB', 'Dermacare Bath Pom-Pom'),
('DE', 'Deep Velvet Matte'),
('DF', 'DENTAL FLOSS'),
('DG', 'Dazzling Glow'),
('DM', 'Disney x Mulan'),
('DR', 'Dramatic'),
('DS', 'Dermasoft Facial Sponge'),
('DV', 'Dolly Curl & Volume'),
('EB', 'Eyebrow'),
('EC', 'Extreme Coverage'),
('EF', 'Easy Happy Feet'),
('EP', 'Exfoliating Pad'),
('EV', 'Extreme Volume'),
('FF', '5 in 1'),
('FI', 'Face Illuminator'),
('FJ', 'Luscious Fruity Journey'),
('FL', 'Floralista'),
('FM', 'For men'),
('FN', 'Flawless Finish'),
('FO', '4 in 1  Perfect'),
('FP', 'Friuty Party'),
('FS', 'Foot Scratcher'),
('FU', 'Fresh Up'),
('FW', 'Fruity Sweet Lip Care'),
('GB', 'Gentle Cleansing Brush'),
('GD', 'Gradient'),
('GG', 'Glam & Glow Smooth'),
('GL', 'Glamourama'),
('GO', 'Gorgeous'),
('GR', 'Gradation'),
('GS', 'Glow&smooth'),
('GT', 'Magic Touch'),
('HC', 'That Hot Choco'),
('HF', 'Hydra Fresh Mineral Water Spray'),
('HG', 'Healthy Glow'),
('HI', 'Happy In The Garden'),
('HM', 'Happy Beauty  Mask'),
('HP', 'Instant Hand Protection'),
('HS', 'Happiness Stories'),
('HY', 'Hypnosis'),
('IB', 'Instant Brightening'),
('IC', 'Iconic'),
('IF', 'Intense Hydration Foot Care'),
('IH', 'Intense Hydration Hand Care'),
('IN', 'Individualist'),
('JD', 'Fresh&Juicy Delight'),
('JF', 'Juice Fruity Lip Care'),
('JG', 'Juicy Glow'),
('JS', 'Journey for Senses'),
('JU', 'Juicy Squeze'),
('KAL', 'alcohol Spray'),
('KBL', 'Body Lotion'),
('KC', 'Knee Care'),
('KCG', 'Cleansing Gel'),
('KDO', 'Deodorant'),
('KR', 'Kiss From A Rose'),
('KSW', 'shower'),
('KTY', 'KTY'),
('LC', 'Lumino Complex Expert'),
('LD', 'Lengthen & Define'),
('LF', 'Lift Firming'),
('LI', 'LIFE'),
('LK', 'Lovely Kiss'),
('LL', 'Love Letter'),
('LP', 'Lumino Complex Perfecting White'),
('LU', 'Luxurious'),
('LW', 'Lengthening Waterproof'),
('MA', 'Maincure'),
('MB', 'Milky Whitening Intensive'),
('MC', 'Pure Matte Lip Colours'),
('ML', 'Magic Lengths'),
('MR', 'Make Off Remover'),
('MS', 'Matte Stay'),
('MT', 'Make Up Tools'),
('MW', 'Milky Whitening Radiance Intensive Booster'),
('NA', 'Naturally Ageless'),
('NC', 'Natural Power C Miracle Brightening Complex'),
('NE', 'Natural Eyebrow'),
('NF', 'Nail Fashion Sticker'),
('NG', 'Natural Glow'),
('NI', 'Natural Intensive C'),
('NL', 'Natural Lip Treatment'),
('NS', 'Natural Salon Styler'),
('NY', 'New Year, Premium Set'),
('OB', 'Oriental Beauty'),
('OC.LL', 'Lip Liner & Lipstick'),
('OC.LN', 'Proliner'),
('OC.MA', 'Mascara'),
('OC.MT', 'Mousse Tint'),
('OC.NL', 'Nude Lipstick'),
('OC.PB', 'Powder Blusher'),
('OC.RG', 'Ready To Glam'),
('OE', 'Oriental Eyes'),
('OS', 'Oriental Sensation'),
('OS.AA', 'Nat Sun Anti-Aging'),
('OS.AC', 'Nat Sun Acne'),
('OS.BM', 'Nat Sun Base Make Up'),
('OS.CL', 'Nat Sun Cleanser'),
('OS.DC', 'Nat Sun Daily Care'),
('OS.EA', 'Nat Sun Extreme Activity'),
('OS.FI', 'Nat Sun Firming'),
('OS.HP', 'Nat Sun High Protection'),
('OS.LI', 'Nat Sun Lip'),
('OS.MU', 'Nat Sun Make Up'),
('OS.OC', 'Nat Sun Oil Control'),
('OS.SP', 'Nat Sun Skin Problem'),
('OS.WH', 'Nat Sun Whitening'),
('OT', 'Other'),
('PA', 'Peony Bloom'),
('PB', 'pH Balanced'),
('PC', 'Perfect Curling'),
('PD', 'Professional Brow Designer'),
('PE', 'Perfect Eyebrow'),
('PF', 'Perfect Body Treatment'),
('PG', 'Princess Garden'),
('PH', 'Phenomenal'),
('PI', 'Pro Highlight & Contour'),
('PK', 'Powder Kiss Lipstick'),
('PL', 'Perfect Lasting Oil Control'),
('PM', 'Perfect Matte'),
('PN', 'Perfect Finish'),
('PO', 'Palette Of Thailand'),
('PP', 'Passion of Polish'),
('PR', 'Pum refill'),
('PS', 'Peach Blossom'),
('PT', 'Phytotherphy'),
('PU', 'Pure Colours'),
('PW', 'Professional Brow Designer Water Proof'),
('PWH', 'Perfumed White'),
('RD', 'RED Natural Whitening Phenomenon'),
('RF', 'RED Natural Whitening & Firming Phenomenon'),
('RM', 'Rich Moisturisers'),
('RN', 'Rhythms of Nature'),
('RR', 'Repair & Rescue'),
('RV', 'Revival Renewal'),
('RW', 'Ready To Wear'),
('SA', 'Sachet'),
('Sanitizer', 'Sanitizer'),
('SC', 'Secret of Charm'),
('SE', 'Secret Agent'),
('SF', 'Secret Soft'),
('SG', 'Sugar Lip'),
('SH', 'Story of Happiness'),
('SK', 'Sweet Kiss Lip Butter'),
('SL', 'Scent of Love Set'),
('SM', 'Studio Matte'),
('SN', 'Skin Solution Complex  Anti Acne'),
('SO', 'Smoothing Matte'),
('Soap', 'Soap'),
('SP', 'Super Waterproof'),
('ST', 'Soft Touch'),
('SU', 'Sunsational'),
('SW', 'Skin Solution Complex Whitening'),
('TB', 'Tender Body Sponge'),
('TL', 'Touchless Matte'),
('TM', 'Satin Matte'),
('TN', 'Tropical Nutrient'),
('Toothbrush', 'Toothbrush'),
('Toothpaste', 'Toothpaste'),
('TR', 'True Wings'),
('TS', 'Tales of the star'),
('TW', 'Twisty'),
('UC', 'Underarm Care'),
('UE', 'Ultra Natural E+'),
('UF', 'Ultima Lift'),
('UL', 'Ultimate Coverage'),
('UM', 'Ultimate Renewal'),
('UR', 'Ultra Rich Moisture'),
('UT', 'Underarm Toning'),
('V.DF', 'DENTAL FLOSS'),
('VE', 'Velvet'),
('VL', 'Value Set'),
('VV', 'Veda Vanda'),
('WA', 'Wonders of Asia'),
('WD', 'Weekly Detox'),
('WG', 'Welcome Gift , Member Gift'),
('WP', 'White Perfection'),
('WS', 'White Secret'),
('WT', 'Wimantra'),
('WV', 'Wine Valley');

-- --------------------------------------------------------

--
-- Table structure for table `solutions`
--

CREATE TABLE `solutions` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solutions`
--

INSERT INTO `solutions` (`ID`, `DESCRIPTION`) VALUES
('80001', 'Equipment Km'),
('80002', 'Accessory Km'),
('99999', 'Not Define'),
('KTY', 'Katanyu'),
('OA', 'Accessories'),
('OB', 'Body'),
('OC', 'Colours'),
('OF', 'Facial'),
('OG', 'Gift Set/ Limited Edition'),
('OH', 'Hair'),
('OL', 'Lifestyle (Soft Line)'),
('OM', 'Member'),
('OO', 'Others'),
('OP', 'Perfumery'),
('OS', 'Sunscreen'),
('OT', 'Treatment'),
('OX', 'ของฟรี ของแจก ของแถม'),
('RB', 'Body'),
('Toothbrush', 'Toothbrush');

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
(1, 8, 'จัดการเครื่องมือ', 'tool', 1, 1, NULL, NULL, '2024-07-09 07:51:44', '2024-07-09 07:51:44'),
(2, 8, 'จัดการรูป', 'images', 2, 1, NULL, NULL, '2024-07-09 07:51:44', '2024-07-09 07:51:44'),
(3, 8, 'Camera', 'camera', 3, 1, NULL, NULL, '2024-07-09 01:00:47', '2024-07-09 01:00:47'),
(9, 4, 'Dimension', 'dimension', 1, 1, NULL, NULL, '2024-07-31 04:28:26', '2024-07-31 04:28:26'),
(10, 4, 'Approve2', '5.2', 2, 1, NULL, NULL, '2024-07-31 04:28:26', '2024-07-31 04:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `ID` varchar(10) NOT NULL DEFAULT '',
  `CATEGORY_ID` varchar(10) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`ID`, `CATEGORY_ID`, `DESCRIPTION`) VALUES
('DF', 'KTY', 'DENTAL FLOSS PICKS'),
('JG', '', 'Juicy Glow'),
('Loose', '', 'All Day Sun Loose'),
('MT', 'OC.LS', 'Mousse Tint'),
('OC.BM.BM', '', 'Body Makeup'),
('OC.CH.AO', '', 'All Day Glow Powder Blush'),
('OC.CH.CC', '', 'Cheek Colours'),
('OC.CH.GD', '', 'Gradation Cheek'),
('OC.CH.KS', '', 'Kiss From A Rose'),
('OC.CH.PB', '', 'Powder Blusher'),
('OC.CH.RW', '', 'Ready To Wear'),
('OC.CW.MW', '', 'Perfect Cleanse Micellar Water'),
('OC.EY.AW', '', 'All Day Wear Eyeshadow'),
('OC.EY.EB', '', 'Eyebrow'),
('OC.EY.EC', '', 'Eye Colours'),
('OC.EY.EL', '', 'Eyeliner'),
('OC.EY.EP', '', 'Eye palette'),
('OC.EY.MC', '', 'Mascara'),
('OC.FO.AF', '', 'All Day Sun Foundation'),
('OC.FO.BC', '', 'BB Secret Cream'),
('OC.FO.BF', '', 'Brilliant White Foundation'),
('OC.FO.BS', '', 'Base'),
('OC.FO.CC', '', 'All Day Sun CC Cream'),
('OC.FO.CO', '', 'Concealer'),
('OC.FO.CU', '', 'Cushion'),
('OC.FO.DG', '', 'Defy Gravity Foundation'),
('OC.FO.HF', '', 'Healthy Glow Foundation'),
('OC.FO.MF', '', 'Makeup Fix'),
('OC.FO.NF', '', 'Natural Glow Foundation'),
('OC.FO.OF', '', 'Oil Control Foundation'),
('OC.FO.PC', '', 'Phenomenal Perfect Coverage Foundation'),
('OC.FO.PF', '', 'PHENOMENAL Foundation'),
('OC.FO.PH', '', 'Phenomenal Perfecr Coverage'),
('OC.FO.PN', '', 'Phenomenal Perfect Coverage Cream to Powder'),
('OC.FO.RF', '', 'RED Natural Whitening & Firming Phenomenon'),
('OC.FO.SH', '', 'Sunsational Rush Hour'),
('OC.FO.UF', '', 'Ultimate Coverage Foundation'),
('OC.FO.WF', '', 'White Perfection Foundation'),
('OC.JG', '', 'Juicy Glow'),
('OC.LO.AL', '', 'All Day Sun Loose Powder'),
('OC.LO.PH', 'OC.LO', 'Phennomenal Loose Powder'),
('OC.LO.PL', 'OC.LO', 'Perfect Lasting Oil Control Loose Powder'),
('OC.LO.PP', '', 'Phenomeal Loose Powder'),
('OC.LS.AN', '', 'Absolute Nourishing'),
('OC.LS.AT', '', 'Automatic  Lip Pencil'),
('OC.LS.CL', '', 'Collagen'),
('OC.LS.CM', '', 'Creamy Matte'),
('OC.LS.CR', '', 'Cashmere Creamy'),
('OC.LS.DE', '', 'Deep Velvet Mette Lipstick'),
('OC.LS.DM', '', 'Disney x Mulan'),
('OC.LS.GG', '', 'Glam & Glow Smooth Lipstick'),
('OC.LS.GM', '', 'Glamourama Lip Palette'),
('OC.LS.HC', '', 'That Hot Choco'),
('OC.LS.HG', '', 'Hypnosis  Gloss '),
('OC.LS.IC', '', 'Intense Creamy '),
('OC.LS.IM', '', 'Studio Matte'),
('OC.LS.JG', '', 'JUICY  LIPGLOSS'),
('OC.LS.LG', '', 'Lip Gloss'),
('OC.LS.LL', '', 'Lip Liner'),
('OC.LS.LP', '', 'Lip Primer'),
('OC.LS.LQ', '', 'Lip Lacquer'),
('OC.LS.LR', '', 'Lip Sheer'),
('OC.LS.MT', '', 'Mousse Tint'),
('OC.LS.NL', '', 'Nude Lipstick'),
('OC.LS.PK', '', 'Powder Kiss Lipstick'),
('OC.LS.RF', '', 'RED Natural Whiening & Firming Matte Lipstick'),
('OC.LS.RM', '', 'Rich Moisturisers'),
('OC.LS.SM', '', 'Satin Matte'),
('OC.LS.SO', '', 'Smoothing Matte'),
('OC.LS.TL', '', 'Lip Tint '),
('OC.LS.TTL', '', 'Two Tone Lipstick'),
('OC.LS.TWL', '', 'True Wings Lipstick'),
('OC.LS.UM', '', 'Ultra Rich Moisture'),
('OC.LS.VM', '', 'Velvet Matte'),
('OC.LS>PK', '', 'Beneficial Powder Kiss Lipstick'),
('OC.MA', 'OC.EY', 'Mascara'),
('OC.MF.CB', '', 'Cleansing Bubble'),
('OC.MF.CM', '', 'Cleansing Milk'),
('OC.MF.CO', '', 'Cleansing Oil'),
('OC.MF.CS', '', 'Cleansing Milk Essence'),
('OC.MF.CW', '', 'Cleansing Water'),
('OC.MF.OI', '', 'Cleansing Oil in Water'),
('OC.MT.AC', '', 'Accessories'),
('OC.MT.DM', '', 'Disney x Mulan'),
('OC.MT.MB', '', 'Makeup Brush'),
('OC.MT.MT', '', 'Make Up Tools'),
('OC.NL', 'LS', 'Nude Lipstick'),
('OC.PM.BG', '', 'True Wings Bag'),
('OC.PO.AP', '', 'All Day Sun Powder'),
('OC.PO.BL', '', 'BRILLIANT WHITE Loose Powder'),
('OC.PO.BP', '', 'BB Secret Powder'),
('OC.PO.BW', '', 'Brilliant White Powder'),
('OC.PO.DM', '', 'Disney x Mulan'),
('OC.PO.ECP', '', 'Extreme Coverage Powder '),
('OC.PO.EP', '', 'EXTREME Powder'),
('OC.PO.FN', '', 'Flawless Finish Mineral Powder'),
('OC.PO.HL', '', 'Healthy Glow Loose Powder'),
('OC.PO.HP', '', 'Healthy Glow Powder'),
('OC.PO.IP', '', 'ILLUMINATOR POWDER'),
('OC.PO.LO', '', 'Loose Powder'),
('OC.PO.LP', '', 'Loose Powder'),
('OC.PO.NP', '', 'Natural Glow  Powder'),
('OC.PO.OP', '', 'Oil Control Powder'),
('OC.PO.PC', '', 'Perfect Coverage Powder'),
('OC.PO.PH', '', 'Pro Highlight & Contour'),
('OC.PO.PL', '', 'Phenomenal Loose Powder'),
('OC.PO.PP', '', 'Phenomenal Powder'),
('OC.PO.PS', '', 'Pressed Powder'),
('OC.PO.RF', '', 'RED Natural Whitening & Firming Phenomenon Powder'),
('OC.PO.UP', '', 'Ultimate Coverage Powder'),
('OC.PO.WL', '', 'White Perfection Loose Powder'),
('OC.PO.WP', '', 'White Perfection Powder'),
('OC.TL', '', 'Touchless Matte'),
('OS.FB', '', 'For Body'),
('OS.FF', '', 'For Face'),
('OS.LI', '', 'Lip'),
('SC', 'WS', 'Scrub');

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
-- Table structure for table `type_gs`
--

CREATE TABLE `type_gs` (
  `ID` varchar(2) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_gs`
--

INSERT INTO `type_gs` (`ID`, `DESCRIPTION`) VALUES
('01', 'สินค้าขายปกติ'),
('02', 'สินค้าแถมฟรีหรือรางวัล'),
('03', 'เอกสารสิ่งพิมพ์'),
('04', 'อุปกรณ์สนับสนุนการขาย'),
('05', 'วัสดุสิ้นเปลือง'),
('06', 'อื่นๆ'),
('08', 'แอลกอฮอล์'),
('09', 'tester');

-- --------------------------------------------------------

--
-- Table structure for table `unit_ps`
--

CREATE TABLE `unit_ps` (
  `ID` varchar(2) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_ps`
--

INSERT INTO `unit_ps` (`ID`, `DESCRIPTION`) VALUES
('01', 'กระป๋อง'),
('02', 'กล่อง'),
('03', 'ก้อน'),
('04', 'ขวด'),
('05', 'คัน'),
('06', 'คู่'),
('07', 'ชิ้น'),
('08', 'ชุด'),
('09', 'ซิงค์'),
('10', 'ถาดหลุม'),
('11', 'บาน'),
('12', 'ม้วน'),
('13', 'หลอด'),
('14', 'หีบ'),
('15', 'ห่อ'),
('16', 'อัน'),
('17', 'เซ็ท'),
('18', 'เล่ม'),
('19', 'เส้น'),
('20', 'แท่ง'),
('21', 'แผ่น'),
('22', 'แพค'),
('23', 'โหล'),
('24', 'ใบ');

-- --------------------------------------------------------

--
-- Table structure for table `unit_types`
--

CREATE TABLE `unit_types` (
  `ID` varchar(2) NOT NULL DEFAULT '',
  `DESCRIPTION` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_types`
--

INSERT INTO `unit_types` (`ID`, `DESCRIPTION`) VALUES
('01', '1'),
('02', 'g.'),
('03', 'ml');

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
(25, '00d750', NULL, NULL, NULL, NULL, '2Qoh4sKDLBQvh96MqwrfaNiVguXjBLi5gM8AtCLW946YKx9j2y35YmlPQhnt', 1, '2024-08-05 03:22:25', '2024-10-10 04:13:22'),
(26, '00d752', NULL, NULL, NULL, NULL, '4v4AV5QfiJXTjiIY8PeuwtKD6GNsMkp5NpFywfGiGs2w571hmg9GdrboKnNl', 1, '2024-08-05 18:50:00', '2024-10-10 06:56:01'),
(27, '006631', NULL, NULL, NULL, NULL, 'IRnZ0kDtYPOaO68d1QtsreqPQIpjxYc8i8yxmCx0T4ExbXX9i1dH61NhQBAm', 1, '2024-08-07 01:15:19', '2024-08-07 01:15:19'),
(28, '006935', NULL, NULL, NULL, NULL, NULL, 1, '2024-08-07 01:17:59', '2024-08-07 01:17:59'),
(30, '00C648', NULL, NULL, NULL, NULL, 'JYg0S1VU15z1n33xE6Aq4rFE6132Nrw6GAbZ7sszVxHvainm423rJ2wG4XfO', 1, '2024-08-07 23:50:00', '2024-08-07 23:50:00'),
(32, '00d751', NULL, NULL, NULL, NULL, 'Yh8aMJPgNAYTPHGNE2LJh3IWVcEsr3bh5NHMjL7KAbMCXg9Gxg6GJLhUYvRY', 1, '2024-08-08 23:37:47', '2024-10-10 06:59:25'),
(34, '009166', NULL, NULL, NULL, NULL, 'lqSixX6J7ViOl4Zh9yk4WckiTs1IyaUHrK6ENWi0Grb30orn3KlSoXjBbOsv', 1, '2024-08-23 01:12:24', '2024-08-23 01:12:24'),
(35, '005879', NULL, NULL, NULL, NULL, '90s5YUryuNgsYOOySZv7vnXyidKG9r6TjYzysLtPqcW7fMDFSY69Ol03i69u', 1, '2024-09-18 07:09:47', '2024-09-18 07:09:47'),
(36, 'admin', 'admin', 'admin111@gmail.com', NULL, '$2y$10$zdySVo5DfkOvX/VGdUCGXePLQ3TQELvw.ao4iWRl4a5wR1zCIn.7m', NULL, 1, '2024-09-20 04:25:54', '2024-09-20 04:25:54'),
(39, '000069', NULL, NULL, NULL, NULL, 'VYx4XS8dyW5zsVElUXzjnJs6m5Lws71ynZ0k4QG1ZvVHVBg2swYxfh0Dtqmw', 1, '2024-09-26 01:20:42', '2024-09-26 01:20:42'),
(47, '003559', NULL, NULL, NULL, NULL, 'znlbAKvQMfGouAIA8nMvK2LsUU21F7rQG3BXCc7AEDCzGSZo5D0RVUbRxkK3', 1, '2024-10-10 06:53:31', '2024-10-10 06:57:34');

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
(2, 36, 1, 8, '2021-03-24 15:33:51', '2021-03-24 15:33:51'),
(15, 25, NULL, 7, '2022-03-01 12:30:07', '2022-03-01 12:30:07'),
(23, 30, NULL, 5, '2022-03-01 12:30:47', '2022-03-01 12:30:47'),
(25, 26, NULL, 1, '2022-03-01 12:32:54', '2022-03-01 12:32:54'),
(46, 46, 235, 8, '2022-09-07 11:25:30', '2022-09-07 11:25:30'),
(51, 32, NULL, 6, '2024-08-09 06:37:48', '2024-08-09 06:37:48'),
(53, 34, NULL, 3, '2024-08-23 08:12:24', '2024-08-23 08:12:24'),
(54, 35, NULL, 8, '2024-09-18 14:09:47', '2024-09-18 14:09:47'),
(55, 39, NULL, 8, '2024-09-26 08:20:42', '2024-09-26 08:20:42'),
(59, 47, NULL, 15, '2024-10-10 13:53:31', '2024-10-10 13:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `VEN_ID` varchar(15) NOT NULL DEFAULT '',
  `ACC_CODE` varchar(10) NOT NULL DEFAULT '',
  `CONTACT_NAME` varchar(50) NOT NULL DEFAULT '',
  `VEN_NTHAI` varchar(70) NOT NULL DEFAULT '',
  `VEN_NENG` varchar(70) NOT NULL DEFAULT '',
  `ADDRESS` varchar(70) NOT NULL DEFAULT '',
  `ROAD` varchar(30) NOT NULL DEFAULT '',
  `DISTRICT` varchar(30) NOT NULL DEFAULT '',
  `AMPHUR` varchar(30) NOT NULL DEFAULT '',
  `PROVINCE` varchar(30) NOT NULL DEFAULT '',
  `POSTCODE` varchar(5) NOT NULL DEFAULT '',
  `TEL` varchar(20) NOT NULL DEFAULT '',
  `MOBILE` varchar(12) NOT NULL DEFAULT '',
  `FAX` varchar(12) NOT NULL DEFAULT '',
  `DISCOUNT` decimal(5,2) NOT NULL DEFAULT 0.00,
  `CREDIT_LIMIT` decimal(10,0) NOT NULL DEFAULT 0,
  `CREDIT_DAY` decimal(5,0) NOT NULL DEFAULT 0,
  `MAP` varchar(100) NOT NULL DEFAULT '',
  `USER_EDIT` varchar(15) NOT NULL DEFAULT '',
  `EDIT_DT` datetime NOT NULL DEFAULT '1900-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`VEN_ID`, `ACC_CODE`, `CONTACT_NAME`, `VEN_NTHAI`, `VEN_NENG`, `ADDRESS`, `ROAD`, `DISTRICT`, `AMPHUR`, `PROVINCE`, `POSTCODE`, `TEL`, `MOBILE`, `FAX`, `DISCOUNT`, `CREDIT_LIMIT`, `CREDIT_DAY`, `MAP`, `USER_EDIT`, `EDIT_DT`) VALUES
('5050', '', '', 'บ.เคเอ็ม อินเตอร์แล็บ จำกัด', 'Km Interlab Co.,Ltd', '', '', '', '', '', '', '', '', '', 0.00, 0, 0, '', '', '1900-01-01 00:00:00'),
('7162', '-', 'คุณณัฐธิสา', 'VV.วิโรจน์ (คลังย่อย)', 'VV.', '89/1 ซ.รัชฏภัณฑ์', 'ถ.ราชปรารภ', 'แขวงมักกะสัน', 'เขตราชเทวี', 'กรุงเทพมหานคร', '10400', '-', '-', '-', 0.00, 0, 0, '', 'kaesinee', '2012-02-13 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesseries`
--
ALTER TABLE `accesseries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acctypes`
--
ALTER TABLE `acctypes`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `brand_ps`
--
ALTER TABLE `brand_ps`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_products`
--
ALTER TABLE `com_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_id_2` (`company_id`,`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `barcode` (`barcode`),
  ADD KEY `no_wh_stock` (`on_wh_stock`),
  ADD KEY `category` (`category`),
  ADD KEY `product_id_2` (`product_id`,`category`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`COMPANY`,`BRAND`,`DOC_TP`) USING BTREE;

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
-- Indexes for table `grp_ps`
--
ALTER TABLE `grp_ps`
  ADD PRIMARY KEY (`GRP_P`);

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
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`OWNER`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pdms`
--
ALTER TABLE `pdms`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `product1s`
--
ALTER TABLE `product1s`
  ADD PRIMARY KEY (`PRODUCT`),
  ADD UNIQUE KEY `BARCODE` (`BARCODE`);

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
  ADD PRIMARY KEY (`PRODUCT`),
  ADD UNIQUE KEY `BARCODE` (`BARCODE`);

--
-- Indexes for table `p_statuses`
--
ALTER TABLE `p_statuses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `solutions`
--
ALTER TABLE `solutions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `trn_dona_totambons`
--
ALTER TABLE `trn_dona_totambons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_gs`
--
ALTER TABLE `type_gs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `unit_ps`
--
ALTER TABLE `unit_ps`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `unit_types`
--
ALTER TABLE `unit_types`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`VEN_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesseries`
--
ALTER TABLE `accesseries`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barcodes`
--
ALTER TABLE `barcodes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT for table `com_products`
--
ALTER TABLE `com_products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221971;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `menu_relations`
--
ALTER TABLE `menu_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `trn_dona_totambons`
--
ALTER TABLE `trn_dona_totambons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
