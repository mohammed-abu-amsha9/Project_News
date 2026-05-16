-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2025 at 08:19 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liquidity`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `image`, `mobile`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Lester Hawkins', 'abuayham@ayham.app', '$2y$10$cI06aeakUo2RrXYNVVvsd.lUZoOvdTl1KcpAvyQV5PoyhG3R30mLe', 'admins/UgqYpBEZgkk3FSpmB9JmX1CVHYcJXNhjKHBZicff.jpg', 'Quidem at facilis ap', '2025-07-07 06:57:32', '2025-07-07 07:04:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branches_merchant_id_foreign` (`merchant_id`),
  KEY `branches_shop_id_foreign` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `merchant_id`, `shop_id`, `name`, `location`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'فرع الرمال', 'غزة - السرايا - مقابل برج السوسي', '0597946180', '2025-07-07 08:06:30', '2025-07-07 08:07:58'),
(2, 3, 2, 'Justin Molina', 'Roanna Davis', '+1 (102) 323-1029', '2025-07-09 04:51:14', '2025-07-09 04:51:24');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `name`, `email`, `password`, `mobile`, `birth_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'James Melton', 'merchant@merchant.com', '$2y$10$44ADMcDWLNxYfPRfU1UIee097b82wfksYDmEmGkWbaZRj7zSP0DOO', 'Eiusmod eum placeat', '1995-05-21', '2025-07-07 08:00:40', '2025-07-07 08:00:40', NULL),
(3, 'Casey Rose', 'admin@admin.com', '$2y$10$KlAhqX6GBlWwAbf0s2khY.xdJK8iF5iRos8egHp8ZdLlQRBUY60kW', 'Excepturi cumque et', '2006-11-19', '2025-07-09 04:43:35', '2025-07-09 04:43:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_products`
--

DROP TABLE IF EXISTS `merchant_products`;
CREATE TABLE IF NOT EXISTS `merchant_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `merchant_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_products_product_id_foreign` (`product_id`),
  KEY `merchant_products_merchant_id_foreign` (`merchant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_03_095752_create_merchants_table', 1),
