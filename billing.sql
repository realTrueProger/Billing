-- MySQL dump 10.13  Distrib 5.6.26, for Win32 (x86)
--
-- Host: localhost    Database: billing
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `cdrdetailedcalls`
--

DROP TABLE IF EXISTS `cdrdetailedcalls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdrdetailedcalls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iccid` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `number` varchar(45) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cdrdetailedcalls`
--

LOCK TABLES `cdrdetailedcalls` WRITE;
/*!40000 ALTER TABLE `cdrdetailedcalls` DISABLE KEYS */;
INSERT INTO `cdrdetailedcalls` VALUES (24,18251111,10,'84951234567','2016-12-17 12:00:00');
/*!40000 ALTER TABLE `cdrdetailedcalls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cdrdetailedtraffic`
--

DROP TABLE IF EXISTS `cdrdetailedtraffic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdrdetailedtraffic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iccid` int(11) NOT NULL,
  `mb` int(11) NOT NULL,
  `host` varchar(45) NOT NULL,
  `port` varchar(45) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cdrdetailedtraffic`
--

LOCK TABLES `cdrdetailedtraffic` WRITE;
/*!40000 ALTER TABLE `cdrdetailedtraffic` DISABLE KEYS */;
INSERT INTO `cdrdetailedtraffic` VALUES (19,18251111,5,'yandex.ru','80','2016-12-17 12:15:00');
/*!40000 ALTER TABLE `cdrdetailedtraffic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cdrtest`
--

DROP TABLE IF EXISTS `cdrtest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdrtest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iccid` int(11) NOT NULL,
  `num` varchar(30) NOT NULL,
  `min` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cdrtest`
--

LOCK TABLES `cdrtest` WRITE;
/*!40000 ALTER TABLE `cdrtest` DISABLE KEYS */;
/*!40000 ALTER TABLE `cdrtest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Московский Политех','u');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fizdata`
--

DROP TABLE IF EXISTS `fizdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fizdata` (
  `clientid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `patronymic` varchar(45) NOT NULL,
  `passportid` varchar(45) NOT NULL,
  `passportreceivedin` varchar(100) NOT NULL,
  `passportreceivedate` date NOT NULL,
  `contactnumber` varchar(45) NOT NULL,
  `contactemail` varchar(45) NOT NULL,
  PRIMARY KEY (`clientid`),
  UNIQUE KEY `clientid_UNIQUE` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fizdata`
--

LOCK TABLES `fizdata` WRITE;
/*!40000 ALTER TABLE `fizdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `fizdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `invoiceid` int(11) NOT NULL DEFAULT '0',
  `clientid` int(11) NOT NULL,
  `file` varchar(45) NOT NULL,
  `sum` float NOT NULL,
  `status` varchar(45) NOT NULL,
  `Payday` date DEFAULT NULL,
  PRIMARY KEY (`invoiceid`),
  UNIQUE KEY `invoiceid_UNIQUE` (`invoiceid`),
  UNIQUE KEY `file_UNIQUE` (`file`),
  KEY `client_idx` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES (1,1,'invoices/Invoice 1.pdf',125,'не оплачен',NULL);
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rateplan`
--

DROP TABLE IF EXISTS `rateplan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rateplan` (
  `rateid` int(11) NOT NULL AUTO_INCREMENT,
  `ratename` varchar(45) NOT NULL,
  `permin` float NOT NULL,
  `permb` float NOT NULL,
  PRIMARY KEY (`rateid`),
  UNIQUE KEY `rateplanid_UNIQUE` (`rateid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rateplan`
--

LOCK TABLES `rateplan` WRITE;
/*!40000 ALTER TABLE `rateplan` DISABLE KEYS */;
INSERT INTO `rateplan` VALUES (4,'Inmarsat Test XL',10,5);
/*!40000 ALTER TABLE `rateplan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terminals`
--

DROP TABLE IF EXISTS `terminals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `terminals` (
  `iccid` int(11) NOT NULL,
  `msisdn` int(11) NOT NULL AUTO_INCREMENT,
  `technology` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `balance` float NOT NULL,
  `rateplanid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  PRIMARY KEY (`iccid`),
  UNIQUE KEY `iccid_UNIQUE` (`iccid`),
  UNIQUE KEY `msisdn_UNIQUE` (`msisdn`),
  KEY `rate_idx` (`rateplanid`),
  KEY `client_idx` (`clientid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terminals`
--

LOCK TABLES `terminals` WRITE;
/*!40000 ALTER TABLE `terminals` DISABLE KEYS */;
INSERT INTO `terminals` VALUES (18251111,1,'Inmarsat Bgan M2M','active',0,4,1);
/*!40000 ALTER TABLE `terminals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urdata`
--

DROP TABLE IF EXISTS `urdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urdata` (
  `clientid` int(11) NOT NULL,
  `companyname` varchar(45) NOT NULL,
  `legaladdress` varchar(45) NOT NULL,
  `postaladdress` varchar(45) NOT NULL,
  `bank` varchar(45) NOT NULL,
  `currentaccount` int(11) NOT NULL,
  `corraccount` int(11) NOT NULL,
  `bik` int(11) NOT NULL,
  `inn` int(11) NOT NULL,
  `kpp` int(11) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `contactnumber` varchar(45) NOT NULL,
  `contactemail` varchar(45) NOT NULL,
  PRIMARY KEY (`clientid`),
  UNIQUE KEY `clientid_UNIQUE` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urdata`
--

LOCK TABLES `urdata` WRITE;
/*!40000 ALTER TABLE `urdata` DISABLE KEYS */;
INSERT INTO `urdata` VALUES (1,'Московский Политех','107023 г. Москва, ул. Большая Семеновская, д.','107023 г. Москва, ул. Большая Семеновская, д.','Отделение 1 Москва',2147483647,2147483647,44583001,2147483647,771901001,'Ректор: Николаенко Андрей Владимирович','Телефон/факс бухгалтерия: (495) 223-05-23','isollo@mail.ru');
/*!40000 ALTER TABLE `urdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (19,'admin','c3284d0f94606de1fd2af172aba15bf3','2d5e0263dcef1d2765d0807ceedb35dc');
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

-- Dump completed on 2016-12-21 23:36:19
