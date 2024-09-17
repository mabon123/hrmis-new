-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2021 at 04:16 AM
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
-- Table structure for table `sys_contstaff_positions`
--

DROP TABLE IF EXISTS `sys_contstaff_positions`;
CREATE TABLE IF NOT EXISTS `sys_contstaff_positions` (
  `cont_pos_id` tinyint NOT NULL,
  `contract_type_id` tinyint UNSIGNED NOT NULL,
  `cont_pos_kh` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cont_pos_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cont_pos_id`),
  KEY `sys_contstaff_positions_contract_type_id_foreign` (`contract_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_contstaff_positions`
--

INSERT INTO `sys_contstaff_positions` (`cont_pos_id`, `contract_type_id`, `cont_pos_kh`, `cont_pos_en`) VALUES
(1, 3, 'អក្ខរកម្ម', NULL),
(2, 3, 'សមមូល (បឋមសិក្សា)', NULL),
(3, 3, 'សមមូល (មធ្យមសិក្សាបឋមភូមិ)', NULL),
(4, 3, 'ចូលរៀនឡើងវិញ', NULL),
(5, 3, 'កម្មវិធីបង្កើនប្រាក់ចំណូល', NULL),
(6, 1, 'អ្នកបើកបរ', 'Driver'),
(7, 1, 'អ្នកមើលថែសួន', 'Gardener'),
(8, 2, 'គណិតវិទ្យា', 'Mathematics'),
(9, 2, 'ភាសាអង់គ្លេស', 'English'),
(10, 1, 'សន្តិសុខ', 'Security Guard');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
