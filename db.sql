/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : sticker

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 23/12/2024 13:08:35
*/

SET NAMES latin1;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activity_logs
-- ----------------------------
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `action` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `count` int NULL DEFAULT NULL,
  `notification_id` int NULL DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `notification_id`(`notification_id` ASC) USING BTREE,
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `activity_logs_ibfk_2` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel activity_logs
ALTER TABLE `activity_logs` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of activity_logs
-- ----------------------------

-- ----------------------------
-- Table structure for bug_reports
-- ----------------------------
DROP TABLE IF EXISTS `bug_reports`;
CREATE TABLE `bug_reports`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `page` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `severity` enum('low','medium','high') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'low',
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `screenshot` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` enum('open','in_progress','resolved','closed') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `bug_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel bug_reports
ALTER TABLE `bug_reports` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of bug_reports
-- ----------------------------
INSERT INTO `bug_reports` VALUES (1, 1, 'Error saat Upload Gambar', 'profile/edit', 'medium', 'Tidak bisa mengupload foto profil, muncul pesan error \"File too large\"', NULL, 'open', '2024-12-23 00:15:48', NULL);
INSERT INTO `bug_reports` VALUES (2, 2, 'Tombol Tukar Tidak Berfungsi', 'trades/view', 'high', 'Tombol tukar stiker tidak merespon saat diklik di halaman detail stiker', NULL, 'in_progress', '2024-12-23 00:15:48', NULL);
INSERT INTO `bug_reports` VALUES (3, 3, 'Notifikasi Tidak Muncul', 'notifications', 'low', 'Tidak menerima notifikasi saat ada permintaan pertukaran baru', NULL, 'resolved', '2024-12-23 00:15:48', NULL);

-- ----------------------------
-- Table structure for chat_messages
-- ----------------------------
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `trade_id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delivered` tinyint(1) DEFAULT '1',
  `is_read` tinyint(1) DEFAULT '0',
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_trade_user` (`trade_id`,`user_id`),
  KEY `idx_status` (`is_read`,`read_at`),
  KEY `idx_chat_created` (`created_at`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`trade_id`) REFERENCES `trades` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Mengubah collation untuk tabel chat_messages
ALTER TABLE `chat_messages` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of chat_messages
-- ----------------------------

-- ----------------------------
-- Table structure for collections
-- ----------------------------
DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `total_stickers` int NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel collections
ALTER TABLE `collections` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of collections
-- ----------------------------
INSERT INTO `collections` VALUES (1, 'Koleksi Dasar', 'Koleksi stiker dasar untuk pemula', 9, '2024-12-22 23:37:05', NULL);
INSERT INTO `collections` VALUES (2, 'Koleksi Premium', 'Koleksi stiker premium dengan desain eksklusif', 9, '2024-12-22 23:37:05', NULL);
INSERT INTO `collections` VALUES (3, 'Koleksi Spesial', 'Koleksi stiker edisi terbatas', 9, '2024-12-22 23:37:05', NULL);

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('pending','replied','closed') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `replied_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel contacts
ALTER TABLE `contacts` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of contacts
-- ----------------------------
INSERT INTO `contacts` VALUES (1, 'Budi Santoso', 'budi@email.com', 'Pertanyaan tentang Pertukaran', 'Bagaimana cara membatalkan pertukaran yang sudah diajukan?', 'pending', '2024-12-23 00:15:48', NULL);
INSERT INTO `contacts` VALUES (2, 'Ani Wijaya', 'ani@email.com', 'Saran Fitur Baru', 'Mohon tambahkan fitur wishlist untuk stiker yang diinginkan', 'replied', '2024-12-23 00:15:48', NULL);
INSERT INTO `contacts` VALUES (3, 'Citra Purnama', 'citra@email.com', 'Laporan Error', 'Halaman koleksi tidak bisa diakses', 'closed', '2024-12-23 00:15:48', NULL);

-- ----------------------------
-- Table structure for faqs
-- ----------------------------
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `answer` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'general',
  `order_number` int NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel faqs
