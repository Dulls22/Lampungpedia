-- Database: Marketplace UMKM
-- Import lewat phpMyAdmin (XAMPP/Laragon) atau: mysql -u root < marketplace_umkm.sql

CREATE DATABASE IF NOT EXISTS marketplace_umkm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE marketplace_umkm;

DROP TABLE IF EXISTS pesan_kontak;
DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('pembeli','penjual') NOT NULL DEFAULT 'pembeli',
    nama_toko VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(60) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penjual_id INT NOT NULL,
    kategori_id INT NOT NULL,
    nama VARCHAR(120) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (penjual_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
) ENGINE=InnoDB;

CREATE TABLE pesan_kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pesan TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO kategori (nama) VALUES
('Makanan & Minuman'), ('Fashion'), ('Kerajinan'), ('Pertanian'), ('Jasa');

-- Akun contoh (password semua: password123)
INSERT INTO users (nama, email, password, role, nama_toko) VALUES
('Siti Aminah', 'penjual@contoh.com', '$2y$10$imzYL6NFfL51dpuv7eCr4eUXS4VjiryoWAk2yV5t4NaqKS6liNpdu', 'penjual', 'Dapur Siti'),
('Budi Santoso', 'pembeli@contoh.com', '$2y$10$imzYL6NFfL51dpuv7eCr4eUXS4VjiryoWAk2yV5t4NaqKS6liNpdu', 'pembeli', NULL);

INSERT INTO produk (penjual_id, kategori_id, nama, deskripsi, harga, stok) VALUES
(1, 1, 'Keripik Pisang Lampung', 'Keripik pisang renyah khas Lampung, tanpa pengawet. Kemasan 250 gram.', 18000, 50),
(1, 1, 'Kopi Robusta Lampung 200g', 'Biji kopi robusta sangrai medium, aroma kuat dan pahit seimbang.', 35000, 30),
(1, 3, 'Tas Anyaman Pandan', 'Tas anyaman tangan dari daun pandan, kuat dan ringan.', 85000, 12),
(1, 2, 'Kain Tapis Lampung', 'Kain tapis motif tradisional Lampung, ukuran 1,5 m.', 250000, 5);
