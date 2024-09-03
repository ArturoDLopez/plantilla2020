-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: vehiculos_robados_bd
-- ------------------------------------------------------
-- Server version	5.7.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_color` varchar(30) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (1,'Morado','2024-08-20 06:00:00',0),(2,'azul','2024-12-12 06:00:00',0),(3,'rojo','2024-12-12 06:00:00',0),(4,'Amarillo','2024-08-23 06:00:00',0),(10,'azul2','2024-08-26 06:00:00',0),(11,'azul3','2024-08-26 06:00:00',0),(12,'Azul4','2024-08-29 03:41:01',1),(13,'azul5','2024-08-29 03:42:05',1),(14,'azul6','2024-08-29 06:08:13',1),(15,'azul7','2024-08-29 09:38:28',1),(16,'azul8','2024-08-29 09:46:22',1),(17,'azul90','2024-08-29 21:28:58',1),(18,'azul622','2024-08-29 21:32:38',1),(21,'azul4','0000-00-00 00:00:00',1),(22,'aaaaa','0000-00-00 00:00:00',1),(23,'aasas','0000-00-00 00:00:00',1),(24,'azul12','0000-00-00 00:00:00',1),(25,'azul13','0000-00-00 00:00:00',1),(26,'azul1211','2024-09-02 18:54:13',1),(27,'azul4','2024-09-02 19:23:22',0);
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duenos`
--

DROP TABLE IF EXISTS `duenos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `duenos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido_p` varchar(100) DEFAULT NULL,
  `apellido_m` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL,
  `curp` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duenos`
--

