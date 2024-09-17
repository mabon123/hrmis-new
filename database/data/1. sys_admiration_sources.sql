-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2020 at 04:20 AM
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
-- Table structure for table `sys_admiration_sources`
--

DROP TABLE IF EXISTS `sys_admiration_sources`;
CREATE TABLE IF NOT EXISTS `sys_admiration_sources` (
  `source_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `source_kh` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`source_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_admiration_sources`
--

INSERT INTO `sys_admiration_sources` (`source_id`, `source_kh`, `source_en`) VALUES
(1, 'ព្រះមហាក្សត្រ', 'King'),
(2, 'រដ្ឋាភិបាល', 'Government'),
(3, 'ក្រសួង', 'Ministry'),
(4, 'មន្ទីរ', 'POE'),
(5, 'ក្រុង/ស្រក', 'DOE'),
(6, 'កម្រង', NULL),
(7, 'សាលា', 'School'),
(8, 'សហគមន៍', 'Community'),
(9, 'ដៃគូរ', 'Partner');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
