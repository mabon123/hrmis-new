-- MySQL dump 10.13  Distrib 8.0.26, for macos11 (x86_64)
--
-- Host: 127.0.0.1    Database: hrmisdb
-- ------------------------------------------------------
-- Server version	8.0.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_permissions` (
  `permission_id` smallint unsigned NOT NULL,
  `permission_kh` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_en` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `idx_permission_slug` (`permission_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'មើលពត៌មានបុគ្គលិក','View Staff','view-staffs',1),(2,'បង្កើតពត៌មានបុគ្គលិក','Create Staff','create-staffs',1),(3,'កែប្រែពត៌មានបុគ្គលិក','Edit Staff','edit-staffs',1),(4,'លុបពត៌មានបុគ្គលិក','Delete Staff','delete-staffs',1),(5,'មើលពត៌មានសាលារៀន','View School','view-schools',1),(6,'បង្កើតពត៌មានសាលារៀន','Create School','create-schools',1),(7,'កែប្រែពត៌មានសាលារៀន','Edit School','edit-schools',1),(8,'លុបពត៌មានសាលារៀន','Delete School','delete-schools',1),(9,'បង្កើតព័ត៌មានគ្រូបង្រៀនកិច្ចសន្យា','Create Contract Staffs','create-cont-staffs',1),(10,'មើលព័ត៌មានគ្រូបង្រៀនកិច្ចសន្យា','View Contract Staffs','view-cont-staffs',1),(11,'កែប្រែព័ត៌មានគ្រូបង្រៀនកិច្ចសន្យា','Edit Contract Staffs','edit-cont-staffs',1),(12,'លុបព័ត៌មានគ្រូបង្រៀនកិច្ចសន្យា','Delete Contract Staffs','delete-cont-staffs',1),(13,'មើលព័ត៌មានគរុសិស្ស-និស្សិត','View Trainee Teacher','view-trainee-teacher',1),(14,'បង្កើតព័ត៌មានគរុសិស្ស-និស្សិត','Create Trainee Teacher','create-trainee-teacher',1),(15,'កែប្រែព័ត៌មានគរុសិស្ស-និស្សិត','Edit Trainee Teacher','edit-trainee-teacher',1),(16,'លុបព័ត៌មានគរុសិស្ស-និស្សិត','Delete Trainee Teacher','delete-trainee-teacher',1),(17,'មើលអ្នកផ្តល់សេវា អវប (CPD)','View CPD Provider','view-cpd-provider',1),(18,'បង្កើតអ្នកផ្តល់សេវា អវប (CPD)','Create CPD Provider','create-cpd-provider',1),(19,'កែប្រែអ្នកផ្តល់សេវា អវប (CPD)','Edit CPD Provider','edit-cpd-provider',1),(20,'លុបអ្នកផ្តល់សេវា អវប (CPD)','Delete CPD Provider','delete-cpd-provider',1),(21,'មើល CPD Schedule Course','View CPD Schedule Course','view-cpd-schedule-course',1),(22,'បង្កើត CPD Schedule Course','Create CPD Schedule Course','create-cpd-schedule-course',1),(23,'កែប្រែ CPD Schedule Course','Edit CPD Schedule Course','edit-cpd-schedule-course',1),(24,'លុប CPD Schedule Course','Delete CPD Schedule Course','delete-cpd-schedule-course',1),(25,'មើល CPD Structured Course','View CPD Structured Course','view-cpd-structured-course',1),(26,'បង្កើត CPD Structured Course','Create CPD Structured Course','create-cpd-structured-course',1),(27,'កែប្រែ CPD Structured Course','Edit CPD Structured Course','edit-cpd-structured-course',1),(28,'លុប CPD Structured Course','Delete CPD Structured Course','delete-cpd-structured-course',1),(29,'មើលបញ្ជីគ្រូចេញថ្មី','View Trainee Teacher List','view-trainee-teacher-list',1),(30,'កែប្រែបញ្ជីគ្រូចេញថ្មី','Edit Trainee Teacher List','edit-trainee-teacher-list',1),(31,'គ្រប់គ្រងការចុះឈ្មោះអ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ','Manage User Registration','view-manage-user-registration',1),(32,'គ្រប់គ្រង Multi-Criteria Search','Manage Multi-Criteria Search','view-manage-multi-criteria-search',1),(33,'មើលរបាយការណ៍ & តារាងទិន្នន័យ','View Report & Chart','view-report-and-chart',1),(37,'កែប្រែការវាយតម្លៃគន្លងអាជីព','Edit TCP Appraisal','edit-tcp-appraisal',1),(36,'បង្កើតការវាយតម្លៃគន្លងអាជីព','Create TCP Appraisal','create-tcp-appraisal',1),(35,'មើលការវាយតម្លៃគន្លងអាជីព','View TCP Appraisal','view-tcp-appraisal',1),(34,'ត្រួតពិនិត្យការស្នើសុំគន្លងអាជីព','View TCP Appraisal Requests','view-tcp-appraisal-requests',1),(38,'លុបការវាយតម្លៃគន្លងអាជីព','Delete TCP Appraisal','delete-tcp-appraisal',1);
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-18 11:26:35