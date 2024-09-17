-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 18, 2022 at 02:52 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

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
-- Table structure for table `sys_hour_teachings`
--

DROP TABLE IF EXISTS `sys_hour_teachings`;
CREATE TABLE IF NOT EXISTS `sys_hour_teachings` (
  `hour_id` tinyint NOT NULL,
  `hour_kh` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_en` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_order` tinyint NOT NULL,
  `school_level` tinyint DEFAULT NULL,
  `shift` tinyint DEFAULT NULL,
  PRIMARY KEY (`hour_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_hour_teachings`
--

INSERT INTO `sys_hour_teachings` (`hour_id`, `hour_kh`, `hour_en`, `hour_order`, `school_level`, `shift`) VALUES
(1, '០៧:០០-០៨:០០', '07:00-08:00', 1, 3, NULL),
(2, '០៨:០០-០៩:០០', '08:00-09:00', 2, 3, NULL),
(3, '០៩:០០-១០:០០', '09:00-10:00', 3, 3, NULL),
(4, '១០:០០-១១:០០', '10:00-11:00', 4, 3, NULL),
(5, '១១:០០-១២:០០', '11:00-12:00', 5, 3, NULL),
(6, '១២:០០-១៣:០០', '12:00-13:00', 6, 3, NULL),
(7, '១៣:០០-១៤:០០', '13:00-14:00', 7, 3, NULL),
(8, '១៤:០០-១៥:០០', '14:00-15:00', 8, 3, NULL),
(9, '១៥:០០-១៦:០០', '15:00-16:00', 9, 3, NULL),
(10, '១៦:០០-១៧:០០', '16:00-17:00', 10, 3, NULL),
(12, '៧ៈ១០ - ៧ៈ៥០', '7:10 - 7:50', 2, 2, 1),
(13, '៧ៈ៥០ - ៨ៈ៣០', '7:50 - 8:30', 3, 2, 1),
(14, '៨ៈ៣០ - ៨ៈ៤៥', '8:30 - 8:45', 4, 2, 1),
(15, '៨ៈ៤៥ - ៩ៈ២៥', '9:25 - 9:40', 5, 2, 1),
(16, '៩ៈ២៥ - ៩ៈ៤០', '9:25 - 9:40', 6, 2, 1),
(17, '៩ៈ៤០ - ១០ៈ២០', '9:40 - 10:20', 7, 2, 1),
(18, '១០ៈ២០ - ១១ៈ០០', '10:20 - 11:00', 8, 2, 1),
(19, '១ៈ០០ - ១ៈ៤០', '1:00 - 1:40', 9, 2, 2),
(20, '១ៈ៤០ - ២ៈ២០', '1:40 - 2:20', 10, 2, 2),
(21, '២ៈ២០ - ២ៈ៣៥', '2:20 - 2:35', 11, 2, 2),
(22, '២ៈ៣៥ - ៣ៈ១៥', '2:35 - 3:15', 12, 2, 2),
(23, '៣ៈ១៥ - ៣ៈ៣០', '3:15 - 3:30', 13, 2, 2),
(24, '៣ៈ៣០ - ៤ៈ១០', '3:30 - 4:10', 14, 2, 2),
(25, '៤ៈ១០ - ៤ៈ៥០', '4:10 - 5:50', 15, 2, 2),
(11, '៦ៈ៥៥ - ៧ៈ១០', '6:55 - 7:10', 1, 2, 1),
(26, '៤ៈ៥០ - ៥ៈ០៥', '4:50 - 5:05', 16, 2, 2),
(27, '៧ៈ០០ - ៧ៈ១០', '7:00 - 7:10', 1, 1, 1),
(28, '៧ៈ១០ - ៧ៈ៤០', '7:10 - 7:40', 2, 1, 1),
(29, '៧ៈ៤០ - ៨៖១០', '7:40 - 8:10', 3, 1, 1),
(30, '៨ៈ១០ - ៨ៈ៤០', '8:10 - 8:40', 4, 1, 1),
(31, '៨ៈ៤០ - ៨ៈ៥០', '8:40 - 8:50', 5, 1, 1),
(32, '៨ៈ៥០ - ៩ៈ២០', '8:50 - 9:20', 6, 1, 1),
(33, '៩ៈ២០ - ៩ៈ៥០', '9:20 - 9:50', 7, 1, 1),
(34, '៩ៈ៥០ - ១០ៈ០០', '9:50 - 10:00', 8, 1, 1),
(45, '១០ៈ០០ - ១០ៈ៣០', '10:00 - 10:30', 9, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
