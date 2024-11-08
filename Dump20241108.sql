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
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_carrito`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
INSERT INTO `carrito` VALUES (1,NULL,'2024-11-05 14:01:56'),(2,6,'2024-11-05 14:24:51'),(3,7,'2024-11-05 14:39:15');
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_carrito`
--

DROP TABLE IF EXISTS `detalle_carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_carrito` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_carrito` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  UNIQUE KEY `idx_carrito_producto` (`id_carrito`,`id_producto`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`),
  CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_carrito`
--

LOCK TABLES `detalle_carrito` WRITE;
/*!40000 ALTER TABLE `detalle_carrito` DISABLE KEYS */;
INSERT INTO `detalle_carrito` VALUES (1,1,1,1,100.02),(2,2,2,1,20.00),(4,2,4,1,500.00),(5,2,1,1,100.02),(77,3,1,1,100.02),(78,3,2,4,20.00),(80,3,4,1,500.00),(81,3,11,1,123.00);
/*!40000 ALTER TABLE `detalle_carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_orden`
--

DROP TABLE IF EXISTS `detalle_orden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_orden` (
  `id_detalle_orden` int(11) NOT NULL AUTO_INCREMENT,
  `id_orden` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle_orden`),
  KEY `id_orden` (`id_orden`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalle_orden_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`),
  CONSTRAINT `detalle_orden_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_orden`
--

LOCK TABLES `detalle_orden` WRITE;
/*!40000 ALTER TABLE `detalle_orden` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_orden` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id_orden`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'PruebaImagen','PruebaImagen',100.02,100,'uploads/portada_cacahuates_biodegradables.webp',0.00,1),(2,'PruebaOjoFer','PruebaOjoFer',20.00,10,'uploads/ojo ferxxa.jpg',0.00,1),(3,'Prueba 3','Prueba3',100.00,20,'uploads/Producto ecologico.webp',0.00,0),(4,'Prueba 4','Prueba 4',500.00,100,'uploads/Producto ecologico.webp',0.00,1),(5,'Prueba 5','Prueba 5',50.00,444,'uploads/Cremas.webp',0.00,1),(6,'Prueba de peso','peso',150.00,20,'uploads/Cremas.webp',1.00,1),(7,'Prueba de peso 2','Peso 2',150.50,10,'uploads/vision.png',1.50,1),(8,'Prueba producto de 6kg','peso 6kg',100.00,100,'uploads/vision.png',6.00,1),(9,'Prueba error','prueba erro',250.00,20,'uploads/vision.png',5.00,1),(10,'Prueba 8','pepe',123.00,123,'uploads/Producto ecologico.webp',3.00,1),(11,'HOLA','PRUBEA',123.00,123,'uploads/vision.png',6.00,1),(12,'Peso','Peso 7KG',123.00,123,'uploads/vision.png',7.00,1),(13,'PESO8','PeSo 8KG',123.00,123,'uploads/Cremas.webp',5.00,1),(14,'Diego Informatico','Producto Para el cabello',10.00,123,'uploads/portada_cacahuates_biodegradables.webp',5.00,1),(15,'Prueba Decimales','Producto con fines de probar los decimales',197.50,123,'uploads/Cremas.webp',10.00,1),(16,'Prueba de peso con decimales en los kg','Peso pesito',123.00,123,'uploads/vision.png',6.50,1),(17,'kilosss','kilos',123.00,123,'uploads/PASO10.jpeg',5.50,0);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Jose','pepe.chuy2001@hotmail.com','Pepe','Presidente','8661700949',0),(2,'Jose','pepe.chuy2000@hotmail.com','Pepe','Presidente','8661700949',0),(3,'Prueba2','prueba@hotmail.com','$2y$10$ErnxnJyp6XWshSXExE1B5.48o7LH3Y4/0SFWrd0hkE0f6m7N6gVr.','pepe','8661700949',0),(4,'Gilberto','gil@monclova.tecnm.mx','$2y$10$tQNx4UCIhY77SNLXd7yfnOQMxnX8LFngfPDGadl0jQRpgsBe5OmB2','Tecnologico','8661703850',0),(5,'Admin','rizomats@hotmail.com','Onepiece1','Tec Monclova','0000000000',0),(6,'Adminn','rizomatss@hotmail.com','$2y$10$Viqna2rkbHIM8naa8g5Jv.puLtfuA/knFhD63LgnsEWiw6ETbo1li','TecMonclova','8661700949',1),(7,'Fernanda','fernanda@hotmail.com','$2y$10$WTOz2ekZt9ZBcjHkUibkqOhJtOH/nMnwyEB.l.igNeaakunpdkwwC','Presidente C','8661708989',0),(8,'Diego','gamezdiego115@gmail.com','$2y$10$PJY96872oY8MLYo0LEdkLO.1UJzmkpOgqAfBOp3F8mI6UC7daGSMe','casa obal','8261586303',0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'tienda_carrito'
--

--
-- Dumping routines for database 'tienda_carrito'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-08 10:41:39
