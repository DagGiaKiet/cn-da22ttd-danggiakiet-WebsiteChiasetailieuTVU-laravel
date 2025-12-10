-- MySQL dump for TVU Book Exchange System
-- Database: tvu_bookexchange

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tvu_bookexchange`
--
CREATE DATABASE IF NOT EXISTS `tvu_bookexchange` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tvu_bookexchange`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ma_sv` varchar(255) DEFAULT NULL,
  `ma_lop` varchar(255) DEFAULT NULL,
  `khoa` varchar(255) DEFAULT NULL,
  `nganh` varchar(255) DEFAULT NULL,
  `anh_the` varchar(255) DEFAULT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `ma_sv`, `ma_lop`, `khoa`, `nganh`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin TVU', 'admin@st.tvu.edu.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN001', 'ADMIN', 'Quản trị hệ thống', 'Administrator', 'admin', NOW(), NOW()),
(2, 'Nguyễn Văn A', 'student1@st.tvu.edu.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2151120001', 'DH21CS01', 'Công nghệ Thông tin', 'Khoa học Máy tính', 'student', NOW(), NOW()),
(3, 'Trần Thị B', 'student2@st.tvu.edu.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2151120002', 'DH21CS01', 'Công nghệ Thông tin', 'Khoa học Máy tính', 'student', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `khoas`
--

DROP TABLE IF EXISTS `khoas`;
CREATE TABLE `khoas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_khoa` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khoas`
--

INSERT INTO `khoas` (`id`, `ten_khoa`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Công nghệ Thông tin', 'Khoa Công nghệ Thông tin', NOW(), NOW()),
(2, 'Kinh tế', 'Khoa Kinh tế', NOW(), NOW()),
(3, 'Sư phạm', 'Khoa Sư phạm', NOW(), NOW()),
(4, 'Nông nghiệp', 'Khoa Nông nghiệp', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `nganhs`
--

DROP TABLE IF EXISTS `nganhs`;
CREATE TABLE `nganhs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_nganh` varchar(255) NOT NULL,
  `khoa_id` bigint(20) UNSIGNED NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nganhs_khoa_id_foreign` (`khoa_id`),
  CONSTRAINT `nganhs_khoa_id_foreign` FOREIGN KEY (`khoa_id`) REFERENCES `khoas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nganhs`
--

INSERT INTO `nganhs` (`id`, `ten_nganh`, `khoa_id`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Khoa học Máy tính', 1, 'Ngành Khoa học Máy tính', NOW(), NOW()),
(2, 'Hệ thống Thông tin', 1, 'Ngành Hệ thống Thông tin', NOW(), NOW()),
(3, 'Quản trị Kinh doanh', 2, 'Ngành Quản trị Kinh doanh', NOW(), NOW()),
(4, 'Kế toán', 2, 'Ngành Kế toán', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `mons`
--

DROP TABLE IF EXISTS `mons`;
CREATE TABLE `mons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_mon` varchar(255) NOT NULL,
  `nganh_id` bigint(20) UNSIGNED NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mons_nganh_id_foreign` (`nganh_id`),
  CONSTRAINT `mons_nganh_id_foreign` FOREIGN KEY (`nganh_id`) REFERENCES `nganhs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mons`
--

INSERT INTO `mons` (`id`, `ten_mon`, `nganh_id`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Lập trình Hướng đối tượng', 1, 'Môn Lập trình Hướng đối tượng với Java/C++', NOW(), NOW()),
(2, 'Cấu trúc Dữ liệu và Giải thuật', 1, 'Môn Cấu trúc Dữ liệu và Giải thuật', NOW(), NOW()),
(3, 'Cơ sở Dữ liệu', 1, 'Môn Cơ sở Dữ liệu', NOW(), NOW()),
(4, 'Lập trình Web', 1, 'Môn Lập trình Web với HTML, CSS, JavaScript, PHP', NOW(), NOW()),
(5, 'Phân tích Thiết kế Hệ thống', 2, 'Môn Phân tích và Thiết kế Hệ thống Thông tin', NOW(), NOW()),
(6, 'Quản trị Hệ thống', 2, 'Môn Quản trị Hệ thống', NOW(), NOW()),
(7, 'Quản trị Marketing', 3, 'Môn Quản trị Marketing', NOW(), NOW()),
(8, 'Quản trị Tài chính', 3, 'Môn Quản trị Tài chính Doanh nghiệp', NOW(), NOW()),
(9, 'Kế toán Tài chính', 4, 'Môn Kế toán Tài chính', NOW(), NOW()),
(10, 'Kế toán Quản trị', 4, 'Môn Kế toán Quản trị', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_tai_lieu` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `gia` decimal(10,2) NOT NULL DEFAULT 0.00,
  `loai` enum('ban','cho') NOT NULL DEFAULT 'cho',
  `khoa_id` bigint(20) UNSIGNED NOT NULL,
  `nganh_id` bigint(20) UNSIGNED NOT NULL,
  `mon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `trang_thai` enum('available','sold') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_khoa_id_foreign` (`khoa_id`),
  KEY `documents_nganh_id_foreign` (`nganh_id`),
  KEY `documents_mon_id_foreign` (`mon_id`),
  KEY `documents_user_id_foreign` (`user_id`),
  CONSTRAINT `documents_khoa_id_foreign` FOREIGN KEY (`khoa_id`) REFERENCES `khoas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_nganh_id_foreign` FOREIGN KEY (`nganh_id`) REFERENCES `nganhs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_mon_id_foreign` FOREIGN KEY (`mon_id`) REFERENCES `mons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `ten_tai_lieu`, `mo_ta`, `hinh_anh`, `gia`, `loai`, `khoa_id`, `nganh_id`, `mon_id`, `user_id`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 'Giáo trình Lập trình Hướng đối tượng Java', 'Giáo trình đầy đủ về OOP với Java, còn mới 90%', 'java-oop.jpg', 50000.00, 'ban', 1, 1, 1, 2, 'available', NOW(), NOW()),
(2, 'Slide bài giảng Cấu trúc Dữ liệu', 'Tài liệu slide đầy đủ từ giảng viên, chia sẻ miễn phí', 'data-structure.jpg', 0.00, 'cho', 1, 1, 2, 2, 'available', NOW(), NOW()),
(3, 'Giáo trình Cơ sở Dữ liệu', 'Giáo trình về Database, SQL, còn đẹp', 'database.jpg', 40000.00, 'ban', 1, 1, 3, 3, 'available', NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tieu_de` varchar(255) NOT NULL,
  `noi_dung` text NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blogs_user_id_foreign` (`user_id`),
  CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `tieu_de`, `noi_dung`, `hinh_anh`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Chia sẻ tài liệu Lập trình Web', 'Mình có bộ tài liệu Lập trình Web đầy đủ, bao gồm HTML, CSS, JavaScript, PHP. Ai cần liên hệ mình nhé! Gặp tại TVU.', 'web-programming.jpg', 2, NOW(), NOW()),
(2, 'Cho tặng slide môn Marketing', 'Mình có slide môn Quản trị Marketing đầy đủ, in màu, chia sẻ miễn phí cho các bạn. Inbox mình để hẹn gặp.', 'marketing.jpg', 3, NOW(), NOW());

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `noi_dung` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_comments_blog_id_foreign` (`blog_id`),
  KEY `blog_comments_user_id_foreign` (`user_id`),
  CONSTRAINT `blog_comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `trang_thai` enum('pending','dang_giao','da_nhan','huy') NOT NULL DEFAULT 'pending',
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_document_id_foreign` (`document_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_document_id_unique` (`user_id`,`document_id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_document_id_foreign` (`document_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