LOCK TABLES `duenos` WRITE;
/*!40000 ALTER TABLE `duenos` DISABLE KEYS */;
INSERT INTO `duenos` VALUES (1,'','quien','','2024-08-20 06:00:00',1,NULL),(2,'joaquina','Perez','Ayala','2015-11-15 06:00:00',0,NULL),(3,'Q','p','s','2024-08-20 06:00:00',0,NULL),(5,'Sonrisas','Bien','Bromas','2024-08-20 06:00:00',0,NULL),(6,'Arturo','Duran','Lopez','2022-10-10 06:00:00',0,NULL),(7,'Alejandro','Jazo','Jazo2','2024-08-27 23:40:42',1,NULL),(8,'Biometricos','a','Doble','2024-08-27 23:46:20',1,NULL),(9,'','','','2024-08-28 00:12:00',1,NULL),(10,'','','','2024-08-28 01:39:41',1,NULL),(11,'','','','2024-08-28 01:53:07',1,NULL),(12,'','','','2024-08-28 01:54:23',1,NULL),(13,'Arturo200','311','311111','2024-08-28 02:20:54',1,NULL),(14,'Arthur','00000000000','311111','2024-08-28 02:46:33',0,NULL),(15,'Biometricos','pueda','Doble','2024-08-28 03:12:09',0,NULL),(16,'Atension SRE 3','pueda','Doble','2024-08-29 01:35:42',1,NULL),(17,'Hidalgo','Montiel','Garcia','2024-08-29 01:54:49',1,NULL),(18,'Manantial','dela','valle','2024-08-30 11:32:26',1,NULL),(19,'dsa','sad','da','2024-08-30 11:34:52',1,NULL),(20,'Arturo','Duran','Lopez','2024-09-03 18:47:17',0,'DULA000202HGTRPRA7'),(21,'Arturo','Duran','Lopez','2024-09-03 18:49:41',0,'DULA000202HGTRPRA'),(22,'aas','asas','asas','2024-09-03 18:50:54',1,'DULA0'),(23,'as','as','as','2024-09-03 18:52:18',1,'DULA000202HGTRP'),(24,'a','a','a','2024-09-03 18:54:38',1,'DULA000202HGT'),(25,'aas','aaa','aaa','2024-09-03 18:55:43',1,'DULA000202HG'),(26,'aaa','aaa','aaa','2024-09-03 19:14:34',1,'DULA000202HGTRPRA11aaaaaaaaaa1');
/*!40000 ALTER TABLE `duenos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emplacado`
--

DROP TABLE IF EXISTS `emplacado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emplacado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehiculos_id` int(11) NOT NULL,
  `placas_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actual` tinyint(4) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_termino` varchar(100) DEFAULT NULL,
  `eliminado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emplacado_vehiculos_FK` (`vehiculos_id`),
  KEY `emplacado_placas_FK` (`placas_id`),
  CONSTRAINT `emplacado_placas_FK` FOREIGN KEY (`placas_id`) REFERENCES `placas` (`id`),
  CONSTRAINT `emplacado_vehiculos_FK` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emplacado`
--

LOCK TABLES `emplacado` WRITE;
/*!40000 ALTER TABLE `emplacado` DISABLE KEYS */;
INSERT INTO `emplacado` VALUES (3,1,5,'2024-08-21 06:00:00',1,'1906-05-30 00:00:00','3444-10-10','0'),(4,3,5,'2024-08-21 06:00:00',1,'2024-08-01 00:00:00','','1'),(5,7,4,'2023-09-09 06:00:00',1,'1900-10-10 00:00:00','9000-01-01','0'),(6,6,4,'2024-08-26 06:00:00',1,'2024-08-23 00:00:00','','0'),(7,19,4,'2024-08-28 17:32:50',0,'2024-08-23 00:00:00','2024-08-28','1'),(9,34,5,'2024-08-29 01:59:10',1,'2024-08-30 00:00:00','','0'),(10,20,4,'2024-08-30 11:18:24',1,'2024-08-02 00:00:00','','0'),(11,25,4,'2024-08-30 21:20:02',1,'2024-08-01 00:00:00','','0'),(12,5,4,'2024-08-30 21:56:19',0,'2024-08-02 00:00:00','2024-08-01','0'),(13,4,19,'2024-08-30 23:21:08',1,'2024-08-01 00:00:00','','0'),(14,7,13,'2024-08-30 23:25:40',0,'2024-08-02 00:00:00','2024-07-31','1'),(15,2,14,'2024-08-30 23:27:22',1,'2024-08-02 00:00:00','','1'),(16,19,4,'2024-08-30 23:53:49',1,'2024-08-01 00:00:00','','1'),(17,6,10,'2024-08-31 00:28:55',1,'2024-08-02 00:00:00','','0'),(18,1,9,'2024-08-31 00:32:27',1,'2024-08-03 00:00:00','','0'),(19,20,4,'2024-08-31 00:44:18',1,'2024-08-09 00:00:00','','0'),(20,4,9,'2024-08-31 00:44:32',0,'2024-08-09 00:00:00','','0'),(21,5,9,'2024-08-31 01:01:59',1,'2024-08-02 00:00:00','','1'),(22,2,4,'2024-08-31 01:05:12',1,'2024-08-02 00:00:00','','0'),(23,2,10,'2024-08-31 03:37:01',1,'2024-08-08 00:00:00','','1'),(24,4,13,'2024-09-03 20:14:52',0,'2024-09-19 00:00:00','2024-09-17',''),(25,1,5,'2024-09-03 20:16:31',1,'2024-09-05 00:00:00','',''),(26,1,5,'2024-09-03 20:19:20',1,'2024-09-21 00:00:00','',''),(27,1,5,'2024-09-03 20:21:01',0,'2024-09-13 00:00:00','',''),(28,4,5,'2024-09-03 20:27:59',1,'2024-09-06 00:00:00','',''),(29,1,19,'2024-09-03 20:28:16',0,'0000-00-00 00:00:00','',''),(30,19,12,'2024-09-03 20:29:01',0,'2024-09-06 00:00:00','',''),(31,1,10,'2024-09-03 21:25:34',1,'0000-00-00 00:00:00','',''),(32,1,12,'2024-09-03 21:26:12',0,'0000-00-00 00:00:00','',''),(33,1,12,'2024-09-03 21:29:18',0,'0000-00-00 00:00:00','',''),(34,1,10,'2024-09-03 21:39:06',0,'0000-00-00 00:00:00','',''),(35,3,21,'2024-09-03 21:41:39',0,'0000-00-00 00:00:00','',''),(36,56,13,'2024-09-03 21:53:37',0,'0000-00-00 00:00:00','','1');
/*!40000 ALTER TABLE `emplacado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_marca` varchar(30) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES (1,'Nissan','2022-03-14 06:00:00',1),(2,'ford','2021-12-25 06:00:00',0),(7,'Toyota','2024-08-20 06:00:00',0),(9,'Hyundai','2024-08-26 06:00:00',0),(18,'Nissan2','2024-08-26 06:00:00',0),(19,'Nissan3','2024-08-26 06:00:00',1),(20,'Nissan4','2024-08-26 06:00:00',1),(21,'Nissan5','2024-08-26 06:00:00',1),(22,'Nissan6','2024-08-26 06:00:00',1),(23,'Nissan7','2024-08-26 06:00:00',1),(24,'Nissan8','2024-08-26 06:00:00',1),(25,'Nissan9','2024-08-29 06:05:19',1),(26,'Nissan10','2024-08-29 06:06:22',1),(27,'Nissan11','2024-08-29 06:07:43',1),(28,'Nissan12','2024-08-29 09:46:10',1),(29,'Nissan13','2024-08-29 21:28:40',1),(30,'Tesla','2024-08-31 01:29:07',0),(31,'Nissan12asdsa','2024-09-01 22:33:28',0),(32,'Nissan11','2024-09-02 20:40:30',0),(33,'Nissan11','2024-09-02 20:41:10',0),(34,'Nissan11','2024-09-02 20:56:28',0),(35,'Nissan11','2024-09-02 20:58:52',0),(39,'GM','2024-09-02 20:06:12',0);
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placas`
--

DROP TABLE IF EXISTS `placas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `placas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placa` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `asignado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `placas_emplacado_FK` (`asignado`),
  CONSTRAINT `placas_emplacado_FK` FOREIGN KEY (`asignado`) REFERENCES `emplacado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placas`
--

LOCK TABLES `placas` WRITE;
/*!40000 ALTER TABLE `placas` DISABLE KEYS */;
INSERT INTO `placas` VALUES (1,'1234','2021-12-12 06:00:00',0,19),(2,'Placa2','2024-08-20 06:00:00',0,22),(4,'Placa3','2024-08-20 06:00:00',0,22),(5,'99999','2020-10-10 06:00:00',0,30),(6,'Placa4','2024-08-27 06:00:00',1,NULL),(7,'12345','2024-08-28 21:16:11',1,NULL),(8,'8888','2024-08-30 10:37:43',1,NULL),(9,'Mazatlan','2024-08-30 21:19:28',0,14),(10,'pl101','2024-08-30 23:24:51',0,35),(11,'pl102','2024-08-30 23:24:55',0,20),(12,'pl103','2024-08-30 23:24:59',0,34),(13,'pl104','2024-08-30 23:25:03',0,NULL),(14,'pl105','2024-08-30 23:25:07',0,NULL),(19,'Moroleon','2024-09-03 19:35:02',0,NULL),(20,'Moroleon2','2024-09-03 19:35:17',1,NULL),(21,'Moroleon2','2024-09-03 19:36:20',0,NULL);
/*!40000 ALTER TABLE `placas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propietario`
--

DROP TABLE IF EXISTS `propietario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propietario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehiculos_id` int(11) NOT NULL,
  `duenos_id` int(11) NOT NULL,
  `actual` tinyint(1) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_termino` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `propietario_vehiculos_FK` (`vehiculos_id`),
  KEY `propietario_dueños_FK` (`duenos_id`),
  KEY `propietario_usuarios_FK` (`usuarios_id`),
  CONSTRAINT `propietario_vehiculos_FK` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propietario`
--

LOCK TABLES `propietario` WRITE;
/*!40000 ALTER TABLE `propietario` DISABLE KEYS */;
INSERT INTO `propietario` VALUES (1,2,3,0,'2024-08-21 06:00:00',0,0,'2024-08-14 00:00:00','2024-08-20 00:00:00'),(2,2,5,1,'2024-08-21 06:00:00',1,0,'2024-08-14 00:00:00','2024-08-20 00:00:00'),(3,1,2,0,'2024-08-21 06:00:00',0,0,'2024-08-02 00:00:00','2024-08-09 00:00:00'),(4,1,2,1,'2024-08-21 06:00:00',1,0,'2024-08-02 00:00:00','2024-08-20 00:00:00'),(5,5,2,1,'2024-08-21 06:00:00',0,0,'2024-08-16 00:00:00','2024-08-20 00:00:00'),(6,7,6,1,'2024-10-11 06:00:00',0,0,'2014-02-02 00:00:00','2024-08-03 00:00:00'),(8,19,6,1,'2024-08-28 03:14:59',0,0,'2024-08-01 00:00:00','2024-08-30 00:00:00'),(9,2,5,0,'2024-08-28 03:17:18',1,0,'2024-08-10 00:00:00','2024-08-01 00:00:00'),(10,6,15,1,'2024-08-29 01:39:52',1,0,'2024-09-06 00:00:00','2024-08-20 00:00:00'),(11,24,15,1,'2024-08-29 02:00:20',0,0,'2024-08-31 00:00:00','2024-08-20 00:00:00'),(12,6,5,0,'2024-08-29 10:16:41',0,0,'2024-08-19 00:00:00','2024-08-03 00:00:00'),(14,20,15,1,'2024-08-30 01:25:37',0,0,'2024-08-03 00:00:00','2024-08-20 00:00:00');
/*!40000 ALTER TABLE `propietario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `robos`
--

DROP TABLE IF EXISTS `robos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `robos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL,
  `vehiculos_id` int(11) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `placas_id` int(11) NOT NULL,
  `duenos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `robos_usuarios_FK` (`usuarios_id`),
  KEY `robos_vehiculos_FK` (`vehiculos_id`),
  KEY `robos_placas_FK` (`placas_id`),
  KEY `robos_dueños_FK` (`duenos_id`),
  CONSTRAINT `robos_dueños_FK` FOREIGN KEY (`duenos_id`) REFERENCES `duenos` (`id`),
  CONSTRAINT `robos_placas_FK` FOREIGN KEY (`placas_id`) REFERENCES `placas` (`id`),
  CONSTRAINT `robos_vehiculos_FK` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `robos`
--

LOCK TABLES `robos` WRITE;
/*!40000 ALTER TABLE `robos` DISABLE KEYS */;
INSERT INTO `robos` VALUES (1,'2024-08-27 00:20:24',0,'2024-08-23 06:00:00',1,7,'asdasd',5,6),(2,'2024-08-27 00:20:24',0,'2024-08-23 06:00:00',0,7,'Otra vez se lo robaron',5,6),(5,'2024-08-27 00:20:24',0,'2024-08-23 06:00:00',0,1,'sadasdasda',1,2),(6,'2024-08-27 00:20:24',0,'2024-08-23 06:00:00',0,7,'La canaca',5,6),(7,'2024-08-27 00:20:24',0,'2024-08-23 06:00:00',0,7,'1',5,6),(8,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'2',5,6),(9,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'3',5,6),(10,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'4',5,6),(11,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',1,7,'5',5,6),(12,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',1,7,'6',5,6),(13,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'7',5,6),(14,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'8',5,6),(15,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'9',5,6),(16,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'10',5,6),(17,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'11',5,6),(18,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'13',5,6),(19,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'14',5,6),(20,'2024-08-27 00:00:00',0,'2024-08-23 06:00:00',0,7,'14',5,6),(21,'2024-08-27 00:20:24',0,'2024-08-23 06:00:00',0,7,'qwwwwwwwwwwwwwwwwwwww',5,6),(22,'2024-08-27 00:20:24',0,'2024-08-24 01:36:27',0,7,'aAASSDAS',5,6),(23,'2024-08-27 00:00:00',0,'2024-08-24 01:36:59',0,7,'QWDQW',5,6),(25,'2024-08-31 00:00:00',0,'2024-08-29 02:01:22',0,24,'sadadsa',5,15),(26,'2024-08-03 00:00:00',0,'2024-08-30 11:57:26',0,20,'asdsaxasxa\nccccccccccccccccc',4,15);
/*!40000 ALTER TABLE `robos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL,
  `usuarios_id` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin',NULL,0,0),(2,'normal',NULL,0,0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo`
--

DROP TABLE IF EXISTS `tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_tipo` varchar(30) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_usuarios_FK` (`usuarios_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo`
--

LOCK TABLES `tipo` WRITE;
/*!40000 ALTER TABLE `tipo` DISABLE KEYS */;
INSERT INTO `tipo` VALUES (1,'suv','2024-05-26 06:00:00',0,1),(2,'seddan','2024-08-20 06:00:00',0,0),(3,'suburban','2020-11-11 06:00:00',0,0),(4,'4x4','2024-08-29 03:36:45',1,0),(5,'4*$#','2024-08-29 03:37:51',1,0),(6,'1111','2024-08-29 03:39:47',1,0),(7,'suburban2','2024-08-29 09:44:14',1,0);
/*!40000 ALTER TABLE `tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido_p` varchar(100) DEFAULT NULL,
  `apellido_m` varchar(100) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `roles_id` int(11) NOT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_rol` (`roles_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Arturo','Duran','Lopez','1234',1,'2024-01-10 00:00:00',0,''),(2,'Alejandro','Duran','Lopez','1234',2,'2024-01-11 00:00:00',0,''),(3,'ADMIN','admin','admin','1234',1,NULL,0,'admin@admin.com'),(4,'ADMIN','admin','admin','1234',1,NULL,0,'admin@admin.com'),(5,'lvillafana','admin','malvada','1232',1,NULL,0,'admin@admin.com'),(6,'lvillafana','admin','malvada','1232',1,NULL,0,'admin@admin.com');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_serie` varchar(100) NOT NULL,
  `marcas_id` int(11) NOT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `colores_id` int(11) NOT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL,
  `tipos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehiculos_marcas_FK` (`marcas_id`),
  KEY `vehiculos_colores_FK` (`colores_id`),
  KEY `vehiculos_tipo_FK` (`tipo_id`),
  CONSTRAINT `vehiculos_colores_FK` FOREIGN KEY (`colores_id`) REFERENCES `colores` (`id`),
  CONSTRAINT `vehiculos_marcas_FK` FOREIGN KEY (`marcas_id`) REFERENCES `marcas` (`id`),
  CONSTRAINT `vehiculos_tipo_FK` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculos`
--

LOCK TABLES `vehiculos` WRITE;
/*!40000 ALTER TABLE `vehiculos` DISABLE KEYS */;
INSERT INTO `vehiculos` VALUES (1,'Ab123',9,'2005',4,3,'2024-08-29 23:27:20',0,0),(2,'12345',1,'2004',1,3,'2024-08-29 01:32:14',0,0),(3,'34343',1,'2001',1,3,'2024-08-21 06:00:00',0,0),(4,'43434',1,'2001',1,3,'2024-08-21 06:00:00',0,0),(5,'33333',18,'2001',1,3,'2024-08-29 23:11:53',0,0),(6,'11111',7,'2013',3,3,'2024-08-29 23:10:23',0,0),(7,'123AB',7,'1990',3,3,'2024-10-10 06:00:00',0,0),(8,'22222',9,'2001',3,3,'2024-08-27 06:00:00',1,0),(9,'44444',7,'2013',4,3,'2024-08-27 06:00:00',1,0),(10,'55555',2,'2001',1,3,'2024-08-27 06:00:00',1,0),(11,'66666',9,'1999',4,3,'2024-08-27 06:00:00',1,0),(12,'77777',1,'2001',1,3,'2024-08-27 06:00:00',1,0),(13,'44444',2,'2013',1,3,'2024-08-27 06:00:00',1,0),(14,'44444',7,'2001',1,3,'2024-08-27 06:00:00',1,0),(15,'44444',7,'2013',2,3,'2024-08-27 06:00:00',1,0),(16,'4444',1,'2001',2,3,'2024-08-27 06:00:00',1,0),(17,'44444',1,'2001',3,3,'2024-08-27 06:00:00',1,0),(18,'44444',1,'2001',1,3,'2024-08-27 06:00:00',1,0),(19,'44444',9,'2013',1,3,'2024-08-27 06:00:00',0,0),(20,'bbbbb',7,'2021',3,3,'2024-08-28 18:07:56',0,0),(21,'aaaaa1',7,'2021',3,3,'2024-08-28 17:58:18',1,0),(22,'aaaaa2',7,'2021',3,3,'2024-08-28 17:59:10',1,0),(23,'aaaaa222',7,'2021',3,3,'2024-08-28 18:02:10',1,0),(24,'aaaaa1111',7,'2021',3,3,'2024-08-28 18:05:21',1,0),(25,'33333',1,'1221',1,3,'2024-08-28 21:05:35',0,0),(26,'33331',2,'1221',1,3,'2024-08-30 10:41:03',0,0),(27,'33333',1,'2001',2,3,'2024-08-28 21:07:28',1,0),(28,'33333',1,'211',3,3,'2024-08-28 21:08:41',1,0),(29,'333331',1,'2222',1,3,'2024-08-28 21:12:04',1,0),(30,'7777',7,'Mirindajhlghjlkj',4,2,'2024-08-29 23:17:42',1,0),(31,'111115',2,'saa',2,1,'2024-08-29 23:12:12',1,0),(32,'3333355',2,'55',3,2,'2024-08-29 23:27:38',1,0),(33,'3333311111',2,'saa',3,1,'2024-08-30 10:30:52',1,0),(34,'ooooo',7,'saa',3,1,'2024-08-30 10:41:38',0,0),(36,'33333111111',2,'saa',1,1,'2024-09-02 21:54:47',0,0),(37,'12345a',2,'saa',1,1,'2024-09-03 15:00:31',0,0),(38,'12345b',2,'55',1,1,'2024-09-03 15:03:06',0,0),(39,'12345c',2,'55',1,1,'2024-09-03 15:04:29',0,0),(40,'12345d',2,'55',1,1,'2024-09-03 15:06:02',0,0),(41,'12345e',2,'55',1,1,'2024-09-03 15:17:05',0,0),(42,'12345f',2,'55',1,1,'2024-09-03 15:20:48',0,0),(43,'12345g',2,'55',1,1,'2024-09-03 15:21:55',0,0),(44,'12345h',2,'55',1,1,'2024-09-03 15:26:29',0,0),(45,'12345i',2,'55',1,1,'2024-09-03 15:30:51',0,0),(46,'12345j',2,'55',1,1,'2024-09-03 15:31:40',0,0),(47,'12345k',2,'55',1,1,'2024-09-03 15:50:01',0,0),(48,'12345l',2,'55',1,1,'2024-09-03 15:54:59',0,0),(49,'12345m',2,'55',1,1,'2024-09-03 15:56:17',0,0),(50,'12345n',2,'55',1,1,'2024-09-03 15:57:57',0,0),(51,'12345o',2,'55',1,1,'2024-09-03 16:01:14',0,0),(52,'12345p',2,'55',1,1,'2024-09-03 16:01:48',0,0),(53,'12345q',2,'55',1,1,'2024-09-03 16:03:45',0,0),(54,'12345r',2,'55',1,1,'2024-09-03 16:04:41',0,0),(55,'12345s',2,'55',1,1,'2024-09-03 16:04:56',0,0),(56,'12345zzzzzzz',30,'55z',4,2,'2024-09-03 16:08:40',0,0),(57,'12345u',2,'55',1,1,'2024-09-03 16:09:35',1,0),(58,'12345v',2,'55',1,1,'2024-09-03 16:14:31',1,0),(59,'12345w',2,'55',1,1,'2024-09-03 16:14:52',1,0),(60,'12345zzzxxx',18,'55',4,1,'2024-09-03 16:53:02',1,0);
/*!40000 ALTER TABLE `vehiculos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'vehiculos_robados_bd'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-03 15:59:49
