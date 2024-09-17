-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 03, 2020 at 02:49 AM
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
-- Table structure for table `sys_position_categories`
--

DROP TABLE IF EXISTS `sys_position_categories`;
CREATE TABLE IF NOT EXISTS `sys_position_categories` (
  `pos_category_id` smallint UNSIGNED NOT NULL,
  `pos_category_kh` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos_category_en` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`pos_category_id`),
  KEY `sys_position_categories_pos_category_kh_pos_category_en_index` (`pos_category_kh`,`pos_category_en`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_position_categories`
--

INSERT INTO `sys_position_categories` (`pos_category_id`, `pos_category_kh`, `pos_category_en`) VALUES
(1, 'អ្នកដឹកនាំថ្នាក់ខ្ពស់', 'Top Manager'),
(2, 'អ្នកដឹកនាំថ្នាក់កណ្តាល', 'Middle Manager'),
(3, 'អ្នកដឹកនាំថ្នាក់ទាប', 'Low Manager'),
(4, 'បុគ្គលិក', 'Staff');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
