-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 08, 2022 at 09:22 AM
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
-- Table structure for table `sys_report_fields`
--

DROP TABLE IF EXISTS `sys_report_fields`;
CREATE TABLE IF NOT EXISTS `sys_report_fields` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `table_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_kh` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_date_field` tinyint NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_report_fields`
--

INSERT INTO `sys_report_fields` (`id`, `table_name`, `field_name`, `title_kh`, `title_en`, `is_date_field`, `active`) VALUES
(1, 'hrmis_staffs', 'payroll_id', 'លេខបៀវត្ស', 'Payroll ID', 0, 1),
(2, 'hrmis_staffs', 'surname_kh', 'នាមត្រកូលជាខ្មែរ', 'Surname in Khmer', 0, 1),
(3, 'hrmis_staffs', 'name_kh', 'នាមខ្លួនជាខ្មែរ', 'Name in Khmer', 0, 1),
(4, 'hrmis_staffs', 'surname_en', 'នាមត្រកូលជាឡាតាំង', 'Surname in English', 0, 1),
(6, 'hrmis_staffs', 'sex', 'ភេទ', 'Gender', 0, 1),
(7, 'hrmis_staffs', 'dob', 'ថ្ងៃ ខែ ឆ្នាំ កំណើត', 'Date of Birth', 1, 1),
(8, 'hrmis_staffs', 'birth_village', 'ភូមិកំណើត', 'Birth Village', 0, 1),
(9, 'hrmis_staffs', 'birth_commune', 'ឃុំកំណើត', 'Birth Commune', 0, 1),
(10, 'hrmis_staffs', 'birth_district', 'ស្រុកកំណើត', 'Birth District', 0, 1),
(11, 'hrmis_staffs', 'birth_pro_code', 'រាជធានី-ខេត្តកំណើត', 'Birth Province', 0, 1),
(12, 'hrmis_staffs', 'start_date', 'ថ្ងៃ ខែ ឆ្នាំ ចូលបំពេញការងារ', 'Start Work Date', 1, 1),
(13, 'sys_locations', 'location_kh', 'ទីកន្លែងបម្រើការងារបច្ចុប្បន្ន', 'Current Workplace', 0, 1),
(14, 'sys_positions', 'position_kh', 'មុខងារ', 'Position', 0, 1),
(15, 'sys_maritalstatus', 'maritalstatus_kh', 'ស្ថានភាពគ្រួសារ', 'Family Status', 0, 1),
(16, 'salary_levels', 'salary_level_kh', 'ប្រភេទកាំប្រាក់', 'Salary Level', 0, 1),
(5, 'hrmis_staffs', 'name_en', 'នាមខ្លួនជាឡាតាំង', 'Name in English', 0, 1),
(17, 'hrmis_staff_salaries', 'salary_degree', 'កម្រិតកាំប្រាក់', 'Salary Degree', 0, 1),
(18, 'sys_locations', 'pro_code', 'បំពេញការងារនៅរាជធានី-ខេត្ត', 'Workplace at Province', 0, 1),
(19, 'sys_locations', 'dis_code', 'បំពេញការងារនៅស្រុក-ខ័ណ្ឌ', 'Workplace at District', 0, 1),
(20, 'sys_locations', 'com_code', 'បំពេញការងារនៅឃុំ-សង្កាត់', 'Workplace at Commune', 0, 1),
(21, 'sys_staff_status', 'status_kh', 'ស្ថានភាពបច្ចុប្បន្ន', 'Current Status', 0, 1),
(22, 'sys_offices', 'office_kh', 'ការិយាល័យ', 'Office', 0, 1),
(23, 'sys_qualification_codes', 'qualification_kh', 'កម្រិតសញ្ញាបត្រខ្ពស់បំផុត', 'Highest Degree', 0, 1),
(24, 'sys_official_ranks', 'official_rank_kh', 'ឋានន្តរស័ក្តិ', 'Official Rank', 0, 1),
(25, 'hrmis_staff_salaries', 'salary_type_shift_date', 'ថ្ងៃ ខែ ឆ្នាំ ឡើងកាំប្រាក់ចុងក្រោយ', 'Salary Type Shift Date', 0, 1),
(26, 'hrmis_staff_salaries', 'salary_type_prokah_num', 'ប្រកាសតែងតាំង', 'Salary Prokah Number', 0, 1),
(36, 'hrmis_staffs', 'sbsk_num', 'លេខសបសខ', 'SBSK Number', 0, 1),
(35, 'hrmis_staffs', 'bank_account', 'លេខគណនីបៀវត្ស', 'Bank Account Number', 0, 1),
(29, 'hrmis_staff_teachings', 'teaching', 'បង្រៀន', 'Teach', 0, 0),
(30, 'hrmis_staffs', 'phone', 'លេខទូរស័ព្ទ', 'Phone Number', 0, 1),
(31, 'hrmis_families', 'fullname_kh', 'ឈ្មោះប្តី/ប្រពន្ធ', 'Spouse Name', 0, 1),
(32, 'hrmis_families', 'occupation', 'មុខរបរប្តី/ប្រពន្ធ', 'Occupation', 0, 1),
(33, 'hrmis_families', 'spouse_workplace', 'អង្គភាពប្តី/ប្រពន្ធ', 'Spouse Workplace', 0, 1),
(34, 'hrmis_staffs', 'nid_card', 'លេខអត្តសញ្ញាណប័ណ្ណ', 'National ID Card', 0, 1),
(37, 'sys_disabilities', 'disability_kh', 'ប្រភេទពិការ', 'Disability', 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
