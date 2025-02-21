/*
Navicat MySQL Data Transfer

Source Server         : sap.mykm.com/accounting
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : accounting

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2025-02-21 16:59:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `product_price`
-- ----------------------------
DROP TABLE IF EXISTS `product_price`;
CREATE TABLE `product_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(15) NOT NULL COMMENT 'รหัสบัญชีสินค้า',
  `status` int(2) NOT NULL DEFAULT '1',
  `price` decimal(15,2) NOT NULL COMMENT 'ราคาสินค้า',
  `cost` decimal(15,2) DEFAULT NULL,
  `perfume_tax` decimal(15,2) DEFAULT NULL,
  `cost_perfume_tax` decimal(15,2) DEFAULT NULL,
  `cost5percent` decimal(15,2) DEFAULT NULL,
  `cost10percent` decimal(15,2) DEFAULT NULL,
  `cost_other` decimal(15,2) DEFAULT NULL,
  `sale_km` decimal(15,2) DEFAULT NULL,
  `sale_km20percent` decimal(15,2) DEFAULT NULL,
  `sale_km_other` decimal(15,2) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(10) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=25682 DEFAULT CHARSET=utf8;
