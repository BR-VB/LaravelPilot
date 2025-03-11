-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 11. Mrz 2025 um 17:29
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `projectnavigator`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `activity_type_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_activity_type_id_foreign` (`activity_type_id`),
  KEY `activity_logs_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `activity_logs`:
--   `activity_type_id`
--       `activity_types` -> `id`
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `activity_types`
--

DROP TABLE IF EXISTS `activity_types`;
CREATE TABLE IF NOT EXISTS `activity_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activity_types_title_unique` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `activity_types`:
--

--
-- Daten für Tabelle `activity_types`
--

INSERT IGNORE INTO `activity_types` (`id`, `title`, `label`, `locale`, `created_at`, `updated_at`) VALUES
(6, 'create', 'Create', 'en', '2024-12-13 06:36:13', '2024-12-13 06:36:13'),
(7, 'delete', 'Delete', 'en', '2024-12-13 06:36:13', '2024-12-13 06:36:13'),
(8, 'update', 'Update', 'en', '2024-12-13 06:36:13', '2024-12-13 06:36:13'),
(9, 'query', 'Query', 'en', '2024-12-13 06:36:13', '2024-12-13 06:36:13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `cache`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `cache_locks`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `failed_jobs`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `jobs`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `job_batches`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `migrations`:
--

--
-- Daten für Tabelle `migrations`
--

INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_09_151041_create_tasks_table', 2),
(5, '2024_12_10_071033_create_projects_table', 3),
(7, '2024_12_12_082924_add_is_admin_to_users_table', 4),
(8, '2024_12_12_085022_create_scopes_table', 5),
(10, '2024_12_12_100642_add_default_language_to_users_table', 6),
(12, '2024_12_12_120247_add_project_id_to_scopes_table', 7),
(14, '2024_12_12_144341_add_label_to_scopes_table', 8),
(15, '2024_12_12_150936_add_columns_to_tasks_table', 9),
(16, '2024_12_12_170615_create_task_detail_types_table', 10),
(17, '2024_12_12_172144_create_task_details_table', 11),
(18, '2024_12_13_072713_create_activity_types_table', 12),
(20, '2024_12_13_073737_create_activity_logs_table', 13),
(24, '2024_12_13_094016_create_translations_table', 14),
(25, '2024_12_16_075904_add_task_id_to_task_details_table', 15),
(26, '2024_12_23_141723_update_scopes_title_index', 16),
(28, '2025_01_04_092555_add_unique_index_to_translations_table', 17),
(29, '2025_01_09_100516_add_is_reporting_to_users_table', 18),
(30, '2025_01_10_142335_create_telescope_entries_table', 19),
(31, '2025_01_15_040201_create_personal_access_tokens_table', 20),
(32, '2025_02_04_122849_add_bgcolor_to_scopes_table', 21),
(33, '2025_02_06_092926_add_default_project_id_to_users_table', 22),
(34, '2025_02_07_114737_add_occurred_at_to_tasks_table', 23),
(35, '2025_02_07_134737_add_occurred_at_to_task_details_table', 24),
(36, '2025_02_20_150427_add_index_project_id_column_sortorder_to_scopes_table', 25),
(37, '2025_02_20_150427_add_indexes_to_tasks_table', 26),
(38, '2025_02_20_150427_add_index_project_id_column_sortorder_to_scopes_table copy', 27),
(39, '2025_02_20_153427_add_indexes_to_tasks_table', 27),
(40, '2025_02_20_154202_add_indexes_to_task_details_table', 28),
(41, '2025_02_20_154703_add_indexes_to_translations_table', 29);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `password_reset_tokens`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `personal_access_tokens`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(65) NOT NULL,
  `description` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_title_unique` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `projects`:
--

--
-- Daten für Tabelle `projects`
--

