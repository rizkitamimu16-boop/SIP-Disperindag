-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: aplikasi_disperindag
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
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
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `catatan_alpha`
--

DROP TABLE IF EXISTS `catatan_alpha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catatan_alpha` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `alasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siklus_sp` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `catatan_alpha_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `catatan_alpha_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catatan_alpha`
--

LOCK TABLES `catatan_alpha` WRITE;
/*!40000 ALTER TABLE `catatan_alpha` DISABLE KEYS */;
/*!40000 ALTER TABLE `catatan_alpha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_kegiatan`
--

DROP TABLE IF EXISTS `laporan_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan_kegiatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_kirim` time DEFAULT NULL,
  `nilai_produktivitas` decimal(5,2) NOT NULL DEFAULT '0.00',
  `kategori_produktivitas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_kualitas` decimal(5,2) NOT NULL DEFAULT '0.00',
  `kategori_kualitas` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_kualitas` text COLLATE utf8mb4_unicode_ci,
  `status_verifikasi` enum('Menunggu Review','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Review',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_kegiatan_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `laporan_kegiatan_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_kegiatan`
--

LOCK TABLES `laporan_kegiatan` WRITE;
/*!40000 ALTER TABLE `laporan_kegiatan` DISABLE KEYS */;
INSERT INTO `laporan_kegiatan` VALUES (3,30,'2026-09-24','pendataan harga pasar','melihat harga bahan pokok di pasar central','kegiatan/DIAtLTNsi4RmyRAqC88z04uuwQxTMxJRKUn73jVf.jpg','15:19:07',85.00,'Target Tercapai',90.00,'A',NULL,'Disetujui','2026-09-24 07:19:07','2026-09-26 17:07:33'),(6,30,'2026-09-27','pengecekan mata uangosahcdoaschsadjcnascndsajcanscoaldscdsa','dcascascasdc asdgfasvafdsadssssafvavabfdbdgadfvadcvdvadgadfbdvbadbdabgdadgbadbadbabadbgadbbgbdfbafbf','kegiatan/MZ7nbgfl7z1QpzQR8keHKrK3PxQFf27026OBW1ok.jpg','02:05:53',85.00,'Target Tercapai',10.00,'A',NULL,'Disetujui','2026-09-26 18:05:53','2026-09-26 18:44:51'),(7,30,'2026-09-27','pendataan harga pasar','cdscsdscs','kegiatan/l3OUITw3HsPwUiaQYI3saNMCenyQrgZOuPUiXTBs.avif','02:50:55',85.00,'Target Tercapai',0.00,NULL,NULL,'Menunggu Review','2026-09-26 18:50:55','2026-09-26 18:50:55');
/*!40000 ALTER TABLE `laporan_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_16_000001_create_tabel_sistem_bahasa_indonesia',1),(5,'2026_09_27_021003_ubah_kolom_pengaturan_kantor_ke_bahasa_indonesia',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` enum('Perindustrian','Perdagangan','Sekretariat','Perlindungan Konsumen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Aktif','Cuti') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawai_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES (7,'197002202025212008','Rita Ronosumitro, S.IP',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:55','2026-09-23 06:08:07'),(8,'198910292025212051','Indriani Fransisca Daliuwa, SE',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:55','2026-09-23 06:08:07'),(9,'199407202025212086','Intan Van Gobel, S.AP',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:56','2026-09-23 06:08:07'),(10,'198811292025212042','Marwiyah Abd Gafur',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:56','2026-09-23 06:08:07'),(11,'198801082025212058','Ningsih Ayu Woloto, A.Md',NULL,'Pengelola Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:56','2026-09-23 06:08:07'),(12,'198602152025212047','Sri Hartati Hala, S.Pd',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:56','2026-09-23 06:08:07'),(13,'198004192025211041','Rahmat Utija',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:57','2026-09-23 06:08:07'),(14,'197508202025212016','Agustina Mailensun',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:57','2026-09-23 06:08:07'),(15,'198511272025211048','Fandi Kamah',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:57','2026-09-23 06:08:07'),(16,'198203272025212035','Helmi Mbuinga',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:57','2026-09-23 06:08:07'),(17,'198707112025211071','Hendrik pakudu, S.Kom',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:58','2026-09-23 06:08:07'),(18,'198512242025212047','Heni Wartabone',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:58','2026-09-23 06:08:07'),(19,'198512222025211066','Imam Husin',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:58','2026-09-23 06:08:07'),(20,'198001132025212020','Jein Kalengkongan',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:58','2026-09-23 06:08:07'),(21,'198401052025211061','Jefri Dama',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:59','2026-09-23 06:08:07'),(22,'198803202025212067','Lindawati said',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:59','2026-09-23 06:08:07'),(23,'197310042025212015','Ram N. Hakim, S.IP',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:59','2026-09-23 06:08:07'),(24,'197706182025212025','Rini Otoluwa, S.IP',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:59','2026-09-23 06:08:07'),(25,'197604222025212016','Rusmin Adjunge, SE',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:01:59','2026-09-23 06:08:07'),(26,'197706172025212023','Wahyunie Bahsoan',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:02:00','2026-09-23 06:08:07'),(27,'199307012025212075','Yulinda M. Lasibu, S.Kom',NULL,'Penata Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:02:00','2026-09-23 06:08:07'),(28,'197303032025212021','Yuningsih Sadu',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:02:00','2026-09-23 06:08:07'),(29,'197411022025211014','Yusuf Manopo',NULL,'Operator Layanan Operasional','Sekretariat',NULL,NULL,'Aktif','2026-09-23 06:02:00','2026-09-23 06:08:07'),(30,'7171071602060001','Rizqi Tamimu','085756634973','Anak Magang','Sekretariat','jl jendral sudirman samping rsud dunda',NULL,'Aktif','2026-09-23 16:16:20','2026-09-23 16:16:20');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajuan_izin`
--

DROP TABLE IF EXISTS `pengajuan_izin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengajuan_izin` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `jenis` enum('Izin','Cuti','Sakit','Dinas Luar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Menunggu Review','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Review',
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `tanggal_disetujui` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengajuan_izin_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `pengajuan_izin_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajuan_izin`
--

LOCK TABLES `pengajuan_izin` WRITE;
/*!40000 ALTER TABLE `pengajuan_izin` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengajuan_izin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaturan_kantor`
--

DROP TABLE IF EXISTS `pengaturan_kantor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaturan_kantor` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pemerintah Kota Gorontalo',
  `nama_skpd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dinas Perindustrian dan Perdagangan Kota Gorontalo',
  `alamat_kantor` text COLLATE utf8mb4_unicode_ci,
  `telepon_kantor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titik_koordinat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.5375000,123.0625000',
  `radius_absensi_meter` int NOT NULL DEFAULT '50',
  `jam_masuk` time NOT NULL DEFAULT '07:30:00',
  `batas_terlambat` time NOT NULL DEFAULT '08:00:00',
  `batas_akhir_masuk` time NOT NULL DEFAULT '11:00:00',
  `jam_pulang` time NOT NULL DEFAULT '16:30:00',
  `batas_akhir_pulang` time NOT NULL DEFAULT '19:00:00',
  `jam_pulang_jumat` time NOT NULL DEFAULT '16:00:00',
  `bobot_kehadiran` decimal(5,2) NOT NULL DEFAULT '60.00',
  `bobot_produktivitas` decimal(5,2) NOT NULL DEFAULT '25.00',
  `bobot_kualitas` decimal(5,2) NOT NULL DEFAULT '15.00',
  `ambang_sp1` int NOT NULL DEFAULT '3',
  `ambang_sp2` int NOT NULL DEFAULT '6',
  `ambang_sp3` int NOT NULL DEFAULT '9',
  `pola_nomor_sp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '800/{NO}/DISPERINDAG/2026',
  `template_sp` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan_kantor`
--

LOCK TABLES `pengaturan_kantor` WRITE;
/*!40000 ALTER TABLE `pengaturan_kantor` DISABLE KEYS */;
INSERT INTO `pengaturan_kantor` VALUES (1,'Pemerintah Kota Gorontalo','Dinas Perindustrian dan Perdagangan Kota Gorontalo','Jl. Jalaluddin Tantu No. 45, Kota Gorontalo','(0435) 821xxx','0.6226627,122.9765976',100,'01:00:00','02:00:00','02:15:00','14:00:00','22:00:00','09:00:00',60.00,25.00,15.00,3,6,9,'800/{nomor}/DISPERINDAG/{tahun}','Berdasarkan rekapitulasi data kehadiran terpadu DISPERINDAG Kota Gorontalo, yang bersangkutan telah mengakumulasi ketidakhadiran tanpa izin sah...','2026-09-21 16:28:21','2026-09-26 17:26:30');
/*!40000 ALTER TABLE `pengaturan_kantor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengguna` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran` enum('admin','pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengguna_username_unique` (`username`),
  UNIQUE KEY `pengguna_email_unique` (`email`),
  KEY `pengguna_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `pengguna_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (1,NULL,'Administrator Utama','admin','admin@disperindag.gorontalokota.go.id',NULL,'$2y$12$zmpJr7i0kIcNSvNeN9cDKeRwbyL4AhDTh64lpK4TE/WEguCqoxz7u','admin','aktif',NULL,'2026-09-21 16:28:21','2026-09-23 06:10:31'),(8,NULL,'dhani ardiyanto syahdila','budi123','ramatamimu68@gmail.com',NULL,'$2y$12$dNEWh45d8CRgWRhESQ0BeeKrsUlZEcSO1cRbz6.OfvJEEb4X8BE/W','admin','aktif',NULL,'2026-09-21 18:17:56','2026-09-21 18:17:56'),(9,7,'Rita Ronosumitro, S.IP','rita.2008','rita.ronosumitro.sip@disperindag.gorontalokota.go.id',NULL,'$2y$12$1EEK432xnXrVvdfqDOxr2OfVMKlGmvEgwbCEob/KO.IWpqrJ.eiEG','pegawai','aktif',NULL,'2026-09-23 06:01:55','2026-09-23 06:01:55'),(10,8,'Indriani Fransisca Daliuwa, SE','indriani.2051','indriani.fransisca.daliuwa.se@disperindag.gorontalokota.go.id',NULL,'$2y$12$MMS.Arz7Si2EVCkdEokj8eL307A9mjsfTNQSzI4OyNTg7MbLOa5Za','pegawai','aktif',NULL,'2026-09-23 06:01:56','2026-09-23 06:01:56'),(11,9,'Intan Van Gobel, S.AP','intan.2086','intan.van.gobel.sap@disperindag.gorontalokota.go.id',NULL,'$2y$12$MnNW4zotrtpLUYGdM1gdc.B2p5mmtCea2WbAF5OWuQbIrOeMRRKcK','pegawai','aktif',NULL,'2026-09-23 06:01:56','2026-09-23 06:01:56'),(12,10,'Marwiyah Abd Gafur','marwiyah.2042','marwiyah.abd.gafur@disperindag.gorontalokota.go.id',NULL,'$2y$12$5JFvPgcAfV9CqkZuZr9Lee.8LPiEAXRt1HvdgnqcpF7K5AlocIube','pegawai','aktif',NULL,'2026-09-23 06:01:56','2026-09-23 06:01:56'),(13,11,'Ningsih Ayu Woloto, A.Md','ningsih.2058','ningsih.ayu.woloto.amd@disperindag.gorontalokota.go.id',NULL,'$2y$12$.9vyiq2W.uGPZ2J6ZQf6ied19T7imYryF83BM99tFBnSJ862WwLUG','pegawai','aktif',NULL,'2026-09-23 06:01:56','2026-09-23 06:01:56'),(14,12,'Sri Hartati Hala, S.Pd','sri.2047','sri.hartati.hala.spd@disperindag.gorontalokota.go.id',NULL,'$2y$12$GZ7FduwMAwgHCqFdaaD4rORxIF.DAA.ksh6j/A37tVY29TY0/Mda.','pegawai','aktif',NULL,'2026-09-23 06:01:57','2026-09-23 06:01:57'),(15,13,'Rahmat Utija','rahmat.1041','rahmat.utija@disperindag.gorontalokota.go.id',NULL,'$2y$12$OqLmzxsw7d1oAsg/NvJCa.0lJCzUIQdRSc92Ga9AjES5BrAvoTA/W','pegawai','aktif',NULL,'2026-09-23 06:01:57','2026-09-23 06:01:57'),(16,14,'Agustina Mailensun','agustina.2016','agustina.mailensun@disperindag.gorontalokota.go.id',NULL,'$2y$12$bPMQ.zXJVOveZHKF7IN.Y.8tNxeDjTmQ6wFRFcW6gVveLNULX.6nC','pegawai','aktif',NULL,'2026-09-23 06:01:57','2026-09-23 06:01:57'),(17,15,'Fandi Kamah','fandi.1048','fandi.kamah@disperindag.gorontalokota.go.id',NULL,'$2y$12$vEce.nTlLkIWXVckdViJYOcP3FtRCVOduycmiAOfcQGK1WPjqT.26','pegawai','aktif',NULL,'2026-09-23 06:01:57','2026-09-23 06:01:57'),(18,16,'Helmi Mbuinga','helmi.2035','helmi.mbuinga@disperindag.gorontalokota.go.id',NULL,'$2y$12$3o05Kv5IDLxBmt1k9IQrGeFhN2FLA0ASU1PaCcZ8L9Cmjbl0ONGBq','pegawai','aktif',NULL,'2026-09-23 06:01:58','2026-09-23 06:01:58'),(19,17,'Hendrik pakudu, S.Kom','hendrik.1071','hendrik.pakudu.skom@disperindag.gorontalokota.go.id',NULL,'$2y$12$ydNjTfV1JVzWxmNvnKW.GewTNeQmfpd6uQKLU56x0qYA81M8G.5fe','pegawai','aktif',NULL,'2026-09-23 06:01:58','2026-09-23 06:01:58'),(20,18,'Heni Wartabone','heni.2047','heni.wartabone@disperindag.gorontalokota.go.id',NULL,'$2y$12$ugo8v9jexWoZIk9OT8CTsumr.sUp6In1ssMYDUWu7NEU4UFGaSjmO','pegawai','aktif',NULL,'2026-09-23 06:01:58','2026-09-23 06:01:58'),(21,19,'Imam Husin','imam.1066','imam.husin@disperindag.gorontalokota.go.id',NULL,'$2y$12$pZBu7H5Oss601/w/t/5i3u1Y64KFCxNXl13AOiRLUKXzroRT8ZSVi','pegawai','aktif',NULL,'2026-09-23 06:01:58','2026-09-23 06:01:58'),(22,20,'Jein Kalengkongan','jein.2020','jein.kalengkongan@disperindag.gorontalokota.go.id',NULL,'$2y$12$J2kWxvqjdhrsW8NhUFP38exnRe.UScA02Wltvl8/AUm70b3e.ysUO','pegawai','aktif',NULL,'2026-09-23 06:01:59','2026-09-23 06:01:59'),(23,21,'Jefri Dama','jefri.1061','jefri.dama@disperindag.gorontalokota.go.id',NULL,'$2y$12$/FENMHes9hP2j0XD3dcwFu6hTSslf4YUzKTUgnJUMd5eXqgZ1c9Km','pegawai','aktif',NULL,'2026-09-23 06:01:59','2026-09-23 06:01:59'),(24,22,'Lindawati said','lindawati.2067','lindawati.said@disperindag.gorontalokota.go.id',NULL,'$2y$12$1T52qCfeSEmQyvOLt3HAsuUdyd5LOEc3nD9A.mJVokYgTX90JIFeq','pegawai','aktif',NULL,'2026-09-23 06:01:59','2026-09-23 06:01:59'),(25,23,'Ram N. Hakim, S.IP','ram.2015','ram.n.hakim.sip@disperindag.gorontalokota.go.id',NULL,'$2y$12$a5NscaCythBnSiinDEg9hu5hy9FrqEcL386Hv1vwaTMDoFC0pxMsu','pegawai','aktif',NULL,'2026-09-23 06:01:59','2026-09-23 06:01:59'),(26,24,'Rini Otoluwa, S.IP','rini.2025','rini.otoluwa.sip@disperindag.gorontalokota.go.id',NULL,'$2y$12$J4r9gICyWAaqlF71z3P9XeymwFNpOM2aJFwMz/pYNpSXan22FPHS2','pegawai','aktif',NULL,'2026-09-23 06:01:59','2026-09-23 06:01:59'),(27,25,'Rusmin Adjunge, SE','rusmin.2016','rusmin.adjunge.se@disperindag.gorontalokota.go.id',NULL,'$2y$12$mvAtE0WgOnKuKnQTBzjwYuCLrkQJtgs8ffdHzDQxu3dj6oB58RI/K','pegawai','aktif',NULL,'2026-09-23 06:02:00','2026-09-23 06:02:00'),(28,26,'Wahyunie Bahsoan','wahyunie.2023','wahyunie.bahsoan@disperindag.gorontalokota.go.id',NULL,'$2y$12$n8rMRmSfqnAleTkiVlkKm.NPfqTC5tqYi21xLfzFsSIKuSBJDBFOm','pegawai','aktif',NULL,'2026-09-23 06:02:00','2026-09-23 06:02:00'),(29,27,'Yulinda M. Lasibu, S.Kom','yulinda.2075','yulinda.m.lasibu.skom@disperindag.gorontalokota.go.id',NULL,'$2y$12$XNMSOPJ.eJvgnIvj1P7YBON6TGXm0qoJw9gXPCLqsc4ZJm7f2e9S6','pegawai','aktif',NULL,'2026-09-23 06:02:00','2026-09-23 06:02:00'),(30,28,'Yuningsih Sadu','yuningsih.2021','yuningsih.sadu@disperindag.gorontalokota.go.id',NULL,'$2y$12$QdrekNO0jSMHGNxwVfT/KuaoN10BptlzTqlB8D3hjxEw.bVc.55b2','pegawai','aktif',NULL,'2026-09-23 06:02:00','2026-09-23 06:02:00'),(31,29,'Yusuf Manopo','yusuf.1014','yusuf.manopo@disperindag.gorontalokota.go.id',NULL,'$2y$12$6aL75vBxDr0gbg0.JsifS.8LiKa4vAfGvOwQhgJm7Ch4CAljhw1UW','pegawai','aktif',NULL,'2026-09-23 06:02:01','2026-09-23 06:02:01'),(32,30,'Rizqi Tamimu','rizqi.0001','rizkitamimu16@gmail.com',NULL,'$2y$12$Fdmgm6w01FNdbDeEfBZTQO5SOtwZcs4nUgRnF1x.bav.qa1WTfUxi','pegawai','aktif',NULL,'2026-09-23 16:16:20','2026-09-23 16:16:20');
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presensi`
--

DROP TABLE IF EXISTS `presensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `status_masuk` enum('Tepat Waktu','Terlambat') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak_masuk` decimal(8,2) DEFAULT NULL,
  `foto_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `status_pulang` enum('Tepat Waktu','Pulang Cepat') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak_pulang` decimal(8,2) DEFAULT NULL,
  `foto_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Hadir','Terlambat','Alpha','Izin','Cuti','Dinas Luar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presensi_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `presensi_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presensi`
--

LOCK TABLES `presensi` WRITE;
/*!40000 ALTER TABLE `presensi` DISABLE KEYS */;
INSERT INTO `presensi` VALUES (8,30,'2026-09-24','15:17:57','Tepat Waktu',45.83,'absensi/30_1790234277.jpeg','15:22:01','Tepat Waktu',45.83,'absensi/30_1790234521.jpeg','Hadir','2026-09-24 07:17:57','2026-09-24 07:22:01'),(12,30,'2026-09-27','02:03:59','Terlambat',12.05,'absensi/30_1790445839.jpeg','02:07:13','Pulang Cepat',12.05,'absensi/30_1790446033.jpeg','Terlambat','2026-09-26 18:03:59','2026-09-26 18:07:13');
/*!40000 ALTER TABLE `presensi` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('ODzQbKn80NIo6fHO3Fr1x1CnB4dwwWs8SOYSr51b',32,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJCZVVYTTZtQnVJc01LVmxvSG9lamd2UEl2amhvYVRqRjE0QVFCUXdoIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BlZ2F3YWlcL2tlZ2lhdGFuIiwicm91dGUiOiJwZWdhd2FpLmtlZ2lhdGFuIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjozMn0=',1790448720);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skor_kinerja`
--

DROP TABLE IF EXISTS `skor_kinerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skor_kinerja` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `periode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_kehadiran` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_produktivitas` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_kualitas` decimal(5,2) NOT NULL DEFAULT '0.00',
  `bobot_kehadiran` decimal(5,2) NOT NULL DEFAULT '60.00',
  `bobot_produktivitas` decimal(5,2) NOT NULL DEFAULT '25.00',
  `bobot_kualitas` decimal(5,2) NOT NULL DEFAULT '15.00',
  `nilai_akhir` decimal(5,2) NOT NULL DEFAULT '0.00',
  `kategori` enum('Sangat Baik','Baik','Cukup','Kurang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `status` enum('Final','Draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `rekomendasi_kontrak` enum('Diperpanjang','Dipertimbangkan','Tidak Diperpanjang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diperpanjang',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skor_kinerja_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `skor_kinerja_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skor_kinerja`
--

LOCK TABLES `skor_kinerja` WRITE;
/*!40000 ALTER TABLE `skor_kinerja` DISABLE KEYS */;
/*!40000 ALTER TABLE `skor_kinerja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_peringatan`
--

DROP TABLE IF EXISTS `surat_peringatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_peringatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint unsigned NOT NULL,
  `tingkat_sp` enum('SP-1','SP-2','SP-3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_alpha` int NOT NULL,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Aktif','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `surat_peringatan_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `surat_peringatan_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_peringatan`
--

LOCK TABLES `surat_peringatan` WRITE;
/*!40000 ALTER TABLE `surat_peringatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `surat_peringatan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-27 11:01:22
