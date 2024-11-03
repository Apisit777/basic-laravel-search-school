-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 08:59 PM
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
-- Table structure for table `log_product1s`
--

CREATE TABLE `log_product1s` (
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
