-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2020 at 08:38 AM
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
-- Table structure for table `salary_levels`
--

DROP TABLE IF EXISTS `salary_levels`;
CREATE TABLE IF NOT EXISTS `salary_levels` (
  `salary_level_id` tinyint UNSIGNED NOT NULL,
  `salary_level_kh` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_level_en` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`salary_level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_levels`
--

INSERT INTO `salary_levels` (`salary_level_id`, `salary_level_kh`, `salary_level_en`) VALUES
(1, 'ក១', 'A1'),
(2, 'ក២', 'A2'),
(3, 'ក៣', 'A3'),
(4, 'ខ១', 'B1'),
(5, 'ខ២', 'B2'),
(6, 'ខ៣', 'B3'),
(9, 'គ', 'C');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
