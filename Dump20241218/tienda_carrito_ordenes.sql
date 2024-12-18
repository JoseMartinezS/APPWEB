CREATE DATABASE  IF NOT EXISTS `tienda_carrito` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `tienda_carrito`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tienda_carrito
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenes` (
  `id_orden` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_orden` datetime DEFAULT current_timestamp(),
  `estado` varchar(50) DEFAULT 'pendiente',
  `pago_id` varchar(50) DEFAULT NULL,
  `direccion_envio` varchar(255) DEFAULT NULL,
  `direccion_linea2` varchar(255) DEFAULT NULL,
  `direccion_linea3` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado_envio` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_orden`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
INSERT INTO `ordenes` VALUES (1,NULL,179.00,'2024-11-27 17:56:25','Completado','trjjqf4l5vz1tvon5fk5','Presidente','Presidente','Presidente','25680','Frontera','coahuila'),(2,NULL,179.00,'2024-11-27 18:05:38','Completado','tritkk0ne6cqyij39apr','Presidente','Presidente','Presidente','25680','frontera','coahuila'),(3,NULL,179.00,'2024-11-27 18:09:21','Completado','trewmb3fiaxeu544jkpm','Presidente','Presidente','Presidente','25680','frontera','coahuila'),(4,6,179.00,'2024-11-27 18:15:59','Completada','trtrpilvfeaccbcbr3ze','Presidente','Presidente','Presidente','25680','Frontera','coahuila'),(5,7,716.00,'2024-11-27 18:42:20','Completada','trr2m8fvawvyq1c7aysd','Cuauhtémoc 1212','Kenedy','Argon','25680','Monclova','coahuila'),(6,6,358.00,'2024-11-27 21:03:51','En Proceso','trmq8na0skb5k91nozrp','Presidente','Presidente','Presidente','25680','fr','coahuila'),(7,6,179.00,'2024-12-14 20:39:47','En Proceso','trkrcevimcc1mfutf0ve','Presidente','Presidente','Presidente','25680','Frontera','coahuila');
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-18 16:08:41
