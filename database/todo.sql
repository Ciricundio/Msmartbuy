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
-- Table structure for table `carrito_producto`
--

DROP TABLE IF EXISTS `carrito_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito_producto` (
  `carrito_ID` bigint NOT NULL,
  `producto_ID` bigint NOT NULL,
  `cantidad` int NOT NULL,
  `subtotal` bigint NOT NULL,
  PRIMARY KEY (`carrito_ID`,`producto_ID`),
  KEY `fk_carrito_has_producto_producto1_idx` (`producto_ID`),
  KEY `fk_carrito_has_producto_carrito1_idx` (`carrito_ID`),
  CONSTRAINT `fk_carrito_has_producto_carrito1` FOREIGN KEY (`carrito_ID`) REFERENCES `carrito` (`ID`),
  CONSTRAINT `fk_carrito_has_producto_producto1` FOREIGN KEY (`producto_ID`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito_producto`
--

LOCK TABLES `carrito_producto` WRITE;
/*!40000 ALTER TABLE `carrito_producto` DISABLE KEYS */;
INSERT INTO `carrito_producto` VALUES (2,104,1,8900),(2,113,1,10500);
/*!40000 ALTER TABLE `carrito_producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:38
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
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `fecha_creacion` date NOT NULL,
  `usuario_ID` bigint NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `fk_carrito_usuario1_idx` (`usuario_ID`),
  CONSTRAINT `fk_carrito_usuario1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
INSERT INTO `carrito` VALUES (2,'2025-08-19',13),(3,'2025-09-14',5);
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Todos','todos'),(2,'Aseo personal','aseoPersonal'),(3,'Bebidas','bebidas'),(4,'Granos','granos'),(6,'Lactios','lactios'),(7,'Embutidos','embutidos'),(8,'Bebes','bebes'),(9,'Frutas','frutas'),(10,'Papelería','papeleria'),(11,'Limpieza','limpieza'),(12,'Fiesta','fiesta'),(13,'Carnes frías','carneFria'),(14,'Baño',NULL),(15,'Juegos',NULL),(16,'Farmacia',NULL),(17,'Cocina',NULL);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
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
-- Table structure for table `color`
--

DROP TABLE IF EXISTS `color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `color` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `color` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color`
--

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `detalle_factura`
--

DROP TABLE IF EXISTS `detalle_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_factura` (
  `factura_ID` bigint NOT NULL,
  `producto_ID` bigint NOT NULL,
  `cantidad_producto` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`factura_ID`,`producto_ID`),
  KEY `fk_factura_has_producto_producto1_idx` (`producto_ID`),
  KEY `fk_factura_has_producto_factura1_idx` (`factura_ID`),
  CONSTRAINT `fk_factura_has_producto_factura1` FOREIGN KEY (`factura_ID`) REFERENCES `factura` (`ID`),
  CONSTRAINT `fk_factura_has_producto_producto1` FOREIGN KEY (`producto_ID`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_factura`
--

LOCK TABLES `detalle_factura` WRITE;
/*!40000 ALTER TABLE `detalle_factura` DISABLE KEYS */;
INSERT INTO `detalle_factura` VALUES (1,113,2,14700.00),(1,132,1,1200.00),(3,2,2,1500.00),(3,3,2,1500.00),(3,115,1,1500.00),(3,120,1,1500.00),(3,131,1,1500.00),(4,103,1,13720.00),(4,105,2,13720.00),(5,10,2,6000.00),(5,104,1,6000.00),(5,114,1,6000.00),(5,119,1,6000.00),(5,124,1,6000.00),(5,133,2,6000.00),(6,102,1,4675.00),(7,3,1,2000.00),(8,105,1,6860.00),(9,105,1,6860.00),(10,105,1,6860.00),(11,132,1,3000.00),(11,133,1,3000.00),(12,3,1,2000.00);
/*!40000 ALTER TABLE `detalle_factura` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:38
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
-- Table structure for table `favorito_producto`
--

DROP TABLE IF EXISTS `favorito_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorito_producto` (
  `favorito_ID` bigint NOT NULL,
  `producto_ID` bigint NOT NULL,
  PRIMARY KEY (`favorito_ID`,`producto_ID`),
  KEY `fk_favorito_has_producto_producto1_idx` (`producto_ID`),
  KEY `fk_favorito_has_producto_favorito1_idx` (`favorito_ID`),
  CONSTRAINT `fk_favorito_has_producto_favorito1` FOREIGN KEY (`favorito_ID`) REFERENCES `favorito` (`ID`),
  CONSTRAINT `fk_favorito_has_producto_producto1` FOREIGN KEY (`producto_ID`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorito_producto`
--

LOCK TABLES `favorito_producto` WRITE;
/*!40000 ALTER TABLE `favorito_producto` DISABLE KEYS */;
INSERT INTO `favorito_producto` VALUES (1,113),(1,131);
/*!40000 ALTER TABLE `favorito_producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `favorito`
--

DROP TABLE IF EXISTS `favorito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorito` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `usuario_ID` bigint NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_favorito_usuario1_idx` (`usuario_ID`),
  CONSTRAINT `fk_favorito_usuario1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorito`
--

LOCK TABLES `favorito` WRITE;
/*!40000 ALTER TABLE `favorito` DISABLE KEYS */;
INSERT INTO `favorito` VALUES (1,4),(2,5);
/*!40000 ALTER TABLE `favorito` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `mensaje`
--

DROP TABLE IF EXISTS `mensaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensaje` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `fecha_mensaje` date NOT NULL,
  `contenido` varchar(250) NOT NULL,
  `respuesta_mensaje` bigint DEFAULT NULL,
  `soporte_ID` bigint NOT NULL,
  `usuario_ID` bigint NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `fk_mensaje_mensaje1_idx` (`respuesta_mensaje`),
  KEY `fk_mensaje_soporte1_idx` (`soporte_ID`),
  KEY `fk_mensaje_usuario1_idx` (`usuario_ID`),
  CONSTRAINT `fk_mensaje_mensaje1` FOREIGN KEY (`respuesta_mensaje`) REFERENCES `mensaje` (`ID`),
  CONSTRAINT `fk_mensaje_soporte1` FOREIGN KEY (`soporte_ID`) REFERENCES `soporte` (`ID`),
  CONSTRAINT `fk_mensaje_usuario1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensaje`
--

LOCK TABLES `mensaje` WRITE;
/*!40000 ALTER TABLE `mensaje` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensaje` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `metodo_pago`
--

DROP TABLE IF EXISTS `metodo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodo_pago` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `pago` varchar(45) DEFAULT NULL,
  `tarjeta_ID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `fk_table1_tarjeta1_idx` (`tarjeta_ID`),
  CONSTRAINT `fk_table1_tarjeta1` FOREIGN KEY (`tarjeta_ID`) REFERENCES `tarjeta` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodo_pago`
--

LOCK TABLES `metodo_pago` WRITE;
/*!40000 ALTER TABLE `metodo_pago` DISABLE KEYS */;
INSERT INTO `metodo_pago` VALUES (1,'Efectivo',NULL),(2,'Transferencia',NULL);
/*!40000 ALTER TABLE `metodo_pago` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `producto_color`
--

DROP TABLE IF EXISTS `producto_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_color` (
  `producto_ID` bigint NOT NULL,
  `color_ID` int NOT NULL,
  PRIMARY KEY (`producto_ID`,`color_ID`),
  KEY `fk_producto_has_color_color1_idx` (`color_ID`),
  KEY `fk_producto_has_color_producto1_idx` (`producto_ID`),
  CONSTRAINT `fk_producto_has_color_color1` FOREIGN KEY (`color_ID`) REFERENCES `color` (`ID`),
  CONSTRAINT `fk_producto_has_color_producto1` FOREIGN KEY (`producto_ID`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_color`
--

LOCK TABLES `producto_color` WRITE;
/*!40000 ALTER TABLE `producto_color` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_color` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:38
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
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `marca` varchar(45) NOT NULL,
  `cantidad` varchar(45) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `vistas` int DEFAULT NULL,
  `sku` varchar(45) NOT NULL,
  `f_inicio_oferta` date DEFAULT NULL,
  `f_final_oferta` date DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `peso` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `descuento` int DEFAULT NULL,
  `resena_ID` bigint DEFAULT NULL,
  `categoria_ID` int DEFAULT NULL,
  `proveedor_ID` bigint DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `fk_producto_resena1_idx` (`resena_ID`),
  KEY `fk_producto_categoria1_idx` (`categoria_ID`),
  KEY `fk_producto_usuario1_idx` (`proveedor_ID`),
  CONSTRAINT `fk_producto_categoria1` FOREIGN KEY (`categoria_ID`) REFERENCES `categoria` (`ID`),
  CONSTRAINT `fk_producto_resena1` FOREIGN KEY (`resena_ID`) REFERENCES `resena` (`ID`),
  CONSTRAINT `fk_producto_usuario1` FOREIGN KEY (`proveedor_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Agua Cristal 600ml','Postobon','200','Agua mineral embotellada',1500,'AGUACRIS001',NULL,NULL,'agua_cristal.jpg','600','Descontinuado',1800.00,10,NULL,3,6),(2,'Gaseosa Coca-Cola 1.5L','Coca-Cola','150','Bebida carbonatada refrescante',2500,'COCACOLA15L',NULL,NULL,'coca_cola.jpg','1500','Disponible',5500.00,0,NULL,3,6),(3,'Papas Margarita Pollo 45g','Margarita','300','Snack de papas sabor pollo',3000,'PAPASMPOLLO',NULL,NULL,'papas_pollo.jpg','45','Disponible',2000.00,0,NULL,1,6),(4,'Leche Entera Colanta 1L','Colanta','100','Leche UHT entera',1200,'LECHECOLANTA',NULL,NULL,'leche_colanta.jpg','1000','Descontinuado',4200.00,0,NULL,1,6),(5,'Arroz Diana 500g','Diana','50','Arroz blanco tradicional',800,'ARROZDIANA',NULL,NULL,'arroz_diana.jpg','500','Descontinuado',2800.00,0,NULL,1,6),(6,'Atún Van Camp\'s Aceite 170g','Van Camp\'s','70','Atún en aceite',950,'ATUNVANCAMPS',NULL,NULL,'atun_vancamps.jpg','170','Descontinuado',6500.00,0,NULL,1,6),(7,'Pan Bimbo Blanco 300g','Bimbo','80','Pan tajado blanco',1100,'PANBIMBOBCO',NULL,NULL,'pan_bimbo.jpg','300','Descontinuado',3800.00,0,NULL,1,6),(8,'Jabón Ariel Polvo 500g','Ariel','60','Detergente en polvo para ropa',1800,'JABONARIEL500',NULL,NULL,'ariel.jpg','500','Disponible',8900.00,0,NULL,2,6),(9,'Papel Higiénico Familia x4 rollos','Familia','90','Papel higiénico doble hoja',2200,'PAPELHIGIENIC',NULL,NULL,'papel_familia.jpg','800','Descontinuado',7500.00,0,NULL,2,6),(10,'Crema Dental Colgate Triple Acción 75ml','Colgate','110','Crema dental protección completa',1400,'CREMADENTALC',NULL,NULL,'crema_colgate.jpg','75','Disponible',4300.00,0,NULL,2,6),(11,'Aceite Vegetal Doria 1L','Doria','40','Aceite de cocina',700,'ACEITEDORIA1L',NULL,NULL,'aceite_doria.jpg','1000','Descontinuado',9800.00,0,NULL,17,6),(12,'Huevos Rojos Kikes x6','Kikes','120','Media docena de huevos',1600,'HUEVOSKIKES6',NULL,NULL,'huevos_kikes.jpg','400','Disponible',5000.00,0,NULL,1,6),(13,'Café Sello Rojo 125g','Sello Rojo','95','Café molido tradicional',1300,'CAFESELLORJ',NULL,NULL,'cafe_sello_rojo.jpg','125','Disponible',4900.00,0,NULL,1,6),(14,'Azúcar Manuelita 1kg','Manuelita','65','Azúcar refinada blanca',900,'AZUCARMANU1K',NULL,NULL,'azucar_manuelita.jpg','1000','Disponible',3600.00,0,NULL,1,6),(15,'Sal Marina Refisal 500g','Refisal','75','Sal marina fina',600,'SALREFI500G',NULL,NULL,'sal_refisal.jpg','500','Disponible',1500.00,0,NULL,1,6),(16,'Galletas Ducales Noel 100g','Noel','250','Galletas saladas tradicionales',2800,'GALLEDUCNOEL',NULL,NULL,'galletas_ducales.jpg','100','Disponible',2300.00,0,NULL,1,6),(17,'Jugo Hit Naranja 1L','Postobon','180','Jugo pasteurizado sabor naranja',1700,'JUGOHITNAR1L',NULL,NULL,'jugo_hit.jpg','1000','Disponible',3900.00,0,NULL,3,6),(18,'Cereal Zucaritas Kellogg\'s 200g','Kellogg\'s','50','Cereal de maíz azucarado',1000,'CEREALZUCKE',NULL,NULL,'zucaritas.jpg','200','Disponible',7500.00,0,NULL,1,6),(19,'Gelatina Gel\'hada Sabores Surtidos','Gel\'hada','90','Postre de gelatina surtida',800,'GELGELSURT',NULL,NULL,'gel_hada.jpg','100','Disponible',1200.00,0,NULL,1,6),(20,'Salsa de Tomate Fruco 200g','Fruco','100','Salsa de tomate clásica',1100,'SALSATF200G',NULL,NULL,'salsa_fruco.jpg','200','Disponible',2100.00,0,NULL,1,6),(21,'Mayonesa Fruco 100g','Fruco','80','Mayonesa clásica',900,'MAYONESAF100',NULL,NULL,'mayonesa_fruco.jpg','100','Disponible',1900.00,0,NULL,1,6),(22,'Lentejas Súperpolo 500g','Súperpolo','45','Lentejas secas',650,'LENTEJASUP500',NULL,NULL,'lentejas_superpolo.jpg','500','Disponible',3200.00,0,NULL,1,6),(23,'Frijoles Cargamanto DelCampo 500g','DelCampo','40','Frijoles secos',600,'FRIJOLESDECA',NULL,NULL,'frijoles_delcampo.jpg','500','Disponible',3500.00,0,NULL,1,6),(24,'Harina de Trigo Presto 500g','Presto','55','Harina de trigo para cocina',750,'HARINAPRESTO',NULL,NULL,'harina_presto.jpg','500','Disponible',2900.00,0,NULL,1,6),(25,'Servilletas Familia Practiroll','Familia','70','Servilletas de papel',1300,'SERVIFAMIPRA',NULL,NULL,'servilletas_familia.jpg','300','Disponible',4500.00,0,NULL,2,6),(26,'Detergente Líquido Fab 1L','Fab','50','Detergente líquido para ropa',1600,'DETERGENTEFA',NULL,NULL,'detergente_fab.jpg','1000','Disponible',12000.00,0,NULL,2,6),(27,'Suavizante Downy Concentrado 400ml','Downy','40','Suavizante para ropa',1400,'SUAVIZADOWNC',NULL,NULL,'downy.jpg','400','Disponible',7800.00,0,NULL,2,6),(28,'Ambientador Glade Automático','Glade','30','Ambientador automático para el hogar',900,'AMBIENTGLADE',NULL,NULL,'glade.jpg','200','Disponible',15000.00,0,NULL,2,6),(29,'Desinfectante Lysol Aerosol 300ml','Lysol','35','Desinfectante multiusos',1100,'DESINFECTLYS',NULL,NULL,'lysol.jpg','300','Descontinuado',10500.00,0,NULL,2,6),(30,'Jabón Rey Barra 300g','Rey','85','Jabón para lavar ropa en barra',1900,'JABONREYBAR',NULL,NULL,'jabon_rey.jpg','300','Disponible',3000.00,0,NULL,2,6),(31,'Cloro Blanqueador Clorox 1L','Clorox','60','Cloro blanqueador para ropa y superficies',1500,'CLOROBLANCL',NULL,NULL,'cloro_clorox.jpg','1000','Disponible',4800.00,0,NULL,2,6),(32,'Detergente para Platos Axion Líquido 500ml','Axion','70','Detergente líquido para loza',1700,'AXIONLIQ500',NULL,NULL,'axion.jpg','500','Disponible',6200.00,0,NULL,2,6),(33,'Esponja de Cocina Scotch-Brite','Scotch-Brite','100','Esponja para lavar platos',1200,'ESPONJASCOTCH',NULL,NULL,'esponja_scotch.jpg','20','Disponible',2500.00,0,NULL,2,6),(34,'Bolsas de Basura Grande x10','Plásticos','100','Bolsas de basura resistentes',900,'BOLSABASGRX10',NULL,NULL,'bolsas_basura.jpg','100','Disponible',3500.00,0,NULL,2,6),(35,'Shampoo Head & Shoulders Control Caspa 180ml','Head & Shoulders','50','Shampoo anti-caspa',1300,'SHAMPOOHDS180',NULL,NULL,'shampoo_hds.jpg','180','Disponible',10500.00,0,NULL,2,6),(36,'Acondicionador Pantene Restauración 180ml','Pantene','50','Acondicionador para cabello dañado',1200,'ACONDIPANT180',NULL,NULL,'acond_pantene.jpg','180','Descontinuado',10500.00,0,NULL,2,6),(37,'Jabón de Tocador Palmolive Suavidad 90g','Palmolive','150','Jabón de tocador humectante',1600,'JABONTOCAPAL',NULL,NULL,'jabon_palmolive.jpg','90','Disponible',2000.00,0,NULL,2,6),(38,'Desodorante Dove Roll-on Original 50ml','Dove','80','Desodorante antitranspirante',1000,'DESODODVRN50',NULL,NULL,'desod_dove.jpg','50','Disponible',7000.00,0,NULL,2,6),(39,'Rasuradoras Gillette Mach3 x2','Gillette','40','Máquinas de afeitar de 3 hojas',800,'RASURGILMA3X2',NULL,NULL,'gillette_mach3.jpg','50','Disponible',18000.00,0,NULL,2,6),(40,'Crema para Manos Nivea Soft 75ml','Nivea','60','Crema humectante para manos',900,'CREMANOSNIV75',NULL,NULL,'crema_nivea.jpg','75','Disponible',6500.00,0,NULL,2,6),(41,'Papel de Cocina Scott Duramax','Scott','80','Papel absorbente de cocina',1000,'PAPELCOCSCMA',NULL,NULL,'papel_cocina_scott.jpg','300','Disponible',6000.00,0,NULL,2,6),(42,'Fósforos El Rey x10 cajas','El Rey','150','Cajas de fósforos',500,'FOSFORELREY',NULL,NULL,'fosforos_rey.jpg','100','Disponible',2500.00,0,NULL,2,6),(43,'Velas Blancas Pequeñas x4','N/A','100','Velas para alumbrar',400,'VELASBLANCAS',NULL,NULL,'velas.jpg','150','Disponible',3000.00,0,NULL,2,6),(44,'Pilax AA x4','Pilax','70','Pilas alcalinas AA',800,'PILASAAX4',NULL,NULL,'pilas_aa.jpg','80','Disponible',8000.00,0,NULL,2,6),(45,'Bombilla LED 7W','Phillips','50','Bombilla de bajo consumo',600,'BOMBILLALED7W',NULL,NULL,'bombilla_led.jpg','50','Disponible',12000.00,0,NULL,2,6),(46,'Cinta Adhesiva Transparente','3M','90','Cinta para empaque o uso general',700,'CINTAADHE3M',NULL,NULL,'cinta_3m.jpg','30','Disponible',4000.00,0,NULL,2,6),(47,'Tijeras Uso General','Tramontina','60','Tijeras de acero inoxidable',500,'TIJERASGRAL',NULL,NULL,'tijeras.jpg','80','Disponible',5500.00,0,NULL,2,6),(48,'Pegamento Líquido Super Bonder','Loctite','80','Pegamento instantáneo',400,'PEGAMENTOSUP',NULL,NULL,'super_bonder.jpg','3','Disponible',4500.00,0,NULL,2,6),(49,'Paños de Cocina Reutilizables x3','Vileda','50','Paños de microfibra',700,'PANOSCOCVILE',NULL,NULL,'panos_vileda.jpg','100','Disponible',9000.00,0,NULL,2,6),(50,'Escoba y Recogedor','Rey','30','Set de escoba y recogedor',600,'ESCOBAYRECO',NULL,NULL,'escoba_rey.jpg','1500','Disponible',25000.00,0,NULL,2,6),(51,'Trapeador de Algodón','N/A','40','Trapeador absorbente',500,'TRAPALGODON',NULL,NULL,'trapeador_algodon.jpg','800','Disponible',18000.00,0,NULL,2,6),(52,'Balde Plástico 10L','Rimoplast','35','Balde multiusos',450,'BALDEPLAST10L',NULL,NULL,'balde_plastico.jpg','400','Disponible',10000.00,0,NULL,2,6),(53,'Guantes de Látex Desechables M x10','N/A','100','Guantes para limpieza o uso general',300,'GUANTESLATEXM',NULL,NULL,'guantes_latex.jpg','50','Disponible',4000.00,0,NULL,2,6),(54,'Esponjillas Metálicas x3','Brilla','80','Esponjillas para limpieza profunda',400,'ESPONJMETX3',NULL,NULL,'esponjillas_metalicas.jpg','30','Disponible',3000.00,0,NULL,2,6),(55,'Desengrasante Limpido Cocina 500ml','Limpido','50','Desengrasante para superficies de cocina',800,'DESENGRALIM500',NULL,NULL,'limpido.jpg','500','Disponible',8500.00,0,NULL,2,6),(56,'Limpiador de Vidrios Brilla King 500ml','Brilla King','60','Limpiador para cristales',700,'LIMPIADBRK500',NULL,NULL,'brilla_king.jpg','500','Disponible',5800.00,0,NULL,2,6),(57,'Pastillas para Chupar Halls Menta','Halls','200','Refrescantes para la garganta',1800,'HALLSMENTA',NULL,NULL,'halls_menta.jpg','30','Disponible',2200.00,0,NULL,1,6),(58,'Chicle Trident Menta','Trident','250','Goma de mascar sin azúcar',2000,'TRIDENTMENTA',NULL,NULL,'trident.jpg','15','Disponible',1800.00,0,NULL,1,6),(59,'Chocolatina Jet Pequeña','Jet','300','Pequeña chocolatina de leche',3500,'CHOCOJETPEQ',NULL,NULL,'chocolatina_jet.jpg','12','Disponible',1000.00,0,NULL,1,6),(60,'Barra de Cereal Kellogg\'s Special K','Kellogg\'s','100','Barra de cereal saludable',1100,'BARRACEREALK',NULL,NULL,'barra_special_k.jpg','25','Disponible',2500.00,0,NULL,1,6),(61,'Maní Salado Supercoco 80g','Supercoco','120','Maní salado tostado',1300,'MANISUPERCOC',NULL,NULL,'mani_supercoco.jpg','80','Disponible',3000.00,0,NULL,1,6),(62,'Chitos Queso','Chitos','180','Snack de maíz sabor queso',1600,'CHITOSQUESO',NULL,NULL,'chitos.jpg','40','Disponible',2000.00,0,NULL,1,6),(63,'De Todito Original 145g','Frito Lay','150','Mix de snacks variados',2200,'DETODITOORIG',NULL,NULL,'detodito.jpg','145','Disponible',6000.00,0,NULL,1,6),(64,'Papas Pringles Original 134g','Pringles','70','Papas en forma de tubo',1500,'PRINGLESORIG',NULL,NULL,'pringles.jpg','134','Disponible',8500.00,0,NULL,1,6),(65,'Bebida Energizante Red Bull 250ml','Red Bull','90','Bebida energética',1900,'REDBULL250ML',NULL,NULL,'redbull.jpg','250','Disponible',7000.00,0,NULL,3,6),(66,'Gatorade Naranja 500ml','Gatorade','100','Bebida hidratante deportiva',1400,'GATORADENAR500',NULL,NULL,'gatorade.jpg','500','Disponible',4500.00,0,NULL,3,6),(67,'Agua Saborizada Brisa Frutos Rojos 600ml','Postobon','130','Agua saborizada sin azúcar',1100,'AGUABRFRR600',NULL,NULL,'brisa_frutos_rojos.jpg','600','Descontinuado',2200.00,0,NULL,3,6),(68,'Jugo California Manzana 200ml','California','180','Jugo de manzana individual',900,'JUGOCALIMAN200',NULL,NULL,'jugo_california.jpg','200','Disponible',1500.00,0,NULL,3,6),(69,'Cerveza Aguila Lata 330ml','Bavaria','200','Cerveza rubia tipo Lager',2500,'CERVEAGUILA',NULL,NULL,'cerveza_aguila.jpg','330','Disponible',3000.00,0,NULL,3,6),(70,'Cerveza Poker Lata 330ml','Bavaria','180','Cerveza Lager',2300,'CERVEPOKER',NULL,NULL,'cerveza_poker.jpg','330','Disponible',3000.00,0,NULL,3,6),(71,'Vino Gato Negro Tinto 750ml','Gato Negro','20','Vino tinto chileno',500,'VINOGATONEGR',NULL,NULL,'vino_gato_negro.jpg','750','Disponible',25000.00,0,NULL,3,6),(72,'Ron Viejo de Caldas 3 Años 750ml','Industria Licorera de Caldas','15','Ron añejo colombiano',400,'RONVCCALDAS',NULL,NULL,'ron_viejo_caldas.jpg','750','Disponible',45000.00,0,NULL,3,6),(73,'Aguardiente Néctar Azul 750ml','Empresas Licoreras de Cundinamarca','18','Aguardiente anisado sin azúcar',420,'AGUANECTARAZUL',NULL,NULL,'aguardiente_nectar.jpg','750','Descontinuado',40000.00,0,NULL,3,6),(74,'Cigarrillos Marlboro Rojo','Philip Morris','50','Caja de cigarrillos',1000,'CIGAMARLROJO',NULL,NULL,'marlboro_rojo.jpg','20','Disponible',9000.00,0,NULL,1,6),(75,'Encendedor Bic','Bic','120','Encendedor de bolsillo',800,'ENCENDEDORBIC',NULL,NULL,'encendedor_bic.jpg','15','Disponible',2000.00,0,NULL,2,6),(76,'Condones Durex Clásico x3','Durex','70','Preservativos de látex',900,'CONDONSDUREX',NULL,NULL,'condones_durex.jpg','10','Disponible',8000.00,0,NULL,2,6),(77,'Pañales Huggies Recién Nacido x20','Huggies','30','Pañales para bebé',700,'PANALESRHUGG',NULL,NULL,'panales_huggies.jpg','500','Disponible',25000.00,0,NULL,2,6),(78,'Toallitas Húmedas Pequeñín x50','Pequeñín','80','Toallitas húmedas para bebé',1100,'TOALLITASP50',NULL,NULL,'toallitas_pequenin.jpg','200','Disponible',6000.00,0,NULL,2,6),(79,'Crema Humectante Johnson\'s Baby 200ml','Johnson\'s Baby','50','Crema hidratante para bebé',900,'CREMAJOHNSON200',NULL,NULL,'crema_johnsons.jpg','200','Disponible',12000.00,0,NULL,2,6),(80,'Compresas Higiénicas Nosotras Invisible x10','Nosotras','100','Toallas sanitarias delgadas',1300,'COMPRESASNOINV',NULL,NULL,'compresas_nosotras.jpg','50','Disponible',5000.00,0,NULL,2,6),(81,'Tampones Tampax Regular x8','Tampax','40','Tampones con aplicador',600,'TAMPONSTAMPR',NULL,NULL,'tampones_tampax.jpg','30','Disponible',9000.00,0,NULL,2,6),(82,'Velas Aromatizadas Vainilla','N/A','60','Velas para ambiente con aroma',800,'VELAAROMAVAN',NULL,NULL,'vela_aromatizada.jpg','100','Disponible',7000.00,0,NULL,2,6),(83,'Insecticida Raid Hogar y Jardín 400ml','Raid','50','Insecticida en aerosol',900,'INSECTICIRAID',NULL,NULL,'raid.jpg','400','Disponible',11000.00,0,NULL,2,6),(84,'Repelente Off! FamilyCare 100ml','Off!','70','Repelente de insectos en crema',1000,'REPELENTEOFF',NULL,NULL,'repelente_off.jpg','100','Disponible',9500.00,0,NULL,2,6),(85,'Pilas AAA x4','Pilax','70','Pilas alcalinas AAA',750,'PILASAAAX4',NULL,NULL,'pilas_aaa.jpg','60','Disponible',7500.00,0,NULL,2,6),(86,'Linterna Pequeña LED','N/A','40','Linterna de mano compacta',500,'LINTERNALEDPEQ',NULL,NULL,'linterna_led.jpg','100','Disponible',15000.00,0,NULL,2,6),(87,'Cargador de Celular Universal','N/A','30','Cargador con múltiples adaptadores',400,'CARGADORUNIV',NULL,NULL,'cargador_universal.jpg','150','Disponible',20000.00,0,NULL,2,6),(88,'Audífonos con Cable','N/A','50','Audífonos básicos con micrófono',600,'AUDIFONOSCABL',NULL,NULL,'audifonos.jpg','50','Disponible',10000.00,0,NULL,2,6),(89,'Tarjeta Recarga Celular Tigo $5000','Tigo','100','Tarjeta para recarga de saldo',1200,'RECARTIGO5000',NULL,NULL,'recarga_tigo.jpg','1','Disponible',5000.00,0,NULL,1,6),(90,'Tarjeta Recarga Celular Claro $5000','Claro','100','Tarjeta para recarga de saldo',1100,'RECARCLARO5000',NULL,NULL,'recarga_claro.jpg','1','Disponible',5000.00,0,NULL,1,6),(91,'Chocolates M&M\'s Peanut 49g','M&M\'s','150','Chocolates con maní',1700,'MMSPEANUT49G',NULL,NULL,'mms_peanut.jpg','49','Disponible',3500.00,0,NULL,1,6),(92,'Gomitas Trululu Aros 90g','Trululu','180','Gomitas azucaradas en forma de aros',1500,'GOMITASAROS',NULL,NULL,'trululu_aros.jpg','90','Disponible',2800.00,0,NULL,1,6),(93,'Empanadas Congeladas x6','N/A','30','Empanadas de carne para freír',800,'EMPANADASCONG',NULL,NULL,'empanadas_cong.jpg','600','Disponible',12000.00,0,NULL,1,6),(94,'Arepas de Maíz Congeladas x5','N/A','40','Arepas listas para asar',900,'AREPASCONGEL',NULL,NULL,'arepas_cong.jpg','500','Disponible',8000.00,0,NULL,1,6),(95,'Salchichas Ranchera x5','Ranchera','60','Salchichas tipo ranchera',1100,'SALCHIRANCHX5',NULL,NULL,'salchichas_ranchera.jpg','250','Disponible',7000.00,0,NULL,1,6),(96,'Queso Campesino El Pastor 250g','El Pastor','45','Queso fresco semiduro',1000,'QUESOCAMPE250',NULL,NULL,'queso_campesino.jpg','250','Disponible',9500.00,0,NULL,1,6),(97,'Yogurt Alpina Descremado Frutos Rojos 1L','Alpina','70','Yogurt light con frutas',1300,'YOGURTALPIFR',NULL,NULL,'yogurt_alpina.jpg','1000','Disponible',6000.00,0,NULL,1,6),(98,'Mantequilla Alpina 250g','Alpina','50','Mantequilla con sal',900,'MANTEQUIALPI',NULL,NULL,'mantequilla_alpina.jpg','250','Disponible',11000.00,0,NULL,1,6),(99,'Pan Integral Artesano Bimbo 400g','Bimbo','70','Pan integral con granos',1000,'PANINTBIMBO',NULL,NULL,'pan_integral_bimbo.jpg','400','Disponible',5000.00,0,NULL,1,6),(100,'Galletas Festival Chocolate','Noel','220','Galletas rellenas de chocolate',2000,'GALLEFESTCHOC',NULL,NULL,'galletas_festival.jpg','100','Disponible',2500.00,0,NULL,1,6),(101,'Agua Cristal 600ml - Oferta','Postobon','100','Agua mineral embotellada en oferta',2000,'AGUACRIS002','2025-06-24','2025-07-01','agua_cristal.jpg','600','Descontinuado',1800.00,10,NULL,3,6),(102,'Gaseosa Coca-Cola 1.5L - Oferta','Coca-Cola','80','Bebida carbonatada refrescante en oferta',3000,'COCACOLA15L2','2025-06-24','2025-07-05','coca_cola.jpg','1500','Disponible',5500.00,15,NULL,3,6),(103,'Arroz Diana 500g - Oferta','Diana','30','Arroz blanco tradicional en oferta',1000,'ARROZDIANA2','2025-06-24','2025-07-10','arroz_diana.jpg','500','Disponible',2800.00,20,NULL,1,6),(104,'Jabón Ariel Polvo 500g - Oferta','Ariel','25','Detergente en polvo para ropa en oferta',2000,'JABONARIEL5002','2025-06-24','2025-07-15','ariel.jpg','500','Disponible',8900.00,25,NULL,2,6),(105,'Aceite Vegetal Doria 1L - Oferta','Doria','15','Aceite de cocina en oferta',800,'ACEITEDORIA1L2','2025-06-24','2025-07-20','aceite_doria.jpg','1000','Disponible',9800.00,30,NULL,1,6),(106,'Café Sello Rojo 125g - Oferta','Sello Rojo','40','Café molido tradicional en oferta',1500,'CAFESELLORJ2','2025-06-24','2025-07-25','cafe_sello_rojo.jpg','125','Disponible',4900.00,12,NULL,1,6),(107,'Azúcar Manuelita 1kg - Oferta','Manuelita','25','Azúcar refinada blanca en oferta',1000,'AZUCARMANU1K2','2025-06-24','2025-07-30','azucar_manuelita.jpg','1000','Descontinuado',3600.00,18,NULL,1,6),(108,'Galletas Ducales Noel 100g - Oferta','Noel','100','Galletas saladas tradicionales en oferta',3000,'GALLEDUCNOEL2','2025-06-24','2025-07-02','galletas_ducales.jpg','100','Disponible',2300.00,10,NULL,1,6),(109,'Jugo Hit Naranja 1L - Oferta','Postobon','60','Jugo pasteurizado sabor naranja en oferta',1900,'JUGOHITNAR1L2','2025-06-24','2025-07-07','jugo_hit.jpg','1000','Disponible',3900.00,22,NULL,3,6),(110,'Salsa de Tomate Fruco 200g - Oferta','Fruco','40','Salsa de tomate clásica en oferta',1200,'SALSATF200G2','2025-06-24','2025-07-12','salsa_fruco.jpg','200','Disponible',2100.00,15,NULL,1,6),(111,'Lentejas Súperpolo 500g - Oferta','Súperpolo','15','Lentejas secas en oferta',700,'LENTEJASUP5002','2025-06-24','2025-07-18','lentejas_superpolo.jpg','500','Disponible',3200.00,20,NULL,1,6),(112,'Detergente Líquido Fab 1L - Oferta','Fab','20','Detergente líquido para ropa en oferta',1800,'DETERGENTEFA2','2025-06-24','2025-07-22','detergente_fab.jpg','1000','Descontinuado',12000.00,25,NULL,2,6),(113,'Desinfectante Lysol Aerosol 300ml - Oferta','Lysol','10','Desinfectante multiusos en oferta',1200,'DESINFECTLYS2','2025-06-24','2025-07-28','lysol.jpg','300','Disponible',10500.00,30,NULL,2,6),(114,'Shampoo Head & Shoulders Control Caspa 180ml - Oferta','Head & Shoulders','20','Shampoo anti-caspa en oferta',1500,'SHAMPOOHDS1802','2025-06-24','2025-07-03','shampoo_hds.jpg','180','Disponible',10500.00,15,NULL,2,6),(115,'Jabón de Tocador Palmolive Suavidad 90g - Oferta','Palmolive','60','Jabón de tocador humectante en oferta',1800,'JABONTOCAPAL2','2025-06-24','2025-07-08','jabon_palmolive.jpg','90','Disponible',2000.00,10,NULL,2,6),(116,'Pilax AA x4 - Oferta','Pilax','25','Pilas alcalinas AA en oferta',900,'PILASAAX42','2025-06-24','2025-07-13','pilas_aa.jpg','80','Disponible',8000.00,20,NULL,2,6),(117,'Cerveza Aguila Lata 330ml - Oferta','Bavaria','50','Cerveza rubia tipo Lager en oferta',2800,'CERVEAGUILA2','2025-06-24','2025-07-19','cerveza_aguila.jpg','330','Disponible',3000.00,10,NULL,3,6),(118,'Ron Viejo de Caldas 3 Años 750ml - Oferta','Industria Licorera de Caldas','5','Ron añejo colombiano en oferta',600,'RONVCCALDAS2','2025-06-24','2025-07-24','ron_viejo_caldas.jpg','750','Disponible',45000.00,15,NULL,3,6),(119,'Compresas Higiénicas Nosotras Invisible x10 - Oferta','Nosotras','30','Toallas sanitarias delgadas en oferta',1500,'COMPRESASNOINV2','2025-06-24','2025-07-04','compresas_nosotras.jpg','50','Disponible',5000.00,10,NULL,2,6),(120,'Queso Campesino El Pastor 250g - Oferta','El Pastor','15','Queso fresco semiduro en oferta',1200,'QUESOCAMPE2502','2025-06-24','2025-07-09','queso_campesino.jpg','250','Disponible',9500.00,15,NULL,1,6),(123,'Antitranspirante','Speed Stick','100','Antitranspirante Xtreme night 48h.',NULL,'NOs',NULL,NULL,NULL,'70','Descontinuado',9000.00,0,NULL,2,6),(124,'Antitranspirante','Speed Stick','99','Antitranspirante en gel Xtreme night 48h.',NULL,'SPEEDXTREME48','2025-07-24','2025-08-08','antitranspirante.jpg','70.0','Disponible',9000.00,10,NULL,2,6),(125,'Crema dental','Colgate','105','Crema dental triple acción de 60ml.',NULL,'COLGATECREMA60',NULL,NULL,NULL,'60.0','Descontinuado',4500.00,0,NULL,1,6),(131,'Alcohol','Mk','1','Alcohol de farmacia, no sé más información porque no tiene etiqueta.',NULL,'JGB100AL',NULL,NULL,'JGB100AL68a81d7b207de.jpg','100','Disponible',1500.00,0,NULL,16,6),(132,'Lápiz Corrector','Marfil','100','Lápiz corrector blanco para papel.',NULL,'MARLAPIZ8',NULL,NULL,'MARLAPIZ868a8239dcb1f7.jpg','0.8','Disponible',1200.00,0,NULL,10,6),(133,'Papel sanitario','Familia','50','Papel sanitario blanco con triple hoja, te acaricia.',NULL,'PASANI100RI',NULL,NULL,'PASANI100RI68a82a2305620.jpg','100','Disponible',3000.00,NULL,NULL,14,6);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `resena`
--

DROP TABLE IF EXISTS `resena`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resena` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `calificacion` int NOT NULL,
  `comentario` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resena`
--

LOCK TABLES `resena` WRITE;
/*!40000 ALTER TABLE `resena` DISABLE KEYS */;
/*!40000 ALTER TABLE `resena` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Dumping events for database 'msmartbuy'
--

--
-- Dumping routines for database 'msmartbuy'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:40
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
-- Table structure for table `soporte`
--

DROP TABLE IF EXISTS `soporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `soporte` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `estado` varchar(45) NOT NULL,
  `solicitante_ID` bigint NOT NULL,
  `asignado_ID` bigint DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `fk_soporte_usuario1_idx` (`solicitante_ID`),
  KEY `fk_soporte_usuario2_idx` (`asignado_ID`),
  CONSTRAINT `fk_soporte_usuario1` FOREIGN KEY (`solicitante_ID`) REFERENCES `usuario` (`ID`),
  CONSTRAINT `fk_soporte_usuario2` FOREIGN KEY (`asignado_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soporte`
--

LOCK TABLES `soporte` WRITE;
/*!40000 ALTER TABLE `soporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `soporte` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-16 20:34:39
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
-- Table structure for table `tarjeta`
--

DROP TABLE IF EXISTS `tarjeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarjeta` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `numero_tarjeta` bigint NOT NULL,
  `fecha_expedicion` date NOT NULL,
  `cvv` int NOT NULL,
  `tipo` varchar(25) NOT NULL,
  `usuario_ID` bigint NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  UNIQUE KEY `numero_tarjeta_UNIQUE` (`numero_tarjeta`),
  KEY `fk_tarjeta_usuario1_idx` (`usuario_ID`),
  CONSTRAINT `fk_tarjeta_usuario1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarjeta`
--

LOCK TABLES `tarjeta` WRITE;
/*!40000 ALTER TABLE `tarjeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarjeta` ENABLE KEYS */;
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
-- Table structure for table `ubicacion`
--

DROP TABLE IF EXISTS `ubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ubicacion` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `pais` varchar(45) DEFAULT NULL,
  `zona` varchar(45) NOT NULL,
  `direccion_local` varchar(150) DEFAULT NULL,
  `codigo_postal` varchar(8) DEFAULT NULL,
  `referencia` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion`
--

LOCK TABLES `ubicacion` WRITE;
/*!40000 ALTER TABLE `ubicacion` DISABLE KEYS */;
INSERT INTO `ubicacion` VALUES (1,NULL,'La Palmita',NULL,NULL,NULL),(2,NULL,'La Palmita',NULL,NULL,NULL),(3,NULL,'La Jagua de Ibirico',NULL,NULL,NULL),(4,NULL,'La Palmita',NULL,NULL,NULL),(5,NULL,'La Jagua de Ibirico',NULL,NULL,NULL);
/*!40000 ALTER TABLE `ubicacion` ENABLE KEYS */;
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
-- Table structure for table `usuario_ubicacion`
--

DROP TABLE IF EXISTS `usuario_ubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_ubicacion` (
  `usuario_ID` bigint NOT NULL,
  `ubicacion_ID` bigint NOT NULL,
  `nombre_identificacion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`usuario_ID`,`ubicacion_ID`),
  KEY `fk_usuario_has_ubicacion_ubicacion1_idx` (`ubicacion_ID`),
  KEY `fk_usuario_has_ubicacion_usuario_idx` (`usuario_ID`),
  CONSTRAINT `fk_usuario_has_ubicacion_ubicacion1` FOREIGN KEY (`ubicacion_ID`) REFERENCES `ubicacion` (`ID`),
  CONSTRAINT `fk_usuario_has_ubicacion_usuario` FOREIGN KEY (`usuario_ID`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_ubicacion`
--

LOCK TABLES `usuario_ubicacion` WRITE;
/*!40000 ALTER TABLE `usuario_ubicacion` DISABLE KEYS */;
INSERT INTO `usuario_ubicacion` VALUES (4,2,NULL),(5,3,NULL),(6,4,NULL),(14,5,NULL);
/*!40000 ALTER TABLE `usuario_ubicacion` ENABLE KEYS */;
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
