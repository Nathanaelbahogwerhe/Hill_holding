-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: hill_holding_db
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`),
  CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agences`
--

DROP TABLE IF EXISTS `agences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agences_code_unique` (`code`),
  KEY `agences_filiale_id_foreign` (`filiale_id`),
  CONSTRAINT `agences_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agences`
--

LOCK TABLES `agences` WRITE;
/*!40000 ALTER TABLE `agences` DISABLE KEYS */;
INSERT INTO `agences` VALUES (1,'HH-BI-BUJ','Agence Bujumbura','Bujumbura, Burundi','bujumbura@hillholding.bi','+257 111 222 333',NULL,1,'2025-12-02 09:33:12','2025-12-02 09:33:12'),(2,'HH-RW-KIG','Agence Kigali','Kigali, Rwanda','kigali@HillHolding.rw','+250 111 222 333',NULL,2,'2025-12-02 09:33:12','2025-12-02 09:33:12'),(3,'AG-BI-01','Agence Bujumbura','Bujumbura, Burundi','bujumbura@hillholding.bi','+257 111 222 333',NULL,1,'2025-12-02 09:33:14','2025-12-02 09:33:14'),(4,'AG-RW-01','Agence Kigali','Kigali, Rwanda','kigali@HillHolding.rw','+250 111 222 333',NULL,2,'2025-12-02 09:33:14','2025-12-02 09:33:14'),(5,'AG-RDC-01','Agence Kinshasa','Kinshasa, RDC','kinshasa@HillHolding.cd','+243 111 222 333',NULL,3,'2025-12-02 09:33:14','2025-12-02 09:33:14'),(6,'AG-RDC-02','Agence Goma','Goma, RDC','goma@HillHolding.cd','+243 111 222 444',NULL,3,'2025-12-02 09:33:14','2025-12-02 09:33:14');
/*!40000 ALTER TABLE `agences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(15,2) DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `acquisition_date` date DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'Laptop Dell','Informatique',1200.00,10,'2025-06-02','active','Ordinateur portable Dell pour le staff IT','2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,'Imprimante HP','Informatique',350.00,5,'2025-09-02','active','Imprimante laser HP pour le bureau','2025-12-02 09:33:22','2025-12-02 09:33:22'),(3,'Bureau en bois','Mobilier',200.00,15,'2024-12-02','active','Bureau en bois pour les employÃ©s','2025-12-02 09:33:22','2025-12-02 09:33:22'),(4,'Chaise ergonomique','Mobilier',150.00,20,'2024-12-02','active','Chaise ergonomique pour le confort des employÃ©s','2025-12-02 09:33:22','2025-12-02 09:33:22'),(5,'Projecteur Epson','Ã‰quipement audiovisuel',800.00,3,'2025-04-02','active','Projecteur pour les prÃ©sentations en salle de rÃ©union','2025-12-02 09:33:22','2025-12-02 09:33:22'),(6,'Table de confÃ©rence','Mobilier',600.00,2,'2023-12-02','active','Grande table pour les rÃ©unions d\'Ã©quipe','2025-12-02 09:33:22','2025-12-02 09:33:22'),(7,'Serveur NAS Synology','Informatique',1500.00,1,'2025-02-02','active','Serveur de stockage en rÃ©seau pour les donnÃ©es de l\'entreprise','2025-12-02 09:33:22','2025-12-02 09:33:22'),(8,'TÃ©lÃ©phone IP Cisco','TÃ©lÃ©communications',100.00,25,'2025-07-02','active','TÃ©lÃ©phone IP pour les communications internes et externes','2025-12-02 09:33:22','2025-12-02 09:33:22'),(9,'Tablette iPad','Informatique',400.00,8,'2025-08-02','active','Tablette pour les prÃ©sentations mobiles et la prise de notes','2025-12-02 09:33:22','2025-12-02 09:33:22'),(10,'CamÃ©ra de sÃ©curitÃ©','SÃ©curitÃ©',250.00,6,'2025-05-02','active','CamÃ©ra pour la surveillance des locaux','2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_employee_id_foreign` (`employee_id`),
  CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `budgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `budgets_filiale_id_foreign` (`filiale_id`),
  CONSTRAINT `budgets_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budgets`
--

LOCK TABLES `budgets` WRITE;
/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
INSERT INTO `budgets` VALUES (1,'Budget Marketing 2025',10000.00,'Campagnes et publicitÃ©s','2025-01-01 00:00:00','2025-12-31 23:59:59',1,'active','2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,'Budget RH 2025',15000.00,'Salaires et formations','2025-01-01 00:00:00','2025-12-31 23:59:59',1,'active','2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_payments`
--

DROP TABLE IF EXISTS `client_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_payments`
--

LOCK TABLES `client_payments` WRITE;
/*!40000 ALTER TABLE `client_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `agence_id` bigint unsigned DEFAULT NULL,
  `total_due` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_paid` decimal(15,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('prospect','active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'prospect',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_email_unique` (`email`),
  KEY `clients_filiale_id_foreign` (`filiale_id`),
  KEY `clients_agence_id_foreign` (`agence_id`),
  CONSTRAINT `clients_agence_id_foreign` FOREIGN KEY (`agence_id`) REFERENCES `agences` (`id`) ON DELETE CASCADE,
  CONSTRAINT `clients_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Client One','Alice','client1@company.com','+25770000001','Bujumbura, Burundi',3,4,1000.00,500.00,500.00,'active','2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,'Client Two','Bob','client2@company.com','+25770000002','Gitega, Burundi',1,5,2000.00,2000.00,0.00,'active','2025-12-02 09:33:23','2025-12-02 09:33:23'),(3,'Client Three','Charlie','client3@company.com','+25770000003','Ngozi, Burundi',2,2,1500.00,0.00,1500.00,'prospect','2025-12-02 09:33:23','2025-12-02 09:33:23');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departments_filiale_id_foreign` (`filiale_id`),
  CONSTRAINT `departments_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'GÃ©nÃ©ral',NULL,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(2,'HR',1,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(3,'Sales',1,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(4,'Finance',1,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(5,'HR',2,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(6,'Sales',2,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(7,'Finance',2,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(8,'HR',3,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(9,'Sales',3,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(10,'Finance',3,'2025-12-02 09:33:19','2025-12-02 09:33:19');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_insurances`
--

DROP TABLE IF EXISTS `employee_insurances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_insurances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `insurance_plan_id` bigint unsigned NOT NULL,
  `insurance_provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_insurances_employee_id_foreign` (`employee_id`),
  KEY `employee_insurances_insurance_plan_id_foreign` (`insurance_plan_id`),
  CONSTRAINT `employee_insurances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employee_insurances_insurance_plan_id_foreign` FOREIGN KEY (`insurance_plan_id`) REFERENCES `insurance_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_insurances`
--

LOCK TABLES `employee_insurances` WRITE;
/*!40000 ALTER TABLE `employee_insurances` DISABLE KEYS */;
INSERT INTO `employee_insurances` VALUES (1,1,1,'AXA','AXA-001','2025-08-12','2026-08-12','2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,2,2,'Allianz','ALL-002','2025-09-01','2026-09-01','2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `employee_insurances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  `agency_id` bigint unsigned DEFAULT NULL,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_user_id_foreign` (`user_id`),
  KEY `employees_department_id_foreign` (`department_id`),
  KEY `employees_agency_id_foreign` (`agency_id`),
  KEY `employees_filiale_id_foreign` (`filiale_id`),
  CONSTRAINT `employees_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agences` (`id`) ON DELETE SET NULL,
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `employees_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,NULL,'Alice','Niyonzima','alice@hillholding.com',1,NULL,NULL,NULL,0.00,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(2,NULL,'Jean','Habonimana','jean@HillHolding burundi.com',1,NULL,1,NULL,0.00,'2025-12-02 09:33:19','2025-12-02 09:33:19'),(3,NULL,'Eric','Hakizimana','eric@agence bujumbura.com',1,1,1,NULL,0.00,'2025-12-02 09:33:19','2025-12-02 09:33:19');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `status` enum('pending','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `filiale_id` bigint unsigned DEFAULT NULL,
  `agence_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_filiale_id_foreign` (`filiale_id`),
  KEY `expenses_agence_id_foreign` (`agence_id`),
  CONSTRAINT `expenses_agence_id_foreign` FOREIGN KEY (`agence_id`) REFERENCES `agences` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expenses_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,'Achat matÃ©riel bureautique','Achat de papiers, stylos et classeurs',350.00,'2025-11-22','pending',1,1,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,'Frais de dÃ©placement','Transport pour une rÃ©union client',120.50,'2025-11-27','pending',1,1,'2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filiales`
--

DROP TABLE IF EXISTS `filiales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `filiales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filiales_name_unique` (`name`),
  UNIQUE KEY `filiales_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filiales`
--

LOCK TABLES `filiales` WRITE;
/*!40000 ALTER TABLE `filiales` DISABLE KEYS */;
INSERT INTO `filiales` VALUES (1,'HH-BI','HillHolding Burundi','Bujumbura, Burundi','contact@hillholding.bi','+257 123 456 789',NULL,'2025-12-02 09:33:12','2025-12-02 09:33:12'),(2,'HH-RW','HillHolding Rwanda','Kigali, Rwanda','contact@HillHolding.rw','+250 123 456 789',NULL,'2025-12-02 09:33:12','2025-12-02 09:33:12'),(3,'HH-RDC','HillHolding RDC','Kinshasa, RDC','contact@HillHolding.cd','+243 123 456 789',NULL,'2025-12-02 09:33:14','2025-12-02 09:33:14');
/*!40000 ALTER TABLE `filiales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finances`
--

DROP TABLE IF EXISTS `finances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `finances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `finance_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finances`
--

LOCK TABLES `finances` WRITE;
/*!40000 ALTER TABLE `finances` DISABLE KEYS */;
/*!40000 ALTER TABLE `finances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_reports`
--

DROP TABLE IF EXISTS `financial_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `financial_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('monthly','quarterly','yearly','custom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_revenue` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_expense` decimal(15,2) NOT NULL DEFAULT '0.00',
  `net_result` decimal(15,2) NOT NULL DEFAULT '0.00',
  `filiale_id` bigint unsigned DEFAULT NULL,
  `agence_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_reports_filiale_id_foreign` (`filiale_id`),
  KEY `financial_reports_agence_id_foreign` (`agence_id`),
  CONSTRAINT `financial_reports_agence_id_foreign` FOREIGN KEY (`agence_id`) REFERENCES `agences` (`id`) ON DELETE CASCADE,
  CONSTRAINT `financial_reports_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_reports`
--

LOCK TABLES `financial_reports` WRITE;
/*!40000 ALTER TABLE `financial_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `financial_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hill_holdings`
--

DROP TABLE IF EXISTS `hill_holdings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hill_holdings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hill_holdings`
--

LOCK TABLES `hill_holdings` WRITE;
/*!40000 ALTER TABLE `hill_holdings` DISABLE KEYS */;
/*!40000 ALTER TABLE `hill_holdings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance_plans`
--

DROP TABLE IF EXISTS `insurance_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `insurance_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coverage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_fee` decimal(10,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insurance_plans_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance_plans`
--

LOCK TABLES `insurance_plans` WRITE;
/*!40000 ALTER TABLE `insurance_plans` DISABLE KEYS */;
INSERT INTO `insurance_plans` VALUES (1,'Basic Health','50%',20000.00,NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,'Premium Health','80%',50000.00,NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `insurance_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `agency_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_client_id_foreign` (`client_id`),
  KEY `invoices_agency_id_foreign` (`agency_id`),
  KEY `invoices_user_id_foreign` (`user_id`),
  CONSTRAINT `invoices_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agences` (`id`) ON DELETE SET NULL,
  CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,1,NULL,NULL,'INV-1001','2025-12-02',NULL,500.00,'paid','2025-12-02 09:33:23','2025-12-02 09:33:23'),(2,2,NULL,NULL,'INV-1002','2025-12-02',NULL,750.00,'pending','2025-12-02 09:33:23','2025-12-02 09:33:23'),(3,1,NULL,NULL,'INV-SJ2S7D','2025-11-16',NULL,478.00,'paid','2025-12-02 09:33:23','2025-12-02 09:33:23'),(4,2,NULL,NULL,'INV-JV93DT','2025-11-13',NULL,308.00,'pending','2025-12-02 09:33:23','2025-12-02 09:33:23'),(5,3,NULL,NULL,'INV-R8ZJKD','2025-11-26',NULL,240.00,'pending','2025-12-02 09:33:23','2025-12-02 09:33:23');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_types`
--

DROP TABLE IF EXISTS `leave_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leave_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_types`
--

LOCK TABLES `leave_types` WRITE;
/*!40000 ALTER TABLE `leave_types` DISABLE KEYS */;
INSERT INTO `leave_types` VALUES (1,'CongÃ© annuel',21,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(2,'CongÃ© maladie',14,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(3,'CongÃ© maternitÃ©',90,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(4,'CongÃ© paternitÃ©',14,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(5,'CongÃ© sans solde',30,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(6,'CongÃ© formation',15,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(7,'CongÃ© exceptionnel',5,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(8,'CongÃ© de deuil',5,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(9,'CongÃ© sabbatique',60,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(10,'CongÃ© parental',30,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(11,'CongÃ© pour Ã©vÃ©nements familiaux',5,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(12,'CongÃ© pour raisons personnelles',10,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(13,'CongÃ© pour service civique',20,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(14,'CongÃ© pour Ã©tudes',30,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(15,'CongÃ© pour crÃ©ation d\'entreprise',30,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(16,'CongÃ© pour mobilitÃ© internationale',60,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(17,'CongÃ© pour adoption',30,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(18,'CongÃ© pour soins mÃ©dicaux',15,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(19,'CongÃ© pour obligations lÃ©gales',10,'2025-12-02 09:33:21','2025-12-02 09:33:21'),(20,'CongÃ© de circonstances',4,'2025-12-02 09:33:21','2025-12-02 09:33:21');
/*!40000 ALTER TABLE `leave_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `leave_type_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leaves_employee_id_foreign` (`employee_id`),
  KEY `leaves_leave_type_id_foreign` (`leave_type_id`),
  CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaves`
--

LOCK TABLES `leaves` WRITE;
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
INSERT INTO `leaves` VALUES (1,1,1,'2025-12-02','2025-12-23','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(2,1,2,'2025-12-02','2025-12-16','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(3,1,3,'2025-12-02','2026-03-02','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(4,1,4,'2025-12-02','2025-12-16','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(5,1,5,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(6,1,6,'2025-12-02','2025-12-17','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(7,1,7,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(8,1,8,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(9,1,9,'2025-12-02','2026-01-31','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(10,1,10,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(11,1,11,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(12,1,12,'2025-12-02','2025-12-12','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(13,1,13,'2025-12-02','2025-12-22','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(14,1,14,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(15,1,15,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(16,1,16,'2025-12-02','2026-01-31','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(17,1,17,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(18,1,18,'2025-12-02','2025-12-17','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(19,1,19,'2025-12-02','2025-12-12','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(20,1,20,'2025-12-02','2025-12-06','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(21,2,1,'2025-12-02','2025-12-23','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(22,2,2,'2025-12-02','2025-12-16','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(23,2,3,'2025-12-02','2026-03-02','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(24,2,4,'2025-12-02','2025-12-16','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(25,2,5,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(26,2,6,'2025-12-02','2025-12-17','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(27,2,7,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(28,2,8,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(29,2,9,'2025-12-02','2026-01-31','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(30,2,10,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(31,2,11,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(32,2,12,'2025-12-02','2025-12-12','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(33,2,13,'2025-12-02','2025-12-22','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(34,2,14,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(35,2,15,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(36,2,16,'2025-12-02','2026-01-31','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(37,2,17,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(38,2,18,'2025-12-02','2025-12-17','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(39,2,19,'2025-12-02','2025-12-12','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(40,2,20,'2025-12-02','2025-12-06','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(41,3,1,'2025-12-02','2025-12-23','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(42,3,2,'2025-12-02','2025-12-16','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(43,3,3,'2025-12-02','2026-03-02','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(44,3,4,'2025-12-02','2025-12-16','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(45,3,5,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(46,3,6,'2025-12-02','2025-12-17','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(47,3,7,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(48,3,8,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(49,3,9,'2025-12-02','2026-01-31','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(50,3,10,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(51,3,11,'2025-12-02','2025-12-07','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(52,3,12,'2025-12-02','2025-12-12','pending','2025-12-02 09:33:21','2025-12-02 09:33:21'),(53,3,13,'2025-12-02','2025-12-22','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(54,3,14,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(55,3,15,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(56,3,16,'2025-12-02','2026-01-31','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(57,3,17,'2025-12-02','2026-01-01','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(58,3,18,'2025-12-02','2025-12-17','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(59,3,19,'2025-12-02','2025-12-12','pending','2025-12-02 09:33:22','2025-12-02 09:33:22'),(60,3,20,'2025-12-02','2025-12-06','pending','2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `recipient_id` bigint unsigned NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_recipient_id_foreign` (`recipient_id`),
  CONSTRAINT `messages_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,3,'Message de  Ã  ','Bonjour , ceci est un message de .',NULL,0,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(2,2,3,'Message de  Ã  ','Bonjour , ceci est un message de .',NULL,0,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(3,3,1,'Message de  Ã  ','Bonjour , ceci est un message de .',NULL,0,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(4,3,2,'Message de  Ã  ','Bonjour , ceci est un message de .',NULL,0,'2025-12-02 09:33:23','2025-12-02 09:33:23');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_09_02_141024_create_filiales_table',1),(2,'2025_09_02_141039_create_agences_table',1),(3,'2025_09_02_141102_create_departments_table',1),(4,'2025_09_02_141156_create_users_table',1),(5,'2025_09_02_141222_create_employees_table',1),(6,'2025_09_02_141246_create_leave_types_table',1),(7,'2025_09_02_141311_create_leaves_table',1),(8,'2025_09_02_141343_create_payrolls_table',1),(9,'2025_09_02_141404_create_insurance_plans_table',1),(10,'2025_09_02_141423_create_employee_insurances_table',1),(11,'2025_09_02_141443_create_assets_table',1),(12,'2025_09_02_141504_create_transactions_table',1),(13,'2025_09_02_141540_create_messages_table',1),(14,'2025_09_02_141606_create_clients_table',1),(15,'2025_09_02_141644_create_invoices_table',1),(16,'2025_09_02_141722_create_permission_tables',1),(17,'2025_09_02_141758_add_role_to_users_table',1),(18,'2025_09_02_154517_create_cache_table',1),(19,'2025_09_08_130915_create_projects_table',1),(20,'2025_09_08_131040_create_tasks_table',1),(21,'2025_09_10_081857_create_client_payments_table',1),(22,'2025_09_10_115316_create_financial_reports_table',1),(23,'2025_09_11_085329_create_attendances_table',1),(24,'2025_09_11_154441_create_expenses_table',1),(25,'2025_09_12_080653_create_revenues_table',1),(26,'2025_09_12_092202_create_budgets_table',1),(27,'2025_09_12_143020_create_products_table',1),(28,'2025_09_12_145044_create_locations_table',1),(29,'2025_09_12_145055_create_stock_transfers_table',1),(30,'2025_09_12_180512_add_quantity_to_assets_table',2),(31,'2025_09_12_180758_add_filiale_id_to_transactions_table',2),(32,'2025_09_13_080822_create_finances_table',2),(33,'2025_09_13_090422_add_email_verified_at_to_users_table',2),(34,'2025_09_13_115008_add_agence_id_to_employees_table',2),(35,'2025_09_16_070837_create_hill_holdings_table',2),(36,'2025_09_16_071143_add_hill_holding_id_to_users_table',2),(37,'2025_09_16_104137_add_logo_to_filiales_table',2),(38,'2025_09_16_104148_add_logo_to_agences_table',2),(39,'2025_09_16_111402_update_users_table_for_roles_and_relations',2),(40,'2025_09_27_105123_add_avatar_to_users_table',2),(41,'2025_09_27_150105_create_activities_table',2),(42,'2025_10_13_090607_create_positions_table',2),(43,'2025_10_23_130403_create_sessions_table',2),(44,'2025_10_25_170831_add_attachment_to_messages_table',2),(45,'2025_11_13_113746_create_notifications_table',2),(46,'2025_11_13_124843_add_code_to_filiales_table',2),(47,'2025_11_13_125814_add_details_to_filiales_table',2),(48,'2025_11_13_131155_add_code_to_agences_table',2),(49,'2025_11_13_131558_add_columns_to_agences_table',2),(50,'2025_11_13_132259_fix_agences_columns_table',2),(51,'2025_11_13_073023_rename_custom_notifications_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3),(4,'App\\Models\\User',4),(5,'App\\Models\\User',5),(1,'App\\Models\\User',6),(6,'App\\Models\\User',7),(3,'App\\Models\\User',8),(4,'App\\Models\\User',9),(5,'App\\Models\\User',10),(6,'App\\Models\\User',11),(3,'App\\Models\\User',12),(4,'App\\Models\\User',13),(5,'App\\Models\\User',14),(6,'App\\Models\\User',15),(3,'App\\Models\\User',16),(4,'App\\Models\\User',17),(5,'App\\Models\\User',18),(6,'App\\Models\\User',19),(3,'App\\Models\\User',20),(4,'App\\Models\\User',21),(5,'App\\Models\\User',22),(6,'App\\Models\\User',23),(3,'App\\Models\\User',24),(4,'App\\Models\\User',25),(5,'App\\Models\\User',26),(5,'App\\Models\\User',27),(5,'App\\Models\\User',28),(5,'App\\Models\\User',29),(5,'App\\Models\\User',30),(5,'App\\Models\\User',31);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payrolls`
--

DROP TABLE IF EXISTS `payrolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payrolls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `month` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deductions` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_salary` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payrolls_employee_id_foreign` (`employee_id`),
  CONSTRAINT `payrolls_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payrolls`
--

LOCK TABLES `payrolls` WRITE;
/*!40000 ALTER TABLE `payrolls` DISABLE KEYS */;
INSERT INTO `payrolls` VALUES (1,1,'2025-12',492616.00,128364.00,50489.00,570491.00,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,2,'2025-12',424850.00,121322.00,33396.00,512776.00,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(3,3,'2025-12',407270.00,22519.00,85368.00,344421.00,'2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `payrolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view employees','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(2,'create employees','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(3,'edit employees','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(4,'delete employees','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(5,'view departments','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(6,'create departments','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(7,'edit departments','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(8,'delete departments','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(9,'view leaves','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(10,'create leaves','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(11,'edit leaves','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(12,'delete leaves','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(13,'approve leaves','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(14,'reject leaves','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(15,'view payrolls','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(16,'generate payrolls','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(17,'edit payrolls','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(18,'view transactions','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(19,'create transactions','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(20,'edit transactions','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(21,'delete transactions','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(22,'view expenses','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(23,'create expenses','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(24,'edit expenses','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(25,'delete expenses','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(26,'view revenues','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(27,'create revenues','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(28,'edit revenues','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(29,'delete revenues','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(30,'view budgets','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(31,'create budgets','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(32,'edit budgets','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(33,'delete budgets','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(34,'view financial reports','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(35,'generate reports','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(36,'view clients','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(37,'create clients','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(38,'edit clients','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(39,'delete clients','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(40,'view projects','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(41,'create projects','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(42,'edit projects','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(43,'delete projects','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(44,'view tasks','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(45,'create tasks','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(46,'edit tasks','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(47,'delete tasks','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(48,'view contracts','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(49,'create contracts','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(50,'edit contracts','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(51,'delete contracts','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(52,'view assets','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(53,'edit settings','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(54,'view notifications','web','2025-12-02 09:33:13','2025-12-02 09:33:13'),(55,'mark notifications as read','web','2025-12-02 09:33:13','2025-12-02 09:33:13');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `positions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','in_progress','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_created_by_foreign` (`created_by`),
  CONSTRAINT `projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Site web corporate','DÃ©veloppement du nouveau site HillHolding','in_progress',NULL,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(2,'Application mobile','App mobile pour les employÃ©s','pending',NULL,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(3,'Migration serveur','Migration vers serveur cloud','completed',NULL,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(4,'Campagne marketing','Campagne digitale pour filiales','in_progress',NULL,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(5,'Audit interne','Audit complet des dÃ©partements','pending',NULL,'2025-12-02 09:33:23','2025-12-02 09:33:23');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenues`
--

DROP TABLE IF EXISTS `revenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date` datetime NOT NULL,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `agence_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revenues_filiale_id_foreign` (`filiale_id`),
  KEY `revenues_agence_id_foreign` (`agence_id`),
  CONSTRAINT `revenues_agence_id_foreign` FOREIGN KEY (`agence_id`) REFERENCES `agences` (`id`) ON DELETE CASCADE,
  CONSTRAINT `revenues_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenues`
--

LOCK TABLES `revenues` WRITE;
/*!40000 ALTER TABLE `revenues` DISABLE KEYS */;
INSERT INTO `revenues` VALUES (1,'Vente produit A',1500.00,'Vente de produits au client X','2025-11-22 10:33:22',1,1,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,'Service de consulting',800.00,'Consulting IT pour le client Y','2025-11-27 10:33:22',1,1,'2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `revenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(54,2),(55,2),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),(25,3),(26,3),(27,3),(28,3),(29,3),(30,3),(31,3),(32,3),(33,3),(34,3),(35,3),(54,3),(55,3),(36,4),(37,4),(38,4),(39,4),(40,4),(41,4),(42,4),(43,4),(44,4),(45,4),(46,4),(47,4),(48,4),(49,4),(50,4),(51,4),(54,4),(55,4),(1,5),(9,5),(10,5),(15,5),(54,5),(55,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(2,'HR Manager','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(3,'Finance Manager','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(4,'Operations Manager','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(5,'Employee','web','2025-12-02 09:33:12','2025-12-02 09:33:12'),(6,'RH Manager','web','2025-12-02 09:33:14','2025-12-02 09:33:14');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_transfers`
--

DROP TABLE IF EXISTS `stock_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_transfers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_transfers`
--

LOCK TABLES `stock_transfers` WRITE;
/*!40000 ALTER TABLE `stock_transfers` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('todo','doing','done') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'todo',
  `due_date` date DEFAULT NULL,
  `project_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_project_id_foreign` (`project_id`),
  KEY `tasks_employee_id_foreign` (`employee_id`),
  CONSTRAINT `tasks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'TÃ¢che 1 pour Site web corporate','Description de la tÃ¢che 1 du projet Site web corporate','doing','2025-12-05',1,3,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(2,'TÃ¢che 2 pour Site web corporate','Description de la tÃ¢che 2 du projet Site web corporate','done','2025-12-19',1,2,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(3,'TÃ¢che 3 pour Site web corporate','Description de la tÃ¢che 3 du projet Site web corporate','done','2025-12-24',1,1,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(4,'TÃ¢che 1 pour Application mobile','Description de la tÃ¢che 1 du projet Application mobile','doing','2025-12-21',2,2,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(5,'TÃ¢che 2 pour Application mobile','Description de la tÃ¢che 2 du projet Application mobile','todo','2025-12-27',2,3,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(6,'TÃ¢che 3 pour Application mobile','Description de la tÃ¢che 3 du projet Application mobile','doing','2025-12-29',2,1,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(7,'TÃ¢che 1 pour Migration serveur','Description de la tÃ¢che 1 du projet Migration serveur','todo','2025-12-16',3,3,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(8,'TÃ¢che 2 pour Migration serveur','Description de la tÃ¢che 2 du projet Migration serveur','doing','2025-12-22',3,2,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(9,'TÃ¢che 3 pour Migration serveur','Description de la tÃ¢che 3 du projet Migration serveur','todo','2025-12-28',3,2,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(10,'TÃ¢che 1 pour Campagne marketing','Description de la tÃ¢che 1 du projet Campagne marketing','todo','2025-12-12',4,2,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(11,'TÃ¢che 2 pour Campagne marketing','Description de la tÃ¢che 2 du projet Campagne marketing','doing','2025-12-05',4,2,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(12,'TÃ¢che 3 pour Campagne marketing','Description de la tÃ¢che 3 du projet Campagne marketing','done','2025-12-12',4,3,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(13,'TÃ¢che 1 pour Audit interne','Description de la tÃ¢che 1 du projet Audit interne','done','2025-12-05',5,3,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(14,'TÃ¢che 2 pour Audit interne','Description de la tÃ¢che 2 du projet Audit interne','done','2025-12-13',5,1,'2025-12-02 09:33:23','2025-12-02 09:33:23'),(15,'TÃ¢che 3 pour Audit interne','Description de la tÃ¢che 3 du projet Audit interne','doing','2025-12-04',5,2,'2025-12-02 09:33:23','2025-12-02 09:33:23');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('income','expense','transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_reference_unique` (`reference`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_filiale_id_foreign` (`filiale_id`),
  CONSTRAINT `transactions_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,'HCCV4FTK3X','income',186627.00,'2025-11-23',NULL,'Transaction example 0',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(2,1,'2OBTNCMNTA','expense',184490.00,'2025-11-24',NULL,'Transaction example 1',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(3,1,'DLUUPZWKA2','income',24405.00,'2025-11-26',NULL,'Transaction example 2',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(4,1,'NBAQI98QYX','expense',196307.00,'2025-11-28',NULL,'Transaction example 3',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(5,1,'PIM6TYE9PB','income',51929.00,'2025-11-09',NULL,'Transaction example 4',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(6,1,'KBA8PE5MMW','expense',469232.00,'2025-11-22',NULL,'Transaction example 5',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(7,1,'5ESWNEHCPF','income',240073.00,'2025-11-19',NULL,'Transaction example 6',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(8,1,'XTJD72TIPF','expense',270236.00,'2025-11-21',NULL,'Transaction example 7',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(9,1,'TP6XMAGCCN','income',246063.00,'2025-11-16',NULL,'Transaction example 8',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22'),(10,1,'LZEOZ8JXGR','expense',124391.00,'2025-11-10',NULL,'Transaction example 9',NULL,'2025-12-02 09:33:22','2025-12-02 09:33:22');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `filiale_id` bigint unsigned DEFAULT NULL,
  `agence_id` bigint unsigned DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency_id` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `hill_holding_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_filiale_id_foreign` (`filiale_id`),
  KEY `users_agency_id_foreign` (`agency_id`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_hill_holding_id_foreign` (`hill_holding_id`),
  KEY `users_agence_id_foreign` (`agence_id`),
  CONSTRAINT `users_agence_id_foreign` FOREIGN KEY (`agence_id`) REFERENCES `agences` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agences` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_filiale_id_foreign` FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_hill_holding_id_foreign` FOREIGN KEY (`hill_holding_id`) REFERENCES `hill_holdings` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@hillholding.bi',NULL,'$2y$12$o5iffOlyr2Dsod8nHDlzO.P4TUs19wC9ukkFyv5M2tzpY6/0n9dRW','user',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-02 09:33:13','2025-12-02 09:33:13',NULL,NULL),(2,'HR Manager','hr@hillholding.bi',NULL,'$2y$12$D05SCyB.ElDHh2VKFOQK/uQio/p7C9/TX5IHSW.qrj/iGPgkBbPrO','user',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-02 09:33:14','2025-12-02 09:33:14',NULL,NULL),(3,'Finance Manager','finance@hillholding.bi',NULL,'$2y$12$N7VIqpRkn5FJIDk2U5g97uz4FrJuBi2m7hU9UGjj1xfQ/7TWPy5/G','user',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-02 09:33:14','2025-12-02 09:33:14',NULL,NULL),(4,'Operations Manager','ops@hillholding.bi',NULL,'$2y$12$5PuEKLABjKHChq.AP1y60uaz3XkB2bKbUyy684f2W7vF6XUsf1d2C','user',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-02 09:33:14','2025-12-02 09:33:14',NULL,NULL),(5,'Employee User','employee@hillholding.bi',NULL,'$2y$12$rwJT9eKc5t5GxP62lgS6SOX1LlzTe4J.eQzt0X0xxVl0bRKTdLg9m','user',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-02 09:33:14','2025-12-02 09:33:14',NULL,NULL),(6,'Super Admin','admin@hillholding.com',NULL,'$2y$12$rFijnIdNvzjhnKNfyas9AuUgsggFwIlRB9GVCWKmujo.Z6JlHeiRK','user',NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-02 09:33:15','2025-12-02 09:33:18',NULL,NULL),(7,'RH Agence Bujumbura','rh.AG-BI-01@hillholding.com',NULL,'$2y$12$leGhqMRJv2PnX2N2zpWgVu8EOY4ygwlWBZ9KOFH39ol7PGdEwqS0q','user',NULL,1,3,NULL,NULL,NULL,'2025-12-02 09:33:15','2025-12-02 09:33:15',NULL,NULL),(8,'Finance Agence Bujumbura','finance.AG-BI-01@hillholding.com',NULL,'$2y$12$ST8LhZCqNK457nM2sWix4uXpHUluCaIME2wu02.NIeBWl1nMpgiHa','user',NULL,1,3,NULL,NULL,NULL,'2025-12-02 09:33:15','2025-12-02 09:33:15',NULL,NULL),(9,'Ops Agence Bujumbura','ops.AG-BI-01@hillholding.com',NULL,'$2y$12$ydC2lap7POMouBZHIt1j2.0TBBNw4FD28TUmjy3qES5WNwsPw5VJ.','user',NULL,1,3,NULL,NULL,NULL,'2025-12-02 09:33:15','2025-12-02 09:33:15',NULL,NULL),(10,'Employee Agence Bujumbura','employee.AG-BI-01@hillholding.com',NULL,'$2y$12$qH63Pr6osf5gpT7DoY8Eh.dD8qdvUoUNZv3n1PLFSDtoShnhZ5HvK','user',NULL,1,3,NULL,NULL,NULL,'2025-12-02 09:33:15','2025-12-02 09:33:15',NULL,NULL),(11,'RH Agence Kigali','rh.AG-RW-01@hillholding.com',NULL,'$2y$12$nSfh2nHIxgXJcKDl.PLHTufGm8XSDY0DLoMJLa6FGcniioBBdMVge','user',NULL,2,4,NULL,NULL,NULL,'2025-12-02 09:33:16','2025-12-02 09:33:16',NULL,NULL),(12,'Finance Agence Kigali','finance.AG-RW-01@hillholding.com',NULL,'$2y$12$.5XPdY1cp3vFpwg2n0lS5efJXdcwTCVr8Vbv4urCi8Iu/yCZ671X6','user',NULL,2,4,NULL,NULL,NULL,'2025-12-02 09:33:16','2025-12-02 09:33:16',NULL,NULL),(13,'Ops Agence Kigali','ops.AG-RW-01@hillholding.com',NULL,'$2y$12$pJ2VEzYdvzBOOmiHpAELa.SrW3kZNNPbfwj3GQG0WVQSdNEzh3DiK','user',NULL,2,4,NULL,NULL,NULL,'2025-12-02 09:33:16','2025-12-02 09:33:16',NULL,NULL),(14,'Employee Agence Kigali','employee.AG-RW-01@hillholding.com',NULL,'$2y$12$PP0UTvwo7ge7toqse5D9hObjAgqWMaYj4kUk2W8ulX7pWeIFnL4WO','user',NULL,2,4,NULL,NULL,NULL,'2025-12-02 09:33:16','2025-12-02 09:33:16',NULL,NULL),(15,'RH Agence Kinshasa','rh.AG-RDC-01@hillholding.com',NULL,'$2y$12$mmocXkaMbUBBov4MU2H7aOuVPgGfan9cLD0oUlpOj1e9DLzQa1PVK','user',NULL,3,5,NULL,NULL,NULL,'2025-12-02 09:33:17','2025-12-02 09:33:17',NULL,NULL),(16,'Finance Agence Kinshasa','finance.AG-RDC-01@hillholding.com',NULL,'$2y$12$hNx4S2DWFTqURkFrMN7wZ.UuJ8KgQ5T6ahu547Zq4vtp7.D8KRxpK','user',NULL,3,5,NULL,NULL,NULL,'2025-12-02 09:33:17','2025-12-02 09:33:17',NULL,NULL),(17,'Ops Agence Kinshasa','ops.AG-RDC-01@hillholding.com',NULL,'$2y$12$r/wRxgUzQsqm.OLxWgndhuaDQ6gbXKsMI001BQVHwUriEGOEO5tE6','user',NULL,3,5,NULL,NULL,NULL,'2025-12-02 09:33:17','2025-12-02 09:33:17',NULL,NULL),(18,'Employee Agence Kinshasa','employee.AG-RDC-01@hillholding.com',NULL,'$2y$12$tAWtYynAIuN3sAYX/4sPBu9.ryfdDWGg7MepR3dJb.pJhIDvgutWe','user',NULL,3,5,NULL,NULL,NULL,'2025-12-02 09:33:17','2025-12-02 09:33:17',NULL,NULL),(19,'RH Agence Goma','rh.AG-RDC-02@hillholding.com',NULL,'$2y$12$Zx2nVyI2CtwukO9kbvcRleaWRJU/ke8Y6PTHS9pwAl1QJnLZkw6bW','user',NULL,3,6,NULL,NULL,NULL,'2025-12-02 09:33:17','2025-12-02 09:33:17',NULL,NULL),(20,'Finance Agence Goma','finance.AG-RDC-02@hillholding.com',NULL,'$2y$12$Het7xqGwgRHBSDbZPtQlW.ixb0zmlCi6TAzzGrbXyrpXfhx2WL51W','user',NULL,3,6,NULL,NULL,NULL,'2025-12-02 09:33:18','2025-12-02 09:33:18',NULL,NULL),(21,'Ops Agence Goma','ops.AG-RDC-02@hillholding.com',NULL,'$2y$12$UKjdth39FU6u4r6Hgu0I2.jSqtOh4IUTvC0Q7cWIhyZLM/QpFGSsm','user',NULL,3,6,NULL,NULL,NULL,'2025-12-02 09:33:18','2025-12-02 09:33:18',NULL,NULL),(22,'Employee Agence Goma','employee.AG-RDC-02@hillholding.com',NULL,'$2y$12$zSXF6csztLTPyFYQyMQzwusU9Xjz6.FuGIbH9i9msyKUw6eMTrz4.','user',NULL,3,6,NULL,NULL,NULL,'2025-12-02 09:33:18','2025-12-02 09:33:18',NULL,NULL),(23,'RH Burundi','rh.bi@hillholding.com',NULL,'$2y$12$VIFl2d/KAAMbSbMTAH8Rp.4x1of5qFZH6SHDulMHZrBivr0StV7c6','user',NULL,1,3,NULL,NULL,NULL,'2025-12-02 09:33:19','2025-12-02 09:33:19',NULL,NULL),(24,'Finance Rwanda','finance.rw@hillholding.com',NULL,'$2y$12$n.NuEgvSmGA7dVxkr3fhneL9nR0uyIk3pE1JoLWsxJT1B2ORWhPne','user',NULL,2,4,NULL,NULL,NULL,'2025-12-02 09:33:19','2025-12-02 09:33:19',NULL,NULL),(25,'Operations RDC','ops.rdc@hillholding.com',NULL,'$2y$12$wzkRHZx7X2QMLDYIKfg1rutp0Tf9p6TKmKbZII0wU4WbEQ1SKO08K','user',NULL,3,5,NULL,NULL,NULL,'2025-12-02 09:33:19','2025-12-02 09:33:19',NULL,NULL),(26,'EmployÃ© Goma','employe.goma@hillholding.com',NULL,'$2y$12$ww6aCf5BlEDPEi7MfU3TfuZO33GRFZ9ZK6RgU2c/bw71iTw7WUIs6','user',NULL,3,6,NULL,NULL,NULL,'2025-12-02 09:33:19','2025-12-02 09:33:19',NULL,NULL),(27,'Test Employee 1','test.employee1@hillholding.com',NULL,'$2y$12$q37WCTxmjEXTeCRrNRcRh.sUqcD9PzkITXaq.YFkLa6VpXq6uL8F6','user',NULL,1,1,NULL,NULL,NULL,'2025-12-02 09:33:20','2025-12-02 09:33:20',NULL,NULL),(28,'Test Employee 2','test.employee2@hillholding.com',NULL,'$2y$12$u7ReXkOYk8scKEMccyjlN.7JzTw4/VKTrqiuf5kN2UhhQS8uY.xhC','user',NULL,1,1,NULL,NULL,NULL,'2025-12-02 09:33:20','2025-12-02 09:33:20',NULL,NULL),(29,'Test Employee 3','test.employee3@hillholding.com',NULL,'$2y$12$F6lHFGV1agjyhOKKwQBwLOYIqozaqvDWAD6o9IAbF8VIXfdLMZmZe','user',NULL,1,1,NULL,NULL,NULL,'2025-12-02 09:33:20','2025-12-02 09:33:20',NULL,NULL),(30,'Test Employee 4','test.employee4@hillholding.com',NULL,'$2y$12$ItjU7ZcHCdfnr4L1azJuEe4q0lEHyzS7E4KPs6Ol4qzrQrwV25Qum','user',NULL,1,1,NULL,NULL,NULL,'2025-12-02 09:33:20','2025-12-02 09:33:20',NULL,NULL),(31,'Test Employee 5','test.employee5@hillholding.com',NULL,'$2y$12$RgdRUL/XAbRLtxYQYYlMeuc/dC9gmHLKTvSne301e.4Jri0S4TcOG','user',NULL,1,1,NULL,NULL,NULL,'2025-12-02 09:33:21','2025-12-02 09:33:21',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-04  9:00:03

