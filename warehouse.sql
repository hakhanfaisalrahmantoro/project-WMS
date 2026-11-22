-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- membuang struktur untuk table warehouse.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) DEFAULT NULL,
  `kategory` varchar(100) DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel warehouse.barang: ~5 rows (lebih kurang)
INSERT INTO `barang` (`id_barang`, `nama_barang`, `kategory`, `stok`, `satuan`) VALUES
	(1, 'Kayu', 'Bahan Baku', 71, 'pcs'),
	(2, 'Lem', 'Bahan Baku', 100, 'botol'),
	(3, 'Senar', 'Komponen', 140, 'pcs'),
	(4, 'Cat', 'Finishing', 30, 'kaleng'),
	(5, 'Kardus', 'Packaging', 150, 'pcs');

-- membuang struktur untuk table warehouse.barang_keluar
CREATE TABLE IF NOT EXISTS `barang_keluar` (
  `id_keluar` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_keluar`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel warehouse.barang_keluar: ~0 rows (lebih kurang)
INSERT INTO `barang_keluar` (`id_keluar`, `id_barang`, `jumlah`, `tanggal`) VALUES
	(1, 3, 50, '2026-09-30'),
	(2, 3, 10, '2026-10-01'),
	(3, 1, 30, '2026-10-11');

-- membuang struktur untuk table warehouse.barang_masuk
CREATE TABLE IF NOT EXISTS `barang_masuk` (
  `id_masuk` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_masuk`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel warehouse.barang_masuk: ~3 rows (lebih kurang)
INSERT INTO `barang_masuk` (`id_masuk`, `id_barang`, `jumlah`, `tanggal`) VALUES
	(1, 2, 10, '2026-10-10'),
	(2, 1, 1, '2026-10-11'),
	(3, 2, 40, '2026-10-11');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
