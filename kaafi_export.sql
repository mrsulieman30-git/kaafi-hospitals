-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: kaafi_hospital
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ai_conversations`
--

DROP TABLE IF EXISTS `ai_conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ai_conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `message_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ai_conversations_user_id_foreign` (`user_id`),
  CONSTRAINT `ai_conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ai_conversations`
--

LOCK TABLES `ai_conversations` WRITE;
/*!40000 ALTER TABLE `ai_conversations` DISABLE KEYS */;
INSERT INTO `ai_conversations` VALUES (1,'r64RsSUMsZNVGsfTvgdMBNLIyDoElUNRD4VjUsXb','assistant',NULL,0,'2026-05-07 05:09:35','2026-05-07 05:09:35','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(2,'wLoNRbcn6zeIN7jB6vkcLJnMBidKOGYf1YzMn88n','assistant',NULL,0,'2026-05-10 05:26:37','2026-05-10 05:26:37','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(3,'wLoNRbcn6zeIN7jB6vkcLJnMBidKOGYf1YzMn88n','user',NULL,0,'2026-05-10 05:28:52','2026-05-10 05:28:52','hi'),(4,'wLoNRbcn6zeIN7jB6vkcLJnMBidKOGYf1YzMn88n','assistant',NULL,0,'2026-05-10 05:29:02','2026-05-10 05:29:02','Hi there! How can I assist you today? Are you looking to book an appointment with one of our doctors, or is there something else I can help you with?'),(5,'3HhLrJCD3fgdi2ssH2pixLAFs0vCtVoCLAd9wnav','assistant',NULL,0,'2026-05-10 05:47:15','2026-05-10 05:47:15','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(6,'eQl4vu48DTa8dQRYBBbzXnxcHuvtB9vzpvDa0RJa','assistant',NULL,0,'2026-05-10 11:26:34','2026-05-10 11:26:34','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(7,'xkxAaLiVEFceCtiHKpGb8sXfHoFsi6eD5f8hDZQl','assistant',NULL,0,'2026-05-10 17:01:24','2026-05-10 17:01:24','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(8,'0aNd1PbAMouGwTh2lz8e1uavbm3xGTLilJfrH8BS','assistant',NULL,0,'2026-05-10 17:15:06','2026-05-10 17:15:06','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(9,'cpYMPn8xBgtxDzALvcy8hh8tt5I9LM5c4pBWUNvB','assistant',NULL,0,'2026-05-11 04:03:37','2026-05-11 04:03:37','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(10,'nF2gL6jeCVSgNscmLSfNybnDXm2NvTSc1Cims1Pu','assistant',NULL,0,'2026-05-11 04:07:49','2026-05-11 04:07:49','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(11,'eFygScJCXl12m3rIIWtNMbSihD9HyjXylYvbQF89','assistant',NULL,0,'2026-05-11 04:20:59','2026-05-11 04:20:59','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(12,'zaQ42nMhfmtqrQj8KIsttSxVw7V1O6Vpwis4Sr3e','assistant',NULL,0,'2026-05-11 04:36:39','2026-05-11 04:36:39','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(13,'iT2n4kikRTn6UZ45owyVPPU6Pg3JCYZHgccK907x','assistant',NULL,0,'2026-05-11 04:42:29','2026-05-11 04:42:29','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(14,'iT2n4kikRTn6UZ45owyVPPU6Pg3JCYZHgccK907x','user',NULL,0,'2026-05-11 07:17:32','2026-05-11 07:17:32','hi'),(15,'iT2n4kikRTn6UZ45owyVPPU6Pg3JCYZHgccK907x','assistant',NULL,0,'2026-05-11 07:17:41','2026-05-11 07:17:41','Hello! How can I assist you today? Are you looking to book an appointment with a specific doctor, or do you need help finding one?'),(16,'RGz9u49vhzufkvFEClcJBRJVjFLjfjAPIjW3yeDz','assistant',NULL,0,'2026-05-11 10:34:32','2026-05-11 10:34:32','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(17,'1kHOXDICBfsKhSpGErvwlRTXBfRKYLNgDjSfI3AO','assistant',NULL,0,'2026-05-11 13:10:27','2026-05-11 13:10:27','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(18,'aZ4RMMxfDi0amKOLEUJjFihhJiWv3tqYVv72YEca','assistant',NULL,0,'2026-05-12 00:29:09','2026-05-12 00:29:09','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(19,'oykKcqRpYtLLfnOlCG1LilTOXevDdnOGfRwDb9Ty','assistant',NULL,0,'2026-05-12 03:00:00','2026-05-12 03:00:00','Hello! Welcome to KAAFI Hospitals. I am the front desk receptionist. How can I help you find a doctor or schedule an appointment today?'),(20,'oykKcqRpYtLLfnOlCG1LilTOXevDdnOGfRwDb9Ty','user',NULL,0,'2026-05-12 06:25:36','2026-05-12 06:25:36','hello'),(21,'oykKcqRpYtLLfnOlCG1LilTOXevDdnOGfRwDb9Ty','assistant',NULL,0,'2026-05-12 06:25:44','2026-05-12 06:25:44','Hello there! How can I assist you today? Are you looking to book an appointment with a doctor or perhaps need some health information?');
/*!40000 ALTER TABLE `ai_conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment_slots`
--

DROP TABLE IF EXISTS `appointment_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment_slots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_slots_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `appointment_slots_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_slots`
--

LOCK TABLES `appointment_slots` WRITE;
/*!40000 ALTER TABLE `appointment_slots` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_email` varchar(255) DEFAULT NULL,
  `patient_phone` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_user_id_foreign` (`user_id`),
  KEY `appointments_department_id_foreign` (`department_id`),
  KEY `appointments_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `appointments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_comments`
--

DROP TABLE IF EXISTS `blog_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_post_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_comments_blog_post_id_foreign` (`blog_post_id`),
  CONSTRAINT `blog_comments_blog_post_id_foreign` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_comments`
--

LOCK TABLES `blog_comments` WRITE;
/*!40000 ALTER TABLE `blog_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT 'post',
  `blog_category_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`title`)),
  `slug` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content`)),
  `excerpt` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `featured_image_url` varchar(2048) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `old_price` varchar(255) DEFAULT NULL,
  `new_price` varchar(255) DEFAULT NULL,
  `has_appointment_btn` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `linked_doctor_id` bigint(20) unsigned DEFAULT NULL,
  `offer_end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  KEY `blog_posts_user_id_foreign` (`user_id`),
  CONSTRAINT `blog_posts_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'post',NULL,NULL,'{\"en\":\"The Future of Telemedicine: Healthcare from Home\"}','the-future-of-telemedicine-healthcare-from-home','{\"en\":\"<h3>A New Era of Healthcare</h3><p>Telemedicine has rapidly transformed from a convenient alternative to an essential pillar of modern healthcare. With advancements in secure video conferencing, wearable health trackers, and AI-driven diagnostics, patients can now receive world-class medical advice without leaving their homes.</p><p>At KAAFI Hospitals, we are integrating these technologies to ensure our patients have 24/7 access to care, reducing emergency room wait times and providing continuous support for chronic disease management.</p>\"}','{\"en\":\"Discover how virtual consultations and remote monitoring are revolutionizing patient care, making specialists more accessible than ever.\"}',NULL,NULL,NULL,'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',1,NULL,0,'2026-05-07 05:06:50','2026-05-07 05:06:50',NULL,NULL,0,0,0,NULL,NULL),(2,'post',NULL,NULL,'{\"en\":\"Understanding Cardiovascular Health in 2026\"}','understanding-cardiovascular-health-in-2026','{\"en\":\"<h3>Your Heart is Your Engine</h3><p>Cardiovascular disease remains a leading health concern globally. However, modern medicine has made incredible strides in early detection and preventative care. Simple lifestyle adjustments, combined with routine ECGs and cholesterol monitoring, can reduce risks by over 70%.</p><p>In this article, our leading cardiologists discuss the importance of Mediterranean diets, cardiovascular exercise routines, and the warning signs you should never ignore.</p>\"}','{\"en\":\"A comprehensive guide to preventing heart disease through modern nutrition, stress management, and early screening.\"}',NULL,NULL,NULL,'https://images.unsplash.com/photo-1530497610245-94d3c16cda28?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',1,NULL,0,'2026-05-07 05:06:50','2026-05-07 05:06:50',NULL,NULL,0,0,0,NULL,NULL),(3,'post',NULL,NULL,'{\"en\":\"Pediatric Care: Milestones Every Parent Should Know\"}','pediatric-care-milestones-every-parent-should-know','{\"en\":\"<h3>Guiding the Next Generation</h3><p>Children grow at their own pace, but understanding standard developmental milestones can help parents ensure their little ones are thriving. From motor skills to speech development, early intervention is key if you suspect any delays.</p>\"}','{\"en\":\"From first steps to cognitive development, learn what to watch for as your child grows and when to consult a pediatrician.\"}',NULL,NULL,NULL,'https://images.unsplash.com/photo-1584515933487-779824d29309?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',1,NULL,0,'2026-05-07 05:06:50','2026-05-07 05:06:50',NULL,NULL,0,0,0,NULL,NULL),(4,'post',NULL,NULL,'{\"en\":\"The Science of Sleep: Why Rest is the Best Medicine\"}','the-science-of-sleep-why-rest-is-the-best-medicine','{\"en\":\"<h3>Recharging the Brain</h3><p>Sleep is not a luxury; it is a biological necessity. During deep sleep, the brain flushes out toxins and the immune system repairs cellular damage. Lack of sleep is now clinically linked to hypertension, diabetes, and weakened immunity.</p>\"}','{\"en\":\"Chronic sleep deprivation is linked to numerous health issues. Learn the clinical importance of sleep hygiene.\"}',NULL,NULL,NULL,'https://images.unsplash.com/photo-1542884748-2b87b36c6b90?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',1,NULL,0,'2026-05-07 05:06:50','2026-05-07 05:06:50',NULL,NULL,0,0,0,NULL,NULL),(5,'post',NULL,NULL,'{\"en\":\"Advances in Minimally Invasive Surgery\"}','advances-in-minimally-invasive-surgery','{\"en\":\"<h3>Precision Meets Care</h3><p>The days of large surgical incisions are fading. With robotic arms that offer greater precision than the human hand, surgeons at KAAFI can perform complex procedures through incisions no larger than a keyhole. This means less pain, minimal scarring, and drastically faster recovery times for our patients.</p>\"}','{\"en\":\"How robotic assistance and laparoscopy are reducing recovery times from weeks to mere days.\"}',NULL,NULL,NULL,'https://images.unsplash.com/photo-1551076805-e1869033e561?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',1,NULL,0,'2026-05-07 05:06:50','2026-05-07 05:06:50',NULL,NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('kaafi-hospitals-cache-spatie.permission.cache','a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}',1778671868);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `slug` varchar(255) NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`description`)),
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_slug_unique` (`slug`),
  KEY `departments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'{\"en\":\"Cardiology\",\"so\":\"Cudurada Wadnaha\"}','cardiology','{\"en\":\"Heart and cardiovascular care.\",\"so\":\"Daryeelka wadnaha iyo xididdada dhiigga.\"}',NULL,0,'2026-05-07 05:06:49','2026-05-11 15:10:03',NULL),(2,'{\"en\":\"Pediatrics\",\"so\":\"Carruurta\"}','pediatrics','{\"en\":\"Child healthcare.\",\"so\":\"Daryeelka caafimaadka carruurta.\"}','departments/01KRBWSXSEHRSH90N46GYAKENH.jpg',1,'2026-05-07 05:06:49','2026-05-11 14:44:49',10),(3,'{\"en\":\"Neurology \",\"so\":\"Neerfaha 1\"}','neurology','{\"en\":\"Brain and nervous system.\",\"so\":\"Maskaxda iyo hab-dhiska neerfaha.\"}','departments/01KRB42HJHEN9AH8RC9GMK98EJ.jpg',1,'2026-05-07 05:06:50','2026-05-11 14:45:19',10),(4,'{\"en\":\"General Medicine\",\"so\":\"Cudurada Guud\"}','general-medicine','{\"en\":\"Primary care.\",\"so\":\"Daryeelka aasaasiga ah.\"}',NULL,0,'2026-05-07 05:06:50','2026-05-11 15:09:46',NULL),(5,'{\"en\":\"Laboratory & Diagnostics\",\"so\":\"Qaybta Baaritaanada kala duwan (Diagnostics)\"}','laboratory','{\"en\":\"<h2>The KAAFI Hospitals Laboratory is renowned for its <strong>modern automated equipment</strong> and its team of <strong>highly knowledgeable and experienced laboratory professionals</strong>.</h2><p>Specialized tests available include:</p><ol><li><strong>Leukemia</strong> (Blood Cancer) screenings</li><li><strong>Semen Analysis</strong> utilizing modern automated machinery</li><li><strong>Culture &amp; Sensitivity</strong> testing for various bodily fluids</li><li><strong>Coagulation</strong> (Blood Clotting) tests</li><li><strong>Body Fluid</strong> analysis</li><li><strong>Hormonal</strong> assays</li><li><em>Additional Routine Tests:</em> Cardiac function, liver function, kidney function, diabetes monitoring, lipid profiles, and more.</li></ol>\",\"so\":\"<p>𝗦𝗛𝗔𝗬𝗕𝗔𝗔𝗥𝗞𝗔 KAAFI Hospitals waxa uu can ku yahay QALAB Shaybaar oo casri ah iyo 𝗞𝗔𝗔𝗗𝗜𝗥𝗜𝗜𝗡𝗧𝗔 𝗦𝗛𝗔𝗬𝗕𝗔𝗔𝗥𝗜𝗦𝗧𝗔𝗬𝗔𝗔𝗟 ah oo aqoon &amp; Khibrad dheer u leh cilmiga Baarista&nbsp;</p><p>Baaritaanada gaarka ah ee laga heli karo shaybaarka Kaafi Hospitals waxa ka mid ah:</p><ol><li>·&nbsp; &nbsp; &nbsp; &nbsp;Baaritaanka 𝗞𝗮𝗻𝘀𝗮𝗿𝗸𝗮 𝗗𝗵𝗶𝗶𝗴𝗮 (𝗟𝗲𝘂𝗸𝗲𝗺𝗶𝗮)</li><li>·&nbsp; &nbsp; &nbsp; &nbsp;Baaritaanka 𝗦𝗵𝗮𝗵𝘄𝗮𝗱𝗮 𝗥𝗮𝗴𝗴𝗮 (𝗦𝗲𝗺𝗲𝗻 𝗔𝗻𝗮𝗹𝘆𝘀𝗶𝘀) oo lagu samaynayo Mashiin otomaatik ah oo casriya</li><li>·&nbsp; &nbsp; &nbsp; &nbsp;Baaritaanada 𝗕𝗲𝗲𝗿𝗶𝘀𝘁𝗮 𝗜𝗹𝗺𝗼-𝗮𝗿𝗮𝗴𝘁𝗮𝗱𝗮 (𝗖𝘂𝗹𝘁𝘂𝗿𝗲 &amp; 𝗦𝗲𝗻𝘀𝗶𝘁𝗶𝘃𝗶𝘁𝘆) oo la beerayo Dheecaanada kala duwan ee jirka</li><li>·&nbsp; &nbsp; &nbsp; &nbsp;Baaritaanada 𝗫𝗶𝗻𝗷𝗶𝗿𝗼𝘄𝗴𝗮 𝗗𝗵𝗶𝗶𝗴𝗮 (𝗖𝗼𝗮𝗴𝘂𝗹𝗮𝘁𝗶𝗼𝗻 𝘁𝗲𝘀𝘁𝘀)</li><li>·&nbsp; &nbsp; &nbsp; &nbsp;Baaritaanada 𝗗𝗵𝗲𝗲𝗰𝗮𝗮𝗻𝗮𝗱𝗮 𝗗𝗮𝗿𝗲𝗲𝗿𝗮𝗵𝗮 𝗷𝗶𝗿𝗸𝗮 (𝗕𝗼𝗱𝘆 𝗙𝗹𝘂𝗶𝗱𝘀)</li><li>·&nbsp; &nbsp; &nbsp; &nbsp;Baaritaanada 𝗛𝗼𝗿𝗺𝗼𝗼𝗻𝗮𝗱𝗮 jirka</li></ol><p>iyo kuwo kaloo badan sida Baaritaanada Shaqooyinka Wadnaha, Beerka, Kelyaha, la socodka Macaanka, Dufanka Dhiiga iwm</p>\"}','departments/01KRD4QSNRD1B913T11EZAFC63.png',1,'2026-05-07 05:06:50','2026-05-12 00:53:26',NULL),(6,'{\"en\":\"Internal Medicine\",\"so\":\"Cudurada guud (Internal Medicine)\"}','gastroentrology','{\"en\":\"This department specializes in the diagnosis and treatment of diseases affecting the digestive system. The department provides comprehensive medical care for conditions related to the stomach, intestines, liver, esophagus, and other digestive organs. Our experienced medical team utilizes advanced technology and modern treatment methods to ensure high-quality healthcare services and exceptional patient care.\\n\",\"so\":\"Waaxdan waxay ku takhasustay cudurrada iyo xanuunnada ku dhaca hab-dhiska dheef-shiidka. Waaxdu waxay bixisaa baaritaan, daaweyn, iyo daryeel caafimaad oo heer sare ah oo la xiriira cudurrada caloosha, mindhicirrada, beerka, hunguriga, iyo dhammaan qaybaha kale ee habka dheef-shiidka. Dhakhaatiirta iyo shaqaalaha caafimaadka ee waaxdan waxay adeegsadaan qalab casri ah iyo khibrad caafimaad si loo xaqiijiyo adeeg tayo leh iyo daryeel bukaan oo dhammaystiran.\\n\"}','departments/01KRC36MPBQR2JS8DYXKYQQ5Q3.png',1,'2026-05-10 09:00:12','2026-05-11 15:01:36',10),(7,'{\"en\":\"GENERAL SURGERY \",\"so\":\"QAYBTA QALLIIMADA\"}','general-surgery-department-qaybta-qalliimada','{\"en\":\"Performs a wide range of surgical procedures including:\\n\\nGallbladder surgery (Cholecystectomy)\\nHernia repair operations\\nIntestinal obstruction surgery\\nThyroid gland surgery\\nManagement of penetrating chest injuries\\nAppendectomy (Appendix surgery)\\nHemorrhoid surgery (Piles treatment)\\nHydrocele repair (scrotal fluid swelling)\\nObstetric and gynecological surgical procedures\\nVaricocele surgery (swollen testicular veins)\",\"so\":\"<p>Performs a wide range of surgical procedures including: Gallbladder surgery (Cholecystectomy) Hernia repair operations Intestinal obstruction surgery Thyroid gland surgery Management of penetrating chest injuries Appendectomy (Appendix surgery) Hemorrhoid surgery (Piles treatment) Hydrocele repair (scrotal fluid swelling) Obstetric and gynecological surgical procedures Varicocele surgery (swollen testicular veins)</p>\"}','departments/01KRB3PMGC06E39PHN3QMR07JY.png',1,'2026-05-11 05:49:38','2026-05-12 03:46:21',NULL),(8,'{\"en\":\"Opthalmology Department\",\"so\":\"Qaybta  Indhaha \"}','opthalmology-department','{\"en\":\"In KAAFI hospitals, the Ophthalmology department provides comprehensive eye care services focused on protecting and restoring vision. We diagnose and manage a wide range of eye conditions, including refractive errors, cataracts, glaucoma, retinal diseases, and ocular infections. Our team also performs both minor and advanced eye procedures using modern diagnostic equipment to ensure accurate assessment and effective treatment.\",\"so\":\"Qaybta Cudurrada Indhaha iyo Qalliinka Indhaha (Ophthalmology) ee isbitaalkayaga waxay bixisaa daryeel dhammaystiran oo ku saabsan ilaalinta, baarista, iyo daaweynta caafimaadka indhaha iyo aragga.\\n\\nWaxaan si xirfad leh u ogaannaa una daaweynaa cudurrada kala duwan ee indhaha sida ciladaha aragga, biyo-cataract, cadaadiska indhaha (glaucoma), cudurrada ku dhaca retina-da, iyo caabuqyada indhaha. Sidoo kale, qaybta waxay fulisaa qalliimo indhaha ah iyo adeegyo casri ah oo lagu hagaajiyo ama lagu badbaadiyo aragga bukaanka.\\n\\nUjeedkayagu waa inaan bixino daryeel indho oo tayo sare leh oo isku dhafan aqoon caafimaad iyo qalab casri ah, si bukaannadeenu u helaan arag caafimaad leh oo waara.\"}','departments/01KRB55X4K76NSF0NQKP7Y7JZ2.jpg',1,'2026-05-11 06:16:35','2026-05-11 15:08:18',10),(9,'{\"en\":\"GYN & OBS\",\"so\":\"Qaybta Dumarka iyo Umulaha\"}','gyn-obs','{\"en\":\"obsetrics and gynecology\",\"so\":\"Qaybta Dumarka iyo Umulaha\"}','departments/01KRBXXV65DYN5P92A41NQ8GPV.webp',1,'2026-05-11 13:29:06','2026-05-11 15:08:51',10),(10,'{\"en\":\"Outpatient Department (OPD)\",\"so\":\"Bukaan Socod (OPD)\"}','outpatient-department-opd','{\"en\":\"Outpatient services are available every day, 7 days a week, ensuring patients have continuous access to consultations and treatments for various health conditions.\\n\\nSpecialty Departments:\\n\\nInternal Medicine\\n\\nGynecology & Obstetrics (Gyn & Obs)\\n\\nOrthopedics\\n\\nPediatrics\\n\\nOphthalmology\\n\\nGeneral Surgery\\n\\nCardiology\\n\\nDermatology\",\"so\":\"Adeegyada bukaan socodka oo la heli karo maalin kasta 7da beriba, si bukaanadu u helaan la-talin iyo daaweyn cudurro kala duwan.\\nQaybaha Takhasuska:\\n•\\tCudurada guud (Internal Medicine) \\n•\\tDumarka (Gyn & Obs)\\n•\\tLafaha (Orthopedics) \\n•\\tCarruurta (Pediatrics) \\n•\\tIndhaha (Ophthalmology) \\n•\\tQalliimada (General surgeon) \\n•\\tWadnaha (Cardiology) \\n•\\tMaqaarka (Dermatologist)\\n\"}','departments/01KRC26HSC7WG2E5VP30RQ788V.png',1,'2026-05-11 14:43:45','2026-05-11 14:43:45',NULL),(11,'{\"en\":\"Inpatient Services (IPD)\",\"so\":\"Bukaan Jiif (Inpatient)\"}','inpatient-services-ipd','{\"en\":\"The hospital features 28+ fully equipped inpatient beds distributed across several units:\\n\\nMaternity Wards\\n\\nNeonatal Intensive Care Unit (NICU)\\n\\nSurgical Wards\\n\\nInternal Medicine Wards\\n\\nThe facility offers general wards, private rooms, and specialized units tailored to meet diverse patient needs.\",\"so\":\"Waxa uu ka kooban yahay 28+ sariirood iyo qalabkoodii oo isugu jira:\\n-\\tQaybtii bukaanjiifka Hooyada iyo dhallaanka (Maternity Wards)\\n-\\tQaybta Daryeelka xaalada adage e Caruurta (NICU unit)\\n-\\tQaybta bukaanjiifka la qalay (Surgery wards)\\n-\\tQaybta bukaanjiifka xanuunada guud & uurku jirta (Internal medicin wards)\\n-\\tWaxaa jira qolal guud, qolal gaar ah, iyo qaybo gaar ah oo loogu talagalay baahiyaha kala duwan ee bukaanka.\\n\"}','departments/01KRD0WC0X834RCNNYWV3EJ8J2.png',1,'2026-05-11 23:39:58','2026-05-12 00:02:01',NULL),(12,'{\"en\":\"Emergency & Critical Care\",\"so\":\"Qaybta Gargaarka Degdegga & Daryeelada Xaaladaha Halista ah:\"}','emergency-critical-care','{\"en\":\"The Emergency Department is equipped with 7 specialized beds and accompanying medical equipment.\\n\\nThe Operating Theater (OT) consists of 2 fully equipped surgical rooms, allowing simultaneous operations.\",\"so\":\"•\\tQaybta Gargaarka degdegga waxay leedahay 7 sariirood iyo qalabkoodii\\n•\\tQaybta Qalliimada (OT) oo ka kooban 2 masrax oo si dhamaytiran u qalabaysan oo isku mar lagu fulin karo qalliimo.\\n\"}','departments/01KRD2S48FHXR0BXMYNQFW1CYX.png',1,'2026-05-12 00:13:08','2026-05-12 00:13:08',NULL),(13,'{\"en\":\"Surgical Department\",\"so\":\"Qaybta Qalliimada\"}','surgical-department','{\"so\":\"<ul><li><strong>Waxaa </strong>jira 2 miis qalliin oo qalabaysan oo isku xilli qalliimadu ka dhici karaan&nbsp;</li><li><strong>Waxaa </strong>lagu sameeyaa: o Qalliinnada guud o Qalliinnada dumarka &amp; dhalmadooda o Qalliinnada indhaha o Qalliinnada lafaha qaarkood&nbsp;</li></ul>\",\"en\":\"<h2>Equipped with 2 advanced operating tables to perform simultaneous surgical procedures, including:</h2><ul><li>General surgeries</li><li>Gynecological &amp; obstetric surgeries</li><li>Eye surgeries (Ophthalmology)</li><li>Selected orthopedic surgeries</li></ul>\"}','departments/01KRD3H9CNAT3BHRM3GAXB8VG1.png',1,'2026-05-12 00:18:02','2026-05-12 00:26:20',11),(14,'{\"en\":\"Maternity & Neonatal Care\",\"so\":\"Qaybta Hooyada & Dhallaanka\"}','maternity-neonatal-care','{\"en\":\"<ul><li><h2>Quality delivery services, including normal deliveries and Caesarean sections (<strong>C-sections</strong>).</h2></li><li>Maternal care and continuous pregnancy monitoring (Antenatal care).</li><li>Care and incubation for premature infants.</li><li>Treatment and care for newborns with various health conditions.</li></ul>\",\"so\":\"<ul><li><h2><strong>Adeegyo dhalmo tayo leh sida dhalmada dabiiciga ah iyo qalliimada C-section.</strong></h2></li><li>Daryeelka hooyada iyo la socodka xilliga ay uurka leedahay</li><li>Korinta ilmaha dhasha isagoon sidkiisa dhamaysan</li><li>Daryeelka ilmaha ku dhasha xanuunada kala duwan</li></ul><p><br></p>\"}','departments/01KRD3XDZXC34HWVBVG6YFHK44.png',1,'2026-05-12 00:32:58','2026-05-12 00:32:58',11),(15,'{\"en\":\"Administration\",\"so\":\"Maamulka\"}','administration','{\"so\":null}',NULL,1,'2026-05-12 01:12:34','2026-05-12 01:12:34',NULL);
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_schedules`
--

DROP TABLE IF EXISTS `doctor_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_schedules_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `doctor_schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_schedules`
--

LOCK TABLES `doctor_schedules` WRITE;
/*!40000 ALTER TABLE `doctor_schedules` DISABLE KEYS */;
INSERT INTO `doctor_schedules` VALUES (1,9,'[\"Monday\",\"Thursday\"]','11:00:00','13:00:00',1,'2026-05-10 08:40:51','2026-05-10 08:40:51'),(2,9,'[\"Tuesday\",\"Wednesday\"]','10:00:00','00:00:00',1,'2026-05-10 08:41:33','2026-05-10 08:41:33');
/*!40000 ALTER TABLE `doctor_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `slug` varchar(255) NOT NULL,
  `title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`title`)),
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bio`)),
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(2048) DEFAULT NULL,
  `image_type` varchar(255) DEFAULT 'upload',
  `phone` varchar(255) DEFAULT NULL,
  `youtube_video_url` varchar(2048) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_slug_unique` (`slug`),
  KEY `doctors_user_id_foreign` (`user_id`),
  KEY `doctors_department_id_foreign` (`department_id`),
  CONSTRAINT `doctors_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (9,NULL,6,'{\"en\":\"Dr Ahmed Al Hatem\",\"so\":\"Dr Ahmed Al Hatem\"}','dr-ahmed-al-hatem','{\"en\":\"MMed Internal Medicine\",\"so\":\"Master-ka ee Cudurrada Gudaha\"}','{\"en\":\"Internal Medicine\\n\\nMore than a decade of experience\\nSpecialized in the diagnosis and treatment of general and internal medical conditions, including:\\nDigestive disorders and gastritis\\nManagement of chronic conditions such as diabetes, hypertension, and cholesterol disorders\\nLiver, gallbladder, kidney, pancreas, and respiratory system conditions\\nTreatment of all infectious diseases and various infections\\nAdditional expertise in ultrasound scanning\",\"so\":\"<h3>Cudurrada Gudaha (Internal Medicine)</h3><p><strong>In ka badan toban sano oo khibrad ah</strong></p><p>Wuxuu ku takhasusay baaritaanka iyo daaweynta xaaladaha caafimaad ee guud iyo kuwa gudaha, oo ay ka mid yihiin:</p><ul><li>Xanuunada dheefshiidka iyo caabuqa caloosha (Gastritis).</li><li>Maareynta xaaladaha daba-dheeraada sida macaanka, dhiig-karka, iyo kordhinka dufanka dhiigga (Cholesterol).</li><li>Xanuunada ku dhaca beerka, xameetida, kelyaha, ganaca, iyo hab-dhiska neefsashada.</li><li>Daaweynta dhammaan cudurrada faafa iyo caabuqyada kala duwan.</li><li>Khibrad dheeraad ah oo ku saabsan ku baarista qalabka Ultrasound-ka.</li></ul><p><br></p>\"}','doctor-images/01KR8RTWF4J9SN9G92X2BFER1V.png',NULL,'upload','+252 61 000 0001','https://www.youtube.com/watch?v=IagYUKyS0cg',1,'2026-05-10 06:27:10','2026-05-12 04:02:45'),(10,NULL,9,'{\"en\":\"DR KEYSAR MOHAMED\",\"so\":\"DR KEYSAR MOHAMED\"}','dr-keysar-mohamed','{\"en\":\"MBBS, MS OBG\",\"so\":\"MBBS, MS OBG\"}','{\"en\":\"Specialized in the diagnosis and management of:\\n\\nMenstrual disorders, recurrent miscarriages, and infertility\\nChronic medical conditions during pregnancy such as hypertension, diabetes, and persistent infections\\n\\nProvides advanced obstetric and gynecological procedures including:\\n\\nCesarean section (C-Section) for the safe delivery of mother and baby\\nSurgical treatment of ovarian cysts and uterine fibroids\\nSurgical management of ectopic pregnancy\\nNormal vaginal delivery and management of miscarriage-related conditions\",\"so\":\"Waxay daaweyneysaa:\\n•\\tKhalkhalka ku yimaada caadada dhicinta soo noqnoqota, dhalmo la’aanta \\n•\\tLa tacaalida cudurada jiitama ee hooyada uurka leh sida dhiigkarka, macaanka iyo caabuqyada daba dheeraada \\nWaxay fulinaysaa qalliinada sida:\\n•\\tQalliinka lagu kala badbaadiyo hooyada & ilmaha (C-Section) \\n•\\tQalliinka buro biyoodka minka & isufuranka \\n•\\tQalliinka ilmaha ku abuurma minka banaankiisa (Ectopic Pregnancy) \\n•\\tDhalmada dabiiciga (Vaginal Delivery) & la tacaalida xaaladaha dhiciska \\n\"}','doctor-images/01KRB0JAJP2X4RNYTAW14NA7VT.png',NULL,'upload','0906661110',NULL,1,'2026-05-11 04:56:00','2026-05-12 04:28:14'),(11,NULL,2,'{\"en\":\"DR SAFIYO ALI BARRE\",\"so\":\"DR SAFIYO ALI BARRE\"}','dr-safiyo-ali-barre','{\"en\":\"Neonatology/Pediatric\",\"so\":\"Neonatology/Pediatric\"}','{\"en\":\"Specialized in the diagnosis and management of:\\n\\nPediatric respiratory diseases including tonsillitis, bronchitis, asthma, and related conditions\\nPediatric urinary tract disorders such as urinary tract infections (UTIs) and urinary incontinence\\nDigestive system disorders including diarrhea and gastritis\\nChildhood malnutrition and dehydration management\\nCare, growth monitoring, and management of premature infants and neonates\",\"so\":\"<p><strong>DH. CARUURTA (Pediatrician)</strong></p><h3><strong>Waxay daaweyneysaa:</strong></h3><ul><li>Cudurada neefmareenka caruurta sida qumanka, burukiitada, naqaska iwm&nbsp;</li><li>Cudurada kaadimareenka sida caabuqyada kaadimareenka caruurta, kaadi baxsadka&nbsp;</li><li>Cudurada dheefshiidka sida shubanka, gaastariiga&nbsp;</li><li>Nafaqo darida caruurta &amp; la tacaalida fuuqbaxa&nbsp;</li><li>Korinta &amp; daryeelka dhiciska an bilaaha dhamaysan&nbsp;</li></ul>\"}','doctor-images/01KRB14Q13GY8H4FG59DF9JG32.png',NULL,'upload','0906661110',NULL,1,'2026-05-11 05:06:02','2026-05-12 05:26:42'),(12,NULL,1,'{\"en\":\"DR ABDIRAHMAN A/KAAFI\",\"so\":\"DR ABDIRAHMAN A/KAAFI\"}','dr-abdirahman-abdikaafi','{\"en\":\"MBBS, MS Ortho\",\"so\":\"MBBS, MS Ortho\"}','{\"en\":\"ORTHOPEDICS & TRAUMA SURGERY\\n\\nSpecialized in the diagnosis and treatment of:\\n\\nDisorders affecting the bones, muscles, tendons, cartilage, and joints\\nFracture management and bone casting procedures\\nDiagnosis and treatment of rheumatic and musculoskeletal conditions\",\"so\":\"<p><strong>DH. LAFAHA &amp; QALLIIMADOODA (Orthopedic)</strong></p><h3><strong>Wuxuu daaweynayaa cudurada:</strong></h3><ul><li>Lafaha, murqaha, seedaha, carjawda &amp; kala goysyda&nbsp;</li><li>Kabniinka lafaha jaban&nbsp;</li><li>Daaweynta roomatisamka&nbsp;</li></ul>\"}','doctor-images/01KRB1HKXASV2Z24T6EA9Z784C.png',NULL,'upload','0906661110',NULL,1,'2026-05-11 05:13:05','2026-05-12 04:29:58'),(13,NULL,1,'{\"en\":\"DR MOHAMUD ALI (MUSLIM)\",\"so\":\"DR MOHAMUD ALI (MUSLIM)\"}','dr-mohamud-ali-muslim','{\"en\":\"MBBS, MSc Ophth\",\"so\":\"MBBS, MSc Ophth\"}','{\"en\":\"Specialized in the diagnosis and treatment of:\\n\\nEye infections, trachoma, allergies, dry eye syndrome, and glaucoma\\n\\nProvides advanced ophthalmic procedures including:\\n\\nCataract surgery\\nGlaucoma management and surgical treatment\\nCorrection of strabismus (crossed eyes)\\nVision assessment and eye examinations\\nPrescription and fitting of corrective eyeglasses\",\"so\":\"<p><strong>QALLIINKA &amp; DAWAYNTA INDHAHA (Ophthalmologist)</strong></p><ul><li>Daaweynta caabuqyada indhaha, tarakomada, xasaasiyada, qallaylka indhaha, biyaha ku furma indhaha&nbsp;</li><li>Qalliimada indhaha sida: fiiqida caadka, biyo xirista indhaha, toosinta weershaha, cabbirida araga, qorista &amp; sameynta muraayadaha&nbsp;</li></ul>\"}','doctor-images/01KRB2T505VS4M64T9EKP14CW6.png',NULL,'upload','0906661110',NULL,1,'2026-05-11 05:32:52','2026-05-12 04:31:02'),(14,NULL,3,'{\"en\":\"DR MOHAMUD HURUSE\"}','dr-mohamud-huruse','{\"en\":\"NEUROLOGY & MENTAL HEALTH\"}','{\"en\":\"\\nSpecialized in the diagnosis and management of:\\n\\nStroke, epilepsy, and back pain\\nInsomnia, stress-related conditions, and migraines\\nMemory disorders and other neurological conditions\"}','doctor-images/01KRB34G483SR57N34QP3GWQ34.png',NULL,'upload','0906661110',NULL,1,'2026-05-11 05:40:52','2026-05-11 05:40:52'),(15,NULL,5,'{\"en\":\"Mohammad Sulieman Ibrahim\",\"so\":\"Maxamed Suleymaan\"}','mohammad-sulieman-ibrahim','{\"en\":\"Laboratory Manager\",\"so\":\"Maamulaha Shaybaarka\"}','{\"en\":\"<p>With over <strong>9 years of experience</strong> in the Medical Laboratory Department, Dr. Mohammad Sulieman directs and manages the laboratory services with professionalism and dedication. He ensures the implementation of strict quality control and quality assurance standards to guarantee accurate, reliable, and timely laboratory results. Dr. Mohammad is committed to maintaining high laboratory performance, patient safety, and continuous improvement while leading the department with excellence and integrity.</p>\",\"so\":\"<p>Isagoo leh khibrad ka badan 9 sano oo dhinaca Waaxda Shaybaarka Caafimaadka ah, Dr. Mohammad Sulieman wuxuu maamulaa isla markaana hagaa adeegyada shaybaarka si xirfad iyo hufnaan leh. Wuxuu hubiyaa in si joogto ah loo dabaqo nidaamyada tayada iyo kormeerka saxnaanta (Quality Control &amp; Quality Assurance) si loo helo natiijooyin sax ah, lagu kalsoonaan karo, isla markaana waqtigooda ku soo baxa. Dr. Mohammad waxa uu ka go’an ilaalinta tayada adeegga shaybaarka, badbaadada bukaanka, iyo horumarinta joogtada ah ee waaxda isagoo ku hoggaaminaya xirfad, daacadnimo, iyo mas’uuliyad sare.</p>\"}','doctor-images/01KRD5YSDKMTX7SW6XS65WBXPJ.png',NULL,'upload','+252906660001',NULL,1,'2026-05-12 01:08:40','2026-05-12 01:08:40'),(16,NULL,15,'{\"en\":\"Dr. Muse Abdulahi\",\"so\":\"Dr. Muse Abdulahi\"}','dr-muse-abdulahi','{\"en\":\"General Director of KAAFI Hospitals\",\"so\":\"Agaasimaha KAAFI Hospitals\"}','{\"so\":null}','doctor-images/01KRD66F936SWEH73JFVMFY07B.png',NULL,'upload','+252 906661110',NULL,1,'2026-05-12 01:12:51','2026-05-12 01:12:51'),(17,NULL,7,'{\"en\":\"Dr A/Qafar Hareed \",\"so\":\"Dr A/Qqafar Hareed \"}','dr-abdiqafar-hareed-salah','{\"en\":\"MBBS, Anaesthetist\",\"so\":\"MBBS, Anaesthetist\"}','{\"en\":\"<p>MBBS, Anaesthetist</p>\",\"so\":\"<p>MBBS, Anaesthetist</p>\"}','doctor-images/01KRDES03JPFX1VWNAMD8Z25YP.png',NULL,'upload','+252 906661110',NULL,1,'2026-05-12 03:42:47','2026-05-12 03:44:52'),(18,NULL,12,'{\"en\":\"Dr Jama Ali Ahmed\",\"so\":\"Dr Jama Ali Ahmed\"}','dr-jama-ali-ahmed','{\"en\":\"MBBS, Dermatology\",\"so\":\"MBBS, Dermatology\"}','{\"en\":\"<p>Dermatology</p>\",\"so\":\"<p>Dermatology</p>\"}','doctor-images/01KRDQQNKCZSJPPWHV30HSK82E.png',NULL,'upload',NULL,NULL,1,'2026-05-12 06:19:21','2026-05-12 06:19:21');
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_02_143310_create_permission_tables',1),(5,'2026_05_02_143328_create_departments_table',1),(6,'2026_05_02_143329_create_doctors_table',1),(7,'2026_05_02_143333_create_blog_categories_table',1),(8,'2026_05_02_143334_create_appointments_table',1),(9,'2026_05_02_143335_create_blog_posts_table',1),(10,'2026_05_02_143339_create_blog_comments_table',1),(11,'2026_05_02_143341_create_pages_table',1),(12,'2026_05_02_143343_create_settings_table',1),(13,'2026_05_02_143345_create_ai_conversations_table',1),(14,'2026_05_02_143348_create_doctor_schedules_table',1),(15,'2026_05_02_143350_create_appointment_slots_table',1),(16,'2026_05_03_055845_add_seo_fields_to_blog_posts_table',1),(17,'2026_05_05_042208_add_role_to_ai_conversations_table',1),(18,'2026_05_05_042539_add_message_to_ai_conversations_table',1),(19,'2026_05_05_045947_modify_ai_conversations_table_and_create_site_settings_table',1),(20,'2026_05_05_081600_add_featured_image_url_to_blog_posts_table',1),(21,'2026_05_06_080600_upgrade_blog_for_ads_and_analytics',1),(22,'2026_05_10_085400_add_group_and_type_to_settings_table',2),(23,'2026_05_10_092500_add_video_and_image_type_to_doctors_table',2),(24,'2026_05_11_202400_add_parent_id_to_departments_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`title`)),
  `slug` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','web','2026-05-07 05:06:49','2026-05-07 05:06:49'),(2,'Receptionist','web','2026-05-07 05:06:49','2026-05-07 05:06:49'),(3,'Doctor','web','2026-05-07 05:06:49','2026-05-07 05:06:49'),(4,'Patient','web','2026-05-07 05:06:49','2026-05-07 05:06:49');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('aZ4RMMxfDi0amKOLEUJjFihhJiWv3tqYVv72YEca',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTo5OntzOjY6Il90b2tlbiI7czo0MDoiSDY2Z2VMeUljWFhJYmw1NmdoYUtTV093ZmxsV1E5ZnNtcGVMcWJiQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWJvdXQiO3M6NToicm91dGUiO047fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjVmODljODBmYTQ5MjE3ZmNhYzM2NTM5ZGFhNjI0NmNjNTRhZDUxODhkOGRmOTgyYjdiNTA3ZTA1YjNiY2QxMTkiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6NjoidGFibGVzIjthOjI6e3M6NDE6ImE1OWI1NGEwYjQ0YWE4YmQwM2RjYzhkOTU2OTAxYTFlX3Blcl9wYWdlIjtzOjI6IjI1IjtzOjQ4OiJhNTliNTRhMGI0NGFhOGJkMDNkY2M4ZDk1NjkwMWExZV90b2dnbGVkX2NvbHVtbnMiO2E6MTp7czoxMDoiY3JlYXRlZF9hdCI7YjowO319czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1778564524),('oykKcqRpYtLLfnOlCG1LilTOXevDdnOGfRwDb9Ty',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiTXhia1liUk9yOUE0dHhwYllqcXc0Q2dSekFYV2ZDdlBvRUNSWHdZbCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjVmODljODBmYTQ5MjE3ZmNhYzM2NTM5ZGFhNjI0NmNjNTRhZDUxODhkOGRmOTgyYjdiNTA3ZTA1YjNiY2QxMTkiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6NjoibG9jYWxlIjtzOjI6ImVuIjt9',1778584486);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `type` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'logo_path','\"brand\\/01KR8J01AYH9YTKX3CVSZJWHQ1.png\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:02:51'),(2,'logo_height','\"40\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:09:57'),(3,'logo_position','\"left\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:09:57'),(4,'hero_bg_path','\"brand\\/01KR8JD0K5250T46Q9VQ0RZR3B.png\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:09:57'),(5,'hero_bg_opacity','\"90\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:15:41'),(6,'chatbot_avatar_path','\"brand\\/01KR8JD0KZGJ80646QG9NMSNTM.png\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:09:57'),(7,'location_coordinates','\"{\\\"lat\\\":11.267725875318874,\\\"lng\\\":49.184354636436495}\"',NULL,NULL,'2026-05-10 06:02:51','2026-05-10 06:02:51'),(8,'hospital_name','\"KAAFI HOSPITALS\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-10 06:14:11'),(9,'hospital_address','\"Main Road, Opposite Shabeele Hotel, Bosaso, Bari, Somalia\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-11 13:47:02'),(10,'working_hours','\"24 Hours\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-10 06:14:11'),(11,'contact_phone','\"+25290 6660001\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-11 13:46:39'),(12,'emergency_phone','\"4477\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-12 02:24:31'),(13,'contact_email','\"info@kaafihospitals.com\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-11 13:46:39'),(14,'facebook_url','\"https:\\/\\/www.facebook.com\\/KAAFIHOSPITALs\"',NULL,NULL,'2026-05-10 06:14:11','2026-05-12 02:24:31'),(15,'twitter_url',NULL,NULL,NULL,'2026-05-10 06:14:11','2026-05-10 06:14:11'),(16,'instagram_url',NULL,NULL,NULL,'2026-05-10 06:14:11','2026-05-10 06:14:11'),(17,'whatsapp_number','\"+25290 5494477\"',NULL,NULL,'2026-05-11 13:52:33','2026-05-11 13:52:33'),(18,'tiktok_url','\"https:\\/\\/www.tiktok.com\\/@kaafihospital3\"',NULL,NULL,'2026-05-11 13:52:33','2026-05-12 02:24:31'),(19,'city_name','\"Bosaso, Bari, Somalia\"',NULL,NULL,'2026-05-11 13:52:33','2026-05-12 02:25:44'),(20,'about_gallery','[\"01KRD8XPFPCRPKV6HVB4E94TH3.jpg\",\"gallery\\/01KRD971HFSAM7PAACP0N2J18S.jpg\",\"gallery\\/01KRD971JNS0M2J33TDA71HPM9.jpg\",\"gallery\\/01KRD971KJ2QZX7HDD0A0VBC4X.jpg\",\"gallery\\/01KRD971M8D4BDWA9HYPSKDGW9.jpg\",\"gallery\\/01KRD971MZJT1XYV1YFKG5A3DK.jpg\",\"gallery\\/01KRD971NM3QFH3QNQZ3HS58DE.jpg\"]',NULL,NULL,'2026-05-12 02:00:30','2026-05-12 02:05:36'),(21,'additional_phones','[{\"number\":\"+25290-6660001\",\"label\":null},{\"number\":\"+25290-6660002\",\"label\":null}]',NULL,NULL,'2026-05-12 02:24:31','2026-05-12 02:24:31');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logo_path` varchar(255) DEFAULT NULL,
  `logo_height` int(11) NOT NULL DEFAULT 40,
  `logo_position` varchar(255) NOT NULL DEFAULT 'left',
  `hero_bg_path` varchar(255) DEFAULT NULL,
  `hero_bg_opacity` int(11) NOT NULL DEFAULT 10,
  `chatbot_avatar_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,NULL,40,'left',NULL,10,NULL,'2026-05-07 05:06:49','2026-05-07 05:06:49');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_stats`
--

DROP TABLE IF EXISTS `site_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_stats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_stats_session_id_unique` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_stats`
--

LOCK TABLES `site_stats` WRITE;
/*!40000 ALTER TABLE `site_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@kaafihospitals.so',NULL,NULL,'$2y$12$Ryw4aPKwLCIu2eOciL8J/eh6dZdJYoU3NSR6pCauwm/I.a7pKiTvu',NULL,'2026-05-07 05:06:49','2026-05-07 05:06:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-12 16:15:53
