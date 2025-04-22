-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: secundaria93_db
-- ------------------------------------------------------
-- Server version	9.2.0

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
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad` (
  `id_act` int NOT NULL AUTO_INCREMENT,
  `numero_mat` int NOT NULL,
  `rubrica_act` varchar(255) NOT NULL,
  `objetivo_act` varchar(255) NOT NULL,
  `ponderacion_act` float NOT NULL,
  PRIMARY KEY (`id_act`),
  UNIQUE KEY `id_act_UNIQUE` (`id_act`),
  UNIQUE KEY `numero_mat_UNIQUE` (`numero_mat`),
  CONSTRAINT `FK_materia` FOREIGN KEY (`numero_mat`) REFERENCES `materia` (`numero_mat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `id_us` int NOT NULL,
  `nombre_admin` varchar(45) NOT NULL,
  `telefono_admin` varchar(45) NOT NULL,
  PRIMARY KEY (`id_admin`,`id_us`),
  UNIQUE KEY `id_admin_UNIQUE` (`id_admin`),
  UNIQUE KEY `id_us_UNIQUE` (`id_us`),
  CONSTRAINT `FK_usuario` FOREIGN KEY (`id_us`) REFERENCES `usuario` (`id_us`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante` (
  `id_est` int NOT NULL AUTO_INCREMENT,
  `id_us` int NOT NULL,
  `nombre_est` varchar(45) NOT NULL,
  `grado_est` varchar(45) NOT NULL,
  `grupo_est` varchar(45) NOT NULL,
  PRIMARY KEY (`id_est`),
  UNIQUE KEY `id_est_UNIQUE` (`id_est`),
  UNIQUE KEY `id_us_UNIQUE` (`id_us`),
  CONSTRAINT `FK_usuario_estudiante` FOREIGN KEY (`id_us`) REFERENCES `usuario` (`id_us`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imparte`
--

DROP TABLE IF EXISTS `imparte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imparte` (
  `numero_imp` int NOT NULL AUTO_INCREMENT,
  `numero_mat` int NOT NULL,
  `id_mae` int NOT NULL,
  PRIMARY KEY (`numero_imp`),
  UNIQUE KEY `numero_imp_UNIQUE` (`numero_imp`),
  UNIQUE KEY `numero_mat_UNIQUE` (`numero_mat`),
  UNIQUE KEY `id_mae_UNIQUE` (`id_mae`),
  CONSTRAINT `FK_maestro` FOREIGN KEY (`id_mae`) REFERENCES `maestro` (`id_mae`),
  CONSTRAINT `FK_materia_imp` FOREIGN KEY (`numero_mat`) REFERENCES `materia` (`numero_mat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imparte`
--

LOCK TABLES `imparte` WRITE;
/*!40000 ALTER TABLE `imparte` DISABLE KEYS */;
/*!40000 ALTER TABLE `imparte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripción`
--

DROP TABLE IF EXISTS `inscripción`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripción` (
  `id_ins` int NOT NULL AUTO_INCREMENT,
  `id_est` int NOT NULL,
  `numero_mat` int NOT NULL,
  `calificacion_ins` int NOT NULL,
  PRIMARY KEY (`id_ins`),
  UNIQUE KEY `id_ins_UNIQUE` (`id_ins`),
  UNIQUE KEY `id_est_UNIQUE` (`id_est`),
  UNIQUE KEY `numero_mat_UNIQUE` (`numero_mat`),
  CONSTRAINT `FK_estudiante` FOREIGN KEY (`id_est`) REFERENCES `estudiante` (`id_est`),
  CONSTRAINT `FK_materia_ins` FOREIGN KEY (`numero_mat`) REFERENCES `materia` (`numero_mat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripción`
--

LOCK TABLES `inscripción` WRITE;
/*!40000 ALTER TABLE `inscripción` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscripción` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maestro`
--

DROP TABLE IF EXISTS `maestro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maestro` (
  `id_mae` int NOT NULL AUTO_INCREMENT,
  `id_us` int NOT NULL,
  `nombre_mae` varchar(150) NOT NULL,
  `telefono_mae` varchar(45) NOT NULL,
  PRIMARY KEY (`id_mae`),
  UNIQUE KEY `id_mae_UNIQUE` (`id_mae`),
  UNIQUE KEY `id_us_UNIQUE` (`id_us`),
  CONSTRAINT `FK_usuario_maestro` FOREIGN KEY (`id_us`) REFERENCES `usuario` (`id_us`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maestro`
--

LOCK TABLES `maestro` WRITE;
/*!40000 ALTER TABLE `maestro` DISABLE KEYS */;
/*!40000 ALTER TABLE `maestro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materia` (
  `numero_mat` int NOT NULL AUTO_INCREMENT,
  `nombre_mat` varchar(100) NOT NULL,
  PRIMARY KEY (`numero_mat`),
  UNIQUE KEY `numero_mat_UNIQUE` (`numero_mat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia`
--

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;
/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `numero_rol` int NOT NULL,
  `nombre_rol` varchar(45) NOT NULL,
  `Descripción` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`numero_rol`),
  UNIQUE KEY `numero_rol_UNIQUE` (`numero_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarea`
--

DROP TABLE IF EXISTS `tarea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarea` (
  `numero_tar` int NOT NULL AUTO_INCREMENT,
  `id_est` int NOT NULL,
  `numero_act` int NOT NULL,
  `calificación_tar` int NOT NULL,
  `fechain_tar` date NOT NULL,
  `fechafin_tar` date NOT NULL,
  PRIMARY KEY (`numero_tar`),
  UNIQUE KEY `numero_tar_UNIQUE` (`numero_tar`),
  UNIQUE KEY `id_est_UNIQUE` (`id_est`),
  UNIQUE KEY `numero_act_UNIQUE` (`numero_act`),
  CONSTRAINT `FK_actividad` FOREIGN KEY (`numero_act`) REFERENCES `actividad` (`id_act`),
  CONSTRAINT `FK_estudiante_tar` FOREIGN KEY (`id_est`) REFERENCES `estudiante` (`id_est`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarea`
--

LOCK TABLES `tarea` WRITE;
/*!40000 ALTER TABLE `tarea` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_us` int NOT NULL AUTO_INCREMENT,
  `numero_rol` int NOT NULL,
  `email_us` varchar(45) NOT NULL,
  `contraseña_us` varchar(45) NOT NULL,
  `nombre_us` varchar(100) NOT NULL,
  `apellido_us` varchar(100) NOT NULL,
  PRIMARY KEY (`id_us`,`numero_rol`),
  UNIQUE KEY `id_us_UNIQUE` (`id_us`),
  UNIQUE KEY `numero_rol_UNIQUE` (`numero_rol`),
  CONSTRAINT `FK_rol` FOREIGN KEY (`numero_rol`) REFERENCES `rol` (`numero_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
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

-- Dump completed on 2025-04-10  1:41:46
-- Data:
--Tabla Rol
INSERT INTO `rol`(`numero_rol`, `nombre_rol`, `Descripción`) VALUES ('1','Usuario','Rol Usuario');
INSERT INTO `rol`(`numero_rol`, `nombre_rol`, `Descripción`) VALUES ('2','Administrador','Rol Administrador');
INSERT INTO `rol`(`numero_rol`, `nombre_rol`, `Descripción`) VALUES ('3','Estudiante','Rol Estudiante');
INSERT INTO `rol`(`numero_rol`, `nombre_rol`, `Descripción`) VALUES ('4','Maestro','Rol Maestro');

--Tabla Usuario
INSERT INTO `usuario`(`numero_rol`, `email_us`, `contraseña_us`, `nombre_us`, `apellido_us`) VALUES ('1','lmov@hotmail.com','LMOVMMX4','Lorenzo Martin','Olmos Vega');
INSERT INTO `usuario`(`numero_rol`, `email_us`, `contraseña_us`, `nombre_us`, `apellido_us`) VALUES ('2','jvital@hotmail.com','12345678','Julian','Vital');

--Tabla Estudiante
INSERT INTO `estudiante`(`id_us`, `nombre_est`, `grado_est`, `grupo_est`) VALUES ('1','Martin Olmos','2','C');
INSERT INTO `estudiante`(`id_us`, `nombre_est`, `grado_est`, `grupo_est`) VALUES ('2','Julian Vital','1','A');
INSERT INTO `estudiante`(`id_us`, `nombre_est`, `grado_est`, `grupo_est`) VALUES ('1','Ruben Mercado','1','A');
INSERT INTO `estudiante`(`id_us`, `nombre_est`, `grado_est`, `grupo_est`) VALUES ('1','Manuel Lopez','3','B');
INSERT INTO `estudiante`(`id_us`, `nombre_est`, `grado_est`, `grupo_est`) VALUES ('2','Jose Valadez','2','A');