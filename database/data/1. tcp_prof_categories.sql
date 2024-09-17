-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2022 at 01:58 PM
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
-- Table structure for table `tcp_prof_categories`
--

DROP TABLE IF EXISTS `tcp_prof_categories`;
CREATE TABLE IF NOT EXISTS `tcp_prof_categories` (
  `tcp_prof_cat_id` tinyint UNSIGNED NOT NULL,
  `tcp_prof_cat_kh` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tcp_prof_cat_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`tcp_prof_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tcp_prof_categories`
--

INSERT INTO `tcp_prof_categories` (`tcp_prof_cat_id`, `tcp_prof_cat_kh`, `tcp_prof_cat_en`) VALUES
(1, 'គន្លងបង្រៀន', 'Teaching Track'),
(2, 'គន្លងគ្រប់គ្រង', 'Leadership Track'),
(3, 'គន្លងអ្នកឯកទេសអប់រំ', 'Education Specialist Track');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
