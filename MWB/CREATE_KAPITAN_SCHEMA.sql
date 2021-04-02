CREATE DATABASE  IF NOT EXISTS `heroku_483d8bf99e42fe3` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `heroku_483d8bf99e42fe3`;
-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: heroku_483d8bf99e42fe3
-- ------------------------------------------------------
-- Server version	8.0.22

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `ADMIN_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_STATUS` int NOT NULL,
  `ADMIN_LEVEL` int NOT NULL,
  `ADMIN_ACCOUNT` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_PASSWORD` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_NAME` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_AVATAR_URL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ADMIN_IDENTIFIER` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_SESSION` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_SIGNIN_AUTHENTICATION` tinyint NOT NULL,
  `ADMIN_SIGNIN_TIMEOUT` datetime DEFAULT NULL,
  PRIMARY KEY (`ADMIN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('AD0001',1,1,'HugoChiang','91ba2e4729fcbf9c99dce087ebb40b27fa8b80da601a00a5d0747bde9826723c','雨果先生','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Admin-Avatar/AD0001_bvhma5.jpg','HG0303drinkTea!','https://res.cloudinary.com/hugo-chiang/image/upload/v1615745171/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Admin-Avatar/AD0001_bvhma5.jpg',0,'2021-03-21 00:00:00'),('AD0002',1,3,'DemoTester','0ffe1abd1a08215353c233d6e009613e95eec4253832a761af28ff37ac5a150c','演示測試者','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Admin-Avatar/AD0002_ru70uy.jpg','hire@@me!PLZ','n!K4cf5Ewz9dPmjTyK$j',0,'2021-03-21 00:00:00');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking` (
  `BOOKING_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `BOOKING_DATE` date NOT NULL,
  `BOOKING_NUM_OF_PEOPLE` int NOT NULL,
  `BOOKING_VISIBLE_ON_WEB` int NOT NULL,
  `FK_PROJECT_ID_for_BK` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `FK_ORDER_DETAIL_ID_for_BK` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`BOOKING_ID`),
  KEY `FK_PROJECT_ID_for_BK_idx` (`FK_PROJECT_ID_for_BK`),
  KEY `FK_ORDER_DETAIL_ID_for_BK_idx` (`FK_ORDER_DETAIL_ID_for_BK`),
  CONSTRAINT `FK_ORDER_DETAIL_ID_for_BK` FOREIGN KEY (`FK_ORDER_DETAIL_ID_for_BK`) REFERENCES `order_details` (`ORDER_DETAIL_ID`),
  CONSTRAINT `FK_PROJECT_ID_for_BK` FOREIGN KEY (`FK_PROJECT_ID_for_BK`) REFERENCES `projects` (`PROJECT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `CATEGORY_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `CATEGORY_NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `CATEGORY_VISIBLE_ON_WEB` int NOT NULL,
  PRIMARY KEY (`CATEGORY_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES ('CG0001','台北',1),('CG0002','宜蘭',1),('CG0003','台南',1),('CG0004','高雄',1),('CG0005','屏東',1),('CG0006','澎湖',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departure_location`
--

DROP TABLE IF EXISTS `departure_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departure_location` (
  `LOCATION_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_NAME` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_LNG` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_LAT` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_DESCRIPTION` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LOCATION_VISIBLE_ON_WEB` int NOT NULL,
  PRIMARY KEY (`LOCATION_ID`),
  UNIQUE KEY `LOCATION_NAME_UNIQUE` (`LOCATION_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departure_location`
--

LOCK TABLES `departure_location` WRITE;
/*!40000 ALTER TABLE `departure_location` DISABLE KEYS */;
INSERT INTO `departure_location` VALUES ('LC0001','宜蘭烏石港','121.834840','24.869254','<p>烏石漁港，是位於宜蘭縣頭城鎮的觀光漁港，漁港管理單位行政院農業委員會漁業署將其列為第一類漁港。</p><p>烏石漁港自古就是台灣東北部出入的門戶，現在和梗枋漁港及南方澳漁港並列宜蘭3大賞鯨觀光漁港。一年一度的頭城搶孤也是在此地舉辦。烏石漁港的名稱，是因港灣內的巨大黑礁石而得名。</p>',1),('LC0002','測試地點0002','121.834840','24.869254',NULL,1),('LC0003','測試地點0003','121.834840','24.869254',NULL,1),('LC0004','4','0','0',NULL,1),('LC0005','5','0','0',NULL,1),('LC0006','6','0','0',NULL,1),('LC0007','7','0','0',NULL,1),('LC0008','8','0','0',NULL,1),('LC0009','9','0','0',NULL,1);
/*!40000 ALTER TABLE `departure_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edm_list`
--

DROP TABLE IF EXISTS `edm_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edm_list` (
  `EDM_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `EDM_REGISTERED_DATE` datetime NOT NULL,
  `EDM_STATUS` int NOT NULL,
  `EDM_ADDRESS` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`EDM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edm_list`
--

LOCK TABLES `edm_list` WRITE;
/*!40000 ALTER TABLE `edm_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `edm_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `MEMBER_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_REGISTERED_DATE` datetime NOT NULL,
  `MEMBER_STATUS` int NOT NULL,
  `MEMBER_ACCOUNT` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_PASSWORD` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_NICKNAME` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_NAME` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_PHONE` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_AVATAR_URL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_EC_NAME` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_EC_PHONE` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_EC_EMAIL` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_SESSION` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_SIGNIN_TIMEOUT` datetime NOT NULL,
  `MEMBER_SIGNIN_AUTHENTICATION` int NOT NULL,
  `MEMBER_FOR_TESTING` int NOT NULL,
  `MEMBER_VISIBLE_ON_WEB` int NOT NULL,
  PRIMARY KEY (`MEMBER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES ('MB0000001','2020-01-01 00:00:00',1,'Dennis@gmail.com','7631e16d50b969a9612fce1d1c37b15ba42cc746d843b38ed77bba7c3f686846','紀老爺','紀老爺','0933123456','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/fbhbntggsy79xdhwmyok','巴奇','0922987654','Bucky@shiba.com','1','2021-03-25 14:00:00',0,0,1),('MB0000002','2020-01-01 00:00:00',1,'Nobita@yahoo.com.jp','b61ae2e09ae7b4dffbb3478f2f5493a99536e611d973cb968f83354f7760866f',NULL,'','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/hpvdunv8g3a4t9b4sbeg','','','','1','2021-03-25 14:00:00',0,0,1),('MB0000003','2020-05-20 00:00:00',1,'WeiWei40609@outlook.com','43cf3f9e354d56d9b99b74bde8a906289dbb3ddd9fca40509be274f5634d9f8f','男神','黃負心','0955078978','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/v98kswxubkl29pqlc9tp','黃太','0977888999','','1','2021-03-25 14:00:00',0,0,1);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `ORDER_DETAIL_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_STATUS` int NOT NULL,
  `ORDER_DETAIL_AMOUNT` int NOT NULL,
  `ORDER_DETAIL_MC_NAME` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_MC_PHONE` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_MC_EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_EC_NAME` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_EC_PHONE` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_EC_EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_FOR_TESTING` int NOT NULL,
  `ORDER_DETAIL_VISIBLE_ON_WEB` int NOT NULL,
  `FK_ORDER_ID_for_ODD` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ORDER_DETAIL_ID`),
  KEY `FK_ORDERS_ID_for_ODD_idx` (`FK_ORDER_ID_for_ODD`),
  CONSTRAINT `FK_ORDER_ID_for_ODD` FOREIGN KEY (`FK_ORDER_ID_for_ODD`) REFERENCES `orders` (`ORDER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `ORDER_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_STATUS` int NOT NULL,
  `ORDER_DATE` datetime NOT NULL,
  `ORDER_TOTAL_CONSUMPTION` int NOT NULL,
  `ORDER_TOTAL_DISCOUNT` int NOT NULL,
  `ORDER_MC_NAME` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_MC_PHONE` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_MC_EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_EC_NAME` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_EC_PHONE` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_EC_EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_FOR_TESTING` int NOT NULL,
  `ORDER_VISIBLE_ON_WEB` int NOT NULL,
  `FK_MEMBER_ID_for_OD` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ORDER_ID`),
  KEY `FK_MEMBER_ID_for_OD_idx` (`FK_MEMBER_ID_for_OD`),
  CONSTRAINT `FK_MEMBER_ID_for_OD` FOREIGN KEY (`FK_MEMBER_ID_for_OD`) REFERENCES `members` (`MEMBER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `PROJECT_ID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `PROJECT_STATUS` int NOT NULL,
  `PROJECT_NAME` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `PROJECT_AVATAR_URL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_CAROUSEL_URL` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_ORIGINAL_PRICE_PER_PERSON` int NOT NULL,
  `PROJECT_MIN_NUM_OF_PEOPLE` int NOT NULL,
  `PROJECT_MAX_NUM_OF_PEOPLE` int NOT NULL,
  `PROJECT_SUMMARY` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_DESCRIPITION` varchar(20000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_VISIBLE_ON_WEB` int NOT NULL,
  `PROJECT_FOR_TESTING` int NOT NULL,
  `FK_CATEGORY_ID_for_PJ` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `FK_LOCATION_ID_for_PJ` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`PROJECT_ID`),
  KEY `FK_CATEGORY_ID_for_PJ_idx` (`FK_CATEGORY_ID_for_PJ`),
  KEY `FK_LOCATION_ID_for_PJ_idx` (`FK_LOCATION_ID_for_PJ`),
  CONSTRAINT `FK_CATEGORY_ID_for_PJ` FOREIGN KEY (`FK_CATEGORY_ID_for_PJ`) REFERENCES `category` (`CATEGORY_ID`),
  CONSTRAINT `FK_LOCATION_ID_for_PJ` FOREIGN KEY (`FK_LOCATION_ID_for_PJ`) REFERENCES `departure_location` (`LOCATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secret_keys`
--

DROP TABLE IF EXISTS `secret_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secret_keys` (
  `SECRET_KEY_ID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `SECRET_KEY_USAGE` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `SECRET_KEY_VALUE` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`SECRET_KEY_ID`),
  UNIQUE KEY `SECRET_KEY_VALUE_UNIQUE` (`SECRET_KEY_VALUE`),
  UNIQUE KEY `SECRET_KEY_ID_UNIQUE` (`SECRET_KEY_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secret_keys`
--

LOCK TABLES `secret_keys` WRITE;
/*!40000 ALTER TABLE `secret_keys` DISABLE KEYS */;
INSERT INTO `secret_keys` VALUES ('KY0001','admin','1A9D9'),('KY0002','members','CEB6F');
/*!40000 ALTER TABLE `secret_keys` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-02 16:48:47
