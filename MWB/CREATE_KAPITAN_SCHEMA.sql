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
  `ADMIN_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_STATUS` int NOT NULL,
  `ADMIN_LEVEL` int NOT NULL,
  `ADMIN_ACCOUNT` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_PASSWORD` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_NAME` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_AVATAR_URL` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ADMIN_IDENTIFIER` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ADMIN_SESSION` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `admin` VALUES ('AD0001',1,1,'HugoChiang','91ba2e4729fcbf9c99dce087ebb40b27fa8b80da601a00a5d0747bde9826723c','雨果先生','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Admin-Avatar/AD0001_bvhma5.jpg','HG0303drinkTea!','79323770e626318e6d73ffe37ca9727a4921260e40a328551be8839ef60f2e3f',1,'2021-04-12 13:06:02'),('AD0002',1,3,'DemoTester','0ffe1abd1a08215353c233d6e009613e95eec4253832a761af28ff37ac5a150c','演示測試者','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Admin-Avatar/AD0002_ru70uy.jpg','hire@@me!PLZ','ab69e52dfa1d3461a4fae56a27fbcd98ad189fa333f881960119224c67b354a6',1,'2021-04-08 18:31:44');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking` (
  `BOOKING_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BOOKING_DATE` date NOT NULL,
  `BOOKING_NUM_OF_PEOPLE` int NOT NULL,
  `BOOKING_VISIBLE_ON_WEB` int NOT NULL,
  `FK_PROJECT_ID_for_BK` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FK_ORDER_DETAIL_ID_for_BK` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `booking` VALUES ('BK0000000001','2021-04-01',3,1,'PJ0000005','ODD0000000001'),('BK0000000002','2021-04-02',3,1,'PJ0000005','ODD0000000002'),('BK0000000003','2021-04-02',3,1,'PJ0000005','ODD0000000003'),('BK0000000004','2021-04-02',2,1,'PJ0000005','ODD0000000004'),('BK0000000005','2021-04-01',5,1,'PJ0000005','ODD0000000005'),('BK0000000006','2021-04-07',15,1,'PJ0000002','ODD0000000006'),('BK0000000007','2021-04-08',5,1,'PJ0000008','ODD0000000007'),('BK0000000008','2021-04-08',7,1,'PJ0000001','ODD0000000008'),('BK0000000009','2021-04-10',5,1,'PJ0000001','ODD0000000009'),('BK0000000010','2021-04-09',6,1,'PJ0000001','ODD0000000010'),('BK0000000011','2021-04-10',5,1,'PJ0000004','ODD0000000011'),('BK0000000012','2021-04-23',5,1,'PJ0000004','ODD0000000012'),('BK0000000013','2021-04-27',6,1,'PJ0000004','ODD0000000013'),('BK0000000014','2021-04-15',4,1,'PJ0000001','ODD0000000014'),('BK0000000015','2021-04-13',6,1,'PJ0000001','ODD0000000015'),('BK0000000016','2021-04-18',5,1,'PJ0000004','ODD0000000016'),('BK0000000017','2021-04-16',5,1,'PJ0000001','ODD0000000017'),('BK0000000018','2021-04-24',5,1,'PJ0000004','ODD0000000018');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `CATEGORY_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CATEGORY_NAME` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CATEGORY_VISIBLE_ON_WEB` int NOT NULL,
  PRIMARY KEY (`CATEGORY_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES ('CG0001','新北',1),('CG0002','宜蘭',1),('CG0003','台南',1),('CG0004','高雄',1),('CG0005','屏東',1),('CG0006','澎湖',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departure_location`
--

DROP TABLE IF EXISTS `departure_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departure_location` (
  `LOCATION_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_LNG` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_LAT` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LOCATION_DESCRIPTION` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
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
INSERT INTO `departure_location` VALUES ('LC0001','宜蘭烏石漁港','121.83484465905036','24.868634954412986','<p>烏石漁港，是位於宜蘭縣頭城鎮的觀光漁港，漁港管理單位行政院農業委員會漁業署將其列為第一類漁港。</p><p>烏石漁港自古就是台灣東北部出入的門戶，現在和梗枋漁港及南方澳漁港並列宜蘭3大賞鯨觀光漁港。一年一度的頭城搶孤也是在此地舉辦。烏石漁港的名稱，是因港灣內的巨大黑礁石而得名。</p>',1),('LC0002','安平亞果遊艇碼頭','120.16054775816966','22.983859074041572','<p>台南安平遊艇城，包含水域及陸域共占地12公頃，由會員制的遊艇會、海洋學院、海景餐廳、新加坡知名飯店集團-悅榕集團進駐之渡假村、泊位房產等海洋休閒項目組成，將成為台灣第一個，也是最大的遊艇生活重鎮，其中安平亞果遊艇碼頭的建置更讓許多船主、船艇玩家引頸期盼。</p><p>安平亞果遊艇碼頭位於台灣的第一個城市且充滿人文風情的古都安平，西南部沿岸綿延的海岸線，被港務局評比為最適合興建遊艇碼頭之地，特別是安平亞果遊艇碼頭旁依偎著漁光島，這座突出的小島成為天然的擋浪堤，提供碼頭絕佳的安全性，形成全台灣靜穩度最高的遊艇碼頭。</p>',1),('LC0003','澎湖亞果遊艇碼頭','119.5682807343746','23.562304415788937','<p>澎湖亞果遊艇碼頭為馬公第一漁港轉型遊艇碼頭並於2017年6月啟用，為亞果全台第一家擁有國際級自建遊艇碼頭、碼頭專屬服務會所之遊艇集團，澎湖、高雄以及台南亞果遊艇碼頭同步提供服務。</p><p>澎湖亞果遊艇碼頭位於台灣本島與中國沿岸之中介點，又屬澎湖主要航道，陸域方面碼頭位於澎湖馬公市中心，距離鬧區僅五分鐘之車程，附近設有各類飯店、民宿以及各式餐館、便利店以及租賃服務，夏季亦有海上花火節之活動，從碼頭出發無論海域或陸域僅不到10分鐘之航程，體驗澎湖跳島旅遊之最佳選擇。</p>',1),('LC0004','屏東枋寮漁港','120.59350462538053','22.362406097135256','<p>枋寮漁港原本是利用枋寮河口提供給竹筏的停泊地，隨著沿海漁業的興起，擴建為漁港，碼頭邊堤防是釣客的最愛，每天都有釣客在漁港邊享受海釣樂趣，夕陽餘暉下形成特殊美景，也成為枋寮漁港的特色，周邊有許多魚獲攤販販賣著新鮮捕撈的海鮮，是個品嘗海鮮美味的好去處。</p>',1),('LC0005','高雄棧貳庫','120.27708679863737','22.61901355027271','<p>位於鼓山區七賢路底、高雄港2號碼頭的「棧貳庫」前身為日人於大正3年（1914）在新濱町岸壁興建之磚牆瓦頂單層小型倉庫，用以儲存、輸運砂糖為主，迄今已有104年歷史。二次世界大戰期間遭受美軍轟炸，1962年國民政府以鋼筋混凝土柱、力霸鋼筋屋架及磚牆重建，倉庫內並未架設任何支座，規模壯觀之大跨距空間，具有建築史及技術史上之意義，現況地景與老倉建築仍能看出其原扮演之鐵路轉海運的樞紐角色，見證台灣經濟蓬勃起飛的榮景，高雄市政府於2003年公告為歷史建築。</p>',1),('LC0006','澎湖馬公第二漁港','119.56991537036971','23.565845294869252','<p>澎湖縣馬公市區的馬公漁港，原位於今馬公商港處，今址肇建於台灣日治時期昭和13年（1938年），並於昭和15年（1940年）落成。當時澎湖廳為在媽宮三甲地區闢建漁港，特拆除媽宮城，將原為海崖的海尾地區悉數填平造陸，新增「築地町」，其海埔新生地南半部便為「馬公第一漁港」所在處。</p><p>民國50年（1961年），馬公第二漁港完工，其腹地約莫為媽宮東甲、埔仔尾（今馬公市重慶里、光復里）的行政區域，港內水深約3.5公尺，總長度約390公尺。第二漁港腹地較大，可提供500艘漁船停泊，較之第一漁港地點更近內灣，港內風浪較小，可停靠漁船處達四面，漁獲裝卸期間得以縮短，對漁汛期間漁獲量的收穫有正面的效益。根據2005年賴惠敏主編《續修澎湖縣志．財政志》記載，民國39年至70年（1950年－1981年）間使用於馬公漁港的經費為新台幣3100萬元整。</p>',1),('LC0007','屏東後壁湖遊艇港','120.74676344841296','21.94867642772642','<p>後壁湖是墾丁國家公園內最大的漁港，碼頭的市場裡有豐富的漁獲和新鮮的生魚片，每逢假日，市場內總是擠滿了想要大啖海鮮的饕客，相當熱鬧。</p><p>除了美食，後壁湖的港口還有遊艇和觀光潛艇可以搭乘出海，後壁湖海域也是墾丁最成功的海洋保育示範區，海域禁止捕撈魚釣，所以海底生態大概是全墾丁最豐富的地區，只要浮潛就可以看到一大群的魚，現在浮潛想看魚，我們誠心推薦後壁湖。</p>',1),('LC0008','新北淡水漁人碼頭','121.41211126809232','25.18304603895426','<p>漁人碼頭完成於民國76年，原本是為替代日漸淤塞的舊滬尾漁港，發展近海漁業而設，於1978年（民國67）動工分七期施工、1987年完工，陸域面積約15公頃、水域面積約11公頃，共26公頃。近年在行政院農委會漁業署與新北市政府的聯合推動下，將漁港功能多元化，讓漁人碼頭搖身一變，成為一個兼具遊憩功能的港區公園。在捷運通車、週休二日的實施和藍色公路的發展之下，漁人碼頭成為知名的旅遊景點。2003年情人節，跨港的船形景觀大橋取名「情人橋」完工。</p>',1),('LC0009','9','0','0',NULL,1);
/*!40000 ALTER TABLE `departure_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edm_list`
--

DROP TABLE IF EXISTS `edm_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edm_list` (
  `EDM_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EDM_REGISTERED_DATE` datetime NOT NULL,
  `EDM_STATUS` int NOT NULL,
  `EDM_ADDRESS` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
  `MEMBER_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_REGISTERED_DATE` datetime NOT NULL,
  `MEMBER_STATUS` int NOT NULL,
  `MEMBER_ACCOUNT` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_PASSWORD` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_NICKNAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_PHONE` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_AVATAR_URL` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_EC_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_EC_PHONE` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_EC_EMAIL` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEMBER_SESSION` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `members` VALUES ('MB0000001','2020-01-01 00:00:00',1,'Dennis@gmail.com','7631e16d50b969a9612fce1d1c37b15ba42cc746d843b38ed77bba7c3f686846','紀老爺','紀老爺','0933123456','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/hilwkjzj6jwr2sdq3zl6','巴奇','0922987654','Bucky@shiba.com','af042ad096252ef004aa1aabf1cd478a7dcb9d50f926567ff3f888e37467e84f','2021-04-12 17:13:48',1,0,1),('MB0000002','2020-01-01 00:00:00',1,'Nobita@yahoo.com.jp','b61ae2e09ae7b4dffbb3478f2f5493a99536e611d973cb968f83354f7760866f',NULL,'','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/rmz7rrckgf1ovxdlssha','','','','1','2021-03-25 14:00:00',0,0,1),('MB0000003','2020-05-20 00:00:00',1,'WeiWei40609@outlook.com','43cf3f9e354d56d9b99b74bde8a906289dbb3ddd9fca40509be274f5634d9f8f','男神','黃負心','0955078978','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/qdzdioek2ohtvnzgz0tb','黃太','0977888999','','1','2021-03-25 14:00:00',0,0,1),('MB0000004','2021-04-03 02:01:00',1,'Barbossa2003@icloud.com','82909fa5e0e8dc34b51170099502cb41a2b6b114c96e1d9e11cc817a4611dec1',NULL,'','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/cp9rnqyye0vrblv9w66b','','','','1','2021-04-03 02:01:54',0,0,1),('MB0000005','2021-04-03 02:01:00',1,'Maki-love-U@gmail.com','7028460167b2793fc29195e4c49f71d0938927ac7eced186859cbce7268c7c99',NULL,'Maki','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/ckcs11fobimnvfi56rtm','','','','1','2021-04-03 02:04:20',0,0,1),('MB0000006','2021-04-03 02:04:00',1,'ZhugeLiang@qq.com','8d9420f170c44bf07cf9872a2c192daa57f51d4d521532b95906472d962122bf',NULL,'諸葛村夫','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/l3zdmeiszuzaf4afoabn','嘟嘟','','','1','2021-04-03 02:05:26',0,0,1),('MB0000007','2021-04-03 02:11:00',1,'LeehomWang@icloud.com','92d5d8837a4b10ffa258906d5021589fb6ac8ff3408c772ebed94d51365f6a74',NULL,'','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/g1tntlofuwf8lkm8hwwo','','','','1','2021-04-03 02:12:40',0,0,1),('MB0000008','2021-04-03 02:13:00',1,'Namewee@gmail.com','23358baae1e93bc473f2b59aca3ebab85230ce49cf6d3aa6447122d56d988504',NULL,'','','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Members-Avatar/uexvk1gtoc4w6nbarnuk','','','','1','2021-04-03 02:18:38',0,0,1);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `ORDER_DETAIL_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_STATUS` int NOT NULL,
  `ORDER_DETAIL_AMOUNT` int NOT NULL,
  `ORDER_DETAIL_MC_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_MC_PHONE` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_MC_EMAIL` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_EC_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_EC_PHONE` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_EC_EMAIL` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_DETAIL_FOR_TESTING` int NOT NULL,
  `ORDER_DETAIL_VISIBLE_ON_WEB` int NOT NULL,
  `ORDER_DETAIL_CERTIFICATE` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `FK_ORDER_ID_for_ODD` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `order_details` VALUES ('ODD0000000001',-1,11,'紀老爺','09','dasdad@ccc.com','巴奇','0922987654','Bucky@shiba.com',1,0,'0','OD0000001'),('ODD0000000002',-1,13,'紀老爺','09','dasdad@ccc.com','巴奇','0922987654','Bucky@shiba.com',1,1,'26ec4d01c76dbb63b9b2767139725119','OD0000001'),('ODD0000000003',-1,33,'紀老爺','09','dasdad@ccc.com','巴奇','0922987654','Bucky@shiba.com',1,1,'0','OD0000001'),('ODD0000000004',-1,3000,'紀老爺','09','dasdad@ccc.com','巴奇','0922987654','Bucky@shiba.com',1,0,'0','OD0000002'),('ODD0000000005',1,3000,'紀老爺','09','dasdad@ccc.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000002'),('ODD0000000006',1,33000,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000003'),('ODD0000000007',1,10000,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000004'),('ODD0000000008',1,20860,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000005'),('ODD0000000009',1,14900,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000006'),('ODD0000000010',1,17880,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000007'),('ODD0000000011',1,9995,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000008'),('ODD0000000012',1,9995,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000009'),('ODD0000000013',1,11994,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000010'),('ODD0000000014',1,11920,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'0','OD0000011'),('ODD0000000015',1,17880,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'b21903ac454c63bec724f2db2f6fd441','OD0000012'),('ODD0000000016',1,9995,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'4504696d08cc5900f3bbddc6772d3a0f','OD0000012'),('ODD0000000017',1,14900,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'6e6c2b123afad61d5dd4d32e9267a4d1','OD0000013'),('ODD0000000018',1,9995,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'bb6509154deb5016a475f6c2f29aad0a','OD0000014');
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `ORDER_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_STATUS` int NOT NULL,
  `ORDER_DATE` datetime NOT NULL,
  `ORDER_TOTAL_CONSUMPTION` int NOT NULL,
  `ORDER_TOTAL_DISCOUNT` int NOT NULL,
  `ORDER_MC_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_MC_PHONE` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_MC_EMAIL` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_EC_NAME` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_EC_PHONE` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_EC_EMAIL` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_FOR_TESTING` int NOT NULL,
  `ORDER_VISIBLE_ON_WEB` int NOT NULL,
  `FK_MEMBER_ID_for_OD` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `orders` VALUES ('OD0000001',-1,'2021-04-05 21:39:00',46,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',1,1,'MB0000001'),('OD0000002',1,'2021-04-01 00:30:00',6000,300,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000002'),('OD0000003',1,'2021-04-06 16:10:26',33000,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',1,0,'MB0000001'),('OD0000004',1,'2021-04-08 01:22:19',10000,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',1,0,'MB0000001'),('OD0000005',1,'2021-04-09 17:48:40',20860,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000006',1,'2021-04-09 17:54:53',14900,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000007',1,'2021-04-09 17:55:58',17880,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000008',1,'2021-04-09 17:57:25',9995,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000009',1,'2021-04-09 17:59:49',9995,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000010',1,'2021-04-09 18:00:40',11994,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000011',1,'2021-04-09 18:10:38',11920,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000012',1,'2021-04-09 18:44:52',27875,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000013',1,'2021-04-09 18:55:00',14900,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001'),('OD0000014',1,'2021-04-09 18:57:13',9995,0,'紀老爺','0933123456','Dennis@gmail.com','巴奇','0922987654','Bucky@shiba.com',0,1,'MB0000001');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `PROJECT_ID` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PROJECT_STATUS` int NOT NULL,
  `PROJECT_NAME` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PROJECT_AVATAR_URL` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_CAROUSEL_URL` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_ORIGINAL_PRICE_PER_PERSON` int NOT NULL,
  `PROJECT_MIN_NUM_OF_PEOPLE` int NOT NULL,
  `PROJECT_MAX_NUM_OF_PEOPLE` int NOT NULL,
  `PROJECT_SUMMARY` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_DESCRIPITION` varchar(20000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PROJECT_VISIBLE_ON_WEB` int NOT NULL,
  `PROJECT_FOR_TESTING` int NOT NULL,
  `FK_CATEGORY_ID_for_PJ` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FK_LOCATION_ID_for_PJ` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `projects` VALUES ('PJ0000001',1,'澎湖｜帆船出海・夕陽晚餐體驗','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/rrueeurmhdyjn1eerhh7','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/avesdy8rqdcynwbym2od\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/fvocltpdhdqr5yvgip70\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/aj916vd3hmtb3cscnii2\"]',2980,4,8,'<ul><li>搭乘8人帆船出海體驗，享受澎湖的海風與自由</li><li>學習簡單的帆船掌舵與拉帆技巧</li><li>在海上體驗立式划槳和跳水樂趣</li><li>在返回港口的途中，享用美味點心及飲品</li><li>無經驗者也可以安心出海體驗</li></ul>','<p>在全台灣最美的海域享受乘風破浪的快感！充當一日船長，搭乘來自法國貴族血統Lagoon 380的雙體帆船出海，學習簡單的帆船掌舵與拉帆技巧，還可享受浮潛、划獨木舟與跳水體驗。船上提供浴巾，還有精緻的小點與飲品讓你享用，讓你充分領略海上航行的魅力與樂趣。全程教練陪伴在側，循序漸進安全有保障，透過帆的升降控制航行速度，從基礎開始到出航，沒經驗者也能輕鬆上手駕馭。</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617358846/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/gqphnazlxy0uurbdhjqm.png\"></p><p>▲ 搭乘帆船出海，體驗駕駛以及水上活動樂趣</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617358860/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/uqe3troglmbovtvtzpxg.png\"></p><p>▲ 享受航行、浮潛等活動，暢享澎湖清澈湛藍的海水魅力</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617358871/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/w0ua3gki8f8m5x1dkqbh.png\"></p><p>▲ 在船上享用美味點心，出海玩也不怕餓肚子</p>',1,0,'CG0006','LC0003'),('PJ0000002',1,'宜蘭｜龜山島牛奶海SUP體驗','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/wdomumqbikzqecmuynip','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/jw1cfbs6gbxeihhs0fm2\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/sq8mm4xyrtvhah8iallh\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/zzh1w0u6zp1spxgd06cu\"]',2200,15,25,'<ul><li>搭乘遊艇或帆船前往號稱人間仙境的牛奶海，15人輕鬆成團！</li><li>海上提供大型泳池及造型泳圈，網美最愛，好玩又好拍！</li><li>在美麗海域體驗有趣的SUP立式划槳，裝備齊全，安全有保障</li><li>專業解說人員導覽，深度探索海洋與龜山島地理環境生態之美</li></ul>','<p>宜蘭位處台灣東海岸、是黑潮及本島河流匯出的交界點，帶來的多種季節洄游魚類，成為鯨魚及海豚的囊中美食，讓宜蘭成為最佳賞鯨地。本行程將帶你到美麗的宜蘭海岸，挑戰近年超夯又有趣的SUP體驗，還能近身觀賞台灣唯一活火山、形狀像烏龜一樣的「龜山島」匍伏於海面上的美景！幸運的話，說不定可以拍到夢寐以求的牛奶海網美照！</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617359261/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/r4g9b8st8mqxqdirnlix.png\"></p><p>▲ 乳藍色的龜山島牛奶湖是宜蘭的秘境景點，彷彿海上被水彩渲染般美麗</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617359284/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/eymbpvbwkbdkpgch6dng.png\"></p><p>▲ 行程提供專業介紹，帶你了解台灣豐富的海洋資源</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617359298/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/rljkqcuryrxpdw3hiffs.png\"></p><p>▲ 今年大爆發的牛奶海，想拍令人羨慕的無敵網美照？心動不如馬上預訂</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617359310/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/vjwjqel7jqpvje6yfrxc.png\"></p><p>▲ 夏天限定的絕美風光！揪上好友立即出發</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617359322/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/oj7kejlfjhdplncnkm5w.png\"></p><p>▲ 宛如被上帝推翻的牛奶罐，就在宜蘭龜山島</p>',1,0,'CG0002','LC0001'),('PJ0000003',0,'卡位','','[]',0,0,0,'','',1,0,'CG0001','LC0001'),('PJ0000004',1,'屏東│枋星遊艇小琉球之旅','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/s1gloltlpw2l9pbfkyps','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/pzvphlet9lxiftvo8gpf\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/czsfxvkcbhyvd060hiuw\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/mb5azhzjws5fepupkz5i\"]',1999,3,12,'<ul><li>搭上私人豪華遊艇，展開小琉球遊艇之旅</li><li>豪華遊艇設有3個室內船艙和一個飛橋甲板，一次性可搭載12位賓客</li><li>遊艇配置齊全，是您舉辦求婚、派對、甚至是舉辦婚禮的完美之地</li><li>遊艇試駕及多種迷人的水上活動可選</li></ul>','<p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360233/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/fk1tijmewfyc2mh78ulu.png\"></p><p>▲ 從枋寮坐豪華遊艇到小琉球，來趟特別的水上活動之旅</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360246/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/nbw3m0pssjuorfdr982l.png\"></p><p>▲ 獨木舟、SUP立式滑板、浮潛、跳水，旅途中體驗各式各樣的水上活動</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360262/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/y3pn7wjhufyhmgdg4edp.png\"></p><p>▲ 配上藍天大海，怎麼拍都美</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360379/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/h7hhd8watx1dfnmspgox.png\"></p><p>▲ 在遊艇上，度過慵懶又放鬆的下午</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360272/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/itgphywedhzr9nvhwyni.png\"></p><p>▲ 以最不一樣的方式感受南台灣的美！</p>',1,0,'CG0005','LC0004'),('PJ0000005',1,'高雄｜棧貳庫 - 紅毛港文化園區一日遊','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/wizjfpxe8etibktrmzwv','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/hacyfkyzvvsbrtieuxpm\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/dcijylq8trrop4bvxsed\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/lzjobovxbihkfbqkqgbt\"]',499,6,24,'<ul><li>全程備有專業導覽服務，搭乘豪華遊艇享受高雄港壯闊海景</li><li>遊艇配有冷氣及加大的柔軟皮椅、視野寬廣觀景窗，是乘風波浪觀賞高雄港灣最佳享受</li><li>位於台灣最大港「高雄第二港口」，鄰近長榮海運、美國ÁPL海運等大型航運公司貨櫃碼頭，近距離見識國際巨型貨櫃船進出港的震撼</li><li>穿梭在擁有300多年歷史的紅毛港漁村，特色建築文物融合聲光音效、實境數位模擬等互動方式，帶你穿越時空，體驗在地海港生活</li><li>高字塔旋轉餐廳坐擁360度環窗視野，將高雄港灣之美盡收眼底</li><li>夜晚船班返回棧貳庫，沿途欣賞燈火通明浪漫的高雄港夜景，美不勝收</li></ul>','<p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360814/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/dv8mljr1afykzovffduw.png\"></p><p>▲ 388年歷史的紅毛港漁村，值得你一探究竟</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360817/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/wdrwe1p2blgw0wzn6g1m.png\"></p><p>▲ 船內設有空調，更有柔軟皮椅、視野寬廣觀景窗，讓你將大好風光一覽無遺</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617360820/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/b18cutiuzlyohdspl639.png\"></p><p>▲ 保留了傳統建築元素，結合聲光效果，紅毛港漁村讓你深入淺出認識南臺灣歷史</p>',1,0,'CG0004','LC0005'),('PJ0000006',1,'高雄｜棧貳庫 - 英領館大港巡航之旅','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/jsx4t8otlx4kijjytrhh','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/fcawygcu2xb4c4odzxla\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/l4azkzqhjj7k5ymt6jxo\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/wlrietqp6jovn1piclqf\"]',888,8,24,'<ul><li>40分鐘航程途經香蕉碼頭、漁人碼頭、遠眺壽山、打狗英國領事館及旗後燈塔等景點</li><li>觀賞亞洲新灣區內各重大建設，包括高雄展覽館、高雄軟體科技園區、新光碼頭及流行音樂中心，最後返回棧貳庫專屬碼頭</li><li>搭乘豪華遊艇享受高雄港壯闊海景（全程備有專業導覽服務，室內有冷氣及加大的柔軟皮椅、視野觀廣的觀景窗，乘風波浪觀賞高雄港灣最佳享受）</li><li>位於台灣最大港-高雄第二港口，鄰近陽明海運、長榮海運、美國ÁPL海運等大型航運公司貨櫃碼頭，近距離欣賞全台獨一無二國際級巨型貨櫃輪進出港的震撼</li></ul>','<p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617378110/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/ycrsz8ewfkdumlia5or7.png\"></p><p>▲ 在棧貳庫上下船，從捷運步行4分鐘即可抵達</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617378128/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/s5pkzdwxlr9ovluozmzm.png\"></p><p>▲ 在船上，您可近距離看到大船入港</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617378118/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/hceghsojf3dfsx2pwwz1.png\"></p><p>▲ 活動途經各個著名景點，包含高雄流行音樂中心</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617378135/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/xz4ytx1yscstedtabg76.png\"></p><p>▲ 船隻屬於室內，同時配有冷氣及新穎的設備</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617378284/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/clyukrl7bkz79d2lipgq.png\"></p><p>▲ 搭配附餐，在棧貳庫欣賞美麗的風景</p>',1,0,'CG0004','LC0005'),('PJ0000007',0,'卡位','','[]',0,0,0,'','',1,0,'CG0001','LC0001'),('PJ0000008',1,'屏東│墾丁帆船嘉年華','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/kyawfa82gwpaag0qwztb','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/cenbq0vvbqgydp1vnovx\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/fkdlfcfhiuf2ilnd9okr\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/u2eeldrlclparkvshqw8\"]',2000,2,6,'<ul><li>搭乘擁有法國貴族血統 Lagoon 380的雙體帆船出海，體驗輕奢華的海上漂浮之旅</li><li>下水到海中游泳浮潛，欣賞美麗海底世界，與海洋生物相見歡</li><li>船上提供舒適沙發、大床、飲品與水果，享受慵懶假期時光</li></ul>','<p>在墾丁與大海接觸的機會太多了，但有時想讓身心都放鬆一下，享受舒適慵懶的假期時光。搭乘帆船出海，沐浴在陽光中，漂浮在大海上。若想動動身子，就跳下海游泳浮潛，見見海洋生物。上船後躺在舒服的沙發或大床上休息，品嚐飲品或水果，彷彿身處在奢華的電影場景中。登上擁有法國貴族血統 Lagoon 380的雙體帆船，感受陽光、海洋與開闊景色的撫慰和平靜。</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617364215/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/jnf5zhpaxtwje54gdds4.png\"></p><p>▲ 搭乘雙體帆船，體驗輕奢華的海上漂浮之旅</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617364219/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/uvwfabuldwn2tfswwp7q.png\"></p><p>▲ 坐上遊船出海，可以是喧鬧的海上派對，也可以是舒適悠閒的時光</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617364229/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/cup2mgnd6hbeungttr8v.png\"></p><p>▲ 自由選擇下水游泳或浮潛，度過快樂海上時光</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617364233/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/fvcziy5kgdgrl2ccvxfj.png\"></p><p>▲ 探索繽紛海底世界，與海洋生物面對面</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617364236/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/izkyt5kfhjso1ujwwoqj.png\"></p><p>▲ 船上提供舒適沙發、大床、飲品與水果，享受慵懶假期時光</p>',1,0,'CG0005','LC0007'),('PJ0000009',0,'卡位','','[]',0,0,0,'','',1,0,'CG0001','LC0001'),('PJ0000010',1,'宜蘭｜龜山島登島・賞鯨・環繞龜山島體驗','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/rgworzbsgdzancegqlzj','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/o4ojk69uipp3gwtdjqvn\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/ehvrdctrs6audajkwopn\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/yz1bib17qny7p4yrueii\"]',1200,8,16,'<ul><li>乘坐遊艇，環繞龜山島，與飛魚及海豚於海上共舞</li><li>透過專業導覽解說，了解龜山島的歷史及鯨豚習性</li><li>熱門401高地攻頂體驗</li></ul>','<p>宜蘭位處台灣東海岸，是黑潮及本島河流匯出的交界點，帶來的多種季節洄游魚類，成為鯨魚及海豚的囊中美食，讓宜蘭成為最佳賞鯨地。本行程將帶你到美麗的宜蘭海岸，讓你在乘船之際近身觀賞飛躍的飛魚及海豚，留下難忘經歷，幸運的話，還有可能看到遠方嬉戲的鯨魚。行程更帶你欣賞台灣唯一活火山、形狀像烏龜一樣的「龜山島」匍伏於海面上的美景。乘船抵達龜山島後，就是你探索島上豐饒動植物生態的時刻，讓我們的專業導遊帶你深入了解台灣這座神秘小島的歷史。</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617380895/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/xotcey6iwfshj2f6w7mn.png\"></p><p>▲ 專業導遊帶你深入探索龜山島的地形與歷史</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617380890/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/zwsupqgjmugkgt7ebyka.png\"></p><p>▲ 從各種不同的角度觀賞龜山島八景</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381030/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/wgrndjfcim4v0sq8tisx.png\"></p><p>▲ 緊盯海面，捕捉鯨魚、海豚、飛魚躍出海面的時刻</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381041/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/pvbjotlijhiu9yk72mmp.png\"></p><p>▲ 大家齊聚船頭，享受龜山島的天然美景</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381021/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/ycamy4mrkepyznz7rpfk.png\"></p><p>▲ 爬上401高地，每日總量管制，搶先預訂！</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617380886/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/zjg2qo45w5ebfcoyerw8.png\"></p><p>▲ 登島行程一虧從前的軍事基地龜山島！</p>',1,0,'CG0002','LC0001'),('PJ0000011',0,'卡位','','[]',0,0,0,'','',1,0,'CG0001','LC0001'),('PJ0000012',1,'澎湖｜珊瑚礁天堂｜忘憂島浮潛＆水上活動一日遊','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/sruhxwjupthp8uvrezqs','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/xmpugsy9vhjka5onrnkz\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/o5ha3b9rz4skpx7a4cky\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/or2u2yaujbvch6wlu2hi\"]',3500,8,24,'<ul><li>在全台唯一的國家海洋公園（南方四島國家公園）海域浮潛，一覽國際級的七彩珊瑚礁群</li><li>搭乘特殊登島遊艇，探索有「海上侏儸紀」之稱的原始無人島及魚群潮池、海鳥生態</li><li>在海上休閒平台拍網美照，挑戰高空跳水、划水衝浪等刺激水上活動</li><li>行程附贈水下攝影服務、全套浮潛裝備、午餐及下午茶，吃喝玩樂一次搞定</li></ul>','<p>探索澎湖忘憂島豐富的海洋生態、魚類和七彩珊瑚礁，體驗在台灣唯一國家海洋公園區浮潛。這裡被喻為世界級浮潛點，欣賞澎湖最美的海底世界，發現藍色珊瑚，享用為你精心準備的海上午餐饗宴。午後時光可以在海上平台欣賞海景、遊玩刺激的快艇衝浪等水上活動，更不可錯過在無人島上拍攝專屬的風景沙龍照。平台上播放讓人放鬆心情的音樂，慵懶地躺在舒適觀景區飽覽大片海景，或是在寧靜的島嶼登高遠眺，藍天白雲、湛藍海洋、沙灘淺礁盡收眼底，四周美景如畫，賞心悅目，保證讓你難以忘懷！</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381351/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/kazkzjz2pubjuiqa8czn.png\"></p><p>▲ 探索澎湖海域最原始的珊瑚礁生態及無人島</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381370/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/ur3kyh244ywctcoslhf9.png\"></p><p>▲ 欣賞忘憂島豐富的野島生態、地質生態及潮間帶生態</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381373/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/zm9tyxtqhzsarjqyjwpb.png\"></p><p>▲ 享用美味可口午餐，為下午行程補充滿滿元氣</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381397/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/ocsdjk1brptgj2frtioe.png\"></p><p>▲ 藍天白雲、湛藍海洋、沙灘淺礁，美景如畫，賞心悅目</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381396/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/y9dzbx4jkoz8kjkvhifh.png\"></p><p>▲ 展開不受打擾的澎湖忘憂島之旅，享受悠閒度假時光</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381405/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/pdjux10klombmirjgbbs.png\"></p><p>▲ 遠離塵囂，放鬆的忘憂島一日遊！不用出國也能體驗南島的美</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381419/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/a20srlhutmedx67oebsc.png\"></p><p>▲ 在清澈的海洋中暢遊</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617381431/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/sh4dbt7gjm4yb9bg7mjz.png\"></p><p>▲ 南方四島國家公園是浮潛者愛好的珊瑚礁王國</p>',1,0,'CG0006','LC0003'),('PJ0000013',1,'新北│閩越號│沙崙釣魚體驗','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/yk7d5kpsd2rnfzvvsq4g','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/eynmtznmd3mnu1d43lxi\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/mwxqliezuujcwhew39sf\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/vlh4dhh3fzvfylauazyu\"]',999,4,12,'<ul><li>搭乘閩越號遊艇、沿沙崙海灘觀光，體驗垂釣樂趣</li><li>使用GPS和探測器輕鬆捕捉各種魚類，收穫滿滿</li><li>享用美味的南島自助午餐，犒賞你的味蕾</li></ul>','<p>假期一到，何不遠離城市繁華與喧囂，搭乘閩越號遊艇，靜靜曬著太陽，感受和煦海風吹拂，一邊欣賞沙崙碧海白沙的優美風光，一邊揮起魚竿等待魚兒上鉤。沒有經驗也不怕，知識淵博的導遊提供專業指導，準備好你的誘餌，使用GPS和釣魚探測器輕鬆捕捉各種魚類，活蹦亂跳的魚類嬉戲於透明海水上，讓你眼花繚亂，結束後別忘了和你的戰利品合照，發送給家人好友，一起分享豐收的喜悅。</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617382940/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/dsgafseohjxxxh9g4xob.png\"></p><p>▲ 登上閩越號，一邊欣賞華欣平靜碧藍的海灘，一邊開啟令人興奮的垂釣之旅</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617382944/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/iaky9kqgxwcexpbcvux4.png\"></p><p>▲ 雙腳穩站舺板，收緊臂力抓著魚桿迎接你的戰利品</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617382977/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/fl08djb2pzdf5zwgmjgi.png\"></p><p>▲ GPS和探測器助你輕鬆捕獲各種魚類</p><p><br></p><p><img src=\"https://res.cloudinary.com/hugo-chiang/image/upload/v1617382984/Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Content/igqogcwthsevfopwkdt1.png\"></p><p>▲ 船上享用美味的自助南島料理，補充能量</p>',1,0,'CG0001','LC0008'),('PJ0000014',0,'卡位','Side-Projects/Frontend-Side-Projects-0001-Kapitan/Mess-Upload/Projects-Avatar/yk7d5kpsd2rnfzvvsq4g','[\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/eynmtznmd3mnu1d43lxi\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/mwxqliezuujcwhew39sf\",\"Side-Projects\\/Frontend-Side-Projects-0001-Kapitan\\/Mess-Upload\\/Projects-Carousel\\/vlh4dhh3fzvfylauazyu\"]',0,0,0,'','',1,0,'CG0001','LC0001'),('PJ0000015',-1,'（測試項目）卡位','','[]',0,0,0,'','',1,1,'CG0001','LC0001');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secret_keys`
--

DROP TABLE IF EXISTS `secret_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secret_keys` (
  `SECRET_KEY_ID` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SECRET_KEY_USAGE` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SECRET_KEY_VALUE` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
INSERT INTO `secret_keys` VALUES ('KY0001','admin','1A9D9'),('KY0002','members','CEB6F'),('KY0003','order_details','8CVR0');
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

-- Dump completed on 2021-04-09 23:19:41