ALTER TABLE `faqs` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of faqs
-- ----------------------------
INSERT INTO `faqs` VALUES (1, 'Apa itu Sticker Exchange?', 'Sticker Exchange adalah platform pertukaran stiker digital yang memungkinkan pengguna untuk mengoleksi dan menukar stiker dengan pengguna lain.', 'general', 1, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (2, 'Bagaimana cara memulai menggunakan Sticker Exchange?', 'Untuk memulai:\n1. Daftar akun baru\n2. Login ke akun Anda\n3. Jelajahi koleksi stiker yang tersedia\n4. Mulai mengumpulkan dan menukar stiker', 'general', 2, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (3, 'Apakah layanan ini gratis?', 'Ya, Sticker Exchange sepenuhnya gratis untuk digunakan. Anda dapat mengoleksi dan menukar stiker tanpa biaya.', 'general', 3, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (4, 'Bagaimana cara mengelola koleksi stiker?', 'Anda dapat mengelola koleksi melalui menu \"Koleksi\":\n1. Pilih kategori koleksi\n2. Atur status tukar setiap stiker\n3. Tambah atau hapus stiker dari koleksi\n4. Pantau progress koleksi Anda', 'collection', 1, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (5, 'Bagaimana cara mendapatkan stiker baru?', 'Ada beberapa cara mendapatkan stiker baru:\n1. Menukar dengan pengguna lain\n2. Menyelesaikan misi harian\n3. Berpartisipasi dalam event\n4. Membuka pack stiker gratis harian', 'collection', 2, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (6, 'Apakah saya bisa melihat koleksi pengguna lain?', 'Ya, Anda dapat melihat koleksi pengguna lain melalui profil mereka atau feed stiker, kecuali jika mereka mengatur koleksinya sebagai privat.', 'collection', 3, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (7, 'Bagaimana sistem pertukaran stiker bekerja?', 'Sistem pertukaran bekerja dengan cara:\n1. Pilih stiker yang ingin ditukar\n2. Ajukan permintaan tukar\n3. Pilih stiker yang ditawarkan\n4. Tunggu konfirmasi dari pemilik stiker\n5. Setelah disetujui, stiker akan otomatis bertukar', 'trading', 1, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (8, 'Berapa lama proses pertukaran?', 'Proses pertukaran bergantung pada respon pemilik stiker. Setelah disetujui, pertukaran terjadi secara instan. Permintaan yang tidak dijawab akan kedaluwarsa dalam 7 hari.', 'trading', 2, '2024-12-23 00:15:48');
INSERT INTO `faqs` VALUES (9, 'Bagaimana jika pertukaran ditolak?', 'Jika pertukaran ditolak, Anda akan mendapat notifikasi. Anda dapat mencoba mengajukan pertukaran lagi dengan stiker yang berbeda atau mencari pengguna lain.', 'trading', 3, '2024-12-23 00:15:48');

-- ----------------------------
-- Table structure for guides
-- ----------------------------
DROP TABLE IF EXISTS `guides`;
CREATE TABLE `guides`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `content` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'general',
  `order_number` int NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel guides
ALTER TABLE `guides` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of guides
-- ----------------------------
INSERT INTO `guides` VALUES (1, 'Panduan Memulai', 'getting-started', '# Selamat Datang di Sticker Exchange!\r\n\r\n## 1. Membuat Akun\r\n\r\n### Langkah-langkah Pendaftaran\r\n1. Klik tombol \"Daftar\" di pojok kanan atas\r\n2. Isi formulir pendaftaran dengan:\r\n   - Username yang unik\r\n   - Email yang valid \r\n   - Password yang aman\r\n3. Baca dan setujui syarat & ketentuan\r\n4. Klik tombol \"Daftar\"\r\n5. Cek email untuk verifikasi\r\n\r\n### Tips Keamanan Akun\r\n- Gunakan password yang kuat\r\n- Jangan bagikan informasi login\r\n- Aktifkan autentikasi 2 langkah\r\n- Perbarui password secara berkala\r\n\r\n## 2. Menjelajahi Platform\r\n\r\n### Fitur Utama\r\n**Dashboard**\r\n- Pusat kontrol koleksi Anda\r\n- Pantau progress koleksi\r\n- Lihat statistik pertukaran\r\n\r\n**Feed**\r\n- Temukan stiker dari pengguna lain\r\n- Jelajahi koleksi terbaru\r\n- Interaksi dengan kolektor\r\n\r\n**Koleksi**\r\n- Kelola stiker-stiker Anda\r\n- Atur status pertukaran\r\n- Organisir berdasar kategori\r\n\r\n**Pertukaran**\r\n- Mulai trading dengan kolektor\r\n- Ajukan penawaran\r\n- Pantau status pertukaran\r\n\r\n### Mengatur Profil\r\n1. Klik foto profil Anda\r\n2. Pilih menu \"Edit Profil\"\r\n3. Lengkapi informasi:\r\n   - Foto profil menarik\r\n   - Bio singkat\r\n   - Informasi kontak\r\n4. Atur preferensi notifikasi\r\n\r\n## 3. Memulai Koleksi\r\n\r\n### Pack Stiker Harian\r\n- Klaim pack gratis setiap hari\r\n- Buka pack untuk stiker acak\r\n- Dapatkan stiker dari berbagai kategori\r\n- Simpan stiker duplikat untuk ditukar\r\n\r\n### Memilih Kategori\r\n1. Jelajahi kategori yang tersedia\r\n2. Pilih kategori favorit Anda\r\n3. Pantau progress per kategori\r\n4. Tetapkan target penyelesaian\r\n\r\n### Tips Mengoleksi\r\n- Fokus pada satu kategori dulu\r\n- Manfaatkan event khusus\r\n- Ikuti update koleksi baru\r\n- Kelola stiker duplikat dengan baik\r\n\r\n## 4. Berinteraksi dengan Komunitas\r\n\r\n### Mengikuti Kolektor\r\n- Temukan kolektor aktif\r\n- Follow untuk update terbaru\r\n- Lihat koleksi mereka\r\n- Mulai interaksi pertukaran\r\n\r\n### Event & Challenge\r\n- Ikuti event mingguan\r\n- Dapatkan stiker eksklusif\r\n- Partisipasi dalam challenge\r\n- Menangkan hadiah spesial\r\n\r\n### Panduan Pertukaran\r\n1. Temukan stiker yang diinginkan\r\n2. Cek status ketersediaan\r\n3. Ajukan penawaran yang adil\r\n4. Tunggu konfirmasi pemilik\r\n5. Selesaikan pertukaran\r\n\r\n## Tips & Trik Tambahan\r\n\r\n### Maksimalkan Koleksi\r\n- Login setiap hari untuk rewards\r\n- Selesaikan misi harian\r\n- Ikuti panduan achievement\r\n- Bergabung dalam grup komunitas\r\n\r\n### Etika Bertransaksi\r\n- Bersikap sopan dan profesional\r\n- Berikan penawaran yang masuk akal\r\n- Respon permintaan dengan cepat\r\n- Jaga reputasi akun Anda\r\n\r\n## Bantuan & Dukungan\r\n\r\nJika membutuhkan bantuan:\r\n- Kunjungi halaman FAQ\r\n- Hubungi tim support\r\n- Laporkan bug/masalah\r\n- Berikan feedback untuk peningkatan\r\n\r\n*Selamat mengoleksi dan bertransaksi!*', 'general', 1, '2024-12-23 00:15:48', '2024-12-23 00:22:10');
INSERT INTO `guides` VALUES (2, 'Panduan Pertukaran', 'trading-guide', '# Panduan Pertukaran Stiker\n\n## Cara Melakukan Pertukaran\n\n### 1. Memilih Stiker\n- Cari stiker yang diinginkan\n- Periksa status ketersediaan\n- Pastikan Anda memiliki stiker untuk ditukar\n\n### 2. Mengajukan Pertukaran\n- Klik tombol \"Tukar\"\n- Pilih stiker yang ditawarkan\n- Tambahkan pesan (opsional)\n\n### 3. Menunggu Konfirmasi\n- Pantau status pertukaran\n- Tunggu respons pemilik\n- Cek notifikasi\n\n### 4. Menyelesaikan Pertukaran\n- Terima/tolak tawaran\n- Konfirmasi pertukaran\n- Beri rating (opsional)', 'trading', 2, '2024-12-23 00:15:48', '2024-12-23 00:15:48');
INSERT INTO `guides` VALUES (3, 'Tips Mengoleksi', 'collection-tips', '# Tips Mengoleksi Stiker\n\n## Strategi Koleksi\n\n### 1. Fokus pada Kategori\n- Pilih kategori favorit\n- Selesaikan satu per satu\n- Pantau progress\n\n### 2. Manajemen Koleksi\n- Atur stiker duplikat\n- Kelola status tukar\n- Catat stiker yang diinginkan\n\n### 3. Berinteraksi dengan Komunitas\n- Ikuti kolektor aktif\n- Bergabung dalam event\n- Bagikan tips dengan pengguna lain', 'collection', 3, '2024-12-23 00:15:48', '2024-12-23 00:15:48');

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `reference_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `reference_id` int NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `reference_id`(`reference_id` ASC) USING BTREE,
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- Mengubah collation untuk tabel notifications
ALTER TABLE `notifications` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for sticker_categories
-- ----------------------------
DROP TABLE IF EXISTS `sticker_categories`;
CREATE TABLE `sticker_categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- Mengubah collation untuk tabel sticker_categories
ALTER TABLE `sticker_categories` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of sticker_categories
-- ----------------------------
INSERT INTO `sticker_categories` VALUES (1, 'Indonesia Map', 'indonesia-map', '1', '2024-12-22 01:27:43', NULL);
INSERT INTO `sticker_categories` VALUES (2, 'World Map', 'world-map', '2', '2024-12-22 01:27:58', NULL);
INSERT INTO `sticker_categories` VALUES (3, 'Space Station Map', 'space-station-map', '3', '2024-12-22 01:28:37', NULL);
INSERT INTO `sticker_categories` VALUES (4, 'Theme Park Map', 'theme-park-map', '4', '2024-12-22 01:28:46', NULL);
INSERT INTO `sticker_categories` VALUES (5, 'Adventure Map', 'adventure-map', '5', '2024-12-22 01:28:56', NULL);
INSERT INTO `sticker_categories` VALUES (6, 'Fortress', 'fortress', '6', '2024-12-22 01:29:05', NULL);
INSERT INTO `sticker_categories` VALUES (7, 'Zombie Map', 'zombie-map', '7', '2024-12-22 01:29:14', NULL);
INSERT INTO `sticker_categories` VALUES (8, 'God\'s Hand', 'gods-hand', '8', '2024-12-22 01:29:24', NULL);
INSERT INTO `sticker_categories` VALUES (9, 'Magic Land', 'magic-land', '9', '2024-12-22 01:29:34', NULL);
INSERT INTO `sticker_categories` VALUES (10, 'Ice Cave', 'ice-cave', '10', '2024-12-22 01:29:44', NULL);
INSERT INTO `sticker_categories` VALUES (11, 'Toy Land', 'toy-land', '11', '2024-12-22 01:29:55', NULL);
INSERT INTO `sticker_categories` VALUES (12, 'Water City', 'water-city', '12', '2024-12-22 01:30:03', NULL);

-- ----------------------------
-- Table structure for stickers
-- ----------------------------
DROP TABLE IF EXISTS `stickers`;
CREATE TABLE `stickers`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int NULL DEFAULT NULL,
  `category_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_stickers_category`(`category_id` ASC) USING BTREE,
  CONSTRAINT `stickers_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `sticker_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 109 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- Mengubah collation untuk tabel stickers
ALTER TABLE `stickers` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of stickers
-- ----------------------------
INSERT INTO `stickers` VALUES (1, 1, 1, '2024-12-22 01:27:43', '2024-12-22 01:31:27', 0);
INSERT INTO `stickers` VALUES (2, 2, 1, '2024-12-22 01:27:43', '2024-12-22 02:22:09', 0);
INSERT INTO `stickers` VALUES (3, 3, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (4, 4, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (5, 5, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (6, 6, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (7, 7, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (8, 8, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (9, 9, 1, '2024-12-22 01:27:43', NULL, 0);
INSERT INTO `stickers` VALUES (10, 1, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (11, 2, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (12, 3, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (13, 4, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (14, 5, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (15, 6, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (16, 7, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (17, 8, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (18, 9, 2, '2024-12-22 01:27:58', NULL, 0);
INSERT INTO `stickers` VALUES (19, 1, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (20, 2, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (21, 3, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (22, 4, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (23, 5, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (24, 6, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (25, 7, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (26, 8, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (27, 9, 3, '2024-12-22 01:28:37', NULL, 0);
INSERT INTO `stickers` VALUES (28, 1, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (29, 2, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (30, 3, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (31, 4, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (32, 5, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (33, 6, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (34, 7, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (35, 8, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (36, 9, 4, '2024-12-22 01:28:46', NULL, 0);
INSERT INTO `stickers` VALUES (37, 1, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (38, 2, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (39, 3, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (40, 4, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (41, 5, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (42, 6, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (43, 7, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (44, 8, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (45, 9, 5, '2024-12-22 01:28:56', NULL, 0);
INSERT INTO `stickers` VALUES (46, 1, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (47, 2, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (48, 3, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (49, 4, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (50, 5, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (51, 6, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (52, 7, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (53, 8, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (54, 9, 6, '2024-12-22 01:29:05', NULL, 0);
INSERT INTO `stickers` VALUES (55, 1, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (56, 2, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (57, 3, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (58, 4, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (59, 5, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (60, 6, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (61, 7, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (62, 8, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (63, 9, 7, '2024-12-22 01:29:14', NULL, 0);
INSERT INTO `stickers` VALUES (64, 1, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (65, 2, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (66, 3, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (67, 4, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (68, 5, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (69, 6, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (70, 7, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (71, 8, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (72, 9, 8, '2024-12-22 01:29:24', NULL, 0);
INSERT INTO `stickers` VALUES (73, 1, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (74, 2, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (75, 3, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (76, 4, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (77, 5, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (78, 6, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (79, 7, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (80, 8, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (81, 9, 9, '2024-12-22 01:29:34', NULL, 0);
INSERT INTO `stickers` VALUES (82, 1, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (83, 2, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (84, 3, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (85, 4, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (86, 5, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (87, 6, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (88, 7, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (89, 8, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (90, 9, 10, '2024-12-22 01:29:44', NULL, 0);
INSERT INTO `stickers` VALUES (91, 1, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (92, 2, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (93, 3, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (94, 4, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (95, 5, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (96, 6, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (97, 7, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (98, 8, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (99, 9, 11, '2024-12-22 01:29:55', NULL, 0);
INSERT INTO `stickers` VALUES (100, 1, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (101, 2, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (102, 3, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (103, 4, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (104, 5, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (105, 6, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (106, 7, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (107, 8, 12, '2024-12-22 01:30:03', NULL, 0);
INSERT INTO `stickers` VALUES (108, 9, 12, '2024-12-22 01:30:03', NULL, 0);

-- ----------------------------
-- Table structure for trade_messages
-- ----------------------------
DROP TABLE IF EXISTS `trade_messages`;
CREATE TABLE `trade_messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `trade_id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `trade_id`(`trade_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `trade_messages_ibfk_1` FOREIGN KEY (`trade_id`) REFERENCES `trades` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `trade_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- Mengubah collation untuk tabel trade_messages
ALTER TABLE `trade_messages` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of trade_messages
-- ----------------------------
INSERT INTO `trade_messages` VALUES (1, 3, 1, 'hai', '2024-12-22 23:16:49');
INSERT INTO `trade_messages` VALUES (2, 3, 1, 'semangat', '2024-12-22 23:17:09');
INSERT INTO `trade_messages` VALUES (3, 3, 3, 'tes', '2024-12-22 23:17:48');
INSERT INTO `trade_messages` VALUES (4, 3, 3, 'dsa', '2024-12-22 23:19:51');
INSERT INTO `trade_messages` VALUES (5, 3, 3, 'asdasd', '2024-12-22 23:20:53');
INSERT INTO `trade_messages` VALUES (6, 3, 3, 'asdasdasdasdaadasdsdas', '2024-12-22 23:22:43');
INSERT INTO `trade_messages` VALUES (7, 3, 3, 'sadasdasd', '2024-12-22 23:24:17');

-- ----------------------------
-- Table structure for trades
-- ----------------------------
DROP TABLE IF EXISTS `trades`;
CREATE TABLE `trades`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `requester_id` int NOT NULL,
  `owner_id` int NOT NULL,
  `requested_sticker_id` int NOT NULL,
  `offered_sticker_id` int NOT NULL,
  `status` enum('pending','accepted','rejected','cancelled') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `requested_sticker_id`(`requested_sticker_id` ASC) USING BTREE,
  INDEX `offered_sticker_id`(`offered_sticker_id` ASC) USING BTREE,
  INDEX `idx_trades_requester`(`requester_id` ASC) USING BTREE,
  INDEX `idx_trades_owner`(`owner_id` ASC) USING BTREE,
  CONSTRAINT `trades_ibfk_1` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `trades_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `trades_ibfk_3` FOREIGN KEY (`requested_sticker_id`) REFERENCES `stickers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `trades_ibfk_4` FOREIGN KEY (`offered_sticker_id`) REFERENCES `stickers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- Mengubah collation untuk tabel trades
ALTER TABLE `trades` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of trades
-- ----------------------------
INSERT INTO `trades` VALUES (3, 3, 1, 10, 1, 'rejected', '2024-12-22 13:39:44', '2024-12-22 23:49:37');

-- ----------------------------
-- Table structure for user_stickers
-- ----------------------------
DROP TABLE IF EXISTS `user_stickers`;
CREATE TABLE `user_stickers`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `sticker_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT 0,
  `is_for_trade` tinyint(1) NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `number` int NOT NULL DEFAULT 1,
  `image_path` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `image_hash` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `collection_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_user_sticker_number`(`user_id` ASC, `sticker_id` ASC, `number` ASC) USING BTREE,
  INDEX `idx_user_stickers_user`(`user_id` ASC) USING BTREE,
  INDEX `idx_user_stickers_sticker`(`sticker_id` ASC) USING BTREE,
  INDEX `user_stickers_collection_fk`(`collection_id` ASC) USING BTREE,
  CONSTRAINT `user_stickers_collection_fk` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `user_stickers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_stickers_ibfk_2` FOREIGN KEY (`sticker_id`) REFERENCES `stickers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- Mengubah collation untuk tabel user_stickers
ALTER TABLE `user_stickers` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of user_stickers
-- ----------------------------
INSERT INTO `user_stickers` VALUES (28, 1, 2, 6, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (29, 1, 3, 3, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (30, 1, 4, 2, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (31, 1, 5, 3, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (32, 1, 6, 7, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (33, 1, 7, 5, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (34, 1, 8, 7, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (35, 1, 9, 1, 1, '2024-12-22 23:55:49', '2024-12-22 23:55:49', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706012.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (36, 2, 1, 4, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (37, 2, 2, 1, 0, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (38, 2, 3, 5, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (39, 2, 4, 4, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (40, 2, 5, 2, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (41, 2, 6, 6, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (42, 2, 7, 1, 0, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (43, 2, 8, 3, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);
INSERT INTO `user_stickers` VALUES (44, 2, 9, 7, 1, '2024-12-23 00:06:06', '2024-12-23 00:06:06', 1, 'Gambar_WhatsApp_2024-12-22_pukul_08_10_05_cbea706013.jpg', NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'default.jpg',
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `is_admin` tinyint(1) NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- Mengubah collation untuk tabel users
ALTER TABLE `users` 
CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Bekoy', 'bzndenis@gmail.com', 'default.jpg', '$2y$10$Q1oV.uvO5FCUWbQz53t93.rLHRiI467aTOVanipdCK.l5fZhnSoLO', 1, 1, '2024-12-22 01:22:48', NULL);
INSERT INTO `users` VALUES (2, 'Bekoy66', 'bzndenis1@gmail.com', 'default.jpg', '$2y$10$LIEGPbomOv//F77cJeVKuuHmRNTsHJBpVSV2eXm0YLPHhAuGmOlv.', 1, 0, '2024-12-22 01:31:40', NULL);
INSERT INTO `users` VALUES (3, 'Bekoy666', 'bzndenis11@gmail.com', 'default.jpg', '$2y$10$UhAEJjy71w3o6S1x21/XHedqUKecd2tQGoZoTbhSmzVC5TI02idbm', 1, 0, '2024-12-22 01:31:59', NULL);

SET FOREIGN_KEY_CHECKS = 1;
