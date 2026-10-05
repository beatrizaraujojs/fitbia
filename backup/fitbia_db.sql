-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fitbia_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

SET FOREIGN_KEY_CHECKS = 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
-- /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_adicional`
--

DROP TABLE IF EXISTS `tbl_adicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_adicional` (
  `id_adicional` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo_fk` int(11) NOT NULL,
  `nome_adicional` varchar(50) NOT NULL,
  `preco_adicional` decimal(8,2) DEFAULT 0.00,
  `status_adicional` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_adicional`),
  KEY `fk_adicional_grupo` (`id_grupo_fk`),
  CONSTRAINT `fk_adicional_grupo` FOREIGN KEY (`id_grupo_fk`) REFERENCES `tbl_grupo_adicional` (`id_grupo_adicional`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_adicional`
--

LOCK TABLES `tbl_adicional` WRITE;
/*!40000 ALTER TABLE `tbl_adicional` DISABLE KEYS */;
INSERT INTO `tbl_adicional` VALUES (1,1,'Molho da casa',1.50,'ATIVO','2026-06-03 13:21:45','2026-06-03 13:21:45'),(2,1,'Molho cítrico',1.50,'ATIVO','2026-06-03 13:21:45','2026-06-03 13:21:45'),(3,1,'Molho ceaser',1.50,'ATIVO','2026-06-03 13:21:45','2026-06-03 13:21:45'),(39,4,'Arroz integral',5.00,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(40,4,'Filé de tilápia',18.00,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(41,4,'Tiras de carne',15.00,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(42,4,'Abacate',5.00,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(43,4,'Molho da casa',1.50,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(44,4,'Ovos cozidos',8.00,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(45,4,'Grão de Bico',8.00,'ATIVO','2026-06-03 13:27:52','2026-06-03 13:27:52'),(46,5,'Molho de iogurte',1.50,'ATIVO','2026-06-03 13:31:10','2026-06-03 13:31:10'),(47,5,'Queijo parmesão ralado',3.50,'ATIVO','2026-06-03 13:31:10','2026-06-03 13:31:10'),(48,5,'Crocante de pão integral',2.50,'ATIVO','2026-06-03 13:31:10','2026-06-03 13:31:10'),(49,6,'Camarões grelhados',21.99,'ATIVO','2026-06-03 13:33:48','2026-06-03 13:33:48'),(50,6,'Castanhas',3.99,'ATIVO','2026-06-03 13:33:48','2026-06-03 13:33:48'),(51,6,'Molho cítrico',1.50,'ATIVO','2026-06-03 13:33:48','2026-06-03 13:33:48'),(73,9,'Alface americana',2.50,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(74,9,'Cenoura ralada',2.50,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(75,9,'Macarrão',2.50,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(76,9,'Arroz integral',5.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(77,9,'Filé de frango grelhado',12.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(78,9,'Frango desfiado',10.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(79,9,'Salmão',22.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(80,9,'Filé de tilápia',18.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(81,9,'Abacate',5.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(82,9,'Azeitonas',3.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(83,9,'Camarões grelhados',21.99,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(84,9,'Grão de Bico',8.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(85,9,'Ovos cozidos',8.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(86,9,'Palmito',5.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(87,9,'Queijo mussarela',5.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(88,9,'Repolho branco',5.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(89,9,'Repolho roxo',5.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(90,9,'Tiras de carne',14.99,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(91,9,'Tomate cereja',3.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(92,9,'Brócolis cozido no vapor',9.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(93,9,'Beterraba ralada',3.00,'ATIVO','2026-06-03 13:37:21','2026-06-03 13:37:21'),(94,10,'Molho da casa',1.50,'ATIVO','2026-06-03 13:39:17','2026-06-03 13:39:17'),(95,10,'Molho cítrico',1.50,'ATIVO','2026-06-03 13:39:17','2026-06-03 13:39:17'),(96,10,'Molho ceaser',1.50,'ATIVO','2026-06-03 13:39:17','2026-06-03 13:39:17'),(102,15,'Banana',2.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(103,15,'Morango',2.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(104,15,'Uva',0.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(105,15,'Maça',0.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(106,15,'Melão',2.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(107,16,'Banana',2.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(108,16,'Morango',2.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(109,16,'Uva',0.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(110,16,'Maça',0.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(111,16,'Melão',2.00,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(122,11,'Suco Verde',0.00,'ATIVO','2026-06-16 15:27:54','2026-06-16 15:27:54'),(123,11,'Suco Rosa',0.00,'ATIVO','2026-06-16 15:27:54','2026-06-16 15:27:54'),(124,11,'Suco Laranja',0.00,'ATIVO','2026-06-16 15:27:54','2026-06-16 15:27:54'),(125,11,'Suco Amarelo',0.00,'ATIVO','2026-06-16 15:27:54','2026-06-16 15:27:54'),(126,11,'Suco Branco',0.00,'ATIVO','2026-06-16 15:27:54','2026-06-16 15:27:54'),(128,22,'Banana',2.00,'INATIVO','2026-06-16 15:38:11','2026-06-16 15:57:41'),(129,22,'Morango',1.07,'INATIVO','2026-06-16 15:38:11','2026-06-16 15:57:41'),(130,23,'teste',1.00,'ATIVO','2026-06-24 11:21:35','2026-06-24 11:21:35');
/*!40000 ALTER TABLE `tbl_adicional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_categoria`
--

DROP TABLE IF EXISTS `tbl_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(100) NOT NULL,
  `ordem_exibicao_categoria` int(11) DEFAULT 0,
  `ativa_categoria` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categoria`
--

LOCK TABLES `tbl_categoria` WRITE;
/*!40000 ALTER TABLE `tbl_categoria` DISABLE KEYS */;
INSERT INTO `tbl_categoria` VALUES (1,'Combos',1,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(2,'Marmitas',2,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(3,'Caldos',3,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(4,'Saladas',4,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(5,'Lanches',5,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(6,'Bebidas',6,'ATIVO','2026-05-29 11:55:32','2026-06-15 15:57:50'),(7,'Frutas',7,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(8,'Pratos do dia',8,'ATIVO','2026-05-29 11:55:32','2026-05-29 11:55:32'),(9,'Sobremesas',0,'ATIVO','2026-05-29 14:11:38','2026-05-29 14:11:38'),(10,'Bolos',9,'INATIVO','2026-06-09 15:39:22','2026-06-12 14:02:40'),(11,'Porções',10,'INATIVO','2026-06-09 15:56:37','2026-06-11 17:29:28'),(12,'Teste',11,'INATIVO','2026-06-09 16:04:04','2026-06-09 16:04:04'),(13,'Teste',12,'INATIVO','2026-06-09 16:04:40','2026-06-09 16:04:40'),(14,'Teste',13,'INATIVO','2026-06-09 16:04:49','2026-06-11 17:27:49'),(15,'Teste',20,'INATIVO','2026-06-09 16:21:36','2026-06-11 17:27:52'),(16,'Porções',15,'INATIVO','2026-06-10 14:17:48','2026-06-10 14:17:48'),(17,'teste murilo',20,'INATIVO','2026-06-11 15:23:00','2026-06-15 16:04:13'),(18,'Teste',20,'INATIVO','2026-06-11 17:40:53','2026-06-11 17:41:13'),(19,'Bolo',11,'INATIVO','2026-06-15 15:16:15','2026-06-15 15:16:55'),(20,'petiscos',16,'INATIVO','2026-06-15 15:36:37','2026-06-15 15:36:46'),(21,'bolo',10,'INATIVO','2026-06-16 14:25:55','2026-06-16 15:39:31'),(22,'bolo',15,'INATIVO','2026-06-16 15:38:21','2026-06-16 15:39:34'),(23,'bolo',0,'INATIVO','2026-06-16 15:40:30','2026-06-16 15:40:37'),(24,'teste',0,'INATIVO','2026-06-24 11:21:08','2026-06-25 14:03:59'),(25,'teste murilo',0,'ATIVO','2026-06-29 14:31:30','2026-06-29 14:31:30'),(26,'Teste',0,'ATIVO','2026-06-29 14:33:32','2026-06-29 14:33:32');
/*!40000 ALTER TABLE `tbl_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cliente`
--

DROP TABLE IF EXISTS `tbl_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) NOT NULL,
  `email_cliente` varchar(80) DEFAULT NULL,
  `senha_cliente` varchar(255) DEFAULT NULL,
  `whatsapp_cliente` varchar(20) NOT NULL,
  `cpf_cliente` varchar(14) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `status_cliente` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `whatsapp_cliente` (`whatsapp_cliente`),
  UNIQUE KEY `cpf_cliente` (`cpf_cliente`),
  UNIQUE KEY `email_cliente` (`email_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cliente`
--

LOCK TABLES `tbl_cliente` WRITE;
/*!40000 ALTER TABLE `tbl_cliente` DISABLE KEYS */;
INSERT INTO `tbl_cliente` VALUES (1,'Beatriz Araujo','beatriz20araujo123@gmail.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','11981826719','54327582883','2008-08-20','ATIVO','2026-06-08 14:31:03','2026-06-08 14:31:03'),(2,'Bia',NULL,NULL,'1198186719',NULL,NULL,'ATIVO','2026-06-18 15:06:31','2026-06-18 15:06:31'),(4,'Teste','123@gmail.com','$2y$12$xwTr8nIlw5WdH4Y.ZRKtyuMIDL.bWY.aleGiyzy8f1eS6H.W7jKQ.','1190028922',NULL,NULL,'ATIVO','2026-06-18 15:45:59','2026-06-18 15:45:59'),(5,'Teste 2','123456@gmail.com','$2y$12$gwlwRF0cDmbTOmL3.YjpI.hiqhAfLDUrlXlz3vir8uCnI3XsPKYmO','11999999999',NULL,NULL,'ATIVO','2026-06-18 15:48:33','2026-06-18 15:48:33'),(6,'biabia','789456@gmail.com','$2y$12$AWt9u7u73a96s.34OjlAt.sg8yhapTNus0XU2W/7LjJTYs3gNF622','11900000000',NULL,NULL,'ATIVO','2026-06-18 15:52:26','2026-06-19 12:51:58'),(9,'Leandro','testetests@gmail.com','$2y$12$SG/3652wCXRNlMLRyz6OJubIFhyrx3ekmvEN22xtTPKjPSQ4H3H1e','11986210491',NULL,'2008-08-20','ATIVO','2026-06-18 17:31:00','2026-06-18 17:51:09'),(10,'Murilo','murilo@gmail.com','$2y$12$Eu7aky0kgHj9DH5dgPjeIusT70uktcJvpHa6UrtJbPxwTvBRa31Na','11900000009',NULL,NULL,'ATIVO','2026-06-22 12:19:18','2026-06-22 12:22:50'),(11,'murilo lopes barbosa','heavymetallover1986@gmail.com','$2y$12$3rePj1r73maWpLJX02SqyOKPUYe/rM2hryF.TTUfR9k3IfFryHHDa','11970398344',NULL,NULL,'ATIVO','2026-06-22 14:22:00','2026-06-22 14:22:00'),(12,'Mikael','1111@testemikael','$2y$12$1NiVlwKOPFPAII6qDBhcMub2cuL8ijgqvUGje7JNcNAMaShexe5se','11111111111',NULL,NULL,'ATIVO','2026-06-26 11:39:32','2026-06-26 11:39:32');
/*!40000 ALTER TABLE `tbl_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_configuracao`
--

DROP TABLE IF EXISTS `tbl_configuracao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_configuracao` (
  `id_configuracao` int(11) NOT NULL AUTO_INCREMENT,
  `horario_abertura` time NOT NULL,
  `horario_fechamento` time NOT NULL,
  `valor_minimo_pedido` decimal(8,2) DEFAULT 0.00,
  `loja_aberta_status` enum('ABERTA','FECHADA') DEFAULT 'ABERTA',
  `taxa_entrega_padrao` decimal(8,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_configuracao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_configuracao`
--

LOCK TABLES `tbl_configuracao` WRITE;
/*!40000 ALTER TABLE `tbl_configuracao` DISABLE KEYS */;
INSERT INTO `tbl_configuracao` VALUES (1,'09:00:00','21:00:00',50.00,'ABERTA',0.00,'2026-05-29 12:06:22','2026-05-29 12:06:22');
/*!40000 ALTER TABLE `tbl_configuracao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cupom`
--

DROP TABLE IF EXISTS `tbl_cupom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_cupom` (
  `id_cupom` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_cupom` varchar(20) NOT NULL,
  `porcentagem_desconto` decimal(5,2) NOT NULL,
  `status_cupom` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_cupom`),
  UNIQUE KEY `codigo_cupom` (`codigo_cupom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cupom`
--

LOCK TABLES `tbl_cupom` WRITE;
/*!40000 ALTER TABLE `tbl_cupom` DISABLE KEYS */;
INSERT INTO `tbl_cupom` VALUES (1,'primeiropedido',5.00,'ATIVO','2026-05-29 12:36:19','2026-05-29 12:36:19');
/*!40000 ALTER TABLE `tbl_cupom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_endereco`
--

DROP TABLE IF EXISTS `tbl_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente_fk` int(11) NOT NULL,
  `cep_endereco` varchar(9) DEFAULT NULL,
  `rua_endereco` varchar(100) NOT NULL,
  `numero_endereco` varchar(10) DEFAULT NULL,
  `complemento_endereco` varchar(100) DEFAULT NULL,
  `bairro_endereco` varchar(50) DEFAULT NULL,
  `cidade_endereco` varchar(50) DEFAULT 'São Paulo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_endereco`),
  KEY `fk_endereco_cliente` (`id_cliente_fk`),
  CONSTRAINT `fk_endereco_cliente` FOREIGN KEY (`id_cliente_fk`) REFERENCES `tbl_cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_endereco`
--

LOCK TABLES `tbl_endereco` WRITE;
/*!40000 ALTER TABLE `tbl_endereco` DISABLE KEYS */;
INSERT INTO `tbl_endereco` VALUES (1,2,'08340-510','Rua Pedro Medeiros','13','a','Jardim Vila Carrão','São Paulo','2026-06-18 15:06:31','2026-06-18 15:06:31'),(2,2,'08340-510','Rua Pedro Medeiros','13','','Jardim Vila Carrão','São Paulo','2026-06-18 15:10:25','2026-06-18 15:10:25'),(3,9,'08340510','Rua Pedro de Medeiros13 A casa','2','a','vila carrao','São Paulo','2026-06-18 17:51:26','2026-06-19 14:53:16'),(4,9,'08340510','Rua Pedro de Medeiros13 A casa','2','a','vila carrao','São Paulo','2026-06-19 14:20:32','2026-06-19 14:20:32'),(5,6,'08340-510','Rua Pedro Medeiros','13','a','Jardim Vila Carrão','São Paulo','2026-06-19 14:58:16','2026-06-26 14:10:56'),(6,12,'08340-510','Rua Pedro Medeiros','13',NULL,'Jardim Vila Carrão','São Paulo','2026-06-26 11:42:56','2026-06-26 11:42:56');
/*!40000 ALTER TABLE `tbl_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_grupo_adicional`
--

DROP TABLE IF EXISTS `tbl_grupo_adicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_grupo_adicional` (
  `id_grupo_adicional` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto_fk` int(11) DEFAULT NULL,
  `nome_grupo_adicional` varchar(50) NOT NULL,
  `qtd_min_grupo` int(11) DEFAULT 0,
  `qtd_max_grupo` int(11) DEFAULT 1,
  `status_grupo` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_grupo_adicional`),
  KEY `fk_grupo_produto` (`id_produto_fk`),
  CONSTRAINT `fk_grupo_produto` FOREIGN KEY (`id_produto_fk`) REFERENCES `tbl_produto` (`id_produto`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_grupo_adicional`
--

LOCK TABLES `tbl_grupo_adicional` WRITE;
/*!40000 ALTER TABLE `tbl_grupo_adicional` DISABLE KEYS */;
INSERT INTO `tbl_grupo_adicional` VALUES (1,43,'Molhos',0,3,'ATIVO','2026-06-03 13:21:41','2026-06-03 13:21:41'),(4,44,'Complementos salada Fitbia Power',0,7,'ATIVO','2026-06-03 13:26:26','2026-06-03 13:26:26'),(5,45,'Complementos salada caeser',0,3,'ATIVO','2026-06-03 13:31:05','2026-06-03 13:31:05'),(6,46,'Complementos salada tropical',0,4,'ATIVO','2026-06-03 13:33:44','2026-06-03 13:33:44'),(9,47,'Monte sua salada',1,21,'ATIVO','2026-06-03 13:37:15','2026-06-03 13:37:15'),(10,48,'Molhos',0,3,'ATIVO','2026-06-03 13:39:12','2026-06-03 13:39:12'),(11,82,'Escolha os sucos',5,5,'ATIVO','2026-06-03 13:41:18','2026-06-03 13:41:18'),(12,51,'fondue',1,3,'INATIVO','2026-06-12 16:05:20','2026-06-16 15:23:43'),(13,51,'fondue',1,3,'INATIVO','2026-06-12 16:05:39','2026-06-16 15:23:40'),(14,51,'frutas',0,3,'INATIVO','2026-06-12 17:15:51','2026-06-16 15:23:37'),(15,NULL,'frutas para fondue',0,5,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(16,NULL,'frutas para fondue',0,5,'ATIVO','2026-06-16 14:50:32','2026-06-16 14:50:32'),(22,NULL,'Teste',0,2,'INATIVO','2026-06-16 15:37:43','2026-06-16 15:57:41'),(23,NULL,'teste',1,2,'ATIVO','2026-06-24 11:21:35','2026-06-24 11:21:35');
/*!40000 ALTER TABLE `tbl_grupo_adicional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_pedido`
--

DROP TABLE IF EXISTS `tbl_item_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_item_pedido` (
  `id_item_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido_fk` int(11) NOT NULL,
  `id_produto_fk` int(11) NOT NULL,
  `quantidade_item` int(11) NOT NULL,
  `preco_unitario_item` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_item_pedido`),
  KEY `fk_item_pedido` (`id_pedido_fk`),
  KEY `fk_item_produto` (`id_produto_fk`),
  CONSTRAINT `fk_item_pedido` FOREIGN KEY (`id_pedido_fk`) REFERENCES `tbl_pedido` (`id_pedido`) ON DELETE CASCADE,
  CONSTRAINT `fk_item_produto` FOREIGN KEY (`id_produto_fk`) REFERENCES `tbl_produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_pedido`
--

LOCK TABLES `tbl_item_pedido` WRITE;
/*!40000 ALTER TABLE `tbl_item_pedido` DISABLE KEYS */;
INSERT INTO `tbl_item_pedido` VALUES (1,1,10,1,28.00,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(2,1,83,1,75.00,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(3,1,43,1,32.00,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(4,1,46,1,35.00,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(5,2,44,1,34.00,'2026-06-18 15:10:25','2026-06-18 15:10:25'),(6,2,8,1,28.00,'2026-06-18 15:10:25','2026-06-18 15:10:25'),(7,3,65,2,18.50,'2026-06-19 14:20:32','2026-06-19 14:20:32'),(8,3,67,1,6.00,'2026-06-19 14:20:32','2026-06-19 14:20:32'),(9,4,64,1,5.00,'2026-06-19 14:53:16','2026-06-19 14:53:16'),(10,5,4,1,420.00,'2026-06-19 14:58:57','2026-06-19 14:58:57'),(11,5,1,1,219.00,'2026-06-19 14:58:57','2026-06-19 14:58:57'),(12,6,64,1,5.00,'2026-06-19 12:12:47','2026-06-19 12:12:47'),(13,7,85,1,55.00,'2026-06-19 12:18:08','2026-06-19 12:18:08'),(14,8,2,1,150.00,'2026-06-19 12:20:53','2026-06-19 12:20:53'),(15,9,3,1,150.00,'2026-06-19 12:27:05','2026-06-19 12:27:05'),(16,10,1,1,219.00,'2026-06-19 12:40:24','2026-06-19 12:40:24'),(17,11,3,1,150.00,'2026-06-19 12:46:44','2026-06-19 12:46:44'),(18,12,69,2,5.00,'2026-06-22 13:54:26','2026-06-22 13:54:26'),(19,13,2,1,150.00,'2026-06-22 14:13:49','2026-06-22 14:13:49'),(20,14,4,1,420.00,'2026-06-22 14:19:53','2026-06-22 14:19:53'),(21,15,2,1,150.00,'2026-06-22 14:27:33','2026-06-22 14:27:33'),(22,16,3,1,150.00,'2026-06-22 14:47:26','2026-06-22 14:47:26'),(23,17,4,1,420.00,'2026-06-24 11:17:11','2026-06-24 11:17:11'),(24,18,106,2,50.00,'2026-06-24 11:19:32','2026-06-24 11:19:32'),(25,18,44,1,57.00,'2026-06-24 11:19:32','2026-06-24 11:19:32'),(26,19,117,1,3.00,'2026-06-24 11:22:30','2026-06-24 11:22:30'),(27,20,117,1,3.00,'2026-06-24 11:23:23','2026-06-24 11:23:23'),(28,21,4,1,420.00,'2026-06-24 11:25:32','2026-06-24 11:25:32'),(29,22,117,1,3.00,'2026-06-24 11:28:22','2026-06-24 11:28:22'),(30,23,4,1,420.00,'2026-06-24 12:32:53','2026-06-24 12:32:53'),(31,24,4,1,420.00,'2026-06-24 12:53:14','2026-06-24 12:53:14'),(32,25,64,1,5.00,'2026-06-24 13:30:31','2026-06-24 13:30:31'),(33,26,4,1,420.00,'2026-06-24 13:36:37','2026-06-24 13:36:37'),(34,27,1,1,219.00,'2026-06-25 14:06:43','2026-06-25 14:06:43'),(35,27,2,1,150.00,'2026-06-25 14:06:43','2026-06-25 14:06:43'),(36,27,4,1,420.00,'2026-06-25 14:06:43','2026-06-25 14:06:43'),(37,28,1,1,219.00,'2026-06-25 14:12:10','2026-06-25 14:12:10'),(38,29,2,1,150.00,'2026-06-26 11:48:03','2026-06-26 11:48:03'),(39,30,3,1,150.00,'2026-06-26 12:23:40','2026-06-26 12:23:40'),(40,31,1,1,219.00,'2026-06-26 13:53:59','2026-06-26 13:53:59'),(41,32,1,1,219.00,'2026-06-26 13:54:34','2026-06-26 13:54:34'),(42,33,3,1,150.00,'2026-06-26 13:58:00','2026-06-26 13:58:00'),(43,34,4,1,420.00,'2026-06-26 14:01:45','2026-06-26 14:01:45'),(44,35,3,1,150.00,'2026-06-26 14:02:23','2026-06-26 14:02:23'),(45,36,3,1,150.00,'2026-06-26 14:03:13','2026-06-26 14:03:13'),(46,37,3,1,150.00,'2026-06-26 14:03:43','2026-06-26 14:03:43'),(47,38,3,1,150.00,'2026-06-26 14:04:50','2026-06-26 14:04:50'),(48,39,1,2,219.00,'2026-06-26 14:06:15','2026-06-26 14:06:15'),(49,40,1,1,219.00,'2026-06-26 14:07:50','2026-06-26 14:07:50'),(50,41,4,1,420.00,'2026-06-26 14:09:47','2026-06-26 14:09:47'),(51,42,51,1,25.00,'2026-06-26 14:10:56','2026-06-26 14:10:56'),(52,43,2,1,150.00,'2026-06-26 14:11:43','2026-06-26 14:11:43'),(53,44,2,1,150.00,'2026-06-26 14:14:14','2026-06-26 14:14:14'),(54,45,3,1,150.00,'2026-06-29 14:17:43','2026-06-29 14:17:43'),(55,46,3,1,150.00,'2026-06-29 14:26:37','2026-06-29 14:26:37'),(56,47,3,1,150.00,'2026-06-29 14:35:31','2026-06-29 14:35:31');
/*!40000 ALTER TABLE `tbl_item_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_pedido_adicional`
--

DROP TABLE IF EXISTS `tbl_item_pedido_adicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_item_pedido_adicional` (
  `id_item_add` int(11) NOT NULL AUTO_INCREMENT,
  `id_item_pedido_fk` int(11) NOT NULL,
  `id_adicional_fk` int(11) NOT NULL,
  `preco_cobrado_add` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_item_add`),
  KEY `fk_add_item_pedido` (`id_item_pedido_fk`),
  KEY `fk_add_item_adicional` (`id_adicional_fk`),
  CONSTRAINT `fk_add_item_adicional` FOREIGN KEY (`id_adicional_fk`) REFERENCES `tbl_adicional` (`id_adicional`),
  CONSTRAINT `fk_add_item_pedido` FOREIGN KEY (`id_item_pedido_fk`) REFERENCES `tbl_item_pedido` (`id_item_pedido`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_pedido_adicional`
--

LOCK TABLES `tbl_item_pedido_adicional` WRITE;
/*!40000 ALTER TABLE `tbl_item_pedido_adicional` DISABLE KEYS */;
INSERT INTO `tbl_item_pedido_adicional` VALUES (1,4,49,21.99,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(2,4,50,3.99,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(3,4,51,1.50,'2026-06-18 15:06:31','2026-06-18 15:06:31'),(4,5,43,1.50,'2026-06-18 15:10:25','2026-06-18 15:10:25'),(5,5,44,8.00,'2026-06-18 15:10:25','2026-06-18 15:10:25'),(6,5,45,8.00,'2026-06-18 15:10:25','2026-06-18 15:10:25'),(7,25,39,5.00,'2026-06-24 11:19:32','2026-06-24 11:19:32'),(8,25,40,18.00,'2026-06-24 11:19:32','2026-06-24 11:19:32'),(9,26,130,1.00,'2026-06-24 11:22:30','2026-06-24 11:22:30'),(10,27,130,1.00,'2026-06-24 11:23:23','2026-06-24 11:23:23'),(11,29,130,1.00,'2026-06-24 11:28:22','2026-06-24 11:28:22');
/*!40000 ALTER TABLE `tbl_item_pedido_adicional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pedido`
--

DROP TABLE IF EXISTS `tbl_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente_fk` int(11) NOT NULL,
  `id_endereco_fk` int(11) NOT NULL,
  `id_cupom_fk` int(11) DEFAULT NULL,
  `forma_pagamento_pedido` enum('DINHEIRO','PIX','CARTAO_DEBITO','CARTAO_CREDITO','VALE_REFEICAO') NOT NULL,
  `status_pedido` enum('PENDENTE','PREPARANDO','SAIU PARA ENTREGA','ENTREGUE','CANCELADO') DEFAULT 'PENDENTE',
  `valor_total_pedido` decimal(8,2) NOT NULL,
  `troco_para_pedido` decimal(8,2) DEFAULT 0.00,
  `observacoes_pedido` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_pedido`),
  KEY `fk_pedido_cliente` (`id_cliente_fk`),
  KEY `fk_pedido_endereco` (`id_endereco_fk`),
  KEY `fk_pedido_cupom` (`id_cupom_fk`),
  CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`id_cliente_fk`) REFERENCES `tbl_cliente` (`id_cliente`),
  CONSTRAINT `fk_pedido_cupom` FOREIGN KEY (`id_cupom_fk`) REFERENCES `tbl_cupom` (`id_cupom`),
  CONSTRAINT `fk_pedido_endereco` FOREIGN KEY (`id_endereco_fk`) REFERENCES `tbl_endereco` (`id_endereco`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pedido`
--

LOCK TABLES `tbl_pedido` WRITE;
/*!40000 ALTER TABLE `tbl_pedido` DISABLE KEYS */;
INSERT INTO `tbl_pedido` VALUES (1,2,1,NULL,'DINHEIRO','PENDENTE',198.98,0.00,'','2026-06-18 15:06:31','2026-06-18 15:06:31'),(2,2,2,NULL,'PIX','PENDENTE',87.50,0.00,'','2026-06-18 15:10:25','2026-06-18 15:10:25'),(3,9,4,NULL,'PIX','PENDENTE',43.00,0.00,'','2026-06-19 14:20:32','2026-06-19 14:20:32'),(4,9,3,NULL,'PIX','CANCELADO',5.00,0.00,'','2026-06-19 14:53:16','2026-06-19 13:54:38'),(5,6,5,NULL,'PIX','CANCELADO',639.00,0.00,'','2026-06-19 14:58:57','2026-06-19 13:46:39'),(6,6,5,NULL,'PIX','PENDENTE',5.00,0.00,'','2026-06-19 12:12:47','2026-06-19 12:12:47'),(7,9,3,NULL,'DINHEIRO','PENDENTE',55.00,0.00,'','2026-06-19 12:18:08','2026-06-19 12:18:08'),(8,9,3,NULL,'DINHEIRO','PENDENTE',150.00,0.00,'nao obg','2026-06-19 12:20:53','2026-06-19 12:20:53'),(9,9,3,NULL,'PIX','PENDENTE',150.00,0.00,'','2026-06-19 12:27:05','2026-06-19 12:27:05'),(10,6,5,NULL,'DINHEIRO','ENTREGUE',219.00,0.00,'','2026-06-19 12:40:24','2026-06-22 11:04:33'),(11,6,5,NULL,'PIX','PENDENTE',150.00,0.00,'oi','2026-06-19 12:46:44','2026-06-19 12:46:44'),(12,6,5,NULL,'PIX','PENDENTE',10.00,0.00,'Pedido lançado manualmente pelo Admin.','2026-06-22 13:54:26','2026-06-22 13:54:26'),(13,6,5,NULL,'DINHEIRO','PENDENTE',150.00,0.00,NULL,'2026-06-22 14:13:49','2026-06-22 14:13:49'),(14,6,5,NULL,'DINHEIRO','PENDENTE',420.00,0.00,NULL,'2026-06-22 14:19:53','2026-06-22 14:19:41'),(15,9,3,NULL,'DINHEIRO','ENTREGUE',150.00,0.00,NULL,'2026-06-22 14:27:33','2026-06-22 14:44:34'),(16,9,3,NULL,'DINHEIRO','PENDENTE',150.00,0.00,NULL,'2026-06-22 14:47:26','2026-06-22 14:47:26'),(17,9,3,NULL,'DINHEIRO','PENDENTE',420.00,0.00,NULL,'2026-06-24 11:17:11','2026-06-24 11:17:11'),(18,9,3,NULL,'DINHEIRO','PENDENTE',180.00,0.00,NULL,'2026-06-24 11:19:32','2026-06-24 11:19:32'),(19,9,3,NULL,'DINHEIRO','ENTREGUE',4.00,0.00,NULL,'2026-06-24 11:22:30','2026-06-29 14:30:54'),(20,9,3,NULL,'DINHEIRO','PENDENTE',4.00,0.00,NULL,'2026-06-24 11:23:23','2026-06-24 11:23:23'),(21,9,3,NULL,'DINHEIRO','PENDENTE',420.00,0.00,NULL,'2026-06-24 11:25:32','2026-06-24 11:25:32'),(22,9,3,NULL,'DINHEIRO','PENDENTE',4.00,0.00,NULL,'2026-06-24 11:28:22','2026-06-24 11:28:22'),(23,9,3,NULL,'DINHEIRO','ENTREGUE',420.00,0.00,NULL,'2026-06-24 12:32:53','2026-06-29 14:30:56'),(24,9,3,NULL,'CARTAO_DEBITO','ENTREGUE',420.00,0.00,NULL,'2026-06-24 12:53:14','2026-06-29 14:30:55'),(25,9,3,NULL,'CARTAO_DEBITO','ENTREGUE',5.00,0.00,'Pedido lançado manualmente pelo Admin.','2026-06-24 13:30:31','2026-06-29 14:30:50'),(26,9,3,NULL,'CARTAO_CREDITO','ENTREGUE',420.00,0.00,NULL,'2026-06-24 13:36:37','2026-06-29 14:30:52'),(27,9,3,NULL,'DINHEIRO','ENTREGUE',789.00,0.00,NULL,'2026-06-25 14:06:43','2026-06-29 14:30:49'),(28,9,3,NULL,'CARTAO_CREDITO','ENTREGUE',219.00,0.00,NULL,'2026-06-25 14:12:10','2026-06-29 14:31:34'),(29,12,6,NULL,'CARTAO_CREDITO','ENTREGUE',150.00,0.00,NULL,'2026-06-26 11:48:03','2026-06-29 14:30:48'),(30,12,6,NULL,'CARTAO_CREDITO','ENTREGUE',150.00,0.00,NULL,'2026-06-26 12:23:40','2026-06-29 14:30:45'),(31,6,5,NULL,'CARTAO_DEBITO','ENTREGUE',219.00,0.00,NULL,'2026-06-26 13:53:59','2026-06-29 14:30:43'),(32,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',219.00,0.00,NULL,'2026-06-26 13:54:34','2026-06-29 14:31:00'),(33,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',150.00,0.00,NULL,'2026-06-26 13:58:00','2026-06-29 14:30:22'),(34,6,5,NULL,'CARTAO_CREDITO','PENDENTE',420.00,0.00,NULL,'2026-06-26 14:01:45','2026-06-26 14:01:45'),(35,6,5,NULL,'DINHEIRO','PENDENTE',150.00,0.00,NULL,'2026-06-26 14:02:23','2026-06-26 14:02:23'),(36,6,5,NULL,'DINHEIRO','PENDENTE',150.00,0.00,NULL,'2026-06-26 14:03:13','2026-06-26 14:03:13'),(37,6,5,NULL,'DINHEIRO','PENDENTE',150.00,0.00,NULL,'2026-06-26 14:03:43','2026-06-26 14:03:43'),(38,6,5,NULL,'CARTAO_DEBITO','ENTREGUE',150.00,0.00,NULL,'2026-06-26 14:04:50','2026-06-29 14:30:26'),(39,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',438.00,0.00,NULL,'2026-06-26 14:06:15','2026-06-29 14:30:24'),(40,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',219.00,0.00,NULL,'2026-06-26 14:07:50','2026-06-29 14:30:57'),(41,6,5,NULL,'DINHEIRO','ENTREGUE',420.00,0.00,NULL,'2026-06-26 14:09:47','2026-06-29 14:30:55'),(42,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',25.00,0.00,NULL,'2026-06-26 14:10:56','2026-06-29 14:30:54'),(43,6,5,NULL,'CARTAO_DEBITO','ENTREGUE',150.00,0.00,NULL,'2026-06-26 14:11:43','2026-06-29 14:30:53'),(44,6,5,NULL,'DINHEIRO','ENTREGUE',150.00,0.00,NULL,'2026-06-26 14:14:14','2026-06-29 14:30:52'),(45,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',150.00,0.00,NULL,'2026-06-29 14:17:43','2026-06-29 14:30:50'),(46,6,5,NULL,'CARTAO_CREDITO','ENTREGUE',150.00,0.00,NULL,'2026-06-29 14:26:37','2026-06-29 14:30:48'),(47,6,5,NULL,'DINHEIRO','PENDENTE',150.00,0.00,NULL,'2026-06-29 14:35:31','2026-06-29 14:35:31');
/*!40000 ALTER TABLE `tbl_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_produto`
--

DROP TABLE IF EXISTS `tbl_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria_fk` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `descricao_produto` text DEFAULT NULL,
  `foto_produto` varchar(255) DEFAULT NULL,
  `preco_base_produto` decimal(8,2) NOT NULL,
  `status_produto` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `destaque_produto` enum('SIM','NAO') DEFAULT 'NAO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_produto`),
  KEY `fk_produto_categoria` (`id_categoria_fk`),
  CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`id_categoria_fk`) REFERENCES `tbl_categoria` (`id_categoria`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_produto`
--

LOCK TABLES `tbl_produto` WRITE;
/*!40000 ALTER TABLE `tbl_produto` DISABLE KEYS */;
INSERT INTO `tbl_produto` VALUES (1,1,'Combo Mais Vendidas','Acompanha as seguintes marmitas:\n- Carne moída com legumes, arroz e feijão.\n- Carne desfiada com arroz e legumes.\n- Frango cremoso com arroz e brócolis.\n- Fricassê de frango com batatas assadas.\n- Nhoque.\n- Tiras de carne com arroz e feijão.\n- Escondidinho de carne desfiada com purê de batata.\n- Strogonoff de carne com batatas assadas.','combo_mais_vendidas.png',219.00,'ATIVO','NAO','2026-05-29 12:45:22','2026-05-29 12:45:22'),(2,1,'Combo Low Carb','Acompanha 5 Marmitas:\n\n- Lasanha de abobrinha.\n- Strogonoff de carne com brócolis.\n- Tiras de frango com legumes salteados.\n- Espaguete de cenoura com abobrinha e carne moída.\n- Tilápia assada com brócolis, couve-flor e vagem.\n\nPEDIDO SOB ENCOMENDA PRAZO DE 3 DIAS PARA FABRICAÇÃO.','combo_low_carb.png',150.00,'ATIVO','NAO','2026-05-29 12:48:33','2026-05-29 12:48:33'),(3,1,'Combo Fit','Acompanha 5 Marmitas:\n- Tiras de carne com brócolis, arroz integral e feijão.\n- Filé de tilápia grelhado com arroz integral e legumes.\n- Escondidinho de batata-doce com frango desfiado.\n- Batata-doce assada com carne moída e legumes.\n- Carne desfiada com legumes e arroz integral.\n\nPEDIDO SOB ENCOMENDA PRAZO DE 3 DIAS PARA FABRICAÇÃO.','combo_fit.png',150.00,'ATIVO','NAO','2026-05-29 12:49:51','2026-05-29 12:49:51'),(4,1,'Combo Marmitas 450g','Acompanha as seguintes marmitas:\n- 3x de Carne moída de patinho (200g) + Macarrão (200g), finalizado com 50g de molho de tomate.\n- 3x de Carne de panela de patinho (200g) + Arroz (200g).\n- 3x de Frango desfiado (200g) + Batata-doce cozida (200g).\n- 3x de Frango em cubos grelhado (200g) + Purê de moranga (200g).\n\nPEDIDO SOB ENCOMENDA PRAZO DE 3 DIAS PARA FABRICAÇÃO.','combo_marmitas_450g.png',420.00,'ATIVO','NAO','2026-05-29 12:50:49','2026-05-29 12:50:49'),(5,2,'Fricassê de frango com Batatas assadas','300gr','fricasse_frango_batatas.png',28.00,'ATIVO','NAO','2026-05-29 13:02:23','2026-05-29 13:02:23'),(6,2,'Carne moída arroz e feijão','300gr','carne_moida_arroz_feijao.png',28.00,'ATIVO','NAO','2026-05-29 13:04:18','2026-05-29 13:04:18'),(7,2,'Nhoque espinafre com ricota 350gr','Acompanha molho branco, tiras de alcatra e queijo mussarela ralado.','nhoque_espinafre_ricota.png',32.00,'INATIVO','NAO','2026-05-29 13:05:06','2026-05-29 13:05:06'),(8,2,'Tiras de carne com arroz e feijão','300gr','tiras_carne_arroz_feijao.png',28.00,'ATIVO','NAO','2026-05-29 13:05:40','2026-05-29 13:05:40'),(9,2,'Filé de tilápia arroz e legumes','300gr','file_tilapia_arroz_legumes.png',32.00,'INATIVO','NAO','2026-05-29 13:06:27','2026-05-29 13:06:27'),(10,2,'Kibe recheado com mussarela, arroz e legumes','300gr','kibe_recheado_mussarela_arroz_legumes.png',28.00,'ATIVO','NAO','2026-05-29 13:07:09','2026-05-29 13:07:09'),(11,2,'Parmegiana com arroz primavera.','','parmegiana_arroz_primavera.png',28.00,'ATIVO','NAO','2026-05-29 13:08:54','2026-05-29 13:08:54'),(12,2,'Cubos de frango arroz e feijão','300gr','cubos_frango_arroz_feijao.png',28.00,'ATIVO','NAO','2026-05-29 13:09:33','2026-05-29 13:09:33'),(13,2,'Frango desfiado purê de batata doce e arroz.','300gr','frango_desfiado_pure_batata_doce_arroz.png',28.00,'INATIVO','NAO','2026-05-29 13:09:36','2026-05-29 13:09:36'),(14,2,'Lasanha de berinjela','Berinjela, carne moída, molho de tomate e queijo mussarela.','lasanha_berinjela.png',28.00,'ATIVO','NAO','2026-05-29 13:09:38','2026-05-29 13:09:38'),(15,2,'Macarrão com legumes e carne desfiada','','macarrao_legumes_carne_desfiada.png',28.00,'INATIVO','NAO','2026-05-29 13:12:10','2026-05-29 13:12:10'),(16,2,'Frango com quiabo','','frango_quiabo.png',28.00,'INATIVO','NAO','2026-05-29 13:12:12','2026-05-29 13:12:12'),(17,2,'Sobrecoxa, arroz e legumes','','sobrecoxa_arroz_legumes.png',28.00,'INATIVO','NAO','2026-05-29 13:12:14','2026-05-29 13:12:14'),(18,2,'Nhoque de bacalhau','Nhoque recheado, acompanha molho branco e queijo mussarela.','nhoque_bacalhau.png',32.00,'INATIVO','NAO','2026-05-29 13:12:17','2026-05-29 13:12:17'),(19,2,'Carne moída com legumes arroz e feijão','300gr','carne_moida_legumes_arroz_feijao.png',28.00,'ATIVO','NAO','2026-05-29 13:12:20','2026-05-29 13:12:20'),(20,2,'Lasanha de abobrinha','300gr','lasanha_abobrinha.png',28.00,'INATIVO','NAO','2026-05-29 13:12:22','2026-05-29 13:12:22'),(21,2,'Carne moída com legumes e arroz','300gr','carne_moida_legumes_arroz.png',28.00,'ATIVO','NAO','2026-05-29 13:13:03','2026-05-29 13:13:03'),(22,2,'Escondidinho de carne moída com purê de batata','300gr','escondidinho_carne_moida_pure_batata.png',28.00,'ATIVO','NAO','2026-05-29 13:13:05','2026-05-29 13:13:05'),(23,2,'Escondidinho de carne moída com purê de abóbora','300gr','escondidinho_carne_moida_pure_abobora.png',28.00,'INATIVO','NAO','2026-05-29 13:13:08','2026-05-29 13:13:08'),(24,2,'Escondidinho de frango desfiado com purê de batata','300gr','escondidinho_frango_desfiado_pure_batata.png',28.00,'INATIVO','NAO','2026-05-29 13:13:10','2026-05-29 13:13:10'),(25,2,'Strogonoff de carne com arroz branco','300gr','strogonoff_carne_arroz_branco.png',28.00,'INATIVO','NAO','2026-05-29 13:13:12','2026-05-29 13:13:12'),(26,2,'Strogonoff de carne com batatas assadas','300gr','strogonoff_carne_batatas_assadas.png',28.00,'INATIVO','NAO','2026-05-29 13:14:21','2026-05-29 13:14:21'),(27,2,'Strogonoff de frango com arroz e brócolis','300gr','strogonoff_frango_arroz_brocolis.png',28.00,'ATIVO','NAO','2026-05-29 13:14:22','2026-05-29 13:14:22'),(28,2,'Carne desfiada com arroz e legumes','300gr','carne_desfiada_arroz_legumes.png',28.00,'ATIVO','NAO','2026-05-29 13:14:25','2026-05-29 13:14:25'),(29,2,'Macarrão com carne moída e molho sugo','300gr','macarrao_carne_moida_molho_sugo.png',28.00,'INATIVO','NAO','2026-05-29 13:14:27','2026-05-29 13:14:27'),(30,2,'Panqueca de carne moída com arroz e legumes','300gr','panqueca_carne_moida_arroz_legumes.png',28.00,'ATIVO','NAO','2026-05-29 13:14:32','2026-05-29 13:14:32'),(31,2,'Salmão com batatas assadas e brócolis','300gr','salmao_batatas_assadas_brocolis.png',38.00,'INATIVO','NAO','2026-05-29 13:14:34','2026-05-29 13:14:34'),(32,2,'Arroz, salmão e brócolis','300gr','arroz_salmao_brocolis.png',38.00,'INATIVO','NAO','2026-05-29 13:14:36','2026-05-29 13:14:36'),(33,2,'Cubos de frango com arroz primavera','300gr','cubos_frango_arroz_primavera.png',28.00,'INATIVO','NAO','2026-05-29 13:52:07','2026-05-29 13:52:07'),(34,2,'Frango cremoso com arroz de brócolis','300gr','frango_cremoso_arroz_brocolis.png',28.00,'ATIVO','NAO','2026-05-29 13:52:10','2026-05-29 13:52:10'),(35,2,'Escondidinho de carne desfiada com purê de batata','300gr','escondidinho_carne_desfiada_pure_batata.png',28.00,'ATIVO','NAO','2026-05-29 13:52:12','2026-05-29 13:52:12'),(36,2,'Parmegiana de frango com arroz','300gr','parmegiana_frango_arroz.png',28.00,'INATIVO','NAO','2026-05-29 13:52:15','2026-05-29 13:52:15'),(37,2,'Kibe recheado com mussarela batatas assadas','300gr','kibe_recheado_mussarela_batatas.png',28.00,'ATIVO','NAO','2026-05-29 13:52:17','2026-05-29 13:52:17'),(38,2,'Nhoque de espinafre, mandioquinha e beterraba recheado com mussarela e molho sugo','450gr','nhoque_espinafre_mandioquinha_beterraba.png',32.00,'INATIVO','NAO','2026-05-29 13:52:19','2026-05-29 13:52:19'),(39,3,'Caldo Abóbora com frango desfiado','Creme de abóbora cabotiá super cremoso com bastante frango desfiado e temperos naturais. Nutritivo, leve e perfeito para qualquer momento.','caldo_abobora_frango_desfiado.png',28.00,'ATIVO','NAO','2026-05-29 13:54:20','2026-06-12 14:50:21'),(40,3,'Caldo Abóbora com carne moída','Caldo cremoso de abóbora cabotiá com carne moída refogada na hora. Uma opção leve, nutritiva e cheia de sabor.','caldo_abobora_carne_moida.png',28.00,'ATIVO','NAO','2026-05-29 13:54:23','2026-06-12 14:49:10'),(41,3,'Caldo Caldo verde com carne moída','Unidade','caldo_verde_carne_moida.png',30.00,'ATIVO','NAO','2026-05-29 13:54:25','2026-06-12 15:03:30'),(42,3,'Caldo Caldo de legumes com frango em cubos','Caldo leve e caseiro feito com legumes selecionados (cenoura, batata e mais) e cubos macios de frango grelhado. Saboroso e ideal para uma refeição saudável.','caldo_legumes_frango_cubos.png',28.00,'ATIVO','NAO','2026-05-29 13:54:27','2026-06-12 14:50:41'),(43,4,'Salpicão de Frango - Bowl 500ml','- Repolho roxo\n- Milho\n- Ervilha\n- Cenoura ralada\n- Mix de folhas verdes\n- Frango desfiado','salpicao_frango_bowl.png',32.00,'ATIVO','NAO','2026-05-29 14:01:12','2026-05-29 14:01:12'),(44,4,'Salada FitBia Power','Mix folhasTomate cerejaCenoura raladaProteínaFrango grelhado','salada_fitbia_power.png',34.00,'ATIVO','NAO','2026-05-29 14:01:53','2026-06-16 17:00:27'),(45,4,'Salada ceaser Fit','Base da salada: Alface Americana,Frango grelhado e tomate cereja.','salada_ceaser_fit.png',29.00,'ATIVO','NAO','2026-05-29 14:02:54','2026-05-29 14:02:54'),(46,4,'Salada Tropical Fit','Mix folhasMangaAbacaxiCenouraFrango desfiado','salada_tropical_fit.png',35.00,'ATIVO','NAO','2026-05-29 14:02:56','2026-06-16 17:00:35'),(47,4,'MONTE A SUA SALADA.','Você pode montar a sua salada com as opções do seu gosto.','monte_sua_salada.png',10.00,'ATIVO','NAO','2026-05-29 14:04:02','2026-05-29 14:04:02'),(48,4,'Salada de Atum - Bowl 500ml','* Alface americana\n* Atum\n* Cenoura\n* Brócolis\n* Tomate cereja','salada_atum_bowl.png',28.00,'ATIVO','NAO','2026-05-29 14:04:04','2026-05-29 14:04:04'),(49,4,'Salada de Macarrão - Bowl 500ml','* Macarrão\n* Cenoura ralada\n* Frango desfiado\n* Azeitonas\n* Coentro\n* Tomate cereja','salada_macarrao_bowl.png',28.00,'ATIVO','NAO','2026-05-29 14:04:06','2026-05-29 14:04:06'),(50,5,'Lanche natural com patê de frango','Acompanha alface, tomate, cenoura ralada.','lanche_natural_pate_frango.png',20.00,'ATIVO','NAO','2026-05-29 14:06:10','2026-05-29 14:06:10'),(51,5,'Wrap de frango','Wrap de frango desfiado com requeijão light, acompanha salada.','wrap_frango.png',25.00,'ATIVO','NAO','2026-05-29 14:06:12','2026-05-29 14:06:12'),(53,5,'Crepioca','Crepioca recheada com carne moída ou frango desfiado.','crepioca.png',17.00,'ATIVO','NAO','2026-05-29 14:06:20','2026-05-29 14:06:20'),(54,5,'Cuscuz com carne seca','Cuscuz recheado com carne seca. acompanha carne seca com cebola, queijo coalho e manteiga.','cuscuz_carne_seca.png',47.50,'ATIVO','NAO','2026-05-29 14:07:12','2026-05-29 14:07:12'),(55,9,'Surpresa de uva','Surpresa de uva, doce sem açúcar','surpresa-de-uva_1781267202.png',32.00,'ATIVO','NAO','2026-05-29 14:11:44','2026-06-12 15:26:42'),(56,9,'Bolo de pote sem açúcar','Sabores: prestígio, brigadeiro e chocolate com morango','bolo_pote_sem_acucar.png',25.00,'INATIVO','NAO','2026-05-29 14:11:47','2026-05-29 14:11:47'),(57,5,'Pizza Crossfit','Massa integral, molho de tomate natural, mussarela de búfala, mix de tomate confit e cebola.','pizza_crossfit.png',52.90,'ATIVO','NAO','2026-05-29 14:15:36','2026-05-29 14:15:36'),(58,5,'Pizza Move','Massa integral, molho de tomate natural, atum sólido espinafre, cebola roxa e cream cheese.','pizza_move.png',52.90,'ATIVO','NAO','2026-05-29 14:15:39','2026-05-29 14:15:39'),(59,5,'Pizza No Shape','Massa integral, molho de tomate natural, frango desfiado, creme de ricota e cebola caramelizada.','pizza_no_shape.png',54.90,'ATIVO','NAO','2026-05-29 14:15:41','2026-05-29 14:15:41'),(60,5,'Pizza Strong','Massa integral, molho de tomate natural, rocambole de frango recheado com peito de peru.','pizza_strong.png',56.90,'ATIVO','NAO','2026-05-29 14:15:44','2026-05-29 14:15:44'),(61,5,'Pizza Pump','Massa integral, molho de tomate natural, carne moída temperada, queijo minas frescal, cebola.','pizza_pump.png',57.90,'ATIVO','NAO','2026-05-29 14:15:46','2026-05-29 14:15:46'),(62,7,'Bowl de iogurte com frutas','Granola, mel ou geleia. (Frutas da estação)','bowl_iogurte_frutas.png',28.00,'ATIVO','NAO','2026-05-29 14:15:48','2026-05-29 14:15:48'),(63,5,'Combo café da manhã','Ovos mexidos, iogurte natural com frutas, acompanha suco ou café expresso ou coado.','combo_cafe_da_manha.png',47.50,'ATIVO','NAO','2026-05-29 14:16:17','2026-05-29 14:16:17'),(64,6,'Agua sem gas','','agua_sem_gas.png',5.00,'ATIVO','NAO','2026-05-29 14:36:02','2026-05-29 14:36:02'),(65,6,'Suco Verde - 300ml','Abacaxi, couve e maçã verde','suco_verde_300ml.png',18.50,'ATIVO','NAO','2026-05-29 14:36:05','2026-05-29 14:36:05'),(66,6,'Suco Rosa - 300ml','Melancia, limão e gengibre','suco_rosa_300ml.png',18.50,'ATIVO','NAO','2026-05-29 14:36:07','2026-05-29 14:36:07'),(67,6,'Coca cola zero','','coca_cola_zero.png',6.00,'ATIVO','NAO','2026-05-29 14:36:09','2026-05-29 14:36:09'),(68,6,'Coca cola','','coca_cola.png',6.00,'ATIVO','NAO','2026-05-29 14:36:11','2026-05-29 14:36:11'),(69,6,'Agua com gas','','agua_com_gas.png',5.00,'ATIVO','NAO','2026-05-29 14:37:21','2026-05-29 14:37:21'),(70,6,'Suco Laranja - 300ml','Laranja, cenoura, limão e gengibre','suco_laranja_300ml.png',18.50,'ATIVO','NAO','2026-05-29 14:37:23','2026-05-29 14:37:23'),(71,6,'Cafe expresso simples','','cafe_expresso_simples.png',8.90,'ATIVO','NAO','2026-05-29 14:37:25','2026-05-29 14:37:25'),(72,6,'Café coado','','cafe_coado.png',8.90,'ATIVO','NAO','2026-05-29 14:37:27','2026-05-29 14:37:27'),(73,6,'Suco de laranja','','suco_laranja.png',14.00,'ATIVO','NAO','2026-05-29 14:37:29','2026-05-29 14:37:29'),(74,6,'Limonada suíça','','limonada_suica.png',14.00,'ATIVO','NAO','2026-05-29 14:37:32','2026-05-29 14:37:32'),(75,6,'Suco Melancia','','suco_melancia.png',14.00,'ATIVO','NAO','2026-05-29 14:38:43','2026-05-29 14:38:43'),(76,6,'Suco Maracuja','','suco_maracuja.png',14.00,'ATIVO','NAO','2026-05-29 14:38:46','2026-05-29 14:38:46'),(77,6,'Suco morango','','suco_morango.png',14.00,'ATIVO','NAO','2026-05-29 14:38:48','2026-05-29 14:38:48'),(78,6,'Vitamina de Iogurte','Frutas vermelhas,iogurte natural e mel','vitamina_iogurte.png',18.00,'ATIVO','NAO','2026-05-29 14:38:50','2026-05-29 14:38:50'),(79,6,'Shake de wheyprotein','Wheyprotein,fruta,leite integral ou desnatado ou agua.','shake_wheyprotein.png',25.00,'ATIVO','NAO','2026-05-29 14:38:52','2026-05-29 14:38:52'),(80,6,'Suco Amarelo - 300ml','Manga, laranja e gengibre','suco_amarelo_300ml.png',18.50,'ATIVO','NAO','2026-05-29 14:38:54','2026-05-29 14:38:54'),(81,6,'Suco Branco - 300ml','Melão, maçã, abacaxi e hortelã','suco_branco_300ml.png',18.50,'ATIVO','NAO','2026-05-29 14:40:27','2026-05-29 14:40:27'),(82,6,'Combo Sucos','5 Unidades','combo_sucos.png',90.00,'ATIVO','NAO','2026-05-29 14:40:55','2026-05-29 14:40:55'),(83,7,'Combo de frutas gourmet','10 frutas','combo_frutas_gourmet.png',75.00,'ATIVO','NAO','2026-05-29 14:42:34','2026-05-29 14:42:34'),(84,7,'Salada de frutas com acompanhamentos','Acompanha (granola, mel e iogurte natural)','salada_frutas_acompanhamentos.png',28.00,'ATIVO','NAO','2026-05-29 14:42:36','2026-05-29 14:42:36'),(85,7,'Combo de frutas separadinhas','','combo_frutas_separadinhas.png',55.00,'ATIVO','NAO','2026-05-29 14:42:39','2026-05-29 14:42:39'),(86,8,'Segunda feira','Fricasse+Batatass+Brocolis (Pode trocar as batatas por arroz branco)','segunda_feira.png',60.00,'ATIVO','NAO','2026-05-29 14:44:14','2026-05-29 14:44:14'),(87,8,'Sábado 2','Parmegiana de frango','sabado_2.png',60.00,'ATIVO','NAO','2026-05-29 14:44:16','2026-05-29 14:44:16'),(88,8,'Sábado 1','Feijoada','sabado_1.png',60.00,'ATIVO','NAO','2026-05-29 14:44:18','2026-05-29 14:44:18'),(89,8,'Porção de feijão','','porcao_feijao.png',5.00,'ATIVO','NAO','2026-05-29 14:44:20','2026-05-29 14:44:20'),(90,8,'Terça feira','Panquecas de carne ( Panqueca de carne moída,acompanha arroz e legumes)','terca_feira.png',60.00,'ATIVO','NAO','2026-05-29 14:44:22','2026-05-29 14:44:22'),(91,8,'Quarta-feira','Salmão arroz e legumes.','quarta_feira.png',60.00,'ATIVO','NAO','2026-05-29 14:44:25','2026-05-29 14:44:25'),(92,8,'Quinta feira','Nhoque com molho bolonhesa','quinta_feira.png',60.00,'ATIVO','NAO','2026-05-29 14:44:27','2026-05-29 14:44:27'),(93,8,'Sexta-feira','Filé de tilápia, arroz ou batatas assadas. Acompanha legumes.','sexta_feira.png',60.00,'ATIVO','NAO','2026-05-29 14:44:30','2026-05-29 14:44:30'),(94,10,'teste','Bolos muito bons sabor teste','produto/teste_1781094095.png',10.00,'INATIVO','SIM','2026-06-10 15:21:35','2026-06-11 15:52:50'),(98,10,'Bolo de Chocolate -teste','Bolo muito saboroso sabor teste aaaaaaaaaaa','produto/bolo-de-chocolate-teste_1781099076.png',10.00,'INATIVO','NAO','2026-06-10 16:44:36','2026-06-11 15:49:12'),(99,10,'Bolo de Cenoura','Bolo muito saboroso sabor teste','produto/bolo-de-cenoura_1781099311.png',15.00,'INATIVO','SIM','2026-06-10 16:48:31','2026-06-11 15:49:18'),(100,7,'Jabuticaba','Jabuticaba docinha','produto/jabuticaba_1781176837.png',10.00,'INATIVO','NAO','2026-06-11 14:20:37','2026-06-11 15:52:33'),(101,6,'Agua na gocase','agua gelada','agua-na-gocase_1781177897.png',50.00,'INATIVO','SIM','2026-06-11 14:38:17','2026-06-11 15:50:24'),(102,7,'Jabuticaba','Jabuticaba docinha demais','jabuticaba_1781177968.png',20.00,'ATIVO','NAO','2026-06-11 14:39:28','2026-06-11 14:39:28'),(103,6,'Sprite','Sprite geladinha','sprite_1781180477.png',15.00,'INATIVO','SIM','2026-06-11 15:21:17','2026-06-11 16:28:22'),(104,10,'Bolo de Chocolate','Bolo muito saboroso sabor teste','bolo-de-chocolate_1781181712.png',20.00,'ATIVO','NAO','2026-06-11 15:41:52','2026-06-11 15:41:52'),(105,10,'Brigadeiro','Bolo muito saboroso sabor teste','brigadeiro_1781181763.png',5.00,'INATIVO','NAO','2026-06-11 15:42:43','2026-06-12 14:00:57'),(106,9,'Fondue','Calda quente e cremosa de chocolate acompanhada de morangos frescos, rodelas de banana e marshmallows. A sobremesa perfeita e reconfortante.','fondue_1781266089.png',50.00,'INATIVO','SIM','2026-06-12 15:08:09','2026-06-25 14:20:21'),(107,9,'Surpresa de morango','O doce perfeito para quem não quer sair da rotina saudável. Morangos frescos envoltos em um creme branco cremoso e cobertura de chocolate, tudo feito 100% sem adição de açúcares. Leve, refrescante e muito saboroso!','surpresa-de-morango_1781267296.png',32.00,'ATIVO','NAO','2026-06-12 15:28:16','2026-06-12 15:28:16'),(108,9,'Surpresa de morango','O doce perfeito para quem não quer sair da rotina saudável. Morangos frescos envoltos em um creme branco cremoso e cobertura de chocolate, tudo feito 100% sem adição de açúcares. Leve, refrescante e muito saboroso!','surpresa-de-morango_1781267296.png',32.00,'INATIVO','NAO','2026-06-12 15:28:16','2026-06-12 15:29:48'),(109,9,'Brigadeiro de pistache','Para quem ama um doce fino, mas não abre mão da saúde. Feito com pistache de verdade, textura aveludada e totalmente livre de açúcar. Perfeito para diabéticos, dietas low carb ou para quem busca uma opção mais leve.','brigadeiro-de-pistache_1781267377.png',30.00,'ATIVO','NAO','2026-06-12 15:29:37','2026-06-12 15:29:37'),(110,9,'Bolo de Chocolate','Monte o seu bolo de chocolate','bolo-de-chocolate_1781530026.png',5.00,'INATIVO','SIM','2026-06-15 16:27:06','2026-06-15 17:46:36'),(111,9,'Bolo de Chocolate','Bolo muito saboroso sabor teste222222222222','bolo-de-chocolate_1781533455.png',5.00,'INATIVO','SIM','2026-06-15 17:24:15','2026-06-15 17:46:38'),(112,9,'Bolo de Chocolate teste novo produto','Monte o seu bolo de chocolate','bolo-de-chocolate-teste-novo-produto_1781534698.png',2.00,'INATIVO','SIM','2026-06-15 17:44:58','2026-06-16 15:51:26'),(113,9,'Bolo de Chocolate','Monte o seu bolo de chocolate','bolo-de-chocolate_1781609234.png',10.00,'INATIVO','NAO','2026-06-16 14:27:14','2026-06-25 14:20:28'),(114,9,'Bolo de Chocolate','Monte o seu bolo de chocolate','bolo-de-chocolate_1781610688.png',10.00,'INATIVO','NAO','2026-06-16 14:51:28','2026-06-16 15:51:10'),(115,21,'Bolo de Chocolate','Bolo muito saboroso sabor teste',NULL,10.00,'INATIVO','NAO','2026-06-16 15:38:56','2026-06-16 15:39:11'),(116,9,'Bolo de Chocolate','Bolo muito saboroso sabor teste',NULL,5.00,'INATIVO','NAO','2026-06-19 14:33:56','2026-06-25 14:20:08'),(117,24,'teste','teste cadastro de tudo','teste_1782300132.png',1.00,'ATIVO','NAO','2026-06-24 11:22:12','2026-06-24 11:22:12');
/*!40000 ALTER TABLE `tbl_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_produto_grupo_adicional`
--

DROP TABLE IF EXISTS `tbl_produto_grupo_adicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_produto_grupo_adicional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto_fk` int(11) NOT NULL,
  `id_grupo_adicional_fk` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pivot_produto` (`id_produto_fk`),
  KEY `fk_pivot_grupo` (`id_grupo_adicional_fk`),
  CONSTRAINT `fk_pivot_grupo` FOREIGN KEY (`id_grupo_adicional_fk`) REFERENCES `tbl_grupo_adicional` (`id_grupo_adicional`) ON DELETE CASCADE,
  CONSTRAINT `fk_pivot_produto` FOREIGN KEY (`id_produto_fk`) REFERENCES `tbl_produto` (`id_produto`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_produto_grupo_adicional`
--

LOCK TABLES `tbl_produto_grupo_adicional` WRITE;
/*!40000 ALTER TABLE `tbl_produto_grupo_adicional` DISABLE KEYS */;
INSERT INTO `tbl_produto_grupo_adicional` VALUES (1,111,10,NULL,NULL),(6,112,14,NULL,NULL),(7,111,1,NULL,NULL),(8,111,4,NULL,NULL),(9,111,5,NULL,NULL),(10,111,6,NULL,NULL),(11,111,9,NULL,NULL),(12,111,11,NULL,NULL),(13,110,1,NULL,NULL),(15,113,6,NULL,NULL),(16,113,9,NULL,NULL),(17,113,10,NULL,NULL),(18,114,16,NULL,NULL),(19,82,11,NULL,NULL),(20,115,1,NULL,NULL),(21,47,9,NULL,NULL),(22,45,5,NULL,NULL),(23,44,4,NULL,NULL),(24,46,6,NULL,NULL),(25,117,23,NULL,NULL);
/*!40000 ALTER TABLE `tbl_produto_grupo_adicional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario`
--

DROP TABLE IF EXISTS `tbl_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(80) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `cpf_usuario` varchar(14) DEFAULT NULL,
  `nivel_acesso_usuario` enum('ADMIN','FUNCIONARIO','CLIENTE') DEFAULT 'CLIENTE',
  `status_usuario` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`),
  UNIQUE KEY `cpf_usuario` (`cpf_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'biabia','789456@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'CLIENTE','ATIVO','2026-06-18 15:52:26','2026-09-08 11:42:07'),(2,'Leandro','testetests@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'CLIENTE','ATIVO','2026-06-18 17:31:00','2026-09-08 11:42:07'),(3,'Beatriz Araujo','beatriz20araujo123@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'ADMIN','ATIVO','2026-06-22 11:15:54','2026-09-08 11:42:07'),(4,'Beatriz Barros','barroscorinthias26@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'ADMIN','ATIVO','2026-06-22 11:36:13','2026-09-08 11:42:07'),(5,'Murilo','murilo@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'CLIENTE','ATIVO','2026-06-22 12:19:18','2026-09-08 11:42:07'),(6,'anne','araujoanne322@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'FUNCIONARIO','ATIVO','2026-06-22 12:39:32','2026-09-08 11:42:07'),(7,'murilo lopes barbosa','heavymetallover1986@gmail.com','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'CLIENTE','ATIVO','2026-06-22 14:22:00','2026-09-08 11:42:07'),(8,'Mikael','1111@testemikael','$2y$12$QajSZ/hUlAAYKsUz1qFmU.0kGDIFiTuQXZJ1fhJcYi/XbUlyp50mS',NULL,'CLIENTE','ATIVO','2026-06-26 11:39:32','2026-09-08 11:42:07');
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

SET FOREIGN_KEY_CHECKS = 1;

-- Dump completed on 2026-09-24 10:45:06
