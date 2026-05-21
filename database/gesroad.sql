-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gesroad
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
-- Table structure for table `agence`
--

DROP TABLE IF EXISTS `agence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(254) DEFAULT NULL,
  `description` varchar(254) DEFAULT NULL,
  `logo` varchar(254) DEFAULT NULL,
  `devise` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agence`
--

LOCK TABLES `agence` WRITE;
/*!40000 ALTER TABLE `agence` DISABLE KEYS */;
INSERT INTO `agence` VALUES (1,'TransCam','Agence de transport camerounais','transcam.png','FCFA'),(2,'Garanti Express','Transport rapide et fiable','garanti.png','FCFA');
/*!40000 ALTER TABLE `agence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agence_locale`
--

DROP TABLE IF EXISTS `agence_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agence_locale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agence_id` int(11) DEFAULT NULL,
  `addresse` varchar(254) DEFAULT NULL,
  `telephone` varchar(254) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_1` (`agence_id`),
  CONSTRAINT `FK_Association_1` FOREIGN KEY (`agence_id`) REFERENCES `agence` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agence_locale`
--

LOCK TABLES `agence_locale` WRITE;
/*!40000 ALTER TABLE `agence_locale` DISABLE KEYS */;
INSERT INTO `agence_locale` VALUES (1,1,'Rue de la gare, Douala','233001122',1,NULL),(2,1,'Avenue Kennedy, Yaounde','222334455',1,NULL),(3,1,'Rue principale, Bafoussam','233445566',1,NULL),(4,2,'Carrefour Mvog-Mbi, Yaounde','222556677',1,NULL),(5,2,'Bonaberi, Douala','233778899',1,NULL);
/*!40000 ALTER TABLE `agence_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billet`
--

DROP TABLE IF EXISTS `billet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(11) DEFAULT NULL,
  `numero` varchar(254) DEFAULT NULL,
  `datereservation` datetime DEFAULT NULL,
  `fichierpdf` varchar(254) DEFAULT NULL,
  `QRcode` varchar(254) DEFAULT NULL,
  `siege_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_10` (`reservation_id`),
  KEY `siege_id` (`siege_id`),
  CONSTRAINT `FK_Association_10` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`),
  CONSTRAINT `billet_ibfk_1` FOREIGN KEY (`siege_id`) REFERENCES `siege` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billet`
--

LOCK TABLES `billet` WRITE;
/*!40000 ALTER TABLE `billet` DISABLE KEYS */;
INSERT INTO `billet` VALUES (1,12,'BILL-69F9E1F06FFE8','2026-05-05 13:26:24','billets/BILL-69F9E1F06FFE8.pdf','{\"numero\":\"BILL-69F9E1F06FFE8\",\"client\":\"kouam franck\",\"trajet\":\"Douala \\u2192 Bafoussam\",\"depart\":\"2026-05-05 19:30:00\",\"sieges\":\"36,37\",\"montant\":16000}',NULL),(2,12,'BILL-20260505-69F9E331CEFD1','2026-05-05 13:31:45','billets/BILL-20260505-69F9E331CEFD1.pdf','{\"numero\":\"BILL-20260505-69F9E331CEFD1\",\"passager\":\"ccc\",\"siege\":36,\"trajet\":\"Douala \\u2192 Bafoussam\",\"depart\":\"2026-05-05 19:30:00\",\"montant\":8000}',134),(3,12,'BILL-20260505-69F9E331E5B9A','2026-05-05 13:31:45','billets/BILL-20260505-69F9E331E5B9A.pdf','{\"numero\":\"BILL-20260505-69F9E331E5B9A\",\"passager\":\"kouam franck\",\"siege\":37,\"trajet\":\"Douala \\u2192 Bafoussam\",\"depart\":\"2026-05-05 19:30:00\",\"montant\":8000}',135),(4,18,'BILL-20260506-69FB0C235B2F6','2026-05-06 10:38:43','billets/BILL-20260506-69FB0C235B2F6.pdf','{\"numero\":\"BILL-20260506-69FB0C235B2F6\",\"passager\":\"toto toto\",\"siege\":36,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-07 10:00:00\",\"montant\":5000}',271),(5,19,'BILL-20260506-69FB0D4301005','2026-05-06 10:43:31','billets/BILL-20260506-69FB0D4301005.pdf','{\"numero\":\"BILL-20260506-69FB0D4301005\",\"passager\":\"kouam franck\",\"siege\":10,\"trajet\":\"Yaounde \\u2192 Douala\",\"depart\":\"2026-05-11 06:00:00\",\"montant\":7000}',65),(6,21,'BILL-20260506-69FB18F3A2B94','2026-05-06 11:33:23','billets/BILL-20260506-69FB18F3A2B94.pdf','{\"numero\":\"BILL-20260506-69FB18F3A2B94\",\"passager\":\"kouam franck\",\"siege\":2,\"trajet\":\"Yaounde \\u2192 Douala\",\"depart\":\"2026-05-11 06:00:00\",\"montant\":7000}',57),(7,22,'BILL-20260506-69FB21C1AA58A','2026-05-06 12:10:57','billets/BILL-20260506-69FB21C1AA58A.pdf','{\"numero\":\"BILL-20260506-69FB21C1AA58A\",\"passager\":\"kouam franck\",\"siege\":22,\"trajet\":\"Yaounde \\u2192 Bafoussam\",\"depart\":\"2026-05-11 09:00:00\",\"montant\":4000}',95),(8,23,'BILL-20260506-69FB3EC69E0E7','2026-05-06 14:14:46','billets/BILL-20260506-69FB3EC69E0E7.pdf','{\"numero\":\"BILL-20260506-69FB3EC69E0E7\",\"passager\":\"kouam franck\",\"siege\":22,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',388),(9,24,'BILL-20260506-69FB4173C4DB4','2026-05-06 14:26:11','billets/BILL-20260506-69FB4173C4DB4.pdf','{\"numero\":\"BILL-20260506-69FB4173C4DB4\",\"passager\":\"kouam franck\",\"siege\":27,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-07 10:00:00\",\"montant\":5000}',195),(10,26,'BILL-20260506-69FB44B178923','2026-05-06 14:40:01','billets/BILL-20260506-69FB44B178923.pdf','{\"numero\":\"BILL-20260506-69FB44B178923\",\"passager\":\"toto toto\",\"siege\":32,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-07 10:00:00\",\"montant\":5000}',267),(11,29,'BILL-20260507-69FC4D30C4F33','2026-05-07 09:28:32','billets/BILL-20260507-69FC4D30C4F33.pdf','{\"numero\":\"BILL-20260507-69FC4D30C4F33\",\"passager\":\"caissier System\",\"siege\":12,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',311),(12,30,'BILL-20260507-69FC4ECA7BF0F','2026-05-07 09:35:22','billets/BILL-20260507-69FC4ECA7BF0F.pdf','{\"numero\":\"BILL-20260507-69FC4ECA7BF0F\",\"passager\":\"caissier System\",\"siege\":11,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',310),(13,31,'BILL-20260507-69FC4F4F4F22C','2026-05-07 09:37:35','billets/BILL-20260507-69FC4F4F4F22C.pdf','{\"numero\":\"BILL-20260507-69FC4F4F4F22C\",\"passager\":\"caissier System\",\"siege\":32,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',331),(14,32,'BILL-20260507-69FC4FBD4D687','2026-05-07 09:39:25','billets/BILL-20260507-69FC4FBD4D687.pdf','{\"numero\":\"BILL-20260507-69FC4FBD4D687\",\"passager\":\"caissier System\",\"siege\":21,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 14:00:00\",\"montant\":8000}',51),(15,33,'BILL-20260507-69FC530006BD4','2026-05-07 09:53:20','billets/BILL-20260507-69FC530006BD4.pdf','{\"numero\":\"BILL-20260507-69FC530006BD4\",\"passager\":\"oeoeoe\",\"siege\":26,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',325),(16,34,'BILL-20260507-69FC55806BD19','2026-05-07 10:04:00','billets/BILL-20260507-69FC55806BD19.pdf','{\"numero\":\"BILL-20260507-69FC55806BD19\",\"passager\":\"ff\",\"siege\":7,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',373),(17,35,'BILL-20260507-69FC562BB7246','2026-05-07 10:06:51','billets/BILL-20260507-69FC562BB7246.pdf','{\"numero\":\"BILL-20260507-69FC562BB7246\",\"passager\":\"ddf\",\"siege\":31,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',397),(18,36,'BILL-20260507-69FC56BFD3516','2026-05-07 10:09:19','billets/BILL-20260507-69FC56BFD3516.pdf','{\"numero\":\"BILL-20260507-69FC56BFD3516\",\"passager\":\"ee\",\"siege\":27,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',326),(19,37,'BILL-20260507-69FC56DEC20A6','2026-05-07 10:09:50','billets/BILL-20260507-69FC56DEC20A6.pdf','{\"numero\":\"BILL-20260507-69FC56DEC20A6\",\"passager\":\"ee\",\"siege\":6,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',305),(20,41,'BILL-20260507-69FC79B186D0B','2026-05-07 12:38:25','billets/BILL-20260507-69FC79B186D0B.pdf','{\"numero\":\"BILL-20260507-69FC79B186D0B\",\"passager\":\"kouam franck\",\"siege\":12,\"trajet\":\"Douala \\u2192 Bafoussam\",\"depart\":\"2026-05-23 15:01:00\",\"montant\":5000}',554),(21,43,'BILL-20260507-69FC841F3D0C6','2026-05-07 13:22:55','billets/BILL-20260507-69FC841F3D0C6.pdf','{\"numero\":\"BILL-20260507-69FC841F3D0C6\",\"passager\":\"caissier System\",\"siege\":15,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',314),(22,44,'BILL-20260507-69FC8F26952C3','2026-05-07 14:09:58','billets/BILL-20260507-69FC8F26952C3.pdf','{\"numero\":\"BILL-20260507-69FC8F26952C3\",\"passager\":\"kouam franck\",\"siege\":12,\"trajet\":\"Yaounde \\u2192 Bafoussam\",\"depart\":\"2026-05-11 09:00:00\",\"montant\":4000}',85),(23,45,'BILL-20260507-69FC8F425DB31','2026-05-07 14:10:26','billets/BILL-20260507-69FC8F425DB31.pdf','{\"numero\":\"BILL-20260507-69FC8F425DB31\",\"passager\":\"caissier System\",\"siege\":7,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 14:00:00\",\"montant\":8000}',37),(24,47,'BILL-20260507-69FCF6D651F7C','2026-05-07 21:32:22','billets/BILL-20260507-69FCF6D651F7C.pdf','{\"numero\":\"BILL-20260507-69FCF6D651F7C\",\"passager\":\"dff\",\"siege\":1,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',367),(25,48,'BILL-20260508-69FDD512D5989','2026-05-08 13:20:34','billets/BILL-20260508-69FDD512D5989.pdf','{\"numero\":\"BILL-20260508-69FDD512D5989\",\"passager\":\"kouam franck\",\"siege\":6,\"trajet\":\"Yaounde \\u2192 Douala\",\"depart\":\"2026-05-11 06:00:00\",\"montant\":7000}',61),(26,52,'BILL-20260508-69FE574ED1BCE','2026-05-08 22:36:14','billets/BILL-20260508-69FE574ED1BCE.pdf','{\"numero\":\"BILL-20260508-69FE574ED1BCE\",\"passager\":\" \",\"siege\":4,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-10 13:43:00\",\"montant\":5000}',303),(27,53,'BILL-20260509-69FE65E9B49A0','2026-05-08 23:38:33','billets/BILL-20260509-69FE65E9B49A0.pdf','{\"numero\":\"BILL-20260509-69FE65E9B49A0\",\"passager\":\"kouam francko\",\"siege\":15,\"trajet\":\"Yaounde \\u2192 Douala\",\"depart\":\"2026-05-11 06:00:00\",\"montant\":7000}',70),(28,54,'BILL-20260509-69FF5B266FD31','2026-05-09 17:04:54','billets/BILL-20260509-69FF5B266FD31.pdf','{\"numero\":\"BILL-20260509-69FF5B266FD31\",\"passager\":\"kouam francko\",\"siege\":6,\"trajet\":\"Douala \\u2192 Bafoussam\",\"depart\":\"2026-05-23 15:01:00\",\"montant\":5000}',548),(29,54,'BILL-20260509-69FF5B2677236','2026-05-09 17:04:54','billets/BILL-20260509-69FF5B2677236.pdf','{\"numero\":\"BILL-20260509-69FF5B2677236\",\"passager\":\"kk,\",\"siege\":11,\"trajet\":\"Douala \\u2192 Bafoussam\",\"depart\":\"2026-05-23 15:01:00\",\"montant\":5000}',553),(34,62,'BILL-20260520-6A0DCB1D6EE45','2026-05-20 15:54:21','billets/BILL-20260520-6A0DCB1D6EE45.pdf','{\"numero\":\"BILL-20260520-6A0DCB1D6EE45\",\"passager\":\"kouam franck\",\"siege\":7,\"trajet\":\"Douala \\u2192 Yaounde\",\"depart\":\"2026-05-21 10:11:00\",\"montant\":5100}',639);
/*!40000 ALTER TABLE `billet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bus`
--

DROP TABLE IF EXISTS `bus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typebus_id` int(11) DEFAULT NULL,
  `immatriculation` varchar(254) DEFAULT NULL,
  `nbre_place` int(11) DEFAULT NULL,
  `estdisponible` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `FK_Association_5` (`typebus_id`),
  CONSTRAINT `FK_Association_5` FOREIGN KEY (`typebus_id`) REFERENCES `typebus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bus`
--

LOCK TABLES `bus` WRITE;
/*!40000 ALTER TABLE `bus` DISABLE KEYS */;
INSERT INTO `bus` VALUES (1,1,'LT-1234-A',18,0),(2,2,'LT-5678-B',30,1),(3,3,'LT-9012-C',25,0),(4,2,'LT-90114-C',70,0),(5,1,'LT-1465',70,0),(6,1,'LT-145',70,0),(7,3,'CE -84488',70,0);
/*!40000 ALTER TABLE `bus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chauffeur`
--

DROP TABLE IF EXISTS `chauffeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chauffeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(254) DEFAULT NULL,
  `prenom` varchar(254) DEFAULT NULL,
  `telephone` varchar(254) DEFAULT NULL,
  `num_permi` varchar(254) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chauffeur`
--

LOCK TABLES `chauffeur` WRITE;
/*!40000 ALTER TABLE `chauffeur` DISABLE KEYS */;
INSERT INTO `chauffeur` VALUES (1,'Mbarga','Jean','699001122','PERM-001',1),(2,'Ateba','Paul','677334455','PERM-002',1),(3,'Essono','Marc','655667788','PERM-003',1);
/*!40000 ALTER TABLE `chauffeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(11) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `methode` varchar(254) DEFAULT NULL,
  `statut` int(11) DEFAULT 0,
  `referencetransaction` varchar(254) DEFAULT NULL,
  `datepaiement` datetime DEFAULT NULL,
  `caissier_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_9` (`reservation_id`),
  KEY `caissier_id` (`caissier_id`),
  CONSTRAINT `FK_Association_9` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`),
  CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`caissier_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paiement`
--

LOCK TABLES `paiement` WRITE;
/*!40000 ALTER TABLE `paiement` DISABLE KEYS */;
INSERT INTO `paiement` VALUES (1,12,16000,'MTN_MOMO',1,'PAY-20260505-69F9E1F044E5B','2026-05-05 13:26:24',4),(2,12,16000,'_MOMO',1,'PAY-20260505-69F9E33194368','2026-05-05 13:31:45',NULL),(3,18,5000,'_MOMO',1,'PAY-20260506-69FB0C2336661','2026-05-06 10:38:43',NULL),(4,19,7000,'MTN_MOMO',1,'PAY-20260506-69FB0D4299D1B','2026-05-06 10:43:30',NULL),(5,21,7000,'_MOMO',1,'PAY-20260506-69FB18F2D7B72','2026-05-06 11:33:22',NULL),(6,22,4000,'_MOMO',1,'PAY-20260506-69FB21C16DF5B','2026-05-06 12:10:57',NULL),(7,23,5000,'_MOMO',1,'PAY-20260506-69FB3EC644384','2026-05-06 14:14:46',NULL),(8,24,5000,'_MOMO',1,'PAY-20260506-69FB41737AFDB','2026-05-06 14:26:11',NULL),(9,26,5000,'_MOMO',1,'PAY-20260506-69FB44B10CA89','2026-05-06 14:40:01',NULL),(10,29,5000,'_MOMO',1,'PAY-20260507-69FC4D3083382','2026-05-07 09:28:32',NULL),(11,30,5000,'_MOMO',1,'PAY-20260507-69FC4ECA6162E','2026-05-07 09:35:22',NULL),(12,31,5000,'_MOMO',1,'PAY-20260507-69FC4F4EF36B2','2026-05-07 09:37:34',NULL),(13,32,8000,'_MOMO',1,'PAY-20260507-69FC4FBD41F81','2026-05-07 09:39:25',NULL),(14,33,5000,'_MOMO',1,'PAY-20260507-69FC52FFD1A14','2026-05-07 09:53:19',NULL),(15,34,5000,'555_MOMO',1,'PAY-20260507-69FC55802DAF8','2026-05-07 10:04:00',NULL),(16,35,5000,'44_MOMO',1,'PAY-20260507-69FC562B943F4','2026-05-07 10:06:51',NULL),(17,36,5000,'55_MOMO',1,'PAY-20260507-69FC567350B8D','2026-05-07 10:08:03',NULL),(18,36,5000,'55_MOMO',1,'PAY-20260507-69FC56BF9E37B','2026-05-07 10:09:19',NULL),(19,36,5000,'55_MOMO',1,'PAY-20260507-69FC56C3B600B','2026-05-07 10:09:23',NULL),(20,37,5000,'55_MOMO',1,'PAY-20260507-69FC56DEA8529','2026-05-07 10:09:50',NULL),(21,37,5000,'MTN_MOMO',1,'PAY-20260507-69FC5C2F5445E','2026-05-07 10:32:31',4),(22,41,5000,'_MOMO',1,'PAY-20260507-69FC79B103A02','2026-05-07 12:38:25',2),(23,43,5000,'_MOMO',1,'PAY-20260507-69FC841F09753','2026-05-07 13:22:55',4),(24,44,4000,'_MOMO',1,'PAY-20260507-69FC8F26565A2','2026-05-07 14:09:58',2),(25,45,8000,'_MOMO',1,'PAY-20260507-69FC8F422A00B','2026-05-07 14:10:26',4),(26,47,5000,'_MOMO',1,'PAY-20260507-69FCF6D5D5047','2026-05-07 21:32:21',4),(27,48,7000,'_MOMO',1,'PAY-20260508-69FDD5129A494','2026-05-08 13:20:34',2),(28,52,5000,'especes',1,'PAY-20260508-69FE574EA0EC9','2026-05-08 22:36:14',4),(29,53,7000,'_MOMO',1,'PAY-20260509-69FE65E980D3D','2026-05-08 23:38:33',2),(30,54,10000,'_MOMO',1,'PAY-20260509-69FF5B262364F','2026-05-09 17:04:54',2),(31,56,5000,'MTN_MOMO',2,'PAY-20260510-6A0006EA8C7F9','2026-05-10 05:17:46',8),(32,57,5000,'_MOMO',2,'PAY-20260518-6A0AE01E89CF5','2026-05-18 10:47:10',8),(33,58,5000,'_MOMO',2,'PAY-20260519-6A0C2840557FF','2026-05-19 10:07:12',8),(34,59,5100,'_MOMO',2,'PAY-20260519-6A0C317755AB7','2026-05-19 10:46:31',8),(35,62,5100,'especes',1,'PAY-20260520-6A0DCB1D224E1','2026-05-20 15:54:21',4);
/*!40000 ALTER TABLE `paiement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remboursement`
--

DROP TABLE IF EXISTS `remboursement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remboursement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(11) NOT NULL,
  `paiement_id` int(11) NOT NULL,
  `montant_initial` float NOT NULL,
  `montant_rembourse` float NOT NULL,
  `methode` varchar(50) DEFAULT NULL,
  `statut` int(11) DEFAULT 0,
  `referencetransaction` varchar(100) DEFAULT NULL,
  `date_remboursement` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservation_id` (`reservation_id`),
  KEY `paiement_id` (`paiement_id`),
  CONSTRAINT `remboursement_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`),
  CONSTRAINT `remboursement_ibfk_2` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remboursement`
--

LOCK TABLES `remboursement` WRITE;
/*!40000 ALTER TABLE `remboursement` DISABLE KEYS */;
INSERT INTO `remboursement` VALUES (1,57,32,5000,3750,'_MOMO',1,'RMB-20260518-6A0AE0982437D','2026-05-18 10:49:12'),(2,58,33,5000,3750,'_MOMO',1,'RMB-20260519-6A0C2848BE466','2026-05-19 10:07:20'),(3,59,34,5100,3825,'_MOMO',1,'RMB-20260519-6A0CDA427EBD7','2026-05-19 22:46:42');
/*!40000 ALTER TABLE `remboursement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date_reservation` datetime DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `montant_total` float DEFAULT NULL,
  `voyage_id` int(11) DEFAULT NULL,
  `canal` enum('guichet','en ligne') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `voyage_id` (`voyage_id`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`voyage_id`) REFERENCES `voyage` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (1,2,'2026-05-04 20:31:09',2,16000,2,''),(2,2,'2026-05-04 21:04:01',1,8000,5,''),(3,2,'2026-05-04 21:44:54',1,8000,2,''),(4,2,'2026-05-04 21:54:52',1,8000,2,''),(5,2,'2026-05-04 21:55:16',1,8000,2,''),(6,2,'2026-05-04 21:56:20',2,8000,5,''),(7,2,'2026-05-05 12:53:54',1,8000,5,''),(8,2,'2026-05-05 13:01:59',1,16000,5,''),(9,2,'2026-05-05 13:02:55',1,8000,5,''),(10,2,'2026-05-05 13:18:48',1,16000,5,''),(11,2,'2026-05-05 13:25:16',1,8000,2,''),(12,2,'2026-05-05 13:26:15',1,16000,5,''),(13,2,'2026-05-05 13:58:41',2,7000,3,''),(14,2,'2026-05-05 13:59:31',1,7000,3,''),(15,2,'2026-05-05 14:12:23',1,7000,3,''),(16,2,'2026-05-05 14:15:48',1,7000,3,''),(17,2,'2026-05-05 14:28:22',2,7000,3,''),(18,6,'2026-05-06 10:38:36',1,5000,6,''),(19,2,'2026-05-06 10:43:26',2,7000,3,''),(20,2,'2026-05-06 10:44:17',2,7000,3,''),(21,2,'2026-05-06 11:33:18',2,7000,3,''),(22,2,'2026-05-06 12:10:53',1,4000,4,''),(23,2,'2026-05-06 14:14:42',1,5000,7,''),(24,2,'2026-05-06 14:26:08',1,5000,6,''),(25,6,'2026-05-06 14:39:43',1,5000,6,''),(26,6,'2026-05-06 14:39:56',1,5000,6,''),(27,3,'2026-05-06 15:09:13',1,4000,4,''),(28,4,'2026-05-06 23:13:48',1,5000,7,''),(29,4,'2026-05-07 09:28:27',1,5000,7,''),(30,4,'2026-05-07 09:35:18',1,5000,7,''),(31,4,'2026-05-07 09:37:30',2,5000,7,''),(32,4,'2026-05-07 09:39:21',1,8000,2,''),(33,4,'2026-05-07 09:53:12',1,5000,7,''),(34,4,'2026-05-07 10:03:49',1,5000,7,''),(35,4,'2026-05-07 10:06:14',1,5000,7,''),(36,4,'2026-05-07 10:07:56',1,5000,7,''),(37,4,'2026-05-07 10:09:44',1,5000,7,''),(38,2,'2026-05-07 11:59:28',2,5000,11,''),(39,2,'2026-05-07 12:02:12',2,5000,11,''),(40,4,'2026-05-07 12:04:25',2,8000,2,''),(41,2,'2026-05-07 12:38:18',2,5000,11,''),(42,2,'2026-05-07 12:48:05',2,5000,11,''),(43,4,'2026-05-07 13:22:50',1,5000,7,''),(44,2,'2026-05-07 14:09:55',1,4000,4,''),(45,4,'2026-05-07 14:10:23',1,8000,2,''),(46,4,'2026-05-07 21:30:40',2,8000,2,''),(47,4,'2026-05-07 21:32:17',1,5000,7,''),(48,2,'2026-05-08 13:20:30',1,7000,3,''),(49,2,'2026-05-08 13:22:05',2,5000,11,''),(50,4,'2026-05-08 22:04:01',2,5000,7,''),(51,7,'2026-05-08 22:35:48',2,5000,7,'guichet'),(52,7,'2026-05-08 22:36:12',1,5000,7,'guichet'),(53,2,'2026-05-08 23:38:29',1,7000,3,''),(54,2,'2026-05-09 17:04:49',1,10000,11,''),(55,8,'2026-05-10 05:16:54',2,5000,11,''),(56,8,'2026-05-10 05:17:18',2,5000,11,''),(57,8,'2026-05-11 11:13:12',2,5000,11,''),(58,8,'2026-05-19 10:07:08',2,5000,11,''),(59,8,'2026-05-19 10:46:25',1,5100,13,''),(60,8,'2026-05-19 10:47:48',1,5100,13,''),(61,8,'2026-05-19 10:53:31',1,5100,13,''),(62,13,'2026-05-20 15:53:58',1,5100,13,'guichet');
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_siege`
--

DROP TABLE IF EXISTS `reservation_siege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_siege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siege_id` int(11) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `nom` varchar(254) DEFAULT NULL,
  `telephone` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_12` (`siege_id`),
  KEY `FK_Association_13` (`reservation_id`),
  CONSTRAINT `FK_Association_12` FOREIGN KEY (`siege_id`) REFERENCES `siege` (`id`),
  CONSTRAINT `FK_Association_13` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_siege`
--

LOCK TABLES `reservation_siege` WRITE;
/*!40000 ALTER TABLE `reservation_siege` DISABLE KEYS */;
INSERT INTO `reservation_siege` VALUES (1,49,1,NULL,NULL),(2,43,1,NULL,NULL),(3,119,2,NULL,NULL),(4,41,3,NULL,NULL),(5,42,4,NULL,NULL),(6,52,5,NULL,NULL),(7,100,6,NULL,NULL),(8,124,7,'kouam franck',''),(9,125,8,'kouam franck',''),(10,130,8,'',''),(11,109,9,'kouam franck',''),(12,159,10,'kouam franck',''),(13,160,10,'ff','655554'),(14,45,11,'kouam franck',''),(15,135,12,'kouam franck',''),(16,134,12,'ccc','655'),(17,61,13,'kouam franck',''),(18,66,14,'kouam franck',''),(19,67,15,'kouam franck',''),(20,62,16,'kouam franck',''),(21,70,17,'kouam franck',''),(22,271,18,'toto toto',''),(23,65,19,'kouam franck',''),(24,69,20,'kouam franck',''),(25,57,21,'kouam franck',''),(26,95,22,'kouam franck',''),(27,388,23,'kouam franck',''),(28,195,24,'kouam franck',''),(29,190,25,'toto toto',''),(30,267,26,'toto toto',''),(31,94,27,'Admin System',''),(32,387,28,'caissier System',''),(33,311,29,'caissier System',''),(34,310,30,'caissier System',''),(35,331,31,'caissier System',''),(36,51,32,'caissier System',''),(37,325,33,'oeoeoe','788'),(38,373,34,'ff','55'),(39,397,35,'ddf','55'),(40,326,36,'ee','44'),(41,305,37,'ee','88'),(42,549,38,'kouam franck',''),(43,554,39,'kouam franck',''),(44,50,40,'caissier System',''),(45,554,41,'kouam franck',''),(46,564,42,'kouam franck',''),(47,314,43,'caissier System',''),(48,85,44,'kouam franck',''),(49,37,45,'caissier System',''),(50,31,46,'caissier System',''),(51,367,47,'dff','6455'),(52,61,48,'kouam franck',''),(53,563,49,'kouam franck',''),(54,402,50,'caissier System',''),(55,403,51,'ff fffe',''),(56,303,52,' ',''),(57,70,53,'kouam francko',''),(58,548,54,'kouam francko',''),(59,553,54,'kk,','55454'),(60,549,55,'leonel leonel',''),(61,554,56,'leonel leonel',''),(62,569,57,'leonel leonel',''),(63,552,58,'leonel leonel',''),(64,668,59,'leonel leonel',''),(65,643,60,'leonel leonel',''),(66,644,61,'leonel leonel',''),(67,639,62,'kouam franck','64477');
/*!40000 ALTER TABLE `reservation_siege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siege`
--

DROP TABLE IF EXISTS `siege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voyage_id` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_20` (`voyage_id`),
  CONSTRAINT `FK_Association_20` FOREIGN KEY (`voyage_id`) REFERENCES `voyage` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=728 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siege`
--

LOCK TABLES `siege` WRITE;
/*!40000 ALTER TABLE `siege` DISABLE KEYS */;
INSERT INTO `siege` VALUES (1,1,1,0),(2,1,2,0),(3,1,3,0),(4,1,4,0),(5,1,5,0),(6,1,6,0),(7,1,7,0),(8,1,8,0),(9,1,9,0),(10,1,10,0),(11,1,11,0),(12,1,12,0),(13,1,13,0),(14,1,14,0),(15,1,15,0),(16,1,16,0),(17,1,17,0),(18,1,18,0),(19,1,19,0),(20,1,20,0),(21,1,21,0),(22,1,22,0),(23,1,23,0),(24,1,24,0),(25,1,25,0),(26,1,26,0),(27,1,27,0),(28,1,28,0),(29,1,29,0),(30,1,30,0),(31,2,1,0),(32,2,2,0),(33,2,3,0),(34,2,4,0),(35,2,5,0),(36,2,6,0),(37,2,7,1),(38,2,8,0),(39,2,9,0),(40,2,10,0),(41,2,11,1),(42,2,12,1),(43,2,13,0),(44,2,14,0),(45,2,15,1),(46,2,16,0),(47,2,17,0),(48,2,18,0),(49,2,19,0),(50,2,20,0),(51,2,21,1),(52,2,22,1),(53,2,23,0),(54,2,24,0),(55,2,25,0),(56,3,1,0),(57,3,2,0),(58,3,3,0),(59,3,4,0),(60,3,5,0),(61,3,6,1),(62,3,7,1),(63,3,8,0),(64,3,9,0),(65,3,10,0),(66,3,11,1),(67,3,12,1),(68,3,13,0),(69,3,14,0),(70,3,15,1),(71,3,16,0),(72,3,17,0),(73,3,18,0),(74,4,1,0),(75,4,2,0),(76,4,3,0),(77,4,4,0),(78,4,5,0),(79,4,6,0),(80,4,7,0),(81,4,8,0),(82,4,9,0),(83,4,10,0),(84,4,11,0),(85,4,12,1),(86,4,13,0),(87,4,14,0),(88,4,15,0),(89,4,16,0),(90,4,17,0),(91,4,18,0),(92,4,19,0),(93,4,20,0),(94,4,21,1),(95,4,22,1),(96,4,23,0),(97,4,24,0),(98,4,25,0),(99,5,1,0),(100,5,2,0),(101,5,3,0),(102,5,4,0),(103,5,5,0),(104,5,6,0),(105,5,7,0),(106,5,8,0),(107,5,9,0),(108,5,10,0),(109,5,11,1),(110,5,12,0),(111,5,13,0),(112,5,14,0),(113,5,15,0),(114,5,16,0),(115,5,17,0),(116,5,18,0),(117,5,19,0),(118,5,20,0),(119,5,21,1),(120,5,22,0),(121,5,23,0),(122,5,24,0),(123,5,25,0),(124,5,26,1),(125,5,27,1),(126,5,28,0),(127,5,29,0),(128,5,30,0),(129,5,31,0),(130,5,32,1),(131,5,33,0),(132,5,34,0),(133,5,35,0),(134,5,36,1),(135,5,37,1),(136,5,38,0),(137,5,39,0),(138,5,40,0),(139,5,41,0),(140,5,42,0),(141,5,43,0),(142,5,44,0),(143,5,45,0),(144,5,46,0),(145,5,47,0),(146,5,48,0),(147,5,49,0),(148,5,50,0),(149,5,51,0),(150,5,52,0),(151,5,53,0),(152,5,54,0),(153,5,55,0),(154,5,56,0),(155,5,57,0),(156,5,58,0),(157,5,59,0),(158,5,60,0),(159,5,61,1),(160,5,62,1),(161,5,63,0),(162,5,64,0),(163,5,65,0),(164,5,66,0),(165,5,67,0),(166,5,68,0),(167,5,69,0),(168,5,70,0),(169,6,1,0),(170,6,2,0),(171,6,3,0),(172,6,4,0),(173,6,5,0),(174,6,6,0),(175,6,7,0),(176,6,8,0),(177,6,9,0),(178,6,10,0),(179,6,11,0),(180,6,12,0),(181,6,13,0),(182,6,14,0),(183,6,15,0),(184,6,16,0),(185,6,17,0),(186,6,18,0),(187,6,19,0),(188,6,20,0),(189,6,21,0),(190,6,22,1),(191,6,23,0),(192,6,24,0),(193,6,25,0),(194,6,26,0),(195,6,27,1),(196,6,28,0),(197,6,29,0),(198,6,30,0),(199,6,31,0),(200,6,32,0),(201,6,33,0),(202,6,34,0),(203,6,35,0),(204,6,36,0),(205,6,37,0),(206,6,38,0),(207,6,39,0),(208,6,40,0),(209,6,41,0),(210,6,42,0),(211,6,43,0),(212,6,44,0),(213,6,45,0),(214,6,46,0),(215,6,47,0),(216,6,48,0),(217,6,49,0),(218,6,50,0),(219,6,51,0),(220,6,52,0),(221,6,53,0),(222,6,54,0),(223,6,55,0),(224,6,56,0),(225,6,57,0),(226,6,58,0),(227,6,59,0),(228,6,60,0),(229,6,61,0),(230,6,62,0),(231,6,63,0),(232,6,64,0),(233,6,65,0),(234,6,66,0),(235,6,67,0),(236,6,1,0),(237,6,2,0),(238,6,3,0),(239,6,4,0),(240,6,5,0),(241,6,6,0),(242,6,7,0),(243,6,8,0),(244,6,9,0),(245,6,10,0),(246,6,11,0),(247,6,12,0),(248,6,13,0),(249,6,14,0),(250,6,15,0),(251,6,16,0),(252,6,17,0),(253,6,18,0),(254,6,19,0),(255,6,20,0),(256,6,21,0),(257,6,22,0),(258,6,23,0),(259,6,24,0),(260,6,25,0),(261,6,26,0),(262,6,27,0),(263,6,28,0),(264,6,29,0),(265,6,30,0),(266,6,31,0),(267,6,32,1),(268,6,33,0),(269,6,34,0),(270,6,35,0),(271,6,36,1),(272,6,37,0),(273,6,38,0),(274,6,39,0),(275,6,40,0),(276,6,41,0),(277,6,42,0),(278,6,43,0),(279,6,44,0),(280,6,45,0),(281,6,46,0),(282,6,47,0),(283,6,48,0),(284,6,49,0),(285,6,50,0),(286,6,51,0),(287,6,52,0),(288,6,53,0),(289,6,54,0),(290,6,55,0),(291,6,56,0),(292,6,57,0),(293,6,58,0),(294,6,59,0),(295,6,60,0),(296,6,61,0),(297,6,62,0),(298,6,63,0),(299,6,64,0),(300,7,1,0),(301,7,2,0),(302,7,3,0),(303,7,4,1),(304,7,5,0),(305,7,6,1),(306,7,7,0),(307,7,8,0),(308,7,9,0),(309,7,10,0),(310,7,11,1),(311,7,12,1),(312,7,13,0),(313,7,14,0),(314,7,15,1),(315,7,16,0),(316,7,17,0),(317,7,18,0),(318,7,19,0),(319,7,20,0),(320,7,21,0),(321,7,22,0),(322,7,23,0),(323,7,24,0),(324,7,25,0),(325,7,26,1),(326,7,27,1),(327,7,28,0),(328,7,29,0),(329,7,30,0),(330,7,31,0),(331,7,32,0),(332,7,33,0),(333,7,34,0),(334,7,35,0),(335,7,36,0),(336,7,37,0),(337,7,38,0),(338,7,39,0),(339,7,40,0),(340,7,41,0),(341,7,42,0),(342,7,43,0),(343,7,44,0),(344,7,45,0),(345,7,46,0),(346,7,47,0),(347,7,48,0),(348,7,49,0),(349,7,50,0),(350,7,51,0),(351,7,52,0),(352,7,53,0),(353,7,54,0),(354,7,55,0),(355,7,56,0),(356,7,57,0),(357,7,58,0),(358,7,59,0),(359,7,60,0),(360,7,61,0),(361,7,62,0),(362,7,63,0),(363,7,64,0),(364,7,65,0),(365,7,66,0),(366,7,67,0),(367,7,1,1),(368,7,2,0),(369,7,3,0),(370,7,4,0),(371,7,5,0),(372,7,6,0),(373,7,7,1),(374,7,8,0),(375,7,9,0),(376,7,10,0),(377,7,11,0),(378,7,12,0),(379,7,13,0),(380,7,14,0),(381,7,15,0),(382,7,16,0),(383,7,17,0),(384,7,18,0),(385,7,19,0),(386,7,20,0),(387,7,21,1),(388,7,22,1),(389,7,23,0),(390,7,24,0),(391,7,25,0),(392,7,26,0),(393,7,27,0),(394,7,28,0),(395,7,29,0),(396,7,30,0),(397,7,31,1),(398,7,32,0),(399,7,33,0),(400,7,34,0),(401,7,35,0),(402,7,36,0),(403,7,37,0),(404,7,38,0),(405,7,39,0),(406,7,40,0),(407,7,41,0),(408,7,42,0),(409,7,43,0),(410,7,44,0),(411,7,45,0),(412,7,46,0),(413,7,47,0),(414,7,48,0),(415,7,49,0),(416,7,50,0),(417,7,51,0),(418,7,52,0),(419,7,53,0),(420,7,54,0),(421,7,55,0),(422,7,56,0),(423,7,57,0),(424,7,58,0),(425,7,59,0),(426,7,60,0),(427,7,61,0),(428,7,62,0),(429,7,63,0),(430,7,64,0),(431,7,65,0),(432,7,66,0),(433,7,67,0),(434,8,1,0),(435,8,2,0),(436,8,3,0),(437,8,4,0),(438,8,5,0),(439,8,6,0),(440,8,7,0),(441,8,8,0),(442,8,9,0),(443,8,10,0),(444,8,11,0),(445,8,12,0),(446,8,13,0),(447,8,14,0),(448,8,15,0),(449,8,16,0),(450,8,17,0),(451,8,18,0),(452,8,19,0),(453,8,20,0),(454,8,21,0),(455,8,22,0),(456,8,23,0),(457,8,24,0),(458,8,25,0),(459,8,26,0),(460,8,27,0),(461,8,1,0),(462,8,2,0),(463,8,3,0),(464,8,4,0),(465,8,5,0),(466,8,6,0),(467,8,7,0),(468,8,8,0),(469,8,9,0),(470,8,10,0),(471,8,11,0),(472,8,12,0),(473,8,13,0),(474,8,14,0),(475,8,15,0),(476,8,16,0),(477,8,17,0),(478,8,18,0),(479,8,19,0),(480,8,20,0),(481,8,21,0),(482,8,22,0),(483,8,23,0),(484,8,24,0),(485,8,25,0),(486,8,26,0),(487,8,27,0),(488,8,28,0),(489,9,1,0),(490,9,2,0),(491,9,3,0),(492,9,4,0),(493,9,5,0),(494,9,6,0),(495,9,7,0),(496,9,8,0),(497,9,9,0),(498,9,10,0),(499,9,11,0),(500,9,12,0),(501,9,13,0),(502,9,14,0),(503,9,15,0),(504,9,1,0),(505,9,2,0),(506,9,3,0),(507,9,4,0),(508,9,5,0),(509,9,6,0),(510,9,7,0),(511,9,8,0),(512,9,9,0),(513,9,10,0),(514,9,11,0),(515,9,12,0),(516,9,13,0),(517,9,14,0),(518,9,15,0),(519,9,16,0),(520,10,1,0),(521,10,2,0),(522,10,3,0),(523,10,4,0),(524,10,5,0),(525,10,6,0),(526,10,7,0),(527,10,8,0),(528,10,9,0),(529,10,10,0),(530,10,11,0),(531,10,12,0),(532,10,13,0),(533,10,14,0),(534,10,15,0),(535,10,16,0),(536,10,17,0),(537,10,18,0),(538,10,19,0),(539,10,20,0),(540,10,21,0),(541,10,22,0),(542,10,23,0),(543,11,1,0),(544,11,2,0),(545,11,3,0),(546,11,4,0),(547,11,5,0),(548,11,6,1),(549,11,7,0),(550,11,8,0),(551,11,9,0),(552,11,10,0),(553,11,11,1),(554,11,12,0),(555,11,13,0),(556,11,14,0),(557,11,15,0),(558,11,16,0),(559,11,17,0),(560,11,18,0),(561,11,19,0),(562,11,20,0),(563,11,21,0),(564,11,22,0),(565,11,23,0),(566,11,24,0),(567,11,25,0),(568,11,26,0),(569,11,27,0),(570,11,28,0),(571,11,29,0),(572,11,30,0),(573,11,31,0),(574,11,32,0),(575,11,33,0),(576,11,34,0),(577,11,35,0),(578,11,36,0),(579,11,37,0),(580,11,38,0),(581,11,39,0),(582,11,40,0),(583,11,41,0),(584,11,42,0),(585,11,43,0),(586,11,44,0),(587,11,45,0),(588,11,46,0),(589,11,47,0),(590,11,48,0),(591,11,49,0),(592,11,50,0),(593,11,51,0),(594,11,52,0),(595,11,53,0),(596,11,54,0),(597,11,55,0),(598,11,56,0),(599,11,57,0),(600,11,58,0),(601,11,59,0),(602,11,60,0),(603,11,61,0),(604,11,62,0),(605,11,63,0),(606,11,64,0),(607,11,65,0),(608,11,66,0),(609,11,67,0),(610,12,1,0),(611,12,2,0),(612,12,3,0),(613,12,4,0),(614,12,5,0),(615,12,6,0),(616,12,7,0),(617,12,8,0),(618,12,9,0),(619,12,10,0),(620,12,11,0),(621,12,12,0),(622,12,13,0),(623,12,14,0),(624,12,15,0),(625,12,16,0),(626,12,17,0),(627,12,18,0),(628,12,19,0),(629,12,20,0),(630,12,21,0),(631,12,22,0),(632,12,23,0),(633,13,1,0),(634,13,2,0),(635,13,3,0),(636,13,4,0),(637,13,5,0),(638,13,6,0),(639,13,7,1),(640,13,8,0),(641,13,9,0),(642,13,10,0),(643,13,11,0),(644,13,12,0),(645,13,13,0),(646,13,14,0),(647,13,15,0),(648,13,16,0),(649,13,17,0),(650,13,18,0),(651,13,19,0),(652,13,20,0),(653,13,21,0),(654,13,22,0),(655,13,23,0),(656,13,24,0),(657,13,25,0),(658,13,26,0),(659,13,27,0),(660,13,28,0),(661,13,29,0),(662,13,30,0),(663,13,31,0),(664,13,32,0),(665,13,33,0),(666,13,34,0),(667,13,35,0),(668,13,36,0),(669,13,37,0),(670,13,38,0),(671,13,39,0),(672,13,40,0),(673,13,41,0),(674,13,42,0),(675,13,43,0),(676,13,44,0),(677,13,45,0),(678,13,46,0),(679,13,47,0),(680,13,48,0),(681,13,49,0),(682,13,50,0),(683,13,51,0),(684,13,52,0),(685,13,53,0),(686,13,54,0),(687,13,55,0),(688,13,56,0),(689,13,57,0),(690,13,58,0),(691,13,59,0),(692,13,60,0),(693,13,61,0),(694,13,62,0),(695,13,63,0),(696,13,64,0),(697,13,65,0),(698,13,66,0),(699,13,67,0),(700,14,1,0),(701,14,2,0),(702,14,3,0),(703,14,4,0),(704,14,5,0),(705,14,6,0),(706,14,7,0),(707,14,8,0),(708,14,9,0),(709,14,10,0),(710,14,11,0),(711,14,12,0),(712,14,13,0),(713,14,14,0),(714,14,15,0),(715,14,16,0),(716,14,17,0),(717,14,18,0),(718,14,19,0),(719,14,20,0),(720,14,21,0),(721,14,22,0),(722,14,23,0),(723,14,24,0),(724,14,25,0),(725,14,26,0),(726,14,27,0),(727,14,28,0);
/*!40000 ALTER TABLE `siege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trajet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villedepart` varchar(254) DEFAULT NULL,
  `villearrive` varchar(254) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `duree` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trajet`
--

LOCK TABLES `trajet` WRITE;
/*!40000 ALTER TABLE `trajet` DISABLE KEYS */;
INSERT INTO `trajet` VALUES (1,'Douala','Yaounde',250.5,'4h00'),(2,'Yaounde','Douala',250.5,'4h00'),(3,'Douala','Bafoussam',320,'5h30'),(4,'Yaounde','Bafoussam',180,'3h00');
/*!40000 ALTER TABLE `trajet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trajet_chauffeur`
--

DROP TABLE IF EXISTS `trajet_chauffeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trajet_chauffeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chauffeur_id` int(11) DEFAULT NULL,
  `trajet_id` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `FK_Association_3` (`trajet_id`),
  KEY `FK_Association_4` (`chauffeur_id`),
  CONSTRAINT `FK_Association_3` FOREIGN KEY (`trajet_id`) REFERENCES `trajet` (`id`),
  CONSTRAINT `FK_Association_4` FOREIGN KEY (`chauffeur_id`) REFERENCES `chauffeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trajet_chauffeur`
--

LOCK TABLES `trajet_chauffeur` WRITE;
/*!40000 ALTER TABLE `trajet_chauffeur` DISABLE KEYS */;
INSERT INTO `trajet_chauffeur` VALUES (1,1,1,1),(2,2,1,1),(3,1,2,1),(4,3,2,1),(5,2,3,1),(6,3,4,1);
/*!40000 ALTER TABLE `trajet_chauffeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typebus`
--

DROP TABLE IF EXISTS `typebus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typebus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typebus`
--

LOCK TABLES `typebus` WRITE;
/*!40000 ALTER TABLE `typebus` DISABLE KEYS */;
INSERT INTO `typebus` VALUES (1,'Minibus'),(2,'Bus Standard'),(3,'Bus VIP');
/*!40000 ALTER TABLE `typebus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typevoyage`
--

DROP TABLE IF EXISTS `typevoyage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typevoyage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(254) DEFAULT NULL,
  `description` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typevoyage`
--

LOCK TABLES `typevoyage` WRITE;
/*!40000 ALTER TABLE `typevoyage` DISABLE KEYS */;
INSERT INTO `typevoyage` VALUES (1,'Standard',1),(2,'VIP',2),(3,'Express',3);
/*!40000 ALTER TABLE `typevoyage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agencelocale_id` int(11) DEFAULT NULL,
  `nom` varchar(254) DEFAULT NULL,
  `prenom` varchar(254) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `role` enum('client','caissier','admin') DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `statut` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `AK_Identifiant_1` (`id`),
  KEY `FK_Association_19` (`agencelocale_id`),
  CONSTRAINT `FK_Association_19` FOREIGN KEY (`agencelocale_id`) REFERENCES `agence_locale` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,NULL,'kouam','francko','kouamfranc100@icloud.com','client','2026-05-01 23:34:45','14994799216e9ea7b1180010a42751205d1394bf',1),(3,NULL,'Admin','System','admin@gesroad.cm','admin','2026-05-03 05:31:56','f865b53623b121fd34ee5426c792e5c33af8c227',1),(4,NULL,'caissier','System','caissier@gesroad.cm','caissier','2026-05-04 09:46:07','634ff55183f4c35f397b00aef96d317362ba1079',1),(5,NULL,'Caissier','Douala','caissier@gesroad.cm','caissier','2026-05-04 10:15:03','634ff55183f4c35f397b00aef96d317362ba1079',1),(6,NULL,'toto','toto','franc@gmail','client','2026-05-06 10:37:56','14994799216e9ea7b1180010a42751205d1394bf',1),(7,NULL,'ff','fffe','','client','2026-05-08 22:35:48','21f8ba70b81637dffc343dc7578bdd2762085365',0),(8,NULL,'leonel','leonel','leonel@gmail.com','client','2026-05-10 05:12:09','33a11888bbcb40884b1f4402e6a514d039c63732',0),(11,2,'caissier','baf','caissierbaf@gesroad.cm','caissier','2026-05-19 14:43:56','634ff55183f4c35f397b00aef96d317362ba1079',0),(12,4,'caissier1','yde','caissieryde@gesroad.cm','caissier','2026-05-19 14:44:55','634ff55183f4c35f397b00aef96d317362ba1079',1),(13,NULL,'kouam','franck','kouamfranc100@gmail.com','client','2026-05-20 15:53:57','fcf1e025a7bfb5c6dd2a5c281ec17d5d667a1788',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voyage`
--

DROP TABLE IF EXISTS `voyage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voyage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agencelocaledeapart_id` int(11) NOT NULL,
  `trajetchauffeur_id` int(11) DEFAULT NULL,
  `agenceloacledarrive_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `dateheuredepart` datetime DEFAULT NULL,
  `dateheurearrive` datetime DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `placerestante` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_16` (`agenceloacledarrive_id`),
  KEY `FK_Association_17` (`trajetchauffeur_id`),
  KEY `FK_Association_18` (`agencelocaledeapart_id`),
  KEY `FK_Association_6` (`bus_id`),
  KEY `FK_Association_7` (`type_id`),
  CONSTRAINT `FK_Association_16` FOREIGN KEY (`agenceloacledarrive_id`) REFERENCES `agence_locale` (`id`),
  CONSTRAINT `FK_Association_17` FOREIGN KEY (`trajetchauffeur_id`) REFERENCES `trajet_chauffeur` (`id`),
  CONSTRAINT `FK_Association_18` FOREIGN KEY (`agencelocaledeapart_id`) REFERENCES `agence_locale` (`id`),
  CONSTRAINT `FK_Association_6` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`),
  CONSTRAINT `FK_Association_7` FOREIGN KEY (`type_id`) REFERENCES `typevoyage` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voyage`
--

LOCK TABLES `voyage` WRITE;
/*!40000 ALTER TABLE `voyage` DISABLE KEYS */;
INSERT INTO `voyage` VALUES (1,1,1,2,1,2,'2026-05-10 08:00:00','2026-05-10 12:00:00',5000,3,30),(2,2,2,1,2,3,'2026-05-10 14:00:00','2026-05-10 18:00:00',8000,0,21),(3,1,3,3,1,1,'2026-05-11 06:00:00','2026-05-11 11:30:00',7000,0,13),(4,2,6,3,2,3,'2026-05-11 09:00:00','2026-05-11 12:00:00',4000,0,22),(5,5,5,3,2,4,'2026-05-05 19:30:00','2026-05-06 05:00:00',8000,0,61),(6,5,2,3,2,5,'2026-05-07 10:00:00','2026-05-07 16:10:00',5000,0,127),(7,5,2,1,1,6,'2026-05-10 13:43:00','2026-05-23 14:44:00',5000,1,124),(8,5,2,2,1,2,'2026-05-10 10:48:00','2026-05-11 10:48:00',5100,3,55),(9,4,1,1,2,1,'2026-05-08 10:58:00','2026-05-08 14:58:00',5000,3,31),(10,1,1,2,1,3,'2026-05-08 13:55:00','2026-05-09 11:55:00',5000,3,23),(11,4,5,2,3,1,'2026-05-23 15:01:00','2026-05-07 11:58:00',5000,0,69),(12,1,2,2,3,3,'2026-05-20 10:09:00','2026-05-20 18:09:00',8000,0,23),(13,4,2,5,3,7,'2026-05-21 10:11:00','2026-05-22 10:11:00',5100,1,66),(14,4,1,5,2,2,'2026-05-21 09:06:00','2026-05-21 09:07:00',500,2,28);
/*!40000 ALTER TABLE `voyage` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-21 14:41:06