INSERT IGNORE INTO `projects` (`id`, `title`, `description`, `is_featured`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'Laravel', '<strong>My first Laravel project - An introduction to the world of modern Backend - Web Development</strong>\r\n\r\nIn my first Laravel project, I dive into the possibilities and concepts of the popular PHP framework. The aim of this project is to explore and apply the basic functionalities of Laravel - from routing, middleware and services to Eloquent ORM and blade templates to advanced features such as jobs, events, multilingual support and RESTful API. It\'s not just about creating a working application, but also about understanding and consciously making design decisions.\r\n\r\nThe project serves as a personal guide for me to get to know and implement the principles and best practices of Laravel. I document my steps, explain the architecture and key decisions. In addition, I add small code snippets, relevant commands or further details and links to the official documentation in some places. \r\n\r\nThe end result is not only a usable application, but also a solid foundation for future projects. This project is the beginning of my journey to realize complex and performant applications with Laravel as a backend tool.', 0, 'en', '2024-12-10 06:56:24', '2025-02-08 14:15:09'),
(10, 'ProjectNavigator', '<strong>About ProjectNavigator</strong>\r\n\r\nEver wanted an effective way to document your projects? With ProjectNavigator, you can systematically record your own projects to make them traceable later or share them with others as an introduction to new topics.\r\n\r\nProjectNavigator doesn’t just provide step-by-step instructions; it also offers background knowledge, tips, and tricks that are essential for creating comprehensive documentation. The goal is to help you preserve your project knowledge and support others in understanding and continuing your work.', 1, 'en', '2025-01-02 06:13:22', '2025-01-17 07:32:35'),
(47, 'Brigitta - Messages', NULL, 0, 'en', '2025-01-30 11:25:52', '2025-01-30 11:25:52');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scopes`
--

DROP TABLE IF EXISTS `scopes`;
CREATE TABLE IF NOT EXISTS `scopes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `column` tinyint(4) NOT NULL DEFAULT 1,
  `sortorder` tinyint(4) NOT NULL DEFAULT 1,
  `bgcolor` varchar(7) DEFAULT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scopes_project_id_title_unique` (`project_id`,`title`),
  KEY `scopes_project_id_foreign` (`project_id`) USING BTREE,
  KEY `scopes_project_id_column_sortorder_index` (`project_id`,`column`,`sortorder`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `scopes`:
--   `project_id`
--       `projects` -> `id`
--

--
-- Daten für Tabelle `scopes`
--

INSERT IGNORE INTO `scopes` (`id`, `title`, `label`, `is_featured`, `column`, `sortorder`, `bgcolor`, `locale`, `created_at`, `updated_at`, `project_id`) VALUES
(36, 'install', 'Install', 1, 1, 5, '#F0FCFF', 'en', '2024-12-12 14:32:51', '2025-02-08 14:15:49', 1),
(37, 'configure', 'Configure', 1, 1, 10, '#fbf3fa', 'en', '2024-12-12 14:32:51', '2025-02-04 13:02:52', 1),
(38, 'organize', 'Organize', 1, 1, 15, '#F9F9F9', 'en', '2024-12-12 14:32:51', '2025-02-04 12:29:53', 1),
(39, 'others', 'Others', 1, 1, 20, '#FEFBF9', 'en', '2024-12-12 14:32:51', '2025-02-04 15:46:02', 1),
(40, 'todo', 'ToDo', 1, 2, 5, '#FDF5F5', 'en', '2024-12-12 14:32:51', '2025-02-04 12:27:54', 1),
(41, 'maybe', 'MayBe', 1, 2, 10, '#FFF3EC', 'en', '2024-12-12 14:32:51', '2025-02-04 12:48:40', 1),
(42, 'develop', 'Last Activities', 1, 2, 15, '#F4FAF4', 'en', '2024-12-12 14:32:51', '2025-02-04 17:12:31', 1),
(45, 'assumptions', 'Pay attention to', 1, 1, 12, '#FFFFEA', 'en', '2024-12-24 17:34:13', '2025-02-04 13:14:07', 1),
(49, 'why', 'Why ProjectNavigator?', 1, 1, 10, NULL, 'en', '2025-01-02 07:23:47', '2025-01-02 07:23:47', 10),
(50, 'what', 'What can you expect?', 1, 1, 20, NULL, 'en', '2025-01-02 07:40:17', '2025-01-02 07:40:17', 10),
(51, 'how', 'How does it work?', 1, 1, 30, NULL, 'en', '2025-01-02 07:42:59', '2025-01-02 07:42:59', 10),
(52, 'member', 'Not a member yet?', 1, 2, 10, NULL, 'en', '2025-01-02 07:45:07', '2025-01-02 07:45:07', 10),
(53, 'next', 'Your next step', 1, 2, 20, NULL, 'en', '2025-01-02 07:46:49', '2025-01-02 07:46:49', 10),
(54, 'register', 'Register now and get started!', 1, 2, 30, NULL, 'en', '2025-01-02 07:48:11', '2025-01-02 07:48:11', 10),
(57, 'build', 'Build-Process', 0, 2, 20, '#F4F9FF', 'en', '2025-01-18 05:10:03', '2025-02-04 13:10:12', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `sessions`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `occurred_at` timestamp NULL DEFAULT NULL,
  `scope_id` bigint(20) UNSIGNED NOT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `icon` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_scope_id_foreign` (`scope_id`) USING BTREE,
  KEY `tasks_title_index` (`title`),
  KEY `tasks_occurred_at_title_index` (`occurred_at`,`title`),
  KEY `tasks_updated_at_title_index` (`updated_at`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `tasks`:
--   `scope_id`
--       `scopes` -> `id`
--

--
-- Daten für Tabelle `tasks`
--

INSERT IGNORE INTO `tasks` (`id`, `title`, `description`, `created_at`, `updated_at`, `occurred_at`, `scope_id`, `locale`, `is_featured`, `icon`, `prefix`) VALUES
(6, 'Debugbar: composer require barryvdh/laravel-debugbar --dev', NULL, '2024-12-12 07:02:54', '2025-01-16 10:30:14', '2024-12-12 07:02:54', 36, 'en', 1, '✅', '[12.12.]'),
(7, 'Config XDebug for VSCode & Laravel', NULL, '2024-12-12 15:02:54', '2025-01-16 10:31:06', '2024-12-12 15:02:54', 37, 'en', 1, '⌛', NULL),
(8, 'Config Apache to serve ProjectNavigator', NULL, '2024-12-12 15:02:54', '2025-01-18 13:07:50', '2024-12-12 15:02:54', 37, 'en', 1, '⌛', NULL),
(9, 'Meeting Raik: code-review & plan for last 2 weeks', NULL, '2024-12-20 09:00:00', '2025-02-05 13:24:35', '2024-12-20 09:00:00', 38, 'en', 0, '✅', '[20.12.]'),
(10, '<a href=\"https://www.youtube.com/watch?v=wVCEpbLIyLU&list=PL8p2I9GklV46KYQnt-xJB9dhyG-e-zHnI&index=3\" class=\"external-link\" target=\"_blank\">YouTube: Laravel 11 Tutorial -Playlist</a>', NULL, '2025-01-15 15:15:30', '2025-01-15 15:15:30', '2025-01-15 15:15:30', 39, 'en', 1, '✅', '[15.01.]'),
(11, 'Finish DB - Model (tables/migrations/models/factories/seeders)', NULL, '2024-12-13 09:16:54', '2025-02-08 15:43:14', '2024-12-13 09:16:54', 42, 'en', 1, '✅', '[13.12.]'),
(12, 'Implement a soft delete (trash)', NULL, '2024-12-12 15:04:54', '2025-01-13 06:48:46', '2024-12-12 15:04:54', 41, 'en', 1, '🤔', NULL),
(13, 'Layout: Safari - corrections for header', NULL, '2024-12-10 12:30:54', '2025-02-08 15:33:38', '2024-12-10 12:30:54', 42, 'en', 1, '✅', '[10.12.]'),
(14, 'Header: show date depending on locale', NULL, '2024-12-11 08:00:54', '2025-02-08 15:42:05', '2024-12-11 08:00:54', 42, 'en', 1, '✅', '[11.12.]'),
(15, 'LanguageSwitcher: solved problem with session-variables', 'I had troubles with my first experience in Laravel with session handling, because I had overlooked how exactly to write the statement for setting a session variable:\r\n(1) session(\'key\' => \'value\');\r\n(2) session([\'key\' => \'value\']);', '2024-12-11 07:05:54', '2025-02-08 15:40:36', '2024-12-11 07:05:54', 42, 'en', 1, '✅', '[11.12.]'),
(16, 'Footer: translate text and output depending on locale', NULL, '2024-12-11 08:00:54', '2025-02-08 15:41:22', '2024-12-11 08:00:54', 42, 'en', 1, '✅', '[11.12.]'),
(19, 'Page-Leaves: check for pending changes (ask to proceed or not)', NULL, '2025-02-08 10:15:00', '2025-03-06 09:58:14', '2025-02-08 10:15:00', 40, 'en', 1, '⌛', NULL),
(26, 'Teaser-Boxes, navigation & breadcrumb (generated dynamically)', NULL, '2024-12-17 12:03:15', '2025-02-08 15:50:30', '2024-12-17 12:03:15', 42, 'en', 1, '✅', '[17.12.]'),
(27, 'Hamburg menu: home + most important entry points', NULL, '2024-12-16 09:03:16', '2025-02-08 15:44:19', '2024-12-16 09:03:16', 42, 'en', 1, '✅', '[16.12.]'),
(28, 'Home-Logo, additional routes (with minimal controller classes)', NULL, '2024-12-17 15:03:17', '2025-02-08 15:47:02', '2024-12-17 15:03:17', 42, 'en', 1, '✅', '[17.12.]'),
(30, 'Split up layout and blades: welcome-page / sub-pages', NULL, '2024-12-16 13:45:19', '2025-02-08 15:44:53', '2024-12-16 13:45:19', 42, 'en', 1, '✅', '[16.12.]'),
(31, 'New: Project - Switcher, adapt: ProjectController', NULL, '2024-12-13 11:03:20', '2025-02-08 15:43:44', '2024-12-13 11:03:20', 42, 'en', 1, '✅', '[13.12.]'),
(32, 'Adapted: WelcomeController, welcome.blade.php', NULL, '2024-12-11 15:06:56', '2025-02-08 15:42:39', '2024-12-11 15:06:56', 42, 'en', 1, '✅', '[11.12.]'),
(34, 'New class TranslationHelper & model function translatableFields()', NULL, '2024-12-18 07:26:26', '2025-02-08 15:46:46', '2024-12-18 07:26:26', 42, 'en', 1, '✅', '[18.12.]'),
(36, '<a href=\"https://www.linkedin.com/learning/laravel-essential-training/understand-laravel-configuration?autoSkip=true&resume=false&u=0\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel Essential Training (Part I)</a>', NULL, '2024-12-26 07:00:00', '2025-01-16 10:33:31', '2024-12-26 07:00:00', 39, 'en', 1, '✅', '[26.12.]'),
(37, 'Install XAMPP: <a href=\"https://www.apachefriends.org/de/index.html\" class=\"external-link\" target=\"_blank\">XAMPP - Download</a>', NULL, '2024-12-09 09:02:54', '2025-01-16 10:29:53', '2024-12-09 09:02:54', 36, 'en', 1, '✅', '[09.12.]'),
(38, 'Preparations: cleanup and update system', 'Detailed steps - for Mac:\r\n(1) cleanup system: deinstall old MySQL and PHP versions & web servers \r\n(2) install or update Homebrew and Node to newest versions\r\n(3) install PHP 8.4 and make it globally available', '2024-12-08 13:30:00', '2025-01-16 10:29:07', '2024-12-08 13:30:00', 36, 'en', 1, '✅', '[08.12.]'),
(39, 'Install PHP Composer', '(1)  brew install composer\r\n(2)  set composer PATH variable:\r\n       ~/.zshrc -> edit \r\n       add the following line at the end of the file:\r\n       export PATH=\"$HOME/.composer/vendor/bin:$PATH\"\r\n       source ~/.zshrc', '2024-12-09 09:36:15', '2025-03-06 17:13:12', '2024-12-09 09:36:15', 36, 'en', 1, '✅', '[09.12.]'),
(40, 'Install Laravel-Installer', '(1) composer global require laravel/installer', '2024-12-09 09:45:17', '2025-03-06 17:23:38', '2024-12-09 09:45:17', 36, 'en', 1, '✅', '[09.12.]'),
(41, 'Create first Laravel project \'ProjectNavigator\': <a  href=\"http://localhost:8000/\" class=\"external-link\" target=\"_blank\">ProjectNavigator</a>', 'Change to the directory where you want to create the new Laravel project:\r\n(1) laravel new ProjectNavigator\r\n(2) select: Breeze, Blade with Alpine, PHPUnit, MySQL, default migrations & as db: projectnavigator\r\n(3) cd ProjectNavigator \r\n(4) npm install && npm run build \r\n(5) composer run dev', '2024-12-09 10:02:09', '2025-03-06 17:27:56', '2024-12-09 10:02:09', 36, 'en', 1, '✅', '[09.12.]'),
(42, 'XAMPP-Dashboard: <a href=\"http://nephele.fritz.box/dashboard/howto.html\" class=\"external-link\" target=\"_blank\">XAMPP howto guides</a>, <a href=\"http://nephele.fritz.box/phpmyadmin/index.php\" class=\"external-link\" target=\"_blank\">phpMyAdmin</a>', NULL, '2024-12-09 09:32:41', '2025-01-16 10:29:30', '2024-12-09 09:32:41', 36, 'en', 1, '✅', '[09.12.]'),
(43, '<a href=\"https://www.youtube.com/watch?v=rQvDX4gld1I\" class=\"external-link\" target=\"_blank\">YouTube: Laravel - Caching</a>', NULL, '2024-12-19 10:07:00', '2025-02-04 17:28:33', '2024-12-19 10:07:00', 39, 'en', 0, '✅', '[19.12.]'),
(44, '<a href=\"https://laravel.com/docs/11.x/views#view-composers\" class=\"external-link\" target=\"_blank\">Laravel - Documentation: How to  build View Composers</a>', NULL, '2024-12-13 14:21:00', '2025-02-04 17:29:04', '2024-12-13 14:21:00', 39, 'en', 0, '✅', '[13.12.]'),
(45, 'Languages: \'locale\' is restricted to CHAR(2)', NULL, '2024-12-26 12:21:00', '2025-01-16 10:31:45', '2024-12-26 12:21:00', 45, 'en', 1, '⚠️', '[26.12.]'),
(46, '<a href=\"https://github.com/LinkedInLearning/laravel-essential-training-2710093\" class=\"external-link\" target=\"_blank\">Github: Laravel Essential Training (Part I) - Examples</a>', NULL, '2024-12-26 07:00:00', '2025-02-05 10:35:51', '2024-12-26 07:00:00', 39, 'en', 0, '✅', '[26.12.]'),
(47, '<a href=\"https://symmetrical-space-carnival-7456pg4wxwqcx494.github.dev/\" class=\"external-link\" target=\"_blank\">Github: Laravel Essential Training (Part I) - Codespace</a>', NULL, '2024-12-26 07:00:00', '2025-02-04 17:28:01', '2024-12-26 07:00:00', 39, 'en', 0, '✅', '[26.12.]'),
(48, '<a href=\"https://www.linkedin.com/learning/advanced-laravel-22373805/beyond-the-basics?u=0\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel Essential Training (Part II)</a>', NULL, '2025-01-08 09:00:00', '2025-01-10 05:09:15', '2025-01-08 09:00:00', 39, 'en', 1, '✅', '[08.01.]'),
(49, 'Start to document my Laravel-Project', NULL, '2025-01-07 15:30:20', '2025-01-10 07:19:35', '2025-01-07 15:30:20', 42, 'en', 1, '✅', '[07.01.]'),
(51, 'All documentation is practice-oriented and based on proven methods.', NULL, '2025-01-02 08:02:40', '2025-01-02 08:03:43', '2025-01-02 08:02:40', 49, 'en', 1, '🌟', NULL),
(52, 'Clearly and comprehensibly structured so that you can follow every step.', NULL, '2025-01-02 08:01:11', '2025-01-02 08:03:36', '2025-01-02 08:01:11', 49, 'en', 1, '🌟', NULL),
(53, 'Ideal for beginners who want to implement projects independently.', NULL, '2025-01-02 08:00:20', '2025-01-02 08:02:46', '2025-01-02 08:00:20', 49, 'en', 1, '🌟', NULL),
(54, 'Find out how projects are created and what challenges are overcome.', NULL, '2025-01-02 08:16:10', '2025-01-02 08:16:10', '2025-01-02 08:16:10', 50, 'en', 1, '👀', NULL),
(55, 'From planning to implementation - no question remains unanswered.', NULL, '2025-01-02 08:15:14', '2025-01-02 08:15:14', '2025-01-02 08:15:14', 50, 'en', 1, '👀', NULL),
(56, 'Gain valuable insights into tools, technologies and best practices.', NULL, '2025-01-02 08:14:32', '2025-01-02 08:18:28', '2025-01-02 08:14:32', 50, 'en', 1, '👀', NULL),
(57, 'Log in to get full access to the content.', NULL, '2025-01-02 08:23:58', '2025-01-02 08:23:58', '2025-01-02 08:23:58', 51, 'en', 1, '💡', NULL),
(58, 'Select a project that interests you and dive into the details.', NULL, '2025-01-02 08:22:37', '2025-01-02 08:22:37', '2025-01-02 08:22:37', 51, 'en', 1, '💡', NULL),
(59, 'Follow the instructions and complete the steps at your own pace.', NULL, '2025-01-02 08:21:41', '2025-01-02 08:21:41', '2025-01-02 08:21:41', 51, 'en', 1, '💡', NULL),
(60, 'To view the full project documentatios, you need to register and log in.', NULL, '2025-01-02 08:30:08', '2025-01-02 08:40:53', '2025-01-02 08:30:08', 52, 'en', 1, '🔐', NULL),
(61, 'Until then, here\'s a little insight into what you can expect:', '“Imagine you can build projects like a pro - without detours, with clear instructions and inspiring ideas. Join in and be amazed by your success!”', '2025-01-02 08:28:56', '2025-01-11 07:01:19', '2025-01-02 08:28:56', 52, 'en', 1, '🔐', NULL),
(62, 'Still unsure? Take a look at the <a href=\"#\" class=\"external-link\">preview</a> and discover the possibilities.', NULL, '2025-01-02 08:53:44', '2025-01-02 08:53:44', '2025-01-02 08:53:44', 53, 'en', 1, '👉', NULL),
(63, 'Curious? Register now and start your first project!', NULL, '2025-01-02 08:54:39', '2025-01-02 08:54:58', '2025-01-02 08:54:39', 53, 'en', 1, '👉', NULL),
(64, 'Good luck & have fun!', NULL, '2025-01-02 09:07:10', '2025-01-02 09:07:10', '2025-01-02 09:07:10', 54, 'en', 1, '💪', NULL),
(65, '<strong>Your access to structured knowledge and inspiring projects awaits.</strong>', NULL, '2025-01-02 09:07:24', '2025-01-02 09:07:24', '2025-01-02 09:07:24', 54, 'en', 1, '🚀', NULL),
(77, '<a href=\"https://www.linkedin.com/learning/laravel-grundkurs-1-installation-datenbankkonfiguration-und-grundlegende-features/\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel-Basics (Part I)</a>', NULL, '2024-12-08 14:30:00', '2025-03-06 15:58:53', '2024-12-08 14:30:00', 39, 'en', 0, '✅', '[08.12.]'),
(78, '<a href=\"https://www.linkedin.com/learning/laravel-grundkurs-2-rest-apis-und-formulare/\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel-Bascis (Part II)</a>', NULL, '2024-12-08 17:30:40', '2025-02-04 17:29:53', '2024-12-08 17:30:40', 39, 'en', 0, '✅', '[08.12.]'),
(79, 'RE-start to document my Laravel-Project :-(((', NULL, '2025-01-08 14:50:00', '2025-01-10 07:19:22', '2025-01-08 14:50:00', 42, 'en', 1, '✅', '[08.01.]'),
(80, 'CleanUp: replace created-updated, unifications, comments, ...', NULL, '2025-01-08 07:05:00', '2025-01-08 07:05:00', '2025-01-08 07:05:00', 42, 'en', 1, '✅', '[08.01.]'),
(81, 'Create AuthServiceProvider & Gate isAdminUser', NULL, '2025-01-08 14:30:40', '2025-01-08 14:30:40', '2025-01-08 14:30:40', 42, 'en', 1, '✅', '[08.01.]'),
(82, 'Gate: renamed to \'administrate\' & integrated to project & translation', NULL, '2025-01-09 07:10:50', '2025-01-10 05:55:11', '2025-01-09 07:10:50', 42, 'en', 0, '✅', '[09.01.]'),
(83, 'Cookie for userLocale (= default language of logged in user)', NULL, '2025-01-09 09:13:10', '2025-01-09 09:13:10', '2025-01-09 09:13:10', 42, 'en', 1, '✅', '[09.01.]'),
(84, 'New: ProjectPolicy', '(1) Gate = global safety checks\r\n(2) Middleware = secure http-requests (e.g., routes)\r\n(3) Policy = model-based safety checks', '2025-01-09 10:45:09', '2025-01-13 07:22:09', '2025-01-09 10:45:09', 42, 'en', 1, '✅', '[09.01.]'),
(85, 'New: Events & Listeners', '(1) php artisan make:event TranslationMissing\r\n(2) php artisan make:listener NotifyTranslationMissing --event=TranslationMissing\r\n(3) TranslationMissing::dispatch($user, $project);\r\n---\r\n(4) EventServiceProvider -> bootstrap/providers.php', '2025-01-09 12:00:10', '2025-01-13 07:13:59', '2025-01-09 12:00:10', 42, 'en', 1, '✅', '[09.01.]'),
(86, 'New: TranslationMissingMail, emails.translation-missing.blade.php', '(1) php artisan make:mail TranslationMissingMail\r\n(2) check configuration in: config/mail.php & .env\r\n(3) to send dummy-emails use <strong>mailtrap.io</strong>', '2025-01-09 14:02:45', '2025-01-13 07:17:54', '2025-01-09 14:02:45', 42, 'en', 1, '✅', '[09.01.]'),
(87, 'New: NewTaskCreatedNotification, NewTaskCreatedJob', NULL, '2025-01-09 14:47:56', '2025-01-09 14:47:56', '2025-01-09 14:47:56', 42, 'en', 1, '✅', '[09.01.]'),
(88, 'Abort with error if no featured project is defined', NULL, '2025-01-09 16:20:15', '2025-01-09 16:20:15', '2025-01-09 16:20:15', 42, 'en', 1, '✅', '[09.01.]'),
(89, 'Install Telescope', NULL, '2025-01-10 14:20:00', '2025-01-10 14:20:00', '2025-01-10 14:20:00', 36, 'en', 1, '✅', '[10.01.]'),
(90, 'Create new project folder db_export', NULL, '2025-01-10 07:00:15', '2025-01-10 07:00:15', '2025-01-10 07:00:15', 42, 'en', 1, '✅', '[10.01.]'),
(91, 'Continue: document my Laravel-Project', NULL, '2025-01-10 07:20:43', '2025-01-10 07:20:43', '2025-01-10 07:20:43', 42, 'en', 1, '✅', '[10.01.]'),
(92, 'New: Observer Classes', NULL, '2025-01-07 07:00:48', '2025-01-07 07:00:48', '2025-01-07 07:00:48', 42, 'en', 1, '✅', '[07.01.]'),
(93, 'New: TranslationController', NULL, '2025-01-07 08:15:00', '2025-01-07 08:15:00', '2025-01-07 08:15:00', 42, 'en', 1, '✅', '[07.01.]'),
(94, 'New: Trait TranslatableMethods', NULL, '2025-01-07 11:30:20', '2025-01-07 11:30:20', '2025-01-07 11:30:20', 42, 'en', 1, '✅', '[07.01.]'),
(95, 'Rework: TranslationHelper', NULL, '2025-01-07 12:42:00', '2025-01-07 12:42:00', '2025-01-07 12:42:00', 42, 'en', 1, '✅', '[07.01.]'),
(96, 'Check query-executions and log-/loading-process', NULL, '2025-01-07 15:00:00', '2025-01-07 15:00:00', '2025-01-07 15:00:00', 42, 'en', 1, '✅', '[07.01.]'),
(97, 'Create new Middleware EnsureUserIsAdmin', 'to pass parameters to middleware: \'isAdminUser:instructor\' \r\n(instructor = param provided to middleware \'isAdminUser\')', '2025-01-02 07:00:28', '2025-01-13 07:48:10', '2025-01-02 07:00:28', 42, 'en', 1, '✅', '[02.01.]'),
(98, 'Create ProjectNavigator project and fill in DB data', NULL, '2025-01-02 10:15:07', '2025-01-10 08:02:07', '2025-01-02 10:15:07', 42, 'en', 1, '✅', '[02.01.]'),
(99, 'Correct teaser-blade (wrong link & presentation)', NULL, '2025-01-02 14:00:02', '2025-01-02 14:00:02', '2025-01-02 14:00:02', 42, 'en', 1, '✅', '[02.01.]'),
(100, 'Adaptions for navigation and links', NULL, '2025-01-02 14:25:47', '2025-01-02 14:25:47', '2025-01-02 14:25:47', 42, 'en', 1, '✅', '[02.01.]'),
(101, 'Adapt / change icons for projects.index', NULL, '2025-01-02 14:42:15', '2025-01-02 14:42:15', '2025-01-02 14:42:15', 42, 'en', 1, '✅', '[02.01.]'),
(102, 'Adapt / change icons for all other index blades', NULL, '2025-01-03 07:00:46', '2025-01-03 07:00:46', '2025-01-03 07:00:46', 42, 'en', 1, '✅', '[03.01.]'),
(103, 'Rework language files (text/message files)', NULL, '2025-01-03 08:06:35', '2025-01-03 08:06:35', '2025-01-03 08:06:35', 42, 'en', 1, '✅', '[03.01.]'),
(104, 'projects.show: include edit-button (isAdminUser)', NULL, '2025-01-03 09:00:14', '2025-01-03 09:00:14', '2025-01-03 09:00:14', 42, 'en', 1, '✅', '[03.01.]'),
(105, 'projects.show: implement new views (byscope, latest, latesttask, chronological, withalldetails)', NULL, '2025-01-03 09:22:11', '2025-01-03 09:22:11', '2025-01-03 09:22:11', 42, 'en', 1, '✅', '[03.01.]'),
(106, 'Create new view component: projects.show-task-sorted', NULL, '2025-01-03 14:23:17', '2025-01-10 08:23:17', '2025-01-03 14:23:17', 42, 'en', 1, '✅', '[03.01.]'),
(107, 'Corrections: base-layout & projects.index', NULL, '2024-12-20 07:00:37', '2024-12-20 07:00:37', '2024-12-20 07:00:37', 42, 'en', 1, '✅', '[20.12.]'),
(108, 'LanguageService: adapted with caching mechanism', NULL, '2024-12-20 10:30:23', '2024-12-20 10:30:23', '2024-12-20 10:30:23', 42, 'en', 1, '✅', '[20.12.]'),
(109, 'All services: optimized log-entries', NULL, '2024-12-20 11:30:46', '2024-12-20 11:30:46', '2024-12-20 11:30:46', 42, 'en', 1, '✅', '[20.12.]'),
(110, 'Inspect loading chain of Laravel-Framework for a single page load', NULL, '2024-12-20 12:31:59', '2024-12-20 12:31:59', '2024-12-20 12:31:59', 42, 'en', 1, '✅', '[20.12.]'),
(111, 'New: projects.destroy', NULL, '2024-12-20 14:45:07', '2024-12-20 14:45:07', '2024-12-20 14:45:07', 42, 'en', 1, '✅', '[20.12.]'),
(112, 'Finished Controller for Project, Scope and TaskDetailType', NULL, '2024-12-27 11:45:00', '2024-12-27 11:45:00', '2024-12-27 11:45:00', 42, 'en', 1, '✅', '[27.12.]'),
(113, 'Finished Controller for Task and TaskDetail', 'Addtional Informations:\r\n(1) $request->query()\r\n(2) $notes = Auth::user()->notes->latest(\'updated_at\')->paginate(5);\r\n(3) $notes = Note::whereBelongsTo(Auth::user())->latest(...)...\r\n(4)  if ($note->user->is(Auth::user())) {...}', '2024-12-30 13:38:22', '2025-01-13 09:36:26', '2024-12-30 13:38:22', 42, 'en', 1, '✅', '[30.12.]'),
(114, 'ProjectNavigator: configure version control & synchronize with Github repo', NULL, '2024-12-09 11:15:21', '2025-03-06 17:36:15', '2024-12-09 11:15:21', 42, 'en', 1, '✅', '[09.12.]'),
(115, 'ProjectNavigator: inspect project structure in VSCode', NULL, '2024-12-09 12:07:27', '2025-03-06 18:34:02', '2024-12-09 12:07:27', 42, 'en', 1, '✅', '[09.12.]'),
(116, 'Create a first table, model and factory', NULL, '2024-12-09 13:15:17', '2024-12-09 13:15:17', '2024-12-09 13:15:17', 42, 'en', 1, '✅', '[09.12.]'),
(117, 'Create a TaskController, a route, a view & try it out!', NULL, '2024-12-09 14:01:33', '2025-03-07 10:08:50', '2024-12-09 14:01:33', 42, 'en', 1, '✅', '[09.12.]'),
(118, 'Deciding on the exercise project for this training:', 'After some initial experiments to get a feel for the basic functionality of Laravel, I took some time to think about which example I wanted to work on during the training, which DB tables I needed for it, and what the layout should look like.\r\n\r\nThe decisions I made were: \r\n(1) My project should document my own work in this course.\r\n(2) I had a list of DB tables and their fields.\r\n(3) My project should support at least 2 languages (en+de) and be extendable for other languages.\r\n(4) In addition to capturing the basic data, a general translation functionality should be available.\r\n(5) I made 2-3 layout sketches of how my project should look and function. I kept the requirements for the layout and the UI interface very simple, as the focus of my training is on the backend side.\r\n\r\nI was then able to start the implementation step by step.', '2024-12-10 07:00:35', '2025-03-06 17:51:21', '2024-12-10 07:00:35', 42, 'en', 1, '✅', '[10.12.]'),
(119, 'Create table project (with migration, model, factory classes)', NULL, '2024-12-10 09:09:50', '2024-12-10 09:09:50', '2024-12-10 09:09:50', 42, 'en', 1, '✅', '[10.12.]'),
(120, 'Create WelcomeController for home route', NULL, '2024-12-10 10:41:04', '2024-12-10 10:41:04', '2024-12-10 10:41:04', 42, 'en', 1, '✅', '[10.12.]'),
(121, 'Create basic HTML and CSS for my welcome view', NULL, '2024-12-10 11:15:07', '2024-12-10 11:15:07', '2024-12-10 11:15:07', 42, 'en', 1, '✅', '[10.12.]'),
(122, 'Create folders for multilingual support (lang/en, lang/de)', NULL, '2024-12-10 13:04:29', '2024-12-10 13:04:29', '2024-12-10 13:04:29', 42, 'en', 1, '✅', '[10.12.]'),
(123, 'Configure logging (daily) & insert log-messages', NULL, '2024-12-10 13:45:53', '2024-12-10 13:45:53', '2024-12-10 13:45:53', 42, 'en', 1, '✅', '[10.12.]'),
(124, 'Create language-switcher with route and session-handling', NULL, '2024-12-10 14:15:23', '2025-01-10 10:05:35', '2024-12-10 14:15:23', 42, 'en', 1, '✅', '[10.12.]'),
(125, 'Create middleware for LanguageSwitcher', '<strong>Additional info:</strong>\r\n(1) register in AppServiceProvider\r\n(2) AppServiceProvider is integrate in bootstrap/app.php', '2024-12-10 15:10:43', '2024-12-10 15:10:43', '2024-12-10 15:10:43', 42, 'en', 1, '✅', '[10.12.]'),
(126, 'Footer: translateable, header: date-format, changes LanguageSwitcher', NULL, '2024-12-11 08:00:50', '2025-01-10 10:18:02', '2024-12-11 08:00:50', 42, 'en', 1, '✅', '[11.12.]'),
(127, 'Detailed concept & structure/layout for subpages (blades)', NULL, '2024-12-11 09:03:56', '2024-12-11 09:03:56', '2024-12-11 09:03:56', 42, 'en', 1, '✅', '[11.12.]'),
(128, 'Concept for login & propagation of dynamic data through all/certain views', NULL, '2024-12-11 13:21:51', '2024-12-11 13:21:51', '2024-12-11 13:21:51', 42, 'en', 1, '✅', '[11.12.]'),
(129, 'Concept how to extend existing DB data model', NULL, '2024-12-11 14:29:10', '2024-12-11 14:29:10', '2024-12-11 14:29:10', 42, 'en', 1, '✅', '[11.12.]'),
(130, 'Create LoggingService (maybe use AOP)', NULL, '2025-02-08 10:05:00', '2025-02-08 09:45:00', '2025-02-08 10:05:00', 40, 'en', 1, '⌛', NULL),
(131, 'Adapt user-table; new: scope, tasks, task detail, task type (migration, factory, seeder)', NULL, '2024-12-12 09:07:02', '2024-12-12 09:07:02', '2024-12-12 09:07:02', 42, 'en', 1, '✅', '[12.12.]'),
(132, 'Welcome view & controller: show featured data from DB (scopes / tasks)', NULL, '2024-12-12 12:00:01', '2024-12-12 12:00:01', '2024-12-12 12:00:01', 42, 'en', 1, '✅', '[12.12.]'),
(133, 'Debugbar problem solved; dd (++)', NULL, '2024-12-13 07:02:49', '2024-12-13 07:02:49', '2024-12-13 07:02:49', 42, 'en', 1, '✅', '[13.12.]'),
(134, 'Doku: @props, fake(), Factory & Seeder for Unit-Tests; Laravel Mix <-> Vite', NULL, '2024-12-13 08:04:09', '2024-12-13 08:04:09', '2024-12-13 08:04:09', 42, 'en', 1, '✅', '[13.12.]'),
(135, 'New: ViewComposer', NULL, '2024-12-13 13:09:10', '2024-12-13 13:09:10', '2024-12-13 13:09:10', 42, 'en', 1, '✅', '[13.12.]'),
(136, 'Use Vite for: css, images', NULL, '2024-12-16 07:00:16', '2024-12-16 07:00:16', '2024-12-16 07:00:16', 42, 'en', 1, '✅', '[16.12.]'),
(137, 'Adapt ViewComposer for Welcome page & Subpage Layout', NULL, '2024-12-17 07:00:38', '2024-12-17 07:00:38', '2024-12-17 07:00:38', 42, 'en', 1, '✅', '[17.12.]'),
(138, 'New: NaviagtionService + TeaserService', NULL, '2024-12-17 09:11:09', '2024-12-17 09:11:09', '2024-12-17 09:11:09', 42, 'en', 1, '✅', '[17.12.]'),
(139, 'Integrate TranslationHelper into Controller, Middleware and Services', NULL, '2024-12-18 14:35:28', '2024-12-18 14:35:28', '2024-12-18 14:35:28', 42, 'en', 1, '✅', '[18.12.]'),
(140, 'Switch to RESTful routes: first example = Project / adapt breadcrumb: consider id\'s {model}', '(1) list all existing routes: php artisan route:list\r\n(2) list all artisan commands: php artisan list', '2024-12-19 07:00:44', '2025-01-13 08:14:53', '2024-12-19 07:00:44', 42, 'en', 1, '✅', '[19.12.]'),
(141, 'Adapt & finish: Project - index, switch, create, store, show, edit, update', NULL, '2024-12-19 10:43:36', '2024-12-19 10:43:36', '2024-12-19 10:43:36', 42, 'en', 1, '✅', '[19.12.]'),
(142, 'Middleware & Controller: auth()-check() vs. Auth::check()', NULL, '2025-02-04 15:44:36', '2025-02-04 18:46:28', '2025-02-04 15:44:36', 42, 'en', 1, '✅', '[04.02.]'),
(143, 'User: add column \'default_project\' (add value to cookies)', NULL, '2025-02-06 09:55:26', '2025-02-06 09:59:58', '2025-02-06 09:55:26', 42, 'en', 1, '✅', '[06.02.]'),
(144, 'getTranslatedField: check if locale = originLocale (adapt blades)', NULL, '2025-02-03 09:00:23', '2025-02-03 09:59:07', '2025-02-03 09:00:23', 42, 'en', 1, '✅', '[03.02.]'),
(145, 'Form-Fields: add props autofocus, className (create, search, edit, ...)', NULL, '2025-02-05 15:30:24', '2025-02-05 14:52:59', '2025-02-05 15:30:24', 42, 'en', 1, '✅', '[05.02.]'),
(146, 'Search-Block: use form-field components', NULL, '2025-02-06 09:04:41', '2025-02-06 09:04:41', '2025-02-06 09:04:41', 42, 'en', 1, '✅', '[06.02.]'),
(147, 'Welcome-Blade: use components (links, scopeLeft, ScopeRight + opt: descr)', NULL, '2025-02-05 14:00:03', '2025-02-05 14:53:56', '2025-02-05 14:00:03', 42, 'en', 1, '✅', '[05.02.]'),
(148, 'Re-Check DB-queries & DB-indizes', NULL, '2025-02-08 10:45:00', '2025-02-20 09:01:22', '2025-02-19 15:45:00', 42, 'en', 1, '✅', '[19.02.]'),
(149, 'Add file upload to TaskDetail', NULL, '2025-02-05 08:50:32', '2025-02-05 08:50:32', '2025-02-05 08:50:32', 41, 'en', 1, '🤔', NULL),
(150, 'Index-Blades: add \'No records found!\'', NULL, '2025-02-05 10:00:49', '2025-02-05 14:54:41', '2025-02-05 10:00:49', 42, 'en', 1, '✅', '[05.02.]'),
(151, 'BE: Rework Navigation', NULL, '2025-02-07 08:30:12', '2025-02-07 08:30:12', '2025-02-07 08:30:12', 42, 'en', 1, '✅', '[07.02.]'),
(152, 'Use \'white-space-pre-wrap\' in addition to \'{!! ... !!}\' for description', NULL, '2025-02-05 13:04:23', '2025-02-05 13:22:46', '2025-02-05 13:04:23', 42, 'en', 1, '✅', '[05.02.]'),
(154, 'getSopces & getTaskDetailTypes: create ServiceClass', NULL, '2025-01-14 06:08:12', '2025-01-14 06:08:12', '2025-01-14 06:08:12', 42, 'en', 1, '✅', '[14.01.]'),
(155, 'Re-work: session, cache, cookie & use different session-cookies (FE, BE)', NULL, '2025-02-06 14:01:16', '2025-02-06 15:57:32', '2025-02-06 14:01:16', 42, 'en', 1, '✅', '[06.02.]'),
(156, 'Project-Lists (FE+BE): integrate interactions', NULL, '2025-02-08 10:30:00', '2025-02-20 10:53:51', '2025-02-08 10:30:00', 40, 'en', 1, '⌛', NULL),
(157, 'Create routes with UUID (not id\'s)', NULL, '2025-02-05 07:21:29', '2025-02-05 07:21:29', '2025-02-05 07:21:29', 41, 'en', 1, '🤔', NULL),
(158, 'Routes/Controllers: check for model binding (e.g., Project $project)', NULL, '2025-02-08 11:00:00', '2025-02-08 07:29:29', '2025-02-08 08:30:00', 42, 'en', 1, '✅', '[08.02.]'),
(159, 'Extended functionality: Login & Register', NULL, '2025-02-05 09:31:29', '2025-02-05 14:57:50', '2025-02-05 09:31:29', 41, 'en', 1, '🤔', NULL),
(160, '<a href=\"https://www.linkedin.com/learning/building-restful-apis-in-laravel-8532490/building-restful-apis-in-laravel?u=0\" class=\"external-link\">LinkedIn: REST-API - detailed (en)</a>', NULL, '2025-01-15 13:13:28', '2025-02-10 08:32:17', '2025-01-15 13:13:28', 39, 'en', 1, '✅', '[15.01.]'),
(161, '<a href=\"https://www.youtube.com/playlist?list=PLdXLsjL7A9k0esh2qNCtUMsGPLUWdLjHp\" class=\"external-link\" target=\"_blank\">YouTube: Laravel & Testing</a>', NULL, '2025-01-14 14:40:19', '2025-01-14 14:40:19', '2025-01-14 14:40:19', 39, 'en', 1, '✅', '[14.01.]'),
(162, '<a href=\"https://www.linkedin.com/learning/react-essential-training/building-modern-user-interfaces-with-react?u=0\" class=\"external-link\">LinkedIn: React</a>', NULL, '2025-01-26 09:00:00', '2025-02-10 08:44:25', '2025-02-10 09:00:00', 39, 'en', 1, '✅', '[10.02.]'),
(163, '<a href=\"https://www.linkedin.com/learning/building-a-website-with-laravel-react-js-and-inertia/building-a-website-with-laravel-react-and-inertia?u=0\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel & React</a>', NULL, '2025-01-16 07:45:05', '2025-01-16 07:45:05', '2025-01-16 07:45:05', 39, 'en', 1, '✅', '[16.01.]'),
(164, 'Create custom command: OrphanTranslations & schedule it', NULL, '2025-01-13 10:02:02', '2025-01-13 12:52:06', '2025-01-13 10:02:02', 42, 'en', 1, '✅', '[13.01.]'),
(165, 'Read Documentation: Broadcasting, Casts, Rules', NULL, '2025-01-13 13:17:11', '2025-01-13 13:54:54', '2025-01-13 13:17:11', 42, 'en', 1, '✅', '[13.01.]'),
(166, 'Read Documentation: Concurrent Tasks', NULL, '2025-01-13 14:15:06', '2025-01-13 14:15:06', '2025-01-13 14:15:06', 42, 'en', 1, '✅', '[13.01.]'),
(167, 'Docu: Repositories vs. Services', NULL, '2025-01-13 14:31:03', '2025-01-13 15:10:17', '2025-01-13 14:31:03', 42, 'en', 1, '✅', '[13.01.]'),
(168, 'Info: DTO', NULL, '2025-01-13 14:44:28', '2025-01-13 14:46:06', '2025-01-13 14:44:28', 42, 'en', 1, '✅', '[13.01.]'),
(169, 'Prepare & configure project for testing', NULL, '2025-01-14 08:28:08', '2025-01-14 08:28:08', '2025-01-14 08:28:08', 42, 'en', 1, '✅', '[14.01.]'),
(170, 'Inspect Laravel stubs files', NULL, '2025-01-14 07:58:51', '2025-01-14 07:58:51', '2025-01-14 07:58:51', 42, 'en', 1, '✅', '[14.01.]'),
(171, 'Create Feature & Unit Tests', NULL, '2025-01-14 09:23:34', '2025-01-14 10:23:34', '2025-01-14 09:23:34', 42, 'en', 1, '✅', '[14.01.]'),
(172, 'Install and work with API Package', NULL, '2025-01-15 06:38:41', '2025-01-15 06:38:41', '2025-01-15 06:38:41', 42, 'en', 1, '✅', '[15.01.]'),
(173, 'Testing with Dusk', NULL, '2025-01-15 16:10:40', '2025-01-15 16:10:40', '2025-01-15 16:10:40', 42, 'en', 1, '✅', '[15.01.]'),
(174, 'API routes: integrate versioning into routes', NULL, '2025-01-16 06:36:56', '2025-01-16 06:36:56', '2025-01-16 06:36:56', 42, 'en', 1, '✅', '[16.01.]'),
(175, 'tasks.index: correct title (do not show links, but link title)', NULL, '2025-01-16 07:10:07', '2025-01-18 09:35:33', '2025-01-16 07:10:07', 42, 'en', 1, '✅', '[16.01.]'),
(176, 'Install Vite & React', NULL, '2025-01-16 08:15:02', '2025-01-16 11:50:52', '2025-01-16 08:15:02', 42, 'en', 1, '✅', '[16.01.]'),
(177, 'Install InertiaJS for React', NULL, '2025-01-16 11:51:36', '2025-01-16 11:51:36', '2025-01-16 11:51:36', 42, 'en', 1, '✅', '[16.01.]'),
(178, 'Documentation: prod build process', NULL, '2025-01-18 06:59:24', '2025-01-18 06:59:24', '2025-01-18 06:59:24', 57, 'en', 1, '✅', '[18.01.]'),
(179, 'Re-work coding (corrs, optimize, standadrize, ...)', NULL, '2025-01-18 09:33:58', '2025-01-18 09:33:58', '2025-01-18 09:33:58', 42, 'en', 1, '✅', '[18.01.]'),
(180, 'Further work on API routes', NULL, '2025-01-20 07:28:00', '2025-01-20 07:28:00', '2025-01-20 07:28:00', 42, 'en', 1, '✅', '[20.01.]'),
(181, 'Re-work: create class-based view components', NULL, '2025-02-08 10:00:00', '2025-03-07 11:05:33', '2025-02-08 10:00:00', 41, 'en', 1, '🤔', NULL),
(183, 'FE: integrate users.default_project_id', NULL, '2025-02-07 06:30:29', '2025-02-07 06:30:29', '2025-02-07 06:30:29', 42, 'en', 1, '✅', '[07.02.]'),
(184, 'Create Helpers/apihelper.php: apiResponse', NULL, '2025-01-31 14:39:57', '2025-01-31 14:39:57', '2025-01-31 14:39:57', 42, 'en', 1, '✅', '[31.01.]'),
(185, 'Adapt navigation with x-responsive-nav-link and x-nav-dropdown', NULL, '2025-02-07 08:58:48', '2025-02-07 08:59:28', '2025-02-07 08:58:48', 41, 'en', 1, '🤔', NULL),
(186, 'Add passkey register/login as additional option (see: Obsidian)', NULL, '2025-02-05 09:30:00', '2025-02-07 09:20:46', '2025-02-05 09:30:00', 41, 'en', 1, '🤔', NULL),
(189, 'Add new field occurred_at to tasks and task_details', NULL, '2025-02-07 14:25:39', '2025-02-07 14:35:51', '2025-02-07 14:25:33', 42, 'en', 1, '✅', '[07.02.]'),
(192, 'Re-work API Controllers (return type, model-binding, ...)', NULL, '2025-02-08 07:55:27', '2025-02-08 07:55:27', '2025-02-08 13:30:00', 42, 'en', 1, '✅', '[08.02.]'),
(193, 'FE: show all project details', NULL, '2025-02-08 14:34:30', '2025-02-08 14:34:30', '2025-02-08 15:34:07', 42, 'en', 1, '✅', '[08.02.]'),
(194, 'FE: read config.view & icons from BE', NULL, '2025-02-08 16:14:02', '2025-02-08 16:14:02', '2025-02-08 10:10:00', 40, 'en', 1, '⌛', NULL),
(196, 'Re-test Thunder Client API requests', NULL, '2025-02-09 08:58:36', '2025-02-09 08:58:36', '2025-02-09 09:15:50', 42, 'en', 1, '✅', '[09.02.]'),
(197, 'Re-work / add missing API messages (en + de)', NULL, '2025-02-09 09:53:01', '2025-02-09 09:53:01', '2025-02-09 09:52:26', 42, 'en', 1, '✅', '[09.02.]'),
(198, 'FE: re-work list items - replace key settings from array-indizes with object-ids', NULL, '2025-02-10 10:45:42', '2025-02-10 10:49:49', '2025-02-10 10:44:08', 42, 'en', 1, '✅', '[10.02.]'),
(200, 'BE: check session-variable usage in all classes used from both, web and api', NULL, '2025-02-18 12:07:10', '2025-02-18 12:07:27', '2025-02-18 10:05:03', 42, 'en', 1, '✅', '[18.02.]'),
(201, 'Project-Lists (BE): integrate pagination', NULL, '2025-02-20 09:03:25', '2025-02-20 11:22:12', '2025-02-19 13:06:45', 42, 'en', 1, '✅', '[19.02.]'),
(203, 'Task: icon is implemented as select-box (create, edit)', NULL, '2025-02-20 09:36:17', '2025-02-20 09:36:17', '2025-02-20 09:30:00', 42, 'en', 1, '✅', '[20.02.]'),
(204, 'FE: correct welcome page', NULL, '2025-02-20 10:55:20', '2025-02-20 10:55:20', '2025-02-20 10:50:00', 42, 'en', 1, '✅', '[20.02.]'),
(205, 'Project-Lists (FE): integrate pagination / scopeId (byscope)', NULL, '2025-02-20 11:19:08', '2025-02-21 16:30:01', '2025-02-21 16:15:00', 42, 'en', 1, '✅', '[21.02.]'),
(206, 'FE: adapt project views to new concept (some views provide pagination)', NULL, '2025-02-20 12:55:30', '2025-03-06 10:23:08', '2025-02-20 13:00:00', 42, 'en', 1, '✅', '[20.02.]'),
(207, 'Welcome-Page (FE): optimize coding (new component ScopeList.jsx)', NULL, '2025-02-20 13:49:58', '2025-02-20 13:49:58', '2025-02-20 13:50:00', 42, 'en', 1, '✅', '[20.02.]'),
(208, 'DB-Indizes: add migrations for indizes created temporary during query tests', NULL, '2025-02-20 14:06:23', '2025-02-20 14:06:23', '2025-02-20 14:30:00', 42, 'en', 1, '✅', '[20.02.]'),
(209, 'BE: optimize ProjectService (after integration of paginations)', NULL, '2025-02-20 15:21:00', '2025-03-06 13:13:58', '2025-03-05 12:10:00', 42, 'en', 1, '✅', '[05.03.]'),
(210, 'TranslationHelper: support collections with pagination & arrays', NULL, '2025-03-06 10:25:21', '2025-03-06 10:25:32', '2025-03-06 10:24:15', 40, 'en', 1, '⌛', NULL),
(211, 'Translations: use record-delete instead of record-update on null-value', NULL, '2025-03-06 10:30:36', '2025-03-06 10:30:36', '2025-03-06 10:30:00', 42, 'en', 1, '✅', '[06.03.]'),
(212, 'FE: Project/Details.jsx - avoid unnecessary axios-invocations', NULL, '2025-03-06 10:37:02', '2025-03-06 10:37:02', '2025-03-05 15:40:45', 42, 'en', 1, '✅', '[05.03.]'),
(213, 'FE: useEffect - avoid multiple calls - alternative solutions (isUpdatingRef?)', NULL, '2025-03-06 13:28:53', '2025-03-06 15:39:42', '2025-03-06 13:27:42', 40, 'en', 0, '⌛', NULL),
(214, 'Project-Details-View: integrate search function', NULL, '2025-03-06 15:41:16', '2025-03-06 15:41:16', '2025-03-06 15:40:00', 40, 'en', 1, '⌛', NULL),
(215, 'FE: npm install dompurify', NULL, '2025-03-06 16:53:33', '2025-03-06 16:53:33', '2025-03-06 16:53:07', 42, 'en', 1, '✅', '[06.03.]'),
(216, 'Upgrade ProjectNavigator to Laravel 12', NULL, '2025-03-07 11:06:18', '2025-03-07 11:07:50', '2025-03-07 11:05:49', 40, 'en', 1, '⌛', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `task_details`
--

DROP TABLE IF EXISTS `task_details`;
CREATE TABLE IF NOT EXISTS `task_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `task_detail_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `occurred_at` timestamp NULL DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task_details_task_detail_type_id_foreign` (`task_detail_type_id`),
  KEY `task_details_task_id_foreign` (`task_id`),
  KEY `task_details_occurred_at_title_index` (`occurred_at`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `task_details`:
--   `task_detail_type_id`
--       `task_detail_types` -> `id`
--   `task_id`
--       `tasks` -> `id`
--

--
-- Daten für Tabelle `task_details`
--

INSERT IGNORE INTO `task_details` (`id`, `description`, `locale`, `task_detail_type_id`, `created_at`, `updated_at`, `occurred_at`, `task_id`) VALUES
(22, 'Excuting default-tests coming with basic project creation deleted my DB content !\r\nWhile I was watching my learning video, I tried out these tests without realizing what the consequences would be and I didn\'t make a DB backup for one day!', 'en', 1, '2025-01-08 14:50:00', '2025-01-10 05:32:22', '2025-01-08 14:50:00', 79),
(23, 'Correction done in Middleware SetGlobalData.', 'en', 1, '2025-01-09 16:48:29', '2025-01-09 16:48:29', '2025-01-09 16:48:29', 88),
(24, '<pre>composer require laravel/telescope<br/>php artisan telescope:install<br/>php artisan migrate<br/>http://localhost:8000/telescope</pre>', 'en', 2, '2025-01-10 14:21:00', '2025-01-11 07:29:50', '2025-01-10 14:21:00', 89),
(25, 'This directory is used to include regular backups of all database content required for the operation of the website in the versioning process. This is either configuration data or already live data that must not be lost.', 'en', 1, '2025-01-10 07:10:00', '2025-01-10 07:10:00', '2025-01-10 07:10:00', 90),
(26, 'To avoid having to implement a boot function in every model class (which is how it was solved so far), I decided to implement observer classes that monitor the events \'creating\', \'updating\' and \'deleted\'. This distributes the tasks to the right place, as intended by Laravel\'s design.', 'en', 1, '2025-01-07 07:55:50', '2025-01-07 07:55:50', '2025-01-07 07:55:50', 92),
(27, 'In order to avoid having to import the helper class TranslationHelper into every controller, service or other classes and to ensure that the IDE already recognizes if a model does not provide a translation functionality, I decided to provide models with translation capabilities via a trait.', 'en', 1, '2025-01-07 11:35:00', '2025-01-07 11:35:00', '2025-01-07 11:35:00', 94),
(28, '(1) Adapt login and register forms (which already existed) to my needs and add is_admin checkbox\r\n(2) Implement Middleware\r\n(3) Secure routes, nav and individual content with new Middleware', 'en', 1, '2025-01-02 07:08:54', '2025-01-02 07:08:54', '2025-01-02 07:08:54', 97),
(29, 'This project serves to explain the purpose of my Laravel application and is displayed as long as the user is not logged in. In the description, the user is informed what this project is about, what it can be used for and what steps have to be taken in order to view further content.', 'en', 1, '2025-01-02 10:16:00', '2025-01-02 10:16:00', '2025-01-02 10:16:00', 98),
(30, 'Detailed steps:\r\n(1) Go to XAMP-Link, download XAMPP for your system\r\n(2) Follow given instructions during install process\r\n(3) Manager-OSX is ready and opened in a small window:\r\n        - here you can start & stop MySQL and Apache\r\n(3) XAMP-Dashboard and phpMyAdmin are ready (see next entry)\r\n---\r\n(4) Additional on Mac: \r\n       - System Settings -> Privacy & Security -> select: Open anyway', 'en', 1, '2024-12-09 09:30:30', '2025-03-06 17:52:35', '2024-12-09 09:30:30', 37),
(32, '- to have an abstraction layer for future adaptions / customizations', 'en', 1, '2025-01-10 10:36:31', '2025-02-08 16:16:10', '2025-02-08 10:06:31', 130),
(33, '<strong>Queues & Jobs - Details:</strong>\r\n(1) php artisan make:notification NewTaskCreatedNotification\r\n(2) check files queue.php & .env:\r\n        - QUEUE_CONNECTION=database\r\n(3) php artisan queue:table (automatically creates queue tables)\r\n(4) php artisan migrate\r\n---\r\n(5) make:job NotifyClassCancelledJob\r\n(6) php artisan queue:work (start worker process)', 'en', 1, '2025-01-13 07:05:06', '2025-01-13 07:05:06', '2025-01-13 07:05:06', 87),
(34, 'use HasFactory;\r\nprotected $fillable = [\'title\', \'description\', \'is_featured\', \'locale\']; \r\nprotected $attributes = [\'is_featured\' => false];', 'en', 3, '2025-01-13 07:40:19', '2025-03-07 10:36:01', '2025-01-13 07:40:19', 11),
(35, 'attribute \'guarded\' is the opposite of \'fillable\'\r\n\r\nothers: visible, hidden, ..., relations, ..., observables, ... (see data structure with dd())', 'en', 1, '2025-01-13 07:44:40', '2025-01-13 08:43:03', '2025-01-13 07:44:40', 11),
(36, 'SoftDeletes:\r\n(1) migration: $table->SoftDeletes(); / $table->dropSoftDeletes();\r\n(2) model: use SoftDeletes();\r\n(3) new controller: TrashedNoteController\r\n(4) Queries:  withTrashed(), onlyTrashed()\r\n(5) Route: route(/trashed, \'index\')', 'en', 1, '2025-01-13 08:40:45', '2025-01-13 08:40:45', '2025-01-13 08:40:45', 12),
(37, 'Show navigation items for dynamic project details views only if projects is active navigation item.', 'en', 1, '2025-02-07 08:45:15', '2025-02-07 08:38:29', '2025-02-07 08:45:15', 151),
(38, 'For React-Frontend and Laravel-Backend different session cookies are used.\r\n\r\n<strong>Changes-List:</strong>\r\n(1) .env: <span class=\"pre-font\">\r\n     SESSION_COOKIE=pn_backend_session\r\n     SESSION_COOKIE_API=pn_frontend_session </span>\r\n\r\n(2) AppServiceProvider - function register() - as first entry: <span class=\"pre-font\">\r\n     $request = $this->app[\'request\'];\r\n     if ($request->is(\'api/*\') || $request->is(\'sanctum/*\')) {\r\n        Config::set(\'session.cookie\', env(\'SESSION_COOKIE_API\', \'pn_frontend_session\'));\r\n     } </span>\r\n\r\n(3) Replace all usages of session-cookie names with env-variables: login, register, logout', 'en', 1, '2025-02-06 16:08:16', '2025-02-06 16:51:34', '2025-02-06 16:08:16', 155),
(39, '(1) user-session:\r\n      - locale, projectId, projectTitle\r\n(2) cache:\r\n      - languages, teaserTask\r\n(3) user cookies: \r\n      - userLocale, userProjectId', 'en', 1, '2025-02-06 14:10:16', '2025-02-06 16:31:12', '2025-02-06 14:10:16', 155),
(40, 'LinkedIn-Video - Essentials Part I:\r\n(1) Str::uuid() -> creates uuid\r\n(2) model: public function getRouteKeyName () { return \'uuid\'; } ... (uuid anstatt id in URL)\r\n(3) store(): \r\n	  $note = Auth::user()->notes()->create([..., \'uuid\' => Str::uuid(), ...]);\r\n          OR\r\n	  $note = new Note([..., \'uuuid\' => Str::uuid(), ...]); $note->save();', 'en', 1, '2025-01-13 09:26:50', '2025-01-13 09:26:50', '2025-01-13 09:26:50', 157),
(41, '- profile: extended edit, update + destroy\r\n- guest: password vergessen, reset-password\r\n- auth: email-verification, password.confirm, password.update', 'en', 1, '2025-01-13 09:32:32', '2025-01-13 09:32:32', '2025-01-13 09:32:32', 159),
(42, '(1) php artisan make:command OrphanTranslations\r\n(2) lang/de/command.php + lang/en/command.php\r\n---\r\n(3) php artisan app:orphan-translations\r\n(4) php artisan app:orphan-translations --param=value\r\n--\r\n(5) php artisan make:notification OrphanTranslationsNotification\r\n---\r\n(6) routes/console.php: \r\nSchedule::command(OrphanTranslations::class)->everyFiveMinutes();\r\nSchedule::command(OrphanTranslations::class)->dailyAt(\'20:00\');\r\nSchedule::command(OrphanTranslations::class)->monthlyOn(1, \'08:00\');\r\n(7) php artisan schedule:list\r\n(8) php artisan schedule:work\r\n---\r\n(9) <a href=\"https://laravel.com/docs/11.x/scheduling#\" class=\"external-link\">Laravel 11: Scheduling</a>', 'en', 1, '2025-01-13 10:03:52', '2025-01-13 13:21:03', '2025-01-13 10:03:52', 164),
(43, 'Only as example (rule class not created).\r\n(1) php artisan make:rule EvenNumber\r\n...\r\n(2) $request->validate([\r\n    \'number\' => [\'required\', new EvenNumber],\r\n]);', 'en', 1, '2025-01-13 13:19:44', '2025-01-14 07:28:57', '2025-01-13 13:19:44', 165),
(44, '<strong>Located in model-classes:</strong>\r\n<pre>protected function casts(): array { return [ \'password\' => \'hashed\' ]  }</pre>', 'en', 1, '2025-01-13 13:48:59', '2025-01-13 13:51:09', '2025-01-13 13:48:59', 165),
(45, 'Needs some pre-installations for backend & frontend (not executed - only documentation read):\r\n<a href=\"https://laravel.com/docs/11.x/broadcasting\" class=\"external-link\">Laravel 11: Broadcasting</a>', 'en', 1, '2025-01-13 13:56:58', '2025-01-14 07:31:25', '2025-01-13 13:56:58', 165),
(46, '<a href=\"https://laravel.com/docs/11.x/concurrency\" class=\"external-link\">Laravel 11: Concurrent Tasks</a>', 'en', 3, '2025-01-13 14:17:25', '2025-01-13 14:17:25', '2025-01-13 14:17:25', 166),
(47, '<a href=\"https://github.com/canyongbs/advisingapp/tree/main/app/DataTransferObjects\" class=\"external-link\">Github-Example</a>\r\n<a href=\"https://www.youtube.com/watch?v=5qOwF-J5xxM\" class=\"external-link\">YouTube-Video</a>', 'en', 1, '2025-01-13 14:46:55', '2025-01-13 14:55:57', '2025-01-13 14:46:55', 168),
(48, '(1) php artisan make:class Services/ScopeService\r\n(2) php artisan make:class Services/TaskDetailTypeService\r\n(3) php artisan make:class Services/TaskService (uses ScopeService)\r\n---\r\n(4) integrate changes into TaskController (uses TaskService)\r\n---\r\n(5) php artisan make:class Services/TaskDetailService (uses ScopeService, TaskDetailTypeService)\r\n---\r\n(6) integrate changes inot TaskDetailController (uses TaskDetailService)', 'en', 1, '2025-01-14 06:24:00', '2025-01-14 06:56:01', '2025-01-14 06:24:00', 154),
(49, 'Decision: I have decided against the use of so-called repository classes and use service classes (per model). The respective service classes of the models include further service classes (of other models or functionalities).', 'en', 1, '2025-01-14 07:35:18', '2025-01-14 07:35:18', '2025-01-14 07:35:18', 154),
(50, 'Further optimizations should still be made for Controllers: e.g. outsourcing of extensive DB queries, etc.', 'en', 1, '2025-01-14 07:39:51', '2025-01-14 07:40:54', '2025-01-14 07:39:51', 154),
(51, '(1) export DB content\r\n(2) commit / push all changes\r\n---\r\n(3) cp .env .env.testing:\r\n     - APP_ENV=testing\r\n     - APP_URL=http://localhost:8001\r\n     - DB_DATABASE=projectnavigator_test\r\n(4) adapt phpunit.xml:\r\n     - APP_ENV=testing \r\n     - DB_CONNECTION=mysql\r\n     - DB_DATABASE -> projectnavigator_test\r\n(5) adapt package.json:\r\n     - add comma separated line under scripts: \r\n          - \"dev:testing\": \"vite --mode testing\" \r\n(6) adapt vite.config.js: add this lines \r\n<pre><code>\r\n     server: {\r\n         port: process.env.MODE === \'testing\' ? 5174 : 5173, \r\n     },\r\n</code></pre>\r\n---\r\n(7) php artisan config:clear\r\n(8) php artisan cache:clear\r\n---\r\n(9) npm run dev:testing\r\n(10) php artisan migrate --env=testing (you are asked to create DB, use projectnavigator_test)\r\n(11) php artisan serve --host=127.0.0.1 --port=8001 --env=testing\r\n--- \r\n(12) php artisan test (-> results in errors, because DB is empty!)\r\n---\r\n(13) prepare DatabaseSeeder class to seed new DB projectnavigator_test\r\n---\r\n(14) php artisan db:seed --env=testing\r\n---\r\n(15) re-test & work on test classes', 'en', 1, '2025-01-14 08:30:29', '2025-03-07 10:45:46', '2025-01-14 08:30:29', 169),
(52, 'php artisan stub:publish', 'en', 1, '2025-01-14 08:00:21', '2025-01-14 08:00:21', '2025-01-14 08:00:21', 170),
(53, 'Create new class ProjectSeeder & execute:\r\nphp artisan db:seed --env=testing --class=ProjectSeeder\r\n\r\nTest Invocation - Examples:\r\n(1) php artisan test (= all tests)\r\n(2) php artisan test --filter WelcomePageDisplayTest (only this test class)\r\n(3) php artisan test --filter test_welcome_page_with_empty_db_returns_an_error (only this test method)\r\n(4) php artisan test --testsuite=Feature --stop-on-failure (only feature tests & stop after first failure)\r\n\r\nFeature-Tests:\r\n(1) WelcomePageDisplayTest (php artisan test --filter WelcomePageDisplayTest)\r\n(2) ProfileTest, AuthenticationTest, RegistrationTest\r\n\r\nUnit-Tests:\r\n(1) ScopeServiceTest\r\n\r\ncomposer.json:\r\nadd under \"scripts\":\r\n        \"tests\": [\r\n            \"@php artisan test --testsuite=Unit\",\r\n            \"@php artisan test --testsuite=Feature\"\r\n        ]\r\ncomposer run tests\r\n\r\n<a href=\"https://docs.phpunit.de/en/11.5/configuration.html\" class=\"external-link\">PHPUnit - Dcoumentation</a>', 'en', 1, '2025-01-14 09:45:37', '2025-01-15 10:03:42', '2025-01-14 09:45:37', 171),
(54, '<strong>Install API-Package:</strong>\r\n(1) php artisan install:api (-> 1 migration has to be run)\r\n(2) add the [Laravel\\Sanctum\\HasApiTokens] trait to your User model\r\n(3) API route file has to be registered manually. Add API route definition file (routes/api.php) to bootstrap file (bootstrap/app.php): <pre>api: __DIR__ . \'/../routes/api.php\',</pre><strong>Work with API-Package:</strong>\r\n(1) Create first API test route in api.php: <pre>Route::get(\'test\', function () {<br> return \'My first API route :-)\';<br>});</pre>(2) VSCode: install extension \'thunder client\' and test out first route created before\r\n(3) <a href=\"https://jsonplaceholder.typicode.com/\" class=\"external-link\" target=\"_blank\">Dummy API for testting</a>\r\n(4) Adapt folder structure: Controllers/Api & Controllers/App, Requests/Api & Requests/App\r\n(5) composer dump-autoload, route:clear, ...\r\n(6) php artisan make:controller Api/V1/WelcomeController\r\n(7) php artisan make:controller Api/V1/ProjectController\r\n(8) php artisan make:service Api/V1/WelcomeService\r\n(9) php artisan make:request Api/V1/ProjectRequest\r\n(10) php artisan make:request Api/V1/Auth/LoginRequest\r\n(11) php artisan make:controller Api/V1/Auth/RegisteredUserController\r\n(12) php artisan make:controller Api/V1/Auth/AuthenticatedSessionController', 'en', 1, '2025-01-15 06:40:09', '2025-02-04 16:30:09', '2025-01-15 06:40:09', 172),
(55, '(1) composer require --dev laravel/dusk\r\n(2) php artisan dusk:install\r\n(3) php artisan dusk:make LoginTest\r\n(4) php artisan dusk:chrome-driver 131\r\n(5) ./vendor/laravel/dusk/bin/chromedriver-mac-intel (check port and adapt in dusk-test)\r\n(6) php artisan dusk\r\n---\r\n(7) Chrome updated to version 132.*\r\n(8) php artisan dusk:chrome-driver 132', 'en', 1, '2025-01-15 16:11:24', '2025-01-16 03:31:27', '2025-01-15 16:11:24', 173),
(56, 'Use following snippet in your api.php file: <pre>Route::prefix(\'v1\')->name(\'api.v1.\')->group(function () {...}</pre>', 'en', 1, '2025-01-16 06:40:57', '2025-01-16 06:40:57', '2025-01-16 06:40:57', 174),
(57, 'Install:\r\n(1) npm create vite@latest frontend -- --template react\r\n(2) cd frontend\r\n(3) npm install\r\n(4) npm install -D tailwindcss postcss autoprefixer\r\n(5) npx tailwindcss init -p\r\n(6) frontend/tailwind.config.js: content: [\".index.html\", \".src/**/*.{js,ts,jsx,tsx}\"],\r\n(7) frontend/src/index.css -> replace content with:\r\n		- @tailwind base;    \r\n		- @tailwind components;     \r\n		- @tailwind utilities;\r\n(8) frontend/package.json -> add port 3000:  \"dev\": \"vite --port=3000\",\r\n(9) npm run dev\r\n(10) <a href=\"http://localhost:3000\" class=\"external-link\" target=\"_blank\">Vite&React - Frontend</a> is running 🌟\r\n(11) npm install react-router-dom\r\n(12) use api route http://localhost:8000/api/v1/welcome to show WelcomePage-Content with React\r\n(13) start: form to create a project (gets unauthorized error - which is correct)', 'en', 1, '2025-01-16 08:17:18', '2025-01-16 11:21:23', '2025-01-16 08:17:18', 176),
(58, 'Install Inertia:\r\n(1) composer require inertiajs/inertia-laravel\r\n(2) composer require tightenco/ziggy\r\n--\r\n(3) npm install @inertiajs/react\r\n(4) npm install react@latest react-dom@latest\r\n(5) npm install @vitejs/plugin-react --save-dev\r\n--\r\n(6) web.php: Route::inertia(\'/about\', \'About\')->name(\'about\');\r\n(7) create new file resources/js/app.jsx\r\n(8) creates resources/js/Pages/About.jsx\r\n(9) adapt: config.vite.js\r\n(10) create new file: resources/js/views/app.blade.php (= Inertia rendering start point)\r\n---\r\n(11) http://localhost:8000/about (= is delivered correctly)', 'en', 1, '2025-01-16 11:52:16', '2025-01-17 13:12:54', '2025-01-16 11:52:16', 177),
(59, '(1) be sure all dependencies are up to date:\r\n     npm install\r\n(2) insert following code-lines into vite.config.js:\r\n     build: {\r\n         outDir: \'public/build\',\r\n         manifest: true,\r\n         chunkSizeWarningLimit: 500,\r\n    },\r\n(3) Laravel-Build:\r\n     npm run build -- --production\r\n(4) insert following code-lines into frontend/vite.config.js:\r\n      build:  {\r\n        outDir: \'public/frontend\', \r\n        manifest: true, \r\n        chunkSizeWarningLimit: 500, \r\n     },\r\n(5) React-Build:\r\n     cd frontend\r\n     npm install \r\n     npm run build -- --production', 'en', 1, '2025-01-18 07:09:03', '2025-02-08 02:56:13', '2025-01-18 07:09:03', 178),
(60, '(1) Configure Sanctum for API usage:\r\n      - config/sanctum.php: \'guard\' => [\'api\'],\r\n      - php artisan config:publish cors\r\n      - config/cors.php: \r\n           - \'paths\' => [\'api/*\', \'sanctum/csrf-cookie\'],\r\n           - \'allowed_origins\' => [\'http://localhost:3000\'],\r\n           - \'supports_credentials\' => false,  (= false, when tokens are used for auth)\r\n(2) Elaborate standard API Json response for ProjectNavigator:\r\n     - success: true/false\r\n     - message: null / string\r\n     - data: null / [...]\r\n     - errors: null / [...]', 'en', 1, '2025-01-20 07:31:52', '2025-01-20 07:59:17', '2025-01-20 07:31:52', 180),
(61, 'Changes-List:\r\n(1) TranslatableModel.php: \r\n      - change function getTranslatedField()\r\n(2) ProjectService.php:\r\n      - remove locale checks before invoking getTranslatedField()\r\n(3) for all index.blade.php files:\r\n      - remove locale checks before invoking getTranslatedField()\r\n      - remove PHP varibable isOriginalLocale', 'en', 1, '2025-02-03 10:05:37', '2025-02-03 10:06:21', '2025-02-03 10:05:37', 144),
(63, 'VSCode is not able to resolve \'auth()->check()\' but works fine with \'Auth::check()\' in some components (e.g., controllers, services, ...). But \'auth()->check()\' is working fine in middleware and blade-templates.\r\n\r\n(1) this is only an IDE issue, because VSCode is not able to resolve this dynamic construction correctly\r\n\r\n(2) this example code is accepted as correct code in IDE:\r\n\r\n/** @var \\Illuminate\\Contracts\\Auth\\Guard $guard */\r\n$guard = auth();\r\n$guard->check();\r\n\r\nAlternatives, which are working, too:\r\n- auth()->guard()->check();\r\n- auth(\'web\')->check();', 'en', 1, '2025-02-04 18:17:39', '2025-02-05 09:14:31', '2025-02-04 18:17:39', 142),
(64, 'New blade templates:\r\n(1) resources/views/components/welcome/welcome-column.blade.php\r\n(2) resources/views/components/welcome/scope-block.blade.php\r\n(3) resources/views/components/welcome/show-project-detail-link.blade.php\r\n\r\nChanged blade templates:\r\n(1) resources/views/welcome.blade.php', 'en', 1, '2025-02-05 14:01:20', '2025-02-05 14:01:20', '2025-02-05 14:01:20', 147),
(65, '<strong>Problem description:</strong>\r\nprops for blade-components can not be typed - e.g. a field label \'Scope\' is mis-interpreted as model (!)', 'en', 1, '2025-02-06 06:49:20', '2025-02-08 16:15:17', '2025-02-08 10:02:20', 181),
(66, '<strong> Changes-List:</strong>\r\n(1) php artisan make:migration add_default_project_id_to_users_table --table=users\r\n(2) Edit migration file:\r\n      <span class=\"pre-font\">Schema::table(\'users\', function (Blueprint $table) {\r\n          $table->foreignId(\'default_project_id\')\r\n                ->nullable()\r\n                ->constrained(\'projects\')\r\n                ->nullOnDelete();\r\n  });</span>\r\n\r\n     <span class=\"pre-font\">Schema::table(\'users\', function (Blueprint $table) {\r\n            $table->dropForeign([\'default_project_id\']);\r\n            $table->dropColumn(\'default_project_id\');\r\n  });</span>\r\n(3) Change Model User:\r\n    <span class=\"pre-font\">public function defaultProject(): \\Illuminate\\Database\\Eloquent\\Relations\\BelongsTo\r\n    {\r\n        Log::info(class_basename(self::class), [__FUNCTION__]);\r\n        return $this->belongsTo(Project::class, \'default_project_id\');\r\n    }</span>\r\n(4) Change Model Project:\r\n   <span class=\"pre-font\">public function users(): \\Illuminate\\Database\\Eloquent\\Relations\\HasMany\r\n    {\r\n        Log::info(class_basename(self::class), [__FUNCTION__]);\r\n        return $this->hasMany(User::class, \'default_project_id\');\r\n    }</span>\r\n(5) php artisan migrate\r\n---\r\n(6) adapt coding to use default_project_id:\r\n        - middleware: setGlobalData\r\n        - login\r\n        - switchProject', 'en', 1, '2025-02-06 10:04:49', '2025-02-06 09:41:23', '2025-02-06 10:04:49', 143),
(67, 'Adapt composer.json - autoload:\r\n<span class=\"pre-font\">\r\n    \"autoload\": {\r\n        \"psr-4\": {\r\n            \"App\\\\\": \"app/\",\r\n            \"Database\\\\Factories\\\\\": \"database/factories/\",\r\n            \"Database\\\\Seeders\\\\\": \"database/seeders/\"\r\n        },\r\n        \"files\": [\r\n            \"app/Helpers/apihelper.php\"\r\n        ]\r\n    }, </span>', 'en', 1, '2025-01-31 14:41:29', '2025-01-31 14:41:29', '2025-01-31 14:41:29', 184),
(68, '<strong>Changes-List:</strong>\r\n(1) Backend:\r\n        - Api/V1/Auth/AuthenticatedSessionController.php\r\n        - Api/V1/Auth/RegisteredUserController.php\r\n(2) Frontend: \r\n        - src/Context/AuthProvider.jsx\r\n        - src/Context/GlobalDataProvider.jsx', 'en', 1, '2025-02-07 06:44:27', '2025-02-07 06:44:27', '2025-02-07 06:44:27', 183),
(69, 'See documentation in Obsidian: Laravel-Page.', 'en', 2, '2025-02-07 09:01:02', '2025-02-07 09:01:02', '2025-02-07 09:01:02', 185),
(70, '<strong>Changes-List:</strong>\r\n(1) php artisan make:migration add_occurred_at_to_tasks_table --table=tasks\r\n(2) php artisan make:migration add_occurred_at_to_task_details_table --table=task_details\r\n---\r\n(3) edit both migration files\r\n(4) adapt models for task & task detail\r\n(5) adapt observers for task & task detail\r\n---\r\n(6) php artisan migrate\r\n---\r\n(7) create new form field input template for datetime-local (see attached code snippet)\r\n(8) adapt exiting blade-templates\r\n---\r\n(9) adapt controllers, request & service classes: \r\n       - sort tasks and task_details by occurred_at instead of created_at\r\n       - rules: <span class=\"pre-font\">\'occurred_at\' => \'nullable|date_format:Y-m-d\\TH:i:s\',</span>\r\n       - Controller - create/update: \r\n          <span class=\"pre-font\">\'occurred_at\' => \\Carbon\\Carbon::createFromFormat(\'Y-m-d\\TH:i:s\', \r\n          $validatedData[\'occurred_at\'])->format(\'Y-m-d H:i:s\')</span>', 'en', 1, '2025-02-07 14:26:49', '2025-02-07 15:14:11', '2025-02-07 14:26:41', 189),
(71, '@props([\'label\', \'placeholder\' => \'\', \'name\', \'value\' => \'\', \'required\' => false, \'disabled\' => false, \'autofocus\' => false, \'classname\' => \'create-field\'])\r\n\r\n<div class=\"{{ $classname }}\">\r\n    <label for=\"{{ $name }}\" class=\"{{ $classname }}-label\">{{ __($label) }}</label>\r\n    <input type=\"datetime-local\"\r\n        id=\"{{ $name }}\"\r\n        name=\"{{ $name }}\"\r\n        placeholder=\"{{ $placeholder }}\"\r\n        value=\"{{ old($name,  $value ? \\Carbon\\Carbon::parse($value)->format(\'Y-m-d\\TH:i:s\') : \'\') }}\"\r\n        class=\"{{ $classname }}-text\"\r\n        step=\"1\"\r\n        @required($required)\r\n        @disabled($disabled)\r\n        @if($autofocus) autofocus @endif>\r\n    @error($name)\r\n    <div class=\"error\">{{ $message }}</div>\r\n    @enderror\r\n</div>', 'en', 3, '2025-02-07 14:45:42', '2025-02-07 14:58:11', '2025-02-07 14:44:57', 189),
(73, 'Adapt: GlobalDataProvider.jsx, Navigation.jsx, Project/Details.jsx', 'en', 1, '2025-02-08 16:22:42', '2025-02-08 16:22:42', '2025-02-08 10:12:00', 194),
(74, '<strong>Explanation:</strong>\r\nStateless API requests don\'t use this kind of session variables, they provide params only!', 'en', 1, '2025-02-18 12:09:18', '2025-02-18 12:09:18', '2025-02-18 10:07:35', 200),
(75, '(1) Do not show scopes without tasks.\r\n(2) Tasks were missing their id to create uniquey keys for lists in React.', 'en', 1, '2025-02-20 10:56:44', '2025-02-20 10:56:44', '2025-02-20 10:55:50', 204),
(76, '(1) php artisan make:migration add_index_project_id_column_sortorder_to_scopes_table --table=scopes\r\n(2) php artisan make:migration add_indexes_to_tasks_table --table=tasks\r\n(3) php artisan make:migration add_indexes_to_task_details_table --table=task_details\r\n(4) php artisan make:migration add_indexes_to_translations_table --table=translations', 'en', 1, '2025-02-20 14:07:13', '2025-02-20 14:46:33', '2025-02-20 14:35:00', 208),
(77, '(1) npm install react-paginate', 'en', 1, '2025-02-20 17:59:03', '2025-02-20 18:00:01', '2025-02-20 19:20:39', 205),
(78, '<strong>Special problem</strong> for FE was, that variable \'view\' is part of URL and changes immediately. But data structure for project details is part of a useEffect and changes later (React re-render cycle takes place before executing useEffect). Therefore the new \'view\' is rendered with the existing data from the view selected before!\r\n\r\n<strong>Solution:</strong> Do not use \'view\' for render-cycle, but create a state variable changed synchronously with reading new data from backend (i.e., view and data are changed always synchronously)!', 'en', 1, '2025-03-06 10:01:40', '2025-03-06 10:01:40', '2025-02-20 13:03:55', 206),
(79, 'To avoid multiple axios calls when navigating through project details and different project views, some changes to the corresponding useEffect have been added:\r\n\r\n(1) check if relevant params for axios call have really changed \r\n(2) when switching to another view, currentPage and scopeId have to be reset\r\n\r\nThis is not a very elegant solution, and I am still looking for a better, more general alternative that would also be suitable for more complex situations.', 'en', 1, '2025-03-06 10:42:26', '2025-03-06 11:05:31', '2025-03-05 15:50:10', 212),
(80, '...                 \r\nconst { projectId, view } = useParams(); \r\nconst [scopeId, setScopeId] = useState(0);\r\nconst [currentPage, setCurrentPage] = useState(1);\r\nconst lastPageRef = useRef(1);\r\nconst viewOldRef = useRef(view);\r\nconst scopeIdOldRef = useRef(0);\r\nconst currentPageOldRef = useRef(1);\r\nconst loadingRef = useRef(true);\r\nconst firstRenderRef = useRef(true);\r\n...\r\nuseEffect(() => {\r\n    const fetchData = async () => {\r\n        let pageToGet = currentPage;\r\n        let scopeIdToGet = scopeId;\r\n\r\n        if (view !== viewOldRef.current) {\r\n            pageToGet = 1;\r\n            scopeIdToGet = 0;\r\n        }\r\n\r\n        loadingRef.current = true;\r\n\r\n        try {\r\n            const response = await axios.get(`${config.API_URL}/projects/${projectId}/${view}?page=${pageToGet}&scopeId=${scopeIdToGet}`);\r\n            setProjectData(response.data.data); \r\n            ...\r\n            viewOldRef.current = view;\r\n            setScopeId(scopeIdToGet);\r\n            scopeIdOldRef.current = scopeIdToGet;\r\n            setCurrentPage(pageToGet);\r\n            currentPageOldRef.current = pageToGet;\r\n            lastPageRef.current = response.data.data?.scopes?.last_page;\r\n        } catch (error) {\r\n            ...\r\n        } finally {\r\n            loadingRef.current = false; \r\n        }\r\n    };\r\n    ...\r\n    if ((view !== viewOldRef.current) || (currentPage !== currentPageOldRef.current) || (scopeId !== scopeIdOldRef.current) || (firstRenderRef.current === true)) {\r\n        firstRenderRef.current = false;\r\n        fetchData(); \r\n    }\r\n}, [projectId, view, currentPage, scopeId]);', 'en', 3, '2025-03-06 10:50:42', '2025-03-06 11:08:17', '2025-03-05 16:15:00', 212),
(81, 'Prerequisites:\r\n(1) VSCode is installed\r\n(2) Git is installed\r\n(3) A Github account is available\r\n\r\nConfigure & synchronize:\r\n(1) Github: create a new repository \'ProjectNavigator\'\r\n(2) Open ProjectNavigator in VSCode and switch to a terminal with cmd+j:\r\n     - git init\r\n     - git add .\r\n     - git commit -m “Initial commit”\r\n(3) Github: copy the URL of the repository (e.g. https://github.com/username/ProjectNavigator.git)\r\n(4) VSCode terminal:\r\n     - git remote add origin https://github.com/username/ProjectNavigator.git\r\n     - git push -u origin master', 'en', 1, '2025-03-06 18:04:20', '2025-03-06 18:35:51', '2024-12-09 11:16:55', 114),
(82, '⚠️  <strong>Important</strong>:\r\nThe command \'composer run dev\' executes the commands defined in the file composer.json under scripts in the \"dev\"-section. In my installation, the following is defined there: \r\n<pre><code> \r\n   “dev\": [\r\n        “Composer\\\\Config::disableProcessTimeout”,\r\n        “npx concurrently -c \\\"#93c5fd,#c4b5fd,#fb7185,#fdba74\\” \\\"php artisan serve\\” \\\"php artisan queue:listen --tries=1\\” \r\n                             \\\"php artisan pail --timeout=0\\” \\“npm run dev\\” --names=server,queue,logs,vite”\r\n   ],\r\n</code></pre>\r\nThis means, that the command is starting following components:\r\n(1) php artisan serve → starts Laravel Backend on port 8000\r\n(2) php artisan queue:listen --tries=1 → is listening Laravel-Queues\r\n(3) php artisan pail --timeout=0 → starts Laravel Pail for logging\r\n(4) npm run dev → starts Vite (= \'Laravel Frontend\') on port 5173\r\n\r\nAlternatively you can start only (1) and (4) by yourself in a terminal (e.g., in VSCode).\r\n👉 For the rest of this project I will do it that way.', 'en', 1, '2025-03-07 07:22:05', '2025-03-07 08:22:35', '2024-12-09 10:05:49', 41),
(83, '(1) php artisan make:migration create_tasks_table --create=tasks\r\n(2) edit migration file and add table columns\r\n(3) php artisan migrate\r\n---\r\n(4) php artisan make:model Task\r\n(5) edit model file and add/adapt it to your needs\r\n---\r\n(6) php artisan make:factory TaskFactory --model=Task\r\n(7) edit factory file and addd/adapt it to your needs\r\n\r\n⚠️ Note:\r\nArtisan commands can have various parameters, e.g., with\r\nphp artisan make:model Task -m\r\nyou can create a migration and model in one step.\r\n\r\n👉 Use following commands for more details:\r\n- php artisan list\r\n- php artisan help &lt;command&gt;', 'en', 1, '2025-03-07 09:55:36', '2025-03-07 09:58:56', '2024-12-09 13:16:06', 116),
(84, '(1) php artisan make:controller TaskController\r\n(2) edit and adapt controller file to your needs\r\n---\r\n(2) define a route in file routes/web.php and link the route to a function of TaskController\r\n---\r\n(3) define a view to be used in the route\'s function in TaskController: e.g., you can adapt the file resources/views/welcome.blade.php to your needs and use it in TaskController \r\n---\r\n(4) test it out :-)\r\n\r\n👉 Find out for yourself what each of these command alternatives will do:\r\n- php artisan make:controller TaskController --model=Task\r\n- php artisan make:controller TaskController --resource\r\n- php artisan make:controller TaskController --invokable\r\n- php artisan make:controller TaskController --api\r\n- php artisan make:controller TaskController --force', 'en', 1, '2025-03-07 10:20:17', '2025-03-07 10:31:47', '2024-12-09 14:05:20', 117);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `task_detail_types`
--

DROP TABLE IF EXISTS `task_detail_types`;
CREATE TABLE IF NOT EXISTS `task_detail_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `task_detail_types_title_unique` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `task_detail_types`:
--

--
-- Daten für Tabelle `task_detail_types`
--

INSERT IGNORE INTO `task_detail_types` (`id`, `title`, `label`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'note', 'Note', 'en', '2024-12-12 16:20:19', '2024-12-12 16:20:19'),
(2, 'command', 'Command', 'en', '2024-12-12 16:20:19', '2024-12-12 16:20:19'),
(3, 'code', 'Code', 'en', '2024-12-12 16:20:19', '2024-12-12 16:20:19');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
CREATE TABLE IF NOT EXISTS `telescope_entries` (
  `sequence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_family_hash_index` (`family_hash`),
  KEY `telescope_entries_created_at_index` (`created_at`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `telescope_entries`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
CREATE TABLE IF NOT EXISTS `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `telescope_entries_tags`:
--   `entry_uuid`
--       `telescope_entries` -> `uuid`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
CREATE TABLE IF NOT EXISTS `telescope_monitoring` (
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `telescope_monitoring`:
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `record_id` bigint(20) UNSIGNED NOT NULL,
  `locale` char(2) NOT NULL DEFAULT 'en',
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `translations_table_name_record_id_field_name_locale_unique` (`table_name`,`record_id`,`field_name`,`locale`) USING BTREE,
  KEY `translations_table_name_record_id_index` (`table_name`,`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `translations`:
--

--
-- Daten für Tabelle `translations`
--

INSERT IGNORE INTO `translations` (`id`, `table_name`, `field_name`, `record_id`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'projects', 'title', 1, 'de', 'Laravel (de)', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(3, 'projects', 'description', 1, 'de', '<strong>Mein erstes Laravel-Projekt – Ein Einstieg in die Welt moderner Backend - Webentwicklung</strong>\r\n\r\nIn meinem ersten Laravel-Projekt tauche ich in die Möglichkeiten und Konzepte des populären PHP-Frameworks ein. Ziel dieses Projekts ist es, die grundlegenden Funktionalitäten von Laravel zu erkunden und anzuwenden – von Routing, Middleware und Services über Eloquent ORM und Blade-Templates bis zu fortgeschrittenen Features wie Jobs, Events, Unterstützung mehrer Sprachen und RESTful API. Dabei geht es nicht nur darum, eine funktionierende Anwendung zu erstellen, sondern auch die Design-Entscheidungen zu verstehen und bewusst zu treffen.\r\n\r\nDas Projekt dient mir als persönlicher Leitfaden, um die Prinzipien und Best Practices von Laravel kennenzulernen und umzusetzen. Ich dokumentiere meine Schritts, erläutere die Architektur und zentrale Entscheidungen. Ergänzend füge ich an manchen Stellen kleine  Code-Schnipsel, relevante Befehle oder weiterführende Details und Links zur offiziellen Dokumentation hinzu. \r\n\r\nAm Ende steht nicht nur eine benutzbare Anwendung, sondern auch eine fundierte Grundlage für zukünftige Projekte. Dieses Vorhaben ist der Beginn meiner Reise, mit Laravel als Werkzeug komplexe und performante Backend-Anwendungen zu realisieren.', '2024-12-13 07:05:41', '2025-02-08 14:07:20'),
(5, 'activity_types', 'label', 6, 'de', 'Create', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(6, 'activity_types', 'label', 7, 'de', 'Delete', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(7, 'activity_types', 'label', 8, 'de', 'Update', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(8, 'activity_types', 'label', 9, 'de', 'Query', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(9, 'scopes', 'label', 36, 'de', 'Installieren', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(10, 'scopes', 'label', 37, 'de', 'Konfigurieren', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(11, 'scopes', 'label', 38, 'de', 'Organisieren', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(12, 'scopes', 'label', 39, 'de', 'Diverses', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(13, 'scopes', 'label', 40, 'de', 'ToDo', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(14, 'scopes', 'label', 41, 'de', 'Vielleicht', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(15, 'scopes', 'label', 42, 'de', 'Letzte Aktivitäten', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(16, 'task_detail_types', 'label', 1, 'de', 'Notiz', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(17, 'task_detail_types', 'label', 2, 'de', 'Befehl', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(18, 'task_detail_types', 'label', 3, 'de', 'Coding', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(21, 'task_details', 'description', 9, 'de', '<pre>if ($a == $b) {\r\n   $c = true;\r\n}</pre>', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(22, 'tasks', 'title', 6, 'de', 'Debugbar: composer require barryvdh/laravel-debugbar --dev', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(23, 'tasks', 'title', 7, 'de', 'Config XDebug für VSCode & Laravel', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(24, 'tasks', 'title', 8, 'de', 'Config Apache um ProjectNavigator darüber auszuliefern', '2024-12-13 07:05:41', '2025-01-18 12:08:00'),
(25, 'tasks', 'title', 9, 'de', 'Meeting Raik: Code-Review & Planung letzte 2 Wochen', '2024-12-13 07:05:41', '2025-01-10 11:03:10'),
(26, 'tasks', 'title', 10, 'de', '<a href=\"https://www.youtube.com/watch?v=wVCEpbLIyLU&list=PL8p2I9GklV46KYQnt-xJB9dhyG-e-zHnI&index=3\"  class=\"external-link\">YouTube: Laravel Video-Playlist</a>', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(27, 'tasks', 'title', 11, 'de', 'DB-Modell fertigstellen (tables/migrations/models/factories/seeders)', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(28, 'tasks', 'title', 12, 'de', 'Soft Delete (trash) implementieren', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(29, 'tasks', 'title', 13, 'de', 'Layout: Safari - Korrektur Header', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(30, 'tasks', 'title', 14, 'de', 'Header: Datum sprachabhängig anzeigen', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(31, 'tasks', 'title', 15, 'de', 'LanguageSwitcher: Problem mit Session-Variablen gelöst', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(32, 'tasks', 'title', 16, 'de', 'Footer: Texte übersetzen und sprachabhängig ausgeben', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(35, 'tasks', 'title', 19, 'de', 'Page-Leaves: check for pending changes (ask to proceed or not)', '2024-12-13 07:05:41', '2025-03-06 09:58:30'),
(42, 'tasks', 'title', 26, 'de', 'register LanguageService OR not - pro vs. cons?', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(43, 'tasks', 'title', 27, 'de', 'Hamburger Menü: Home + wichtigste Einstiegspunkte', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(44, 'tasks', 'title', 28, 'de', 'Breadcrumb: Home > Abc > Aktuelle Seite', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(46, 'tasks', 'title', 30, 'de', 'split up layout new (inc. welcome-page) ', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(47, 'tasks', 'title', 31, 'de', 'Footer: Project - Switcher ', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(48, 'tasks', 'title', 32, 'de', 'Angepasst: WelcomeController, welcome.blade.php', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(51, 'tasks', 'title', 34, 'de', 'Neue Klasse TranslationHelper & Model Funktion translatableFields()', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(52, 'tasks', 'title', 36, 'de', '<a href=\"https://www.linkedin.com/learning/laravel-essential-training/understand-laravel-configuration?autoSkip=true&resume=false&u=0\" class=\"external-link\">LinkedIn: Laravel Essential Training (Part I)</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(53, 'tasks', 'title', 37, 'de', 'XAMPP installieren: <a href=\"https://www.apachefriends.org/de/index.html\" class=\"external-link\">XAMPP - Download</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(54, 'tasks', 'title', 38, 'de', 'Vorbereitungen: System aufräumen und aktualisieren x', '2024-12-26 06:00:00', '2025-01-05 14:20:57'),
(55, 'tasks', 'description', 38, 'de', 'Detaillierte Schritte: System aufräumen (alte MySQl- und PHP-Versionen und Webserver deinstallieren), Homebrew und Node auf die neuesten Versionen aktualisieren, PHP 8.4 installieren (global verfügbar)', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(56, 'tasks', 'description', 37, 'de', 'Systemeinstellungen: (1) Datenschutz & Sicherheit -> trotzdem öffnen (2) Manager-OSX: -> start / stop (MySQL, Apache) (3) Dashboard: http://nephele.fritz.box/dashboard/howto.html', '2024-12-26 06:00:00', '2025-01-05 06:14:22'),
(57, 'tasks', 'title', 39, 'de', 'PHP Composer installieren', '2024-12-26 06:00:00', '2025-03-06 17:14:33'),
(58, 'tasks', 'description', 39, 'de', '(1)  brew install composer\r\n(2)  set composer PATH variable:\r\n       ~/.zshrc -> edit \r\n       folgende Zeile am Ende der Datei hinzufügen:\r\n       export PATH=\"$HOME/.composer/vendor/bin:$PATH\"\r\n       source ~/.zshrc', '2024-12-26 06:00:00', '2025-03-06 17:15:02'),
(59, 'tasks', 'title', 40, 'de', 'Laravel-Installer installieren', '2024-12-26 06:00:00', '2025-03-06 17:24:04'),
(60, 'tasks', 'title', 41, 'de', 'Erstes Laravel Projekt \'ProjectNavigator\' erstellt: <a  href=\"http://localhost:8000/\" class=\"external-link\" target=\"_blank\">ProjectNavigator</a>', '2024-12-26 06:00:00', '2025-02-03 09:54:19'),
(61, 'tasks', 'description', 41, 'de', 'Wechsel in das Verzeichnis, in welchem das neue Laravel Projekt erstellt werden soll:\r\n(1) laravel new ProjectNavigator\r\n(2) select: Breeze, Blade with Alpine, PHPUnit, MySQL, default migrations & as db: projectnavigator\r\n(3) cd ProjectNavigator \r\n(4) npm install && npm run build \r\n(5) composer run dev', '2024-12-26 06:00:00', '2025-03-06 17:34:35'),
(62, 'tasks', 'title', 42, 'de', 'XAMPP-Dashboard: <a href=\"http://nephele.fritz.box/dashboard/howto.html\" class=\"external-link\" target=\"_blank\">XAMPP howto guides</a>, <a href=\"http://nephele.fritz.box/phpmyadmin/index.php\" class=\"external-link\" target=\"_blank\">phpMyAdmin</a>', '2024-12-26 06:00:00', '2025-02-03 09:56:26'),
(63, 'tasks', 'title', 43, 'de', '<a href=\"https://www.youtube.com/watch?v=rQvDX4gld1I\" class=\"external-link\">YouTube: Laravel - Caching</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(64, 'tasks', 'title', 44, 'de', '<a href=\"https://laravel.com/docs/11.x/views#view-composers\" class=\"external-link\">Laravel - Dokumentation: How to  build View Composers</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(66, 'scopes', 'label', 45, 'de', 'Was zu beachten ist', '2024-12-13 07:05:41', '2024-12-13 07:05:41'),
(67, 'tasks', 'title', 45, 'de', 'Sprachen: \'locale\' ist mit CHAR(2) definiert', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(69, 'tasks', 'title', 46, 'de', '<a href=\"https://github.com/LinkedInLearning/laravel-essential-training-2710093\" class=\"external-link\">Github: Laravel Essential Training (Part I) - Beispiele</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(70, 'tasks', 'title', 47, 'de', '<a href=\"https://symmetrical-space-carnival-7456pg4wxwqcx494.github.dev/\" class=\"external-link\">Github: Laravel Essential Training (Part I) - Codespace</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(71, 'tasks', 'title', 48, 'de', '<a href=\"https://www.linkedin.com/learning/advanced-laravel-22373805/beyond-the-basics?u=0\" class=\"external-link\">LinkedIn: Laravel Essential Training (Part II)</a>', '2024-12-26 06:00:00', '2024-12-26 06:00:00'),
(72, 'projects', 'title', 10, 'de', 'ProjektNavigator (de)', '2025-01-02 07:05:41', '2025-01-02 07:05:41'),
(73, 'projects', 'description', 10, 'de', '<strong>Über das Projekt</strong>\r\n\r\nWollten Sie schon immer eine effektive Möglichkeit haben, Ihre Projekte zu dokumentieren? Mit dem ProjectNavigator können Sie die Umsetzung Ihre eigenen Projekte systematisch aufzeichnen, um sie später nachvollziehbar zu machen oder sie als Einführung in neue Themen mit anderen zu teilen.\r\n\r\nProjectNavigator bietet nicht nur Schritt-für-Schritt-Anleitungen, sondern auch Hintergrundwissen, Tipps und Tricks, die für eine umfassende Dokumentation unerlässlich sind. Das Ziel ist es, Ihr Projektwissen zu bewahren und andere dabei zu unterstützen, Ihre Arbeit zu verstehen und fortzuführen.', '2025-01-02 07:05:41', '2025-01-17 06:34:27'),
(74, 'scopes', 'label', 49, 'de', 'Warum ProjektNavigator?', '2025-01-02 07:05:41', '2025-01-02 07:05:41'),
(75, 'scopes', 'label', 50, 'de', 'Was erwartet Dich?', '2025-01-02 07:05:41', '2025-01-02 07:05:41'),
(76, 'scopes', 'label', 51, 'de', 'Wie funktioniert es?', '2025-01-02 07:05:43', '2025-01-02 07:05:43'),
(77, 'scopes', 'label', 52, 'de', 'Noch kein Mitglied?', '2025-01-02 07:05:45', '2025-01-02 07:05:45'),
(78, 'scopes', 'label', 53, 'de', 'Dein nächster Schritt', '2025-01-02 07:05:47', '2025-01-02 07:05:47'),
(79, 'scopes', 'label', 54, 'de', 'Melde Dich jetzt an und leg los!', '2025-01-02 07:05:49', '2025-01-02 07:05:49'),
(80, 'tasks', 'title', 51, 'de', 'Dokumentationen sind praxisorientiert und basieren auf bewährten Methoden.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(81, 'tasks', 'title', 52, 'de', 'Klar und verständlich gegliedert, sodass du jeden Schritt nachvollziehen kannst.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(82, 'tasks', 'title', 53, 'de', 'Ideal für Anfänger, die Projekte eigenständig umsetzen wollen.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(83, 'tasks', 'title', 54, 'de', 'Erfahre, wie Projekte entstehen und welche Herausforderungen gemeistert werden.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(84, 'tasks', 'title', 55, 'de', 'Von der Planung bis zur Umsetzung – keine Frage bleibt unbeantwortet.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(85, 'tasks', 'title', 56, 'de', 'Erhalte wertvolle Insights zu Tools, Technologien und Best Practices.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(86, 'tasks', 'title', 57, 'de', 'Melde dich an, um vollen Zugriff auf die Inhalte zu erhalten.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(87, 'tasks', 'title', 58, 'de', 'Wähle ein Projekt aus, das dich interessiert, und tauche in die Details ein.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(88, 'tasks', 'title', 59, 'de', 'Folge der Anleitung und setze die Schritte in deinem eigenen Tempo um.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(89, 'tasks', 'title', 60, 'de', 'Um die Projekt-Details einsehen zu können, musst du dich registrieren und einloggen.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(90, 'tasks', 'title', 61, 'de', 'Bis dahin bekommst du hier einen kleinen Einblick, was dich erwartet:', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(91, 'tasks', 'description', 61, 'de', '„Stell dir vor, du kannst Projekte wie ein Profi aufbauen – ohne Umwege, mit klaren Anleitungen und inspirierenden Ideen. Mach mit und staune über deine Erfolge!“', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(92, 'tasks', 'title', 64, 'de', 'Viel Erfolg & viel Spaß!', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(93, 'tasks', 'title', 62, 'de', 'Noch unsicher? Sieh dir die <a href=\"#\" class=\"external-link\">Vorschau</a> an und entdecke die Möglichkeiten.', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(94, 'tasks', 'title', 63, 'de', 'Neugierig geworden? Registriere dich jetzt und starte dein erstes Projekt!', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(95, 'tasks', 'title', 65, 'de', '<strong>Dein Zugang zu strukturiertem Wissen und inspirierenden Projekten wartet.</strong>', '2025-01-02 07:55:00', '2025-01-02 07:55:00'),
(98, 'task_details', 'description', 24, 'de', '<pre>composer require laravel/telescope<br/>php artisan telescope:install<br/>php artisan migrate<br/>http://localhost:8000/telescope</pre>', '2025-01-10 10:50:23', '2025-01-11 06:30:02'),
(99, 'task_details', 'description', 30, 'de', '<strong>Detaillierte Schritte:</strong>\r\n(1) Gehe zu XAMP-Link, lade XAMPP für dein System herunter.\r\n(2) Folge den Anweisungen während des Installationsprozesses\r\n(3) Manager-OSX ist fertig und wird in einem Fenster angezeigt:\r\n       - hier kann man MySQL und Apache starten / stoppen\r\n(3) XAMP-Dashboard und phpMyAdmin sind bereit (siehe nächster Eintrag)\r\n---\r\n(4) Zusätzlich auf Mac: \r\n       - Systemeinstellungen -> Datenschutz & Sicherheit -> auswählen: Trotzdem öffnen', '2025-01-10 10:51:06', '2025-03-06 17:05:39'),
(100, 'task_details', 'description', 25, 'de', 'Dieses Verzeichnis wird verwendet, um regelmäßige Backups aller Datenbankinhalte, die für den Betrieb der Website benötigt werden, in den Versionierungsprozess einzubinden. Dabei handelt es sich entweder um Konfigurationsdaten oder bereits aktive Daten, die nicht verloren gehen dürfen.', '2025-01-10 10:51:43', '2025-01-10 10:51:43'),
(101, 'task_details', 'description', 22, 'de', 'Das Ausführen der Standardtests, die bei der Erstellung des Basisprojekts mitgeliefert werden, hat meinen DB-Inhalt gelöscht!\r\nWährend ich mir mein Lernvideo anschaute, probierte ich diese Tests aus, ohne mir über die Konsequenzen im Klaren zu sein, und ich machte einen Tag lang keine DB-Sicherung!', '2025-01-10 10:52:16', '2025-01-10 10:52:16'),
(102, 'task_details', 'description', 23, 'de', 'Korrektur in der Middleware SetGlobalData vorgenommen.', '2025-01-10 10:52:45', '2025-01-10 10:52:45'),
(103, 'task_details', 'description', 27, 'de', 'Um zu vermeiden, dass die Hilfsklasse TranslationHelper in jeden Controller, Service oder andere Klassen importiert werden muss und um sicherzustellen, dass die IDE bereits erkennt, wenn ein Modell keine Übersetzungsfunktionalität bietet, habe ich mich entschieden, Modelle mit Übersetzungsfähigkeiten über einen Trait bereitzustellen.', '2025-01-10 10:53:11', '2025-01-10 10:53:11'),
(104, 'task_details', 'description', 26, 'de', 'Um zu vermeiden, dass in jeder Modellklasse eine Boot-Funktion implementiert werden muss (so war es bisher gelöst), habe ich mich entschieden, Beobachterklassen zu implementieren, die die Ereignisse „Erstellen“, „Aktualisieren“ und „Löschen“ überwachen. Dadurch werden die Aufgaben an der richtigen Stelle verteilt, wie es das Design von Laravel vorsieht.', '2025-01-10 10:53:48', '2025-01-10 10:53:48'),
(105, 'task_details', 'description', 29, 'de', 'Dieses Projekt dient dazu, den Zweck meiner Laravel-Anwendung zu erklären und wird angezeigt, solange der Benutzer nicht eingeloggt ist. In der Beschreibung wird der Benutzer darüber informiert, worum es sich bei diesem Projekt handelt, wofür es verwendet werden kann und welche Schritte unternommen werden müssen, um weitere Inhalte anzuzeigen.', '2025-01-10 10:54:27', '2025-01-10 10:54:27'),
(106, 'task_details', 'description', 28, 'de', '(1) Anmelde- und Registrierungs-Formular (die bereits existierten) an meine Bedürfnisse anpassen und is_admin-Kontrollkästchen hinzufügen\r\n(2) Middleware implementieren\r\n(3) Routen, Navigation und individuelle Inhalte mit neuer Middleware absichern', '2025-01-10 10:55:15', '2025-01-10 10:55:15'),
(107, 'task_details', 'description', 32, 'de', '- um eine Abstraktionsschicht für künftige Anpassungen zu haben', '2025-01-10 10:56:24', '2025-01-10 10:56:24'),
(108, 'tasks', 'title', 78, 'de', '<a href=\"https://www.linkedin.com/learning/laravel-grundkurs-2-rest-apis-und-formulare/\" class=\"external-link\">LinkedIn: Laravel-Bascis (Part II)</a>', '2025-01-10 10:59:57', '2025-01-10 10:59:57'),
(109, 'tasks', 'title', 77, 'de', '<a href=\"https://www.linkedin.com/learning/laravel-grundkurs-1-installation-datenbankkonfiguration-und-grundlegende-features/\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel-Basics (Part I)</a>', '2025-01-10 11:00:23', '2025-03-06 15:59:06'),
(110, 'tasks', 'title', 89, 'de', 'Install Telescope', '2025-01-10 11:01:55', '2025-01-10 11:01:55'),
(111, 'tasks', 'title', 130, 'de', 'Neue Klasse LoggingServie (eventuell mit AOP)', '2025-01-10 11:04:16', '2025-02-04 18:45:10'),
(112, 'tasks', 'title', 115, 'de', 'ProjectNavigator: Projektstruktur in VSCode ansehen und verstehen', '2025-01-10 11:09:59', '2025-03-06 18:34:39'),
(113, 'tasks', 'title', 116, 'de', 'Eine erste Tabelle, ein Model und Factory erstellen', '2025-01-10 11:10:33', '2025-01-10 11:10:33'),
(114, 'tasks', 'title', 140, 'de', 'Anpassung der Routen an RESTful routes, erstes Beispiel = Project, Anpassung Breadcrumb (mit id)', '2025-01-10 11:11:56', '2025-01-10 11:11:56'),
(115, 'tasks', 'title', 114, 'de', 'ProjectNavigator-Projekt: Versionierung aktivieren und Synchronistation mit Github konfigurieren', '2025-01-10 11:12:50', '2025-03-06 17:35:42'),
(116, 'tasks', 'title', 126, 'de', 'Footer: sprachabhängige Ausgabe, Header: sprachabhängiges Datumsformat, Anpassung LanguageSwitcher', '2025-01-10 11:13:59', '2025-01-10 11:13:59'),
(117, 'tasks', 'title', 124, 'de', 'Neu: LanguageSwitcher mit Route und Session-Handling', '2025-01-10 11:14:36', '2025-01-10 11:14:36'),
(118, 'tasks', 'title', 106, 'de', 'Neue View-Komponente: projects.show-task-sorted', '2025-01-10 11:15:08', '2025-01-10 11:15:08'),
(119, 'tasks', 'title', 98, 'de', 'Neu: ProjectNavigator Projekt und Befüllung mit Inhalt (Datenerfassung)', '2025-01-10 11:15:57', '2025-01-10 11:15:57'),
(120, 'tasks', 'title', 91, 'de', 'Fortsetzung: Laravel-Projekt dokumentieren', '2025-01-10 11:16:30', '2025-01-10 11:16:30'),
(121, 'tasks', 'title', 49, 'de', 'Beginn: Laravel-Projekt dokumentieren', '2025-01-10 11:17:01', '2025-01-10 11:17:01'),
(122, 'tasks', 'title', 79, 'de', 'NEU-Beginn: Dokumentation Laravel-Projekt', '2025-01-10 11:17:32', '2025-01-10 11:17:32'),
(123, 'tasks', 'title', 85, 'de', 'New: Events & Listeners', '2025-01-10 11:18:35', '2025-01-10 11:18:35'),
(124, 'tasks', 'description', 85, 'de', '(1) php artisan make:event TranslationMissing\r\n(2) php artisan make:listener NotifyTranslationMissing --event=TranslationMissing\r\n(3) TranslationMissing::dispatch($user, $project);\r\n---\r\n(4) EventServiceProvider -> bootstrap/providers.php', '2025-01-10 11:18:35', '2025-01-13 06:14:07'),
(125, 'tasks', 'title', 90, 'de', 'Neues Projekt-Verzeichnis: db_export', '2025-01-10 11:19:04', '2025-01-10 11:19:04'),
(126, 'tasks', 'title', 82, 'de', 'Gate: umbenannt in \'administrate\' & für Projekte und Übersetzungen angepasst', '2025-01-10 11:20:19', '2025-01-10 11:20:19'),
(127, 'tasks', 'title', 88, 'de', 'Abbruch mit einem Fehler, falls kein Projekt für die Startseite konfiguriert ist.', '2025-01-10 11:20:55', '2025-01-10 11:20:55'),
(128, 'tasks', 'title', 87, 'de', 'Neu: NewTaskCreatedNotification, NewTaskCreatedJob', '2025-01-10 11:21:39', '2025-01-10 11:21:39'),
(129, 'tasks', 'title', 86, 'de', 'Neu: TranslationMissingMail, emails.translation-missing.blade.php', '2025-01-10 11:22:25', '2025-01-10 11:22:25'),
(130, 'tasks', 'title', 84, 'de', 'Neu: ProjectPolicy', '2025-01-10 11:22:40', '2025-01-10 11:22:40'),
(131, 'tasks', 'title', 83, 'de', 'Cookie-Verwendung für die Default-Sprache des angemeldeten Benutzers (userLocale)', '2025-01-10 11:23:57', '2025-01-10 11:23:57'),
(132, 'tasks', 'title', 81, 'de', 'Neu: AuthServiceProvider & Gate isAdminUser', '2025-01-10 11:24:21', '2025-01-10 11:24:21'),
(133, 'tasks', 'title', 80, 'de', 'Code CleanUp: neue Komponente für created-updated, Vereinheitlichungen, Kommenatre, ...', '2025-01-10 11:25:19', '2025-01-10 11:25:19'),
(134, 'tasks', 'title', 96, 'de', 'Check Query-Ausführungen, Logging und Seiten-Ladeprozess', '2025-01-10 11:25:55', '2025-01-10 11:25:55'),
(135, 'tasks', 'title', 95, 'de', 'Überarbeitung: TranslationHelper', '2025-01-10 11:26:15', '2025-01-10 11:26:15'),
(136, 'tasks', 'title', 94, 'de', 'Neu: Trait TranslatableMethods', '2025-01-10 11:26:38', '2025-01-10 11:26:38'),
(137, 'tasks', 'title', 93, 'de', 'New: TranslationController', '2025-01-10 11:26:53', '2025-01-10 11:26:53'),
(138, 'tasks', 'title', 92, 'de', 'Neu: Observer Klassen', '2025-01-10 11:27:14', '2025-01-10 11:27:14'),
(139, 'tasks', 'title', 105, 'de', 'projects.show: neue Views (byscope, latest, latesttask, chronological, withalldetails)', '2025-01-10 11:27:45', '2025-01-10 11:27:45'),
(140, 'tasks', 'title', 104, 'de', 'projects.show: Edit-Button (für isAdminUser) ergänzen', '2025-01-10 11:28:23', '2025-01-10 11:28:23'),
(141, 'tasks', 'title', 103, 'de', 'Überarbeitung Sprachdateien', '2025-01-10 11:28:52', '2025-01-10 11:28:52'),
(142, 'tasks', 'title', 102, 'de', 'Anpassung & Überarbeitung der Icons für alle index blades', '2025-01-10 11:29:26', '2025-01-10 11:29:26'),
(143, 'tasks', 'title', 101, 'de', 'Anpassung & Überarbeitung der Icons für projects.index', '2025-01-10 11:29:56', '2025-01-10 11:29:56'),
(144, 'tasks', 'title', 100, 'de', 'Anpassungen: Navigation und Verlinkungen', '2025-01-10 11:30:34', '2025-01-10 11:30:34'),
(145, 'tasks', 'title', 99, 'de', 'Korrektur Teaser-Blade (falscher Link und Darstellung)', '2025-01-10 11:31:08', '2025-01-10 11:31:08'),
(146, 'tasks', 'title', 97, 'de', 'Neue Middleware: ensureUserIsAdmin', '2025-01-10 11:31:31', '2025-01-10 11:31:31'),
(147, 'tasks', 'title', 113, 'de', 'Fertig: Controller für Task und TaskDetail', '2025-01-10 11:32:00', '2025-01-10 11:32:00'),
(148, 'tasks', 'title', 112, 'de', 'Fertig: Controller für Project, Scope und TaskDetailType', '2025-01-10 11:32:29', '2025-01-10 11:32:29'),
(149, 'tasks', 'title', 111, 'de', 'Neu: projects.destroy', '2025-01-10 11:32:44', '2025-01-10 11:32:44'),
(150, 'tasks', 'title', 110, 'de', 'Untersuchung der Seitenlade-Prozesses von Laravel', '2025-01-10 11:33:17', '2025-01-10 11:33:17'),
(151, 'tasks', 'title', 109, 'de', 'Alle Service-Klassen: Anpassung Log-einträge', '2025-01-10 11:33:52', '2025-01-10 11:33:52'),
(152, 'tasks', 'title', 137, 'de', 'Anpassung ViewComposer für Welcome Seite und das Unterseiten-Layout', '2025-01-10 11:34:32', '2025-01-10 11:34:32'),
(153, 'tasks', 'title', 138, 'de', 'New: NavigationService + TeaserService', '2025-01-10 11:34:55', '2025-01-10 11:34:55'),
(154, 'tasks', 'title', 108, 'de', 'LanguageService: Integration Caching', '2025-01-10 11:35:40', '2025-01-10 11:35:40'),
(155, 'tasks', 'title', 107, 'de', 'Korrekturen: Basis-Layout & projects.index', '2025-01-10 11:36:07', '2025-01-10 11:36:07'),
(156, 'tasks', 'title', 141, 'de', 'Anpassung & Fertigstellung: Project - index, switch, create, store, show, edit, update', '2025-01-10 11:36:35', '2025-01-10 11:36:35'),
(157, 'tasks', 'title', 139, 'de', 'Integration TranslationHelper in Controller, Middleware and Services', '2025-01-10 11:37:01', '2025-01-10 11:37:01'),
(158, 'tasks', 'title', 136, 'de', 'Einsatz von Vite für CSS und Bilder', '2025-01-10 11:37:32', '2025-01-10 11:37:32'),
(159, 'tasks', 'title', 135, 'de', 'Neu: ViewComposer', '2025-01-10 11:37:49', '2025-01-10 11:37:49'),
(160, 'tasks', 'title', 134, 'de', 'Doku lesen: @props, fake(), Factory & Seeder for Unit-Tests; Laravel Mix <-> Vite', '2025-01-10 11:38:07', '2025-01-10 11:38:07'),
(161, 'tasks', 'title', 133, 'de', 'Debugbar Problem gelöst; dd (++)', '2025-01-10 11:38:28', '2025-01-10 11:38:28'),
(162, 'tasks', 'title', 132, 'de', 'Welcome view & controller: Anzeigen DB-Daten (scopes / tasks)', '2025-01-10 11:39:23', '2025-01-10 11:39:23'),
(163, 'tasks', 'title', 131, 'de', 'Anpassungen users; neu: scopes, tasks, task details, task_detail_types (migration, factory, seeder)', '2025-01-10 11:40:39', '2025-01-10 11:40:39'),
(164, 'tasks', 'title', 129, 'de', 'Konzept: Vorgangsweise für Anpassungen der DB-Struktur', '2025-01-10 11:41:19', '2025-01-10 11:41:19'),
(165, 'tasks', 'title', 128, 'de', 'Konzept für: Login & Verwaltung dynamischer Daten (welche für alle/mehrere Views benötigt werden)', '2025-01-10 11:42:11', '2025-01-10 11:42:11'),
(166, 'tasks', 'title', 127, 'de', 'Detailliertes Konzept & Struktur/Layout für Unterseiten (blades)', '2025-01-10 11:42:44', '2025-01-10 11:42:44'),
(167, 'tasks', 'title', 125, 'de', 'Neu: Middleware für LanguageSwitcher', '2025-01-10 11:43:53', '2025-01-10 11:43:53'),
(168, 'tasks', 'description', 125, 'de', '(1) wird registriert in AppServiceProvider\r\n(2) AppServiceProvider wird in bootstrap/app.php eingebunden', '2025-01-10 11:43:53', '2025-01-10 11:43:53'),
(169, 'tasks', 'title', 123, 'de', 'Laravel Logging konfigurieren (daily) & Log-Ausgaben einbauen', '2025-01-10 11:44:39', '2025-01-10 11:44:39'),
(170, 'tasks', 'title', 122, 'de', 'Projektverzeichnisse für sprachabhängige Texte erstellen (lang/en, lang/de)', '2025-01-10 11:45:13', '2025-01-10 11:45:13'),
(171, 'tasks', 'title', 121, 'de', 'Basis-HTML-Struktur und CSS für Welcome Seite', '2025-01-10 11:45:57', '2025-01-10 11:45:57'),
(172, 'tasks', 'title', 120, 'de', 'Neu: WelcomeController für die Route \'home\'', '2025-01-10 11:46:32', '2025-01-10 11:46:32'),
(173, 'tasks', 'title', 119, 'de', 'Neu: Tabelle projects (mit migration, model und factory Klassen)', '2025-01-10 11:47:19', '2025-01-10 11:47:19'),
(174, 'tasks', 'title', 118, 'de', 'Entscheidung: an welchem Übungsprojekt werde ich arbeiten', '2025-01-10 11:50:22', '2025-01-10 11:50:22'),
(175, 'tasks', 'description', 118, 'de', 'Nach den ersten Experimenten, um ein Gefühl für die Grundfunktionalität von Laravel zu bekommen, habe ich mir überlegt, an welchem Beispiel ich während der Schulung arbeiten möchte, welche DB-Tabellen ich dafür brauche und wie das Layout aussehen soll.\r\n\r\nMeine Entscheidungen:\r\n(1) Mein Projekt soll meine eigene Arbeit in diesem Kurs dokumentieren\r\n(2) Ich habe eine Liste von DB-Tabellen und ihren Feldern erstellt\r\n(3) Mein Projekt soll mindestens 2 Sprachen unterstützen (en+de) und für weitere Sprachen erweiterbar sein\r\n(4) Neben der Erfassung der Grunddaten soll daher auch eine allgemeine Übersetzungsfunktionalität vorhanden sein\r\n(5) Ich erstellte 2-3 Layout-Skizzen, wie mein Projekt aussehen und funktionieren soll. Dabei habe ich die Anforderungen an das Layout und die Benutzeroberfläche sehr einfach gehalten, da der Schwerpunkt meiner Ausbildung auf der Backend-Seite liegt.\r\n\r\nNun kann ich Schritt für Schritt mit der Umsetzung beginnen.', '2025-01-10 11:50:22', '2025-02-04 16:11:31'),
(176, 'tasks', 'title', 117, 'de', 'TaskController, eine Route und View erstellen und damit experimentieren!', '2025-01-10 11:51:30', '2025-03-07 10:09:32'),
(177, 'task_details', 'description', 33, 'de', '<strong>Queues & Jobs - Details:</strong>\r\n(1) php artisan make:notification NewTaskCreatedNotification\r\n(2) check files queue.php & .env:\r\n        - QUEUE_CONNECTION=database\r\n(3) php artisan queue:table (automatically creates queue tables)\r\n(4) php artisan migrate\r\n---\r\n(5) make:job NotifyClassCancelledJob\r\n(6) php artisan queue:work (start worker process)', '2025-01-13 06:08:17', '2025-01-13 06:08:17'),
(178, 'tasks', 'description', 86, 'de', '(1) php artisan make:mail TranslationMissingMail\r\n(2) check configuration in: config/mail.php & .env\r\n(3) to send dummy-emails use <strong>mailtrap.io</strong>', '2025-01-13 06:18:18', '2025-01-13 06:18:18'),
(179, 'tasks', 'description', 84, 'de', '(1) Gate = global safety checks\r\n(2) Middleware = secure http-requests (e.g., routes)\r\n(3) Policy = model-based safety checks', '2025-01-13 06:22:17', '2025-01-13 06:22:17'),
(180, 'task_details', 'description', 34, 'de', 'use HasFactory;\r\nprotected $fillable = [\'title\', \'description\', \'is_featured\', \'locale\']; \r\nprotected $attributes = [\'is_featured\' => false];', '2025-01-13 06:43:30', '2025-03-07 10:36:10'),
(181, 'task_details', 'description', 35, 'de', 'Das Attribut \'guarded\' ist das Gegenteil von \'fillable\'.\r\n\r\nWeitere: visible, hidden, ..., relations, ..., observables, ... (siehe dd())', '2025-01-13 06:45:35', '2025-01-13 07:43:36'),
(182, 'tasks', 'description', 97, 'de', 'Middleware kann auch Parameter verwenden:\r\n \'isAdminUser:instructor\' (\'instructor\' = Parameter, der an die Middleware \'isAdminUser\' übergeben wird)', '2025-01-13 06:50:34', '2025-01-13 06:50:46'),
(183, 'tasks', 'title', 143, 'de', 'User: neue Spalte \'default_project\' (Wert in Cookie speichern)', '2025-01-13 06:56:49', '2025-02-06 10:00:09'),
(184, 'tasks', 'title', 144, 'de', 'getTranslatedField: Prüfung auf locale = originLocale (blades anpassen)', '2025-01-13 07:01:38', '2025-01-13 07:01:38'),
(185, 'tasks', 'title', 145, 'de', 'Form-Fields: add props autofocus, className (create, search, edit, ...)', '2025-01-13 07:03:42', '2025-02-05 14:53:15'),
(186, 'tasks', 'title', 146, 'de', 'Suchen-Block: Form-Field Komponenten verwenden', '2025-01-13 07:04:51', '2025-02-06 08:08:01'),
(187, 'tasks', 'title', 147, 'de', 'Welcome-Blade: use components (links, scopeLeft, ScopeRight + opt: descr)', '2025-01-13 07:08:18', '2025-02-05 14:54:05'),
(188, 'tasks', 'description', 140, 'de', '(1) Liste aller Routen: php artisan route:list\r\n(2) Liste aller php artisan Kommandos: php artisan list', '2025-01-13 07:15:30', '2025-01-13 07:15:30'),
(189, 'task_details', 'description', 36, 'de', 'SoftDeletes:\r\n(1) migration: $table->SoftDeletes(); / $table->dropSoftDeletes();\r\n(2) model: use SoftDeletes();\r\n(3) new controller: TrashedNoteController\r\n(4) Queries:  withTrashed(), onlyTrashed()\r\n(5) Route: route(/trashed, \'index\')', '2025-01-13 07:40:54', '2025-01-13 07:40:54'),
(190, 'tasks', 'title', 148, 'de', 'Überprüfung DB-Abfragen & -Indizes', '2025-01-13 07:46:18', '2025-01-13 07:46:18'),
(191, 'tasks', 'title', 149, 'de', 'Datei-Upload zu TaskDetal hinzufügen', '2025-01-13 07:51:19', '2025-01-13 07:51:19'),
(192, 'tasks', 'title', 150, 'de', 'Index-Blades: add \'Keine Daten vorhanden!\'', '2025-01-13 07:54:17', '2025-02-05 14:54:53'),
(193, 'tasks', 'title', 151, 'de', 'BE: Navigation überarbeiten', '2025-01-13 08:01:38', '2025-02-06 16:58:40'),
(194, 'task_details', 'description', 37, 'de', 'Navigationselemente für dynamische Projekt-Detailansichten nur anzeigen, wenn Projekte das aktive Navigationselement ist.', '2025-01-13 08:02:32', '2025-02-07 08:43:35'),
(195, 'tasks', 'title', 152, 'de', 'Hinzufügen der CSS-Klasse \'white-space-pre-wrap\' zu \'{!! ... !!}\' für Beschreibungs-Texte', '2025-01-13 08:06:33', '2025-02-05 13:22:55'),
(196, 'tasks', 'title', 154, 'de', 'getSopces & getTaskDetailTypes: create ServiceClass', '2025-01-13 08:08:20', '2025-01-13 08:08:20'),
(197, 'tasks', 'title', 155, 'de', 'Re-work: session, cache, cookie & use different session-cookies (FE, BE)', '2025-01-13 08:11:40', '2025-02-06 15:58:05'),
(198, 'task_details', 'description', 38, 'de', 'For React-Frontend and Laravel-Backend different session cookies are used.\r\n\r\n<strong>Changes-List:</strong>\r\n(1) .env: <span class=\"pre-font\">\r\n     SESSION_COOKIE=pn_backend_session\r\n     SESSION_COOKIE_API=pn_frontend_session </span>\r\n\r\n(2) AppServiceProvider - function register() - as first entry: <span class=\"pre-font\">\r\n     $request = $this->app[\'request\'];\r\n     if ($request->is(\'api/*\') || $request->is(\'sanctum/*\')) {\r\n        Config::set(\'session.cookie\', env(\'SESSION_COOKIE_API\', \'pn_frontend_session\'));\r\n     } </span>\r\n\r\n(3) Replace all usages of session-cookie names with env-variables: login, register, logout', '2025-01-13 08:12:41', '2025-02-06 16:52:05'),
(199, 'task_details', 'description', 39, 'de', '(1) user-session:\r\n      - locale, projectId, projectTitle\r\n(2) cache:\r\n      - languages, teaserTask\r\n(3) user cookies: \r\n      - userLocale, userProjectId', '2025-01-13 08:14:36', '2025-02-06 16:32:05'),
(200, 'tasks', 'title', 157, 'de', 'Routen mit UUID parametrieren (anstatt id\'s)', '2025-01-13 08:22:02', '2025-01-13 08:22:02'),
(201, 'task_details', 'description', 40, 'de', 'LinkedIn-Video - Essentials Part I:\r\n(1) Str::uuid() -> creates uuid\r\n(2) model: public function getRouteKeyName () { return \'uuid\'; } ... (uuid anstatt id in URL)\r\n(3) store(): \r\n	  $note = Auth::user()->notes()->create([..., \'uuid\' => Str::uuid(), ...]);\r\n          OR\r\n	  $note = new Note([..., \'uuuid\' => Str::uuid(), ...]); $note->save();', '2025-01-13 08:26:59', '2025-01-13 08:26:59'),
(202, 'tasks', 'title', 158, 'de', 'Routes/Controllers: check for model binding (z.B. Project $project)', '2025-01-13 08:29:55', '2025-02-08 02:42:02'),
(203, 'tasks', 'title', 159, 'de', 'Erweiterte Funktionen: Login & Register', '2025-01-13 08:32:05', '2025-01-13 08:32:05'),
(204, 'tasks', 'description', 113, 'de', 'Interessante Informationen:\r\n(1) $request->query()\r\n(2) $notes = Auth::user()->notes->latest(\'updated_at\')->paginate(5);\r\n(3) $notes = Note::whereBelongsTo(Auth::user())->latest(...)...\r\n(4)  if ($note->user->is(Auth::user())) {...}', '2025-01-13 08:36:43', '2025-01-13 08:36:43'),
(205, 'tasks', 'title', 160, 'de', '<a href=\"https://www.linkedin.com/learning/building-restful-apis-in-laravel-8532490/building-restful-apis-in-laravel?u=0\" class=\"external-link\">LinkedIn: REST-API - detailed (en)</a>', '2025-01-13 08:44:05', '2025-02-10 08:32:33'),
(206, 'tasks', 'title', 162, 'de', '<a href=\"https://www.linkedin.com/learning/react-essential-training/building-modern-user-interfaces-with-react?u=0\" class=\"external-link\">LinkedIn: React</a>', '2025-01-13 08:47:18', '2025-01-13 08:47:18'),
(207, 'tasks', 'title', 163, 'de', '<a href=\"https://www.linkedin.com/learning/building-a-website-with-laravel-react-js-and-inertia/building-a-website-with-laravel-react-and-inertia?u=0\" class=\"external-link\" target=\"_blank\">LinkedIn: Laravel & React</a>', '2025-01-13 08:48:19', '2025-02-04 19:14:31'),
(208, 'tasks', 'title', 164, 'de', 'Neu: benutzerdefiniertes Kommando OrphanTranslations & Task-Schedule', '2025-01-13 09:02:42', '2025-01-13 11:52:41'),
(209, 'task_details', 'description', 42, 'de', '(1) php artisan make:command OrphanTranslations\r\n(2) lang/de/command.php + lang/en/command.php\r\n---\r\n(3) php artisan app:orphan-translations\r\n(4) php artisan app:orphan-translations --param=value\r\n--\r\n(5) php artisan make:notification OrphanTranslationsNotification\r\n---\r\n(6) routes/console.php: \r\nSchedule::command(OrphanTranslations::class)->everyFiveMinutes();\r\nSchedule::command(OrphanTranslations::class)->dailyAt(\'20:00\');\r\nSchedule::command(OrphanTranslations::class)->monthlyOn(1, \'08:00\');\r\n(7) php artisan schedule:list\r\n(8) php artisan schedule:work\r\n---\r\n(9) <a href=\"https://laravel.com/docs/11.x/scheduling#\" class=\"external-link\">Laravel 11: Scheduling</a>', '2025-01-13 10:00:07', '2025-01-13 12:21:14'),
(210, 'tasks', 'title', 165, 'de', 'Dokumentation lesen: Broadcasting, Casts, Rules', '2025-01-13 12:17:32', '2025-01-13 12:55:07'),
(211, 'task_details', 'description', 43, 'de', 'Nur als Beispiel (Klasse EvenNumber nicht erzeugt).\r\n(1) php artisan make:rule EvenNumber\r\n...\r\n(2) $request->validate([\r\n    \'number\' => [\'required\', new EvenNumber],\r\n]);', '2025-01-13 12:19:52', '2025-01-14 06:29:40'),
(212, 'task_details', 'description', 44, 'de', '<strong>Casts werden in Model-Klassen definiert:</strong>\r\n<pre>protected function casts(): array { return [ \'password\' => \'hashed\' ]  }</pre>', '2025-01-13 12:51:50', '2025-01-13 12:51:50'),
(213, 'task_details', 'description', 45, 'de', 'Benötigt einige zusätzliche Installation für Back- und Frontend (nicht ausgeführt, nur Dokumentation gelesen):\r\n<a href=\"https://laravel.com/docs/11.x/broadcasting\" class=\"external-link\">Laravel 11: Broadcasting</a>', '2025-01-13 12:57:07', '2025-01-14 06:30:45'),
(214, 'tasks', 'title', 166, 'de', 'Dokumentation: Concurrent Tasks', '2025-01-13 13:15:38', '2025-01-13 13:15:38'),
(215, 'task_details', 'description', 46, 'de', '<a href=\"https://laravel.com/docs/11.x/concurrency\" class=\"external-link\">Laravel 11: Concurrent Tasks</a>', '2025-01-13 13:17:32', '2025-01-13 13:17:32'),
(216, 'tasks', 'title', 168, 'de', 'Info: DTO', '2025-01-13 13:46:16', '2025-01-13 13:46:16'),
(217, 'task_details', 'description', 47, 'de', '<a href=\"https://github.com/canyongbs/advisingapp/tree/main/app/DataTransferObjects\" class=\"external-link\">Github-Example</a>\r\n<a href=\"https://www.youtube.com/watch?v=5qOwF-J5xxM\" class=\"external-link\">YouTube-Video</a>', '2025-01-13 13:47:08', '2025-01-13 13:56:05'),
(218, 'tasks', 'title', 167, 'de', 'Doku: Repositories vs. Services', '2025-01-13 14:10:29', '2025-01-13 14:10:29'),
(219, 'task_details', 'description', 48, 'de', '(1) php artisan make:class Services/ScopeService\r\n(2) php artisan make:class Services/TaskDetailTypeService\r\n(3) php artisan make:class Services/TaskService (uses ScopeService)\r\n---\r\n(4) integrate changes into TaskController (uses TaskService)\r\n---\r\n(5) php artisan make:class Services/TaskDetailService (uses ScopeService, TaskDetailTypeService)\r\n---\r\n(6) integrate changes inot TaskDetailController (uses TaskDetailService)', '2025-01-14 05:56:11', '2025-01-14 05:56:11'),
(220, 'task_details', 'description', 49, 'de', 'Entscheidung: habe mich gegen die Verwendung sogenannter Repository-Klassen entschieden und verwende Service-Klassen (je Model). Die jeweiligen Service-Klassen der Models inkludieren weitere Service Klassen (anderer Models oder Funktionalitäten).', '2025-01-14 06:35:34', '2025-01-14 06:35:34'),
(221, 'task_details', 'description', 50, 'de', 'Weitere Optimierungen sollten hier für Controller generell noch gemacht werden: z.B. Auslagerung umfangreicher DB-Abfragen, etc.', '2025-01-14 06:40:25', '2025-01-14 06:41:04'),
(222, 'tasks', 'title', 169, 'de', 'Projekt fürs Testing vorbereiten / configurieren', '2025-01-14 06:58:49', '2025-01-14 06:58:49'),
(223, 'task_details', 'description', 51, 'de', '(1) export DB content\r\n(2) commit / push all changes\r\n---\r\n(3) cp .env .env.testing:\r\n     - APP_ENV=testing\r\n     - APP_URL=http://localhost:8001\r\n     - DB_DATABASE=projectnavigator_test\r\n(4) adapt phpunit.xml:\r\n     - APP_ENV=testing \r\n     - DB_CONNECTION=mysql\r\n     - DB_DATABASE -> projectnavigator_test\r\n(5) adapt package.json:\r\n     - add comma separated line under scripts: \r\n          - \"dev:testing\": \"vite --mode testing\" \r\n(6) adapt vite.config.js: add this lines \r\n<pre><code>\r\n     server: {\r\n         port: process.env.MODE === \'testing\' ? 5174 : 5173, \r\n     },\r\n</code></pre>\r\n---\r\n(7) php artisan config:clear\r\n(8) php artisan cache:clear\r\n---\r\n(9) npm run dev:testing\r\n(10) php artisan migrate --env=testing (you are asked to create DB, use projectnavigator_test)\r\n(11) php artisan serve --host=127.0.0.1 --port=8001 --env=testing\r\n--- \r\n(12) php artisan test (-> results in errors, because DB is empty!)\r\n---\r\n(13) prepare DatabaseSeeder class to seed new DB projectnavigator_test\r\n---\r\n(14) php artisan db:seed --env=testing\r\n---\r\n(15) re-test & work on test classes', '2025-01-14 07:00:36', '2025-03-07 10:47:19'),
(224, 'tasks', 'title', 170, 'de', 'Laravel Stubs-Dateien durchsehen', '2025-01-14 08:28:40', '2025-01-14 08:28:40'),
(225, 'task_details', 'description', 52, 'de', 'php artisan stub:publish', '2025-01-14 08:29:28', '2025-01-14 08:29:28'),
(226, 'tasks', 'title', 171, 'de', 'Erstellung von Feature- & Unit-Tests', '2025-01-14 09:23:58', '2025-01-14 09:23:58'),
(227, 'task_details', 'description', 53, 'de', 'Create new class ProjectSeeder & execute:\r\nphp artisan db:seed --env=testing --class=ProjectSeeder\r\n\r\nTest Invocation - Examples:\r\n(1) php artisan test (= all tests)\r\n(2) php artisan test --filter WelcomePageDisplayTest (only this test class)\r\n(3) php artisan test --filter test_welcome_page_with_empty_db_returns_an_error (only this test method)\r\n(4) php artisan test --testsuite=Feature --stop-on-failure (only feature tests & stop after first failure)\r\n\r\nFeature-Tests:\r\n(1) WelcomePageDisplayTest (php artisan test --filter WelcomePageDisplayTest)\r\n(2) ProfileTest, AuthenticationTest, RegistrationTest\r\n\r\nUnit-Tests:\r\n(1) ScopeServiceTest\r\n\r\ncomposer.json:\r\nadd under \"scripts\":\r\n        \"tests\": [\r\n            \"@php artisan test --testsuite=Unit\",\r\n            \"@php artisan test --testsuite=Feature\"\r\n        ]\r\ncomposer run tests\r\n\r\n<a href=\"https://docs.phpunit.de/en/11.5/configuration.html\" class=\"external-link\">PHPUnit - Dcoumentation</a>', '2025-01-14 09:25:54', '2025-01-15 09:04:44'),
(228, 'tasks', 'title', 172, 'de', 'API-Package installieren und anwenden', '2025-01-15 01:39:14', '2025-01-15 01:39:14'),
(229, 'task_details', 'description', 54, 'de', '<strong>Install API-Package:</strong>\r\n(1) php artisan install:api (-> 1 migration has to be run)\r\n(2) add the [Laravel\\Sanctum\\HasApiTokens] trait to your User model\r\n(3) API route file has to be registered manually. Add API route definition file (routes/api.php) to bootstrap file (bootstrap/app.php): <pre>api: __DIR__ . \'/../routes/api.php\',</pre><strong>Work with API-Package:</strong>\r\n(1) Create first API test route in api.php: <pre>Route::get(\'test\', function () {<br> return \'My first API route :-)\';<br>});</pre>(2) VSCode: install extension \'thunder client\' and test out first route created before\r\n(3) <a href=\"https://jsonplaceholder.typicode.com/\" class=\"external-link\" target=\"_blank\">Dummy API for testting</a>\r\n(4) Adapt folder structure: Controllers/Api & Controllers/App, Requests/Api & Requests/App\r\n(5) composer dump-autoload, route:clear, ...\r\n(6) php artisan make:controller Api/V1/WelcomeController\r\n(7) php artisan make:controller Api/V1/ProjectController\r\n(8) php artisan make:service Api/V1/WelcomeService\r\n(9) php artisan make:request Api/V1/ProjectRequest\r\n(10) php artisan make:request Api/V1/Auth/LoginRequest\r\n(11) php artisan make:controller Api/V1/Auth/RegisteredUserController\r\n(12) php artisan make:controller Api/V1/Auth/AuthenticatedSessionController', '2025-01-15 01:40:43', '2025-02-04 16:31:56'),
(230, 'tasks', 'title', 173, 'de', 'Dusk Tests', '2025-01-15 15:10:56', '2025-01-15 15:10:56'),
(231, 'task_details', 'description', 55, 'de', '(1) composer require --dev laravel/dusk\r\n(2) php artisan dusk:install\r\n(3) php artisan dusk:make LoginTest\r\n(4) php artisan dusk:chrome-driver 131\r\n(5) ./vendor/laravel/dusk/bin/chromedriver-mac-intel (check port and adapt in dusk-test)\r\n(6) php artisan dusk\r\n---\r\n(7) Chrome updated to version 132.*\r\n(8) php artisan dusk:chrome-driver 132', '2025-01-15 15:11:35', '2025-01-16 02:31:37'),
(232, 'tasks', 'title', 174, 'de', 'API routes: integrate versioning into routes', '2025-01-16 02:37:05', '2025-01-16 02:37:05'),
(233, 'task_details', 'description', 56, 'de', 'Verwende folgendes Code-Snippet in der Datei api.php: <pre>Route::prefix(\'v1\')->name(\'api.v1.\')->group(function () {...}</pre>', '2025-01-16 02:44:56', '2025-01-16 02:44:56'),
(234, 'tasks', 'title', 175, 'de', 'tasks.index: Korrektur Anzeige (nur Link-Titel)', '2025-01-16 03:17:42', '2025-01-16 03:17:42'),
(235, 'tasks', 'title', 176, 'de', 'Installation Vite & React', '2025-01-16 04:33:54', '2025-01-16 10:51:01'),
(236, 'task_details', 'description', 57, 'de', 'Install:\r\n(1) npm create vite@latest frontend -- --template react\r\n(2) cd frontend\r\n(3) npm install\r\n(4) npm install -D tailwindcss postcss autoprefixer\r\n(5) npx tailwindcss init -p\r\n(6) frontend/tailwind.config.js: content: [\".index.html\", \".src/**/*.{js,ts,jsx,tsx}\"],\r\n(7) frontend/src/index.css -> replace content with:\r\n		- @tailwind base;    \r\n		- @tailwind components;     \r\n		- @tailwind utilities;\r\n(8) frontend/package.json -> add port 3000:  \"dev\": \"vite --port=3000\",\r\n(9) npm run dev\r\n(10) <a href=\"http://localhost:3000\" class=\"external-link\" target=\"_blank\">Vite&React - Frontend</a> is running 🌟\r\n(11) npm install react-router-dom\r\n(12) use api route http://localhost:8000/api/v1/welcome to show WelcomePage-Content with React\r\n(13) start: form to create a project (gets unauthorized error - which is correct)', '2025-01-16 04:35:35', '2025-01-16 10:21:41'),
(237, 'tasks', 'title', 177, 'de', 'Install InertiaJS for React', '2025-01-16 10:51:47', '2025-01-16 10:51:47'),
(238, 'task_details', 'description', 58, 'de', 'Install Inertia:\r\n(1) composer require inertiajs/inertia-laravel\r\n(2) composer require tightenco/ziggy\r\n--\r\n(3) npm install @inertiajs/react\r\n(4) npm install react@latest react-dom@latest\r\n(5) npm install @vitejs/plugin-react --save-dev\r\n--\r\n(6) web.php: Route::inertia(\'/about\', \'About\')->name(\'about\');\r\n(7) create new file resources/js/app.jsx\r\n(8) creates resources/js/Pages/About.jsx\r\n(9) adapt: config.vite.js\r\n(10) create new file: resources/js/views/app.blade.php (= Inertia rendering start point)\r\n---\r\n(11) http://localhost:8000/about (= is delivered correctly)', '2025-01-16 10:52:26', '2025-01-17 12:13:22'),
(239, 'tasks', 'title', 178, 'de', 'Dokumentation: Build-Prozess für \'prod\'', '2025-01-18 04:01:37', '2025-01-18 04:01:37'),
(240, 'scopes', 'label', 57, 'de', 'Build-Prozess', '2025-01-18 04:10:44', '2025-01-18 04:10:44'),
(241, 'task_details', 'description', 59, 'de', '(1) be sure all dependencies are up to date:\r\n     npm install\r\n(2) insert following code-lines into vite.config.js:\r\n     build: {\r\n         outDir: \'public/build\',\r\n         manifest: true,\r\n         chunkSizeWarningLimit: 500,\r\n    },\r\n(3) Laravel-Build:\r\n     npm run build -- --production\r\n(4) insert following code-lines into frontend/vite.config.js:\r\n       build: {\r\n        outDir: \'public/frontend\', \r\n        manifest: true, \r\n        chunkSizeWarningLimit: 500, \r\n     },\r\n(5) React-Build:\r\n     cd frontend\r\n     npm install \r\n     npm run build -- --production', '2025-01-18 04:11:30', '2025-02-05 12:24:20'),
(242, 'tasks', 'title', 179, 'de', 'Source-Code Überarbeitung (Korrekturen, Vereinheitlichung, Optimierung)', '2025-01-18 08:34:45', '2025-01-18 08:34:45'),
(243, 'tasks', 'title', 180, 'de', 'Weitere Ausarbeitung API Routen', '2025-01-20 07:32:33', '2025-01-20 07:32:33'),
(244, 'task_details', 'description', 60, 'de', '(1) Configure Sanctum for API usage:\r\n      - config/sanctum.php: \'guard\' => [\'api\'],\r\n      - php artisan config:publish cors\r\n      - config/cors.php: \r\n           - \'paths\' => [\'api/*\', \'sanctum/csrf-cookie\'],\r\n           - \'allowed_origins\' => [\'http://localhost:3000\'],\r\n           - \'supports_credentials\' => false,  (= false, when tokens are used for auth)\r\n(2)', '2025-01-20 07:34:58', '2025-01-20 07:34:58'),
(245, 'tasks', 'title', 161, 'de', '<a href=\"https://www.youtube.com/playlist?list=PLdXLsjL7A9k0esh2qNCtUMsGPLUWdLjHp\" class=\"external-link\" target=\"_blank\">YouTube: Laravel & Testing</a>', '2025-01-13 08:44:05', '2025-01-13 08:44:05'),
(246, 'tasks', 'title', 156, 'de', 'Projekt-Listen (FE+BE): Interaktionen integrieren', '2025-02-03 09:50:21', '2025-02-20 10:54:02'),
(247, 'tasks', 'title', 142, 'de', 'Middleware & Controller: auth()-check() vs. Auth::check()', '2025-02-03 09:51:51', '2025-02-04 18:46:43'),
(248, 'task_details', 'description', 61, 'de', 'Changes-List:\r\n(1) TranslatableModel.php: \r\n      - change function getTranslatedField()\r\n(2) ProjectService.php:\r\n      - remove locale checks before invoking getTranslatedField()\r\n(3) for all index.blade.php files:\r\n      - remove locale checks before invoking getTranslatedField()\r\n      - remove PHP varibable isOriginalLocale', '2025-02-03 10:05:50', '2025-02-03 10:06:13');
INSERT IGNORE INTO `translations` (`id`, `table_name`, `field_name`, `record_id`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(250, 'task_details', 'description', 63, 'de', 'In manchen Laravel-Komponenten (z.B. Controller, Service, ...) ist VSCode nicht in der Lage, \'auth()->check()\' aufzulösen, funktioniert aber korrekt mit \'Auth::check()\'. In Middelware und Blade-Templates hingegen funktioniert \'auth()->check()\' korrekt.\r\n\r\n(1) Dies ist nur ein IDE-Problem, weil VSCode nicht in der Lage ist, diese dynamische Konstruktion korrekt aufzulösen.\r\n\r\n(2) Dieser Beispielcode wird in der IDE hingegen als korrekter Code akzeptiert:\r\n\r\n/** @var \\Illuminate\\Contracts\\Auth\\Guard $guard */\r\n$guard = auth();\r\n$guard->check();\r\n\r\nAlternativen, die auch funktionieren:\r\n- auth()->guard()->check();\r\n- auth(\'web\')->check();', '2025-02-04 18:17:57', '2025-02-05 09:16:28'),
(251, 'task_details', 'description', 64, 'de', 'Neue Blade - Templates:\r\n(1) resources/views/components/welcome/welcome-column.blade.php\r\n(2) resources/views/components/welcome/scope-block.blade.php\r\n(3) resources/views/components/welcome/show-project-detail-link.blade.php\r\n\r\nGeänderte Blade - Templates:\r\n(1) resources/views/welcome.blade.php', '2025-02-05 14:02:03', '2025-02-05 14:02:03'),
(252, 'task_details', 'description', 65, 'de', '<strong>Problem description:</strong>\r\nprops for blade-components can not be typed - e.g. a field label \'Scope\' is mis-interpreted as model (!)', '2025-02-06 06:49:44', '2025-02-06 06:49:44'),
(253, 'tasks', 'title', 181, 'de', 'Re-work: create class-based view components', '2025-02-06 06:50:11', '2025-02-06 15:54:05'),
(254, 'task_details', 'description', 66, 'de', '<strong> Changes-List:</strong>\r\n(1) php artisan make:migration add_default_project_id_to_users_table --table=users\r\n(2) edit migration:\r\n(3) change Model User:\r\n(4) change Model Project:\r\n(5) php artisan migrate', '2025-02-06 08:53:09', '2025-02-06 08:53:09'),
(255, 'tasks', 'title', 183, 'de', 'FE: integrate users.default_project_id', '2025-02-06 16:57:55', '2025-02-06 16:57:55'),
(256, 'task_details', 'description', 67, 'de', 'Adapt composer.json - autoload:\r\n<span class=\"pre-font\">\r\n    \"autoload\": {\r\n        \"psr-4\": {\r\n            \"App\\\\\": \"app/\",\r\n            \"Database\\\\Factories\\\\\": \"database/factories/\",\r\n            \"Database\\\\Seeders\\\\\": \"database/seeders/\"\r\n        },\r\n        \"files\": [\r\n            \"app/Helpers/apihelper.php\"\r\n        ]\r\n    }, </span>', '2025-02-06 17:43:39', '2025-02-06 17:43:39'),
(257, 'tasks', 'title', 184, 'de', 'Create Helpers/apihelper.php: apiResponse()', '2025-02-06 17:45:16', '2025-02-06 17:45:16'),
(258, 'task_details', 'description', 68, 'de', '<strong>Changes-List:</strong>\r\n(1) Backend:\r\n        - Api/V1/Auth/AuthenticatedSessionController.php\r\n        - Api/V1/Auth/RegisteredUserController.php\r\n(2) Frontend: \r\n        - src/Context/AuthProvider.jsx\r\n        - src/Context/GlobalDataProvider.jsx', '2025-02-07 04:24:51', '2025-02-07 04:24:51'),
(259, 'tasks', 'title', 185, 'de', 'Ergänzung Navigation mit Blades: x-responsive-nav-link and x-nav-dropdown', '2025-02-07 09:00:13', '2025-02-07 09:00:13'),
(260, 'task_details', 'description', 69, 'de', 'Siehe Dokumentation in Obsidian: Laravel-Seite.', '2025-02-07 09:01:23', '2025-02-07 09:01:23'),
(261, 'tasks', 'title', 186, 'de', 'Add passkey register/login as additional option (siehe: Obsidian)', '2025-02-07 09:16:48', '2025-02-07 09:20:59'),
(262, 'tasks', 'title', 189, 'de', 'Neues DB-Feld occurred_at für die Tabellen tasks & task_details', '2025-02-07 14:36:34', '2025-02-07 14:36:34'),
(263, 'task_details', 'description', 70, 'de', '<strong>Changes-List:</strong>\r\n(1) php artisan make:migration add_occurred_at_to_tasks_table --table=tasks\r\n(2) php artisan make:migration add_occurred_at_to_task_details_table --table=task_details\r\n---\r\n(3) edit both migration files\r\n(4) adapt models for task & task detail\r\n(5) adapt observers for task & task detail\r\n---\r\n(6) php artisan migrate\r\n---\r\n(7) create new form field input template for datetime-local (see attached code snippet)\r\n(8) adapt exiting blade-templates\r\n---\r\n(9) adapt controllers, request & service classes: sort tasks and task_details by occurred_at instead of created_at', '2025-02-07 14:43:53', '2025-02-07 15:06:14'),
(264, 'task_details', 'description', 71, 'de', '@props([\'label\', \'placeholder\' => \'\', \'name\', \'value\' => \'\', \'required\' => false, \'disabled\' => false, \'autofocus\' => false, \'classname\' => \'create-field\'])\r\n\r\n<div class=\"{{ $classname }}\">\r\n    <label for=\"{{ $name }}\" class=\"{{ $classname }}-label\">{{ __($label) }}</label>\r\n    <input type=\"datetime-local\"\r\n        id=\"{{ $name }}\"\r\n        name=\"{{ $name }}\"\r\n        placeholder=\"{{ $placeholder }}\"\r\n        value=\"{{ old($name,  $value ? \\Carbon\\Carbon::parse($value)->format(\'Y-m-d\\TH:i:s\') : \'\') }}\"\r\n        class=\"{{ $classname }}-text\"\r\n        step=\"1\"\r\n        @required($required)\r\n        @disabled($disabled)\r\n        @if($autofocus) autofocus @endif>\r\n    @error($name)\r\n    <div class=\"error\">{{ $message }}</div>\r\n    @enderror\r\n</div>', '2025-02-07 15:01:01', '2025-02-07 15:01:01'),
(267, 'tasks', 'title', 192, 'de', 'Re-work API Controllers (return type, model-binding, ...)', '2025-02-08 07:55:41', '2025-02-08 07:55:41'),
(268, 'tasks', 'title', 193, 'de', 'FE: alle Detailinformationen zum Projekt auflisten', '2025-02-08 14:35:03', '2025-02-08 14:35:03'),
(270, 'tasks', 'title', 196, 'de', 'Re-test Thunder Client API requests', '2025-02-09 08:58:49', '2025-02-09 08:58:49'),
(271, 'tasks', 'title', 197, 'de', 'Re-work / add missing API messages (en + de)', '2025-02-09 09:53:13', '2025-02-09 09:53:13'),
(272, 'tasks', 'title', 198, 'de', 'FE: Listen-Elemente (key-Angaben über Array-Indizes mit Ids ersetzen)', '2025-02-10 10:46:56', '2025-02-18 12:13:36'),
(273, 'task_details', 'description', 74, 'de', '<strong>Explanation:</strong>\r\nZustandslose API Anfragen benutzen diese Art von Session-Variable nicht. Sie stellen nur Parameter für die gemeinsam genutzten Klassen / Funktionen zur Verfügung!', '2025-02-18 12:09:29', '2025-02-18 12:10:38'),
(274, 'tasks', 'title', 200, 'de', 'BE: Prüfung Session-Variable für gemeinsam genutzte Klassen (web + api)', '2025-02-18 12:11:36', '2025-02-18 12:12:23'),
(275, 'tasks', 'title', 201, 'de', 'Projekt-Ansichten (BE): Seiten-Navigation integrieren', '2025-02-20 09:04:26', '2025-02-20 11:22:33'),
(276, 'tasks', 'title', 203, 'de', 'Aufgaben: Icon als Select-Box umgesetzt (neu & bearbeiten)', '2025-02-20 09:36:55', '2025-02-20 09:36:55'),
(277, 'tasks', 'title', 194, 'de', 'FE: read config.view & icons from BE', '2025-02-20 09:37:56', '2025-02-20 09:37:56'),
(278, 'tasks', 'title', 204, 'de', 'FE: Korrektur Welcome-Seite', '2025-02-20 10:55:40', '2025-02-20 10:55:40'),
(279, 'task_details', 'description', 75, 'de', '(1) Bereiche ohne Aufgaben nicht anzeigen.\r\n(2) Für Aufgaben würde der Primary-Key nicht mit übertragen, sodass keine eindeutigen Keys für Listen in React erzeugt werden konnten.', '2025-02-20 10:58:06', '2025-02-20 10:58:06'),
(280, 'tasks', 'title', 205, 'de', 'Projekt-Ansichten (FE): Integration Seitennavigation / scopeId (byscope)', '2025-02-20 11:19:52', '2025-02-20 15:00:52'),
(281, 'tasks', 'title', 206, 'de', 'FE: Anpassung der Projektansichten an das neue Konzept', '2025-02-20 13:21:23', '2025-02-20 13:21:23'),
(283, 'tasks', 'title', 207, 'de', 'Welcome-Seite: Code-Optimierung (neue Komponente ScopeList.jsx)', '2025-02-20 13:50:35', '2025-02-20 13:50:35'),
(284, 'tasks', 'title', 208, 'de', 'DB-Indizes: add migrations for indizes created temporary during query tests', '2025-02-20 14:06:34', '2025-02-20 14:06:34'),
(285, 'task_details', 'description', 76, 'de', '(1) php artisan make:migration add_index_project_id_column_sortorder_to_scopes_table --table=scopes\r\n(2) php artisan make:migration add_indexes_to_tasks_table --table=tasks\r\n(3) php artisan make:migration add_indexes_to_task_details_table --table=task_details\r\n(4) php artisan make:migration add_indexes_to_translations_table --table=translations', '2025-02-20 14:07:25', '2025-02-20 14:46:43'),
(286, 'task_details', 'description', 77, 'de', '(1) npm install react-paginate', '2025-02-20 17:59:50', '2025-02-20 17:59:50'),
(287, 'task_details', 'description', 78, 'de', 'Einige Projekt-Ansichten sind backend-seitig nun mit einer Seiten-Navigation ausgestattet, was für diese Ansichten die Datenstruktur ändert.\r\n\r\nDas besondere Problem für FE war, dass die Variable \'view\' Teil der URL ist und sich sofort ändert. Aber die Datenstruktur für die Projektansicht ist Teil eines useEffect und wird erst später aktualisiert (React re-render cycle takes place before executing useEffect). Daher wird die neue „Ansicht“ mit den bestehenden Daten der zuvor ausgewählten Ansicht gerendert!\r\n\r\n<strong>Lösung:</strong> Nicht \'view\' für Render-Zyklus verwenden, sondern eine Zustandsvariable erstellen, die synchron mit dem Lesen neuer Daten aus dem Backend aktualisiert wird (d.h. View und Daten werden immer synchron geändert)!', '2025-03-06 10:04:16', '2025-03-06 10:04:16'),
(288, 'tasks', 'title', 209, 'de', 'BE: ProjectService - Optimierung (nach Integration Blättern-Funktion)', '2025-03-06 10:22:17', '2025-03-06 10:22:17'),
(289, 'tasks', 'title', 210, 'de', 'TranslationHelper: Collections mit Pagination & Arrays integrieren', '2025-03-06 10:26:58', '2025-03-06 10:26:58'),
(290, 'tasks', 'title', 211, 'de', 'Übersetzungen: Datensatz löschen, wenn Eingabefeld geleert wird', '2025-03-06 10:32:23', '2025-03-06 10:32:23'),
(291, 'tasks', 'title', 212, 'de', 'FE: Project/Details.jsx - Vermeidung unnötiger Axios-Aufrufe', '2025-03-06 10:37:54', '2025-03-06 10:37:54'),
(292, 'task_details', 'description', 79, 'de', 'Um mehrfache Axios-Aufrufe bei der Navigation durch Projektdetails und verschiedene Projektansichten zu vermeiden, wurden einige Änderungen am entsprechenden useEffect vorgenommen: \r\n\r\n(1) Prüfung, ob sich relevante Parameter für den Axios-Aufruf wirklich geändert haben \r\n(2) beim Wechsel zu einer anderen Ansicht müssen auch currentPage und scopeId auf Intial-Werte gesetzt werden\r\n\r\nDas ist keine sehr elegante Lösung, und ich suche noch nach einer besseren, allgemeineren Alternative, die auch für komplexere Situationen geeignet wäre.', '2025-03-06 10:45:46', '2025-03-06 11:05:25'),
(293, 'task_details', 'description', 80, 'de', '...                 \r\nconst { projectId, view } = useParams(); \r\nconst [scopeId, setScopeId] = useState(0);\r\nconst [currentPage, setCurrentPage] = useState(1);\r\nconst lastPageRef = useRef(1);\r\nconst viewOldRef = useRef(view);\r\nconst scopeIdOldRef = useRef(0);\r\nconst currentPageOldRef = useRef(1);\r\nconst loadingRef = useRef(true);\r\nconst firstRenderRef = useRef(true);\r\n...\r\nuseEffect(() => {\r\n    const fetchData = async () => {\r\n        let pageToGet = currentPage;\r\n        let scopeIdToGet = scopeId;\r\n\r\n        if (view !== viewOldRef.current) {\r\n            pageToGet = 1;\r\n            scopeIdToGet = 0;\r\n        }\r\n\r\n        loadingRef.current = true;\r\n\r\n        try {\r\n            const response = await axios.get(`${config.API_URL}/projects/${projectId}/${view}?page=${pageToGet}&scopeId=${scopeIdToGet}`);\r\n            setProjectData(response.data.data); \r\n            ...\r\n            viewOldRef.current = view;\r\n            setScopeId(scopeIdToGet);\r\n            scopeIdOldRef.current = scopeIdToGet;\r\n            setCurrentPage(pageToGet);\r\n            currentPageOldRef.current = pageToGet;\r\n            lastPageRef.current = response.data.data?.scopes?.last_page;\r\n        } catch (error) {\r\n            ...\r\n        } finally {\r\n            loadingRef.current = false; \r\n        }\r\n    };\r\n    ...\r\n    if ((view !== viewOldRef.current) || (currentPage !== currentPageOldRef.current) || (scopeId !== scopeIdOldRef.current) || (firstRenderRef.current === true)) {\r\n        firstRenderRef.current = false;\r\n        fetchData(); \r\n    }\r\n}, [projectId, view, currentPage, scopeId]);', '2025-03-06 10:56:21', '2025-03-06 11:08:43'),
(294, 'tasks', 'title', 213, 'de', 'FE: useEffect - Mehrfach-Aufrufe verhindern - Alternativen (isUpdatingRef?)', '2025-03-06 13:30:35', '2025-03-06 13:30:35'),
(295, 'tasks', 'title', 214, 'de', 'Projekt-Ansichten: Suchfunktion hinzufügen', '2025-03-06 15:41:56', '2025-03-06 15:41:56'),
(296, 'tasks', 'title', 215, 'de', 'FE: npm install dompurify', '2025-03-06 16:53:49', '2025-03-06 16:53:49'),
(297, 'tasks', 'description', 40, 'de', '(1) composer global require laravel/installer', '2025-03-06 17:24:04', '2025-03-06 17:24:04'),
(298, 'task_details', 'description', 81, 'de', 'Voraussetzungen:\r\n(1) VSCode ist installiert\r\n(2) Git ist installiert\r\n(3) Ein Github-Account steht zur Verfügung\r\n\r\nConfigurieren & Synchronisieren:\r\n(1) Github: ein neues Repository \'ProjectNavigator\' erstellen\r\n(2) ProjectNavigator in VSCode öffnen und mit cmd+j in einTerminal wechseln:\r\n     - git init\r\n     - git add .\r\n     - git commit -m \"Initial commit\"\r\n(3) Github: die URL des Repositorys kopieren (z.B. https://github.com/username/ProjectNavigator.git)\r\n(4) VSCode-Terminal:\r\n     - git remote add origin https://github.com/username/ProjectNavigator.git\r\n     - git push -u origin master', '2025-03-06 18:04:30', '2025-03-06 18:30:47'),
(299, 'task_details', 'description', 82, 'de', '⚠️  <strong>Zu beachten</strong>:\r\nDer Befehl \'composer run dev\' führt jene Kommandos in der Datei composer.json aus, welche im Abschnitt \"scripts\" unter \"dev\" definiert sind. In meiner Installation, sind das:\r\n<pre><code>\r\n   “dev\": [\r\n        “Composer\\\\Config::disableProcessTimeout”,\r\n        “npx concurrently -c \\\"#93c5fd,#c4b5fd,#fb7185,#fdba74\\” \\\"php artisan serve\\” \\\"php artisan queue:listen --tries=1\\” \r\n                             \\\"php artisan pail --timeout=0\\” \\“npm run dev\\” --names=server,queue,logs,vite”\r\n   ],\r\n</code></pre>\r\nDies bedeutet, dass folgende Komponenten gestartet werden:\r\n(1) php artisan serve → startet Laravel Backend auf Port 8000\r\n(2) php artisan queue:listen --tries=1 → hört auf Laravel-Queues\r\n(3) php artisan pail --timeout=0 → startet Laravel Pail fürs Logging\r\n(4) npm run dev → startet Vite (= \'Laravel Frontend\') auf Port 5173\r\n\r\nAlternativ dazu kann man auch nur die Befehle (1) and (4) in einem Terminal starten (z.B. über die VSCode).\r\n👉 Im weiteren Projektverlauf werde ich das so machen.', '2025-03-07 07:46:37', '2025-03-07 08:22:06'),
(300, 'task_details', 'description', 83, 'de', '(1) php artisan make:migration create_tasks_table --create=tasks\r\n(2) Migrationsdatei bearbeiten und Tabellenspalten hinzufügen\r\n(3) php artisan migrate\r\n---\r\n(4) php artisan make:model Task\r\n(5) Model-Datei bearbeiten\r\n---\r\n(6) php artisan make:factory TaskFactory —model=Task\r\n(7) Factory-Datei bearbeiten\r\n\r\n⚠️ Hinweis:\r\nArtisan-Befehle können verschiedene Parameter haben, z.B. mit\r\nphp artisan make:model Aufgabe -m\r\nkönnen Sie eine Migration und ein Model in einem Schritt erstellen.\r\n\r\n👉 Verwenden Sie die folgenden Befehle für weitere Details:\r\n- php artisan list\r\n- php artisan help &lt;command&gt;', '2025-03-07 10:07:58', '2025-03-07 10:13:42'),
(301, 'task_details', 'description', 84, 'de', '(1) php artisan make:controller TaskController\r\n(2) edit and adapt controller file to your needs\r\n---\r\n(2) define a route in file routes/web.php and link the route to a function of TaskController\r\n---\r\n(3) define a view to be used in the route\'s function in TaskController: e.g., you can adapt the file resources/views/welcome.blade.php to your needs and use it in TaskController \r\n---\r\n(4) test it out :-)\r\n\r\n👉 Find out for yourself what each of these command alternatives will do:\r\n- php artisan make:controller TaskController --model=Task\r\n- php artisan make:controller TaskController --resource\r\n- php artisan make:controller TaskController --invokable\r\n- php artisan make:controller TaskController --api\r\n- php artisan make:controller TaskController --force', '2025-03-07 10:32:01', '2025-03-07 10:32:01'),
(302, 'tasks', 'title', 216, 'de', 'Upgrade von Laravel 11.34.2 auf Laravel 12', '2025-03-07 11:07:32', '2025-03-07 11:07:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `default_locale` char(2) NOT NULL DEFAULT 'en',
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_reporting` tinyint(1) NOT NULL DEFAULT 0,
  `default_project_id` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_default_project_id_foreign` (`default_project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONEN DER TABELLE `users`:
--   `default_project_id`
--       `projects` -> `id`
--

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_activity_type_id_foreign` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_types` (`id`),
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `scopes`
--
ALTER TABLE `scopes`
  ADD CONSTRAINT `scopes_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints der Tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `scopes` (`id`);

--
-- Constraints der Tabelle `task_details`
--
ALTER TABLE `task_details`
  ADD CONSTRAINT `task_details_task_detail_type_id_foreign` FOREIGN KEY (`task_detail_type_id`) REFERENCES `task_detail_types` (`id`),
  ADD CONSTRAINT `task_details_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

--
-- Constraints der Tabelle `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_default_project_id_foreign` FOREIGN KEY (`default_project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
