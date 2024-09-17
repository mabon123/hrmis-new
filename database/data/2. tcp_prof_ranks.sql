-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2022 at 03:07 PM
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
-- Table structure for table `tcp_prof_ranks`
--

DROP TABLE IF EXISTS `tcp_prof_ranks`;
CREATE TABLE IF NOT EXISTS `tcp_prof_ranks` (
  `tcp_prof_rank_id` tinyint UNSIGNED NOT NULL,
  `tcp_prof_cat_id` tinyint UNSIGNED NOT NULL,
  `tcp_prof_rank_kh` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tcp_prof_rank_en` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank_hierarchy` tinyint NOT NULL,
  `rank_low` smallint DEFAULT NULL,
  `rank_high` smallint DEFAULT NULL,
  PRIMARY KEY (`tcp_prof_rank_id`),
  KEY `tcp_prof_ranks_tcp_prof_cat_id_foreign` (`tcp_prof_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tcp_prof_ranks`
--

INSERT INTO `tcp_prof_ranks` (`tcp_prof_rank_id`, `tcp_prof_cat_id`, `tcp_prof_rank_kh`, `tcp_prof_rank_en`, `rank_hierarchy`, `rank_low`, `rank_high`) VALUES
(1, 1, 'គ្រូល្អ', 'Good Teacher', 1, 250, 400),
(2, 1, 'គ្រូឈានមុខ', 'Senior Teacher', 2, 400, 490),
(3, 1, 'គ្រូឆ្នើម', 'Master Teacher', 3, 490, 500),
(4, 2, 'នាយកល្អ', 'Good Leader', 1, 250, 400),
(5, 2, 'នាយកឈានមុខ', 'Senior Leader', 2, 400, 490),
(6, 2, 'នាយកឆ្នើម', 'Master Leader', 3, 490, 500),
(7, 3, 'អ្នកឯកទេសអប់រំល្អ', 'Good Education Specialist', 1, 250, 400),
(8, 3, 'អ្នកឯកទេសអប់រំឈានមុខ', 'Senior Education Specialist', 2, 400, 490),
(9, 3, 'អ្នកឯកទេសអប់រំឆ្នើម', 'Master Education Specialist', 3, 490, 500);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
