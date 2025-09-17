CREATE DATABASE  IF NOT EXISTS `msmartbuy` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `msmartbuy`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: msmartbuy
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `nota` varchar(200) DEFAULT NULL,
  `valor_venta` decimal(12,2) NOT NULL,
  `valor_envio` decimal(10,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `usuario_ID` bigint NOT NULL,
  `metodo_pago_ID` int NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `fk_factura_usuario1_idx` (`usuario_ID`),
  KEY `fk_factura_metodo_pago1_idx` (`metodo_pago_ID`),
  CONSTRAINT `fk_factura_metodo_pago1` FOREIGN KEY (`metodo_pago_ID`) REFERENCES `metodo_pago` (`ID`),
  CONSTRAINT `fk_factura_usuario1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (1,'2025-09-16','Necesito que el pedido llegue antes de 12pm',15900.00,5000.00,20900.00,'PENDIENTE',12,1),(3,'2025-09-16','',1500.00,2000.00,28375.00,'PENDIENTE',12,1),(4,'2025-09-16','Esto es para el almuerzo y yo voy a cocinar.',13720.00,6000.00,21960.00,'PENDIENTE',4,1),(5,'2025-09-16','',6000.00,4000.00,46800.00,'PENDIENTE',4,2),(6,'2025-09-16','tengo sed',4675.00,0.00,4675.00,'PENDIENTE',4,2),(7,'2025-09-16','',2000.00,1000.00,3000.00,'PENDIENTE',4,2),(8,'2025-09-16','',6860.00,3000.00,9860.00,'PENDIENTE',4,2),(9,'2025-09-16','',6860.00,4545.00,11405.00,'PENDIENTE',4,1),(10,'2025-09-16','',6860.00,2999.00,9859.00,'PENDIENTE',4,2),(11,'2025-09-16','',3000.00,2000.00,6200.00,'PENDIENTE',4,1),(12,'2025-09-16','',2000.00,0.00,2000.00,'PENDIENTE',4,2);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:40
