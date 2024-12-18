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
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `peso` decimal(10,2) NOT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'PRODUCTO1','PRODUCTO1',100.00,100,'uploads/portada_cacahuates_biodegradables.webp',1.00,1),(2,'PruebaOjoFer','PruebaOjoFer',20.00,10,'uploads/ojo ferxxa.jpg',0.00,0),(3,'Prueba 3','Prueba3',100.00,20,'uploads/Producto ecologico.webp',0.00,0),(4,'PRODUCTO 2','PRODUCTO 2',200.00,100,'uploads/Producto ecologico.webp',2.00,1),(5,'PRUEBA 3','PRUEBA 3',300.00,100,'uploads/Cremas.webp',3.00,1),(6,'PRUEBA 4','PRUEBA 4',400.00,100,'uploads/Producto 4.png',4.00,1),(7,'Prueba de peso 2','Peso 2',150.50,10,'uploads/vision.png',1.50,1),(8,'Prueba producto de 6kg','peso 6kg',100.00,100,'uploads/vision.png',6.00,1),(9,'Prueba error','prueba erro',250.00,20,'uploads/vision.png',5.00,1),(10,'Prueba 8','pepe',123.00,123,'uploads/Producto ecologico.webp',3.00,1),(11,'HOLA','PRUBEA',123.00,123,'uploads/vision.png',6.00,0),(12,'Peso','Peso 7KG',123.00,123,'uploads/vision.png',7.00,0),(13,'PESO8','PeSo 8KG',123.00,123,'uploads/Cremas.webp',5.00,0),(14,'Diego Informatico','Producto Para el cabello',10.00,123,'uploads/portada_cacahuates_biodegradables.webp',5.00,0),(15,'Prueba Decimales','Producto con fines de probar los decimales',197.50,123,'uploads/Cremas.webp',10.00,0),(16,'Prueba de peso con decimales en los kg','Peso pesito',123.00,123,'uploads/vision.png',6.50,0),(17,'kilosss','kilos',123.00,123,'uploads/PASO10.jpeg',5.50,0),(18,'Prueba de Status','Prueba de Status',200.00,10,'uploads/producto2.jpeg',1.00,0);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-18 16:08:42
