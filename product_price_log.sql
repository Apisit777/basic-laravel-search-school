/*
Navicat MySQL Data Transfer

Source Server         : sap.mykm.com/accounting
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : accounting

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2025-02-21 17:00:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `product_price_log`
-- ----------------------------
DROP TABLE IF EXISTS `product_price_log`;
CREATE TABLE `product_price_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(15) NOT NULL,
  `active_date` date DEFAULT NULL,
  `action` varchar(20) NOT NULL,
  `old_data` text NOT NULL,
  `new_data` text NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26360 DEFAULT CHARSET=utf8;
