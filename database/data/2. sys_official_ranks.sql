-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2020 at 09:21 AM
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
-- Table structure for table `sys_official_ranks`
--

DROP TABLE IF EXISTS `sys_official_ranks`;
CREATE TABLE IF NOT EXISTS `sys_official_ranks` (
  `official_rank_id` smallint UNSIGNED NOT NULL,
  `official_rank_kh` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `official_rank_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_level_id` tinyint NOT NULL,
  PRIMARY KEY (`official_rank_id`),
  KEY `sys_official_ranks_official_rank_en_official_rank_kh_index` (`official_rank_en`,`official_rank_kh`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_official_ranks`
--

INSERT INTO `sys_official_ranks` (`official_rank_id`, `official_rank_kh`, `official_rank_en`, `salary_level_id`) VALUES
(1, 'ឧត្តមមន្ត្រី', NULL, 1),
(2, 'វរៈមន្ត្រី', NULL, 2),
(3, 'អនុមន្ត្រី', NULL, 3),
(4, 'នាយក្រមការ', NULL, 4),
(5, 'ក្រមការដើមខ្សែ', NULL, 5),
(6, 'ក្រមការ', NULL, 6),
(7, 'នាយលេខាធិការរដ្ឋបាល', NULL, 7),
(8, 'លេខាធិការរដ្ឋបាលដើមខ្សែ', NULL, 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;