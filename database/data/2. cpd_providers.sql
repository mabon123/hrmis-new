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
-- Table structure for table `cpd_providers`
--

DROP TABLE IF EXISTS `cpd_providers`;
CREATE TABLE IF NOT EXISTS `cpd_providers` (
  `provider_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider_type_id` tinyint UNSIGNED NOT NULL,
  `payroll_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_cat_id` tinyint UNSIGNED NOT NULL,
  `accreditation_id` tinyint UNSIGNED NOT NULL,
  `accreditation_date` date NOT NULL,
  `provider_kh` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_logo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pro_code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dis_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `com_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vil_code` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`provider_id`),
  KEY `cpd_providers_provider_type_id_foreign` (`provider_type_id`),
  KEY `cpd_providers_provider_cat_id_foreign` (`provider_cat_id`),
  KEY `cpd_providers_accreditation_id_foreign` (`accreditation_id`),
  KEY `cpd_providers_created_by_foreign` (`created_by`),
  KEY `cpd_providers_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cpd_providers`
--

INSERT INTO `cpd_providers` (`provider_id`, `provider_type_id`, `payroll_id`, `provider_cat_id`, `accreditation_id`, `accreditation_date`, `provider_kh`, `provider_en`, `provider_email`, `provider_phone`, `provider_logo`, `pro_code`, `dis_code`, `com_code`, `vil_code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 3, 1, '2020-01-01', 'សាកលវិទ្យាល័យភូមិន្ទភ្នំពេញ', 'Royal University of Phnom Penh', 'info@rupp.edu.kh', '023 999 123', 'royal_university_of_phnom_penh.png', '12', '1204', '120410', '12041012', 1, 1, '2021-07-09 08:34:34', '2021-07-09 08:34:34'),
(2, 1, NULL, 3, 2, '2021-01-01', 'សាកលវិទ្យាល័យអាមេរិកាំងភ្នំពេញ', 'American University of Phnom Penh', 'career@aupp.edu.kh', '023 999 456', 'american_university_of_phnom_penh.png', '12', '1207', '120704', '12070401', 1, 1, '2021-07-09 08:36:27', '2021-07-09 08:36:27'),
(3, 1, NULL, 3, 1, '2020-06-01', 'វិទ្យាស្ថានបច្ចេកវិទ្យាកម្ពុជា', 'Institution Technology de Cambodge', 'contact@itc.edu.kh', '023 999 124', 'institution_technology_de_cambodge.jpg', '12', '1204', '120410', '12041014', 1, 1, '2021-07-09 08:39:15', '2021-07-09 08:39:15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
