-- =============================================================================
-- DATABASE SCHEMA & OPERATIONAL QUERIES - LAUNDRYKU SYSTEM
-- DBMS: MySQL / MariaDB
-- =============================================================================

-- =============================================================================
-- BAGIAN 1: DATA DEFINITION LANGUAGE (DDL) - SKEMA TABEL
-- =============================================================================

-- 1. Tabel Users (Kredensial Login & Manajemen Pengguna)
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'petugas') DEFAULT 'petugas' NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel Customers (Manajemen Data Pelanggan)
CREATE TABLE IF NOT EXISTS `customers` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(255) NOT NULL,
  `telepon` VARCHAR(20) NOT NULL,
  `alamat` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Services (Manajemen Layanan Laundry & Tarif Per Kg)
CREATE TABLE IF NOT EXISTS `services` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama_layanan` VARCHAR(255) NOT NULL,
  `harga_per_kg` INT UNSIGNED NOT NULL,
  `deskripsi` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Transactions (Manajemen Transaksi, Alur Bisnis, & Status)
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `invoice_number` VARCHAR(100) UNIQUE NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `customer_id` BIGINT UNSIGNED NOT NULL,
  `service_id` BIGINT UNSIGNED NOT NULL,
  `berat` DECIMAL(8, 2) NOT NULL,
  `total_harga` INT UNSIGNED NOT NULL,
  `status` VARCHAR(50) DEFAULT 'Diproses' NOT NULL, -- Status: Diproses, Siap Diambil, Selesai
  `tanggal_masuk` DATETIME NOT NULL,
  `tanggal_estimasi` DATETIME NOT NULL,
  `tanggal_diambil` DATETIME NULL,
  `status_pembayaran` VARCHAR(50) DEFAULT 'Belum Lunas' NOT NULL, -- Status: Belum Lunas, Lunas
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  -- Foreign Key Constraints
  CONSTRAINT `fk_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_transactions_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_transactions_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- BAGIAN 2: SEEDING DATA AWAL (INITIAL DATA)
-- =============================================================================

-- Seed User Akun Default
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Administrator', 'admin@laundryku.test', '$2y$12$qZsbql6DVNH6WxARJoUSx.Scrci4vSAFukG.Kfa6qfu0UGov/XNCG', 'admin'), -- Password: password
('Petugas Laundry', 'petugas@laundryku.test', '$2y$12$qZsbql6DVNH6WxARJoUSx.Scrci4vSAFukG.Kfa6qfu0UGov/XNCG', 'petugas'); -- Password: password

-- Seed Daftar Layanan Default
INSERT INTO `services` (`nama_layanan`, `harga_per_kg`, `deskripsi`) VALUES
('Cuci Reguler', 5000, 'Cuci biasa, selesai dalam 2 hari'),
('Cuci Express', 8000, 'Cuci cepat kilat, selesai dalam 1 hari'),
('Setrika Saja', 4000, 'Layanan setrika per kg, selesai dalam 1 hari');

-- Seed Data Pelanggan Awal
INSERT INTO `customers` (`nama`, `telepon`, `alamat`) VALUES
('Budi Santoso', '081234567890', 'Jl. Merdeka No. 10'),
('Siti Aminah', '081987654321', 'Jl. Sudirman No. 25');


-- =============================================================================
-- BAGIAN 3: QUERY OPERASIONAL APLIKASI (DML CRUD & SEARCH)
-- =============================================================================

-- -------------------------------------------------------------
-- MODUL 1: AUTENTIKASI
-- -------------------------------------------------------------
-- Mencari data pengguna berdasarkan email (saat login)
SELECT * FROM `users` WHERE `email` = 'admin@laundryku.test' LIMIT 1;

-- -------------------------------------------------------------
-- MODUL 2: MANAJEMEN PELANGGAN
-- -------------------------------------------------------------
-- Menampilkan daftar pelanggan dengan pagination (Terbaru dahulu)
SELECT * FROM `customers` ORDER BY `created_at` DESC LIMIT 10 OFFSET 0;

-- Pencarian pelanggan berdasarkan kata kunci (Nama, Telepon, atau Alamat)
SELECT * FROM `customers` 
WHERE `nama` LIKE '%Budi%' 
   OR `telepon` LIKE '%Budi%' 
   OR `alamat` LIKE '%Budi%' 
ORDER BY `created_at` DESC;

-- Menyimpan pelanggan baru
INSERT INTO `customers` (`nama`, `telepon`, `alamat`) 
VALUES ('Ahmad Zaki', '081299998888', 'Jl. Kenanga No. 4');

-- Membaca detail data pelanggan untuk proses edit
SELECT * FROM `customers` WHERE `id` = 3 LIMIT 1;

-- Memperbarui data pelanggan
UPDATE `customers` 
SET `nama` = 'Ahmad Zaki Alatas', `telepon` = '081299998889', `alamat` = 'Jl. Kenanga No. 4B' 
WHERE `id` = 3;

