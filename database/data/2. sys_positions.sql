-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 03, 2020 at 03:40 AM
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
-- Table structure for table `sys_positions`
--

DROP TABLE IF EXISTS `sys_positions`;
CREATE TABLE IF NOT EXISTS `sys_positions` (
  `position_id` smallint UNSIGNED NOT NULL,
  `position_kh` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_en` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_category_id` smallint UNSIGNED NOT NULL,
  `position_hierarchy` smallint UNSIGNED NOT NULL,
  `pos_level_id` smallint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`position_id`),
  KEY `idx_position` (`position_kh`,`position_en`),
  KEY `sys_positions_pos_category_id_foreign` (`pos_category_id`),
  KEY `sys_positions_pos_level_id_foreign` (`pos_level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_positions`
--

INSERT INTO `sys_positions` (`position_id`, `position_kh`, `position_en`, `pos_category_id`, `position_hierarchy`, `pos_level_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'អគ្គនាយក', 'Director General', 2, 18, 1, 1, 1, NULL, NULL),
(2, 'អគ្គាធិការ', 'General Inspector', 2, 16, 1, 1, 1, NULL, NULL),
(3, 'សាកលវិទ្យាធិការ', 'Rector', 2, 18, 1, 1, 1, NULL, NULL),
(4, 'សាស្ត្រាចារ្យមហាបរិញ្ញា', 'Professor', 4, 50, 1, 1, 1, NULL, NULL),
(5, 'អគ្គនាយករង', 'Vice- Director General', 2, 19, 1, 1, 1, NULL, NULL),
(6, 'អគ្គាធិការរង', 'Vice- General Inspector', 2, 17, 1, 1, 1, NULL, NULL),
(7, 'សាកលវិទ្យាធិការរង', 'Vice-Rector', 2, 19, 1, 1, 1, NULL, NULL),
(8, 'ប្រធាននាយកដ្ឋាន', 'Director of Department', 2, 20, 1, 1, 1, NULL, NULL),
(9, 'អធិការ', 'Inspector', 2, 20, 1, 1, 1, NULL, NULL),
(10, 'នាយកវិទ្យាស្ថាន', 'Director of Institute', 2, 20, 1, 1, 1, NULL, NULL),
(11, 'ព្រឹទ្ធបុរស', 'Dean', 2, 20, 0, 1, 1, NULL, NULL),
(12, 'អនុប្រធាននាយកដ្ឋាន', 'Vice- Director of Department', 2, 21, 1, 1, 1, NULL, NULL),
(13, 'អធិការរង', 'Vice-Inspector', 2, 21, 1, 1, 1, NULL, NULL),
(14, 'នាយករងវិទ្យាស្ថាន', 'Vice-Director of Institute', 2, 21, 1, 1, 1, NULL, NULL),
(15, 'ប្រធានមន្ទីររាជធានី-ខេត្ត', 'Director of municipal/provincial Education', 2, 21, 1, 1, 1, NULL, NULL),
(16, 'ព្រឹទ្ធបុរសរង', 'Vice-Dean', 2, 21, 1, 1, 1, NULL, NULL),
(17, 'នាយកសាលាមតេយ្យមជ្ឈឹម', 'Director of central pre-school', 2, 22, 1, 1, 1, NULL, NULL),
(18, 'ប្រធានដេប៉ាតឺម៉ង់', 'Head of Department', 3, 22, 0, 1, 1, NULL, NULL),
(19, 'នាយករងសាលាមតេយ្យមជ្ឈឹម', 'Vice-Director of central pre-school', 3, 24, 1, 1, 1, NULL, NULL),
(20, 'អនុប្រធានដេប៉ាតឺម៉ង់', 'Vice-Head of Department', 3, 24, 1, 1, 1, NULL, NULL),
(21, 'ប្រធានការិ.ថ្នាក់កណ្តាល', 'Chief Office Central Education', 2, 22, 1, 1, 1, NULL, NULL),
(22, 'អនុប្រធានមន្ទីររាជធានី-ខេត្ត', 'Vice- Director of municipal/provincial Education', 2, 23, 1, 1, 1, NULL, NULL),
(23, 'អនុប្រធានការិ.ថ្នាក់កណ្តាល', 'Vice- Chief Office Central Education', 2, 24, 1, 1, 1, NULL, NULL),
(24, 'ប្រធានការិ.រាជធានី-ខេត្ត', 'Chief Office provincial Education', 3, 24, 1, 1, 1, NULL, NULL),
(25, 'អនុប្រធានការិ.រាជធានី-ខេត្ត', 'Vice- Chief Office municipal/provincial Education', 3, 25, 1, 1, 1, NULL, NULL),
(26, 'ប្រធានការិ.ស្រុក-ខ័ណ្ឌ-ក្រុង', 'Chief Office District Education', 3, 25, 1, 1, 1, NULL, NULL),
(27, 'អនុប្រធានការិ.ស្រុក-ខ័ណ្ឌ-ក្រុង', 'Vice-Chief Office District Education', 3, 26, 1, 1, 1, NULL, NULL),
(28, 'មន្ត្រីគ្រប់គ្រងរដ្ឋបាល', 'Official of Administration Management', 4, 36, 1, 1, 1, NULL, NULL),
(29, 'មន្ត្រីក្រមការ', 'Official of Administration Management (b)', 4, 37, 1, 1, 1, NULL, NULL),
(30, 'លេខាធិការ', 'Secretary', 4, 38, 1, 1, 1, NULL, NULL),
(31, 'ភ្នាក់ងាររដ្ឋបាល', 'Official of Administration Management (d)', 4, 39, 1, 1, 1, NULL, NULL),
(32, 'គ្រូឧត្តមសិក្សា', 'Teacher of Higher Education', 4, 36, 1, 1, 1, NULL, NULL),
(33, 'អធិការមធ្យមសិក្សា', 'Secondary Inspector', 3, 27, 0, 1, 1, NULL, NULL),
(34, 'នាយកវិទ្យាល័យ', 'Director of Upper Secondary School', 3, 25, 1, 1, 1, NULL, NULL),
(35, 'នាយករងវិទ្យាល័យ', 'Vice-Director of Upper Secondary School', 3, 25, 1, 1, 1, NULL, NULL),
(36, 'គ្រូមធ្យមសិក្សាទុតិយភូមិ', 'Upper Secondary School Teacher', 4, 36, 1, 1, 1, NULL, NULL),
(37, 'អធិការបឋមសិក្សា', 'Primary Inspector', 3, 28, 1, 1, 1, NULL, NULL),
(38, 'នាយកអនុវិទ្យាល័យ', 'Director of Lower Secondary School', 3, 27, 1, 1, 1, NULL, NULL),
(39, 'នាយករងអនុវិទ្យាល័យ', 'Vice-Director of Lower Secondary School', 3, 28, 1, 1, 1, NULL, NULL),
(40, 'គ្រូមធ្យមសិក្សាបឋមភូមិ', 'Lower Secondary School Teacher', 4, 37, 1, 1, 1, NULL, NULL),
(41, 'នាយកបឋមសិក្សា', 'Director of Primary School', 3, 29, 1, 1, 1, NULL, NULL),
(42, 'នាយករងបឋមសិក្សា       ', 'Vice- Director of Primary School', 3, 30, 1, 1, 1, NULL, NULL),
(43, 'គ្រូបឋមសិក្សា ', 'Primary School Teacher', 4, 38, 1, 1, 1, NULL, NULL),
(44, 'គ្រូមត្តេយសិក្សា', 'Pre-School Teacher', 4, 39, 1, 1, 1, NULL, NULL),
(45, 'នាយកមជ្ឈមណ្ឌលគរុកោសល្យភូមិភាគ', 'Director of Regional Pedagogical Center', 3, 22, 1, 1, 1, NULL, NULL),
(46, 'នាយកសាលាគរុកោសល្យរាជធានី-ខេត្ត', 'Director of Municipal/Provincial Teacher Training Center', 3, 22, 1, 1, 1, NULL, NULL),
(47, 'នាយករងមជ្ឈមណ្ឌលគរុកោសល្យភូមិភាគ', 'Vice- Director of Regional Pedagogical Center', 3, 24, 1, 1, 1, NULL, NULL),
(48, 'នាយករងសាលាគរុកោសល្យរាជធានី-ខេត្ត', 'Vice- Director of Municipal/Provincial Teacher Training Cent', 3, 24, 1, 1, 1, NULL, NULL),
(49, 'នាយកមត្តេយ្យសិក្សា', 'Director of Pre-School', 3, 31, 1, 1, 1, NULL, NULL),
(50, 'នាយករងមត្តេយ្យសិក្សា', 'Vice-Director of Pre-School', 3, 32, 1, 1, 1, NULL, NULL),
(51, 'នាយក រដ្ឋបាល', 'Director of Administration (ITC)', 2, 19, 1, 1, 1, NULL, NULL),
(52, 'នាយក សិក្សា', 'Director of Education (ITC)', 2, 19, 1, 1, 1, NULL, NULL),
(53, 'រដ្ឋលេខាធិការ', 'Secretary Of State', 4, 12, 1, 1, 1, NULL, NULL),
(54, 'អនុរដ្ឋលេខាធិការ', 'Under Secretary Of State', 2, 13, 1, 1, 1, NULL, NULL),
(55, 'រដ្ឋមន្ត្រី', 'Minister', 1, 11, 1, 1, 1, NULL, NULL),
(56, 'សាស្ត្រាចារ្យ ឧត្តមសិក្សា', 'University Lecturer', 4, 33, 1, 1, 1, NULL, NULL),
(57, 'នាយកមជ្ឈមណ្ឌលស្រាវជ្រាវ', 'Director of Center', 2, 22, 1, 1, 1, NULL, NULL),
(58, 'នាយករងមជ្ឈមណ្ឌលស្រាវជ្រាវ', 'Vice-Director of Center', 2, 24, 1, 1, 1, NULL, NULL),
(59, 'នាយកមជ្ឈមណ្ឌលធនធាន', 'Director of Resource Center', 3, 22, 1, 1, 1, NULL, NULL),
(60, 'នាយករងមជ្ឈមណ្ឌលធនធាន', 'Vice-Director of Resource Center', 3, 24, 1, 1, 1, NULL, NULL),
(61, 'គ្រូឧទ្ទេសឧត្តម', NULL, 4, 33, 1, 1, 1, NULL, NULL),
(62, 'ជំនួយការក្រសួង', 'Assistant', 0, 54, 1, 1, 1, NULL, NULL),
(63, 'ទីប្រឹក្សាក្រសួង', 'Adviser', 0, 53, 1, 1, 1, NULL, NULL),
(64, 'អនុប្រធានអង្គភាពលទ្ធកម្ម', 'Vice_Director', 2, 21, 1, 1, 1, NULL, NULL),
(65, 'ប្រធានអង្គភាពលទ្ធកម្ម', 'Director', 2, 20, 1, 1, 1, NULL, NULL),
(66, 'នាយកខុទ្ធការល័យ', NULL, 2, 51, 1, 1, 1, NULL, NULL),
(67, 'នាយករងខុទ្ធការល័យ', NULL, 2, 52, 1, 1, 1, NULL, NULL),
(68, 'បេសកជន ទីប្រឹក្សាបច្ចេកទេស', NULL, 0, 55, 1, 1, 1, NULL, NULL),
(69, 'ជំនួយការខុទ្ធកាល័យ', NULL, 0, 53, 1, 1, 1, NULL, NULL),
(70, 'នាយករង សិក្សា', NULL, 2, 20, 1, 1, 1, NULL, NULL),
(71, 'អនុប្រធានមជ្ឈមណ្ឌល', NULL, 2, 21, 1, 1, 1, NULL, NULL),
(72, 'អនុពន្ធសារព័ត៌មាន', NULL, 0, 51, 1, 1, 1, NULL, NULL),
(73, 'ប្រធានអគ្គនាយក', NULL, 2, 20, 1, 1, 1, NULL, NULL),
(74, 'ប្រធានមជ្ឈមណ្ឌល', 'Vice Center', 2, 20, 1, 1, 1, NULL, NULL),
(75, 'អគ្គលេខាធិការរង', 'Vice', 2, 15, 1, 1, 1, NULL, NULL),
(76, 'អគ្គលេខាធិការ', 'Vice', 2, 14, 1, 1, 1, NULL, NULL),
(77, 'នាយករងប្រតិបត្តិសាខា', 'Deputy CEO', 2, 28, 1, 1, 1, NULL, NULL),
(78, 'នាយកមជ្ឈមណ្ឌលបណ្តុះបណ្តាល', 'Director of Center', 2, 22, 1, 1, 1, NULL, NULL),
(79, 'នាយករងមជ្ឈមណ្ឌលបណ្តុះបណ្តាល', 'Vice-Directo of Center', 2, 24, 1, 1, 1, NULL, NULL),
(80, 'នាយកមជ្ឈមណ្ឌលតំបន់អាស៊ីអាគ្នេយ៍', 'Director of Southeast Asia Center', 2, 20, 1, 1, 1, NULL, NULL),
(81, 'នាយករងមជ្ឈមណ្ឌលតំបន់អាស៊ីអាគ្នេយ៍', 'Vice-Director of Southeast Asia Center', 2, 21, 1, 1, 1, NULL, NULL),
(82, 'គ្រូឧទ្ទេសកម្រិតមូលដ្ឋាន', NULL, 4, 36, 1, 1, 1, NULL, NULL),
(83, 'គ្រូឧទ្ទេសបឋម', NULL, 4, 37, 1, 1, 1, NULL, NULL),
(84, 'អធិការអប់រំ', 'Inspector in Education', 1, 27, 1, 1, 1, NULL, NULL),
(85, 'នាយកវិទ្យាស្ថាន(ITC And NIE)', NULL, 0, 18, 1, 1, 1, NULL, NULL),
(86, 'គ្រូឧទ្ទេសរងឧត្តម', NULL, 4, 34, 1, 1, 1, NULL, NULL),
(87, 'គ្រូឧទ្ទេសជំនួយឧត្តម', NULL, 4, 35, 1, 1, 1, NULL, NULL),
(88, 'នាយកវិទ្យាស្ថានអភិវឌ្ឍន៍សហគមន៍', 'Director of Community Development', 2, 22, 1, 1, 1, NULL, NULL),
(89, 'នាយករងវិទ្យាស្ថានអភិវឌ្ឍន៍សហគមន៍', 'Vice Director of Community Development', 2, 24, 1, 1, 1, NULL, NULL),
(90, 'នាយករងវិទ្យាស្ថាន(ITC And NIE)', NULL, 0, 19, 1, 1, 1, NULL, NULL),
(91, 'រច្ចទេយករ', NULL, 0, 40, 1, 1, 1, NULL, NULL),
(92, 'រច្ចទេយកររង', NULL, 0, 41, 1, 1, 1, NULL, NULL),
(93, 'គណនេយ្យករ', NULL, 0, 42, 1, 1, 1, NULL, NULL),
(94, 'បេឡាករ', NULL, 0, 43, 1, 1, 1, NULL, NULL),
(95, 'លេខាសាលា', NULL, 0, 44, 1, 1, 1, NULL, NULL),
(96, 'លេខាកម្រង', NULL, 0, 45, 1, 1, 1, NULL, NULL),
(97, 'បណ្ណារក្ស', NULL, 0, 46, 1, 1, 1, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
