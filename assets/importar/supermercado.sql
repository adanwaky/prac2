--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idCat` int(11) NOT NULL AUTO_INCREMENT,
  `codCat` varchar(45) DEFAULT NULL,
  `nombreCat` varchar(50) DEFAULT NULL,
  `descripcionCat` text,
  `anuncioCat` text,
  `se_muestra` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idCat`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'fru','Frutería','Sección de frutería','Frutería',1),(2,'car','Carnicería','Sección de carnicería','Carnicería',1),(3,'pes','Pescadería','Sección de pescados','Pescadería',1),(4,'beb','Bebidas','Sección de bebidas, refrescos o alcohol.','Bebidas',1),(5,'dro','Droguería','Sección de droguería','Droguería',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `idPed` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) DEFAULT '',
  `importe` decimal(5,2) DEFAULT NULL,
  `user_user` varchar(20) DEFAULT NULL,
  `user_mail` varchar(45) DEFAULT NULL,
  `user_nombreUs` varchar(45) DEFAULT NULL,
  `user_apellidos` varchar(70) DEFAULT NULL,
  `user_direccion` varchar(90) DEFAULT NULL,
  `user_cp` int(11) DEFAULT NULL,
  `user_provincia` int(11) DEFAULT NULL,
  `fecha_ped` date DEFAULT NULL,
  `Usuario_idUsu` int(11) NOT NULL,
  PRIMARY KEY (`idPed`),
  KEY `fk_Pedido_Usuario1_idx` (`Usuario_idUsu`),
  CONSTRAINT `fk_Pedido_Usuario1` FOREIGN KEY (`Usuario_idUsu`) REFERENCES `usuario` (`idUsu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `insertar_fecha` BEFORE INSERT ON `pedido`
 FOR EACH ROW SET NEW.fecha_ped=CURRENT_DATE() */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `idPro` int(11) NOT NULL AUTO_INCREMENT,
  `Categoria_idCat` int(11) NOT NULL,
  `CodPro` varchar(45) DEFAULT NULL,
  `nombrePro` varchar(50) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `imagen` varchar(256) DEFAULT NULL,
  `iva` decimal(5,2) DEFAULT NULL,
  `descripcionPro` text,
  `anuncioPro` text,
  `stock` int(11) DEFAULT NULL,
  `seleccionado` tinyint(1) DEFAULT NULL,
  `fec_ini` date DEFAULT NULL,
  `fec_fin` date DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT NULL,
  `se_muestra` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idPro`),
  KEY `fk_Producto_Categoria1_idx` (`Categoria_idCat`),
  CONSTRAINT `fk_Producto_Categoria1` FOREIGN KEY (`Categoria_idCat`) REFERENCES `categoria` (`idCat`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,1,'ARA','Arándanos',9.88,0.00,'fru/1.jpg',21.00,'Arándanos',NULL,50,1,'2016-01-01','2016-02-15',0,0),(2,1,'CAQ','Caquis',0.58,0.00,'fru/2.jpg',21.00,'Caquis',NULL,50,1,'2016-01-01','2016-02-15',0,1),(3,1,'FRE','Fresas',3.48,0.00,'fru/3.jpg',21.00,'Fresas de Huelva',NULL,0,1,'2016-01-01','2016-02-15',1,1),(4,1,'KIW','Kiwis',0.62,0.00,'fru/4.jpg',21.00,'Kiwis',NULL,50,1,'2016-01-01','2016-02-15',0,1),(5,1,'MAN','Mandarinas',0.25,0.00,'fru/5.jpg',21.00,'Mandarinas naturales de valencia',NULL,50,1,'2016-01-01','2016-02-18',0,1),(6,1,'MAZ','Manzanas',0.73,0.00,'fru/6.jpg',21.00,'Manzanas Royal Gala',NULL,50,1,'2016-01-01','2016-02-15',0,1),(7,1,'MEL','Melocotones',2.39,0.00,'fru/7.jpg',21.00,'Melocotones amarillos fuertes',NULL,50,1,'2016-01-01','2016-02-15',0,1),(8,1,'MLO','Melón',7.07,0.00,'fru/8.jpg',21.00,'Melones de piel de sapo',NULL,50,1,'2016-01-01','2016-02-15',0,1),(9,1,'PER','Peras',0.47,0.00,'fru/9.jpg',21.00,'Peras Conference',NULL,50,1,'2016-01-01','2016-02-15',0,1),(10,1,'PLA','Plátanos',0.44,0.00,'fru/10.jpg',21.00,'Plátanos de Canarias',NULL,50,1,'2016-01-01','2016-02-15',0,1),(11,2,'PLL','Pollo entero',7.00,0.00,'car/1.png',21.00,'Pollo entero certificado limpio. Pieza de 2000g aprox.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(12,2,'PEC','Pechuga de pollo',5.88,0.00,'car/2.png',21.00,'Bandeja de pechugas de pollo entera. 1200g. aprox.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(13,2,'FTE','Filete de ternera',7.45,0.00,'car/3.png',21.00,'Filete de ternera lechal. Bandeja 500g. aprox.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(14,2,'ENT','Entrecot de ternera',11.95,0.00,'car/4.png',21.00,'Entrecot de ternera. Bandeja de 500g. aprox.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(15,2,'COS','Costilla de cerdo',1.49,0.00,'car/5.png',21.00,'Costilla de cerdo a trozos',NULL,50,1,'2016-01-01','2016-02-15',1,1),(16,2,'CLO','Cinta de lomo',4.72,0.00,'car/6.png',21.00,'Cinta de lomo fileteada',NULL,50,1,'2016-01-01','2016-02-15',0,1),(17,2,'PAC','Panceta de cerdo',2.50,0.00,'car/7.png',21.00,'Panceta fina de cerdo',NULL,50,1,'2016-01-01','2016-02-15',0,1),(18,2,'CON','Conejo',5.10,0.00,'car/8.png',21.00,'Conejo entero',NULL,50,1,'2016-01-01','2016-02-15',1,1),(19,2,'CMX','Carne picada',4.65,0.00,'car/9.png',21.00,'Carne picada mixta 1Kg',NULL,50,1,'2016-01-01','2016-02-15',0,1),(20,2,'HAM','Hamburguesa',2.50,0.00,'car/10.png',21.00,'Hamburguesa ibérica 4uds.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(21,3,'PEC','Pescadilla',4.76,0.00,'pes/1.png',21.00,'Pescadilla fina del Cantábrico',NULL,49,1,'2016-01-01','2016-02-15',0,1),(22,3,'FPA','Panga',3.15,0.00,'pes/2.png',21.00,'Filete de panga',NULL,50,1,'2016-01-01','2016-02-15',0,1),(23,3,'DOR','Dorada',3.99,0.00,'pes/3.png',21.00,'Dorada de ración',NULL,50,1,'2016-01-01','2016-02-15',0,1),(24,3,'LUB','Lubina',3.20,0.00,'pes/4.png',21.00,'Lubina de ración',NULL,50,1,'2016-01-01','2016-02-15',0,1),(25,3,'RAP','Rape',19.98,0.00,'pes/5.png',21.00,'Pieza de rape blanco',NULL,50,1,'2016-01-01','2016-02-15',0,1),(26,3,'LEN','Lenguado',3.00,0.00,'pes/6.png',21.00,'Lenguado',NULL,50,1,'2016-01-01','2016-02-15',0,1),(27,3,'CHI','Chipirones',2.80,0.00,'pes/7.png',21.00,'Chipirón 20-25 piezas/kilo',NULL,50,1,'2016-01-01','2016-02-15',0,1),(28,3,'PUL','Pulpo',13.49,0.00,'pes/8.png',21.00,'Pieza de pulpo',NULL,50,1,'2016-01-01','2016-02-15',0,1),(29,3,'LAN','Langostinos',6.00,0.00,'pes/9.png',21.00,'Langostinos gordos frescos 40/60 por kilo',NULL,50,1,'2016-01-01','2016-02-15',0,1),(30,3,'COQ','Coquinas',13.90,0.00,'pes/10.png',21.00,'Coquinas de Huelva',NULL,50,1,'2016-01-01','2016-02-15',1,1),(31,4,'CCL','Coca-Cola',1.41,0.00,'beb/1.png',21.00,'Refresco de Coca-Cola 2L',NULL,50,1,'2016-01-01','2016-02-15',0,1),(32,4,'FNA','Fanta',1.21,0.00,'beb/2.png',21.00,'Refresco de Fanta de Naranja 2L',NULL,50,1,'2016-01-01','2016-02-15',0,1),(33,4,'AAQ','Agua',0.49,0.00,'beb/3.png',21.00,'Agua mineral Aquabona 1,5L',NULL,50,1,'2016-01-01','2016-02-15',0,1),(34,4,'ALJ','Agua',0.53,0.00,'beb/4.png',21.00,'Agua mineral Lanjarón',NULL,50,1,'2016-01-01','2016-02-15',0,1),(35,4,'CCR','Cerveza',1.17,0.00,'beb/5.png',21.00,'Cerveza Cruzcampo 1.1L',NULL,50,1,'2016-01-01','2016-02-15',0,1),(36,4,'CHE','Cerveza',1.59,0.00,'beb/6.png',21.00,'Cerveza Heineken 65cl.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(37,4,'VTR','Vino Tinto',6.55,0.00,'beb/7.png',21.00,'Vino D.O. Rioja tinto reserva Bardesano 75 cl.',NULL,50,1,'2016-01-01','2016-02-15',1,1),(38,4,'VBR','Vino Blanco',3.35,0.00,'beb/8.png',21.00,'Vino D.O. Rioja blanco El Coto 75 cl.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(39,4,'GLA','Ginebra',14.80,0.00,'beb/9.png',21.00,'Ginebra London Dry Larios 1,5 l.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(40,4,'RCQ','Ron',13.95,0.00,'beb/10.png',21.00,'Ron Añejo Natural Cacique 1 l.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(41,5,'LJD','Limpiador',1.55,0.00,'dro/1.png',21.00,'Limpiador con Lejía y Detergente Estrella 1,5 l.',NULL,50,1,'2016-01-01','2016-02-15',1,1),(42,5,'SUA','Suavizante',4.50,NULL,'dro/2.png',21.00,'Suavizante concentrado Rubí y Pétalos de Jazmín Flor 80 lavados.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(43,5,'DET','Detergente',13.65,0.00,'dro/3.png',21.00,'Detergente líquido Active Clean Skip 74 lavados.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(44,5,'LHG','Limpiahogar',2.05,0.00,'dro/4.png',21.00,'Limpia hogar Tenn 1,5 l.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(45,5,'LVL','Lavavajillas',2.48,0.00,'dro/5.png',21.00,'Lavavajillas mano ultra Original Fairy 780 ml.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(46,5,'PHI','Papel Higiénico',1.00,0.00,'dro/6.png',21.00,'Papel higiénico original Scottex 6 rollos',NULL,50,1,'2016-01-01','2016-02-15',0,1),(47,5,'TOA','Toallitas',3.10,0.00,'dro/7.png',21.00,'Papel Higiénico húmedo Sensitive Jumbo Scottex 84 ud.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(48,5,'LEJ','Lejía',1.69,0.00,'dro/8.png',21.00,'Lejía amarilla Conejo 2 l.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(49,5,'AMO','Amoniaco',1.21,0.00,'dro/9.png',21.00,'Amoniaco con detergente perfumado Disiclin 750 ml.',NULL,50,1,'2016-01-01','2016-02-15',0,1),(50,5,'PAL','Papel de aluminio',3.45,0.00,'dro/10.png',21.00,'Papel de aluminio Albal 30 metros.',NULL,50,1,'2016-01-01','2016-02-15',0,1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `idPro` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES (1,'Álava'),(2,'Albacete'),(3,'Alicante'),(4,'Almería'),(5,'Avila'),(6,'Badajoz'),(7,'Balears (Illes)'),(8,'Barcelona'),(9,'Burgos'),(10,'Cáceres'),(11,'Cádiz'),(12,'Castellón'),(13,'Ciudad Real'),(14,'Córdoba'),(15,'Coruña (A)'),(16,'Cuenca'),(17,'Girona'),(18,'Granada'),(19,'Guadalajara'),(20,'Guipzcoa'),(21,'Huelva'),(22,'Huesca'),(23,'Jaén'),(24,'León'),(25,'Lleida'),(26,'Rioja (La)'),(27,'Lugo'),(28,'Madrid'),(29,'Málaga'),(30,'Murcia'),(31,'Navarra'),(32,'Ourense'),(33,'Asturias'),(34,'Palencia'),(35,'Palmas (Las)'),(36,'Pontevedra'),(37,'Salamanca'),(38,'Santa Cruz de Tenerife'),(39,'Cantabria'),(40,'Segovia'),(41,'Sevilla'),(42,'Soria'),(43,'Tarragona'),(44,'Teruel'),(45,'Toledo'),(46,'Valencia'),(47,'Valladolid'),(48,'Vizcaya'),(49,'Zamora'),(50,'Zaragoza'),(51,'Ceuta'),(52,'Melilla');
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsu` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(10) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `nombreUs` varchar(45) DEFAULT NULL,
  `apellidos` varchar(70) DEFAULT NULL,
  `direccion` varchar(90) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `provincias_id` varchar(2) NOT NULL,
  PRIMARY KEY (`idUsu`),
  KEY `fk_Usuario_provincias1_idx` (`provincias_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta` (
  `idCompra` int(11) NOT NULL AUTO_INCREMENT,
  `Producto_idPro` int(11) NOT NULL,
  `Pedido_idPed` int(11) NOT NULL,
  `unidades` decimal(10,0) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL,
  `iva` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idCompra`),
  KEY `fk_Venta_Producto1_idx` (`Producto_idPro`),
  KEY `fk_Venta_Pedido1_idx` (`Pedido_idPed`),
  CONSTRAINT `fk_Venta_Pedido1` FOREIGN KEY (`Pedido_idPed`) REFERENCES `pedido` (`idPed`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Venta_Producto1` FOREIGN KEY (`Producto_idPro`) REFERENCES `producto` (`idPro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-24 12:29:45
