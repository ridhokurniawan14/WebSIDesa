-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: websidesa
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=869 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (851,'default','deleted','App\\Models\\User','deleted',4,'App\\Models\\User',1,'{\"old\": {\"name\": \"Muhammad Rayyan\", \"role\": null, \"email\": \"mrayyan@gmail.com\"}}',NULL,'2025-12-23 15:31:00','2025-12-23 15:31:00'),(852,'default','Menghapus user: Muhammad Rayyan',NULL,NULL,NULL,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"DELETE\", \"deleted_count\": 1}',NULL,'2025-12-23 15:31:00','2025-12-23 15:31:00'),(853,'default','deleted','App\\Models\\User','deleted',3,'App\\Models\\User',1,'{\"old\": {\"name\": \"Muhammad Rasyaad\", \"role\": null, \"email\": \"mrasyaad@gmail.com\"}}',NULL,'2025-12-23 15:31:01','2025-12-23 15:31:01'),(854,'default','Menghapus user: Muhammad Rasyaad',NULL,NULL,NULL,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"DELETE\", \"deleted_count\": 1}',NULL,'2025-12-23 15:31:01','2025-12-23 15:31:01'),(855,'default','Admin logout',NULL,NULL,NULL,'App\\Models\\User',1,'[]',NULL,'2025-12-23 15:31:04','2025-12-23 15:31:04'),(856,'default','Admin login',NULL,NULL,NULL,'App\\Models\\User',6,'{\"ip\": \"127.0.0.1\", \"method\": \"POST\"}',NULL,'2025-12-23 15:31:11','2025-12-23 15:31:11'),(857,'default','Admin logout',NULL,NULL,NULL,'App\\Models\\User',6,'[]',NULL,'2025-12-23 15:31:45','2025-12-23 15:31:45'),(858,'default','Admin login',NULL,NULL,NULL,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"POST\"}',NULL,'2025-12-23 15:31:56','2025-12-23 15:31:56'),(859,'default','updated','App\\Models\\User','updated',1,'App\\Models\\User',1,'{\"old\": {\"name\": \"Ridho\"}, \"attributes\": {\"name\": \"Ridho Kurniawan\"}}',NULL,'2025-12-23 15:32:04','2025-12-23 15:32:04'),(860,'user_profile','Memperbarui profil pengguna','App\\Models\\User',NULL,1,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"PUT\", \"changes\": {\"name\": {\"new\": \"Ridho Kurniawan\", \"old\": \"Ridho\"}}}',NULL,'2025-12-23 15:32:04','2025-12-23 15:32:04'),(861,'default','Menghapus log aktivitas lama',NULL,NULL,NULL,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"DELETE\", \"deleted_count\": 280}',NULL,'2025-12-23 15:32:12','2025-12-23 15:32:12'),(862,'default','Admin logout',NULL,NULL,NULL,'App\\Models\\User',1,'[]',NULL,'2025-12-23 15:32:18','2025-12-23 15:32:18'),(863,'default','Admin login',NULL,NULL,NULL,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"POST\"}',NULL,'2025-12-23 15:41:29','2025-12-23 15:41:29'),(864,'beranda','Mengubah data beranda','App\\Models\\Beranda',NULL,1,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"PUT\", \"changes\": {\"foto_kepala_desa\": {\"new\": \"beranda/kades/g6hnBVMVZ9e5pIt0fsh735Lmtq64erW8vMZ09ToT.jpg\", \"old\": null}, \"nama_kepala_desa\": {\"new\": \"Kim Jong Un\", \"old\": null}}}',NULL,'2025-12-23 15:43:15','2025-12-23 15:43:15'),(865,'default','Admin login',NULL,NULL,NULL,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"POST\"}',NULL,'2025-12-23 16:18:35','2025-12-23 16:18:35'),(866,'berita','Mengubah berita','App\\Models\\Berita',NULL,2,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"PUT\", \"changes\": {\"date\": {\"new\": \"2025-12-23\", \"old\": \"2025-12-22T17:00:00.000000Z\"}, \"slug\": {\"new\": \"berita-2-MJ9R1\", \"old\": \"berita-2-USJJt\"}, \"content\": {\"new\": \"<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah beri<strong>ta tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berit</strong>a tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>\", \"old\": \"<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>\"}}}',NULL,'2025-12-23 16:18:53','2025-12-23 16:18:53'),(867,'berita','Mengubah berita','App\\Models\\Berita',NULL,2,'App\\Models\\User',1,'{\"ip\": \"127.0.0.1\", \"method\": \"PUT\", \"changes\": {\"date\": {\"new\": \"2025-12-23\", \"old\": \"2025-12-22T17:00:00.000000Z\"}, \"slug\": {\"new\": \"berita-2-q2Qg8\", \"old\": \"berita-2-MJ9R1\"}, \"content\": {\"new\": \"<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah beri<strong>ta tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berit</strong>a&nbsp;<br><br>tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>\", \"old\": \"<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah beri<strong>ta tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berit</strong>a tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>\"}}}',NULL,'2025-12-23 16:21:45','2025-12-23 16:21:45'),(868,'default','Admin logout',NULL,NULL,NULL,'App\\Models\\User',1,'[]',NULL,'2025-12-23 16:22:29','2025-12-23 16:22:29');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrasi`
--

DROP TABLE IF EXISTS `administrasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `prosedur` json DEFAULT NULL,
  `syarat` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `administrasi_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrasi`
--

LOCK TABLES `administrasi` WRITE;
/*!40000 ALTER TABLE `administrasi` DISABLE KEYS */;
INSERT INTO `administrasi` VALUES (1,'pembuatan-kartu-keluarga-kk-N8aTv','kependudukan','Pembuatan Kartu Keluarga (KK)','Pengajuan pembuatan KK baru atau perubahan data','[\"Datang ke kantor desa dengan membawa persyaratan.\", \"Mengisi formulir permohonan KK.\", \"Verifikasi data oleh petugas.\", \"Menunggu proses penerbitan KK.\"]','[\"Fotokopi Buku Nikah\", \"Fotokopi KTP suami & istri\", \"Surat keterangan kelahiran anak\"]','2025-12-21 15:20:10','2025-12-21 15:37:32'),(2,'pembuatan-ktp-el-CpPOJ','kependudukan','Pembuatan KTP-el','KTP elektronik untuk warga usia 17+','[\"Membawa dokumen persyaratan.\", \"Pengambilan foto & sidik jari.\", \"Menunggu pencetakan.\"]','[\"Fotokopi KK\"]','2025-12-21 15:38:38','2025-12-21 15:38:38'),(3,'surat-keterangan-tidak-mampu-sktm-XgSyF','surat-keterangan','Surat Keterangan Tidak Mampu (SKTM)','Surat untuk bantuan sekolah, kesehatan, dan lainnya.','[\"Mengisi formulir.\", \"Verifikasi petugas.\", \"Penerbitan surat.\"]','[\"Fotokopi KK\", \"Fotokopi KTP\"]','2025-12-21 15:39:27','2025-12-21 15:39:27'),(4,'surat-keterangan-domisili-VeN7J','surat-keterangan','Surat Keterangan Domisili','Persyaratan untuk berbagai kebutuhan administrasi.','[\"Mengisi formulir domisili.\", \"Pengecekan alamat oleh RT/RW.\", \"Penerbitan surat oleh desa.\"]','[\"Fotokopi KK\", \"Fotokopi KTP\"]','2025-12-21 15:40:20','2025-12-21 15:40:20'),(5,'surat-keterangan-usaha-sku-yxuEy','surat-keterangan','Surat Keterangan Usaha (SKU)','Untuk pengajuan bantuan UMKM atau legalitas usaha.','[\"Mengisi formulir SKU.\", \"Verifikasi lapangan.\", \"Penerbitan SKU.\"]','[\"Fotokopi KTP\", \"Fotokopi KK\"]','2025-12-21 15:40:54','2025-12-21 15:40:54'),(6,'surat-keterangan-kematian-hvTMY','lainnya','Surat Keterangan Kematian','Untuk kebutuhan data kependudukan dan administrasi lainnya.','[\"Laporan keluarga.\", \"Pengecekan data.\", \"Penerbitan surat kematian.\"]','[\"Fotokopi KK almarhum\", \"Fotokopi KTP pelapor\"]','2025-12-21 15:41:31','2025-12-21 15:41:31'),(7,'pembuatan-apa-saja-77l4U','lainnya','Pembuatan Apa saja','ini deskripsi singkat ya','[\"Silahkan ke 1\", \"Silahkan ke 2\", \"Silahkan ke 3\", \"Silahkan ke 4\"]','[\"KTP Suami\", \"KTP Istri\", \"Buku Nikah\"]','2025-12-23 10:03:59','2025-12-23 10:03:59');
/*!40000 ALTER TABLE `administrasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apbdes`
--

DROP TABLE IF EXISTS `apbdes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apbdes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year NOT NULL,
  `jenis` enum('pendapatan','belanja','pembiayaan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` bigint NOT NULL DEFAULT '0',
  `realisasi` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apbdes_tahun_index` (`tahun`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apbdes`
--

LOCK TABLES `apbdes` WRITE;
/*!40000 ALTER TABLE `apbdes` DISABLE KEYS */;
INSERT INTO `apbdes` VALUES (1,2025,'pendapatan','Hasil Aset Desa',79800000,79800000,'2025-12-19 15:40:18','2025-12-19 15:40:18'),(2,2025,'pendapatan','Dana Desa',1243675000,1243675000,'2025-12-19 16:28:25','2025-12-19 16:28:25'),(3,2025,'pendapatan','Bagi Hasil Pajak Dan Retribusi',93111100,93111100,'2025-12-19 16:28:49','2025-12-19 16:28:49'),(4,2025,'pendapatan','Alokasi Dana Desa',864201000,864201000,'2025-12-19 16:29:14','2025-12-19 16:29:14'),(5,2025,'pendapatan','Bunga Bank',3090000,2534217,'2025-12-19 16:29:45','2025-12-19 16:36:46'),(6,2025,'belanja','Bidang Penyelenggaran Pemerintahan Desa',1023595564,1001934000,'2025-12-19 16:39:19','2025-12-19 16:39:19'),(7,2025,'belanja','Bidang Pelaksanaan Pembangunan Desa',743665000,725985321,'2025-12-19 16:41:20','2025-12-19 16:41:20'),(8,2025,'belanja','Bidang Pembinaan Kemasyarakatan Desa',139518000,128929000,'2025-12-19 16:42:35','2025-12-19 16:42:35'),(9,2025,'belanja','Bidang Pemberdayaan Masyarakat Desa',285325000,281292000,'2025-12-19 16:43:10','2025-12-19 16:45:17'),(10,2025,'belanja','Bidang Penanggulangan Bencana, Darurat Dan Mendesak Desa',111600000,111600000,'2025-12-19 16:45:09','2025-12-19 16:45:09'),(11,2025,'pembiayaan','Pembiayaan',19826464,19826464,'2025-12-19 16:56:13','2025-12-19 16:57:05'),(12,2023,'pendapatan','Dana Desa',120000000,115000000,'2025-12-19 17:07:39','2025-12-19 17:07:39'),(13,2023,'pendapatan','Alokasi Dana Desa',80000000,78000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(14,2023,'pendapatan','Bagi Hasil Pajak',30000000,29000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(15,2023,'belanja','Pembangunan Jalan',60000000,55000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(16,2023,'belanja','Renovasi Balai Desa',40000000,38000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(17,2023,'belanja','Pengadaan Lampu Jalan',20000000,18000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(18,2023,'belanja','Kegiatan Posyandu',15000000,14000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(19,2023,'belanja','Pelatihan Karang Taruna',10000000,9500000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(20,2023,'pembiayaan','Silpa Tahun Lalu',25000000,25000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(21,2023,'pembiayaan','Penerimaan Pembiayaan',15000000,14000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(22,2023,'pembiayaan','Pengeluaran Pembiayaan',10000000,9000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(23,2023,'belanja','Program Kebersihan Desa',12000000,11000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(24,2024,'pendapatan','Dana Desa',130000000,125000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(25,2024,'pendapatan','Alokasi Dana Desa',90000000,88000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(26,2024,'pendapatan','Bagi Hasil Pajak',35000000,34000000,'2025-12-19 17:07:40','2025-12-19 17:07:40'),(27,2024,'belanja','Pembangunan Jembatan',70000000,68000000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(28,2024,'belanja','Renovasi Sekolah',50000000,48000000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(29,2024,'belanja','Pengadaan Air Bersih',30000000,28000000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(30,2024,'belanja','Kegiatan PKK',20000000,19000000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(31,2024,'belanja','Pelatihan UMKM',15000000,14500000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(32,2024,'pembiayaan','Silpa Tahun Lalu',30000000,30000000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(33,2024,'pembiayaan','Penerimaan Pembiayaan',20000000,19000000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(34,2024,'pembiayaan','Pengeluaran Pembiayaan',12000000,11500000,'2025-12-19 17:07:41','2025-12-19 17:07:41'),(35,2024,'belanja','Program Lingkungan Hijau',18000000,17000000,'2025-12-19 17:07:43','2025-12-19 17:07:43');
/*!40000 ALTER TABLE `apbdes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aplikasis`
--

DROP TABLE IF EXISTS `aplikasis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aplikasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kantor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wa_cs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer` text COLLATE utf8mb4_unicode_ci,
  `map` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jam_operasional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplikasis`
--

LOCK TABLES `aplikasis` WRITE;
/*!40000 ALTER TABLE `aplikasis` DISABLE KEYS */;
INSERT INTO `aplikasis` VALUES (1,'logo/RcPbd0VOhdpa1Oqi5NxfTczxm6qbewxoWLu6uePa.png','Desa Kembiritan','Kab. Banyuwangi','Kantor Desa Kembiritan','Jl. Raya Genteng-Kembiritan 168, Kec. Genteng, Kab. Banyuwangi, Jawa Timur 68465','0333848195','desakembiritan7@gmail.com','6285963015003','https://www.facebook.com/Kembiritan7','https://www.instagram.com/kembiritan7','https://www.youtube.com/@pemdeskembiritan9559','Website resmi informasi pelayanan dan publikasi Desa Cipta Makmur. Melayani dengan integritas.','<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9714.168679200897!2d114.187995!3d-8.367709!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd15562ff3a6b3f%3A0x3b0181738285d4bc!2sBalai%20desa%20kembiritan!5e1!3m2!1sid!2sid!4v1766422869082!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','2025-12-19 08:08:00','2025-12-22 17:02:03','Senin - Jumat (08.00 - 15.00 WIB)');
/*!40000 ALTER TABLE `aplikasis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beranda`
--

DROP TABLE IF EXISTS `beranda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beranda` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `banner_images` json DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `sambutan_kades` text COLLATE utf8mb4_unicode_ci,
  `nama_kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periode_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_penduduk` int NOT NULL DEFAULT '0',
  `total_laki_laki` int NOT NULL DEFAULT '0',
  `total_perempuan` int NOT NULL DEFAULT '0',
  `usia_muda` int NOT NULL DEFAULT '0',
  `usia_dewasa` int NOT NULL DEFAULT '0',
  `usia_lansia` int NOT NULL DEFAULT '0',
  `jumlah_kk` int NOT NULL DEFAULT '0',
  `jumlah_rt` int NOT NULL DEFAULT '0',
  `jumlah_rw` int NOT NULL DEFAULT '0',
  `jumlah_dusun` int NOT NULL DEFAULT '0',
  `desa_adat` int NOT NULL DEFAULT '0',
  `keluarga_miskin` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beranda`
--

LOCK TABLES `beranda` WRITE;
/*!40000 ALTER TABLE `beranda` DISABLE KEYS */;
INSERT INTO `beranda` VALUES (1,'[\"beranda/banners/5YjNcmfY0e5wiJjXtiPpH24gxZ9rOdaVLK39SW8b.jpg\", \"beranda/banners/iIT6hDtI3IxlwAA7a6xgsSc5W2vsGoav4FZUNfSM.jpg\", \"beranda/banners/epvSfKEIFhRpWySLhs1mAJ9zx05XcoI5FBKW67g7.jpg\", \"beranda/banners/Cn6f1CqEvDibTHG5Zx6WKWpClhAosclpEkqOaXYD.jpg\", \"beranda/banners/dZM8is5EmY4sLP0Maf4BPcFxMmTLp3u0MAANtNsK.jpg\"]','Wujudkan Desa Digital yang Transparan. Akses informasi, anggaran, dan layanan publik secara terbuka, mendorong kemajuan Desa Kembiritan.','Assalamualaikum Warahmatullahi Wabarakatuh. Selamat datang di Website Resmi Desa Kembiritan. Media ini merupakan komitmen kami dalam menyediakan informasi desa secara terbuka, cepat, dan mudah diakses oleh seluruh masyarakat. Mari bersama-sama membangun Desa Kembiritan menuju masa depan yang lebih baik.','Kim Jong Un','beranda/kades/g6hnBVMVZ9e5pIt0fsh735Lmtq64erW8vMZ09ToT.jpg','2024-2029',5430,2710,2720,1240,3020,1170,1650,18,6,4,1,210,'2025-12-22 09:50:36','2025-12-23 15:43:15');
/*!40000 ALTER TABLE `beranda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beritas`
--

DROP TABLE IF EXISTS `beritas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beritas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `beritas_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beritas`
--

LOCK TABLES `beritas` WRITE;
/*!40000 ALTER TABLE `beritas` DISABLE KEYS */;
INSERT INTO `beritas` VALUES (1,'pemerintah-desa-laksanakan-musrenbang-tahun-2025-RorcO','Pemerintah Desa Laksanakan Musrenbang Tahun 2025','2025-12-21','berita/8TvTEP3OmTuOnb5hL0Q6gsbRMgjbQi111K08IqD4.jpg','Ringkasan (Excerpt) Ringkasan (Excerpt) Ringkasan (Excerpt) Ringkasan (Excerpt)','<div>Musyawarah Perencanaan Pembangunan Desa (Musrenbang) tahun 2025 telah sukses dilaksanakan di balai desa. Kegiatan ini dihadiri oleh perangkat desa, tokoh masyarakat, ketua RT/RW, serta lembaga-lembaga desa. Agenda Musrenbang Pemaparan program pembangunaan&nbsp;<br>Diskusi prioritas pembangunan tahun berjalan Usulan kegiatan dari warga Musrenbang desa merupakan langkah awal dalam menentukan arah pembangunan desa yang lebih baik.</div>',11,'2025-12-21 16:20:38','2025-12-23 17:00:15'),(2,'berita-2-q2Qg8','Berita 2','2025-12-23','berita/w7PkJReoZEGDcuqbRoLGlIsINuW51KapUF2552Rd.jpg','ini adalah berita tentang ini','<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah beri<strong>ta tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berit</strong>a&nbsp;<br><br>tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>',21,'2025-12-23 06:02:45','2025-12-23 17:00:21'),(3,'berita-2-y3oik','Berita 2','2025-12-21','berita/Owwqt3sFkOkLc6IfEOoYCTO3YOYaSQDOOzcrO1EW.jpg','ini adalah berita tentang ini','<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>',21,'2025-12-23 06:03:02','2025-12-23 16:21:53'),(4,'berita-3-UtnZ3','Berita 3','2025-12-20','berita/FdoERy2JQN7QmGlX7JS6PHpuhPAsHKUuwVsgiZ06.jpg','ini adalah berita tentang ini','<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>',3,'2025-12-23 06:03:14','2025-12-23 16:04:31'),(5,'berita-4-xae1G','Berita 4','2025-12-19','berita/5N3gWvBQBYO8YVXIxw5sf5TTPzclsRi2TNfWv1c9.jpg','ini adalah berita tentang ini','<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>',2,'2025-12-23 06:03:27','2025-12-23 17:00:18'),(6,'berita-5-snXxF','Berita 5','2025-12-18','berita/KqWHUP03YAZymUn2JeCKJpkfojTT0n2aBTqAOLRw.jpg','ini adalah berita tentang ini','<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>',0,'2025-12-23 06:04:21','2025-12-23 06:04:21'),(7,'berita-6-9WMnh','Berita 6','2025-12-17','berita/9KU69Tty1eFK5VlMAScaMrgwgJHPCzWydlg1I54g.jpg','ini adalah berita tentang ini','<div>ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini ini adalah berita tentang ini&nbsp;</div>',0,'2025-12-23 06:04:34','2025-12-23 06:04:34');
/*!40000 ALTER TABLE `beritas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bumdes`
--

DROP TABLE IF EXISTS `bumdes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bumdes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tentang` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` json DEFAULT NULL,
  `unit_usaha` json DEFAULT NULL,
  `pengurus` json DEFAULT NULL,
  `kontak` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bumdes`
--

LOCK TABLES `bumdes` WRITE;
/*!40000 ALTER TABLE `bumdes` DISABLE KEYS */;
INSERT INTO `bumdes` VALUES (1,'Bumdes Kembiritan','Membangun desa mandiri melalui pengelolaan aset dan potensi yang profesional, transparan, dan akuntabel.','Badan Usaha Milik Desa (BUMDes) merupakan lembaga usaha desa yang dikelola secara profesional untuk meningkatkan perekonomian dan kesejahteraan masyarakat desa.','Menjadi penggerak ekonomi desa yang mandiri dan berkelanjutan.','[\"Mengembangkan potensi ekonomi lokal desa\", \"Menciptakan lapangan kerja bagi masyarakat\", \"Meningkatkan pendapatan asli desa\", \"Mendukung UMKM desa\"]','[{\"nama\": \"Simpan Pinjam\", \"deskripsi\": \"Melayani kebutuhan permodalan masyarakat desa.\"}, {\"nama\": \"Perdagangan\", \"deskripsi\": \"Pengelolaan usaha jual beli kebutuhan pokok.\"}, {\"nama\": \"Jasa\", \"deskripsi\": \"Layanan jasa sesuai kebutuhan masyarakat desa.\"}, {\"nama\": \"Pengelolaan UMKM\", \"deskripsi\": \"Pendampingan dan pemasaran produk UMKM desa.\"}]','[{\"nama\": \"Slamet Dariyanto\", \"jabatan\": \"Pengawas\"}, {\"nama\": \"Sukamto\", \"jabatan\": \"Penasehat\"}, {\"nama\": \"Ir. Slamet Alsidama\", \"jabatan\": \"Direktur\"}, {\"nama\": \"Nabila Royi, S.H\", \"jabatan\": \"Sekretaris\"}, {\"nama\": \"Yaumil Izza Idz Fajri\", \"jabatan\": \"Bendahara\"}, {\"nama\": \"Sugeng\", \"jabatan\": \"Manager Unit HIPPAM\"}]','{\"email\": \"desakembiritan7@gmail.com\", \"alamat\": \"Kantor Desa Kembiritan Jl. Raya Genteng-Kembiritan 168\", \"telepon\": \"6285963015004\"}','2025-12-21 12:24:17','2025-12-21 12:31:19');
/*!40000 ALTER TABLE `bumdes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
-- Table structure for table `galeris`
--

DROP TABLE IF EXISTS `galeris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galeris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeris`
--

LOCK TABLES `galeris` WRITE;
/*!40000 ALTER TABLE `galeris` DISABLE KEYS */;
INSERT INTO `galeris` VALUES (1,'Kegiatan 1','2025-12-14','galeri/YK8YLV1W88BSyilJobMVQdU3tJjGefOvAyZMmiJW.jpg','2025-12-19 11:29:13','2025-12-19 14:55:37'),(5,'Kegiatan 2','2025-12-15','galeri/Ft7R0JF1Jo9QqfVrVfGRgHcsW1TVo5zfwL0QgVrQ.jpg','2025-12-19 14:56:17','2025-12-19 14:56:17'),(6,'Kegiatan 3','2025-12-16','galeri/2IpJcNIGIbDRBErgNO3rDb3E9inQ6ahXEX0hStXu.jpg','2025-12-19 14:56:27','2025-12-19 14:56:27'),(7,'Kegiatan 4','2025-12-17','galeri/Qoit8ahYKIVB3uJOmJ4pNMpZzfr1nDjowvCKTRvw.jpg','2025-12-19 14:56:36','2025-12-19 14:56:36'),(8,'Kegiatan 6','2025-12-19','galeri/FlfnSG8up8bAdcZnVHW51lXP4ahYRUpO0224C0aq.jpg','2025-12-19 14:56:45','2025-12-19 14:57:25'),(9,'Kegiatan 5','2025-12-18','galeri/WpRN3KXbRi64BZdh9mZEuFgObaawnIrWnDoRnc6S.jpg','2025-12-19 14:57:14','2025-12-19 14:57:22'),(10,'Kegiatan 7','2025-12-20','galeri/fISPtLaRL9s7BOjdbY406I7LQNKqlBPQYxtmtcDY.jpg','2025-12-19 14:57:50','2025-12-19 14:57:50'),(11,'Kegiatan 8','2025-12-21','galeri/AdOAM9D3vvZdycezX8EOA26ykeXb7iQuIsjrmMMK.jpg','2025-12-19 14:58:02','2025-12-19 14:58:02'),(12,'Kegiatan 12','2025-12-24','galeri/CgrzNmd0FmvfoaSjTjA9NyQKWQD49sD2L9kcJnRV.jpg','2025-12-19 14:58:11','2025-12-19 14:59:18'),(13,'Kegiatan 9','2025-12-22','galeri/fyhFNVBM6Odu5rblOsJCmu5waMJu67ZIUsOlhyiv.jpg','2025-12-19 14:58:29','2025-12-19 14:58:42'),(14,'Kegiatan 11','2025-12-23','galeri/svYJudIOnhcWiLThKT2sUfPq6y831kcbxMQ0RJux.jpg','2025-12-19 14:59:00','2025-12-19 14:59:00'),(15,'Kegiatan 10','2025-12-25','galeri/am92QTN2k6LpLAJd9LrMoeDljRGeSVxYtnGoCIKW.jpg','2025-12-19 14:59:44','2025-12-23 13:27:37');
/*!40000 ALTER TABLE `galeris` ENABLE KEYS */;
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
  `attempts` tinyint unsigned NOT NULL,
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
-- Table structure for table `karang_tarunas`
--

DROP TABLE IF EXISTS `karang_tarunas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `karang_tarunas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` json DEFAULT NULL,
  `program` json DEFAULT NULL,
  `galeri` json DEFAULT NULL,
  `pengurus` json DEFAULT NULL,
  `kontak` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karang_tarunas`
--

LOCK TABLES `karang_tarunas` WRITE;
/*!40000 ALTER TABLE `karang_tarunas` DISABLE KEYS */;
INSERT INTO `karang_tarunas` VALUES (1,'Karang Taruna Cakra Wiguna','Organisasi kepemudaan desa yang berperan aktif dalam kegiatan sosial, pengembangan potensi pemuda, dan pembangunan desa.','Mewujudkan pemuda desa yang mandiri, kreatif, dan peduli terhadap lingkungan sosial.','[\"Meningkatkan peran aktif pemuda dalam pembangunan desa\", \"Mengembangkan kreativitas dan jiwa kewirausahaan pemuda\", \"Menumbuhkan kepedulian sosial dan solidaritas masyarakat\"]','[{\"icon\": \"🌱\", \"judul\": \"Pemuda Peduli Lingkungan\", \"deskripsi\": \"Kegiatan kebersihan desa, penanaman pohon, dan pengelolaan lingkungan.\"}, {\"icon\": \"💼\", \"judul\": \"Pelatihan Kewirausahaan\", \"deskripsi\": \"Pelatihan usaha kecil, UMKM, dan ekonomi kreatif bagi pemuda.\"}, {\"icon\": \"⚽\", \"judul\": \"Olahraga & Seni\", \"deskripsi\": \"Turnamen olahraga, seni budaya, dan kreativitas pemuda.\"}]','[{\"judul\": \"Foto 1\", \"gambar\": \"karang-taruna/galeri/MW6SAVmIMWZ3Ho11hngu1srLjD8BjpST33TuRnqi.jpg\"}, {\"judul\": \"Foto 2\", \"gambar\": \"karang-taruna/galeri/0487RinoVme9T5bILx4vXOl4R8GlwopnnU4LZtFb.jpg\"}, {\"judul\": \"Foto 3\", \"gambar\": \"karang-taruna/galeri/7hVArZwK3JLuBGlU9JL5vxc3IOXZsC5G8v8kJS9w.jpg\"}, {\"judul\": \"Foto 4\", \"gambar\": \"karang-taruna/galeri/TKLB2rrDFRVnKdbzCzn5mByFE5CiYRwG4J8it1Ny.jpg\"}, {\"judul\": \"Foto 5\", \"gambar\": \"karang-taruna/galeri/krDrkOyVICA5TXt26tLJTiHKZqiEnfJIoIRY4Blo.jpg\"}, {\"judul\": \"Foto 6\", \"gambar\": \"karang-taruna/galeri/8VZwgTHmwZ5tHZ6lKPKY4pB0ETfhPIJthmkofQHg.jpg\"}]','[{\"nama\": \"Ketua\", \"gambar\": \"karang-taruna/pengurus/vkQqvMH9OHhayNhl61sqytA7QKIZkKzbHVcDy7J4.jpg\", \"jabatan\": \"Pembina\"}, {\"nama\": \"Saiful\", \"gambar\": \"karang-taruna/pengurus/atWtja4bT4Xs4odZjogC1wvAVlsQYrC1zY3TrPkK.jpg\", \"jabatan\": \"Ketua\"}, {\"nama\": \"Winarto\", \"gambar\": \"karang-taruna/pengurus/jpYtx7eLFXtv9HPmBXMAHGPJSUL5QUA3VXNIAQAx.jpg\", \"jabatan\": \"Wakil Ketua\"}, {\"nama\": \"Naufal Esa Mahendra\", \"gambar\": \"karang-taruna/pengurus/IJq7cP1gpuT1J1dGxfMLq7D2H5zBkaCdFVZdR1mM.jpg\", \"jabatan\": \"Sekretaris\"}, {\"nama\": \"Aeni Yulaily\", \"gambar\": \"karang-taruna/pengurus/BbX9XclaZOxTiSaCbciEjfQZDM1GweJux5WF4W2i.jpg\", \"jabatan\": \"Bendahara\"}, {\"nama\": \"Yoka Aditya Pratama\", \"gambar\": \"karang-taruna/pengurus/ks4aki7Mc9dftjtUQ21KCjusNxNsDNwYsLBxCSDX.jpg\", \"jabatan\": \"Koord. Bid. Pendidikan\"}, {\"nama\": \"Anang Yulianto\", \"gambar\": \"karang-taruna/pengurus/6rU3jvxuowfnUN5Pn3B3imc2aZIh5v40wOl8aey3.jpg\", \"jabatan\": \"Koord. Bid. Usaha & Kesejah. Sosial\"}, {\"nama\": \"Muchlis\", \"gambar\": \"karang-taruna/pengurus/fX8yinRBJFvccAxDjeqUyUcRt7Dbp3GR3c93wlxM.jpg\", \"jabatan\": \"Koord. Bid. Humas & Dakwah\"}]','{\"wa\": \"6285963015004\", \"email\": \"desakembiritan7@gmail.com\", \"instagram\": \"https://instagram.com/kembiritan7\"}','2025-12-21 13:14:53','2025-12-23 12:19:38');
/*!40000 ALTER TABLE `karang_tarunas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `koperasidesa`
--

DROP TABLE IF EXISTS `koperasidesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `koperasidesa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_koperasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `struktur_pengurus` json DEFAULT NULL,
  `syarat_anggota` json DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `koperasidesa`
--

LOCK TABLES `koperasidesa` WRITE;
/*!40000 ALTER TABLE `koperasidesa` DISABLE KEYS */;
INSERT INTO `koperasidesa` VALUES (1,'KDMP Kembiritan','Wadah kolaborasi ekonomi kerakyatan untuk mewujudkan kemandirian, kesejahteraan, dan semangat gotong royong yang berkelanjutan.','[{\"foto\": \"koperasi/pengurus/53tr8wpwejDGHRxqhydzc43hm0zukQJ5dwXJFldm.jpg\", \"nama\": \"Selamet\", \"jabatan\": \"Ketua Koperasi\"}, {\"foto\": \"koperasi/pengurus/ooMrsjNs2NELd9Y6aeo5s6XavLEcOJkCgKZpvv0q.jpg\", \"nama\": \"Hartini\", \"jabatan\": \"Sekretaris\"}, {\"foto\": \"koperasi/pengurus/MJ12Cet62MHdZxES720IR8OJFj1dbt16fODTz2O9.jpg\", \"nama\": \"Joko\", \"jabatan\": \"Bendahara\"}]','[\"Warga Negara Indonesia (WNI) dan berdomisili di wilayah Desa Merah Putih (dibuktikan dengan KTP/KK).\", \"Mengisi formulir pendaftaran keanggotaan.\", \"Membayar Simpanan Pokok sebesar Rp 100.000 (sekali bayar).\", \"Bersedia membayar Simpanan Wajib sebesar Rp 20.000 setiap bulan.\", \"Menyetujui Anggaran Dasar (AD) dan Anggaran Rumah Tangga (ART) Koperasi.\"]','6285963015004','2025-12-21 14:06:51','2025-12-21 14:08:40');
/*!40000 ALTER TABLE `koperasidesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lpmd`
--

DROP TABLE IF EXISTS `lpmd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lpmd` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `dasar_hukum` json DEFAULT NULL,
  `tugas_fungsi` json DEFAULT NULL,
  `struktur_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ketua` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sekretaris` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bendahara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bidang` json DEFAULT NULL,
  `program` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lpmd`
--

LOCK TABLES `lpmd` WRITE;
/*!40000 ALTER TABLE `lpmd` DISABLE KEYS */;
INSERT INTO `lpmd` VALUES (1,'LPMD (Lembaga Pemberdayaan Masyarakat Desa) adalah lembaga yang dibentuk oleh masyarakat desa sebagai mitra pemerintah desa untuk membantu dalam proses perencanaan, pelaksanaan, dan pengendalian pembangunan desa.','[\"Undang-Undang Nomor 6 Tahun 2014 tentang Desa\", \"Permendagri Nomor 18 Tahun 2018 tentang LPMD dan LPMK\", \"Peraturan Desa terkait LPMD\"]','[\"Membantu pemerintah desa dalam perencanaan pembangunan\", \"Menampung dan menyalurkan aspirasi masyarakat\", \"Mendorong partisipasi masyarakat dalam pembangunan\", \"Melaksanakan kegiatan pemberdayaan masyarakat\", \"Melakukan pengawasan terhadap pelaksanaan pembangunan desa\"]','lpmd/eraskgXRVg5xDTatjiOXDqczFG8mFtYc2i5G1Cn9.jpg','Nur Salim','Arief Setyawan','Selamet Dariyanto','[{\"nama_bidang\": \"Bidang Keagamaan\", \"penanggung_jawab\": \"Abdullah Faqih\"}, {\"nama_bidang\": \"Bidang Pembangunan dan Lingkungan Hidup\", \"penanggung_jawab\": \"Bani\"}, {\"nama_bidang\": \"Bidang Ekonomi, Sosial, dan Budaya\", \"penanggung_jawab\": \"Jema\'in Agus Winarno\"}, {\"nama_bidang\": \"Pendidikan, Pemuda dan Olahraga\", \"penanggung_jawab\": \"Sanajid\"}]','[\"Penyusunan perencanaan pembangunan desa\", \"Fasilitasi kegiatan masyarakat\", \"Pelatihan dan pemberdayaan ekonomi masyarakat\", \"Pendampingan kegiatan pembangunan\", \"Monitoring pelaksanaan pembangunan desa\"]','2025-12-20 16:12:15','2025-12-23 11:30:10');
/*!40000 ALTER TABLE `lpmd` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_12_15_101933_add_role_to_users_table',1),(5,'2025_12_16_074300_create_roles_table',1),(6,'2025_12_16_074343_add_is_active_to_users_table',1),(7,'2025_12_16_074400_create_user_profiles_table',1),(8,'2025_12_16_074439_create_permissions_table',1),(9,'2025_12_16_074454_create_role_user_table',1),(10,'2025_12_16_074504_create_permission_role_table',1),(11,'2025_12_16_074610_drop_role_from_users_table',1),(12,'2025_12_17_100034_create_activity_log_table',2),(13,'2025_12_17_100035_add_event_column_to_activity_log_table',2),(14,'2025_12_17_100036_add_batch_uuid_column_to_activity_log_table',2),(15,'2025_12_19_092137_create_aplikasis_table',3),(16,'2025_12_19_163106_create_pesans_table',4),(17,'2025_12_19_180420_create_galeris_table',5),(18,'2025_12_19_221843_create_apbdes_table',6),(19,'2025_12_20_001603_create_pembangunan_table',7),(21,'2025_12_20_220808_create_lpmd_table',8),(22,'2025_12_21_000048_create_posyandus_table',9),(23,'2025_12_21_170251_create_pkk_table',10),(24,'2025_12_21_185258_create_bumdes_table',11),(25,'2025_12_21_194207_create_karang_tarunas_table',12),(26,'2025_12_21_204006_create_koperasidesa_table',13),(27,'2025_12_21_212726_create_administrasi_table',14),(28,'2025_12_21_225041_create_beritas_table',15),(29,'2025_12_22_084334_create_produk_hukum_table',16),(30,'2025_12_22_095225_create_visimisi_table',17),(31,'2025_12_22_101947_create_sejarah_table',18),(32,'2025_12_22_104554_create_perangkat_desa_table',19),(33,'2025_12_22_130604_create_peta_table',20),(34,'2025_12_22_161809_create_beranda_table',21),(35,'2025_12_22_165601_add_views_to_beritas_table',22),(37,'2025_12_22_170945_create_visitors_table',23),(38,'2025_12_23_205337_create_rws_table',24),(39,'2025_12_23_205339_create_rts_table',24),(40,'2025_12_23_223824_add_kades_info_to_beranda_table',25);
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
-- Table structure for table `pembangunan`
--

DROP TABLE IF EXISTS `pembangunan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembangunan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` bigint NOT NULL,
  `sumber_dana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelaksana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Proses',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `foto` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pembangunan_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembangunan`
--

LOCK TABLES `pembangunan` WRITE;
/*!40000 ALTER TABLE `pembangunan` DISABLE KEYS */;
INSERT INTO `pembangunan` VALUES (2,'pavingisasi-jalan-A0wjn','Pavingisasi Jalan Jalan','Kaliputih','RT 02 / RW 01','600 M',300000000,'Dana Desa','2024','Budi Saja','Proses','Pavingisasi jalan masih proses pengerjaan untuk kelancaran transportasi.','[\"pembangunan/8Y4Tkl4uB7l3DiQxQ8v67RPTTGFXlhD4BelGQrAe.jpg\", \"pembangunan/A6DLvHFzNaenNPQkIIOgnZUcURZk6eN8KXWVoqwB.jpg\"]','2025-12-20 13:14:02','2025-12-21 14:11:14'),(3,'pembangunan-jembatan-OAFIM','Pembangunan Jembatan','Pandan','RT 03 / RW 04','5 M',50000000,'BanProv','2025','Bambang Supriyanto','Proses','Masih Proses','[\"pembangunan/zKAb1w8vsxWOHNlFhQAbJiCnQTIOBloNnNUSP32z.jpg\"]','2025-12-20 13:37:58','2025-12-21 14:11:02'),(4,'pembangunan-jalan-beton-pzx7g','Pembangunan Jalan Beton','Krajan Satu','RT 03 / RW 10','250 M',500000000,'BHPRD','2025','Selamet Hariyanto','Proses','Masih Proses pembangunan belum selesai','[\"pembangunan/D7hvAFdCPqVqhIwzu5zvAAkBLLaDhLYqPawhMK45.jpg\", \"pembangunan/CkDDdKfZeMxbMlSdmi8ATMJrZufqMWyPId9zS3XI.jpg\", \"pembangunan/4ar8Nm0KDv4YqYCdXE2GK5eplLaHzrhLIbD270xM.jpg\", \"pembangunan/MZqMoWj6znrwPjS4XfPHtZCaJvfbqYUui5lN7tVQ.jpg\", \"pembangunan/0hyPtmSPATsKlnhhH53zTn60dkm4hkq5kMSqtHc8.jpg\"]','2025-12-20 13:40:03','2025-12-21 14:10:50'),(5,'bedah-rumah-BZJsi','Bedah Rumah','Cendono','RT 03 / RW 2','72 M',72000000,'PADes','2024','Suliyanto','Selesai','Pembangunan berhasil di selesaikan dengan Baik, rumah Ibu Sarbini.','[\"pembangunan/CNfhhHjD6TGhBnmkyCEEMQSYrGs9IwqJMz7sIEnF.jpg\", \"pembangunan/zFnFFEMZ4CBrY2AJaybkqSNKIS90EHsNiqlaBCo4.jpg\", \"pembangunan/ovWtYBfF5Rmh2LD7Q7uj0xbjNKyh8Slc162Tjawp.jpg\"]','2025-12-20 13:41:35','2025-12-21 14:10:20'),(6,'pengaspalan-jalan-cT4Ex','Pengaspalan Jalan','Pandan','RT. 05 / RW. 11','200 M',250000000,'ADD','2023','Adhi Hidayat','Selesai','Pengaspalan masih proses pelaksanaan dan masih tahap perabatan','[\"pembangunan/F8JHyCCoasX5udMlpx3w0L4im9t16nBVFHAy79uw.jpg\", \"pembangunan/8h6cls6uxmaapUMeBsSSd3L9unzmuYu6sTjcUfWs.jpg\", \"pembangunan/rvY35qJAWSUf6RkVpw5xZFqPvX0l0OiHE9FSQQq0.jpg\"]','2025-12-20 13:43:22','2025-12-21 14:10:02');
/*!40000 ALTER TABLE `pembangunan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perangkat_desa`
--

DROP TABLE IF EXISTS `perangkat_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perangkat_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto_struktur_organisasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_perangkat` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perangkat_desa`
--

LOCK TABLES `perangkat_desa` WRITE;
/*!40000 ALTER TABLE `perangkat_desa` DISABLE KEYS */;
INSERT INTO `perangkat_desa` VALUES (1,'perangkat-desa/uvCKfn0szbIvaTYHA05a1qGGhy8DReYVDjgrtFBL.webp','[{\"foto\": \"perangkat-desa/staff/55VVLxUP4S7CCIHwZP5edpqcV8lGSQok04lzLN00.jpg\", \"nama\": \"Ridho Kurniawan\", \"jabatan\": \"Kepala Desa\"}, {\"foto\": \"perangkat-desa/staff/1NOVNe68ocssLoBLHpizCZyA9jGbFvmIV7n7hv1B.jpg\", \"nama\": \"Supriyadi\", \"jabatan\": \"Wakil Kepala Desa\"}, {\"foto\": \"perangkat-desa/staff/86HM38jpycT71wUvlUK4fZaOSsmOgIQcsv6RIFEx.jpg\", \"nama\": \"Supratman\", \"jabatan\": \"Sekretaris\"}, {\"foto\": \"perangkat-desa/staff/tMfb2T9YPaeKZjm6i3oAFWWuT7L3qNEnzlRMOF2J.jpg\", \"nama\": \"Supretmen\", \"jabatan\": \"Bendahara\"}, {\"foto\": \"perangkat-desa/staff/BGaJckHvnBC42l692iVLwk9LaxfigsEpX8AjZ7WJ.jpg\", \"nama\": \"Supriyanti\", \"jabatan\": \"Staff\"}]','2025-12-22 04:04:30','2025-12-23 09:29:47');
/*!40000 ALTER TABLE `perangkat_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_role` (
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(8,1),(9,1),(10,1),(1,2),(8,2),(9,2),(10,2),(1,3),(8,3),(9,3),(1,4),(8,4),(9,4),(10,4),(1,5),(8,5),(9,5),(1,6),(8,6),(9,6),(10,6),(1,7),(8,7),(9,7),(1,8),(8,8),(9,8),(10,8),(1,9),(8,9),(9,9),(1,10),(8,10),(9,10),(1,11),(8,11),(1,12),(8,12),(9,12),(10,12),(1,13),(8,13),(9,13),(1,14),(8,14),(9,14),(10,14),(1,15),(8,15),(9,15),(10,15),(1,16),(8,16),(9,16),(1,17),(8,17),(9,17),(1,18),(8,18),(1,19),(8,19),(9,19),(10,19),(1,20),(8,20),(9,20),(1,21),(8,21),(9,21),(1,22),(8,22),(1,23),(8,23),(9,23),(10,23),(1,24),(8,24),(9,24),(1,25),(8,25),(9,25),(1,26),(8,26),(1,27),(8,27),(9,27),(10,27),(1,28),(8,28),(9,28),(10,28),(1,29),(8,29),(9,29),(1,30),(8,30),(9,30),(1,31),(8,31),(1,32),(8,32),(9,32),(10,32),(1,33),(8,33),(9,33),(1,34),(8,34),(9,34),(1,35),(8,35),(1,36),(8,36),(9,36),(10,36),(1,37),(8,37),(9,37),(1,38),(8,38),(9,38),(1,39),(8,39),(1,40),(8,40),(9,40),(10,40),(1,41),(8,41),(9,41),(1,42),(8,42),(9,42),(1,43),(8,43),(1,44),(8,44),(9,44),(10,44),(1,45),(8,45),(9,45),(1,46),(8,46),(9,46),(1,47),(8,47),(1,48),(8,48),(9,48),(10,48),(1,49),(8,49),(9,49),(1,50),(8,50),(9,50),(1,51),(8,51),(1,52),(8,52),(9,52),(10,52),(1,53),(8,53),(9,53),(10,53),(1,54),(8,54),(9,54),(1,55),(8,55),(9,55),(1,56),(8,56),(1,57),(8,57),(9,57),(10,57),(1,58),(8,58),(9,58),(1,59),(8,59),(9,59),(1,60),(8,60),(1,61),(8,61),(9,61),(10,61),(1,62),(8,62),(9,62),(1,63),(8,63),(9,63),(1,64),(8,64),(1,65),(8,65),(9,65),(10,65),(1,66),(8,66),(9,66),(1,67),(8,67),(1,68),(8,68),(8,69),(8,70),(8,71),(8,72),(8,73),(8,74),(8,75),(8,76),(8,77),(8,78),(8,79),(8,80),(8,81),(1,83),(8,83),(1,84),(8,84),(10,84),(1,85),(8,85),(1,86),(8,86),(9,86),(1,87),(8,87),(1,88),(8,88),(1,89),(8,89),(8,90),(1,91),(8,91),(9,91),(10,91),(1,92),(8,92),(9,92),(1,93),(8,93),(1,94),(8,94);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'dashboard.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(2,'profil.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(3,'profil.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(4,'visi-misi.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(5,'visi-misi.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(6,'sejarah.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(7,'sejarah.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(8,'perangkat.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(9,'perangkat.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(10,'perangkat.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(11,'perangkat.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(12,'peta.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(13,'peta.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(14,'informasi.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(15,'syarat.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(16,'syarat.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(17,'syarat.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(18,'syarat.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(19,'berita.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(20,'berita.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(21,'berita.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(22,'berita.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(23,'produk-hukum.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(24,'produk-hukum.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(25,'produk-hukum.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(26,'produk-hukum.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(27,'lembaga.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(28,'lpmd.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(29,'lpmd.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(30,'lpmd.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(31,'lpmd.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(32,'posyandu.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(33,'posyandu.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(34,'posyandu.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(35,'posyandu.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(36,'pkk.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(37,'pkk.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(38,'pkk.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(39,'pkk.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(40,'bumdes.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(41,'bumdes.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(42,'bumdes.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(43,'bumdes.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(44,'karang-taruna.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(45,'karang-taruna.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(46,'karang-taruna.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(47,'karang-taruna.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(48,'koperasi.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(49,'koperasi.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(50,'koperasi.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(51,'koperasi.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(52,'transparansi.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(53,'apbdes.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(54,'apbdes.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(55,'apbdes.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(56,'apbdes.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(57,'pembangunan.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(58,'pembangunan.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(59,'pembangunan.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(60,'pembangunan.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(61,'galeri.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(62,'galeri.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(63,'galeri.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(64,'galeri.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(65,'pesan.view','2025-12-17 17:06:44','2025-12-19 09:22:28'),(66,'pesan.delete','2025-12-17 17:06:44','2025-12-19 09:22:40'),(67,'aplikasi.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(68,'aplikasi.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(69,'user.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(70,'user.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(71,'user.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(72,'user.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(73,'roles.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(74,'roles.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(75,'roles.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(76,'roles.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(77,'permissions.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(78,'permissions.create','2025-12-17 17:06:44','2025-12-17 17:06:44'),(79,'permissions.update','2025-12-17 17:06:44','2025-12-17 17:06:44'),(80,'permissions.delete','2025-12-17 17:06:44','2025-12-17 17:06:44'),(81,'logactivity.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(83,'setting.view','2025-12-17 17:06:44','2025-12-17 17:06:44'),(84,'beranda.view','2025-12-21 16:33:14','2025-12-21 16:33:14'),(85,'beranda.create','2025-12-21 16:33:21','2025-12-21 16:33:21'),(86,'beranda.update','2025-12-21 16:33:32','2025-12-21 16:33:32'),(87,'visi-misi.create','2025-12-22 02:47:00','2025-12-22 02:47:00'),(88,'sejarah.create','2025-12-22 03:12:08','2025-12-22 03:12:08'),(89,'peta.create','2025-12-22 05:58:17','2025-12-22 05:58:17'),(90,'pengaturan.view','2025-12-22 14:07:21','2025-12-22 14:07:21'),(91,'rtrw.view','2025-12-23 13:14:30','2025-12-23 13:14:30'),(92,'rtrw.create','2025-12-23 13:14:35','2025-12-23 13:14:35'),(93,'rtrw.update','2025-12-23 13:14:40','2025-12-23 13:14:40'),(94,'rtrw.delete','2025-12-23 13:14:45','2025-12-23 13:14:45');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesans`
--

DROP TABLE IF EXISTS `pesans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesans`
--

LOCK TABLES `pesans` WRITE;
/*!40000 ALTER TABLE `pesans` DISABLE KEYS */;
INSERT INTO `pesans` VALUES (1,'Pengunjung 1','user1@example.com','083126321210','Pesan Dummy #1','Ini adalah isi pesan dummy ke-1. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(2,'Pengunjung 2','user2@example.com','086282568465','Pesan Dummy #2','Ini adalah isi pesan dummy ke-2. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(3,'Pengunjung 3','user3@example.com','084156195604','Pesan Dummy #3','Ini adalah isi pesan dummy ke-3. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(4,'Pengunjung 4','user4@example.com','083256700549','Pesan Dummy #4','Ini adalah isi pesan dummy ke-4. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(5,'Pengunjung 5','user5@example.com','085413390278','Pesan Dummy #5','Ini adalah isi pesan dummy ke-5. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(6,'Pengunjung 6','user6@example.com','084050687569','Pesan Dummy #6','Ini adalah isi pesan dummy ke-6. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(7,'Pengunjung 7','user7@example.com','082881268503','Pesan Dummy #7','Ini adalah isi pesan dummy ke-7. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(8,'Pengunjung 8','user8@example.com','085809363502','Pesan Dummy #8','Ini adalah isi pesan dummy ke-8. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(9,'Pengunjung 9','user9@example.com','082901727351','Pesan Dummy #9','Ini adalah isi pesan dummy ke-9. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(10,'Pengunjung 10','user10@example.com','086018963089','Pesan Dummy #10','Ini adalah isi pesan dummy ke-10. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(11,'Pengunjung 11','user11@example.com','083559470606','Pesan Dummy #11','Ini adalah isi pesan dummy ke-11. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(12,'Pengunjung 12','user12@example.com','087739816316','Pesan Dummy #12','Ini adalah isi pesan dummy ke-12. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(13,'Pengunjung 13','user13@example.com','086458707301','Pesan Dummy #13','Ini adalah isi pesan dummy ke-13. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(14,'Pengunjung 14','user14@example.com','083373667877','Pesan Dummy #14','Ini adalah isi pesan dummy ke-14. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(15,'Pengunjung 15','user15@example.com','085576974393','Pesan Dummy #15','Ini adalah isi pesan dummy ke-15. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(16,'Pengunjung 16','user16@example.com','082000952437','Pesan Dummy #16','Ini adalah isi pesan dummy ke-16. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(17,'Pengunjung 17','user17@example.com','089534066697','Pesan Dummy #17','Ini adalah isi pesan dummy ke-17. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(18,'Pengunjung 18','user18@example.com','081331280879','Pesan Dummy #18','Ini adalah isi pesan dummy ke-18. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(19,'Pengunjung 19','user19@example.com','087138393207','Pesan Dummy #19','Ini adalah isi pesan dummy ke-19. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(20,'Pengunjung 20','user20@example.com','083035205467','Pesan Dummy #20','Ini adalah isi pesan dummy ke-20. Digunakan untuk testing halaman admin pesan kontak.','2025-12-19 09:57:16','2025-12-19 09:57:16'),(21,'Ridho Kurniawan','uyeuye@gmail.com','089682154449','Jalan Rusak di daerah Pandan Kembiritan','segera perbaiki, kasihan warna disana, dengan akses jalan seperti itu membuat transportasi susah untuk melewatinya','2025-12-23 13:34:45','2025-12-23 13:34:45');
/*!40000 ALTER TABLE `pesans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peta`
--

DROP TABLE IF EXISTS `peta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `batas_utara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batas_timur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batas_selatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batas_barat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_wilayah` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Dalam meter persegi',
  `koordinat_kantor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Lat,Long contoh: -8.36770, 114.18542',
  `polygon_wilayah` json DEFAULT NULL COMMENT 'Array koordinat polygon',
  `zoom_level` int NOT NULL DEFAULT '15',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peta`
--

LOCK TABLES `peta` WRITE;
/*!40000 ALTER TABLE `peta` DISABLE KEYS */;
INSERT INTO `peta` VALUES (1,'DESA NANGA ENGKULUN','DESA LANDAU KUMPAI','DESA LANDAU APIN','DESA CENAYAN',54482300.00,'-8.366282637768037, 114.19425487518312','[[-8.371463, 114.191422], [-8.378893, 114.196014], [-8.377874, 114.214983], [-8.365264, 114.215069], [-8.36365, 114.200563], [-8.371463, 114.191422]]',15,'2025-12-22 16:16:11','2025-12-22 16:17:50');
/*!40000 ALTER TABLE `peta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pkk`
--

DROP TABLE IF EXISTS `pkk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pkk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_ketua` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp_wa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar_ilustrasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengurus` json DEFAULT NULL,
  `kegiatan` json DEFAULT NULL,
  `program_pokok` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pkk`
--

LOCK TABLES `pkk` WRITE;
/*!40000 ALTER TABLE `pkk` DISABLE KEYS */;
INSERT INTO `pkk` VALUES (1,'Nama Lengkap Ketua','628123456111','pkk/ilustrasi/gscE3YjoCp3s7Ys63ptxxeVV1IPwzbzFnq2Q7oGo.jpg','[{\"nama\": \"Nama Ketua\", \"jabatan\": \"Ketua\", \"photo_url\": \"pkk/pengurus/bpcuwHdkLcG3ScCEeKm73WbWW8ZYp5N8Dq4pqc7D.jpg\"}, {\"nama\": \"Nama Wakil Ketua\", \"jabatan\": \"Wakil Ketua\", \"photo_url\": \"pkk/pengurus/vNWiIk8b31pRzLCUP0jqoF6RpQ7YCdQjfvoBSuQw.jpg\"}, {\"nama\": \"Nama Sekretaris\", \"jabatan\": \"Sekretaris\", \"photo_url\": \"pkk/pengurus/zI696FDOO6y2N9nehxlSGwXHIG2w3HWwuqT3JMGI.jpg\"}, {\"nama\": \"Nama Bendahara\", \"jabatan\": \"Bendahara\", \"photo_url\": \"pkk/pengurus/Bph7swetbwVXPove0P7mNYZBlKISqLaiyXY0APm2.jpg\"}, {\"nama\": \"iyawes apa saja\", \"jabatan\": \"coba ini\", \"photo_url\": \"pkk/pengurus/GxOfYQivkBIfIsaXRRtBCfPqXucIWeNS6jCUgPPd.jpg\"}]','[\"Posyandu Balita & Lansia\", \"Pelatihan Keterampilan Ibu Rumah Tangga\", \"Pembinaan UMKM Desa\", \"Penyuluhan Kesehatan Keluarga\", \"Kerja Bakti Lingkungan\"]','[\"Penghayatan dan Pengamalan Pancasila\", \"Gotong Royong\", \"Pangan\", \"Sandang\", \"Perumahan dan Tata Laksana Rumah Tangga\", \"Pendidikan dan Keterampilan\", \"Kesehatan\", \"Pengembangan Kehidupan Berkoperasi\", \"Kelestarian Lingkungan Hidup\", \"Perencanaan Sehat\"]','2025-12-21 11:03:34','2025-12-23 11:59:17');
/*!40000 ALTER TABLE `pkk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posyandus`
--

DROP TABLE IF EXISTS `posyandus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posyandus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` json DEFAULT NULL,
  `layanan` json DEFAULT NULL,
  `sasaran` json DEFAULT NULL,
  `jadwal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar_struktur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ketua` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_sekretaris` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_bendahara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kader` json DEFAULT NULL,
  `program` json DEFAULT NULL,
  `kontak` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posyandus`
--

LOCK TABLES `posyandus` WRITE;
/*!40000 ALTER TABLE `posyandus` DISABLE KEYS */;
INSERT INTO `posyandus` VALUES (1,'Posyandu (Pos Pelayanan Terpadu) adalah wadah pelayanan kesehatan yang dikelola dari, oleh, dan untuk masyarakat dalam penyelenggaraan pembangunan kesehatan agar masyarakat memperoleh pelayanan dasar yang dekat, cepat, dan mudah dijangkau.','[\"Meningkatkan derajat kesehatan masyarakat terutama ibu dan anak.\", \"Meningkatkan cakupan pelayanan kesehatan dasar.\", \"Mendorong peran serta masyarakat dalam penyelenggaraan kesehatan.\", \"Mempermudah akses masyarakat terhadap pelayanan kesehatan.\"]','[\"Penimbangan balita\", \"Pelayanan imunisasi\", \"Pemeriksaan ibu hamil\", \"Konseling gizi dan kesehatan\", \"Pelayanan imunisasi\", \"Pemberian vitamin & PMT (Pemberian Makanan Tambahan)\", \"Pencatatan dan pelaporan kesehatan ibu & anak\"]','[\"Balita\", \"Ibu hamil\", \"Ibu menyusui\", \"Pasangan usia subur\", \"Lansia (jika termasuk Posyandu Lansia)\"]','Setiap tanggal 10 setiap bulan di Balai Desa','posyandu/3YPInyMzdDfMNsUuENZJQqShMiSZF0TzBdCGKxiY.jpg','Supri','Supra','Supro','[\"Elly Hakim\", \"Siti Fatimah\", \"Suparti\", \"Yulia Elsani\", \"Iin Nur Kholifah\", \"Ninik Idayanti\", \"Anisah Fatma\", \"Devi Ratnasari\", \"Yayuk Istiqomah\", \"Susiani Ariska Sari\", \"Sri Wahyuni\", \"Endang Sukliyowati\", \"Nur Khotimah\", \"Rita Unaini\", \"Sri Purwaningsih\", \"Siti Rohasanah\", \"Rini Nurimama\", \"Widya Retnaning Puspita\", \"Isnaini\", \"Masruroh\", \"Mimin Nurhayati\", \"Nurul Hidayah\", \"Linda Dwi Jayanti\", \"Siti Mutmainah\", \"Erni Yunita\", \"Siti Aminah\", \"Ida Fatmawati\", \"Mariyanah\", \"Rumiyati\", \"Purwatiningsih\", \"Tholifah\"]','[\"Pelaksanaan Posyandu rutin setiap bulan.\", \"Pemberian PMT balita.\", \"Pemeriksaan ibu hamil dan konseling.\", \"Pelatihan kader posyandu.\", \"Pendataan tumbuh kembang balita.\"]','[{\"nama\": \"Supra\", \"jabatan\": \"Ketua\", \"telepon\": \"08123456789\"}, {\"nama\": \"Supri\", \"jabatan\": \"Sekretaris\", \"telepon\": \"08123456789\"}, {\"nama\": \"Supro\", \"jabatan\": \"Bendahara\", \"telepon\": \"08123456789\"}]','2025-12-20 17:30:11','2025-12-23 11:44:25');
/*!40000 ALTER TABLE `posyandus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produk_hukum`
--

DROP TABLE IF EXISTS `produk_hukum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produk_hukum` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('Peraturan Desa','Peraturan Kepala Desa','Keputusan Kepala Desa','Surat Edaran') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produk_hukum`
--

LOCK TABLES `produk_hukum` WRITE;
/*!40000 ALTER TABLE `produk_hukum` DISABLE KEYS */;
INSERT INTO `produk_hukum` VALUES (2,'Surat Edaran Kepala Desa','Surat Edaran',2025,'produk-hukum/XaRO7WBW1kAjzmyLtfmIzX9JskW2afAp3uYRCKIX.pdf','2025-12-22 02:24:30','2025-12-22 02:24:30'),(3,'Dokumen 2','Peraturan Desa',2025,'produk-hukum/5RCYjRiSaYhbNaE8MgRJGr5lY5ZV7Q6iAt6nUZxm.pdf','2025-12-23 11:11:21','2025-12-23 11:11:21'),(4,'Dokumen 3','Peraturan Desa',2025,'produk-hukum/2V8gJ1IO2iYBeEGL164Qjao1sGBtemKuxiybRQN1.pdf','2025-12-23 11:11:32','2025-12-23 11:11:32'),(5,'Dokumen 4','Peraturan Kepala Desa',2025,'produk-hukum/4XxS4W51rAXSUm5HROJ1Sj5zC5KIjf5wGThZIrVW.pdf','2025-12-23 11:11:41','2025-12-23 11:11:41'),(6,'Dokumen 5','Keputusan Kepala Desa',2024,'produk-hukum/f5xdNeej9XfaJ5pqtT0wiNVScfStrLDerXkdWb82.pdf','2025-12-23 11:11:56','2025-12-23 11:11:56'),(7,'Dokumen 6','Keputusan Kepala Desa',2024,'produk-hukum/VGYkyIezXGkI9dzEpXEOgOP2kwAqNKidDvdRXQzG.pdf','2025-12-23 11:12:21','2025-12-23 11:12:21'),(8,'Dokumen 7','Peraturan Kepala Desa',2023,'produk-hukum/xdvMhLs4lArFKUyUyJkgS7kVSIs1eGEEDdUq9fju.pdf','2025-12-23 11:12:32','2025-12-23 11:12:32');
/*!40000 ALTER TABLE `produk_hukum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_user` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,8),(6,8);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2025-12-16 01:26:05','2025-12-19 14:46:35'),(8,'superadmin','2025-12-18 12:26:48','2025-12-18 12:26:48'),(9,'operator','2025-12-18 12:39:16','2025-12-18 12:39:16'),(10,'staff','2025-12-18 12:41:18','2025-12-18 12:41:18');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rts`
--

DROP TABLE IF EXISTS `rts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rw_id` bigint unsigned NOT NULL,
  `nomor_rt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua_rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rts_rw_id_nomor_rt_unique` (`rw_id`,`nomor_rt`),
  CONSTRAINT `rts_rw_id_foreign` FOREIGN KEY (`rw_id`) REFERENCES `rws` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rts`
--

LOCK TABLES `rts` WRITE;
/*!40000 ALTER TABLE `rts` DISABLE KEYS */;
INSERT INTO `rts` VALUES (5,5,'02','Fathur Efendi','2025-12-23 15:18:04','2025-12-23 15:18:04'),(6,5,'03','Moh. Izudin','2025-12-23 15:18:04','2025-12-23 15:18:04'),(7,5,'04','Untung A.S.','2025-12-23 15:18:04','2025-12-23 15:18:04'),(8,5,'01','Rokhim','2025-12-23 15:20:18','2025-12-23 15:20:18'),(9,6,'01','Anis Selviana A., S.E','2025-12-23 15:22:04','2025-12-23 15:22:04'),(10,6,'02','Sumariyo','2025-12-23 15:22:04','2025-12-23 15:22:04'),(11,6,'03','Saiful Efendi','2025-12-23 15:22:04','2025-12-23 15:22:04'),(12,7,'01','Varis Afif Efendi','2025-12-23 15:22:53','2025-12-23 15:22:53'),(13,7,'02','Deni Wahyu P.','2025-12-23 15:22:53','2025-12-23 15:22:53'),(14,7,'03','Muhaimin','2025-12-23 15:22:53','2025-12-23 15:22:53'),(15,8,'01','Basukiyanto','2025-12-23 15:23:35','2025-12-23 15:23:35'),(16,8,'02','Karyono','2025-12-23 15:23:35','2025-12-23 15:23:35'),(17,8,'03','Sugeng Prayitno','2025-12-23 15:23:35','2025-12-23 15:23:35'),(18,9,'01','Samsu Hadi','2025-12-23 15:24:17','2025-12-23 15:24:17'),(19,9,'02','Samuri','2025-12-23 15:24:17','2025-12-23 15:24:17'),(20,9,'03','Moh. Alimron','2025-12-23 15:24:17','2025-12-23 15:24:17'),(21,10,'02','Sarto Ertanto','2025-12-23 15:25:21','2025-12-23 15:25:21'),(22,10,'03','Heri Setyanto','2025-12-23 15:25:21','2025-12-23 15:25:21'),(23,10,'04','Supri','2025-12-23 15:25:21','2025-12-23 15:25:21'),(24,10,'05','Sunarto','2025-12-23 15:25:21','2025-12-23 15:25:21');
/*!40000 ALTER TABLE `rts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rws`
--

DROP TABLE IF EXISTS `rws`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rws` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dusun` enum('Krajan Satu','Krajan Dua','Kaliputih','Temurejo','Pandan','Cendono','Ringinsari') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rw` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua_rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rws`
--

LOCK TABLES `rws` WRITE;
/*!40000 ALTER TABLE `rws` DISABLE KEYS */;
INSERT INTO `rws` VALUES (5,'Krajan Satu','01','Rokhim','2025-12-23 15:14:02','2025-12-23 15:14:18'),(6,'Krajan Satu','02','Karyadi','2025-12-23 15:20:01','2025-12-23 15:20:01'),(7,'Krajan Satu','03','Imam Sibro Wilis','2025-12-23 15:22:20','2025-12-23 15:22:20'),(8,'Krajan Satu','04','Hanafi','2025-12-23 15:23:04','2025-12-23 15:23:04'),(9,'Krajan Satu','05','Suyadi','2025-12-23 15:23:48','2025-12-23 15:23:48'),(10,'Krajan Satu','06','Iwan Susanto','2025-12-23 15:24:35','2025-12-23 15:24:35'),(11,'Krajan Dua','07','Nurchuda','2025-12-23 15:26:17','2025-12-23 15:26:17');
/*!40000 ALTER TABLE `rws` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejarah`
--

DROP TABLE IF EXISTS `sejarah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sejarah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asal_usul` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeline` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sejarah`
--

LOCK TABLES `sejarah` WRITE;
/*!40000 ALTER TABLE `sejarah` DISABLE KEYS */;
INSERT INTO `sejarah` VALUES (1,'sejarah/TvSlngPlsiF5f937kXsfofhsSbAZn0muCg4v2SHO.jpg','Desa ini berdiri pada sekitar tahun 1900-an sebagai permukiman kecil yang dipimpin oleh tokoh masyarakat setempat. Pada awalnya, wilayah ini masih berupa hutan dan ladang, kemudian berkembang menjadi kawasan pemukiman tetap.\r\nPada masa kolonial, desa ini mulai dikenal karena memiliki potensi hasil bumi yang melimpah, sehingga menarik banyak penduduk untuk menetap. Seiring berjalannya waktu, desa ini mengalami perkembangan pesat dalam bidang sosial, ekonomi, serta budaya.\r\nHingga saat ini, Desa terus menjaga nilai-nilai tradisi leluhur sambil tetap beradaptasi dengan perkembangan zaman agar tetap maju dan sejahtera.','[{\"ket\": \"Pemukiman kecil mulai terbentuk oleh beberapa keluarga.\", \"judul\": \"1900 : Awal Pembentukan\"}, {\"ket\": \"Desa resmi diakui sebagai wilayah administrasi pemerintahan.\", \"judul\": \"1950 : Pengakuan Administratif\"}, {\"ket\": \"Mulai dibangun jalan desa, irigasi, dan fasilitas publik.\", \"judul\": \"1980 : Pembangunan Infrastruktur\"}, {\"ket\": \"Desa mulai menerima akses teknologi dan program pemberdayaan masyarakat.\", \"judul\": \"2000 : Modernisasi\"}, {\"ket\": \"Pemerintah Desa mengembangkan layanan digital dan transparansi publik.\", \"judul\": \"Sekarang : Era Digital\"}]','2025-12-22 03:39:47','2025-12-23 07:14:33');
/*!40000 ALTER TABLE `sejarah` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('CardQaDHdV4KFKO6gL1QSisK0G5gGLdgFhvoK68Z',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieVlRUWVSMU5lclBpb1BFNVZ3eG5QRGVIcHRVcmVqdmlwRUtncGZjdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly93ZWJzaWRlc2EudGVzdCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1767066394),('P5yineXIZnOiIBCzEN7Do4dOBulBzmkl1IYTv7UJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicHo1VlB1a3cxaGxGcDYxQnRSek9XbldQb1dLMnFLMXZXa2pKRDFvRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly93ZWJzaWRlc2EudGVzdCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1767164809);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ridho Kurniawan','ridho@gmail.com',NULL,'$2y$12$EGWM0Ca2zYAs3rTmSbW20eRDENP6Dobxli7VsCqzJnGgBsH6iwa0C',1,NULL,'2025-12-16 01:26:06','2025-12-23 15:32:04'),(6,'Bakti','bakti@gmail.com',NULL,'$2y$12$vOhz3VDgWgx1ROtcelYBLecxgT3bXYdKSRCSR6f1NwZl7syBzK3WG',1,NULL,'2025-12-23 15:30:52','2025-12-23 15:30:52');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visimisi`
--

DROP TABLE IF EXISTS `visimisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visimisi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visimisi`
--

LOCK TABLES `visimisi` WRITE;
/*!40000 ALTER TABLE `visimisi` DISABLE KEYS */;
INSERT INTO `visimisi` VALUES (1,'Terwujudnya Desa yang Maju, Mandiri, Sejahtera, dan Berbudaya dengan Mengedepankan Pelayanan Publik Prima serta Pembangunan Berkelanjutan.','[\"Meningkatkan kualitas pelayanan publik yang cepat, tepat, dan transparan.\", \"Mengembangkan potensi ekonomi desa berbasis UMKM dan pertanian.\", \"Meningkatkan pembangunan infrastruktur yang merata dan berkelanjutan.\", \"Mendorong partisipasi masyarakat dalam pembangunan desa.\", \"Melestarikan budaya lokal dan memperkuat nilai-nilai sosial kemasyarakatan.\"]','2025-12-22 03:08:32','2025-12-23 06:24:34');
/*!40000 ALTER TABLE `visimisi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitors_ip_address_index` (`ip_address`),
  KEY `visitors_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitors`
--

LOCK TABLES `visitors` WRITE;
/*!40000 ALTER TABLE `visitors` DISABLE KEYS */;
INSERT INTO `visitors` VALUES (1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 13:59:48','2025-12-23 13:59:48'),(2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:07:08','2025-12-23 14:07:08'),(3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:07:43','2025-12-23 14:07:43'),(4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:07:59','2025-12-23 14:07:59'),(5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:08:25','2025-12-23 14:08:25'),(6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:09:45','2025-12-23 14:09:45'),(7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:10:28','2025-12-23 14:10:28'),(8,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:10:53','2025-12-23 14:10:53'),(9,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:11:22','2025-12-23 14:11:22'),(10,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:14:24','2025-12-23 14:14:24'),(11,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:17:04','2025-12-23 14:17:04'),(12,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:26:19','2025-12-23 14:26:19'),(13,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:37:22','2025-12-23 14:37:22'),(14,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:37:39','2025-12-23 14:37:39'),(15,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:51:35','2025-12-23 14:51:35'),(16,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/kontak',1,'2025-12-23 14:52:10','2025-12-23 14:52:10'),(17,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/visi-misi','GET','http://websidesa.test/kontak',1,'2025-12-23 14:52:44','2025-12-23 14:52:44'),(18,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/administrasi','GET','http://websidesa.test/visi-misi',1,'2025-12-23 14:52:45','2025-12-23 14:52:45'),(19,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/visi-misi','GET','http://websidesa.test/administrasi',1,'2025-12-23 14:52:46','2025-12-23 14:52:46'),(20,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/sejarah-desa','GET','http://websidesa.test/visi-misi',1,'2025-12-23 14:52:47','2025-12-23 14:52:47'),(21,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/perangkat-desa','GET','http://websidesa.test/sejarah-desa',1,'2025-12-23 14:52:48','2025-12-23 14:52:48'),(22,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/peta-desa','GET','http://websidesa.test/perangkat-desa',1,'2025-12-23 14:52:50','2025-12-23 14:52:50'),(23,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/administrasi','GET','http://websidesa.test/peta-desa',1,'2025-12-23 14:52:52','2025-12-23 14:52:52'),(24,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/administrasi',1,'2025-12-23 14:52:56','2025-12-23 14:52:56'),(25,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/berita',1,'2025-12-23 14:52:59','2025-12-23 14:52:59'),(26,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:53:01','2025-12-23 14:53:01'),(27,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/berita',1,'2025-12-23 14:53:03','2025-12-23 14:53:03'),(28,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:55:06','2025-12-23 14:55:06'),(29,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:56:30','2025-12-23 14:56:30'),(30,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:56:36','2025-12-23 14:56:36'),(31,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:57:03','2025-12-23 14:57:03'),(32,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:57:30','2025-12-23 14:57:30'),(33,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 14:58:13','2025-12-23 14:58:13'),(34,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:02:09','2025-12-23 15:02:09'),(35,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:02:13','2025-12-23 15:02:13'),(36,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:02:44','2025-12-23 15:02:44'),(37,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:03:01','2025-12-23 15:03:01'),(38,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:03:01','2025-12-23 15:03:01'),(39,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/lpmd','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:03:25','2025-12-23 15:03:25'),(40,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:04:01','2025-12-23 15:04:01'),(41,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:06:47','2025-12-23 15:06:47'),(42,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw','GET','http://websidesa.test/produk-hukum',1,'2025-12-23 15:06:51','2025-12-23 15:06:51'),(43,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw','GET',NULL,1,'2025-12-23 15:07:08','2025-12-23 15:07:08'),(44,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=Temurejo&q=','GET','http://websidesa.test/rt-rw',1,'2025-12-23 15:07:31','2025-12-23 15:07:31'),(45,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=Krajan%20Satu&q=','GET','http://websidesa.test/rt-rw?q=&dusun=Temurejo',1,'2025-12-23 15:07:34','2025-12-23 15:07:34'),(46,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=','GET','http://websidesa.test/rt-rw?q=&dusun=Krajan+Satu',1,'2025-12-23 15:07:39','2025-12-23 15:07:39'),(47,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=sulhak','GET','http://websidesa.test/rt-rw?q=&dusun=',1,'2025-12-23 15:07:43','2025-12-23 15:07:43'),(48,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=','GET','http://websidesa.test/rt-rw?q=sulhak&dusun=',1,'2025-12-23 15:08:01','2025-12-23 15:08:01'),(49,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=','GET','http://websidesa.test/rt-rw?q=&dusun=',1,'2025-12-23 15:12:42','2025-12-23 15:12:42'),(50,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=','GET','http://websidesa.test/rt-rw?q=&dusun=',1,'2025-12-23 15:19:26','2025-12-23 15:19:26'),(51,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=','GET','http://websidesa.test/rt-rw?q=&dusun=',1,'2025-12-23 15:28:31','2025-12-23 15:28:31'),(52,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=karyadi','GET','http://websidesa.test/rt-rw?q=&dusun=',1,'2025-12-23 15:29:17','2025-12-23 15:29:17'),(53,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=','GET','http://websidesa.test/rt-rw?q=karyadi&dusun=',1,'2025-12-23 15:29:30','2025-12-23 15:29:30'),(54,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw?dusun=&q=Sumariyo','GET','http://websidesa.test/rt-rw?q=&dusun=',1,'2025-12-23 15:29:37','2025-12-23 15:29:37'),(55,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-23 15:33:31','2025-12-23 15:33:31'),(56,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-23 15:33:38','2025-12-23 15:33:38'),(57,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET','http://websidesa.test/',1,'2025-12-23 15:41:45','2025-12-23 15:41:45'),(58,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET','http://websidesa.test/',1,'2025-12-23 15:44:04','2025-12-23 15:44:04'),(59,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET','http://websidesa.test/',1,'2025-12-23 15:44:26','2025-12-23 15:44:26'),(60,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/',1,'2025-12-23 15:45:13','2025-12-23 15:45:13'),(61,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita',1,'2025-12-23 15:45:15','2025-12-23 15:45:15'),(62,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:45:49','2025-12-23 15:45:49'),(63,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:46:01','2025-12-23 15:46:01'),(64,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:46:32','2025-12-23 15:46:32'),(65,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:46:38','2025-12-23 15:46:38'),(66,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:49:08','2025-12-23 15:49:08'),(67,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:49:31','2025-12-23 15:49:31'),(68,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:50:21','2025-12-23 15:50:21'),(69,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 15:59:26','2025-12-23 15:59:26'),(70,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-3-UtnZ3','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:01:17','2025-12-23 16:01:17'),(71,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:03:01','2025-12-23 16:03:01'),(72,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:03:14','2025-12-23 16:03:14'),(73,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:03:20','2025-12-23 16:03:20'),(74,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:03:22','2025-12-23 16:03:22'),(75,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:03:24','2025-12-23 16:03:24'),(76,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:04:09','2025-12-23 16:04:09'),(77,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:04:14','2025-12-23 16:04:14'),(78,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:04:20','2025-12-23 16:04:20'),(79,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/pemerintah-desa-laksanakan-musrenbang-tahun-2025-RorcO','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:04:21','2025-12-23 16:04:21'),(80,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/pemerintah-desa-laksanakan-musrenbang-tahun-2025-RorcO',1,'2025-12-23 16:04:24','2025-12-23 16:04:24'),(81,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-3-UtnZ3','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:04:31','2025-12-23 16:04:31'),(82,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-USJJt','GET','http://websidesa.test/berita/berita-3-UtnZ3',1,'2025-12-23 16:04:34','2025-12-23 16:04:34'),(83,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-USJJt',1,'2025-12-23 16:04:38','2025-12-23 16:04:38'),(84,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:04:47','2025-12-23 16:04:47'),(85,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:07:38','2025-12-23 16:07:38'),(86,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:08:03','2025-12-23 16:08:03'),(87,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:08:51','2025-12-23 16:08:51'),(88,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:09:19','2025-12-23 16:09:19'),(89,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:16:06','2025-12-23 16:16:06'),(90,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:16:11','2025-12-23 16:16:11'),(91,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:16:16','2025-12-23 16:16:16'),(92,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:17:00','2025-12-23 16:17:00'),(93,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:17:42','2025-12-23 16:17:42'),(94,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:18:10','2025-12-23 16:18:10'),(95,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:18:56','2025-12-23 16:18:56'),(96,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:21:22','2025-12-23 16:21:22'),(97,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-MJ9R1','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:21:26','2025-12-23 16:21:26'),(98,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-MJ9R1','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:21:46','2025-12-23 16:21:46'),(99,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-MJ9R1','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:21:50','2025-12-23 16:21:50'),(100,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-y3oik','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:21:53','2025-12-23 16:21:53'),(101,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-q2Qg8','GET','http://websidesa.test/berita/berita-2-y3oik',1,'2025-12-23 16:21:58','2025-12-23 16:21:58'),(102,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET','http://websidesa.test/berita/berita-2-q2Qg8',NULL,'2025-12-23 16:28:20','2025-12-23 16:28:20'),(103,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-23 16:35:35','2025-12-23 16:35:35'),(104,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET','http://websidesa.test/berita/berita-2-q2Qg8',NULL,'2025-12-23 16:35:39','2025-12-23 16:35:39'),(105,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/visi-misi','GET','http://websidesa.test/',NULL,'2025-12-23 16:35:48','2025-12-23 16:35:48'),(106,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/visi-misi',NULL,'2025-12-23 16:37:21','2025-12-23 16:37:21'),(107,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/visi-misi',NULL,'2025-12-23 16:37:26','2025-12-23 16:37:26'),(108,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/visi-misi',NULL,'2025-12-23 16:37:29','2025-12-23 16:37:29'),(109,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/visi-misi',NULL,'2025-12-23 16:37:33','2025-12-23 16:37:33'),(110,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/administrasi','GET','http://websidesa.test/berita',NULL,'2025-12-23 16:38:51','2025-12-23 16:38:51'),(111,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/administrasi',NULL,'2025-12-23 16:39:37','2025-12-23 16:39:37'),(112,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/galeri','GET','http://websidesa.test/produk-hukum',NULL,'2025-12-23 16:42:32','2025-12-23 16:42:32'),(113,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2025','GET','http://websidesa.test/galeri',NULL,'2025-12-23 16:51:43','2025-12-23 16:51:43'),(114,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 16:51:46','2025-12-23 16:51:46'),(115,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2025','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 16:58:58','2025-12-23 16:58:58'),(116,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2025','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 16:59:02','2025-12-23 16:59:02'),(117,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 16:59:26','2025-12-23 16:59:26'),(118,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/visi-misi','GET','http://websidesa.test/',NULL,'2025-12-23 16:59:27','2025-12-23 16:59:27'),(119,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/sejarah-desa','GET','http://websidesa.test/visi-misi',NULL,'2025-12-23 16:59:28','2025-12-23 16:59:28'),(120,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/perangkat-desa','GET','http://websidesa.test/sejarah-desa',NULL,'2025-12-23 16:59:29','2025-12-23 16:59:29'),(121,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/sejarah-desa','GET','http://websidesa.test/perangkat-desa',NULL,'2025-12-23 16:59:30','2025-12-23 16:59:30'),(122,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/perangkat-desa','GET','http://websidesa.test/sejarah-desa',NULL,'2025-12-23 16:59:33','2025-12-23 16:59:33'),(123,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/peta-desa','GET','http://websidesa.test/perangkat-desa',NULL,'2025-12-23 16:59:41','2025-12-23 16:59:41'),(124,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/administrasi','GET','http://websidesa.test/peta-desa',NULL,'2025-12-23 17:00:07','2025-12-23 17:00:07'),(125,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita','GET','http://websidesa.test/administrasi',NULL,'2025-12-23 17:00:13','2025-12-23 17:00:13'),(126,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/pemerintah-desa-laksanakan-musrenbang-tahun-2025-RorcO','GET','http://websidesa.test/berita',NULL,'2025-12-23 17:00:15','2025-12-23 17:00:15'),(127,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-4-xae1G','GET','http://websidesa.test/berita/pemerintah-desa-laksanakan-musrenbang-tahun-2025-RorcO',NULL,'2025-12-23 17:00:18','2025-12-23 17:00:18'),(128,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/berita/berita-2-q2Qg8','GET','http://websidesa.test/berita/berita-4-xae1G',NULL,'2025-12-23 17:00:21','2025-12-23 17:00:21'),(129,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/berita/berita-2-q2Qg8',NULL,'2025-12-23 17:00:23','2025-12-23 17:00:23'),(130,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/produk-hukum','GET','http://websidesa.test/berita/berita-2-q2Qg8',NULL,'2025-12-23 17:00:29','2025-12-23 17:00:29'),(131,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/rt-rw','GET','http://websidesa.test/produk-hukum',NULL,'2025-12-23 17:00:40','2025-12-23 17:00:40'),(132,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/lpmd','GET','http://websidesa.test/rt-rw',NULL,'2025-12-23 17:00:53','2025-12-23 17:00:53'),(133,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/posyandu','GET','http://websidesa.test/lpmd',NULL,'2025-12-23 17:00:56','2025-12-23 17:00:56'),(134,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/pkk','GET','http://websidesa.test/posyandu',NULL,'2025-12-23 17:01:00','2025-12-23 17:01:00'),(135,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/bumdes','GET','http://websidesa.test/pkk',NULL,'2025-12-23 17:01:02','2025-12-23 17:01:02'),(136,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/karang-taruna','GET','http://websidesa.test/bumdes',NULL,'2025-12-23 17:01:04','2025-12-23 17:01:04'),(137,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/koperasi-desa-merah-putih','GET','http://websidesa.test/karang-taruna',NULL,'2025-12-23 17:01:06','2025-12-23 17:01:06'),(138,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2025','GET','http://websidesa.test/koperasi-desa-merah-putih',NULL,'2025-12-23 17:01:08','2025-12-23 17:01:08'),(139,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 17:01:09','2025-12-23 17:01:09'),(140,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2025','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 17:01:11','2025-12-23 17:01:11'),(141,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2024','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 17:01:13','2025-12-23 17:01:13'),(142,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/apbdes/2025','GET','http://websidesa.test/informasi/apbdes/2024',NULL,'2025-12-23 17:01:15','2025-12-23 17:01:15'),(143,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 17:01:16','2025-12-23 17:01:16'),(144,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/galeri','GET','http://websidesa.test/informasi/apbdes/2025',NULL,'2025-12-23 17:03:17','2025-12-23 17:03:17'),(145,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/kontak','GET','http://websidesa.test/galeri',NULL,'2025-12-23 17:03:23','2025-12-23 17:03:23'),(146,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan','GET','http://websidesa.test/kontak',NULL,'2025-12-23 17:03:36','2025-12-23 17:03:36'),(147,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan','GET','http://websidesa.test/kontak',NULL,'2025-12-23 17:04:16','2025-12-23 17:04:16'),(148,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan?desa=Kaliputih&tahun=','GET','http://websidesa.test/informasi/pembangunan',NULL,'2025-12-23 17:04:20','2025-12-23 17:04:20'),(149,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan?desa=Kaliputih&tahun=2025','GET','http://websidesa.test/informasi/pembangunan?desa=Kaliputih&tahun=',NULL,'2025-12-23 17:04:23','2025-12-23 17:04:23'),(150,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan?desa=&tahun=2025','GET','http://websidesa.test/informasi/pembangunan?desa=Kaliputih&tahun=2025',NULL,'2025-12-23 17:04:25','2025-12-23 17:04:25'),(151,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test/informasi/pembangunan?desa=&tahun=','GET','http://websidesa.test/informasi/pembangunan?desa=&tahun=2025',NULL,'2025-12-23 17:04:31','2025-12-23 17:04:31'),(152,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-24 06:01:44','2025-12-24 06:01:44'),(153,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-25 01:30:55','2025-12-25 01:30:55'),(154,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-25 01:31:01','2025-12-25 01:31:01'),(155,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-27 11:25:06','2025-12-27 11:25:06'),(156,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-27 12:15:03','2025-12-27 12:15:03'),(157,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-30 02:09:44','2025-12-30 02:09:44'),(158,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-30 03:43:43','2025-12-30 03:43:43'),(159,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-30 03:46:34','2025-12-30 03:46:34'),(160,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','http://websidesa.test','GET',NULL,NULL,'2025-12-31 07:06:49','2025-12-31 07:06:49');
/*!40000 ALTER TABLE `visitors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'websidesa'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-31 14:52:09
