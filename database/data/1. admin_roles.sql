-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 24, 2020 at 04:36 AM
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
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE IF NOT EXISTS `admin_roles` (
  `role_id` smallint UNSIGNED NOT NULL,
  `role_kh` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_en` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_slug` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `idx_role_slug` (`role_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`role_id`, `role_kh`, `role_en`, `role_slug`, `active`) VALUES
(1, 'អ្នកគ្រប់គ្រងប្រព័ន្ធទាំងមូល', 'System Administrator', 'administrator', 1),
(2, 'គណៈកម្មាធិការគ្រប់គ្រង CPD', 'CPD Committee', 'cpd_committee', 1),
(3, 'អ្នកផ្ដល់​ CPD', 'CPD Provider', 'cpd_provider', 1),
(4, 'អ្នកគ្រប់គ្រងប្រព័ន្ធថ្នាក់នាយកដ្ឋាន', 'Department Administrator', 'dept-admin', 1),
(5, 'អ្នកគ្រប់គ្រងប្រព័ន្ធមន្ទីរអប់រំខេត្ត', 'POE Administrator', 'poe-admin', 1),
(6, 'អ្នកគ្រង់គ្រងប្រព័ន្ធការិយាល័យអប់រំស្រុក', 'DOE Administrator', 'doe-admin', 1),
(7, 'អ្នកគ្រប់គ្រងប្រព័ន្ធសាលារៀន', 'School Administrator', 'school-admin', 1),
(8, 'បុគ្គលិកអបំរំ​ / គ្រូបង្រៀន', 'Staff Member/Teacher', 'teacher', 1),
(9, 'អ្នកឯកទេសអប់រំ', 'Education Specialist', 'edu-specialist', 1),
(10, 'អ្នកប្រើប្រាស់កម្មវិធីទូរស័ព្ទដៃ', 'Mobile User', 'mobile-user', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
