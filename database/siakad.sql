-- MariaDB dump 10.19  Distrib 10.7.3-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: siakad
-- ------------------------------------------------------
-- Server version	10.7.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `siakad_configs`
--

DROP TABLE IF EXISTS `siakad_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_configs` (
  `config` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  UNIQUE KEY `siakad_configs_config_unique` (`config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_configs`
--

LOCK TABLES `siakad_configs` WRITE;
/*!40000 ALTER TABLE `siakad_configs` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_dosen_makul`
--

DROP TABLE IF EXISTS `siakad_dosen_makul`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_dosen_makul` (
  `dosen_id` bigint(20) NOT NULL,
  `mata_kuliah_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_dosen_makul`
--

LOCK TABLES `siakad_dosen_makul` WRITE;
/*!40000 ALTER TABLE `siakad_dosen_makul` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_dosen_makul` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_dosens`
--

DROP TABLE IF EXISTS `siakad_dosens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_dosens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `nidn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L' COMMENT 'L: Laki-laki, P: Perempuan',
  `prodi_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif' COMMENT 'aktif, nonaktif, cuti',
  `opt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opt`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_dosens`
--

LOCK TABLES `siakad_dosens` WRITE;
/*!40000 ALTER TABLE `siakad_dosens` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_dosens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_failed_jobs`
--

DROP TABLE IF EXISTS `siakad_failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `siakad_failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_failed_jobs`
--

LOCK TABLES `siakad_failed_jobs` WRITE;
/*!40000 ALTER TABLE `siakad_failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_krs`
--

DROP TABLE IF EXISTS `siakad_krs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_krs` (
  `semester` int(11) NOT NULL,
  `mahasiswa_id` bigint(20) NOT NULL,
  `mata_kuliah_id` bigint(20) NOT NULL,
  `sks` int(11) DEFAULT NULL,
  `opt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opt`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_krs`
--

LOCK TABLES `siakad_krs` WRITE;
/*!40000 ALTER TABLE `siakad_krs` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_krs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_mahasiswas`
--

DROP TABLE IF EXISTS `siakad_mahasiswas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_mahasiswas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `jenis_kelamin` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L' COMMENT 'L: Laki-laki, P: Perempuan',
  `dosen_id` bigint(20) DEFAULT NULL,
  `prodi_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif' COMMENT 'aktif, nonaktif, cuti',
  `opt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opt`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_mahasiswas`
--

LOCK TABLES `siakad_mahasiswas` WRITE;
/*!40000 ALTER TABLE `siakad_mahasiswas` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_mahasiswas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_mata_kuliahs`
--

DROP TABLE IF EXISTS `siakad_mata_kuliahs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_mata_kuliahs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi_id` bigint(20) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `semester` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 - n Semester',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siakad_mata_kuliahs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_mata_kuliahs`
--

LOCK TABLES `siakad_mata_kuliahs` WRITE;
/*!40000 ALTER TABLE `siakad_mata_kuliahs` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_mata_kuliahs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_migrations`
--

DROP TABLE IF EXISTS `siakad_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_migrations`
--

LOCK TABLES `siakad_migrations` WRITE;
/*!40000 ALTER TABLE `siakad_migrations` DISABLE KEYS */;
INSERT INTO `siakad_migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2021_09_05_091837_create_mahasiswas_table',1),
(6,'2021_09_05_093806_create_prodis_table',1),
(7,'2021_09_05_093834_create_dosens_table',1),
(8,'2021_09_05_094638_create_mata_kuliahs_table',1),
(9,'2021_09_05_103358_create_dosen_makul_table',1),
(10,'2021_09_05_103513_create_krs_table',1),
(11,'2021_09_05_104603_create_nilai_table',1),
(12,'2021_09_05_113635_create_configs_table',1);
/*!40000 ALTER TABLE `siakad_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_nilai`
--

DROP TABLE IF EXISTS `siakad_nilai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_nilai` (
  `semester` bigint(20) NOT NULL,
  `mahasiswa_id` bigint(20) NOT NULL,
  `mata_kuliah_id` bigint(20) NOT NULL,
  `sks` int(11) NOT NULL,
  `bnilai` int(11) NOT NULL COMMENT 'Big Nilai',
  `index_nilai` char(2) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A+ - E',
  `poin_nilai` char(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '4 - 0',
  `total_nilai` double(8,2) NOT NULL COMMENT 'sks x poin_nilai',
  `opt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opt`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_nilai`
--

LOCK TABLES `siakad_nilai` WRITE;
/*!40000 ALTER TABLE `siakad_nilai` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_nilai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_password_resets`
--

DROP TABLE IF EXISTS `siakad_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `siakad_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_password_resets`
--

LOCK TABLES `siakad_password_resets` WRITE;
/*!40000 ALTER TABLE `siakad_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_personal_access_tokens`
--

DROP TABLE IF EXISTS `siakad_personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siakad_personal_access_tokens_token_unique` (`token`),
  KEY `siakad_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_personal_access_tokens`
--

LOCK TABLES `siakad_personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `siakad_personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_prodis`
--

DROP TABLE IF EXISTS `siakad_prodis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_prodis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opt`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siakad_prodis_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_prodis`
--

LOCK TABLES `siakad_prodis` WRITE;
/*!40000 ALTER TABLE `siakad_prodis` DISABLE KEYS */;
/*!40000 ALTER TABLE `siakad_prodis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siakad_users`
--

DROP TABLE IF EXISTS `siakad_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siakad_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` char(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0:superadmin, 1:dosen, 2:mahasiswa, 3:operator',
  `prodi_id` bigint(20) DEFAULT NULL,
  `jenis_kelamin` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'L' COMMENT 'L: Laki-laki, P: Perempuan',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siakad_users_uuid_unique` (`uuid`),
  UNIQUE KEY `siakad_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siakad_users`
--

LOCK TABLES `siakad_users` WRITE;
/*!40000 ALTER TABLE `siakad_users` DISABLE KEYS */;
INSERT INTO `siakad_users` VALUES
(1,'a2f76b4d-f6a8-4861-b5db-7cc6f592e660','Administrator','admin','$2y$10$YEwscjDr4GqBdZXFdEPd8ewRgpT79G046Qxai70vk1bnRYbKtpnSG','0',NULL,'L',NULL,'2022-04-27 06:06:46','2022-04-27 06:06:46');
/*!40000 ALTER TABLE `siakad_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-27 14:06:51
