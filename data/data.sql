-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: zf2_unlikelysource_org
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.10.1

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
-- Table structure for table `classfile`
--

DROP TABLE IF EXISTS `classfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classfile` (
  `classfile_id` int(8) NOT NULL AUTO_INCREMENT,
  `title` char(64) NOT NULL,
  `body` text NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `class` char(16) DEFAULT NULL,
  PRIMARY KEY (`classfile_id`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classfile`
--

LOCK TABLES `classfile` WRITE;
/*!40000 ALTER TABLE `classfile` DISABLE KEYS */;
INSERT INTO `classfile` VALUES (1,'2013-02-26 Module 1 Lab','<?php\n// public/index.php\n/**\n * This makes our life easier when dealing with paths. Everything is relative\n * to the application root now.\n */\nchdir(dirname(__DIR__));\n\n// Setup autoloading\n//require \'init_autoloader.php\';\n$zf2Path = \'vendor/ZF2/library\';\ninclude $zf2Path . \'/Zend/Loader/AutoloaderFactory.php\';\nZend\\Loader\\AutoloaderFactory::factory(array(\n	\'Zend\\Loader\\StandardAutoloader\' => array(\n		\'autoregister_zf\' => true\n	)\n));\nrequire $zf2Path . \'/Zend/Stdlib/compatibility/autoload.php\';\nrequire $zf2Path . \'/Zend/Session/compatibility/autoload.php\';\n\n// Run the application!\nZend\\Mvc\\Application::init(require \'config/application.config.php\')->run();\n','2013-02-27 12:25:00','zf2f-2013-02-25');
/*!40000 ALTER TABLE `classfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(6) DEFAULT NULL,
  `super` smallint(6) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

