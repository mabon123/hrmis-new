-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 10, 2020 at 01:30 AM
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
-- Table structure for table `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE IF NOT EXISTS `admin_permissions` (
  `permission_id` smallint UNSIGNED NOT NULL,
  `permission_kh` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_en` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `idx_permission_slug` (`permission_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`permission_id`, `permission_kh`, `permission_en`, `permission_slug`, `active`) VALUES
(1, 'មើលពត៌មានបុគ្គលិក', 'View Staff', 'view-staffs', 1),
(2, 'បង្កើតពត៌មានបុគ្គលិក', 'Create Staff', 'create-staffs', 1),
(3, 'កែប្រែពត៌មានបុគ្គលិក', 'Edit Staff', 'edit-staffs', 1),
(4, 'លុបពត៌មានបុគ្គលិក', 'Delete Staff', 'delete-staffs', 1),
(5, 'មើលពត៌មានសាលារៀន', 'View School', 'view-schools', 1),
(6, 'បង្កើតពត៌មានសាលារៀន', 'Create School', 'create-schools', 1),
(7, 'កែប្រែពត៌មានសាលារៀន', 'Edit School', 'edit-schools', 1),
(8, 'លុបពត៌មានសាលារៀន', 'Delete School', 'delete-schools', 1),
(9, 'បង្កើតពត៌មានបុគ្គលិកកិច្ចសន្យា', 'Create Contract Staffs', 'create-cont-staffs', 1),
(10, 'មើលពត៌មានបុគ្គលិកកិច្ចសន្យា', 'View Contract Staffs', 'view-cont-staffs', 1),
(11, 'កែប្រែពត៌មានបុគ្គលិកកិច្ចសន្យា', 'Edit Contract Staffs', 'edit-cont-staffs', 1),
(12, 'លុបពត៌មានបុគ្គលិកកិច្ចសន្យា', 'Delete Contract Staffs', 'delete-cont-staffs', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
