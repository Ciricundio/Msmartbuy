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
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `n_identificacion` bigint DEFAULT NULL,
  `tipo_documento` varchar(4) DEFAULT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(145) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  UNIQUE KEY `n_identificacion_UNIQUE` (`n_identificacion`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (4,NULL,NULL,'Ciro','Muñoz','3135804317','amadeus@gmail.com','$2y$10$aw7tS8VmMsWGnvYi0iMvbeVRWzP0cprPk.FZ6thY9ieDJbrwPZc52','masculino','2006-12-15',NULL,'cliente'),(5,NULL,NULL,'Leniker','Zuleta','3135804317','admin@msb.com','$2y$10$gLD8jxDm2zj5D0CLdLf4veonruxrud8goIt6SeCFRtqpPr9AgvQtu','masculino','2000-01-09',NULL,'admin'),(6,NULL,NULL,'Yofran','Zuleta','3135804317','yofran@gmail.com','$2y$10$4h0NXOr8MJ3LvuZ0mPSFg.5e11h6DmSHp57pfQ1zwflaC4995C7.u','masculino','2020-01-09',NULL,'proveedor'),(7,NULL,NULL,'Snake Fury','Pancracio','3012345678','sfp@gmail.com','$2y$10$oV5blciIYFeffcUxQ5L94.tl/lTtI0dlJsk0BtUmmb/mE1LNtjuOe','masculino','2000-11-09',NULL,'cliente'),(11,NULL,NULL,'William','Shakespeare','3023456789','shake@gmail.com','$2y$10$57GATsG7Ufj0y.HGKqGCkOkncIQi6oZYE0xrKnomHlhkUt6DICIo2','masculino','1564-04-23',NULL,'cliente'),(12,NULL,NULL,'Isaac','Newton','3012345678','isaac@gmail.com','$2y$10$FcXyTN/aTtDQC7ERjpy42ez/NelA3FpOq5oGjmsaB17ysoXLYu8GO','masculino','1642-12-25',NULL,'cliente'),(13,NULL,NULL,'Frida','Kahlo','3012345678','fridaka@gmail.com','$2y$10$IBocwcQ3VaMq1qi9KOOuO.cn.MwS2puBEWRL2mIvFDWYX5pMzhgju','femenino','2003-07-06',NULL,'cliente'),(14,NULL,NULL,'Frida','Kahlo','3012345678','fridaka@gmail.com','$2y$10$IBocwcQ3VaMq1qi9KOOuO.cn.MwS2puBEWRL2mIvFDWYX5pMzhgju','femenino','2003-07-06',NULL,'cliente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:37
