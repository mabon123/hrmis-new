-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2021 at 08:42 AM
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
-- Table structure for table `cpd_provider_categories`
--

DROP TABLE IF EXISTS `cpd_provider_categories`;
CREATE TABLE IF NOT EXISTS `cpd_provider_categories` (
  `provider_cat_id` tinyint UNSIGNED NOT NULL,
  `provider_type_id` tinyint UNSIGNED NOT NULL,
  `provider_cat_kh` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_cat_en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`provider_cat_id`),
  KEY `cpd_provider_categories_provider_type_id_foreign` (`provider_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cpd_provider_categories`
--

INSERT INTO `cpd_provider_categories` (`provider_cat_id`, `provider_type_id`, `provider_cat_kh`, `provider_cat_en`) VALUES
(1, 1, 'គ្រឺះស្ថានអប់រំគ្រូបង្រៀន', 'TEI'),
(2, 2, 'នាយកដ្ឋានជំនាញ', 'MoEYS department'),
(3, 1, 'គ្រឺះស្ថានឧត្តមសិក្សា', 'HEI, such as RUPP'),
(4, 2, 'អង្គការក្រៅរដ្ឋាភិបាល', 'NGO'),
(5, 2, 'ផ្សេងទៀត (សូមបញ្ជាក់)', 'Other'),
(6, 2, 'អ្នកផ្តល់សេវា អវប ជាបុគ្គល', 'Individual Provider'),
(7, 2, 'អ្នកផ្តល់សេវា អវប ឯកជន', 'Private Provider');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
