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
-- Table structure for table `sys_contract_types`
--

DROP TABLE IF EXISTS `sys_contract_types`;
CREATE TABLE IF NOT EXISTS `sys_contract_types` (
  `contract_type_id` tinyint NOT NULL,
  `contract_type_kh` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_type_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`contract_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_contract_types`
--

INSERT INTO `sys_contract_types` (`contract_type_id`, `contract_type_kh`, `contract_type_en`) VALUES
(1, 'មន្ត្រីកិច្ចសន្យា', 'Contract Staff'),
(2, 'គ្រូកិច្ចសន្យាចំណេះទូទៅ', 'General Contract Teacher'),
(3, 'គ្រូបង្រៀនកិច្ចសន្យាអប់រំក្រៅប្រព័ន្ធ', NULL),
(4, 'បញ្ចប់ភារកិច្ច', 'Ended Contract');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
