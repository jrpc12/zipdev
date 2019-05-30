-- MySQL dump 10.14  Distrib 5.5.56-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: zipdev
-- ------------------------------------------------------
-- Server version	5.5.56-MariaDB

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
-- Table structure for table `Email`
--

DROP TABLE IF EXISTS `Email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Email` (
  `emailId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) DEFAULT NULL,
  `phoneBookId` int(11) DEFAULT NULL,
  PRIMARY KEY (`emailId`),
  KEY `phoneBookId` (`phoneBookId`),
  CONSTRAINT `Email_ibfk_1` FOREIGN KEY (`phoneBookId`) REFERENCES `PhoneBook` (`phoneBookId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Email`
--

LOCK TABLES `Email` WRITE;
/*!40000 ALTER TABLE `Email` DISABLE KEYS */;
INSERT INTO `Email` VALUES (1,'test@test.com',9),(2,'test2@test.com',9),(3,'test@test.com',10),(4,'test2@test.com',10),(5,'test@test.com',11),(6,'test2@test.com',11),(7,'test@test.com',12),(8,'test2@test.com',12),(11,'test@test.com',14),(12,'test2@test.com',14),(13,'test@test.com',15),(14,'test2@test.com',15),(15,'test@test.com',16),(16,'test2@test.com',16),(17,'anon1t@test.com',17),(18,'anon22@test.com',17),(19,'x@test.com',18),(20,'y@test.com',18),(21,'2@test.com',2);
/*!40000 ALTER TABLE `Email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PhoneBook`
--

DROP TABLE IF EXISTS `PhoneBook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PhoneBook` (
  `phoneBookId` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`phoneBookId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PhoneBook`
--

LOCK TABLES `PhoneBook` WRITE;
/*!40000 ALTER TABLE `PhoneBook` DISABLE KEYS */;
INSERT INTO `PhoneBook` VALUES (2,'2name','2lastbame'),(3,'Jimmy','Pat'),(4,'Jimmy','Pat'),(5,'Jimmy','Pat'),(6,'Jimmy','Pat'),(7,'Jimmy','Pat'),(8,'Jimmy','Pat'),(9,'Jimmy','Pat'),(10,'Jimmy','Pat'),(11,'Jimmy','Pat'),(12,'Jimmy','Pat'),(14,'Jimmy','Pat'),(15,'Jimmy','Pat'),(16,'Jimmy','Pat'),(17,'Post','Man'),(18,'Ana','Powell');
/*!40000 ALTER TABLE `PhoneBook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PhoneNumber`
--

DROP TABLE IF EXISTS `PhoneNumber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PhoneNumber` (
  `phoneNumberId` int(11) NOT NULL AUTO_INCREMENT,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `phoneBookId` int(11) DEFAULT NULL,
  PRIMARY KEY (`phoneNumberId`),
  KEY `phoneBookId` (`phoneBookId`),
  CONSTRAINT `PhoneNumber_ibfk_1` FOREIGN KEY (`phoneBookId`) REFERENCES `PhoneBook` (`phoneBookId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PhoneNumber`
--

LOCK TABLES `PhoneNumber` WRITE;
/*!40000 ALTER TABLE `PhoneNumber` DISABLE KEYS */;
INSERT INTO `PhoneNumber` VALUES (3,'9998122323',14),(4,'55564652342',14),(5,'9998122323',15),(6,'55564652342',15),(7,'9998122323',16),(8,'55564652342',16),(9,'123123123',17),(10,'7867867868',17),(11,'000000000001',18),(12,'444444444444',18),(13,'22222222222222',2);
/*!40000 ALTER TABLE `PhoneNumber` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-30  0:45:26
