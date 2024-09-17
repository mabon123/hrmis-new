/*
SQLyog Ultimate
MySQL - 10.4.11-MariaDB : Database - testhrdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `sys_trainee_status` */

DROP TABLE IF EXISTS `sys_trainee_status`;

CREATE TABLE `sys_trainee_status` (
  `trainee_status_id` tinyint(4) NOT NULL,
  `trainee_status_kh` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trainee_status_en` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`trainee_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sys_trainee_status` */

insert  into `sys_trainee_status`(`trainee_status_id`,`trainee_status_kh`,`trainee_status_en`) values 
(1,'គរុសិស្ស','Trainee'),
(2,'លុបឈ្មោះ','Removed'),
(3,'បោះបង់','Gave Up'),
(4,'ព្យួរ','Postpone'),
(5,'ពេញសិទ្ធិ','Completed');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
