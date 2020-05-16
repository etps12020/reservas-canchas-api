-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: reservas_utec
-- ------------------------------------------------------
-- Server version	8.0.19

use reservas_utec;
--
-- Dumping data for table `estado_cancha`
--

LOCK TABLES `estado_cancha` WRITE;
INSERT INTO `estado_cancha` VALUES (1,'Activo'),(2,'Inactivo');
UNLOCK TABLES;

--
-- Dumping data for table `estado_edificio`
--

LOCK TABLES `estado_edificio` WRITE;
INSERT INTO `estado_edificio` VALUES (1,'Disponible'),(2,'Inactivo');
UNLOCK TABLES;

--
-- Dumping data for table `estado_historico`
--

LOCK TABLES `estado_historico` WRITE;
INSERT INTO `estado_historico` VALUES (1,'CREADO'),(2,'RECHAZADO'),(3,'APROBADO'),(4,'Cancelado por Usuario'),(5,'Cancelado por Inasistencia'),(6,'EN CURSO'),(7,'FINALIZADO');
UNLOCK TABLES;

--
-- Dumping data for table `estado_reservacion`
--

LOCK TABLES `estado_reservacion` WRITE;
INSERT INTO `estado_reservacion` VALUES (1,'En espera Aprobacion'),(2,'Rechazada por Demanda'),(3,'APROBADO'),(4,'CANCELADO'),(5,'CANCELADO'),(6,'EN CURSO'),(7,'FINALIZADO');
UNLOCK TABLES;

--
-- Dumping data for table `estado_usuario`
--

LOCK TABLES `estado_usuario` WRITE;
INSERT INTO `estado_usuario` VALUES (1,'Activo'),(2,'Inactivo');
UNLOCK TABLES;

--
-- Dumping data for table `horario_reservacion`
--

LOCK TABLES `horario_reservacion` WRITE;
INSERT INTO `horario_reservacion` VALUES (1,'07:00:00','08:00:00'),(2,'08:00:00','09:00:00'),(3,'09:00:00','10:00:00'),(4,'10:00:00','11:00:00'),(5,'11:00:00','12:00:00'),(6,'12:00:00','13:00:00'),(7,'13:00:00','14:00:00'),(8,'14:00:00','15:00:00'),(9,'15:00:00','16:00:00'),(10,'16:00:00','17:00:00'),(11,'17:00:00','18:00:00');
UNLOCK TABLES;

--
-- Dumping data for table `rol_usuario`
--

LOCK TABLES `rol_usuario` WRITE;
INSERT INTO `rol_usuario` VALUES (1,'admin'),(2,'encargado'),(3,'estudiante');
UNLOCK TABLES;

--
-- Dumping data for table `tipo_cancha`
--

LOCK TABLES `tipo_cancha` WRITE;
INSERT INTO `tipo_cancha` VALUES (1,'basquetbol'),(2,'futbol');
UNLOCK TABLES;

--
-- Dumping data for table `tipo_reservacion`
--

LOCK TABLES `tipo_reservacion` WRITE;
INSERT INTO `tipo_reservacion` VALUES (1,'llamada','reservacion realizada por llamada'),(2,'Ap mobil','reservacion');
UNLOCK TABLES;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
INSERT INTO `usuario` VALUES (1,'Admin','Administrador','00000000-0','0000000000','0000000000@mail.utec.edu.sv','00000000','Admin001',1,1,'2020-04-01 01:12:19');
UNLOCK TABLES;

