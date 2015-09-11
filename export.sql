CREATE DATABASE  IF NOT EXISTS `scout-merit` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `scout-merit`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: scout-merit
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tr_permissions`
--

DROP TABLE IF EXISTS `tr_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_permissions`
--

LOCK TABLES `tr_permissions` WRITE;
/*!40000 ALTER TABLE `tr_permissions` DISABLE KEYS */;
INSERT INTO `tr_permissions` VALUES (3,1,1,'2015-09-08 08:23:23','2015-09-08 08:23:23');
/*!40000 ALTER TABLE `tr_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_scouts`
--

DROP TABLE IF EXISTS `tr_scouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_scouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `bsid` varchar(45) NOT NULL,
  `rank` varchar(45) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `merit_badge` varchar(255) DEFAULT NULL,
  `partial_badge` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `metadata` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_scouts`
--

LOCK TABLES `tr_scouts` WRITE;
/*!40000 ALTER TABLE `tr_scouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_scouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_users`
--

DROP TABLE IF EXISTS `tr_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `active_hash` varchar(255) DEFAULT NULL,
  `recover_hash` varchar(255) DEFAULT NULL,
  `remember_identifier` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `update_email` varchar(255) DEFAULT NULL,
  `update_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_users`
--

LOCK TABLES `tr_users` WRITE;
/*!40000 ALTER TABLE `tr_users` DISABLE KEYS */;
INSERT INTO `tr_users` VALUES (1,'meun5',NULL,NULL,'pip@littlepip.co','$2y$10$nx1NDC2uat7NKmVCFNce7..XPgFrP095yiUJCx.OiyD5Fo04khIiO',1,'',NULL,NULL,NULL,NULL,NULL,'2015-09-06 01:15:42','2015-09-06 05:18:38');
/*!40000 ALTER TABLE `tr_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'scout-merit'
--

--
-- Dumping routines for database 'scout-merit'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-08 20:37:09
