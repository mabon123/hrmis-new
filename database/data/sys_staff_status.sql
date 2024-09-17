-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2020 at 02:42 AM
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
-- Table structure for table `sys_staff_status`
--

DROP TABLE IF EXISTS `sys_staff_status`;
CREATE TABLE IF NOT EXISTS `sys_staff_status` (
  `status_id` smallint UNSIGNED NOT NULL,
  `status_kh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`status_id`),
  KEY `sys_staff_status_status_en_status_kh_index` (`status_en`,`status_kh`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_staff_status`
--

INSERT INTO `sys_staff_status` (`status_id`, `status_kh`, `status_en`) VALUES
(1, 'សកម្ម', 'Active'),
(2, 'ទំនេរគ្មានបៀវត្ស', 'Leave without pay'),
(3, 'លុបឈ្មោះ', 'Quit'),
(4, 'ផ្ទេរចេញក្រៅខេត្ត', 'Transfer within ministry'),
(5, 'មរណភាព', 'Dead'),
(6, 'ចូលនិវត្តន៏', 'Retired'),
(7, 'ជ្រើសរើស', 'Choose'),
(8, 'ក្រៅក្របខ័ណ្ឌដើម', 'Off Duty'),
(9, 'ផ្ទេរចេញក្រៅក្រសួង', 'Transfer out of ministry'),
(10, 'បន្តការសិក្សា', 'Continue Study'),
(11, 'ក្របខ័ណ្ឌនយោបាយ', 'Politics'),
(12, 'គ្រូកិច្ចសន្យា', 'Contract Teacher'),
(13, 'បញ្ចប់ភារកិច្ច', 'End of Duty'),
(14, 'គរុសិស្ស', 'Teacher Training');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