(6, '2025_07_03_095942_create_shops_table', 1),
(7, '2025_07_03_103229_create_products_table', 1),
(8, '2025_07_03_103233_create_product_shops_table', 1),
(9, '2025_07_04_082518_create_merchant_products_table', 1),
(10, '2025_07_04_090919_create_branches_table', 1),
(11, '2025_07_05_104540_create_permission_tables', 1),
(12, '2025_07_05_110808_create_admins_table', 1),
(13, '2025_07_09_065211_create_payment_methods_table', 2),
(14, '2025_07_09_065552_create_payment_method_products_table', 2),
(17, '2025_07_09_070504_create_payment_methods_table', 3),
(18, '2025_07_09_070513_create_payment_method_products_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\admin', 2),
(2, 'App\\Models\\admin', 2),
(3, 'App\\Models\\admin', 2),
(4, 'App\\Models\\admin', 2),
(5, 'App\\Models\\admin', 2),
(6, 'App\\Models\\admin', 2),
(7, 'App\\Models\\admin', 2),
(8, 'App\\Models\\admin', 2),
(9, 'App\\Models\\admin', 2),
(10, 'App\\Models\\merchant', 2),
(10, 'App\\Models\\merchant', 3),
(11, 'App\\Models\\merchant', 2),
(11, 'App\\Models\\merchant', 3),
(12, 'App\\Models\\admin', 2),
(13, 'App\\Models\\merchant', 2),
(13, 'App\\Models\\merchant', 3),
(14, 'App\\Models\\merchant', 2),
(14, 'App\\Models\\merchant', 3),
(15, 'App\\Models\\merchant', 2),
(15, 'App\\Models\\merchant', 3),
(16, 'App\\Models\\merchant', 2),
(16, 'App\\Models\\merchant', 3),
(17, 'App\\Models\\merchant', 2),
(17, 'App\\Models\\merchant', 3),
(18, 'App\\Models\\merchant', 2),
(18, 'App\\Models\\merchant', 3),
(19, 'App\\Models\\admin', 2),
(20, 'App\\Models\\admin', 2),
(21, 'App\\Models\\admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\merchant', 2),
(2, 'App\\Models\\merchant', 3),
(5, 'App\\Models\\admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_methods_merchant_id_foreign` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `merchant_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 'كاش', '2025-07-09 04:52:37', '2025-07-09 04:52:37'),
(2, 3, 'كرت', '2025-07-09 04:52:41', '2025-07-09 04:52:41'),
(5, 3, 'تحويل بنك فلسطين', '2025-07-09 04:54:12', '2025-07-09 04:54:12'),
(6, 3, 'تحويل محفظة', '2025-07-09 04:54:20', '2025-07-09 04:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_products`
--

DROP TABLE IF EXISTS `payment_method_products`;
CREATE TABLE IF NOT EXISTS `payment_method_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `payment_method_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_method_products_product_id_foreign` (`product_id`),
  KEY `payment_method_products_payment_method_id_foreign` (`payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_method_products`
--

INSERT INTO `payment_method_products` (`id`, `product_id`, `payment_method_id`, `created_at`, `updated_at`) VALUES
(1, 4, 5, NULL, NULL),
(2, 4, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Create-Role', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(2, 'Read-Roles', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(3, 'Update-Role', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(4, 'Delete-Role', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(5, 'Read-Permissions', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(6, 'Create-Admin', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(7, 'Read-Admins', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(8, 'Update-Admin', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(9, 'Delete-Admin', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(10, 'Create-Product', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(11, 'Read-Products', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(12, 'Read-Products', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(13, 'Create-Shop', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(14, 'Update-Shop', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(15, 'Delete-Shop', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(16, 'Create-Branch', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(17, 'Delete-Branch', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(18, 'Update-Product', 'merchant', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(19, 'Delete-Product', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(20, 'Delete-Branch', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44'),
(21, 'Read-Merchants', 'admin', '2025-07-07 06:25:44', '2025-07-07 06:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_merchant_id_foreign` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `merchant_id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'تيشيرت', 'تيشيرت شبابي دراي فيت لون سكني', '50.00', 'products/M1QAcnHrSVxfUJBFlE2DCoP9TU4TBdHV2kBdOkMx.jpg', '2025-07-07 08:18:37', '2025-07-07 08:18:37', NULL),
(2, 2, 'تيشيرت', 'لاجود الملابس واحدثها', '40.00', 'products/0tCQbLn9v91Y6mDJPOdFVaDBkrRUMCT1k8QpNSo7.jpg', '2025-07-09 04:34:06', '2025-07-09 04:34:06', NULL),
(3, 2, 'Gary Solis', 'Aliqua Dolor autem', '82.00', 'products/TsaQsVxQhhQeFJBHSXXhbiCMiiJtSfKdSkjxaLvd.jpg', '2025-07-09 04:36:01', '2025-07-09 04:36:01', NULL),
(4, 3, 'Kay French', 'Odit veritatis et ut', '300.00', 'products/nvmXHbBiBNuYm1pZBbZQ30LVXNL9opBDNsuwF17l.jpg', '2025-07-09 04:55:22', '2025-07-09 04:55:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_shops`
--

DROP TABLE IF EXISTS `product_shops`;
CREATE TABLE IF NOT EXISTS `product_shops` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_shops_product_id_foreign` (`product_id`),
  KEY `product_shops_shop_id_foreign` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_shops`
--

INSERT INTO `product_shops` (`id`, `product_id`, `shop_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'Super Admin', 'admin', NULL, NULL),
(2, 'Merchant', 'merchant', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 2),
(11, 2),
(12, 5),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 5),
(20, 5),
(21, 5);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
CREATE TABLE IF NOT EXISTS `shops` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shops_merchant_id_foreign` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `merchant_id`, `name`, `email`, `activity`, `password`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'الفخامة للملابس الرجالية', 'felicita47@example.net', 'other', '$2y$10$Lg/0SzvZMDu2.eS997c.rOuMLkI0Y4.rOzzppEYIzb1JDHI6AETam', 'يوجد لدينا احدث موديلات الملابس', 'shops/5Qw0GWRlq7Emhr1jkcD9FxVbieLmR8tm4a1kHjZ2.jpg', '2025-07-07 08:07:58', '2025-07-07 08:07:58', NULL),
(2, 3, 'Colby Whitaker', 'hegyl@mailinator.com', 'cafe', '$2y$10$CsLVDdS0qsbo1RToDuD9Cexn/lZpNSbVfWgsCegqxtgvXRidLS5ZK', 'Dignissimos officia', 'shops/soESXFBby2fHM8WQ1meuwgdynwwuk5oLBJGCI6U5.jpg', '2025-07-09 04:51:24', '2025-07-09 04:51:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branches_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merchant_products`
--
ALTER TABLE `merchant_products`
  ADD CONSTRAINT `merchant_products_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `merchant_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_method_products`
--
ALTER TABLE `payment_method_products`
  ADD CONSTRAINT `payment_method_products_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_method_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_shops`
--
ALTER TABLE `product_shops`
  ADD CONSTRAINT `product_shops_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_shops_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
