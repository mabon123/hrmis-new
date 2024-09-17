-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2021 at 08:40 AM
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
-- Table structure for table `cpd_courses`
--

DROP TABLE IF EXISTS `cpd_courses`;
CREATE TABLE IF NOT EXISTS `cpd_courses` (
  `cpd_course_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `cpd_course_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpd_course_type_id` tinyint UNSIGNED NOT NULL,
  `cpd_course_kh` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpd_course_en` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpd_course_desc_kh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cpd_course_desc_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `end_date` date DEFAULT NULL,
  `credits` double(4,2) NOT NULL,
  `duration_hour` smallint UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cpd_course_id`),
  KEY `cpd_courses_cpd_course_type_id_foreign` (`cpd_course_type_id`),
  KEY `cpd_courses_created_by_foreign` (`created_by`),
  KEY `cpd_courses_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cpd_courses`
--

INSERT INTO `cpd_courses` (`cpd_course_id`, `cpd_course_code`, `cpd_course_type_id`, `cpd_course_kh`, `cpd_course_en`, `cpd_course_desc_kh`, `cpd_course_desc_en`, `end_date`, `credits`, `duration_hour`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'CCODE0001', 2, 'ការអប់រំចិត្តវិទ្យា', 'Education Psychology', '<p>ការអប់រំចិត្តវិទ្យា<br></p>', '<p><span style=\"font-family: &quot;Times New Roman&quot;;\">﻿</span><font face=\"Times New Roman\">Education Psychology</font><br></p>', '2021-12-31', 2.00, 45, 1, 1, 1, '2021-07-07 02:49:20', '2021-07-07 02:49:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