-- Menghapus data pelanggan (Khusus Admin)
DELETE FROM `customers` WHERE `id` = 3;

-- -------------------------------------------------------------
-- MODUL 3: MANAJEMEN LAYANAN LAUNDRY
-- -------------------------------------------------------------
-- Menampilkan daftar seluruh layanan
SELECT * FROM `services` ORDER BY `nama_layanan` ASC;

-- Menyimpan layanan baru
INSERT INTO `services` (`nama_layanan`, `harga_per_kg`, `deskripsi`) 
VALUES ('Cuci Karpet', 15000, 'Layanan cuci karpet bulu per meter/kg');

-- Memperbarui data layanan
UPDATE `services` 
SET `nama_layanan` = 'Cuci Karpet Premium', `harga_per_kg` = 17500, `deskripsi` = 'Cuci karpet premium wangi' 
WHERE `id` = 4;

-- Menghapus data layanan
DELETE FROM `services` WHERE `id` = 4;


-- =============================================================================
-- BAGIAN 4: QUERY ALUR BISNIS LAUNDRY & TRANSAKSI
-- =============================================================================

-- 1. Membuat Transaksi Baru (Nota Masuk)
-- Total harga dihitung otomatis di aplikasi (Berat * Harga Layanan)
-- Status default adalah 'Diproses', Status pembayaran default 'Belum Lunas'
INSERT INTO `transactions` (
  `invoice_number`, `user_id`, `customer_id`, `service_id`, 
  `berat`, `total_harga`, `status`, `tanggal_masuk`, 
  `tanggal_estimasi`, `status_pembayaran`
) VALUES (
  'INV-202606250001', 2, 1, 1, 
  3.50, 17500, 'Diproses', NOW(), 
  DATE_ADD(NOW(), INTERVAL 2 DAY), 'Belum Lunas'
);

-- 2. Menampilkan Daftar Transaksi Aktif dengan Join Relasi
SELECT 
  t.id, 
  t.invoice_number, 
  c.nama AS nama_pelanggan, 
  s.nama_layanan, 
  t.berat, 
  t.total_harga, 
  t.status, 
  t.status_pembayaran, 
  t.tanggal_masuk, 
  t.tanggal_estimasi 
FROM `transactions` t
JOIN `customers` c ON t.customer_id = c.id
JOIN `services` s ON t.service_id = s.id
ORDER BY t.created_at DESC;

-- 3. Pencarian Transaksi (Berdasarkan Nomor Invoice atau Nama Pelanggan)
SELECT 
  t.*, c.nama AS nama_pelanggan 
FROM `transactions` t
JOIN `customers` c ON t.customer_id = c.id
WHERE t.invoice_number LIKE '%INV-2026%' 
   OR c.nama LIKE '%Budi%'
ORDER BY t.created_at DESC;

-- 4. Update Status: Laundry Selesai Diproses (Siap Diambil)
UPDATE `transactions` 
SET `status` = 'Siap Diambil' 
WHERE `id` = 1;

-- 5. Pelanggan Datang Mengambil Laundry (Status: Selesai, Status Pembayaran: Lunas)
-- Mengisi tanggal_diambil dengan waktu sekarang
UPDATE `transactions` 
SET 
  `status` = 'Selesai', 
  `status_pembayaran` = 'Lunas', 
  `tanggal_diambil` = NOW() 
WHERE `id` = 1;


-- =============================================================================
-- BAGIAN 5: QUERY LAPORAN & DASHBOARD STATISTIK (ANALYTICS)
-- =============================================================================

-- 1. Menghitung Jumlah Total Pelanggan Aktif
SELECT COUNT(*) AS total_pelanggan FROM `customers`;

-- 2. Menghitung Jumlah Transaksi Aktif (Status 'Diproses' atau 'Siap Diambil')
SELECT 
  SUM(CASE WHEN `status` = 'Diproses' THEN 1 ELSE 0 END) AS total_diproses,
  SUM(CASE WHEN `status` = 'Siap Diambil' THEN 1 ELSE 0 END) AS total_siap_diambil,
  SUM(CASE WHEN `status` = 'Selesai' THEN 1 ELSE 0 END) AS total_selesai
FROM `transactions`;

-- 3. Menghitung Total Pendapatan Hari Ini
SELECT COALESCE(SUM(`total_harga`), 0) AS pendapatan_hari_ini 
FROM `transactions` 
WHERE DATE(`tanggal_masuk`) = CURDATE();

-- 4. Rekapitulasi Pendapatan Bulanan (Untuk Grafik Dashboard)
SELECT 
  DATE_FORMAT(`tanggal_masuk`, '%Y-%m') AS bulan, 
  COUNT(`id`) AS jumlah_transaksi,
  SUM(`total_harga`) AS total_pendapatan 
FROM `transactions` 
GROUP BY bulan 
ORDER BY bulan ASC;
