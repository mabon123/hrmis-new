-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 08, 2022 at 09:23 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrmisdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `sys_report_headers`
--

DROP TABLE IF EXISTS `sys_report_headers`;
CREATE TABLE IF NOT EXISTS `sys_report_headers` (
  `header_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `field_id` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`header_id`),
  KEY `sys_report_headers_user_id_foreign` (`user_id`),
  KEY `sys_report_headers_field_id_foreign` (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_report_headers`
--

INSERT INTO `sys_report_headers` (`header_id`, `user_id`, `field_id`) VALUES
(101, 1, 23),
(100, 1, 14),
(99, 1, 7),
(98, 1, 6),
(97, 1, 5),
(96, 1, 4),
(95, 1, 3),
(94, 1, 2),
(93, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
