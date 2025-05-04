# ************************************************************
# Sequel Ace SQL dump
# Version 20067
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 9.3.0)
# Database: skripsi_devina
# Generation Time: 2025-05-04 10:54:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table kategori
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(45) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;

INSERT INTO `kategori` (`id`, `kategori`, `status`)
VALUES
	(1,'Makanan',0),
	(2,'Minuman',0),
	(3,'Snack',0);

/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `idKategori` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;

INSERT INTO `menu` (`id`, `nama`, `harga`, `gambar`, `idKategori`, `status`)
VALUES
	(1,'Nasi Goreng',15000,'1746247529_5f05018238645a8ef38e.jpeg',1,0),
	(2,'Ayam Goreng',180000,'1746247845_9da9622074b3c90ba28c.jpeg',1,0),
	(3,'Es The',10000,'1746247865_c6798c498ba045cc6e00.jpeg',2,0),
	(4,'Psang Goreng',8000,'1746247886_88396fdf2ce5eeeb1f27.jpeg',3,0);

/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` datetime DEFAULT NULL,
  `total` int DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `payment_method` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '1: cash, 2 digital',
  `transaction_code` varchar(45) DEFAULT NULL,
  `tax` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;

INSERT INTO `order` (`id`, `tanggal`, `total`, `catatan`, `status`, `payment_method`, `transaction_code`, `tax`)
VALUES
	(1,'2025-05-03 04:53:33',275000,'manisin tehnya, ayamnya crispy','status_process','payment_cash','TR-20250503045333',25000),
	(2,'2025-05-03 04:55:12',234300,'manisin tehnya, ayamnya crispy','status_paid','payment_digital','TR-20250503045512',21300),
	(3,'2025-05-03 05:00:22',16500,'','status_paid','payment_cash','TR-20250503050022',1500),
	(4,'2025-05-03 05:03:23',16500,'','status_waiting_cash','payment_cash','TR-20250503050323',1500);

/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_detail`;

CREATE TABLE `order_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `menu_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `catatan` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;

INSERT INTO `order_detail` (`id`, `order_id`, `menu_id`, `qty`, `harga`, `catatan`)
VALUES
	(1,1,1,2,15000,''),
	(2,1,2,1,180000,''),
	(3,1,3,4,10000,''),
	(4,2,1,1,15000,''),
	(5,2,2,1,180000,''),
	(6,2,3,1,10000,''),
	(7,2,4,1,8000,'manis'),
	(8,3,1,1,15000,''),
	(9,4,1,1,15000,'');

/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` tinyint(1) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `email`, `password`, `role`, `nama`, `status`)
VALUES
	(7,'admin@admin.com','$2y$12$uLylexG3isqde6L/IpTpmej3yfv/Pj/JFrJS2ECXZw4dEVQdfm4mO',2,'admin',1),
	(8,'barista@barista.com','$2y$12$Q1QpgJttMVP5nMzEzDQjE.vWkCWtGDuY4d2NqX5GWNb2VgEOfG11q',2,'barista',1),
	(9,'kasir@kasir.com','$2y$12$KVUjXktbQWSG6/E.LdUDbOjhEkPRAXMQvnTb7i1OhOPUx1YTZLAgi',3,'kasir',1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
