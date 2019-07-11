-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2019 at 06:55 AM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.3.1-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_be`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocked_entries`
--

CREATE TABLE `blocked_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blocked_entries`
--

INSERT INTO `blocked_entries` (`id`, `user_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(2, 13, 28, '2019-06-13 23:58:58', '2019-06-13 23:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_kit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_string` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `industry_category_id` bigint(20) NOT NULL,
  `show_options` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `company_id`, `name`, `description`, `entry_kit`, `logo`, `id_string`, `category_id`, `industry_category_id`, `show_options`, `created_at`, `updated_at`) VALUES
(20, 1, 'Amazfit', 'nvon nerverv 0ewrhvewbrv', '2019_06_11_20_41_09_3.pdf', '2019_06_11_20_41_09_323744-P9HEUA-327.ai', '2019|quaerat|001', 7, 1, 0, '2019-06-11 20:41:09', '2019-06-12 23:19:11'),
(21, 1, 'React', 'nvoanvo oenvobev ebovamionvi', '2019_06_11_20_42_07_5.pdf', '2019_06_11_20_42_07_282779-P6LTAF-453.ai', '2019|odit|001', 10, 2, 1, '2019-06-11 20:42:07', '2019-06-12 23:19:11'),
(24, 1, 'Mazda', 'nvofnv oabvoubarv', '2019_06_11_21_31_30_2.pdf', '2019_06_11_21_31_30_323744-P9HEUA-327.ai', '2019|ut|001', 5, 5, 1, '2019-06-11 21:31:30', '2019-06-12 23:19:11'),
(25, 1, 'Subaru', 'vaobrv voeubrvubrv', '2019_06_11_21_34_02_3.pdf', '2019_06_11_21_34_02_323744-P9HEUA-327.ai', '2019|blanditiis|001', 4, 1, 0, '2019-06-11 21:34:02', '2019-06-12 23:19:11'),
(26, 1, 'Fuso', 'vnaobv oanvoabirv arvobasvr', '2019_06_11_21_36_53_5.pdf', '2019_06_11_21_36_53_323744-P9HEUA-327.ai', '2019|blanditiis|002', 4, 2, 1, '2019-06-11 21:36:53', '2019-06-12 23:19:11'),
(27, 1, 'Nissan', 'voasbv aovuoabrv', '2019_06_11_21_38_56_6.pdf', '2019_06_11_21_38_56_282779-P6LTAF-453.ai', '2019|ut|002', 5, 3, 0, '2019-06-11 21:38:56', '2019-06-12 23:19:11'),
(28, 1, 'TATA', 'vnasbv aobsvbavr', '2019_06_11_23_02_20_2.pdf', '2019_06_11_23_02_20_323744-P9HEUA-327.ai', '2019|ut|003', 5, 4, 1, '2019-06-11 23:02:20', '2019-06-12 23:19:11'),
(29, 1, 'Leyland', 'nvaosbv oasrbvobawriv', '2019_06_11_23_02_56_3.pdf', '2019_06_11_23_02_56_282779-P6LTAF-453.ai', '2019|quaerat|002', 7, 5, 1, '2019-06-11 23:02:56', '2019-06-12 23:19:11'),
(31, 1, 'Samsung', 'abosbv oabvoari ehgihbenva', '2019_06_11_23_13_27_4.pdf', '2019_06_11_23_13_27_323744-P9HEUA-327.ai', '2019|architecto|001', 9, 2, 1, '2019-06-11 23:13:27', '2019-06-12 23:19:11'),
(33, 1, 'Xiaomi', 'anfvbrv erbvbarv', '2019_06_11_23_24_30_4.pdf', '2019_06_11_23_24_30_323744-P9HEUA-327.ai', '2019|sit|001', 6, 4, 1, '2019-06-11 23:24:30', '2019-06-12 23:19:11'),
(35, 1, 'Galaxy', 'vnabv avbiabrv airviabvr', '2019_06_11_23_30_06_5.pdf', '2019_06_11_23_30_06_282779-P6LTAF-453.ai', '2019|architecto|002', 9, 1, 1, '2019-06-11 23:30:06', '2019-06-12 23:19:11'),
(36, 1, 'Maga', 'oajbv oebrvoubrev orbvwbvwriv', '2019_06_13_13_28_00_2.pdf', '2019_06_13_13_28_00_282779-P6LTAF-453.ai', '2019|consequuntur|001', 3, 3, 1, '2019-06-13 13:28:00', '2019-06-13 13:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `brand_user`
--

CREATE TABLE `brand_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intent` int(11) NOT NULL,
  `content` int(11) NOT NULL,
  `process` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `performance` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `good` text,
  `bad` text,
  `improvement` text,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand_user`
--

INSERT INTO `brand_user` (`id`, `intent`, `content`, `process`, `health`, `performance`, `total`, `good`, `bad`, `improvement`, `brand_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 15, 10, 30, 10, 5, 70, 'Hello good', 'Hello bad', 'Hello imp', 31, 11, NULL, NULL),
(2, 14, 14, 35, 10, 10, 83, 'basbv', 'vabvoubawrv', 'vjajobvoar', 26, 11, '2019-06-20 23:07:09', '2019-06-20 23:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Minnesota', 'MN', '2019-05-24 21:18:45', '2019-05-29 23:08:43'),
(2, 'ullam', 'voluptatibus', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(3, 'dicta', 'consequuntur', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(4, 'voluptate', 'blanditiis', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(5, 'temporibus', 'ut', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(6, 'autem', 'sit', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(7, 'sunt', 'quaerat', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(9, 'earum', 'architecto', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(10, 'magnam', 'odit', '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(11, 'Alpha', 'AL', '2019-05-29 22:36:03', '2019-05-29 22:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ceo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ceo_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ceo_contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `name`, `address`, `ceo_name`, `ceo_email`, `ceo_contact_number`, `created_at`, `updated_at`) VALUES
(1, 2, 'David Peris Company', '138 Huntington Ave, Boston', 'Apeksha', 'apeksha@gmail.com', '1234567890', '2019-05-24 21:19:59', '2019-05-28 19:58:21'),
(2, 3, 'DVS', '355 high level road', 'Sameera', 'adidulanka@gmail.com', '0715779707', '2019-05-28 10:48:29', '2019-05-29 21:51:40'),
(4, 8, 'Eyes Sri Lanka', 'vyvy igiygyfqr ervoenvion', 'Apeksha', 'chathura1@gmail.com', '1234567890', '2019-05-31 10:10:35', '2019-05-31 10:10:35'),
(5, 9, 'Eyes Sri Lanka', 'nvaobv oanvoab iearhiaehr', 'Apeksha', 'prabodh1@gmail.com', '0987654321', '2019-05-31 12:18:49', '2019-05-31 12:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `industry_categories`
--

CREATE TABLE `industry_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industry_categories`
--

INSERT INTO `industry_categories` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Nebraska', 'NE', NULL, NULL),
(2, 'Massachussets', 'MA', NULL, NULL),
(3, 'Connecticut', 'CT', NULL, NULL),
(4, 'Washington', 'WA', NULL, NULL),
(5, 'Oregon', 'OR', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `industry_category_user`
--

CREATE TABLE `industry_category_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `industry_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `industry_category_user`
--

INSERT INTO `industry_category_user` (`id`, `user_id`, `industry_category_id`, `created_at`, `updated_at`) VALUES
(5, 12, 1, NULL, NULL),
(6, 12, 2, NULL, NULL),
(7, 12, 3, NULL, NULL),
(8, 12, 5, NULL, NULL),
(9, 13, 4, NULL, NULL),
(10, 13, 5, NULL, NULL),
(37, 11, 2, '2019-06-19 15:21:25', '2019-06-19 15:21:25'),
(38, 11, 3, '2019-06-19 15:21:25', '2019-06-19 15:21:25'),
(39, 11, 4, '2019-06-19 15:21:25', '2019-06-19 15:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_05_24_070810_create_roles_table', 1),
(3, '2019_05_24_070900_create_users_table', 1),
(4, '2019_05_24_071358_create_companies_table', 1),
(5, '2019_05_24_071752_create_categories_table', 1),
(6, '2019_05_24_105415_create_brands_table', 1),
(7, '2019_06_12_104845_create_industry_categories_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('apeksha.eyes.lk@gmail.com', '$2y$10$CmtYC.HgluONmbHXLqdPEu9cfCvMeOtzubRUjRlQLTuMGBwYX3JuS', '2019-05-28 11:00:59'),
('lahirukk01@gmail.com', '$2y$10$jFYfmlen3y/UzTVYgqZyC.XLMhhOKbMmVHFynaxMTHbX3ZZrmV4I6', '2019-06-16 12:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'super', NULL, NULL),
(2, 'admin', NULL, NULL),
(3, 'judge', NULL, NULL),
(4, 'client', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `designation`, `contact_number`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Lahiru Kantha Kariyawasam', 'lahirukk01@gmail.com', NULL, '$2y$10$yC6ZVZMMhItVDvI0aSMXNOUkh2FfUmW4L.IFrKbrB6doZ4EM7b9du', 'Super User', '0771234567', 1, NULL, '2019-05-24 21:18:45', '2019-05-24 21:18:45'),
(2, 'Chad Freer', 'chad@gmail.com', NULL, '$2y$10$HWDw/hvYGVwYvml.EmpjquHkonw/BhhR3a3.XS6N1FUN/H50qqHWK', 'Graduate', '0987654321', 4, NULL, '2019-05-24 21:19:59', '2019-05-28 20:36:14'),
(10, 'Sameera', 'sameera@gmail.com', NULL, '$2y$10$k6dCzqPkfxNapXXhAwjKLeDv7ITs3CywJQh6.oWnL9g6Esuh4fsqO', 'Project Manager', '0987654321', 2, NULL, '2019-06-12 16:48:11', '2019-06-12 16:48:11'),
(11, 'Dredd', 'dredd@gmail.com', NULL, '$2y$10$PUm.Uvb1qpTI2FJ6G8LPYee7MhN30aKs.eJ7JdXfbks1TMswAFDPC', NULL, '2609745678', 3, NULL, '2019-06-13 23:14:54', '2019-06-16 12:45:59'),
(12, 'Bruce', 'bruce@gmail.com', NULL, '$2y$10$anZJYxeSuBD/aQDLHvzIfuU6SpYzRE3pLY/YAlGN8mwlZSgdMvKmy', NULL, '5462809732', 3, NULL, '2019-06-13 23:18:56', '2019-06-13 23:18:56'),
(13, 'Clerk', 'clerk@gmail.com', NULL, '$2y$10$fqi4Wek5JiVfLiHizW.RK.pX.ENmyQ0GV/VXWmmVKApY5n8cVphz6', NULL, '5961230954', 3, NULL, '2019-06-13 23:58:21', '2019-06-13 23:58:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocked_entries`
--
ALTER TABLE `blocked_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_company_id_foreign` (`company_id`),
  ADD KEY `brands_category_id_foreign` (`category_id`);

--
-- Indexes for table `brand_user`
--
ALTER TABLE `brand_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `industry_categories`
--
ALTER TABLE `industry_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industry_category_user`
--
ALTER TABLE `industry_category_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `industry_category_id` (`industry_category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocked_entries`
--
ALTER TABLE `blocked_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `brand_user`
--
ALTER TABLE `brand_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `industry_categories`
--
ALTER TABLE `industry_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `industry_category_user`
--
ALTER TABLE `industry_category_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocked_entries`
--
ALTER TABLE `blocked_entries`
  ADD CONSTRAINT `blocked_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blocked_entries_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `brands_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `brand_user`
--
ALTER TABLE `brand_user`
  ADD CONSTRAINT `brand_user_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `brand_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `industry_category_user`
--
ALTER TABLE `industry_category_user`
  ADD CONSTRAINT `industry_category_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `industry_category_user_ibfk_2` FOREIGN KEY (`industry_category_id`) REFERENCES `industry_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
