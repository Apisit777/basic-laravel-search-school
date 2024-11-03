-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 09:00 PM
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
-- Table structure for table `log_pro_develops`
--

CREATE TABLE `log_pro_develops` (
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
-- Dumping data for table `log_pro_develops`
--

INSERT INTO `log_pro_develops` (`BRAND`, `DOC_NO`, `REF_DOC`, `REVISE_NO`, `EDIT_DT`, `USER_EDIT`, `STATUS`, `REMARK_ST`, `CUST_OEM`, `JOB_REFNO`, `DOC_DT`, `NPD`, `PDM`, `NAME_ENG`, `PRODUCT`, `BARCODE`, `CATEGORY`, `CAPACITY`, `Q_SMELL`, `Q_COLOR`, `TARGET_GRP`, `TARGET_STK`, `PRICE_FG`, `PRICE_COST`, `PRICE_BULK`, `P_CONCEPT`, `P_BENEFIT`, `TEXTURE`, `TEXTURE_OT`, `COLOR1`, `COLOR2`, `COLOR3`, `FRANGRANCE`, `INGREDIENT`, `STD`, `PK`, `OTHER`, `DOCUMENT`, `FIRST_ORD`, `OEM`, `REASON1`, `REASON1_DES`, `REASON2`, `REASON2_DES`, `REASON3`, `REASON3_DES`, `REF_COLOR`, `REF_FRAGRANCE`, `OEM_STD`, `PACKAGE_BOX`) VALUES
('OP', NULL, 'IBH-F155', 0, '2024-11-03 00:00:00', '32', '', '', NULL, NULL, '2024-11-03', '008', '001', NULL, '20009', '8850080200096', '001', NULL, NULL, NULL, NULL, '2024-11-03', NULL, NULL, NULL, NULL, NULL, '001', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', '', 'N', NULL, 'N', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_pro_develops`
--
ALTER TABLE `log_pro_develops`
  ADD PRIMARY KEY (`PRODUCT`),
  ADD UNIQUE KEY `BARCODE` (`BARCODE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
