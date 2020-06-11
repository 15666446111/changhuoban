-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-06-11 07:06:14
-- 服务器版本： 8.0.19
-- PHP 版本： 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `chb3`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_config`
--

CREATE TABLE `admin_config` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
(1, 0, 23, '后台主页', 'fa-bar-chart', '/', NULL, NULL, '2020-04-28 06:45:39'),
(2, 0, 24, '权限管理', 'fa-tasks', NULL, NULL, NULL, '2020-04-28 06:45:39'),
(3, 2, 26, '后台用户', 'fa-users', 'auth/users', NULL, NULL, '2020-04-28 06:45:39'),
(4, 2, 27, '权限角色', 'fa-user', 'auth/roles', NULL, NULL, '2020-04-28 06:45:39'),
(5, 2, 28, '权限控制', 'fa-ban', 'auth/permissions', NULL, NULL, '2020-04-28 06:45:39'),
(6, 2, 29, '后台菜单', 'fa-bars', 'auth/menu', NULL, NULL, '2020-04-28 06:45:39'),
(7, 2, 30, '操作日志', 'fa-history', 'auth/logs', NULL, NULL, '2020-04-28 06:45:39'),
(8, 0, 1, '轮播管理', 'fa-photo', NULL, NULL, '2020-04-16 03:57:37', '2020-04-16 06:51:55'),
(9, 8, 2, '轮播类型', 'fa-digg', 'plug-types', NULL, '2020-04-16 03:58:36', '2020-04-16 06:51:55'),
(10, 8, 3, '轮播列表', 'fa-list-ol', 'plugs', NULL, '2020-04-16 03:59:07', '2020-04-16 06:51:55'),
(11, 0, 4, '分享管理', 'fa-slideshare', NULL, NULL, '2020-04-16 05:32:02', '2020-04-16 06:51:55'),
(12, 11, 5, '分享类型', 'fa-share-alt', 'share-types', NULL, '2020-04-16 05:32:31', '2020-04-16 06:51:55'),
(13, 11, 6, '分享列表', 'fa-share', 'shares', NULL, '2020-04-16 05:37:12', '2020-04-16 06:51:55'),
(14, 0, 10, '渠道管理', 'fa-user', NULL, NULL, '2020-04-16 06:32:41', '2020-04-21 05:41:06'),
(15, 14, 12, '代理管理', 'fa-bars', 'users', NULL, '2020-04-16 06:35:42', '2020-04-21 05:41:06'),
(16, 14, 11, '用户级别', 'fa-user-secret', 'user-groups', NULL, '2020-04-16 06:51:40', '2020-04-21 05:41:06'),
(17, 0, 7, '文章管理', 'fa-book', NULL, NULL, '2020-04-16 07:16:24', '2020-04-16 07:16:34'),
(18, 0, 21, '提现管理', 'fa-money', NULL, NULL, '2020-04-16 07:17:04', '2020-04-28 06:45:39'),
(19, 0, 18, '终端管理', 'fa-building', NULL, NULL, '2020-04-16 07:17:30', '2020-04-23 06:19:12'),
(20, 2, 25, '111', 'fa-bars', 'admin-users', NULL, '2020-04-17 04:00:57', '2020-04-28 06:45:39'),
(21, 17, 8, '文章类型', 'fa-columns', 'article-types', NULL, '2020-04-21 02:32:44', '2020-04-21 05:41:06'),
(22, 17, 9, '文章列表', 'fa-align-justify', 'articles', NULL, '2020-04-21 02:33:26', '2020-04-21 05:41:06'),
(23, 0, 13, '机具仓库', 'fa-cubes', NULL, NULL, '2020-04-21 05:40:45', '2020-04-21 05:41:06'),
(24, 23, 14, '机器类型', 'fa-thumb-tack', 'machines-types', NULL, '2020-04-21 05:43:21', '2020-04-23 06:19:12'),
(25, 23, 15, '机具厂商', 'fa-behance', 'machines-factories', NULL, '2020-04-21 05:48:37', '2020-04-23 06:19:12'),
(26, 23, 16, '机具型号', 'fa-android', 'machines-styles', NULL, '2020-04-21 05:53:19', '2020-04-23 06:19:12'),
(27, 23, 17, '机具列表', 'fa-arrows-alt', 'machines', NULL, '2020-04-21 07:03:28', '2020-04-23 06:19:12'),
(28, 0, 19, '交易管理', 'fa-trademark', NULL, NULL, '2020-04-23 06:18:54', '2020-04-23 06:19:12'),
(29, 28, 20, '交易列表', 'fa-dedent', 'trades', NULL, '2020-04-23 06:24:07', '2020-04-28 06:45:39'),
(30, 18, 22, '提现列表', 'fa-cny', 'withdraws', NULL, '2020-04-24 08:57:28', '2020-04-28 06:45:39'),
(31, 0, 34, '系统变量', 'fa-gears', 'env-manager', NULL, '2020-04-28 06:08:48', '2020-04-28 06:56:47'),
(32, 0, 31, '媒体管理', 'fa-folder-open-o', 'media', NULL, '2020-04-28 06:16:55', '2020-04-28 06:58:28'),
(33, 0, 33, '操作日志', 'fa-list-ul', 'logs', NULL, '2020-04-28 06:45:25', '2020-04-28 06:58:07'),
(34, 0, 32, 'Redis管理', 'fa-database', 'redis', NULL, '2020-04-28 06:56:29', '2020-04-28 06:57:08'),
(35, 0, 0, '操盘设置', 'fa-asterisk', 'settings', NULL, '2020-05-06 01:28:30', '2020-05-06 01:28:30');

-- --------------------------------------------------------

--
-- 表的结构 `admin_operation_log`
--

CREATE TABLE `admin_operation_log` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_operation_log`
--

INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin/auth/login', 'POST', '127.0.0.1', '{\"username\":\"admin\",\"password\":\"admin\",\"remember\":\"1\",\"_token\":\"o6cV7jLliOCGWLl0MmDgBlEmRTbSfSsPWtLcNAV1\"}', '2020-04-16 02:33:37', '2020-04-16 02:33:37'),
(2, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 02:33:37', '2020-04-16 02:33:37'),
(3, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 02:33:39', '2020-04-16 02:33:39'),
(4, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 03:55:07', '2020-04-16 03:55:07'),
(5, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:55:10', '2020-04-16 03:55:10'),
(6, 1, 'admin/auth/menu/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:55:13', '2020-04-16 03:55:13'),
(7, 1, 'admin/auth/menu/1', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u540e\\u53f0\\u4e3b\\u9875\",\"icon\":\"fa-bar-chart\",\"uri\":\"\\/\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:55:30', '2020-04-16 03:55:30'),
(8, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:55:30', '2020-04-16 03:55:30'),
(9, 1, 'admin/auth/menu/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:55:36', '2020-04-16 03:55:36'),
(10, 1, 'admin/auth/menu/2', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u6743\\u9650\\u7ba1\\u7406\",\"icon\":\"fa-tasks\",\"uri\":null,\"roles\":[\"1\",null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:55:42', '2020-04-16 03:55:42'),
(11, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:55:43', '2020-04-16 03:55:43'),
(12, 1, 'admin/auth/menu/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:55:55', '2020-04-16 03:55:55'),
(13, 1, 'admin/auth/menu/3', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"\\u540e\\u53f0\\u7528\\u6237\",\"icon\":\"fa-users\",\"uri\":\"auth\\/users\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:56:08', '2020-04-16 03:56:08'),
(14, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:56:08', '2020-04-16 03:56:08'),
(15, 1, 'admin/auth/menu/4/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:56:11', '2020-04-16 03:56:11'),
(16, 1, 'admin/auth/menu/4', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"\\u6743\\u9650\\u89d2\\u8272\",\"icon\":\"fa-user\",\"uri\":\"auth\\/roles\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:56:22', '2020-04-16 03:56:22'),
(17, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:56:22', '2020-04-16 03:56:22'),
(18, 1, 'admin/auth/menu/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:56:24', '2020-04-16 03:56:24'),
(19, 1, 'admin/auth/menu/5', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"\\u6743\\u9650\\u63a7\\u5236\",\"icon\":\"fa-ban\",\"uri\":\"auth\\/permissions\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:56:30', '2020-04-16 03:56:30'),
(20, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:56:30', '2020-04-16 03:56:30'),
(21, 1, 'admin/auth/menu/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:56:33', '2020-04-16 03:56:33'),
(22, 1, 'admin/auth/menu/6', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"\\u540e\\u53f0\\u83dc\\u5355\",\"icon\":\"fa-bars\",\"uri\":\"auth\\/menu\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:56:39', '2020-04-16 03:56:39'),
(23, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:56:39', '2020-04-16 03:56:39'),
(24, 1, 'admin/auth/menu/7/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:56:41', '2020-04-16 03:56:41'),
(25, 1, 'admin/auth/menu/7', 'PUT', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"icon\":\"fa-history\",\"uri\":\"auth\\/logs\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-16 03:56:48', '2020-04-16 03:56:48'),
(26, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:56:48', '2020-04-16 03:56:48'),
(27, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:56:51', '2020-04-16 03:56:51'),
(28, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:57:20', '2020-04-16 03:57:20'),
(29, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:57:25', '2020-04-16 03:57:25'),
(30, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u8f6e\\u64ad\\u7ba1\\u7406\",\"icon\":\"fa-photo\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 03:57:37', '2020-04-16 03:57:37'),
(31, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:57:37', '2020-04-16 03:57:37'),
(32, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"8\",\"title\":\"\\u8f6e\\u64ad\\u7c7b\\u578b\",\"icon\":\"fa-digg\",\"uri\":\"plug-types\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 03:58:36', '2020-04-16 03:58:36'),
(33, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:58:36', '2020-04-16 03:58:36'),
(34, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"8\",\"title\":\"\\u8f6e\\u64ad\\u5217\\u8868\",\"icon\":\"fa-list-ol\",\"uri\":\"plugs\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 03:59:07', '2020-04-16 03:59:07'),
(35, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:59:07', '2020-04-16 03:59:07'),
(36, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 03:59:10', '2020-04-16 03:59:10'),
(37, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:12', '2020-04-16 03:59:12'),
(38, 1, 'admin/plug-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:14', '2020-04-16 03:59:14'),
(39, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:17', '2020-04-16 03:59:17'),
(40, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:29', '2020-04-16 03:59:29'),
(41, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:42', '2020-04-16 03:59:42'),
(42, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:46', '2020-04-16 03:59:46'),
(43, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 03:59:52', '2020-04-16 03:59:52'),
(44, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:00:54', '2020-04-16 04:00:54'),
(45, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:01:13', '2020-04-16 04:01:13'),
(46, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:01:36', '2020-04-16 04:01:36'),
(47, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:01:59', '2020-04-16 04:01:59'),
(48, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:02:36', '2020-04-16 04:02:36'),
(49, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:02:39', '2020-04-16 04:02:39'),
(50, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:02:41', '2020-04-16 04:02:41'),
(51, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:02:42', '2020-04-16 04:02:42'),
(52, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:03:00', '2020-04-16 04:03:00'),
(53, 1, 'admin/plug-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:03:03', '2020-04-16 04:03:03'),
(54, 1, 'admin/plug-types', 'POST', '127.0.0.1', '{\"name\":\"\\u9996\\u9875\\u8f6e\\u64ad\\u56fe\",\"active\":\"on\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plug-types\"}', '2020-04-16 04:03:12', '2020-04-16 04:03:12'),
(55, 1, 'admin/plug-types', 'GET', '127.0.0.1', '[]', '2020-04-16 04:03:12', '2020-04-16 04:03:12'),
(56, 1, 'admin/plug-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:03:15', '2020-04-16 04:03:15'),
(57, 1, 'admin/plug-types', 'POST', '127.0.0.1', '{\"name\":\"\\u8d22\\u5546\\u8f6e\\u64ad\\u56fe\",\"active\":\"on\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plug-types\"}', '2020-04-16 04:03:21', '2020-04-16 04:03:21'),
(58, 1, 'admin/plug-types', 'GET', '127.0.0.1', '[]', '2020-04-16 04:03:21', '2020-04-16 04:03:21'),
(59, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:03:24', '2020-04-16 04:03:24'),
(60, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:03:36', '2020-04-16 04:03:36'),
(61, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:06:05', '2020-04-16 04:06:05'),
(62, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:06:06', '2020-04-16 04:06:06'),
(63, 1, 'admin/plug-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:06:08', '2020-04-16 04:06:08'),
(64, 1, 'admin/plug-types/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:09:43', '2020-04-16 04:09:43'),
(65, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:09:45', '2020-04-16 04:09:45'),
(66, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:09:47', '2020-04-16 04:09:47'),
(67, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:10:46', '2020-04-16 04:10:46'),
(68, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:11:26', '2020-04-16 04:11:26'),
(69, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:11:39', '2020-04-16 04:11:39'),
(70, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:11:54', '2020-04-16 04:11:54'),
(71, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:12:19', '2020-04-16 04:12:19'),
(72, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:12:38', '2020-04-16 04:12:38'),
(73, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:12:57', '2020-04-16 04:12:57'),
(74, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:13:07', '2020-04-16 04:13:07'),
(75, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:13:13', '2020-04-16 04:13:13'),
(76, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:14:37', '2020-04-16 04:14:37'),
(77, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:15:02', '2020-04-16 04:15:02'),
(78, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:15:05', '2020-04-16 04:15:05'),
(79, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:20:19', '2020-04-16 04:20:19'),
(80, 1, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-16 04:24:04', '2020-04-16 04:24:04'),
(81, 1, 'admin/plugs', 'POST', '127.0.0.1', '{\"name\":null,\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"0\",\"href\":\"#\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 04:24:43', '2020-04-16 04:24:43'),
(82, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 04:24:43', '2020-04-16 04:24:43'),
(83, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:24:47', '2020-04-16 04:24:47'),
(84, 1, 'admin/plugs/1', 'PUT', '127.0.0.1', '{\"name\":\"\\u8fd9\\u91cc\\u662f\\u6d4b\\u8bd5\\u8f6e\\u64ad\\u56fe\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"0\",\"href\":\"#\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-16 04:24:58', '2020-04-16 04:24:58'),
(85, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 04:24:58', '2020-04-16 04:24:58'),
(86, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:25:03', '2020-04-16 04:25:03'),
(87, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:25:04', '2020-04-16 04:25:04'),
(88, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:26:44', '2020-04-16 04:26:44'),
(89, 1, 'admin/plug-types/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:26:50', '2020-04-16 04:26:50'),
(90, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:26:53', '2020-04-16 04:26:53'),
(91, 1, 'admin/plug-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:26:55', '2020-04-16 04:26:55'),
(92, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:27:14', '2020-04-16 04:27:14'),
(93, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:27:18', '2020-04-16 04:27:18'),
(94, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-16 04:28:10', '2020-04-16 04:28:10'),
(95, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-16 04:35:04', '2020-04-16 04:35:04'),
(96, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:35:06', '2020-04-16 04:35:06'),
(97, 1, 'admin/plug-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:35:09', '2020-04-16 04:35:09'),
(98, 1, 'admin/plug-types/1', 'GET', '127.0.0.1', '[]', '2020-04-16 04:35:17', '2020-04-16 04:35:17'),
(99, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:35:21', '2020-04-16 04:35:21'),
(100, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:35:24', '2020-04-16 04:35:24'),
(101, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:35:26', '2020-04-16 04:35:26'),
(102, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '[]', '2020-04-16 04:45:12', '2020-04-16 04:45:12'),
(103, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:45:51', '2020-04-16 04:45:51'),
(104, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 04:46:19', '2020-04-16 04:46:19'),
(105, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-16 04:46:28', '2020-04-16 04:46:28'),
(106, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"name\":\"\\u6d4b\\u8bd5\",\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:46:34', '2020-04-16 04:46:34'),
(107, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 04:46:35', '2020-04-16 04:46:35'),
(108, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:29:36', '2020-04-16 05:29:36'),
(109, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:29:39', '2020-04-16 05:29:39'),
(110, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:29:42', '2020-04-16 05:29:42'),
(111, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:29:43', '2020-04-16 05:29:43'),
(112, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:31:47', '2020-04-16 05:31:47'),
(113, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u5206\\u4eab\\u7ba1\\u7406\",\"icon\":\"fa-slideshare\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 05:32:02', '2020-04-16 05:32:02'),
(114, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 05:32:02', '2020-04-16 05:32:02'),
(115, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"11\",\"title\":\"\\u5206\\u4eab\\u7c7b\\u578b\",\"icon\":\"fa-share-alt\",\"uri\":\"share-types\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 05:32:31', '2020-04-16 05:32:31'),
(116, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 05:32:31', '2020-04-16 05:32:31'),
(117, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 05:32:34', '2020-04-16 05:32:34'),
(118, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:32:36', '2020-04-16 05:32:36'),
(119, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-16 05:33:53', '2020-04-16 05:33:53'),
(120, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-16 05:34:14', '2020-04-16 05:34:14'),
(121, 1, 'admin/share-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:34:22', '2020-04-16 05:34:22'),
(122, 1, 'admin/share-types', 'POST', '127.0.0.1', '{\"name\":\"\\u56e2\\u961f\\u6269\\u5c55\",\"active\":\"on\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/share-types\"}', '2020-04-16 05:34:28', '2020-04-16 05:34:28'),
(123, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-16 05:34:29', '2020-04-16 05:34:29'),
(124, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-16 05:35:04', '2020-04-16 05:35:04'),
(125, 1, 'admin/share-types/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:35:08', '2020-04-16 05:35:08'),
(126, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:35:10', '2020-04-16 05:35:10'),
(127, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:35:12', '2020-04-16 05:35:12'),
(128, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:35:15', '2020-04-16 05:35:15'),
(129, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:35:22', '2020-04-16 05:35:22'),
(130, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:36:33', '2020-04-16 05:36:33'),
(131, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"11\",\"title\":\"\\u5206\\u4eab\\u5217\\u8868\",\"icon\":\"fa-share\",\"uri\":\"shares\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 05:37:12', '2020-04-16 05:37:12'),
(132, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 05:37:12', '2020-04-16 05:37:12'),
(133, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 05:37:24', '2020-04-16 05:37:24'),
(134, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:37:26', '2020-04-16 05:37:26'),
(135, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:38:08', '2020-04-16 05:38:08'),
(136, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:38:10', '2020-04-16 05:38:10'),
(137, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:38:12', '2020-04-16 05:38:12'),
(138, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:39:56', '2020-04-16 05:39:56'),
(139, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:40:44', '2020-04-16 05:40:44'),
(140, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:44:58', '2020-04-16 05:44:58'),
(141, 1, 'admin/shares/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 05:45:00', '2020-04-16 05:45:00'),
(142, 1, 'admin/shares/create', 'GET', '127.0.0.1', '[]', '2020-04-16 05:46:58', '2020-04-16 05:46:58'),
(143, 1, 'admin/shares', 'POST', '127.0.0.1', '{\"title\":\"\\u6d4b\\u8bd5\\u5206\\u4eab\\u6807\\u9898\",\"active\":\"on\",\"type_id\":\"1\",\"sort\":\"0\",\"code_size\":\"100\",\"code_x\":\"100\",\"code_y\":\"100\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 05:48:21', '2020-04-16 05:48:21'),
(144, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:48:21', '2020-04-16 05:48:21'),
(145, 1, 'admin/shares/1', 'PUT', '127.0.0.1', '{\"active\":\"off\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\"}', '2020-04-16 05:48:23', '2020-04-16 05:48:23'),
(146, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:48:25', '2020-04-16 05:48:25'),
(147, 1, 'admin/shares/1', 'PUT', '127.0.0.1', '{\"active\":\"on\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_method\":\"PUT\"}', '2020-04-16 05:48:27', '2020-04-16 05:48:27'),
(148, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 05:49:58', '2020-04-16 05:49:58'),
(149, 1, 'admin/shares/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:02:19', '2020-04-16 06:02:19'),
(150, 1, 'admin/shares/1', 'GET', '127.0.0.1', '[]', '2020-04-16 06:02:26', '2020-04-16 06:02:26'),
(151, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:03:54', '2020-04-16 06:03:54'),
(152, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:08:29', '2020-04-16 06:08:29'),
(153, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:08:34', '2020-04-16 06:08:34'),
(154, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '[]', '2020-04-16 06:09:14', '2020-04-16 06:09:14'),
(155, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '[]', '2020-04-16 06:09:23', '2020-04-16 06:09:23'),
(156, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '[]', '2020-04-16 06:09:50', '2020-04-16 06:09:50'),
(157, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '[]', '2020-04-16 06:10:25', '2020-04-16 06:10:25'),
(158, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:11:28', '2020-04-16 06:11:28'),
(159, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:11:37', '2020-04-16 06:11:37'),
(160, 1, 'admin/share-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:11:40', '2020-04-16 06:11:40'),
(161, 1, 'admin/share-types', 'POST', '127.0.0.1', '{\"name\":\"\\u5546\\u6237\\u6ce8\\u518c\",\"active\":\"on\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/share-types\"}', '2020-04-16 06:11:50', '2020-04-16 06:11:50'),
(162, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-16 06:11:50', '2020-04-16 06:11:50'),
(163, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:12:00', '2020-04-16 06:12:00'),
(164, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:13:39', '2020-04-16 06:13:39'),
(165, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:13:40', '2020-04-16 06:13:40'),
(166, 1, 'admin/share-types/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:13:50', '2020-04-16 06:13:50'),
(167, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:13:55', '2020-04-16 06:13:55'),
(168, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:13:57', '2020-04-16 06:13:57'),
(169, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:14:04', '2020-04-16 06:14:04'),
(170, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:14:54', '2020-04-16 06:14:54'),
(171, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 06:15:04', '2020-04-16 06:15:04'),
(172, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-16 06:15:13', '2020-04-16 06:15:13'),
(173, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:15:17', '2020-04-16 06:15:17'),
(174, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-16 06:15:33', '2020-04-16 06:15:33'),
(175, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:16:02', '2020-04-16 06:16:02'),
(176, 1, 'admin/plug-types', 'GET', '127.0.0.1', '[]', '2020-04-16 06:16:19', '2020-04-16 06:16:19'),
(177, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:16:23', '2020-04-16 06:16:23'),
(178, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:31:37', '2020-04-16 06:31:37'),
(179, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:31:42', '2020-04-16 06:31:42'),
(180, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:31:46', '2020-04-16 06:31:46'),
(181, 1, 'admin/shares/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:31:49', '2020-04-16 06:31:49'),
(182, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:31:56', '2020-04-16 06:31:56'),
(183, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:32:14', '2020-04-16 06:32:14'),
(184, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u6e20\\u9053\\u7ba1\\u7406\",\"icon\":\"fa-user\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 06:32:41', '2020-04-16 06:32:41'),
(185, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 06:32:41', '2020-04-16 06:32:41'),
(186, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 06:32:45', '2020-04-16 06:32:45'),
(187, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"14\",\"title\":\"\\u4ee3\\u7406\\u7ba1\\u7406\",\"icon\":\"fa-bars\",\"uri\":\"users\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 06:35:42', '2020-04-16 06:35:42'),
(188, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 06:35:42', '2020-04-16 06:35:42'),
(189, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 06:35:46', '2020-04-16 06:35:46'),
(190, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:35:48', '2020-04-16 06:35:48'),
(191, 1, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-16 06:37:14', '2020-04-16 06:37:14'),
(192, 1, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-16 06:37:24', '2020-04-16 06:37:24'),
(193, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:49:35', '2020-04-16 06:49:35'),
(194, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:51:10', '2020-04-16 06:51:10'),
(195, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"14\",\"title\":\"\\u7528\\u6237\\u7ea7\\u522b\",\"icon\":\"fa-user-secret\",\"uri\":\"user-groups\",\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 06:51:40', '2020-04-16 06:51:40'),
(196, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 06:51:40', '2020-04-16 06:51:40'),
(197, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2020-04-16 06:51:55', '2020-04-16 06:51:55'),
(198, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:51:56', '2020-04-16 06:51:56'),
(199, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 06:51:57', '2020-04-16 06:51:57'),
(200, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:51:59', '2020-04-16 06:51:59'),
(201, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:52:02', '2020-04-16 06:52:02'),
(202, 1, 'admin/user-groups', 'GET', '127.0.0.1', '[]', '2020-04-16 06:53:40', '2020-04-16 06:53:40'),
(203, 1, 'admin/user-groups/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:53:43', '2020-04-16 06:53:43'),
(204, 1, 'admin/user-groups/create', 'GET', '127.0.0.1', '[]', '2020-04-16 06:54:23', '2020-04-16 06:54:23'),
(205, 1, 'admin/user-groups/create', 'GET', '127.0.0.1', '[]', '2020-04-16 06:54:59', '2020-04-16 06:54:59'),
(206, 1, 'admin/user-groups', 'POST', '127.0.0.1', '{\"name\":\"\\u666e\\u901a\\u7528\\u6237\",\"level\":\"0\",\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 06:55:06', '2020-04-16 06:55:06'),
(207, 1, 'admin/user-groups', 'GET', '127.0.0.1', '[]', '2020-04-16 06:55:06', '2020-04-16 06:55:06'),
(208, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:11', '2020-04-16 06:55:11'),
(209, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:14', '2020-04-16 06:55:14'),
(210, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:16', '2020-04-16 06:55:16'),
(211, 1, 'admin/user-groups', 'GET', '127.0.0.1', '[]', '2020-04-16 06:55:29', '2020-04-16 06:55:29'),
(212, 1, 'admin/user-groups/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:33', '2020-04-16 06:55:33'),
(213, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:35', '2020-04-16 06:55:35'),
(214, 1, 'admin/user-groups/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:37', '2020-04-16 06:55:37'),
(215, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:39', '2020-04-16 06:55:39'),
(216, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:43', '2020-04-16 06:55:43'),
(217, 1, 'admin/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:55:47', '2020-04-16 06:55:47'),
(218, 1, 'admin/users/create', 'GET', '127.0.0.1', '[]', '2020-04-16 06:56:45', '2020-04-16 06:56:45'),
(219, 1, 'admin/users/create', 'GET', '127.0.0.1', '[]', '2020-04-16 06:58:51', '2020-04-16 06:58:51'),
(220, 1, 'admin/users/create', 'GET', '127.0.0.1', '[]', '2020-04-16 06:59:05', '2020-04-16 06:59:05'),
(221, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:59:21', '2020-04-16 06:59:21'),
(222, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 06:59:21', '2020-04-16 06:59:21'),
(223, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:01:11', '2020-04-16 07:01:11'),
(224, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:01:12', '2020-04-16 07:01:12'),
(225, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:01:13', '2020-04-16 07:01:13'),
(226, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:13:53', '2020-04-16 07:13:53'),
(227, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:13:57', '2020-04-16 07:13:57'),
(228, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:14:00', '2020-04-16 07:14:00'),
(229, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:15:08', '2020-04-16 07:15:08'),
(230, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:15:18', '2020-04-16 07:15:18'),
(231, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:15:18', '2020-04-16 07:15:18'),
(232, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:15:20', '2020-04-16 07:15:20'),
(233, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:15:26', '2020-04-16 07:15:26'),
(234, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u6587\\u7ae0\\u7ba1\\u7406\",\"icon\":\"fa-book\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 07:16:24', '2020-04-16 07:16:24'),
(235, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 07:16:24', '2020-04-16 07:16:24'),
(236, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2020-04-16 07:16:34', '2020-04-16 07:16:34'),
(237, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:16:34', '2020-04-16 07:16:34'),
(238, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 07:16:47', '2020-04-16 07:16:47'),
(239, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u63d0\\u73b0\\u7ba1\\u7406\",\"icon\":\"fa-money\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 07:17:04', '2020-04-16 07:17:04'),
(240, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 07:17:04', '2020-04-16 07:17:04'),
(241, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":18},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2020-04-16 07:17:11', '2020-04-16 07:17:11'),
(242, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:17:11', '2020-04-16 07:17:11'),
(243, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u7ec8\\u7aef\\u7ba1\\u7406\",\"icon\":\"fa-building\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\"}', '2020-04-16 07:17:30', '2020-04-16 07:17:30'),
(244, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 07:17:30', '2020-04-16 07:17:30'),
(245, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"qI5cQH4u1AQ9quKUyW9exrxx1WHhLR1ldP7CxVT3\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":19},{\\\"id\\\":18},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2020-04-16 07:17:51', '2020-04-16 07:17:51'),
(246, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:17:51', '2020-04-16 07:17:51'),
(247, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-16 07:50:05', '2020-04-16 07:50:05'),
(248, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:50:08', '2020-04-16 07:50:08'),
(249, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:50:09', '2020-04-16 07:50:09'),
(250, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 07:50:09', '2020-04-16 07:50:09'),
(251, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 08:14:37', '2020-04-16 08:14:37'),
(252, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-16 08:14:39', '2020-04-16 08:14:39'),
(253, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-16 08:27:54', '2020-04-16 08:27:54'),
(254, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-17 00:41:10', '2020-04-17 00:41:10'),
(255, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 00:41:13', '2020-04-17 00:41:13'),
(256, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 00:41:15', '2020-04-17 00:41:15'),
(257, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 01:07:48', '2020-04-17 01:07:48'),
(258, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 01:08:15', '2020-04-17 01:08:15'),
(259, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:09:45', '2020-04-17 03:09:45'),
(260, 1, 'admin/auth/roles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:09:46', '2020-04-17 03:09:46'),
(261, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:10:22', '2020-04-17 03:10:22'),
(262, 1, 'admin/auth/roles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:10:30', '2020-04-17 03:10:30'),
(263, 1, 'admin/auth/roles', 'POST', '127.0.0.1', '{\"slug\":\"\\u64cd\\u76d8\",\"name\":\"\\u64cd\\u76d8\",\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/roles\"}', '2020-04-17 03:10:51', '2020-04-17 03:10:51'),
(264, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2020-04-17 03:10:52', '2020-04-17 03:10:52'),
(265, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:10:55', '2020-04-17 03:10:55'),
(266, 1, 'admin/auth/roles/2', 'PUT', '127.0.0.1', '{\"slug\":\"\\u64cd\\u76d8\",\"name\":\"\\u64cd\\u76d8\",\"permissions\":[\"2\",null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/roles\"}', '2020-04-17 03:10:59', '2020-04-17 03:10:59'),
(267, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2020-04-17 03:10:59', '2020-04-17 03:10:59'),
(268, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:11:03', '2020-04-17 03:11:03'),
(269, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:11:05', '2020-04-17 03:11:05'),
(270, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:11:07', '2020-04-17 03:11:07'),
(271, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:20:41', '2020-04-17 03:20:41'),
(272, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:20:42', '2020-04-17 03:20:42'),
(273, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 03:31:26', '2020-04-17 03:31:26'),
(274, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:45:04', '2020-04-17 03:45:04'),
(275, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2020-04-17 03:45:08', '2020-04-17 03:45:08'),
(276, 1, 'admin/auth/users/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:45:23', '2020-04-17 03:45:23'),
(277, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:56:11', '2020-04-17 03:56:11'),
(278, 1, 'admin/auth/menu/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:56:26', '2020-04-17 03:56:26'),
(279, 1, 'admin/auth/menu/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-17 03:59:44', '2020-04-17 03:59:44'),
(280, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 03:59:55', '2020-04-17 03:59:55'),
(281, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:00:43', '2020-04-17 04:00:43'),
(282, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"2\",\"title\":\"111\",\"icon\":\"fa-bars\",\"uri\":\"admin-users\",\"roles\":[null],\"permission\":null,\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 04:00:57', '2020-04-17 04:00:57'),
(283, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-17 04:00:57', '2020-04-17 04:00:57'),
(284, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-17 04:01:01', '2020-04-17 04:01:01'),
(285, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-17 04:01:58', '2020-04-17 04:01:58'),
(286, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:02:02', '2020-04-17 04:02:02'),
(287, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:02:04', '2020-04-17 04:02:04'),
(288, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:02:11', '2020-04-17 04:02:11'),
(289, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-17 04:03:20', '2020-04-17 04:03:20'),
(290, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:03:33', '2020-04-17 04:03:33'),
(291, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:04:18', '2020-04-17 04:04:18'),
(292, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:04:22', '2020-04-17 04:04:22'),
(293, 1, 'admin/admin-users/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:04:25', '2020-04-17 04:04:25'),
(294, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:04:34', '2020-04-17 04:04:34'),
(295, 1, 'admin/admin-users/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:04:37', '2020-04-17 04:04:37'),
(296, 1, 'admin/admin-users/1', 'GET', '127.0.0.1', '[]', '2020-04-17 04:05:51', '2020-04-17 04:05:51'),
(297, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:05:55', '2020-04-17 04:05:55'),
(298, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 04:05:56', '2020-04-17 04:05:56'),
(299, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:14:04', '2020-04-17 04:14:04'),
(300, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:14:17', '2020-04-17 04:14:17'),
(301, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:14:24', '2020-04-17 04:14:24'),
(302, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:14:26', '2020-04-17 04:14:26'),
(303, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:14:27', '2020-04-17 04:14:27'),
(304, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:14:28', '2020-04-17 04:14:28'),
(305, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:15:15', '2020-04-17 04:15:15'),
(306, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:15:32', '2020-04-17 04:15:32'),
(307, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:15:40', '2020-04-17 04:15:40'),
(308, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:15:46', '2020-04-17 04:15:46'),
(309, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"admin\",\"name\":null,\"operate\":\"CP1002020041712154663\",\"password\":\"admin\",\"password_confirmation\":null,\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 04:16:12', '2020-04-17 04:16:12'),
(310, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 04:16:12', '2020-04-17 04:16:12'),
(311, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:19:28', '2020-04-17 05:19:28'),
(312, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:19:29', '2020-04-17 05:19:29'),
(313, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 05:44:41', '2020-04-17 05:44:41'),
(314, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:44:44', '2020-04-17 05:44:44'),
(315, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:44:48', '2020-04-17 05:44:48'),
(316, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:56:13', '2020-04-17 05:56:13'),
(317, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:56:21', '2020-04-17 05:56:21'),
(318, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-17 05:57:39', '2020-04-17 05:57:39'),
(319, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-17 05:57:50', '2020-04-17 05:57:50'),
(320, 1, 'admin/plugs/1', 'PUT', '127.0.0.1', '{\"name\":\"\\u8fd9\\u91cc\\u662f\\u6d4b\\u8bd5\\u8f6e\\u64ad\\u56fe\",\"active\":\"on\",\"type_id\":\"1\",\"sort\":\"0\",\"href\":\"#\",\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_method\":\"PUT\"}', '2020-04-17 05:57:58', '2020-04-17 05:57:58'),
(321, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-17 05:57:58', '2020-04-17 05:57:58'),
(322, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-17 05:58:00', '2020-04-17 05:58:00'),
(323, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:58:03', '2020-04-17 05:58:03'),
(324, 1, 'admin/plugs/1', 'PUT', '127.0.0.1', '{\"name\":\"\\u8fd9\\u91cc\\u662f\\u6d4b\\u8bd5\\u8f6e\\u64ad\\u56fe\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"0\",\"href\":\"#\",\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-17 05:58:06', '2020-04-17 05:58:06'),
(325, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-17 05:58:06', '2020-04-17 05:58:06'),
(326, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-17 05:58:07', '2020-04-17 05:58:07'),
(327, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-17 05:58:25', '2020-04-17 05:58:25'),
(328, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 05:58:27', '2020-04-17 05:58:27'),
(329, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-17 05:58:54', '2020-04-17 05:58:54'),
(330, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:00:01', '2020-04-17 06:00:01'),
(331, 1, 'admin/shares/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:00:03', '2020-04-17 06:00:03'),
(332, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-17 06:00:03', '2020-04-17 06:00:03'),
(333, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-17 06:00:20', '2020-04-17 06:00:20'),
(334, 1, 'admin/shares/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:00:24', '2020-04-17 06:00:24'),
(335, 1, 'admin/shares/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:00:37', '2020-04-17 06:00:37'),
(336, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:01:15', '2020-04-17 06:01:15'),
(337, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:01:17', '2020-04-17 06:01:17'),
(338, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"admin\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714011771\",\"password\":\"admin\",\"password_confirmation\":\"12345678\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/admin-users\"}', '2020-04-17 06:01:56', '2020-04-17 06:01:56'),
(339, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:01:57', '2020-04-17 06:01:57'),
(340, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714011771\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:02:37', '2020-04-17 06:02:37'),
(341, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:02:38', '2020-04-17 06:02:38'),
(342, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714011771\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:04:11', '2020-04-17 06:04:11'),
(343, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-17 06:04:40', '2020-04-17 06:04:40'),
(344, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:04:50', '2020-04-17 06:04:50'),
(345, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714045026\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/admin-users\"}', '2020-04-17 06:05:08', '2020-04-17 06:05:08');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(346, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:05:08', '2020-04-17 06:05:08'),
(347, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714045026\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:07:18', '2020-04-17 06:07:18'),
(348, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-17 06:09:16', '2020-04-17 06:09:16'),
(349, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:09:19', '2020-04-17 06:09:19'),
(350, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714091966\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/admin-users\"}', '2020-04-17 06:09:36', '2020-04-17 06:09:36'),
(351, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:09:36', '2020-04-17 06:09:36'),
(352, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714091966\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:10:30', '2020-04-17 06:10:30'),
(353, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:10:30', '2020-04-17 06:10:30'),
(354, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714091966\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:10:59', '2020-04-17 06:10:59'),
(355, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:10:59', '2020-04-17 06:10:59'),
(356, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714091966\",\"password\":\"123456\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:11:52', '2020-04-17 06:11:52'),
(357, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '[]', '2020-04-17 06:11:52', '2020-04-17 06:11:52'),
(358, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714091966\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\"}', '2020-04-17 06:12:29', '2020-04-17 06:12:29'),
(359, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-17 06:12:29', '2020-04-17 06:12:29'),
(360, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:12:38', '2020-04-17 06:12:38'),
(361, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:13:19', '2020-04-17 06:13:19'),
(362, 1, 'admin/admin-users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:13:21', '2020-04-17 06:13:21'),
(363, 1, 'admin/admin-users', 'POST', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714132163\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[null],\"permissions\":[null],\"_token\":\"PJ5WPlG8Jav6jg96zu7s7RbEeZkUfqbCYGKqO0zE\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/admin-users\"}', '2020-04-17 06:13:40', '2020-04-17 06:13:40'),
(364, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-17 06:13:40', '2020-04-17 06:13:40'),
(365, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:13:46', '2020-04-17 06:13:46'),
(366, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-17 06:13:47', '2020-04-17 06:13:47'),
(367, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-18 06:34:40', '2020-04-18 06:34:40'),
(368, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 06:34:50', '2020-04-18 06:34:50'),
(369, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 06:34:52', '2020-04-18 06:34:52'),
(370, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:04:24', '2020-04-18 09:04:24'),
(371, 3, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-18 09:04:31', '2020-04-18 09:04:31'),
(372, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:04:36', '2020-04-18 09:04:36'),
(373, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:04:41', '2020-04-18 09:04:41'),
(374, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-18 09:05:21', '2020-04-18 09:05:21'),
(375, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-18 09:05:24', '2020-04-18 09:05:24'),
(376, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:05:28', '2020-04-18 09:05:28'),
(377, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:05:34', '2020-04-18 09:05:34'),
(378, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:05:39', '2020-04-18 09:05:39'),
(379, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:05:41', '2020-04-18 09:05:41'),
(380, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:07:21', '2020-04-18 09:07:21'),
(381, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:07:28', '2020-04-18 09:07:28'),
(382, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:07:29', '2020-04-18 09:07:29'),
(383, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:07:30', '2020-04-18 09:07:30'),
(384, 1, 'admin/auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"\\u8f6e\\u64ad\\u56fe\",\"name\":\"\\u8f6e\\u64ad\\u56fe\",\"http_method\":[\"GET\",null],\"http_path\":\"\\/plugs*\",\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/permissions\"}', '2020-04-18 09:08:17', '2020-04-18 09:08:17'),
(385, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '[]', '2020-04-18 09:08:17', '2020-04-18 09:08:17'),
(386, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:08:22', '2020-04-18 09:08:22'),
(387, 1, 'admin/admin-users/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:08:24', '2020-04-18 09:08:24'),
(388, 1, 'admin/admin-users/3', 'PUT', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"operate\":\"CP1002020041714132163\",\"password\":\"$2y$10$OYWMPxZht73.\\/TgATcFnJeDyfGFrsdmFZ39TINBkaRKbZIfVBpB7u\",\"password_confirmation\":\"$2y$10$OYWMPxZht73.\\/TgATcFnJeDyfGFrsdmFZ39TINBkaRKbZIfVBpB7u\",\"roles\":[null],\"permissions\":[\"6\",null],\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/admin-users\"}', '2020-04-18 09:08:29', '2020-04-18 09:08:29'),
(389, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-18 09:08:29', '2020-04-18 09:08:29'),
(390, 3, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-18 09:08:35', '2020-04-18 09:08:35'),
(391, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:08:38', '2020-04-18 09:08:38'),
(392, 3, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:08:57', '2020-04-18 09:08:57'),
(393, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:02', '2020-04-18 09:09:02'),
(394, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:06', '2020-04-18 09:09:06'),
(395, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:08', '2020-04-18 09:09:08'),
(396, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:09', '2020-04-18 09:09:09'),
(397, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:14', '2020-04-18 09:09:14'),
(398, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:15', '2020-04-18 09:09:15'),
(399, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:48', '2020-04-18 09:09:48'),
(400, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:52', '2020-04-18 09:09:52'),
(401, 3, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:55', '2020-04-18 09:09:55'),
(402, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:09:58', '2020-04-18 09:09:58'),
(403, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-18 09:11:57', '2020-04-18 09:11:57'),
(404, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-18 09:11:59', '2020-04-18 09:11:59'),
(405, 1, 'admin/admin-users', 'GET', '127.0.0.1', '[]', '2020-04-18 09:12:10', '2020-04-18 09:12:10'),
(406, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:12:13', '2020-04-18 09:12:13'),
(407, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:13:47', '2020-04-18 09:13:47'),
(408, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:18:57', '2020-04-18 09:18:57'),
(409, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:21:06', '2020-04-18 09:21:06'),
(410, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:23:51', '2020-04-18 09:23:51'),
(411, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:25:21', '2020-04-18 09:25:21'),
(412, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:26:18', '2020-04-18 09:26:18'),
(413, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:26:27', '2020-04-18 09:26:27'),
(414, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:26:41', '2020-04-18 09:26:41'),
(415, 3, 'admin/plugs', 'POST', '127.0.0.1', '{\"name\":\"212321\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"3\",\"href\":\"#\",\"_token\":\"7hdU7nujANyX6Qo0QjeXQhQxpYlZlS5W7I9yRTuR\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-18 09:28:41', '2020-04-18 09:28:41'),
(416, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:28:47', '2020-04-18 09:28:47'),
(417, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:29:02', '2020-04-18 09:29:02'),
(418, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:29:08', '2020-04-18 09:29:08'),
(419, 1, 'admin/auth/permissions/6/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:29:23', '2020-04-18 09:29:23'),
(420, 1, 'admin/auth/permissions/6', 'PUT', '127.0.0.1', '{\"slug\":\"\\u8f6e\\u64ad\\u56fe\",\"name\":\"\\u8f6e\\u64ad\\u56fe\",\"http_method\":[\"GET\",\"POST\",\"PUT\",\"DELETE\",null],\"http_path\":\"\\/plugs*\",\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/permissions\"}', '2020-04-18 09:29:43', '2020-04-18 09:29:43'),
(421, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '[]', '2020-04-18 09:29:43', '2020-04-18 09:29:43'),
(422, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:29:47', '2020-04-18 09:29:47'),
(423, 3, 'admin/plugs', 'POST', '127.0.0.1', '{\"name\":\"222\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"3\",\"href\":\"#\",\"_token\":\"7hdU7nujANyX6Qo0QjeXQhQxpYlZlS5W7I9yRTuR\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-18 09:29:53', '2020-04-18 09:29:53'),
(424, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:29:53', '2020-04-18 09:29:53'),
(425, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:29:55', '2020-04-18 09:29:55'),
(426, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:31:39', '2020-04-18 09:31:39'),
(427, 3, 'admin/plugs', 'POST', '127.0.0.1', '{\"name\":\"333\",\"operate\":null,\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"3\",\"href\":\"#\",\"_token\":\"7hdU7nujANyX6Qo0QjeXQhQxpYlZlS5W7I9yRTuR\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-18 09:31:50', '2020-04-18 09:31:50'),
(428, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:31:50', '2020-04-18 09:31:50'),
(429, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:32:18', '2020-04-18 09:32:18'),
(430, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:32:19', '2020-04-18 09:32:19'),
(431, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:32:36', '2020-04-18 09:32:36'),
(432, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:32:38', '2020-04-18 09:32:38'),
(433, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:33:05', '2020-04-18 09:33:05'),
(434, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:34:16', '2020-04-18 09:34:16'),
(435, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:34:27', '2020-04-18 09:34:27'),
(436, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:34:32', '2020-04-18 09:34:32'),
(437, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:34:39', '2020-04-18 09:34:39'),
(438, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:35:44', '2020-04-18 09:35:44'),
(439, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:35:54', '2020-04-18 09:35:54'),
(440, 3, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:36:00', '2020-04-18 09:36:00'),
(441, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:36:05', '2020-04-18 09:36:05'),
(442, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"name\":\"222\"}', '2020-04-18 09:36:16', '2020-04-18 09:36:16'),
(443, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"name\":\"2\"}', '2020-04-18 09:36:19', '2020-04-18 09:36:19'),
(444, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"name\":null}', '2020-04-18 09:36:23', '2020-04-18 09:36:23'),
(445, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:36:26', '2020-04-18 09:36:26'),
(446, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:36:29', '2020-04-18 09:36:29'),
(447, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:36:53', '2020-04-18 09:36:53'),
(448, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:36:55', '2020-04-18 09:36:55'),
(449, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:36:58', '2020-04-18 09:36:58'),
(450, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:37:01', '2020-04-18 09:37:01'),
(451, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-18 09:37:05', '2020-04-18 09:37:05'),
(452, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:37:23', '2020-04-18 09:37:23'),
(453, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:37:26', '2020-04-18 09:37:26'),
(454, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:38:01', '2020-04-18 09:38:01'),
(455, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:38:02', '2020-04-18 09:38:02'),
(456, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:38:28', '2020-04-18 09:38:28'),
(457, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:38:31', '2020-04-18 09:38:31'),
(458, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:41:50', '2020-04-18 09:41:50'),
(459, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:42:00', '2020-04-18 09:42:00'),
(460, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:43:17', '2020-04-18 09:43:17'),
(461, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:43:35', '2020-04-18 09:43:35'),
(462, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:43:54', '2020-04-18 09:43:54'),
(463, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:44:04', '2020-04-18 09:44:04'),
(464, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:44:48', '2020-04-18 09:44:48'),
(465, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:45:11', '2020-04-18 09:45:11'),
(466, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:45:24', '2020-04-18 09:45:24'),
(467, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:45:31', '2020-04-18 09:45:31'),
(468, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:45:55', '2020-04-18 09:45:55'),
(469, 1, 'admin/plugs/1', 'PUT', '127.0.0.1', '{\"name\":\"verify\",\"value\":\"1\",\"pk\":\"1\",\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_editable\":\"1\",\"_method\":\"PUT\"}', '2020-04-18 09:46:01', '2020-04-18 09:46:01'),
(470, 1, 'admin/plugs/2', 'PUT', '127.0.0.1', '{\"name\":\"verify\",\"value\":\"1\",\"pk\":\"2\",\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_editable\":\"1\",\"_method\":\"PUT\"}', '2020-04-18 09:46:05', '2020-04-18 09:46:05'),
(471, 1, 'admin/plugs/3', 'PUT', '127.0.0.1', '{\"name\":\"verify\",\"value\":\"1\",\"pk\":\"3\",\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_editable\":\"1\",\"_method\":\"PUT\"}', '2020-04-18 09:46:07', '2020-04-18 09:46:07'),
(472, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:46:27', '2020-04-18 09:46:27'),
(473, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:46:38', '2020-04-18 09:46:38'),
(474, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:46:52', '2020-04-18 09:46:52'),
(475, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:46:58', '2020-04-18 09:46:58'),
(476, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:48:46', '2020-04-18 09:48:46'),
(477, 1, 'admin/plugs/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-18 09:49:00', '2020-04-18 09:49:00'),
(478, 1, 'admin/plugs/1', 'PUT', '127.0.0.1', '{\"name\":\"\\u8fd9\\u91cc\\u662f\\u6d4b\\u8bd5\\u8f6e\\u64ad\\u56fe\",\"operate\":null,\"verify\":\"1\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"0\",\"href\":\"#\",\"_token\":\"wKnpFrVOQz1AtoeZQEAyaKsEkF8fuwlma7jSeMyp\",\"_method\":\"PUT\"}', '2020-04-18 09:49:03', '2020-04-18 09:49:03'),
(479, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:49:03', '2020-04-18 09:49:03'),
(480, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:49:15', '2020-04-18 09:49:15'),
(481, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:49:17', '2020-04-18 09:49:17'),
(482, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:49:24', '2020-04-18 09:49:24'),
(483, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:50:07', '2020-04-18 09:50:07'),
(484, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-18 09:51:10', '2020-04-18 09:51:10'),
(485, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-18 09:51:54', '2020-04-18 09:51:54'),
(486, 1, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-18 09:51:58', '2020-04-18 09:51:58'),
(487, 1, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:52:00', '2020-04-18 09:52:00'),
(488, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-18 09:52:04', '2020-04-18 09:52:04'),
(489, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:52:10', '2020-04-18 09:52:10'),
(490, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:52:10', '2020-04-18 09:52:10'),
(491, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-18 09:52:38', '2020-04-18 09:52:38'),
(492, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-18 09:52:42', '2020-04-18 09:52:42'),
(493, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:53:07', '2020-04-18 09:53:07'),
(494, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:53:16', '2020-04-18 09:53:16'),
(495, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:53:42', '2020-04-18 09:53:42'),
(496, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:53:48', '2020-04-18 09:53:48'),
(497, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:54:02', '2020-04-18 09:54:02'),
(498, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:54:14', '2020-04-18 09:54:14'),
(499, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:54:41', '2020-04-18 09:54:41'),
(500, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:54:47', '2020-04-18 09:54:47'),
(501, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:54:57', '2020-04-18 09:54:57'),
(502, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:55:00', '2020-04-18 09:55:00'),
(503, 1, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-18 09:55:23', '2020-04-18 09:55:23'),
(504, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-18 09:55:27', '2020-04-18 09:55:27'),
(505, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-20 00:51:44', '2020-04-20 00:51:44'),
(506, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 00:51:47', '2020-04-20 00:51:47'),
(507, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-20 00:54:21', '2020-04-20 00:54:21'),
(508, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 00:54:24', '2020-04-20 00:54:24'),
(509, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 00:54:25', '2020-04-20 00:54:25'),
(510, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 00:54:29', '2020-04-20 00:54:29'),
(511, 3, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-20 00:54:36', '2020-04-20 00:54:36'),
(512, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 00:54:41', '2020-04-20 00:54:41'),
(513, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 00:55:36', '2020-04-20 00:55:36'),
(514, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 00:55:49', '2020-04-20 00:55:49'),
(515, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 00:56:05', '2020-04-20 00:56:05'),
(516, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 00:56:14', '2020-04-20 00:56:14'),
(517, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 00:57:50', '2020-04-20 00:57:50'),
(518, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 00:58:01', '2020-04-20 00:58:01'),
(519, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 00:59:59', '2020-04-20 00:59:59'),
(520, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:00:15', '2020-04-20 01:00:15'),
(521, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 01:00:30', '2020-04-20 01:00:30'),
(522, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 01:00:34', '2020-04-20 01:00:34'),
(523, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 01:00:34', '2020-04-20 01:00:34'),
(524, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 01:00:43', '2020-04-20 01:00:43'),
(525, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 01:00:47', '2020-04-20 01:00:47'),
(526, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 01:00:47', '2020-04-20 01:00:47'),
(527, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 01:03:44', '2020-04-20 01:03:44'),
(528, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:04:41', '2020-04-20 01:04:41'),
(529, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:04:48', '2020-04-20 01:04:48'),
(530, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:04:54', '2020-04-20 01:04:54'),
(531, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:05:07', '2020-04-20 01:05:07'),
(532, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:05:12', '2020-04-20 01:05:12'),
(533, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:05:23', '2020-04-20 01:05:23'),
(534, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:07:27', '2020-04-20 01:07:27'),
(535, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:07:49', '2020-04-20 01:07:49'),
(536, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:07:55', '2020-04-20 01:07:55'),
(537, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:08:08', '2020-04-20 01:08:08'),
(538, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:09:55', '2020-04-20 01:09:55'),
(539, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-20 01:10:03', '2020-04-20 01:10:03'),
(540, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 01:10:08', '2020-04-20 01:10:08'),
(541, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:10:12', '2020-04-20 01:10:12'),
(542, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-20 01:10:28', '2020-04-20 01:10:28'),
(543, 3, 'admin/plugs/23', 'GET', '127.0.0.1', '[]', '2020-04-20 01:10:31', '2020-04-20 01:10:31'),
(544, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 01:10:35', '2020-04-20 01:10:35'),
(545, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 01:17:04', '2020-04-20 01:17:04'),
(546, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 01:51:51', '2020-04-20 01:51:51'),
(547, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 01:51:53', '2020-04-20 01:51:53'),
(548, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-20 01:51:55', '2020-04-20 01:51:55'),
(549, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 01:52:15', '2020-04-20 01:52:15'),
(550, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:08:13', '2020-04-20 02:08:13'),
(551, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:14', '2020-04-20 02:09:14'),
(552, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:20', '2020-04-20 02:09:20'),
(553, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:24', '2020-04-20 02:09:24'),
(554, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:26', '2020-04-20 02:09:26'),
(555, 3, 'admin/plugs/2', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:27', '2020-04-20 02:09:27'),
(556, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:29', '2020-04-20 02:09:29'),
(557, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:09:31', '2020-04-20 02:09:31'),
(558, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:10:33', '2020-04-20 02:10:33'),
(559, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:10:34', '2020-04-20 02:10:34'),
(560, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:10:53', '2020-04-20 02:10:53'),
(561, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:21:19', '2020-04-20 02:21:19'),
(562, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:21:20', '2020-04-20 02:21:20'),
(563, 3, 'admin/plugs/1', 'GET', '127.0.0.1', '[]', '2020-04-20 02:21:36', '2020-04-20 02:21:36'),
(564, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 02:23:37', '2020-04-20 02:23:37'),
(565, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:23:40', '2020-04-20 02:23:40'),
(566, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:23:41', '2020-04-20 02:23:41'),
(567, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:23:44', '2020-04-20 02:23:44'),
(568, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:23:46', '2020-04-20 02:23:46'),
(569, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:23:48', '2020-04-20 02:23:48'),
(570, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:23:51', '2020-04-20 02:23:51'),
(571, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:24:26', '2020-04-20 02:24:26'),
(572, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:27:16', '2020-04-20 02:27:16'),
(573, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:27:35', '2020-04-20 02:27:35'),
(574, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:27:41', '2020-04-20 02:27:41'),
(575, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:28:06', '2020-04-20 02:28:06'),
(576, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:28:30', '2020-04-20 02:28:30'),
(577, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:28:59', '2020-04-20 02:28:59'),
(578, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:32:47', '2020-04-20 02:32:47'),
(579, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:33:08', '2020-04-20 02:33:08'),
(580, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:44:36', '2020-04-20 02:44:36'),
(581, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:47:14', '2020-04-20 02:47:14'),
(582, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:47:30', '2020-04-20 02:47:30'),
(583, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:47:49', '2020-04-20 02:47:49'),
(584, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:48:13', '2020-04-20 02:48:13'),
(585, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:48:23', '2020-04-20 02:48:23'),
(586, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:48:35', '2020-04-20 02:48:35'),
(587, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 02:48:48', '2020-04-20 02:48:48'),
(588, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:48:50', '2020-04-20 02:48:50'),
(589, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-20 02:49:49', '2020-04-20 02:49:49'),
(590, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:51:54', '2020-04-20 02:51:54'),
(591, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:51:57', '2020-04-20 02:51:57'),
(592, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:52:02', '2020-04-20 02:52:02'),
(593, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 02:52:14', '2020-04-20 02:52:14'),
(594, 1, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:52:18', '2020-04-20 02:52:18'),
(595, 1, 'admin/plugs/3', 'PUT', '127.0.0.1', '{\"name\":\"333\",\"operate\":\"CP1002020041714132163\",\"verify\":\"0\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"3\",\"href\":\"#\",\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-20 02:52:27', '2020-04-20 02:52:27'),
(596, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 02:52:27', '2020-04-20 02:52:27'),
(597, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 02:52:30', '2020-04-20 02:52:30'),
(598, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:52:42', '2020-04-20 02:52:42'),
(599, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:53:32', '2020-04-20 02:53:32'),
(600, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:53:41', '2020-04-20 02:53:41'),
(601, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:53:50', '2020-04-20 02:53:50'),
(602, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:55:33', '2020-04-20 02:55:33'),
(603, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 02:55:45', '2020-04-20 02:55:45'),
(604, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:55:47', '2020-04-20 02:55:47'),
(605, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '[]', '2020-04-20 02:56:11', '2020-04-20 02:56:11'),
(606, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 02:56:16', '2020-04-20 02:56:16'),
(607, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:56:19', '2020-04-20 02:56:19'),
(608, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:56:48', '2020-04-20 02:56:48'),
(609, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:58:26', '2020-04-20 02:58:26'),
(610, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 02:58:30', '2020-04-20 02:58:30'),
(611, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:58:38', '2020-04-20 02:58:38'),
(612, 3, 'admin/plugs/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 02:58:51', '2020-04-20 02:58:51'),
(613, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:00:07', '2020-04-20 03:00:07'),
(614, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:00:15', '2020-04-20 03:00:15'),
(615, 3, 'admin/plugs/3', 'PUT', '127.0.0.1', '{\"name\":\"333\",\"operate\":\"CP1002020041714132163\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"3\",\"href\":\"#\",\"_token\":\"L4jxxT9H3EoDN9yFrJGoelsqiVJqbUowDy8qtzhC\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/plugs\"}', '2020-04-20 03:00:23', '2020-04-20 03:00:23'),
(616, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:00:23', '2020-04-20 03:00:23'),
(617, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:00:42', '2020-04-20 03:00:42'),
(618, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:00:46', '2020-04-20 03:00:46'),
(619, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:03:07', '2020-04-20 03:03:07'),
(620, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:03:16', '2020-04-20 03:03:16'),
(621, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:03:56', '2020-04-20 03:03:56'),
(622, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:04:10', '2020-04-20 03:04:10'),
(623, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:04:25', '2020-04-20 03:04:25'),
(624, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:05:59', '2020-04-20 03:05:59'),
(625, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:06:06', '2020-04-20 03:06:06'),
(626, 3, 'admin/plugs/3', 'PUT', '127.0.0.1', '{\"active\":\"off\",\"_token\":\"L4jxxT9H3EoDN9yFrJGoelsqiVJqbUowDy8qtzhC\",\"_method\":\"PUT\"}', '2020-04-20 03:06:38', '2020-04-20 03:06:38'),
(627, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:06:41', '2020-04-20 03:06:41'),
(628, 3, 'admin/plugs/3', 'PUT', '127.0.0.1', '{\"active\":\"on\",\"_token\":\"L4jxxT9H3EoDN9yFrJGoelsqiVJqbUowDy8qtzhC\",\"_method\":\"PUT\"}', '2020-04-20 03:06:43', '2020-04-20 03:06:43'),
(629, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:06:47', '2020-04-20 03:06:47'),
(630, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:06:54', '2020-04-20 03:06:54'),
(631, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:06:56', '2020-04-20 03:06:56'),
(632, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:07:02', '2020-04-20 03:07:02'),
(633, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:07:05', '2020-04-20 03:07:05'),
(634, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:07:44', '2020-04-20 03:07:44'),
(635, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:07:54', '2020-04-20 03:07:54'),
(636, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:08:28', '2020-04-20 03:08:28'),
(637, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:08:53', '2020-04-20 03:08:53'),
(638, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:10:26', '2020-04-20 03:10:26'),
(639, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:10:33', '2020-04-20 03:10:33'),
(640, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:10:41', '2020-04-20 03:10:41'),
(641, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:10:51', '2020-04-20 03:10:51'),
(642, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:11:11', '2020-04-20 03:11:11'),
(643, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:11:20', '2020-04-20 03:11:20'),
(644, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:12:27', '2020-04-20 03:12:27'),
(645, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:12:41', '2020-04-20 03:12:41'),
(646, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:12:53', '2020-04-20 03:12:53'),
(647, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:13:05', '2020-04-20 03:13:05'),
(648, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:13:09', '2020-04-20 03:13:09'),
(649, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:13:11', '2020-04-20 03:13:11'),
(650, 3, 'admin/plugs/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:13:13', '2020-04-20 03:13:13'),
(651, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:13:13', '2020-04-20 03:13:13'),
(652, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:13:29', '2020-04-20 03:13:29'),
(653, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:15:45', '2020-04-20 03:15:45'),
(654, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:16:02', '2020-04-20 03:16:02'),
(655, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:16:35', '2020-04-20 03:16:35'),
(656, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:16:38', '2020-04-20 03:16:38'),
(657, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:16:40', '2020-04-20 03:16:40'),
(658, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:16:58', '2020-04-20 03:16:58'),
(659, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:17:17', '2020-04-20 03:17:17'),
(660, 3, 'admin/plugs/3', 'GET', '127.0.0.1', '[]', '2020-04-20 03:18:46', '2020-04-20 03:18:46'),
(661, 3, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:16', '2020-04-20 03:25:16'),
(662, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:23', '2020-04-20 03:25:23'),
(663, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:27', '2020-04-20 03:25:27'),
(664, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:33', '2020-04-20 03:25:33'),
(665, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:41', '2020-04-20 03:25:41'),
(666, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:47', '2020-04-20 03:25:47'),
(667, 3, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:48', '2020-04-20 03:25:48'),
(668, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:49', '2020-04-20 03:25:49'),
(669, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:25:54', '2020-04-20 03:25:54'),
(670, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:26:01', '2020-04-20 03:26:01'),
(671, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:26:03', '2020-04-20 03:26:03'),
(672, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:26:11', '2020-04-20 03:26:11'),
(673, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:26:16', '2020-04-20 03:26:16'),
(674, 1, 'admin/auth/users/3', 'PUT', '127.0.0.1', '{\"username\":\"admin\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"password\":\"admin\",\"password_confirmation\":\"$2y$10$OYWMPxZht73.\\/TgATcFnJeDyfGFrsdmFZ39TINBkaRKbZIfVBpB7u\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/users\"}', '2020-04-20 03:26:28', '2020-04-20 03:26:28'),
(675, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:26:28', '2020-04-20 03:26:28'),
(676, 1, 'admin/auth/users/3', 'PUT', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"password\":\"12345678\",\"password_confirmation\":\"$2y$10$OYWMPxZht73.\\/TgATcFnJeDyfGFrsdmFZ39TINBkaRKbZIfVBpB7u\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\"}', '2020-04-20 03:26:40', '2020-04-20 03:26:40'),
(677, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:26:40', '2020-04-20 03:26:40'),
(678, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:26:44', '2020-04-20 03:26:44'),
(679, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-20 03:28:26', '2020-04-20 03:28:26'),
(680, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:28:29', '2020-04-20 03:28:29'),
(681, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:28:32', '2020-04-20 03:28:32'),
(682, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:28:53', '2020-04-20 03:28:53'),
(683, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:29:12', '2020-04-20 03:29:12'),
(684, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:29:37', '2020-04-20 03:29:37'),
(685, 1, 'admin/auth/users/3/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 03:29:56', '2020-04-20 03:29:56'),
(686, 1, 'admin/auth/users/3', 'PUT', '127.0.0.1', '{\"username\":\"15666446111\",\"name\":\"\\u83cf\\u6cfd\\u6728\\u5b50\\u6570\\u636e\",\"password\":\"12345678\",\"password_confirmation\":\"12345678\",\"roles\":[\"2\",null],\"permissions\":[null],\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\"}', '2020-04-20 03:30:25', '2020-04-20 03:30:25'),
(687, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2020-04-20 03:30:26', '2020-04-20 03:30:26'),
(688, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:30:30', '2020-04-20 03:30:30'),
(689, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:30:33', '2020-04-20 03:30:33'),
(690, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:30:34', '2020-04-20 03:30:34'),
(691, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:30:36', '2020-04-20 03:30:36'),
(692, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:30:37', '2020-04-20 03:30:37'),
(693, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:30:40', '2020-04-20 03:30:40'),
(694, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:30:43', '2020-04-20 03:30:43'),
(695, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:30:48', '2020-04-20 03:30:48'),
(696, 1, 'admin/auth/roles/2', 'PUT', '127.0.0.1', '{\"slug\":\"\\u64cd\\u76d8\",\"name\":\"\\u64cd\\u76d8\",\"permissions\":[\"6\",null],\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/roles\"}', '2020-04-20 03:30:59', '2020-04-20 03:30:59'),
(697, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2020-04-20 03:30:59', '2020-04-20 03:30:59'),
(698, 3, 'admin/plug-types', 'GET', '127.0.0.1', '[]', '2020-04-20 03:31:03', '2020-04-20 03:31:03'),
(699, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:05', '2020-04-20 03:31:05'),
(700, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:07', '2020-04-20 03:31:07'),
(701, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:10', '2020-04-20 03:31:10'),
(702, 3, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-20 03:31:11', '2020-04-20 03:31:11'),
(703, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:14', '2020-04-20 03:31:14'),
(704, 3, 'admin/plugs/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:17', '2020-04-20 03:31:17'),
(705, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:24', '2020-04-20 03:31:24'),
(706, 3, 'admin/plug-types', 'GET', '127.0.0.1', '[]', '2020-04-20 03:31:47', '2020-04-20 03:31:47'),
(707, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:49', '2020-04-20 03:31:49'),
(708, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:31:54', '2020-04-20 03:31:54'),
(709, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:32:20', '2020-04-20 03:32:20'),
(710, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:33:04', '2020-04-20 03:33:04'),
(711, 1, 'admin/auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"\\u5206\\u4eab\\u7d20\\u6750\",\"name\":\"\\u5206\\u4eab\\u7d20\\u6750\",\"http_method\":[\"GET\",\"POST\",\"PUT\",\"DELETE\",null],\"http_path\":\"\\/shares*\",\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/permissions\"}', '2020-04-20 03:33:37', '2020-04-20 03:33:37'),
(712, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '[]', '2020-04-20 03:33:38', '2020-04-20 03:33:38'),
(713, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:33:44', '2020-04-20 03:33:44'),
(714, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:33:46', '2020-04-20 03:33:46'),
(715, 1, 'admin/auth/roles/2', 'PUT', '127.0.0.1', '{\"slug\":\"\\u64cd\\u76d8\",\"name\":\"\\u64cd\\u76d8\",\"permissions\":[\"6\",\"7\",null],\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/roles\"}', '2020-04-20 03:33:53', '2020-04-20 03:33:53'),
(716, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2020-04-20 03:33:53', '2020-04-20 03:33:53'),
(717, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:34:02', '2020-04-20 03:34:02'),
(718, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:34:08', '2020-04-20 03:34:08'),
(719, 3, 'admin/auth/setting', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:37:11', '2020-04-20 03:37:11'),
(720, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:37:21', '2020-04-20 03:37:21'),
(721, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:37:30', '2020-04-20 03:37:30'),
(722, 3, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:37:33', '2020-04-20 03:37:33'),
(723, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:37:35', '2020-04-20 03:37:35'),
(724, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 03:38:30', '2020-04-20 03:38:30'),
(725, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:32', '2020-04-20 03:38:32'),
(726, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:34', '2020-04-20 03:38:34'),
(727, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:37', '2020-04-20 03:38:37'),
(728, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:39', '2020-04-20 03:38:39'),
(729, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:42', '2020-04-20 03:38:42'),
(730, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:44', '2020-04-20 03:38:44'),
(731, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:47', '2020-04-20 03:38:47'),
(732, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:49', '2020-04-20 03:38:49'),
(733, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:51', '2020-04-20 03:38:51'),
(734, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:54', '2020-04-20 03:38:54'),
(735, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:56', '2020-04-20 03:38:56'),
(736, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:38:58', '2020-04-20 03:38:58'),
(737, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:01', '2020-04-20 03:39:01');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(738, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:03', '2020-04-20 03:39:03'),
(739, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:05', '2020-04-20 03:39:05'),
(740, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:08', '2020-04-20 03:39:08'),
(741, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:10', '2020-04-20 03:39:10'),
(742, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:12', '2020-04-20 03:39:12'),
(743, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:15', '2020-04-20 03:39:15'),
(744, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:17', '2020-04-20 03:39:17'),
(745, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 03:39:19', '2020-04-20 03:39:19'),
(746, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:25:26', '2020-04-20 04:25:26'),
(747, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 04:25:41', '2020-04-20 04:25:41'),
(748, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 04:26:22', '2020-04-20 04:26:22'),
(749, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 04:26:41', '2020-04-20 04:26:41'),
(750, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 04:27:14', '2020-04-20 04:27:14'),
(751, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:27:17', '2020-04-20 04:27:17'),
(752, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 04:29:39', '2020-04-20 04:29:39'),
(753, 1, 'admin/share-types/2', 'PUT', '127.0.0.1', '{\"active\":\"off\",\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\"}', '2020-04-20 04:47:22', '2020-04-20 04:47:22'),
(754, 1, 'admin/share-types/2', 'PUT', '127.0.0.1', '{\"active\":\"on\",\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\"}', '2020-04-20 04:47:23', '2020-04-20 04:47:23'),
(755, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:55:04', '2020-04-20 04:55:04'),
(756, 1, 'admin/shares/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:58:40', '2020-04-20 04:58:40'),
(757, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:58:44', '2020-04-20 04:58:44'),
(758, 1, 'admin/shares/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:58:48', '2020-04-20 04:58:48'),
(759, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 04:59:44', '2020-04-20 04:59:44'),
(760, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:00:03', '2020-04-20 05:00:03'),
(761, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:00:05', '2020-04-20 05:00:05'),
(762, 1, 'admin/shares/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:00:43', '2020-04-20 05:00:43'),
(763, 3, 'admin/shares/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 05:00:55', '2020-04-20 05:00:55'),
(764, 3, 'admin/shares/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 05:01:11', '2020-04-20 05:01:11'),
(765, 3, 'admin/shares/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:02:34', '2020-04-20 05:02:34'),
(766, 3, 'admin/shares', 'POST', '127.0.0.1', '{\"operate\":\"CP1002020041714132163\",\"title\":\"\\u64cd\\u76d8\\u5206\\u4eab\",\"active\":\"on\",\"type_id\":\"2\",\"sort\":\"0\",\"code_size\":\"100\",\"code_x\":\"100\",\"code_y\":\"100\",\"_token\":\"L4jxxT9H3EoDN9yFrJGoelsqiVJqbUowDy8qtzhC\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/shares\"}', '2020-04-20 05:02:48', '2020-04-20 05:02:48'),
(767, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:02:49', '2020-04-20 05:02:49'),
(768, 3, 'admin/shares/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:02:58', '2020-04-20 05:02:58'),
(769, 3, 'admin/shares/1/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 05:03:02', '2020-04-20 05:03:02'),
(770, 3, 'admin/shares/2/edit', 'GET', '127.0.0.1', '[]', '2020-04-20 05:03:04', '2020-04-20 05:03:04'),
(771, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:03:17', '2020-04-20 05:03:17'),
(772, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:03:47', '2020-04-20 05:03:47'),
(773, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:03:59', '2020-04-20 05:03:59'),
(774, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:04:19', '2020-04-20 05:04:19'),
(775, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:04:28', '2020-04-20 05:04:28'),
(776, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:04:38', '2020-04-20 05:04:38'),
(777, 3, 'admin/shares/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:05:11', '2020-04-20 05:05:11'),
(778, 3, 'admin/shares/2', 'GET', '127.0.0.1', '[]', '2020-04-20 05:06:19', '2020-04-20 05:06:19'),
(779, 3, 'admin/shares/2', 'GET', '127.0.0.1', '[]', '2020-04-20 05:06:43', '2020-04-20 05:06:43'),
(780, 3, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:06:57', '2020-04-20 05:06:57'),
(781, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:07:01', '2020-04-20 05:07:01'),
(782, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:07:03', '2020-04-20 05:07:03'),
(783, 3, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:07:04', '2020-04-20 05:07:04'),
(784, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:07:08', '2020-04-20 05:07:08'),
(785, 3, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:07:23', '2020-04-20 05:07:23'),
(786, 3, 'admin/shares/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:07:25', '2020-04-20 05:07:25'),
(787, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:07:27', '2020-04-20 05:07:27'),
(788, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_export_\":\"all\"}', '2020-04-20 05:07:29', '2020-04-20 05:07:29'),
(789, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:08:22', '2020-04-20 05:08:22'),
(790, 3, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:08:45', '2020-04-20 05:08:45'),
(791, 3, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:08:47', '2020-04-20 05:08:47'),
(792, 3, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:08:50', '2020-04-20 05:08:50'),
(793, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:08:54', '2020-04-20 05:08:54'),
(794, 3, 'admin/shares/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:19:15', '2020-04-20 05:19:15'),
(795, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:19:21', '2020-04-20 05:19:21'),
(796, 1, 'admin/shares', 'GET', '127.0.0.1', '[]', '2020-04-20 05:19:23', '2020-04-20 05:19:23'),
(797, 1, 'admin/shares/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:19:26', '2020-04-20 05:19:26'),
(798, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:19:32', '2020-04-20 05:19:32'),
(799, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:19:35', '2020-04-20 05:19:35'),
(800, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:19:39', '2020-04-20 05:19:39'),
(801, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:01', '2020-04-20 05:35:01'),
(802, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:03', '2020-04-20 05:35:03'),
(803, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:07', '2020-04-20 05:35:07'),
(804, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:13', '2020-04-20 05:35:13'),
(805, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:16', '2020-04-20 05:35:16'),
(806, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:22', '2020-04-20 05:35:22'),
(807, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:31', '2020-04-20 05:35:31'),
(808, 1, 'admin/auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"\\u4f1a\\u5458\\u7ba1\\u7406\",\"name\":\"\\u4f1a\\u5458\\u7ba1\\u7406\",\"http_method\":[\"GET\",null],\"http_path\":\"\\/users*\",\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/permissions\"}', '2020-04-20 05:35:51', '2020-04-20 05:35:51'),
(809, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '[]', '2020-04-20 05:35:52', '2020-04-20 05:35:52'),
(810, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:35:57', '2020-04-20 05:35:57'),
(811, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:36:00', '2020-04-20 05:36:00'),
(812, 1, 'admin/auth/roles/2', 'PUT', '127.0.0.1', '{\"slug\":\"\\u64cd\\u76d8\",\"name\":\"\\u64cd\\u76d8\",\"permissions\":[\"6\",\"7\",\"8\",null],\"_token\":\"XROREFzJYPIyeV3v2J4k6UmENZODNhftmrdtLu46\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/roles\"}', '2020-04-20 05:36:02', '2020-04-20 05:36:02'),
(813, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2020-04-20 05:36:02', '2020-04-20 05:36:02'),
(814, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:36:06', '2020-04-20 05:36:06'),
(815, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:37:28', '2020-04-20 05:37:28'),
(816, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:37:53', '2020-04-20 05:37:53'),
(817, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:38:22', '2020-04-20 05:38:22'),
(818, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:39:07', '2020-04-20 05:39:07'),
(819, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:39:32', '2020-04-20 05:39:32'),
(820, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:39:51', '2020-04-20 05:39:51'),
(821, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:41:32', '2020-04-20 05:41:32'),
(822, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:42:09', '2020-04-20 05:42:09'),
(823, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:42:24', '2020-04-20 05:42:24'),
(824, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:45:37', '2020-04-20 05:45:37'),
(825, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:45:54', '2020-04-20 05:45:54'),
(826, 3, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:46:27', '2020-04-20 05:46:27'),
(827, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:46:29', '2020-04-20 05:46:29'),
(828, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 05:49:07', '2020-04-20 05:49:07'),
(829, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"last_time\",\"type\":\"desc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:49:09', '2020-04-20 05:49:09'),
(830, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"last_time\",\"type\":\"asc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:49:10', '2020-04-20 05:49:10'),
(831, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"last_time\",\"type\":\"asc\"}}', '2020-04-20 05:50:40', '2020-04-20 05:50:40'),
(832, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"last_time\",\"type\":\"asc\"}}', '2020-04-20 05:53:49', '2020-04-20 05:53:49'),
(833, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"last_time\",\"type\":\"asc\"}}', '2020-04-20 05:54:22', '2020-04-20 05:54:22'),
(834, 3, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:56:05', '2020-04-20 05:56:05'),
(835, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 05:56:55', '2020-04-20 05:56:55'),
(836, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 05:57:05', '2020-04-20 05:57:05'),
(837, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 05:57:36', '2020-04-20 05:57:36'),
(838, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 05:57:53', '2020-04-20 05:57:53'),
(839, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 05:57:59', '2020-04-20 05:57:59'),
(840, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 05:58:15', '2020-04-20 05:58:15'),
(841, 3, 'admin/users/5/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:59:38', '2020-04-20 05:59:38'),
(842, 3, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 05:59:41', '2020-04-20 05:59:41'),
(843, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:00:26', '2020-04-20 06:00:26'),
(844, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:03:19', '2020-04-20 06:03:19'),
(845, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:08:10', '2020-04-20 06:08:10'),
(846, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:08:20', '2020-04-20 06:08:20'),
(847, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:10:14', '2020-04-20 06:10:14'),
(848, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:10:48', '2020-04-20 06:10:48'),
(849, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:11:07', '2020-04-20 06:11:07'),
(850, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:11:09', '2020-04-20 06:11:09'),
(851, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:11:22', '2020-04-20 06:11:22'),
(852, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:11:47', '2020-04-20 06:11:47'),
(853, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:11:50', '2020-04-20 06:11:50'),
(854, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:12:21', '2020-04-20 06:12:21'),
(855, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:12:40', '2020-04-20 06:12:40'),
(856, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:12:47', '2020-04-20 06:12:47'),
(857, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:13:00', '2020-04-20 06:13:00'),
(858, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:13:17', '2020-04-20 06:13:17'),
(859, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:14:40', '2020-04-20 06:14:40'),
(860, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:14:42', '2020-04-20 06:14:42'),
(861, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:14:46', '2020-04-20 06:14:46'),
(862, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:14:59', '2020-04-20 06:14:59'),
(863, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:16:04', '2020-04-20 06:16:04'),
(864, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:16:22', '2020-04-20 06:16:22'),
(865, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:17:00', '2020-04-20 06:17:00'),
(866, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:17:31', '2020-04-20 06:17:31'),
(867, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:29:00', '2020-04-20 06:29:00'),
(868, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:29:02', '2020-04-20 06:29:02'),
(869, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:29:10', '2020-04-20 06:29:10'),
(870, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:29:25', '2020-04-20 06:29:25'),
(871, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:29:43', '2020-04-20 06:29:43'),
(872, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:30:04', '2020-04-20 06:30:04'),
(873, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:45:41', '2020-04-20 06:45:41'),
(874, 3, 'admin/users/4', 'GET', '127.0.0.1', '[]', '2020-04-20 06:47:51', '2020-04-20 06:47:51'),
(875, 3, 'admin/users/3', 'GET', '127.0.0.1', '[]', '2020-04-20 06:47:55', '2020-04-20 06:47:55'),
(876, 3, 'admin/users/1', 'GET', '127.0.0.1', '[]', '2020-04-20 06:47:57', '2020-04-20 06:47:57'),
(877, 3, 'admin/users/15', 'GET', '127.0.0.1', '[]', '2020-04-20 06:48:00', '2020-04-20 06:48:00'),
(878, 3, 'admin/users/5', 'GET', '127.0.0.1', '[]', '2020-04-20 06:48:04', '2020-04-20 06:48:04'),
(879, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:48:43', '2020-04-20 06:48:43'),
(880, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:48:50', '2020-04-20 06:48:50'),
(881, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:48:52', '2020-04-20 06:48:52'),
(882, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:48:53', '2020-04-20 06:48:53'),
(883, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:48:54', '2020-04-20 06:48:54'),
(884, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:48:56', '2020-04-20 06:48:56'),
(885, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:53:01', '2020-04-20 06:53:01'),
(886, 1, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:53:05', '2020-04-20 06:53:05'),
(887, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:53:06', '2020-04-20 06:53:06'),
(888, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_export_\":\"all\"}', '2020-04-20 06:53:07', '2020-04-20 06:53:07'),
(889, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:54:31', '2020-04-20 06:54:31'),
(890, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 06:54:33', '2020-04-20 06:54:33'),
(891, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:14:54', '2020-04-20 07:14:54'),
(892, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:15:24', '2020-04-20 07:15:24'),
(893, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:15:26', '2020-04-20 07:15:26'),
(894, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:15:37', '2020-04-20 07:15:37'),
(895, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:15:40', '2020-04-20 07:15:40'),
(896, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:15:41', '2020-04-20 07:15:41'),
(897, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:16:11', '2020-04-20 07:16:11'),
(898, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:16:14', '2020-04-20 07:16:14'),
(899, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:17:01', '2020-04-20 07:17:01'),
(900, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:17:08', '2020-04-20 07:17:08'),
(901, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:17:15', '2020-04-20 07:17:15'),
(902, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:17:19', '2020-04-20 07:17:19'),
(903, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:17:26', '2020-04-20 07:17:26'),
(904, 3, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:17:28', '2020-04-20 07:17:28'),
(905, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:37:09', '2020-04-20 07:37:09'),
(906, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:38:15', '2020-04-20 07:38:15'),
(907, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"wallets.cash_blance\",\"type\":\"desc\"}}', '2020-04-20 07:38:22', '2020-04-20 07:38:22'),
(908, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"wallets.cash_blance\",\"type\":\"desc\"}}', '2020-04-20 07:38:47', '2020-04-20 07:38:47'),
(909, 3, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 07:38:51', '2020-04-20 07:38:51'),
(910, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 07:39:35', '2020-04-20 07:39:35'),
(911, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 07:39:45', '2020-04-20 07:39:45'),
(912, 3, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 07:40:06', '2020-04-20 07:40:06'),
(913, 1, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 07:40:37', '2020-04-20 07:40:37'),
(914, 1, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-20 07:40:46', '2020-04-20 07:40:46'),
(915, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 08:58:11', '2020-04-20 08:58:11'),
(916, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:04:17', '2020-04-20 09:04:17'),
(917, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:04:43', '2020-04-20 09:04:43'),
(918, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:36:47', '2020-04-20 09:36:47'),
(919, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:29:55', '2020-04-20 09:29:55'),
(920, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:29:57', '2020-04-20 09:29:57'),
(921, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:31:10', '2020-04-20 09:31:10'),
(922, 1, 'admin/admin-users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-20 09:34:11', '2020-04-20 09:34:11'),
(923, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-21 00:57:40', '2020-04-21 00:57:40'),
(924, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 00:59:01', '2020-04-21 00:59:01'),
(925, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:32:02', '2020-04-21 02:32:02'),
(926, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"17\",\"title\":\"\\u6587\\u7ae0\\u7c7b\\u578b\",\"icon\":\"fa-columns\",\"uri\":\"article-types\",\"roles\":[null],\"permission\":null,\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\"}', '2020-04-21 02:32:44', '2020-04-21 02:32:44'),
(927, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 02:32:45', '2020-04-21 02:32:45'),
(928, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"17\",\"title\":\"\\u6587\\u7ae0\\u5217\\u8868\",\"icon\":\"fa-align-justify\",\"uri\":\"articles\",\"roles\":[null],\"permission\":null,\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\"}', '2020-04-21 02:33:26', '2020-04-21 02:33:26'),
(929, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 02:33:26', '2020-04-21 02:33:26'),
(930, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 02:33:28', '2020-04-21 02:33:28'),
(931, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:33:30', '2020-04-21 02:33:30'),
(932, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:33:35', '2020-04-21 02:33:35'),
(933, 1, 'admin/auth/menu/21/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:33:37', '2020-04-21 02:33:37'),
(934, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:33:45', '2020-04-21 02:33:45'),
(935, 1, 'admin/users', 'GET', '127.0.0.1', '[]', '2020-04-21 02:34:16', '2020-04-21 02:34:16'),
(936, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:34:18', '2020-04-21 02:34:18'),
(937, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:34:43', '2020-04-21 02:34:43'),
(938, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:37:13', '2020-04-21 02:37:13'),
(939, 1, 'admin/article-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:37:15', '2020-04-21 02:37:15'),
(940, 1, 'admin/article-types', 'POST', '127.0.0.1', '{\"name\":\"\\u7cfb\\u7edf\\u516c\\u544a\",\"active\":\"on\",\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/article-types\"}', '2020-04-21 02:37:20', '2020-04-21 02:37:20'),
(941, 1, 'admin/article-types', 'GET', '127.0.0.1', '[]', '2020-04-21 02:37:20', '2020-04-21 02:37:20'),
(942, 1, 'admin/article-types/1', 'PUT', '127.0.0.1', '{\"active\":\"off\",\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\",\"_method\":\"PUT\"}', '2020-04-21 02:37:43', '2020-04-21 02:37:43'),
(943, 1, 'admin/article-types/1', 'PUT', '127.0.0.1', '{\"active\":\"on\",\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\",\"_method\":\"PUT\"}', '2020-04-21 02:37:44', '2020-04-21 02:37:44'),
(944, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:39:05', '2020-04-21 02:39:05'),
(945, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:39:08', '2020-04-21 02:39:08'),
(946, 1, 'admin/articles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:39:10', '2020-04-21 02:39:10'),
(947, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:41:42', '2020-04-21 02:41:42'),
(948, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:41:43', '2020-04-21 02:41:43'),
(949, 1, 'admin/articles', 'GET', '127.0.0.1', '[]', '2020-04-21 02:46:34', '2020-04-21 02:46:34'),
(950, 1, 'admin/articles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:46:36', '2020-04-21 02:46:36'),
(951, 1, 'admin/articles', 'GET', '127.0.0.1', '[]', '2020-04-21 02:46:38', '2020-04-21 02:46:38'),
(952, 1, 'admin/articles', 'GET', '127.0.0.1', '[]', '2020-04-21 02:47:01', '2020-04-21 02:47:01'),
(953, 1, 'admin/articles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:47:03', '2020-04-21 02:47:03'),
(954, 1, 'admin/articles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 02:52:06', '2020-04-21 02:52:06'),
(955, 1, 'admin/articles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 02:53:00', '2020-04-21 02:53:00'),
(956, 1, 'admin/articles', 'POST', '127.0.0.1', '{\"operate\":\"All\",\"title\":\"\\u6d4b\\u8bd5\",\"active\":\"on\",\"type_id\":\"1\",\"verify\":\"0\",\"content\":\"<p><img src=\\\"http:\\/\\/www.chb.com\\/storage\\/uploads\\/image\\/2020\\/04\\/21\\/\\u5c71\\u5206logo.jpg\\\" title=\\\"\\/uploads\\/image\\/2020\\/04\\/21\\/\\u5c71\\u5206logo.jpg\\\" alt=\\\"\\u5c71\\u5206logo.jpg\\\" width=\\\"227\\\" height=\\\"236\\\" style=\\\"width: 227px; height: 236px;\\\"\\/><\\/p>\",\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\"}', '2020-04-21 02:56:32', '2020-04-21 02:56:32'),
(957, 1, 'admin/articles', 'GET', '127.0.0.1', '[]', '2020-04-21 02:56:33', '2020-04-21 02:56:33'),
(958, 1, 'admin/articles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:56:37', '2020-04-21 02:56:37'),
(959, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 02:57:04', '2020-04-21 02:57:04'),
(960, 1, 'admin/articles', 'GET', '127.0.0.1', '[]', '2020-04-21 03:00:16', '2020-04-21 03:00:16'),
(961, 1, 'admin/articles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:00:30', '2020-04-21 03:00:30'),
(962, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:00:38', '2020-04-21 03:00:38'),
(963, 1, 'admin/articles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:00:40', '2020-04-21 03:00:40'),
(964, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:01:15', '2020-04-21 03:01:15'),
(965, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:01:17', '2020-04-21 03:01:17'),
(966, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:01:19', '2020-04-21 03:01:19'),
(967, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:02:28', '2020-04-21 03:02:28'),
(968, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:02:39', '2020-04-21 03:02:39'),
(969, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:06:07', '2020-04-21 03:06:07'),
(970, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:06:45', '2020-04-21 03:06:45'),
(971, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:07:15', '2020-04-21 03:07:15'),
(972, 1, 'admin/articles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:07:20', '2020-04-21 03:07:20'),
(973, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:08:15', '2020-04-21 03:08:15'),
(974, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:08:18', '2020-04-21 03:08:18'),
(975, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:09:27', '2020-04-21 03:09:27'),
(976, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:10:37', '2020-04-21 03:10:37'),
(977, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:10:48', '2020-04-21 03:10:48'),
(978, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:11:17', '2020-04-21 03:11:17'),
(979, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:11:31', '2020-04-21 03:11:31'),
(980, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"active\",\"type\":\"desc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:11:32', '2020-04-21 03:11:32'),
(981, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"active\",\"type\":\"asc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:11:33', '2020-04-21 03:11:33'),
(982, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"active\",\"type\":\"asc\"}}', '2020-04-21 03:12:05', '2020-04-21 03:12:05'),
(983, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"active\",\"type\":\"asc\"}}', '2020-04-21 03:12:21', '2020-04-21 03:12:21'),
(984, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"active\",\"type\":\"desc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:12:25', '2020-04-21 03:12:25'),
(985, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"active\",\"type\":\"asc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:12:28', '2020-04-21 03:12:28'),
(986, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"id\",\"type\":\"desc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:12:53', '2020-04-21 03:12:53'),
(987, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"id\",\"type\":\"asc\"},\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:12:55', '2020-04-21 03:12:55'),
(988, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"id\",\"type\":\"asc\"}}', '2020-04-21 03:13:32', '2020-04-21 03:13:32'),
(989, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_sort\":{\"column\":\"id\",\"type\":\"asc\"}}', '2020-04-21 03:14:01', '2020-04-21 03:14:01'),
(990, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:16:09', '2020-04-21 03:16:09'),
(991, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:16:12', '2020-04-21 03:16:12'),
(992, 1, 'admin/share-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 03:16:56', '2020-04-21 03:16:56'),
(993, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:17:29', '2020-04-21 03:17:29'),
(994, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:17:32', '2020-04-21 03:17:32'),
(995, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 03:18:38', '2020-04-21 03:18:38'),
(996, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 03:19:12', '2020-04-21 03:19:12'),
(997, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 03:19:23', '2020-04-21 03:19:23'),
(998, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:19:52', '2020-04-21 03:19:52'),
(999, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:19:54', '2020-04-21 03:19:54'),
(1000, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 03:20:02', '2020-04-21 03:20:02'),
(1001, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 03:20:20', '2020-04-21 03:20:20'),
(1002, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:20:31', '2020-04-21 03:20:31'),
(1003, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:20:32', '2020-04-21 03:20:32'),
(1004, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:20:37', '2020-04-21 03:20:37'),
(1005, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:27:28', '2020-04-21 03:27:28'),
(1006, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:27:32', '2020-04-21 03:27:32'),
(1007, 1, 'admin/auth/permissions', 'POST', '127.0.0.1', '{\"slug\":\"\\u6587\\u7ae0\\u7ba1\\u7406\",\"name\":\"\\u6587\\u7ae0\\u7ba1\\u7406\",\"http_method\":[\"GET\",\"POST\",\"PUT\",\"DELETE\",null],\"http_path\":\"\\/articles*\",\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/permissions\"}', '2020-04-21 03:27:55', '2020-04-21 03:27:55'),
(1008, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '[]', '2020-04-21 03:27:56', '2020-04-21 03:27:56'),
(1009, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:28:03', '2020-04-21 03:28:03'),
(1010, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:28:05', '2020-04-21 03:28:05'),
(1011, 1, 'admin/auth/roles/2', 'PUT', '127.0.0.1', '{\"slug\":\"\\u64cd\\u76d8\",\"name\":\"\\u64cd\\u76d8\",\"permissions\":[\"6\",\"7\",\"8\",\"9\",null],\"_token\":\"rfzZ0jbBzSFQG8Sfysofo0CS4u1wIVBUUWyzjs1t\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/roles\"}', '2020-04-21 03:28:08', '2020-04-21 03:28:08'),
(1012, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '[]', '2020-04-21 03:28:08', '2020-04-21 03:28:08'),
(1013, 1, 'admin/auth/roles/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:28:14', '2020-04-21 03:28:14'),
(1014, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:28:30', '2020-04-21 03:28:30'),
(1015, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:33:55', '2020-04-21 03:33:55'),
(1016, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:33:57', '2020-04-21 03:33:57'),
(1017, 1, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:04', '2020-04-21 03:34:04'),
(1018, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:07', '2020-04-21 03:34:07'),
(1019, 1, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:12', '2020-04-21 03:34:12'),
(1020, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:21', '2020-04-21 03:34:21'),
(1021, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:25', '2020-04-21 03:34:25'),
(1022, 1, 'admin/user-groups', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:30', '2020-04-21 03:34:30'),
(1023, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 03:34:31', '2020-04-21 03:34:31'),
(1024, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:40:04', '2020-04-21 05:40:04'),
(1025, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u673a\\u5177\\u4ed3\\u5e93\",\"icon\":\"fa-cubes\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 05:40:45', '2020-04-21 05:40:45'),
(1026, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:40:45', '2020-04-21 05:40:45'),
(1027, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:40:59', '2020-04-21 05:40:59'),
(1028, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17,\\\"children\\\":[{\\\"id\\\":21},{\\\"id\\\":22}]},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":23},{\\\"id\\\":19},{\\\"id\\\":18},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":20},{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2020-04-21 05:41:06', '2020-04-21 05:41:06'),
(1029, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:41:06', '2020-04-21 05:41:06'),
(1030, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:41:08', '2020-04-21 05:41:08'),
(1031, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"23\",\"title\":\"\\u673a\\u5668\\u7c7b\\u578b\",\"icon\":\"fa-thumb-tack\",\"uri\":\"machines-types\",\"roles\":[null],\"permission\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 05:43:21', '2020-04-21 05:43:21'),
(1032, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:43:21', '2020-04-21 05:43:21'),
(1033, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:43:26', '2020-04-21 05:43:26'),
(1034, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:43:28', '2020-04-21 05:43:28'),
(1035, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:43:50', '2020-04-21 05:43:50'),
(1036, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:43:55', '2020-04-21 05:43:55'),
(1037, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:44:08', '2020-04-21 05:44:08'),
(1038, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:44:20', '2020-04-21 05:44:20'),
(1039, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:44:43', '2020-04-21 05:44:43'),
(1040, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:46:38', '2020-04-21 05:46:38'),
(1041, 1, 'admin/machines-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:46:40', '2020-04-21 05:46:40'),
(1042, 1, 'admin/machines-types', 'POST', '127.0.0.1', '{\"name\":\"\\u81ea\\u5907\\u673a\",\"state\":\"on\",\"sort\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-types\"}', '2020-04-21 05:46:48', '2020-04-21 05:46:48'),
(1043, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 05:46:48', '2020-04-21 05:46:48'),
(1044, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:48:10', '2020-04-21 05:48:10'),
(1045, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"23\",\"title\":\"\\u673a\\u5177\\u5382\\u5546\",\"icon\":\"fa-behance\",\"uri\":\"machines-factories\",\"roles\":[null],\"permission\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 05:48:37', '2020-04-21 05:48:37'),
(1046, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:48:37', '2020-04-21 05:48:37'),
(1047, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:48:39', '2020-04-21 05:48:39'),
(1048, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:48:41', '2020-04-21 05:48:41'),
(1049, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-21 05:52:03', '2020-04-21 05:52:03'),
(1050, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:53:01', '2020-04-21 05:53:01'),
(1051, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"23\",\"title\":\"\\u673a\\u5177\\u578b\\u53f7\",\"icon\":\"fa-android\",\"uri\":\"machines-styles\",\"roles\":[null],\"permission\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 05:53:19', '2020-04-21 05:53:19'),
(1052, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:53:19', '2020-04-21 05:53:19'),
(1053, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 05:53:25', '2020-04-21 05:53:25'),
(1054, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:53:26', '2020-04-21 05:53:26'),
(1055, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:53:28', '2020-04-21 05:53:28'),
(1056, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:53:29', '2020-04-21 05:53:29'),
(1057, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:53:30', '2020-04-21 05:53:30'),
(1058, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-21 05:54:25', '2020-04-21 05:54:25'),
(1059, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:55:11', '2020-04-21 05:55:11'),
(1060, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:56:51', '2020-04-21 05:56:51'),
(1061, 1, 'admin/machines-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:56:53', '2020-04-21 05:56:53'),
(1062, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:56:57', '2020-04-21 05:56:57'),
(1063, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:57:05', '2020-04-21 05:57:05'),
(1064, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 05:57:06', '2020-04-21 05:57:06'),
(1065, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:57:29', '2020-04-21 05:57:29'),
(1066, 1, 'admin/machines-factories', 'POST', '127.0.0.1', '{\"factory_name\":null,\"type_id\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-factories\"}', '2020-04-21 05:57:31', '2020-04-21 05:57:31'),
(1067, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:57:31', '2020-04-21 05:57:31'),
(1068, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:57:48', '2020-04-21 05:57:48'),
(1069, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:57:57', '2020-04-21 05:57:57'),
(1070, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:58:31', '2020-04-21 05:58:31'),
(1071, 1, 'admin/machines-factories', 'POST', '127.0.0.1', '{\"factory_name\":null,\"type_id\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 05:58:33', '2020-04-21 05:58:33'),
(1072, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:58:33', '2020-04-21 05:58:33'),
(1073, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:59:40', '2020-04-21 05:59:40'),
(1074, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 05:59:50', '2020-04-21 05:59:50'),
(1075, 1, 'admin/machines-factories', 'POST', '127.0.0.1', '{\"factory_name\":\"\\u6d4b\\u8bd5\\u5382\\u5546\",\"type_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 06:00:03', '2020-04-21 06:00:03'),
(1076, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:00:03', '2020-04-21 06:00:03'),
(1077, 1, 'admin/machines-factories', 'POST', '127.0.0.1', '{\"factory_name\":\"\\u6d4b\\u8bd5\\u5382\\u5546\",\"type_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 06:00:13', '2020-04-21 06:00:13'),
(1078, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-21 06:00:13', '2020-04-21 06:00:13'),
(1079, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:00:18', '2020-04-21 06:00:18'),
(1080, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:00:25', '2020-04-21 06:00:25'),
(1081, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:02:45', '2020-04-21 06:02:45'),
(1082, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:03:11', '2020-04-21 06:03:11'),
(1083, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:03:44', '2020-04-21 06:03:44'),
(1084, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:08:55', '2020-04-21 06:08:55'),
(1085, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:09:12', '2020-04-21 06:09:12'),
(1086, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:11:23', '2020-04-21 06:11:23'),
(1087, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:11:42', '2020-04-21 06:11:42'),
(1088, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:11:55', '2020-04-21 06:11:55'),
(1089, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:12:09', '2020-04-21 06:12:09'),
(1090, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"\\u6240\\u5c5e\\u578b\\u53f7\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 06:12:20', '2020-04-21 06:12:20'),
(1091, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:12:21', '2020-04-21 06:12:21'),
(1092, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:16:59', '2020-04-21 06:16:59'),
(1093, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":null,\"\\u6240\\u5c5e\\u578b\\u53f7\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 06:17:03', '2020-04-21 06:17:03'),
(1094, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:17:12', '2020-04-21 06:17:12'),
(1095, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:17:15', '2020-04-21 06:17:15'),
(1096, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"12\",\"\\u6240\\u5c5e\\u578b\\u53f7\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-styles\"}', '2020-04-21 06:17:19', '2020-04-21 06:17:19'),
(1097, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:21:30', '2020-04-21 06:21:30'),
(1098, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:21:33', '2020-04-21 06:21:33'),
(1099, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"21\",\"igorne\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-styles\"}', '2020-04-21 06:21:36', '2020-04-21 06:21:36'),
(1100, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:22:00', '2020-04-21 06:22:00'),
(1101, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:22:02', '2020-04-21 06:22:02'),
(1102, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"igorne\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-styles\"}', '2020-04-21 06:22:21', '2020-04-21 06:22:21'),
(1103, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:22:21', '2020-04-21 06:22:21'),
(1104, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"igorne\":\"1\",\"factory_id\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 06:22:51', '2020-04-21 06:22:51'),
(1105, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:23:11', '2020-04-21 06:23:11'),
(1106, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:23:13', '2020-04-21 06:23:13'),
(1107, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"121\",\"igorne\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-styles\"}', '2020-04-21 06:23:17', '2020-04-21 06:23:17'),
(1108, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:24:35', '2020-04-21 06:24:35'),
(1109, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:24:37', '2020-04-21 06:24:37'),
(1110, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:25:00', '2020-04-21 06:25:00'),
(1111, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:25:07', '2020-04-21 06:25:07'),
(1112, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 06:28:13', '2020-04-21 06:28:13'),
(1113, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"aa\":\"1\",\"factory_id\":\"1\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 06:28:23', '2020-04-21 06:28:23');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(1114, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:28:23', '2020-04-21 06:28:23'),
(1115, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:28:53', '2020-04-21 06:28:53'),
(1116, 1, 'admin/machines-types/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:28:56', '2020-04-21 06:28:56'),
(1117, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:29:00', '2020-04-21 06:29:00'),
(1118, 1, 'admin/machines-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:29:02', '2020-04-21 06:29:02'),
(1119, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:29:05', '2020-04-21 06:29:05'),
(1120, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-21 06:32:16', '2020-04-21 06:32:16'),
(1121, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:32:19', '2020-04-21 06:32:19'),
(1122, 1, 'admin/machines-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:32:21', '2020-04-21 06:32:21'),
(1123, 1, 'admin/machines-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:32:29', '2020-04-21 06:32:29'),
(1124, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:34:11', '2020-04-21 06:34:11'),
(1125, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:34:14', '2020-04-21 06:34:14'),
(1126, 1, 'admin/plug-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 06:34:35', '2020-04-21 06:34:35'),
(1127, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:34:38', '2020-04-21 06:34:38'),
(1128, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-21 06:36:09', '2020-04-21 06:36:09'),
(1129, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-21 06:36:19', '2020-04-21 06:36:19'),
(1130, 1, 'admin/machines-factories/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:36:28', '2020-04-21 06:36:28'),
(1131, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:36:30', '2020-04-21 06:36:30'),
(1132, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:36:33', '2020-04-21 06:36:33'),
(1133, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:37:24', '2020-04-21 06:37:24'),
(1134, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:37:31', '2020-04-21 06:37:31'),
(1135, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:37:37', '2020-04-21 06:37:37'),
(1136, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-21 06:39:32', '2020-04-21 06:39:32'),
(1137, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:39:35', '2020-04-21 06:39:35'),
(1138, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:41:01', '2020-04-21 06:41:01'),
(1139, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:41:03', '2020-04-21 06:41:03'),
(1140, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-21 06:41:04', '2020-04-21 06:41:04'),
(1141, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:41:07', '2020-04-21 06:41:07'),
(1142, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:41:48', '2020-04-21 06:41:48'),
(1143, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:41:54', '2020-04-21 06:41:54'),
(1144, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:42:09', '2020-04-21 06:42:09'),
(1145, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:42:11', '2020-04-21 06:42:11'),
(1146, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:42:14', '2020-04-21 06:42:14'),
(1147, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:42:22', '2020-04-21 06:42:22'),
(1148, 1, 'admin/machines-factories/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:42:46', '2020-04-21 06:42:46'),
(1149, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:43:32', '2020-04-21 06:43:32'),
(1150, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:43:34', '2020-04-21 06:43:34'),
(1151, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:43:41', '2020-04-21 06:43:41'),
(1152, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:43:53', '2020-04-21 06:43:53'),
(1153, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:43:56', '2020-04-21 06:43:56'),
(1154, 1, 'admin/articles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:43:58', '2020-04-21 06:43:58'),
(1155, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:08', '2020-04-21 06:44:08'),
(1156, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:11', '2020-04-21 06:44:11'),
(1157, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:12', '2020-04-21 06:44:12'),
(1158, 1, 'admin/articles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:15', '2020-04-21 06:44:15'),
(1159, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:17', '2020-04-21 06:44:17'),
(1160, 1, 'admin/articles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:19', '2020-04-21 06:44:19'),
(1161, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:22', '2020-04-21 06:44:22'),
(1162, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:44:46', '2020-04-21 06:44:46'),
(1163, 1, 'admin/articles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:49', '2020-04-21 06:44:49'),
(1164, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:51', '2020-04-21 06:44:51'),
(1165, 1, 'admin/articles/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:54', '2020-04-21 06:44:54'),
(1166, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:44:56', '2020-04-21 06:44:56'),
(1167, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '[]', '2020-04-21 06:45:34', '2020-04-21 06:45:34'),
(1168, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:45:37', '2020-04-21 06:45:37'),
(1169, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:45:39', '2020-04-21 06:45:39'),
(1170, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '[]', '2020-04-21 06:45:46', '2020-04-21 06:45:46'),
(1171, 1, 'admin/shares/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:45:49', '2020-04-21 06:45:49'),
(1172, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:45:51', '2020-04-21 06:45:51'),
(1173, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:47:00', '2020-04-21 06:47:00'),
(1174, 1, 'admin/article-types/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:47:02', '2020-04-21 06:47:02'),
(1175, 1, 'admin/articles/create', 'GET', '127.0.0.1', '{\"type_id\":\"1\",\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:47:04', '2020-04-21 06:47:04'),
(1176, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:47:52', '2020-04-21 06:47:52'),
(1177, 1, 'admin/share-types/2', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:47:55', '2020-04-21 06:47:55'),
(1178, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 06:48:20', '2020-04-21 06:48:20'),
(1179, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:03:05', '2020-04-21 07:03:05'),
(1180, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"23\",\"title\":\"\\u673a\\u5177\\u5217\\u8868\",\"icon\":\"fa-arrows-alt\",\"uri\":\"machines\",\"roles\":[null],\"permission\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\"}', '2020-04-21 07:03:28', '2020-04-21 07:03:28'),
(1181, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 07:03:28', '2020-04-21 07:03:28'),
(1182, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-21 07:03:31', '2020-04-21 07:03:31'),
(1183, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:03:34', '2020-04-21 07:03:34'),
(1184, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:03:47', '2020-04-21 07:03:47'),
(1185, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:04:05', '2020-04-21 07:04:05'),
(1186, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:06:29', '2020-04-21 07:06:29'),
(1187, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:06:59', '2020-04-21 07:06:59'),
(1188, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:08:00', '2020-04-21 07:08:00'),
(1189, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:08:26', '2020-04-21 07:08:26'),
(1190, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:08:32', '2020-04-21 07:08:32'),
(1191, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:08:43', '2020-04-21 07:08:43'),
(1192, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:08:53', '2020-04-21 07:08:53'),
(1193, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:09:07', '2020-04-21 07:09:07'),
(1194, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:09:14', '2020-04-21 07:09:14'),
(1195, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:09:58', '2020-04-21 07:09:58'),
(1196, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:10:08', '2020-04-21 07:10:08'),
(1197, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:10:29', '2020-04-21 07:10:29'),
(1198, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:10:42', '2020-04-21 07:10:42'),
(1199, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:11:57', '2020-04-21 07:11:57'),
(1200, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:12:03', '2020-04-21 07:12:03'),
(1201, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:12:16', '2020-04-21 07:12:16'),
(1202, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:12:51', '2020-04-21 07:12:51'),
(1203, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:12:59', '2020-04-21 07:12:59'),
(1204, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:13:22', '2020-04-21 07:13:22'),
(1205, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:21:40', '2020-04-21 07:21:40'),
(1206, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"m\",\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:21:43', '2020-04-21 07:21:43'),
(1207, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"f\",\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:21:44', '2020-04-21 07:21:44'),
(1208, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"f\"}', '2020-04-21 07:23:28', '2020-04-21 07:23:28'),
(1209, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"f\"}', '2020-04-21 07:23:38', '2020-04-21 07:23:38'),
(1210, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"f\"}', '2020-04-21 07:24:42', '2020-04-21 07:24:42'),
(1211, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"f\"}', '2020-04-21 07:24:48', '2020-04-21 07:24:48'),
(1212, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\",\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:24:50', '2020-04-21 07:24:50'),
(1213, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:25:48', '2020-04-21 07:25:48'),
(1214, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:25:59', '2020-04-21 07:25:59'),
(1215, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:26:08', '2020-04-21 07:26:08'),
(1216, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:26:21', '2020-04-21 07:26:21'),
(1217, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:26:31', '2020-04-21 07:26:31'),
(1218, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:27:08', '2020-04-21 07:27:08'),
(1219, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:27:14', '2020-04-21 07:27:14'),
(1220, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:27:24', '2020-04-21 07:27:24'),
(1221, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:27:39', '2020-04-21 07:27:39'),
(1222, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:27:45', '2020-04-21 07:27:45'),
(1223, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:29:01', '2020-04-21 07:29:01'),
(1224, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:29:09', '2020-04-21 07:29:09'),
(1225, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:29:25', '2020-04-21 07:29:25'),
(1226, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:29:35', '2020-04-21 07:29:35'),
(1227, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:29:47', '2020-04-21 07:29:47'),
(1228, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:30:00', '2020-04-21 07:30:00'),
(1229, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"gender\":\"import\"}', '2020-04-21 07:30:11', '2020-04-21 07:30:11'),
(1230, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:30:54', '2020-04-21 07:30:54'),
(1231, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:30:56', '2020-04-21 07:30:56'),
(1232, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:30:57', '2020-04-21 07:30:57'),
(1233, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:30:59', '2020-04-21 07:30:59'),
(1234, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:31:04', '2020-04-21 07:31:04'),
(1235, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:31:14', '2020-04-21 07:31:14'),
(1236, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:39:13', '2020-04-21 07:39:13'),
(1237, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:40:33', '2020-04-21 07:40:33'),
(1238, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:49:37', '2020-04-21 07:49:37'),
(1239, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:50:09', '2020-04-21 07:50:09'),
(1240, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 07:50:11', '2020-04-21 07:50:11'),
(1241, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:50:11', '2020-04-21 07:50:11'),
(1242, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:50:20', '2020-04-21 07:50:20'),
(1243, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:50:43', '2020-04-21 07:50:43'),
(1244, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:51:36', '2020-04-21 07:51:36'),
(1245, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:52:20', '2020-04-21 07:52:20'),
(1246, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:53:02', '2020-04-21 07:53:02'),
(1247, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:53:19', '2020-04-21 07:53:19'),
(1248, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 07:53:50', '2020-04-21 07:53:50'),
(1249, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:53:51', '2020-04-21 07:53:51'),
(1250, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:54:32', '2020-04-21 07:54:32'),
(1251, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 07:54:37', '2020-04-21 07:54:37'),
(1252, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:54:37', '2020-04-21 07:54:37'),
(1253, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 07:54:44', '2020-04-21 07:54:44'),
(1254, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:54:44', '2020-04-21 07:54:44'),
(1255, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:55:29', '2020-04-21 07:55:29'),
(1256, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 07:55:34', '2020-04-21 07:55:34'),
(1257, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:56:02', '2020-04-21 07:56:02'),
(1258, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 07:56:04', '2020-04-21 07:56:04'),
(1259, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 07:56:05', '2020-04-21 07:56:05'),
(1260, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 07:56:11', '2020-04-21 07:56:11'),
(1261, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:00:27', '2020-04-21 08:00:27'),
(1262, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:00:32', '2020-04-21 08:00:32'),
(1263, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:11:34', '2020-04-21 08:11:34'),
(1264, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:12:02', '2020-04-21 08:12:02'),
(1265, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:12:23', '2020-04-21 08:12:23'),
(1266, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:13:30', '2020-04-21 08:13:30'),
(1267, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:13:53', '2020-04-21 08:13:53'),
(1268, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:15:23', '2020-04-21 08:15:23'),
(1269, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:16:30', '2020-04-21 08:16:30'),
(1270, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:16:46', '2020-04-21 08:16:46'),
(1271, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:17:14', '2020-04-21 08:17:14'),
(1272, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:18:05', '2020-04-21 08:18:05'),
(1273, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:18:12', '2020-04-21 08:18:12'),
(1274, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:18:55', '2020-04-21 08:18:55'),
(1275, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 08:19:23', '2020-04-21 08:19:23'),
(1276, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 08:19:26', '2020-04-21 08:19:26'),
(1277, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 08:19:28', '2020-04-21 08:19:28'),
(1278, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '[]', '2020-04-21 08:19:41', '2020-04-21 08:19:41'),
(1279, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 08:19:47', '2020-04-21 08:19:47'),
(1280, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:21:03', '2020-04-21 08:21:03'),
(1281, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":\"1\",\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:23:21', '2020-04-21 08:23:21'),
(1282, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 08:24:39', '2020-04-21 08:24:39'),
(1283, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:24:47', '2020-04-21 08:24:47'),
(1284, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:25:09', '2020-04-21 08:25:09'),
(1285, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:25:28', '2020-04-21 08:25:28'),
(1286, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:25:54', '2020-04-21 08:25:54'),
(1287, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:29:32', '2020-04-21 08:29:32'),
(1288, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:34:03', '2020-04-21 08:34:03'),
(1289, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:34:50', '2020-04-21 08:34:50'),
(1290, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:35:21', '2020-04-21 08:35:21'),
(1291, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:35:43', '2020-04-21 08:35:43'),
(1292, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:36:15', '2020-04-21 08:36:15'),
(1293, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:36:44', '2020-04-21 08:36:44'),
(1294, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:53:40', '2020-04-21 08:53:40'),
(1295, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:55:38', '2020-04-21 08:55:38'),
(1296, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:57:04', '2020-04-21 08:57:04'),
(1297, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:57:17', '2020-04-21 08:57:17'),
(1298, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:58:34', '2020-04-21 08:58:34'),
(1299, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 08:59:25', '2020-04-21 08:59:25'),
(1300, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 09:00:51', '2020-04-21 09:00:51'),
(1301, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 09:02:17', '2020-04-21 09:02:17'),
(1302, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:02:17', '2020-04-21 09:02:17'),
(1303, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:03:11', '2020-04-21 09:03:11'),
(1304, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:03:48', '2020-04-21 09:03:48'),
(1305, 1, 'admin/machines/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:03:59', '2020-04-21 09:03:59'),
(1306, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:04:07', '2020-04-21 09:04:07'),
(1307, 1, 'admin/machines/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:05:22', '2020-04-21 09:05:22'),
(1308, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:05:59', '2020-04-21 09:05:59'),
(1309, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:06:16', '2020-04-21 09:06:16'),
(1310, 1, 'admin/machines/1', 'PUT', '127.0.0.1', '{\"open_state\":\"on\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_method\":\"PUT\"}', '2020-04-21 09:06:19', '2020-04-21 09:06:19'),
(1311, 1, 'admin/machines/1', 'PUT', '127.0.0.1', '{\"open_state\":\"off\",\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_method\":\"PUT\"}', '2020-04-21 09:06:21', '2020-04-21 09:06:21'),
(1312, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:08:29', '2020-04-21 09:08:29'),
(1313, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:08:42', '2020-04-21 09:08:42'),
(1314, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:08:48', '2020-04-21 09:08:48'),
(1315, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-21 09:10:01', '2020-04-21 09:10:01'),
(1316, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":\"1\",\"factory\":null,\"_token\":\"waJJoegqLDFV7iX68eRUdbxmxLAGMvYMpoaJ8RMI\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-21 09:12:55', '2020-04-21 09:12:55'),
(1317, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:12:55', '2020-04-21 09:12:55'),
(1318, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:13:10', '2020-04-21 09:13:10'),
(1319, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:13:11', '2020-04-21 09:13:11'),
(1320, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:13:12', '2020-04-21 09:13:12'),
(1321, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:13:13', '2020-04-21 09:13:13'),
(1322, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:13:21', '2020-04-21 09:13:21'),
(1323, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:13:55', '2020-04-21 09:13:55'),
(1324, 3, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-21 09:14:28', '2020-04-21 09:14:28'),
(1325, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:14:35', '2020-04-21 09:14:35'),
(1326, 3, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:14:36', '2020-04-21 09:14:36'),
(1327, 3, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:14:48', '2020-04-21 09:14:48'),
(1328, 3, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:14:54', '2020-04-21 09:14:54'),
(1329, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:14:55', '2020-04-21 09:14:55'),
(1330, 3, 'admin/shares/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:15:46', '2020-04-21 09:15:46'),
(1331, 3, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:15:50', '2020-04-21 09:15:50'),
(1332, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:16:01', '2020-04-21 09:16:01'),
(1333, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:16:03', '2020-04-21 09:16:03'),
(1334, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:16:07', '2020-04-21 09:16:07'),
(1335, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:17:08', '2020-04-21 09:17:08'),
(1336, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:17:48', '2020-04-21 09:17:48'),
(1337, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:17:49', '2020-04-21 09:17:49'),
(1338, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:17:51', '2020-04-21 09:17:51'),
(1339, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:18:06', '2020-04-21 09:18:06'),
(1340, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:18:15', '2020-04-21 09:18:15'),
(1341, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:18:38', '2020-04-21 09:18:38'),
(1342, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:18:50', '2020-04-21 09:18:50'),
(1343, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:18:57', '2020-04-21 09:18:57'),
(1344, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:19:17', '2020-04-21 09:19:17'),
(1345, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:19:20', '2020-04-21 09:19:20'),
(1346, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:19:42', '2020-04-21 09:19:42'),
(1347, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:20:19', '2020-04-21 09:20:19'),
(1348, 1, 'admin/machines-styles/1', 'GET', '127.0.0.1', '[]', '2020-04-21 09:20:29', '2020-04-21 09:20:29'),
(1349, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-21 09:20:45', '2020-04-21 09:20:45'),
(1350, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-22 01:22:35', '2020-04-22 01:22:35'),
(1351, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 01:24:41', '2020-04-22 01:24:41'),
(1352, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"_token\":\"OEJHDYmXFHrgCbQgsT85pJy6Nu5uVkMAjejgCBhi\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-22 01:24:49', '2020-04-22 01:24:49'),
(1353, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:27:36', '2020-04-22 01:27:36'),
(1354, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:27:55', '2020-04-22 01:27:55'),
(1355, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:28:23', '2020-04-22 01:28:23'),
(1356, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:30:03', '2020-04-22 01:30:03'),
(1357, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:30:33', '2020-04-22 01:30:33'),
(1358, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:32:07', '2020-04-22 01:32:07'),
(1359, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 01:32:25', '2020-04-22 01:32:25'),
(1360, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-22 01:32:28', '2020-04-22 01:32:28'),
(1361, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 01:32:30', '2020-04-22 01:32:30'),
(1362, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:34:01', '2020-04-22 01:34:01'),
(1363, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:34:02', '2020-04-22 01:34:02'),
(1364, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":null,\"factory\":null,\"head\":\"1\",\"tail\":\"99\",\"_token\":\"OEJHDYmXFHrgCbQgsT85pJy6Nu5uVkMAjejgCBhi\",\"_action\":\"App_Admin_Actions_MachineHeadTail\"}', '2020-04-22 01:34:11', '2020-04-22 01:34:11'),
(1365, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 01:35:20', '2020-04-22 01:35:20'),
(1366, 1, 'admin/machines/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 02:23:56', '2020-04-22 02:23:56'),
(1367, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 02:24:02', '2020-04-22 02:24:02'),
(1368, 1, 'admin/machines/3/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 02:24:32', '2020-04-22 02:24:32'),
(1369, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 02:24:34', '2020-04-22 02:24:34'),
(1370, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 02:24:38', '2020-04-22 02:24:38'),
(1371, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:35:16', '2020-04-22 09:35:16'),
(1372, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:35:21', '2020-04-22 09:35:21'),
(1373, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:35:45', '2020-04-22 09:35:45'),
(1374, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:35:46', '2020-04-22 09:35:46'),
(1375, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:35:48', '2020-04-22 09:35:48'),
(1376, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:08', '2020-04-22 09:36:08'),
(1377, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:09', '2020-04-22 09:36:09'),
(1378, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:10', '2020-04-22 09:36:10'),
(1379, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:25', '2020-04-22 09:36:25'),
(1380, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:26', '2020-04-22 09:36:26'),
(1381, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:40', '2020-04-22 09:36:40'),
(1382, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:36:40', '2020-04-22 09:36:40'),
(1383, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 09:39:35', '2020-04-22 09:39:35'),
(1384, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 09:39:56', '2020-04-22 09:39:56'),
(1385, 1, 'admin/machines-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:05', '2020-04-22 09:40:05'),
(1386, 1, 'admin/machines-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:10', '2020-04-22 09:40:10'),
(1387, 1, 'admin/machines-types', 'POST', '127.0.0.1', '{\"name\":\"1.1\\u673a\\u5177\",\"state\":\"on\",\"sort\":\"1\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-types\"}', '2020-04-22 09:40:19', '2020-04-22 09:40:19'),
(1388, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-22 09:40:19', '2020-04-22 09:40:19'),
(1389, 1, 'admin/machines-types/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:21', '2020-04-22 09:40:21'),
(1390, 1, 'admin/machines-types', 'POST', '127.0.0.1', '{\"name\":\"3.0\\u673a\\u5177\",\"state\":\"on\",\"sort\":\"1\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-types\"}', '2020-04-22 09:40:25', '2020-04-22 09:40:25'),
(1391, 1, 'admin/machines-types', 'GET', '127.0.0.1', '[]', '2020-04-22 09:40:25', '2020-04-22 09:40:25'),
(1392, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:27', '2020-04-22 09:40:27'),
(1393, 1, 'admin/machines-factories/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:29', '2020-04-22 09:40:29'),
(1394, 1, 'admin/machines-factories', 'POST', '127.0.0.1', '{\"factory_name\":\"\\u5382\\u5546\\u540d\\u5b57\",\"type_id\":\"2\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-factories\"}', '2020-04-22 09:40:40', '2020-04-22 09:40:40'),
(1395, 1, 'admin/machines-factories', 'GET', '127.0.0.1', '[]', '2020-04-22 09:40:40', '2020-04-22 09:40:40'),
(1396, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:41', '2020-04-22 09:40:41'),
(1397, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:40:43', '2020-04-22 09:40:43'),
(1398, 1, 'admin/machines-styles', 'POST', '127.0.0.1', '{\"style_name\":\"\\u6d4b\\u8bd5\\u578b\\u53f72\",\"aa\":\"2\",\"factory_id\":\"2\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/machines-styles\"}', '2020-04-22 09:41:03', '2020-04-22 09:41:03'),
(1399, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '[]', '2020-04-22 09:41:03', '2020-04-22 09:41:03'),
(1400, 1, 'admin/machines-styles/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:41:06', '2020-04-22 09:41:06'),
(1401, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:41:20', '2020-04-22 09:41:20'),
(1402, 1, 'admin/_handle_action_', 'POST', '127.0.0.1', '{\"type\":\"1\",\"factory\":null,\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_action\":\"App_Admin_Actions_ImportMachines\"}', '2020-04-22 09:42:11', '2020-04-22 09:42:11'),
(1403, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:42:11', '2020-04-22 09:42:11'),
(1404, 1, 'admin/machines/1', 'PUT', '127.0.0.1', '{\"open_state\":\"on\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_method\":\"PUT\"}', '2020-04-22 09:42:35', '2020-04-22 09:42:35'),
(1405, 1, 'admin/machines/1', 'PUT', '127.0.0.1', '{\"open_state\":\"off\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_method\":\"PUT\"}', '2020-04-22 09:42:37', '2020-04-22 09:42:37'),
(1406, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:43:23', '2020-04-22 09:43:23'),
(1407, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:43:26', '2020-04-22 09:43:26'),
(1408, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:43:26', '2020-04-22 09:43:26'),
(1409, 1, 'admin/machines/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:46:06', '2020-04-22 09:46:06'),
(1410, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:46:14', '2020-04-22 09:46:14'),
(1411, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 09:53:46', '2020-04-22 09:53:46'),
(1412, 1, 'admin/machines/1', 'PUT', '127.0.0.1', '{\"open_state\":\"on\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_method\":\"PUT\"}', '2020-04-22 09:53:58', '2020-04-22 09:53:58'),
(1413, 1, 'admin/machines/1', 'PUT', '127.0.0.1', '{\"open_state\":\"off\",\"_token\":\"6Qf5HmO6nPID3GgvBEF00h0FPv11s1fpeTKKRZ1k\",\"_method\":\"PUT\"}', '2020-04-22 09:53:59', '2020-04-22 09:53:59'),
(1414, 1, 'admin/machines', 'GET', '127.0.0.1', '[]', '2020-04-22 09:54:49', '2020-04-22 09:54:49'),
(1415, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:59:45', '2020-04-22 09:59:45'),
(1416, 1, 'admin/users/5', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 09:59:49', '2020-04-22 09:59:49'),
(1417, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 10:01:53', '2020-04-22 10:01:53'),
(1418, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 10:03:11', '2020-04-22 10:03:11'),
(1419, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 10:04:21', '2020-04-22 10:04:21'),
(1420, 1, 'admin/machines-styles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-22 10:04:26', '2020-04-22 10:04:26'),
(1421, 3, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-23 01:05:34', '2020-04-23 01:05:34'),
(1422, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-23 01:05:49', '2020-04-23 01:05:49'),
(1423, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 01:15:34', '2020-04-23 01:15:34'),
(1424, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 01:44:52', '2020-04-23 01:44:52'),
(1425, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 01:45:51', '2020-04-23 01:45:51'),
(1426, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 06:18:33', '2020-04-23 06:18:33'),
(1427, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u4ea4\\u6613\\u7ba1\\u7406\",\"icon\":\"fa-trademark\",\"uri\":null,\"roles\":[null],\"permission\":null,\"_token\":\"6d9QmCbg8IEi1vFrQ3kS7DSn8fHA5foJKZo3AoSu\"}', '2020-04-23 06:18:54', '2020-04-23 06:18:54'),
(1428, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-23 06:18:54', '2020-04-23 06:18:54'),
(1429, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-23 06:19:07', '2020-04-23 06:19:07'),
(1430, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"6d9QmCbg8IEi1vFrQ3kS7DSn8fHA5foJKZo3AoSu\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17,\\\"children\\\":[{\\\"id\\\":21},{\\\"id\\\":22}]},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":23,\\\"children\\\":[{\\\"id\\\":24},{\\\"id\\\":25},{\\\"id\\\":26},{\\\"id\\\":27}]},{\\\"id\\\":19},{\\\"id\\\":28},{\\\"id\\\":18},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":20},{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]}]\"}', '2020-04-23 06:19:12', '2020-04-23 06:19:12'),
(1431, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 06:19:12', '2020-04-23 06:19:12'),
(1432, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-23 06:19:15', '2020-04-23 06:19:15'),
(1433, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 06:19:17', '2020-04-23 06:19:17'),
(1434, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 06:23:12', '2020-04-23 06:23:12'),
(1435, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"28\",\"title\":\"\\u4ea4\\u6613\\u5217\\u8868\",\"icon\":\"fa-dedent\",\"uri\":\"trades\",\"roles\":[null],\"permission\":null,\"_token\":\"6d9QmCbg8IEi1vFrQ3kS7DSn8fHA5foJKZo3AoSu\"}', '2020-04-23 06:24:07', '2020-04-23 06:24:07'),
(1436, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-23 06:24:07', '2020-04-23 06:24:07'),
(1437, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-23 06:24:11', '2020-04-23 06:24:11'),
(1438, 1, 'admin/trades', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 06:24:15', '2020-04-23 06:24:15'),
(1439, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:27:54', '2020-04-23 06:27:54'),
(1440, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:28:36', '2020-04-23 06:28:36'),
(1441, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:28:53', '2020-04-23 06:28:53'),
(1442, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:30:34', '2020-04-23 06:30:34'),
(1443, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:31:12', '2020-04-23 06:31:12'),
(1444, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:33:57', '2020-04-23 06:33:57'),
(1445, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:49:48', '2020-04-23 06:49:48'),
(1446, 1, 'admin/trades', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 06:51:58', '2020-04-23 06:51:58'),
(1447, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 06:54:24', '2020-04-23 06:54:24'),
(1448, 1, 'admin/trades', 'GET', '127.0.0.1', '[]', '2020-04-23 07:12:37', '2020-04-23 07:12:37'),
(1449, 1, 'admin/trades/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-23 07:12:41', '2020-04-23 07:12:41'),
(1450, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-23 07:13:07', '2020-04-23 07:13:07'),
(1451, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-23 07:13:18', '2020-04-23 07:13:18'),
(1452, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-23 07:13:51', '2020-04-23 07:13:51'),
(1453, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-24 08:54:32', '2020-04-24 08:54:32'),
(1454, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 08:54:44', '2020-04-24 08:54:44'),
(1455, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 08:56:57', '2020-04-24 08:56:57'),
(1456, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"18\",\"title\":\"\\u63d0\\u73b0\\u5217\\u8868\",\"icon\":\"fa-cny\",\"uri\":\"withdraws\",\"roles\":[null],\"permission\":null,\"_token\":\"ESVrMez539YYXHBl44UUcUfsWYMPRhdmNyZ2CaAk\"}', '2020-04-24 08:57:28', '2020-04-24 08:57:28'),
(1457, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-24 08:57:28', '2020-04-24 08:57:28'),
(1458, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 08:57:30', '2020-04-24 08:57:30'),
(1459, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-24 08:57:33', '2020-04-24 08:57:33'),
(1460, 1, 'admin/withdraws', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 08:57:34', '2020-04-24 08:57:34'),
(1461, 1, 'admin/withdraws', 'GET', '127.0.0.1', '[]', '2020-04-24 08:58:57', '2020-04-24 08:58:57'),
(1462, 1, 'admin/withdraws', 'GET', '127.0.0.1', '[]', '2020-04-24 08:59:48', '2020-04-24 08:59:48'),
(1463, 1, 'admin/withdraws', 'GET', '127.0.0.1', '[]', '2020-04-24 09:09:10', '2020-04-24 09:09:10'),
(1464, 1, 'admin/withdraws', 'GET', '127.0.0.1', '[]', '2020-04-24 09:10:38', '2020-04-24 09:10:38'),
(1465, 1, 'admin/trades', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:10:41', '2020-04-24 09:10:41'),
(1466, 1, 'admin/trades/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:10:43', '2020-04-24 09:10:43'),
(1467, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-24 09:15:08', '2020-04-24 09:15:08'),
(1468, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-24 09:16:33', '2020-04-24 09:16:33'),
(1469, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-24 09:17:18', '2020-04-24 09:17:18'),
(1470, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-24 09:18:45', '2020-04-24 09:18:45'),
(1471, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-24 09:18:58', '2020-04-24 09:18:58'),
(1472, 1, 'admin/trades/1', 'GET', '127.0.0.1', '[]', '2020-04-24 09:20:31', '2020-04-24 09:20:31'),
(1473, 1, 'admin/withdraws', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:20:35', '2020-04-24 09:20:35'),
(1474, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:42:54', '2020-04-24 09:42:54'),
(1475, 1, 'admin/withdraws', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:42:59', '2020-04-24 09:42:59'),
(1476, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:43:03', '2020-04-24 09:43:03'),
(1477, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:43:06', '2020-04-24 09:43:06'),
(1478, 1, 'admin/withdraws', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-24 09:43:08', '2020-04-24 09:43:08'),
(1479, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-26 00:55:39', '2020-04-26 00:55:39'),
(1480, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 00:57:06', '2020-04-26 00:57:06'),
(1481, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 00:57:08', '2020-04-26 00:57:08'),
(1482, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"sort\",\"type\":\"desc\"}}', '2020-04-26 00:57:24', '2020-04-26 00:57:24'),
(1483, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"sort\",\"type\":\"asc\"}}', '2020-04-26 00:57:25', '2020-04-26 00:57:25');
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(1484, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"active\",\"type\":\"desc\"}}', '2020-04-26 00:57:35', '2020-04-26 00:57:35'),
(1485, 1, 'admin/plugs/1', 'PUT', '127.0.0.1', '{\"active\":\"off\",\"_token\":\"pY50Xn6yvNDsTpt46AjRNvadrRRnMRpcFT40AArO\",\"_method\":\"PUT\"}', '2020-04-26 00:57:36', '2020-04-26 00:57:36'),
(1486, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"active\",\"type\":\"asc\"}}', '2020-04-26 00:57:38', '2020-04-26 00:57:38'),
(1487, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"active\",\"type\":\"desc\"}}', '2020-04-26 00:57:39', '2020-04-26 00:57:39'),
(1488, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_sort\":{\"column\":\"active\",\"type\":\"asc\"}}', '2020-04-26 00:57:41', '2020-04-26 00:57:41'),
(1489, 1, 'admin/trades', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 00:57:59', '2020-04-26 00:57:59'),
(1490, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 00:58:08', '2020-04-26 00:58:08'),
(1491, 1, 'admin/withdraws', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 00:58:10', '2020-04-26 00:58:10'),
(1492, 1, 'admin/trades', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 00:58:16', '2020-04-26 00:58:16'),
(1493, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 02:11:41', '2020-04-26 02:11:41'),
(1494, 1, 'admin/trades', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 07:53:26', '2020-04-26 07:53:26'),
(1495, 1, 'admin/machines', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 07:53:29', '2020-04-26 07:53:29'),
(1496, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 08:11:36', '2020-04-26 08:11:36'),
(1497, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 08:11:40', '2020-04-26 08:11:40'),
(1498, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 08:11:43', '2020-04-26 08:11:43'),
(1499, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-26 08:11:49', '2020-04-26 08:11:49'),
(1500, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 01:43:42', '2020-04-28 01:43:42'),
(1501, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 03:54:32', '2020-04-28 03:54:32'),
(1502, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:00', '2020-04-28 06:04:00'),
(1503, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:06', '2020-04-28 06:04:06'),
(1504, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:09', '2020-04-28 06:04:09'),
(1505, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:10', '2020-04-28 06:04:10'),
(1506, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:24', '2020-04-28 06:04:24'),
(1507, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:27', '2020-04-28 06:04:27'),
(1508, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:28', '2020-04-28 06:04:28'),
(1509, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:30', '2020-04-28 06:04:30'),
(1510, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:04:30', '2020-04-28 06:04:30'),
(1511, 1, 'admin/share-types', 'GET', '127.0.0.1', '[]', '2020-04-28 06:09:24', '2020-04-28 06:09:24'),
(1512, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:09:31', '2020-04-28 06:09:31'),
(1513, 1, 'admin/auth/menu/31/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:09:34', '2020-04-28 06:09:34'),
(1514, 1, 'admin/auth/menu/31', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u7cfb\\u7edf\\u53d8\\u91cf\",\"icon\":\"fa-gears\",\"uri\":\"env-manager\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:09:46', '2020-04-28 06:09:46'),
(1515, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:09:46', '2020-04-28 06:09:46'),
(1516, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:09:49', '2020-04-28 06:09:49'),
(1517, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:17:22', '2020-04-28 06:17:22'),
(1518, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:27', '2020-04-28 06:17:27'),
(1519, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:33', '2020-04-28 06:17:33'),
(1520, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:33', '2020-04-28 06:17:33'),
(1521, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"list\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:35', '2020-04-28 06:17:35'),
(1522, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"list\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:36', '2020-04-28 06:17:36'),
(1523, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"list\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:36', '2020-04-28 06:17:36'),
(1524, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"table\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:37', '2020-04-28 06:17:37'),
(1525, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:39', '2020-04-28 06:17:39'),
(1526, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/images\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:40', '2020-04-28 06:17:40'),
(1527, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:43', '2020-04-28 06:17:43'),
(1528, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:51', '2020-04-28 06:17:51'),
(1529, 1, 'admin/auth/menu/32/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:17:56', '2020-04-28 06:17:56'),
(1530, 1, 'admin/auth/menu/32', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u5a92\\u4f53\\u7ba1\\u7406\",\"icon\":\"fa-file\",\"uri\":\"media\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:18:03', '2020-04-28 06:18:03'),
(1531, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:18:03', '2020-04-28 06:18:03'),
(1532, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:18:06', '2020-04-28 06:18:06'),
(1533, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:18:10', '2020-04-28 06:18:10'),
(1534, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:18:14', '2020-04-28 06:18:14'),
(1535, 1, 'admin/auth/menu/32/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:18:17', '2020-04-28 06:18:17'),
(1536, 1, 'admin/auth/menu/32/edit', 'GET', '127.0.0.1', '[]', '2020-04-28 06:18:25', '2020-04-28 06:18:25'),
(1537, 1, 'admin/auth/menu/32', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u5a92\\u4f53\\u7ba1\\u7406\",\"icon\":\"fa-file-archive-o\",\"uri\":\"media\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:19:21', '2020-04-28 06:19:21'),
(1538, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:19:21', '2020-04-28 06:19:21'),
(1539, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:19:23', '2020-04-28 06:19:23'),
(1540, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:31:23', '2020-04-28 06:31:23'),
(1541, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:35:17', '2020-04-28 06:35:17'),
(1542, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:45:29', '2020-04-28 06:45:29'),
(1543, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17,\\\"children\\\":[{\\\"id\\\":21},{\\\"id\\\":22}]},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":23,\\\"children\\\":[{\\\"id\\\":24},{\\\"id\\\":25},{\\\"id\\\":26},{\\\"id\\\":27}]},{\\\"id\\\":19},{\\\"id\\\":28,\\\"children\\\":[{\\\"id\\\":29}]},{\\\"id\\\":18,\\\"children\\\":[{\\\"id\\\":30}]},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":20},{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]},{\\\"id\\\":32},{\\\"id\\\":33},{\\\"id\\\":31}]\"}', '2020-04-28 06:45:39', '2020-04-28 06:45:39'),
(1544, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:45:39', '2020-04-28 06:45:39'),
(1545, 1, 'admin/auth/menu/33/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:45:42', '2020-04-28 06:45:42'),
(1546, 1, 'admin/auth/menu/33', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"icon\":\"fa-database\",\"uri\":\"logs\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:45:50', '2020-04-28 06:45:50'),
(1547, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:45:50', '2020-04-28 06:45:50'),
(1548, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:45:52', '2020-04-28 06:45:52'),
(1549, 1, 'admin/logs', 'GET', '127.0.0.1', '[]', '2020-04-28 06:45:54', '2020-04-28 06:45:54'),
(1550, 1, 'admin/logs/laravel.log/tail', 'GET', '127.0.0.1', '{\"offset\":\"1682541\"}', '2020-04-28 06:46:09', '2020-04-28 06:46:09'),
(1551, 1, 'admin/logs', 'GET', '127.0.0.1', '[]', '2020-04-28 06:47:59', '2020-04-28 06:47:59'),
(1552, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:02', '2020-04-28 06:48:02'),
(1553, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-1529779\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:05', '2020-04-28 06:48:05'),
(1554, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-1195948\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:07', '2020-04-28 06:48:07'),
(1555, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-931822\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:10', '2020-04-28 06:48:10'),
(1556, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-650086\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:12', '2020-04-28 06:48:12'),
(1557, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-439604\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:13', '2020-04-28 06:48:13'),
(1558, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-126997\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:14', '2020-04-28 06:48:14'),
(1559, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"126997\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:15', '2020-04-28 06:48:15'),
(1560, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-126997\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:16', '2020-04-28 06:48:16'),
(1561, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"126997\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:17', '2020-04-28 06:48:17'),
(1562, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"-126997\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:18', '2020-04-28 06:48:18'),
(1563, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"offset\":\"126997\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:20', '2020-04-28 06:48:20'),
(1564, 1, 'admin/logs/laravel.log', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:48:23', '2020-04-28 06:48:23'),
(1565, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:50:56', '2020-04-28 06:50:56'),
(1566, 1, 'admin/shares/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:50:57', '2020-04-28 06:50:57'),
(1567, 1, 'admin/shares/create', 'GET', '127.0.0.1', '[]', '2020-04-28 06:56:33', '2020-04-28 06:56:33'),
(1568, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:56:39', '2020-04-28 06:56:39'),
(1569, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_order\":\"[{\\\"id\\\":8,\\\"children\\\":[{\\\"id\\\":9},{\\\"id\\\":10}]},{\\\"id\\\":11,\\\"children\\\":[{\\\"id\\\":12},{\\\"id\\\":13}]},{\\\"id\\\":17,\\\"children\\\":[{\\\"id\\\":21},{\\\"id\\\":22}]},{\\\"id\\\":14,\\\"children\\\":[{\\\"id\\\":16},{\\\"id\\\":15}]},{\\\"id\\\":23,\\\"children\\\":[{\\\"id\\\":24},{\\\"id\\\":25},{\\\"id\\\":26},{\\\"id\\\":27}]},{\\\"id\\\":19},{\\\"id\\\":28,\\\"children\\\":[{\\\"id\\\":29}]},{\\\"id\\\":18,\\\"children\\\":[{\\\"id\\\":30}]},{\\\"id\\\":1},{\\\"id\\\":2,\\\"children\\\":[{\\\"id\\\":20},{\\\"id\\\":3},{\\\"id\\\":4},{\\\"id\\\":5},{\\\"id\\\":6},{\\\"id\\\":7}]},{\\\"id\\\":32},{\\\"id\\\":34},{\\\"id\\\":33},{\\\"id\\\":31}]\"}', '2020-04-28 06:56:47', '2020-04-28 06:56:47'),
(1570, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:56:47', '2020-04-28 06:56:47'),
(1571, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:56:49', '2020-04-28 06:56:49'),
(1572, 1, 'admin/auth/menu/34/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:56:52', '2020-04-28 06:56:52'),
(1573, 1, 'admin/auth/menu/34', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"Redis\\u7ba1\\u7406\",\"icon\":\"fa-database\",\"uri\":\"redis\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:57:08', '2020-04-28 06:57:08'),
(1574, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:57:08', '2020-04-28 06:57:08'),
(1575, 1, 'admin/auth/menu/33/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:57:12', '2020-04-28 06:57:12'),
(1576, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:57:18', '2020-04-28 06:57:18'),
(1577, 1, 'admin/auth/menu/33/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:57:21', '2020-04-28 06:57:21'),
(1578, 1, 'admin/auth/menu/33', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"icon\":\"fa-list-ul\",\"uri\":\"logs\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:58:07', '2020-04-28 06:58:07'),
(1579, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:58:07', '2020-04-28 06:58:07'),
(1580, 1, 'admin/auth/menu/32/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:14', '2020-04-28 06:58:14'),
(1581, 1, 'admin/auth/menu/32', 'PUT', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u5a92\\u4f53\\u7ba1\\u7406\",\"icon\":\"fa-folder-open-o\",\"uri\":\"media\",\"roles\":[null],\"permission\":null,\"_token\":\"JPy59UYVTmWB02zbNsHGIZcaGYEOcdl8yLs6xC4o\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/www.chb.com\\/admin\\/auth\\/menu\"}', '2020-04-28 06:58:28', '2020-04-28 06:58:28'),
(1582, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:58:28', '2020-04-28 06:58:28'),
(1583, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-04-28 06:58:30', '2020-04-28 06:58:30'),
(1584, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:33', '2020-04-28 06:58:33'),
(1585, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/uploads\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:35', '2020-04-28 06:58:35'),
(1586, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/uploads\\/image\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:36', '2020-04-28 06:58:36'),
(1587, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/uploads\\/image\\/2020\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:38', '2020-04-28 06:58:38'),
(1588, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/uploads\\/image\\/2020\\/04\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:52', '2020-04-28 06:58:52'),
(1589, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/uploads\\/image\\/2020\\/04\\/21\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:58:54', '2020-04-28 06:58:54'),
(1590, 1, 'admin/media/download', 'GET', '127.0.0.1', '{\"file\":\"uploads\\/image\\/2020\\/04\\/21\\/\\u5c71\\u5206logo.jpg\"}', '2020-04-28 06:58:58', '2020-04-28 06:58:58'),
(1591, 1, 'admin/media/download', 'GET', '127.0.0.1', '{\"file\":\"uploads\\/image\\/2020\\/04\\/21\\/\\u5c71\\u5206logo.jpg\"}', '2020-04-28 06:58:58', '2020-04-28 06:58:58'),
(1592, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:59:12', '2020-04-28 06:59:12'),
(1593, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"list\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:59:35', '2020-04-28 06:59:35'),
(1594, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"table\",\"_pjax\":\"#pjax-container\"}', '2020-04-28 06:59:45', '2020-04-28 06:59:45'),
(1595, 1, 'admin/media', 'GET', '127.0.0.1', '{\"path\":\"\\/\",\"view\":\"table\"}', '2020-04-28 06:59:55', '2020-04-28 06:59:55'),
(1596, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 07:04:39', '2020-04-28 07:04:39'),
(1597, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-28 07:04:51', '2020-04-28 07:04:51'),
(1598, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-28 07:05:01', '2020-04-28 07:05:01'),
(1599, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-28 07:05:29', '2020-04-28 07:05:29'),
(1600, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-28 07:06:00', '2020-04-28 07:06:00'),
(1601, 1, 'admin/plugs', 'GET', '127.0.0.1', '[]', '2020-04-28 07:06:06', '2020-04-28 07:06:06'),
(1602, 1, 'admin/env-manager', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 07:14:08', '2020-04-28 07:14:08'),
(1603, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:51:21', '2020-04-28 08:51:21'),
(1604, 1, 'admin/env-manager', 'GET', '127.0.0.1', '[]', '2020-04-28 08:51:23', '2020-04-28 08:51:23'),
(1605, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:51:34', '2020-04-28 08:51:34'),
(1606, 1, 'admin/env-manager', 'GET', '127.0.0.1', '[]', '2020-04-28 08:51:35', '2020-04-28 08:51:35'),
(1607, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:52:29', '2020-04-28 08:52:29'),
(1608, 1, 'admin/env-manager', 'GET', '127.0.0.1', '[]', '2020-04-28 08:52:30', '2020-04-28 08:52:30'),
(1609, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:52:30', '2020-04-28 08:52:30'),
(1610, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:52:31', '2020-04-28 08:52:31'),
(1611, 1, 'admin/media', 'GET', '127.0.0.1', '[]', '2020-04-28 08:52:31', '2020-04-28 08:52:31'),
(1612, 1, 'admin/env-manager', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:52:34', '2020-04-28 08:52:34'),
(1613, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:52:35', '2020-04-28 08:52:35'),
(1614, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:52:36', '2020-04-28 08:52:36'),
(1615, 1, 'admin/logs', 'GET', '127.0.0.1', '[]', '2020-04-28 08:52:36', '2020-04-28 08:52:36'),
(1616, 1, 'admin/env-manager', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 08:57:16', '2020-04-28 08:57:16'),
(1617, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:11:39', '2020-04-28 09:11:39'),
(1618, 1, 'admin/env-manager', 'GET', '127.0.0.1', '[]', '2020-04-28 09:11:40', '2020-04-28 09:11:40'),
(1619, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:12:27', '2020-04-28 09:12:27'),
(1620, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 09:13:39', '2020-04-28 09:13:39'),
(1621, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 09:34:31', '2020-04-28 09:34:31'),
(1622, 1, 'admin/env-manager', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:33', '2020-04-28 09:34:33'),
(1623, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:36', '2020-04-28 09:34:36'),
(1624, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:39', '2020-04-28 09:34:39'),
(1625, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:34:40', '2020-04-28 09:34:40'),
(1626, 1, 'admin/logs', 'GET', '127.0.0.1', '[]', '2020-04-28 09:34:44', '2020-04-28 09:34:44'),
(1627, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:46', '2020-04-28 09:34:46'),
(1628, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:50', '2020-04-28 09:34:50'),
(1629, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:51', '2020-04-28 09:34:51'),
(1630, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:34:52', '2020-04-28 09:34:52'),
(1631, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:34:53', '2020-04-28 09:34:53'),
(1632, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 09:37:46', '2020-04-28 09:37:46'),
(1633, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 09:39:59', '2020-04-28 09:39:59'),
(1634, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:40:01', '2020-04-28 09:40:01'),
(1635, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:40:01', '2020-04-28 09:40:01'),
(1636, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 09:40:13', '2020-04-28 09:40:13'),
(1637, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:40:15', '2020-04-28 09:40:15'),
(1638, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:40:16', '2020-04-28 09:40:16'),
(1639, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-28 09:40:19', '2020-04-28 09:40:19'),
(1640, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:40:21', '2020-04-28 09:40:21'),
(1641, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:40:21', '2020-04-28 09:40:21'),
(1642, 1, 'admin/env-manager', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:43:08', '2020-04-28 09:43:08'),
(1643, 1, 'admin/env-manager', 'GET', '127.0.0.1', '[]', '2020-04-28 09:52:29', '2020-04-28 09:52:29'),
(1644, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:52:32', '2020-04-28 09:52:32'),
(1645, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:52:34', '2020-04-28 09:52:34'),
(1646, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:52:34', '2020-04-28 09:52:34'),
(1647, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:53:13', '2020-04-28 09:53:13'),
(1648, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-28 09:53:13', '2020-04-28 09:53:13'),
(1649, 1, 'admin/logs', 'GET', '127.0.0.1', '[]', '2020-04-28 09:53:17', '2020-04-28 09:53:17'),
(1650, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-28 09:53:40', '2020-04-28 09:53:40'),
(1651, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-04-29 01:43:07', '2020-04-29 01:43:07'),
(1652, 1, 'admin/redis', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-29 02:59:28', '2020-04-29 02:59:28'),
(1653, 1, 'admin/redis', 'GET', '127.0.0.1', '[]', '2020-04-29 02:59:29', '2020-04-29 02:59:29'),
(1654, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-29 09:15:15', '2020-04-29 09:15:15'),
(1655, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-29 09:15:17', '2020-04-29 09:15:17'),
(1656, 1, 'admin/share-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-29 09:15:32', '2020-04-29 09:15:32'),
(1657, 1, 'admin/shares', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-04-29 09:15:33', '2020-04-29 09:15:33'),
(1658, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-05-06 00:53:16', '2020-05-06 00:53:16'),
(1659, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-05-06 00:53:57', '2020-05-06 00:53:57'),
(1660, 1, 'admin/plug-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 00:54:05', '2020-05-06 00:54:05'),
(1661, 1, 'admin/plugs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 00:54:06', '2020-05-06 00:54:06'),
(1662, 1, 'admin/article-types', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 00:54:09', '2020-05-06 00:54:09'),
(1663, 1, 'admin/articles', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 00:54:10', '2020-05-06 00:54:10'),
(1664, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 00:54:16', '2020-05-06 00:54:16'),
(1665, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-05-06 00:55:50', '2020-05-06 00:55:50'),
(1666, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-05-06 01:00:25', '2020-05-06 01:00:25'),
(1667, 1, 'admin/media', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:00:29', '2020-05-06 01:00:29'),
(1668, 1, 'admin/media', 'GET', '127.0.0.1', '[]', '2020-05-06 01:03:52', '2020-05-06 01:03:52'),
(1669, 1, 'admin/logs', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:27:59', '2020-05-06 01:27:59'),
(1670, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:28:04', '2020-05-06 01:28:04'),
(1671, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{\"parent_id\":\"0\",\"title\":\"\\u64cd\\u76d8\\u8bbe\\u7f6e\",\"icon\":\"fa-asterisk\",\"uri\":\"settings\",\"roles\":[null],\"permission\":null,\"_token\":\"pzIyEOTZQVgLJ3Rjcrbb8LCqf4CWDv8juTzWG1Ij\"}', '2020-05-06 01:28:30', '2020-05-06 01:28:30'),
(1672, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-05-06 01:28:30', '2020-05-06 01:28:30'),
(1673, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:29:02', '2020-05-06 01:29:02'),
(1674, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:29:20', '2020-05-06 01:29:20'),
(1675, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '[]', '2020-05-06 01:29:53', '2020-05-06 01:29:53'),
(1676, 1, 'admin/settings', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:30:01', '2020-05-06 01:30:01'),
(1677, 1, 'admin/settings', 'GET', '127.0.0.1', '[]', '2020-05-06 01:35:03', '2020-05-06 01:35:03'),
(1678, 1, 'admin/settings', 'GET', '127.0.0.1', '[]', '2020-05-06 01:35:53', '2020-05-06 01:35:53'),
(1679, 1, 'admin/settings', 'GET', '127.0.0.1', '[]', '2020-05-06 01:36:46', '2020-05-06 01:36:46'),
(1680, 1, 'admin/settings/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:36:49', '2020-05-06 01:36:49'),
(1681, 1, 'admin/settings/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-06 01:37:17', '2020-05-06 01:37:17'),
(1682, 1, 'admin/settings/1/edit', 'GET', '127.0.0.1', '[]', '2020-05-07 02:25:14', '2020-05-07 02:25:14'),
(1683, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-05-11 09:42:08', '2020-05-11 09:42:08');

-- --------------------------------------------------------

--
-- 表的结构 `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
(1, 'All permission', '*', '', '*', NULL, NULL),
(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL),
(6, '轮播图', '轮播图', 'GET,POST,PUT,DELETE', '/plugs*', '2020-04-18 09:08:17', '2020-04-18 09:29:43'),
(7, '分享素材', '分享素材', 'GET,POST,PUT,DELETE', '/shares*', '2020-04-20 03:33:37', '2020-04-20 03:33:37'),
(8, '会员管理', '会员管理', 'GET', '/users*', '2020-04-20 05:35:51', '2020-04-20 05:35:51'),
(9, '文章管理', '文章管理', 'GET,POST,PUT,DELETE', '/articles*', '2020-04-21 03:27:55', '2020-04-21 03:27:55'),
(10, 'Media manager', 'ext.media-manager', '', '/media*', '2020-04-28 06:16:55', '2020-04-28 06:16:55'),
(11, 'Logs', 'ext.log-viewer', '', '/logs*', '2020-04-28 06:45:25', '2020-04-28 06:45:25'),
(12, 'Redis Manager', 'ext.redis-manager', '', '/redis*', '2020-04-28 06:56:29', '2020-04-28 06:56:29');

-- --------------------------------------------------------

--
-- 表的结构 `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2020-04-16 02:33:23', '2020-04-16 02:33:23'),
(2, '操盘', '操盘', '2020-04-17 03:10:51', '2020-04-17 03:10:51');

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_menu`
--

CREATE TABLE `admin_role_menu` (
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_role_menu`
--

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 6, NULL, NULL),
(2, 7, NULL, NULL),
(2, 8, NULL, NULL),
(2, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_users`
--

CREATE TABLE `admin_role_users` (
  `role_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 3, NULL, NULL),
(1, 4, NULL, NULL),
(2, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'All' COMMENT '操盤',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `operate`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$CELazGO0RTgBS5WJmg1PXeTlD05SEzWybOZErDiHVUWcrgZeWGRKG', 'Administrator', NULL, 'All', 'zDxCTJWqar3Xad2TLMINgCYQpfwB02ZpMsFDeN0iyg3SUSPuzo9rWnYdlweU', '2020-04-16 02:33:23', '2020-04-16 02:33:23'),
(3, '15666446111', '$2y$10$NnbUc/6gNnEwnq/NscvTp.sL/R/iJnwMVr7De/qeSBG1n66FGWlyu', '菏泽木子数据', NULL, 'CP1002020041714132163', '5ngZgVe1ccakDATN8tzTmTCKorH6gQWHwTf09KWoxcFLbERST0uZTSbVrwUN', '2020-04-17 06:13:40', '2020-04-20 03:30:26'),
(4, 'admin1', '$2y$10$AXCxQR9Iz/2xufazOvi02.XM3sW71kzykcJvV6zFBGqokZ2hY70EC', 'admin', NULL, 'All', NULL, '2020-06-11 07:00:26', '2020-06-11 07:00:26');

-- --------------------------------------------------------

--
-- 表的结构 `admin_user_permissions`
--

CREATE TABLE `admin_user_permissions` (
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '文章标题',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `images` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '缩略图',
  `type_id` tinyint NOT NULL COMMENT '文章类型',
  `verify` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否审核',
  `operate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操盤号',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '操盤号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `articles`
--

INSERT INTO `articles` (`id`, `title`, `active`, `images`, `type_id`, `verify`, `operate`, `content`, `created_at`, `updated_at`) VALUES
(1, '测试', 1, 'images/山分logo.jpg', 1, '0', 'All', '<p><img src=\"http://www.chb.com/storage/uploads/image/2020/04/21/山分logo.jpg\" title=\"/uploads/image/2020/04/21/山分logo.jpg\" alt=\"山分logo.jpg\" width=\"227\" height=\"236\" style=\"width: 227px; height: 236px;\"/></p>', '2020-04-21 02:56:32', '2020-04-21 02:56:32');

-- --------------------------------------------------------

--
-- 表的结构 `article_types`
--

CREATE TABLE `article_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '类型名称',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `article_types`
--

INSERT INTO `article_types` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, '系统公告', 1, '2020-04-21 02:37:20', '2020-04-21 02:37:44');

-- --------------------------------------------------------

--
-- 表的结构 `cashs_logs`
--

CREATE TABLE `cashs_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL COMMENT '用户ID',
  `machine_id` int NOT NULL COMMENT '机器ID',
  `trade_id` int NOT NULL DEFAULT '0' COMMENT '交易ID',
  `money` int NOT NULL DEFAULT '0' COMMENT '分润金额，单位：分',
  `is_run` tinyint NOT NULL COMMENT '1分润，2返现',
  `type` tinyint NOT NULL COMMENT '类型，1直营分润，2团队分润，3激活返现，4间推激活返现，5间间推激活返现，6达标返现，7二次达标返现，8三次达标返现，9财商学院推荐奖励',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `machines`
--

CREATE TABLE `machines` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL COMMENT '归属人',
  `sn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '机器序列号',
  `open_state` tinyint NOT NULL DEFAULT '0' COMMENT '开通状态',
  `is_self` tinyint NOT NULL DEFAULT '0' COMMENT '是否是自备机',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `style_id` int DEFAULT NULL COMMENT '所属型号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `machines`
--

INSERT INTO `machines` (`id`, `user_id`, `sn`, `open_state`, `is_self`, `created_at`, `updated_at`, `style_id`) VALUES
(1, 5, '1', 0, 0, NULL, '2020-04-22 09:53:59', 1),
(2, NULL, '2', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(3, NULL, '3', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(4, NULL, '4', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(5, NULL, '5', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(6, NULL, '6', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(7, NULL, '7', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(8, NULL, '8', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(9, NULL, '9', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(10, NULL, '10', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(11, NULL, '11', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(12, NULL, '12', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(13, NULL, '13', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(14, NULL, '14', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(15, NULL, '15', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(16, NULL, '16', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(17, NULL, '17', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(18, NULL, '18', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(19, NULL, '19', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(20, NULL, '20', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(21, NULL, '21', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(22, NULL, '22', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(23, NULL, '23', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(24, NULL, '24', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(25, NULL, '25', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(26, NULL, '26', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(27, NULL, '27', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(28, NULL, '28', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(29, NULL, '29', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(30, NULL, '30', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(31, NULL, '31', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(32, NULL, '32', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(33, NULL, '33', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1),
(34, NULL, '34', 0, 0, '2020-04-21 09:02:17', '2020-04-21 09:02:17', 1);

-- --------------------------------------------------------

--
-- 表的结构 `machines_factories`
--

CREATE TABLE `machines_factories` (
  `id` bigint UNSIGNED NOT NULL,
  `factory_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '厂商名称',
  `type_id` tinyint NOT NULL COMMENT '所属类型',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `machines_factories`
--

INSERT INTO `machines_factories` (`id`, `factory_name`, `type_id`, `created_at`, `updated_at`) VALUES
(1, '测试厂商', 1, '2020-04-21 06:00:13', '2020-04-21 06:00:13'),
(2, '厂商名字', 2, '2020-04-22 09:40:40', '2020-04-22 09:40:40');

-- --------------------------------------------------------

--
-- 表的结构 `machines_styles`
--

CREATE TABLE `machines_styles` (
  `id` bigint UNSIGNED NOT NULL,
  `style_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '型号名称',
  `factory_id` tinyint NOT NULL COMMENT '所属厂商',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `machines_styles`
--

INSERT INTO `machines_styles` (`id`, `style_name`, `factory_id`, `created_at`, `updated_at`) VALUES
(1, '测试型号', 1, '2020-04-21 06:28:23', '2020-04-21 06:28:23'),
(2, '测试型号2', 2, '2020-04-22 09:41:03', '2020-04-22 09:41:03');

-- --------------------------------------------------------

--
-- 表的结构 `machines_types`
--

CREATE TABLE `machines_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '型号名称',
  `state` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `sort` int NOT NULL DEFAULT '0' COMMENT '排序权重',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `machines_types`
--

INSERT INTO `machines_types` (`id`, `name`, `state`, `sort`, `created_at`, `updated_at`) VALUES
(1, '自备机', 1, 1, '2020-04-21 05:46:48', '2020-04-21 05:46:48'),
(2, '1.1机具', 1, 1, '2020-04-22 09:40:19', '2020-04-22 09:40:19'),
(3, '3.0机具', 1, 1, '2020-04-22 09:40:25', '2020-04-22 09:40:25');

-- --------------------------------------------------------

--
-- 表的结构 `merchants`
--

CREATE TABLE `merchants` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL COMMENT '用户ID',
  `code` bigint NOT NULL COMMENT '商户号',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商户名称',
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商户电话',
  `trade_amount` int NOT NULL DEFAULT '0' COMMENT '商户累计交易金额，单位：分',
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '商户状态 0:无效, 1:有效, X：注销',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2016_01_04_173148_create_admin_tables', 1),
(3, '2017_07_17_040159_create_config_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_04_15_062202_create_user_wallets_table', 1),
(6, '2020_04_15_062637_create_user_groups_table', 1),
(7, '2020_04_15_064438_add_active_to_users_table', 1),
(8, '2020_04_15_064708_create_user_realnames_table', 1),
(9, '2020_04_15_065301_create_plug_types_table', 1),
(10, '2020_04_15_065505_create_plugs_table', 1),
(11, '2020_04_15_070023_create_share_types_table', 1),
(12, '2020_04_15_070207_create_shares_table', 1),
(13, '2020_04_15_070340_create_machines_types_table', 1),
(14, '2020_04_15_070448_create_machines_table', 1),
(15, '2020_04_15_080431_create_transfers_table', 1),
(16, '2020_04_15_084154_create_merchants_table', 1),
(17, '2020_04_15_084326_create_trades_table', 1),
(18, '2020_04_15_084456_create_cashs_logs_table', 1),
(19, '2020_04_15_084618_create_withdraws_table', 1),
(20, '2020_04_15_085309_create_withdraws_datas_table', 1),
(21, '2020_04_16_150413_change_merchants_table_tomerchants_table', 2),
(22, '2020_04_17_112921_add_operate_no_to_admin_users_table', 3),
(23, '2020_04_17_131244_add_operate_to_users_table', 4),
(24, '2020_04_17_131637_create_user_relations_table', 4),
(25, '2020_04_18_154717_add_api_token_to_users_table', 5),
(26, '2020_04_18_171437_add_operate_to_plugs_table', 6),
(27, '2020_04_20_122822_add_operate_to_shares_table', 7),
(28, '2020_04_21_095633_create_article_types_table', 8),
(29, '2020_04_21_095643_create_articles_table', 8),
(30, '2020_04_21_133624_create_machines_factories_table', 9),
(31, '2020_04_21_133646_create_machines_styles_table', 9),
(32, '2020_04_21_145630_add_type_id_to_machines_table', 10),
(33, '2020_04_23_143810_add_info_to_trades_table', 11),
(34, '2020_04_23_145241_add_json_to_trades_table', 12),
(35, '2020_05_06_091958_create_settings_table', 13);

-- --------------------------------------------------------

--
-- 表的结构 `plugs`
--

CREATE TABLE `plugs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '轮播标题',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `type_id` tinyint NOT NULL COMMENT '所属类型',
  `images` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片地址',
  `sort` tinyint NOT NULL DEFAULT '0' COMMENT '排序权重',
  `href` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '#' COMMENT '链接地址',
  `operate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操盤号',
  `verify` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否审核',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `plugs`
--

INSERT INTO `plugs` (`id`, `name`, `active`, `type_id`, `images`, `sort`, `href`, `operate`, `verify`, `created_at`, `updated_at`) VALUES
(1, '这里是测试轮播图', 0, 2, NULL, 0, '#', NULL, '1', '2020-04-16 04:24:43', '2020-04-26 00:57:36'),
(2, '222', 1, 2, NULL, 3, '#', NULL, '1', '2020-04-18 09:29:53', '2020-04-18 09:29:53'),
(3, '333', 1, 2, 'images/timg.jpg', 3, '#', 'CP1002020041714132163', '1', '2020-04-18 09:31:50', '2020-04-20 03:06:43');

-- --------------------------------------------------------

--
-- 表的结构 `plug_types`
--

CREATE TABLE `plug_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '类型名称',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `plug_types`
--

INSERT INTO `plug_types` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, '首页轮播图', 1, '2020-04-16 04:03:12', '2020-04-16 04:03:12'),
(2, '财商轮播图', 1, '2020-04-16 04:03:21', '2020-04-16 04:03:21');

-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `operate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '操盘方',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `settings`
--

INSERT INTO `settings` (`id`, `operate`, `created_at`, `updated_at`) VALUES
(1, 'CP1002020041714132163', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `shares`
--

CREATE TABLE `shares` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分享标题',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `images` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '素材地址',
  `type_id` tinyint NOT NULL COMMENT '类型ID',
  `sort` int NOT NULL DEFAULT '0' COMMENT '排序权重',
  `code_size` int NOT NULL DEFAULT '100' COMMENT '二维码大小',
  `code_x` int NOT NULL DEFAULT '100' COMMENT '二维码X轴位置',
  `code_y` int NOT NULL DEFAULT '100' COMMENT '二维码Y轴位置',
  `operate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操盤号',
  `verify` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否审核',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `shares`
--

INSERT INTO `shares` (`id`, `title`, `active`, `images`, `type_id`, `sort`, `code_size`, `code_x`, `code_y`, `operate`, `verify`, `created_at`, `updated_at`) VALUES
(1, '测试分享标题', 1, NULL, 1, 0, 100, 100, 100, NULL, '0', '2020-04-16 05:48:21', '2020-04-16 05:48:27'),
(2, '操盘分享', 1, 'images/b48082362238d7d0073dca898060f0d1.jpg', 2, 0, 100, 100, 100, 'CP1002020041714132163', '0', '2020-04-20 05:02:49', '2020-04-20 05:02:49');

-- --------------------------------------------------------

--
-- 表的结构 `share_types`
--

CREATE TABLE `share_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类名称',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '开启状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `share_types`
--

INSERT INTO `share_types` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, '团队扩展', 1, '2020-04-16 05:34:28', '2020-04-16 05:34:28'),
(2, '商户注册', 1, '2020-04-16 06:11:50', '2020-04-20 04:47:23');

-- --------------------------------------------------------

--
-- 表的结构 `trades`
--

CREATE TABLE `trades` (
  `id` bigint UNSIGNED NOT NULL,
  `trade_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '交易流水号',
  `user_id` int DEFAULT NULL COMMENT '用户ID',
  `machine_id` int DEFAULT NULL COMMENT '机器ID',
  `is_send` int NOT NULL DEFAULT '0' COMMENT '分润发放状态',
  `sn` int DEFAULT NULL COMMENT '机器序列号',
  `merchant_code` int NOT NULL COMMENT '商户号',
  `rrn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '参考号',
  `amount` int NOT NULL DEFAULT '0' COMMENT '交易金额，单位：分',
  `settle_amount` int NOT NULL DEFAULT '0' COMMENT '结算金额，单位：分',
  `cardType` tinyint DEFAULT NULL COMMENT '交易卡类型，0贷记卡，1借记卡',
  `trade_time` timestamp NULL DEFAULT NULL COMMENT '交易时间',
  `trade_post` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '推送报文',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `trades`
--

INSERT INTO `trades` (`id`, `trade_no`, `user_id`, `machine_id`, `is_send`, `sn`, `merchant_code`, `rrn`, `amount`, `settle_amount`, `cardType`, `trade_time`, `trade_post`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 0, NULL, 123, NULL, 0, 0, NULL, NULL, '{\"sign\": \"a5232e4e6e97c45521e686330357203e\", \"sendNum\": 15, \"dataList\": [{\"rrn\": \"145034815636\", \"amount\": \"73800\", \"cardNo\": \"622902******0104\", \"termId\": \"02006716\", \"termSn\": \"931902194693066\", \"agentId\": \"49030624\", \"batchNo\": \"000004\", \"feeType\": \"YM\", \"traceNo\": \"002599\", \"version\": \"1.1\", \"authCode\": \"316731\", \"cardType\": \"1\", \"mobileNo\": \"185****3000\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145034\", \"inputMode\": \"072\", \"termModel\": \"MP70\", \"activeStat\": \"2\", \"merchLevel\": \"3\", \"merchantId\": \"900457289990050\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"002599\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145034815636]返回[00]:交易成功\", \"merchantName\": \"个体商户刘婷婷\", \"settleAmount\": \"73520\", \"termBindDate\": \"20190403\"}, {\"rrn\": \"144905811318\", \"amount\": \"285500\", \"cardNo\": \"622602******5089\", \"termId\": \"01977126\", \"termSn\": \"911901179617533\", \"agentId\": \"49030624\", \"batchNo\": \"000002\", \"feeType\": \"B\", \"traceNo\": \"000586\", \"version\": \"1.1\", \"authCode\": \"210646\", \"cardType\": \"1\", \"mobileNo\": \"136****5813\", \"tranCode\": \"020000\", \"tranTime\": \"20200423144905\", \"inputMode\": \"071\", \"termModel\": \"H9\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900473179990186\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000586\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[144905811318]返回[00]:交易成功\", \"merchantName\": \"个体商户周丽建\", \"settleAmount\": \"283787\", \"termBindDate\": \"20190524\"}, {\"rrn\": \"144919812033\", \"amount\": \"62400\", \"cardNo\": \"622655******1579\", \"termId\": \"02006716\", \"termSn\": \"931902194693066\", \"agentId\": \"49030624\", \"batchNo\": \"000004\", \"feeType\": \"YM\", \"traceNo\": \"002595\", \"version\": \"1.1\", \"cardType\": \"1\", \"mobileNo\": \"185****3000\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423144919\", \"inputMode\": \"072\", \"termModel\": \"MP70\", \"activeStat\": \"2\", \"merchLevel\": \"3\", \"merchantId\": \"900457289990050\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"002595\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[144919812033]返回[00]:交易成功\", \"merchantName\": \"个体商户刘婷婷\", \"settleAmount\": \"62163\", \"termBindDate\": \"20190403\"}, {\"rrn\": \"144914811755\", \"amount\": \"39600\", \"cardNo\": \"625808******1823\", \"termId\": \"01907936\", \"termSn\": \"911812159718589\", \"agentId\": \"49030624\", \"batchNo\": \"000006\", \"feeType\": \"YM\", \"traceNo\": \"003636\", \"authCode\": \"579881\", \"cardType\": \"1\", \"mobileNo\": \"150****3928\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423144914\", \"inputMode\": \"072\", \"termModel\": \"H9\", \"merchLevel\": \"3\", \"merchantId\": \"900458853110169\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"003636\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[144914811755]返回[00]:交易成功\", \"merchantName\": \"个体商户尚文珍\", \"settleAmount\": \"39450\"}, {\"rrn\": \"144852810744\", \"amount\": \"49500\", \"cardNo\": \"622156******0571\", \"termId\": \"02005202\", \"termSn\": \"911901179619371\", \"agentId\": \"49030624\", \"batchNo\": \"000001\", \"feeType\": \"YM\", \"traceNo\": \"000525\", \"version\": \"1.1\", \"authCode\": \"873482\", \"cardType\": \"1\", \"mobileNo\": \"152****5853\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423144852\", \"inputMode\": \"072\", \"termModel\": \"H9\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900458157220128\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000525\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[144852810744]返回[00]:交易成功\", \"merchantName\": \"个体商户周海霞\", \"settleAmount\": \"49312\", \"termBindDate\": \"20200204\"}, {\"rrn\": \"145105817155\", \"amount\": \"950000\", \"cardNo\": \"439226******1902\", \"termId\": \"01979142\", \"termSn\": \"931901214692444\", \"agentId\": \"49030624\", \"batchNo\": \"000001\", \"feeType\": \"B\", \"traceNo\": \"000369\", \"version\": \"1.1\", \"authCode\": \"484589\", \"cardType\": \"1\", \"mobileNo\": \"177****8885\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145105\", \"inputMode\": \"021\", \"termModel\": \"MP70\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900475150940124\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000369\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145105817155]返回[00]:交易成功\", \"merchantName\": \"个体商户刘亚娟\", \"settleAmount\": \"944300\", \"termBindDate\": \"20190810\"}, {\"rrn\": \"145036815746\", \"amount\": \"85000\", \"cardNo\": \"625193******5522\", \"termId\": \"02005202\", \"termSn\": \"911901179619371\", \"agentId\": \"49030624\", \"batchNo\": \"000001\", \"feeType\": \"YM\", \"traceNo\": \"000527\", \"version\": \"1.1\", \"authCode\": \"710717\", \"cardType\": \"1\", \"mobileNo\": \"152****5853\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145036\", \"inputMode\": \"072\", \"termModel\": \"H9\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900458157220128\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000527\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145036815746]返回[00]:交易成功\", \"merchantName\": \"个体商户周海霞\", \"settleAmount\": \"84677\", \"termBindDate\": \"20200204\"}, {\"rrn\": \"145043816071\", \"amount\": \"189000\", \"cardNo\": \"622602******5089\", \"termId\": \"01977126\", \"termSn\": \"911901179617533\", \"agentId\": \"49030624\", \"batchNo\": \"000002\", \"feeType\": \"B\", \"traceNo\": \"000587\", \"version\": \"1.1\", \"authCode\": \"976010\", \"cardType\": \"1\", \"mobileNo\": \"136****5813\", \"tranCode\": \"020000\", \"tranTime\": \"20200423145043\", \"inputMode\": \"071\", \"termModel\": \"H9\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900473179990186\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000587\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145043816071]返回[00]:交易成功\", \"merchantName\": \"个体商户周丽建\", \"settleAmount\": \"187866\", \"termBindDate\": \"20190524\"}, {\"rrn\": \"145016814836\", \"amount\": \"67200\", \"cardNo\": \"622623******0526\", \"termId\": \"02006838\", \"termSn\": \"931902194693188\", \"agentId\": \"49030624\", \"batchNo\": \"000005\", \"feeType\": \"B\", \"traceNo\": \"002707\", \"version\": \"1.1\", \"authCode\": \"389436\", \"cardType\": \"1\", \"mobileNo\": \"137****6250\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145016\", \"inputMode\": \"051\", \"termModel\": \"MP70\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900458850940073\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"002707\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145016814836]返回[00]:交易成功\", \"merchantName\": \"个体商户曹克苓\", \"settleAmount\": \"66797\", \"termBindDate\": \"20190315\"}, {\"rrn\": \"145010814505\", \"amount\": \"1050000\", \"cardNo\": \"439226******1902\", \"termId\": \"01979142\", \"termSn\": \"931901214692444\", \"agentId\": \"49030624\", \"batchNo\": \"000001\", \"feeType\": \"B\", \"traceNo\": \"000368\", \"version\": \"1.1\", \"cardType\": \"1\", \"mobileNo\": \"177****8885\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145010\", \"inputMode\": \"021\", \"termModel\": \"MP70\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900475150940124\", \"sysTraceNo\": \"000368\", \"sysRespCode\": \"E9\", \"sysRespDesc\": \"交易金额[10500.00]大于磁条信用卡交易限额[10000.00]\", \"merchantName\": \"个体商户刘亚娟\", \"settleAmount\": \"1050000\", \"termBindDate\": \"20190810\"}, {\"rrn\": \"145004814172\", \"amount\": \"113700\", \"cardNo\": \"622576******9950\", \"termId\": \"02006716\", \"termSn\": \"931902194693066\", \"agentId\": \"49030624\", \"batchNo\": \"000004\", \"feeType\": \"B\", \"traceNo\": \"002597\", \"version\": \"1.1\", \"authCode\": \"471593\", \"cardType\": \"1\", \"mobileNo\": \"185****3000\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145004\", \"inputMode\": \"051\", \"termModel\": \"MP70\", \"activeStat\": \"2\", \"merchLevel\": \"3\", \"merchantId\": \"900457289990050\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"002597\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145004814172]返回[00]:交易成功\", \"merchantName\": \"个体商户刘婷婷\", \"settleAmount\": \"113018\", \"termBindDate\": \"20190403\"}, {\"rrn\": \"145047816251\", \"amount\": \"1420000\", \"cardNo\": \"622575******8515\", \"termId\": \"02005744\", \"termSn\": \"911901179619913\", \"agentId\": \"49030624\", \"batchNo\": \"000001\", \"feeType\": \"B\", \"traceNo\": \"000626\", \"version\": \"1.1\", \"authCode\": \"480802\", \"cardType\": \"1\", \"mobileNo\": \"156****6299\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145047\", \"inputMode\": \"071\", \"termModel\": \"H9\", \"activeStat\": \"2\", \"merchLevel\": \"3\", \"merchantId\": \"900458858130110\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000626\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145047816251]返回[00]:交易成功\", \"merchantName\": \"个体商户路畅\", \"settleAmount\": \"1411480\", \"termBindDate\": \"20190606\"}, {\"rrn\": \"145046816214\", \"amount\": \"89200\", \"cardNo\": \"622655******5139\", \"termId\": \"01907936\", \"termSn\": \"911812159718589\", \"agentId\": \"49030624\", \"batchNo\": \"000006\", \"feeType\": \"YM\", \"traceNo\": \"003640\", \"cardType\": \"1\", \"mobileNo\": \"150****3928\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145046\", \"inputMode\": \"072\", \"termModel\": \"H9\", \"merchLevel\": \"3\", \"merchantId\": \"900458853110169\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"003640\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145046816214]返回[00]:交易成功\", \"merchantName\": \"个体商户尚文珍\", \"settleAmount\": \"88861\"}, {\"rrn\": \"144950813463\", \"amount\": \"170500\", \"cardNo\": \"625086******5103\", \"termId\": \"01907936\", \"termSn\": \"911812159718589\", \"agentId\": \"49030624\", \"batchNo\": \"000006\", \"feeType\": \"B\", \"traceNo\": \"003638\", \"authCode\": \"574758\", \"cardType\": \"1\", \"mobileNo\": \"150****3928\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423144950\", \"inputMode\": \"071\", \"termModel\": \"H9\", \"merchLevel\": \"3\", \"merchantId\": \"900458853110169\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"003638\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[144950813463]返回[00]:交易成功\", \"merchantName\": \"个体商户尚文珍\", \"settleAmount\": \"169477\"}, {\"rrn\": \"145057816773\", \"amount\": \"93000\", \"cardNo\": \"622155******2661\", \"termId\": \"02005202\", \"termSn\": \"911901179619371\", \"agentId\": \"49030624\", \"batchNo\": \"000001\", \"feeType\": \"YM\", \"traceNo\": \"000529\", \"version\": \"1.1\", \"authCode\": \"881288\", \"cardType\": \"1\", \"mobileNo\": \"152****5853\", \"tranCode\": \"T20000\", \"tranTime\": \"20200423145057\", \"inputMode\": \"072\", \"termModel\": \"H9\", \"activeStat\": \"1\", \"merchLevel\": \"3\", \"merchantId\": \"900458157220128\", \"settleDate\": \"20200424\", \"sysTraceNo\": \"000529\", \"sysRespCode\": \"00\", \"sysRespDesc\": \"交易[145057816773]返回[00]:交易成功\", \"merchantName\": \"个体商户周海霞\", \"settleAmount\": \"92647\", \"termBindDate\": \"20200204\"}], \"dataType\": \"1\", \"sendTime\": \"20200423145134\", \"transDate\": \"20200423\", \"sendBatchNo\": \"000338\", \"configAgentId\": \"49030624\"}', '2020-04-23 07:12:10', '2020-04-23 07:12:10');

-- --------------------------------------------------------

--
-- 表的结构 `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `machine_id` bigint UNSIGNED NOT NULL COMMENT '机器ID',
  `old_user_id` int NOT NULL COMMENT '划拨前用户',
  `new_user_id` int NOT NULL COMMENT '划拨后用户',
  `state` tinyint NOT NULL COMMENT '类型 1划拨，2回拨',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nickname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '会员昵称',
  `account` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会员账号',
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'images/avatar.png' COMMENT '会员头像',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会员密码',
  `user_group` tinyint NOT NULL COMMENT '用户组',
  `parent` int NOT NULL DEFAULT '0' COMMENT '上级ID',
  `active` tinyint NOT NULL DEFAULT '1' COMMENT '用户状态',
  `operate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操盤',
  `api_token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'api_token',
  `last_ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '最后登录地址',
  `last_time` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `nickname`, `account`, `avatar`, `password`, `user_group`, `parent`, `active`, `operate`, `api_token`, `last_ip`, `last_time`, `created_at`, `updated_at`) VALUES
(5, '15666446111', '15666446111', 'images/avatar.png', '###d97f50dfdd987fc883d40fbd25ef0878', 1, 0, 1, 'CP1002020041714132163', '6478ead2bb6a36f8e532b3e78d17b763134c7fc2a63e76cd0eea2054ff4562a9', '127.0.0.1', '2020-05-06 05:27:52', '2020-04-17 06:13:40', '2020-05-06 05:27:52');

-- --------------------------------------------------------

--
-- 表的结构 `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户组名',
  `level` tinyint NOT NULL COMMENT '用户组级别',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `level`, `created_at`, `updated_at`) VALUES
(1, '普通用户', 0, '2020-04-16 06:55:06', '2020-04-16 06:55:06');

-- --------------------------------------------------------

--
-- 表的结构 `user_realnames`
--

CREATE TABLE `user_realnames` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT '会员ID',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '实名状态',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `idcard` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证号',
  `card_before` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证正面照片',
  `card_after` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '身份证反面照片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_realnames`
--

INSERT INTO `user_realnames` (`id`, `user_id`, `status`, `name`, `idcard`, `card_before`, `card_after`, `created_at`, `updated_at`) VALUES
(2, 5, 0, NULL, NULL, NULL, NULL, '2020-04-17 06:13:40', '2020-04-17 06:13:40');

-- --------------------------------------------------------

--
-- 表的结构 `user_relations`
--

CREATE TABLE `user_relations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT '会员ID',
  `parents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '上级信息',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_relations`
--

INSERT INTO `user_relations` (`id`, `user_id`, `parents`, `created_at`, `updated_at`) VALUES
(2, 5, '', '2020-04-17 06:13:40', '2020-04-17 06:13:40');

-- --------------------------------------------------------

--
-- 表的结构 `user_wallets`
--

CREATE TABLE `user_wallets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL COMMENT '会员ID',
  `cash_blance` int NOT NULL DEFAULT '0' COMMENT '分润余额',
  `return_blance` int NOT NULL DEFAULT '0' COMMENT '返现余额',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_wallets`
--

INSERT INTO `user_wallets` (`id`, `user_id`, `cash_blance`, `return_blance`, `created_at`, `updated_at`) VALUES
(4, 5, 1, 0, '2020-04-17 06:13:40', '2020-04-17 06:13:40');

-- --------------------------------------------------------

--
-- 表的结构 `withdraws`
--

CREATE TABLE `withdraws` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL COMMENT '用户ID',
  `order_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `money` int NOT NULL DEFAULT '0' COMMENT '提现金额',
  `real_money` int NOT NULL DEFAULT '0' COMMENT '实际打款金额',
  `type` tinyint NOT NULL COMMENT '类型，1分润提现，2返现提现',
  `state` tinyint NOT NULL DEFAULT '1' COMMENT '状态，1待审核，2通过，3驳回',
  `make_state` tinyint NOT NULL COMMENT '打款状态：1成功，2失败',
  `check_at` timestamp NULL DEFAULT NULL COMMENT '审核时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `withdraws_datas`
--

CREATE TABLE `withdraws_datas` (
  `id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '提现订单号',
  `phone` int NOT NULL COMMENT '预留手机号',
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户姓名',
  `idcard` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '身份证号',
  `bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '银行名称',
  `bank_open` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '开户行',
  `banklink` bigint DEFAULT NULL COMMENT '联行号',
  `repay_money` int DEFAULT '0' COMMENT '代付系统打款金额',
  `repay_wallet` int DEFAULT '0' COMMENT '代付系统打款金额',
  `reason` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '说明',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `admin_config`
--
ALTER TABLE `admin_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_config_name_unique` (`name`);

--
-- 表的索引 `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `admin_operation_log`
--
ALTER TABLE `admin_operation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_operation_log_user_id_index` (`user_id`);

--
-- 表的索引 `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_name_unique` (`name`),
  ADD UNIQUE KEY `admin_permissions_slug_unique` (`slug`);

--
-- 表的索引 `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_name_unique` (`name`),
  ADD UNIQUE KEY `admin_roles_slug_unique` (`slug`);

--
-- 表的索引 `admin_role_menu`
--
ALTER TABLE `admin_role_menu`
  ADD KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`);

--
-- 表的索引 `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`);

--
-- 表的索引 `admin_role_users`
--
ALTER TABLE `admin_role_users`
  ADD KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`);

--
-- 表的索引 `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_username_unique` (`username`);

--
-- 表的索引 `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  ADD KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`);

--
-- 表的索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_types`
--
ALTER TABLE `article_types`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cashs_logs`
--
ALTER TABLE `cashs_logs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `machines_factories`
--
ALTER TABLE `machines_factories`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `machines_styles`
--
ALTER TABLE `machines_styles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `machines_types`
--
ALTER TABLE `machines_types`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `plugs`
--
ALTER TABLE `plugs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `plug_types`
--
ALTER TABLE `plug_types`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `shares`
--
ALTER TABLE `shares`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `share_types`
--
ALTER TABLE `share_types`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_machine_id_foreign` (`machine_id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_groups_level_unique` (`level`);

--
-- 表的索引 `user_realnames`
--
ALTER TABLE `user_realnames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_realnames_user_id_foreign` (`user_id`);

--
-- 表的索引 `user_relations`
--
ALTER TABLE `user_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_relations_user_id_foreign` (`user_id`);

--
-- 表的索引 `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_wallets_user_id_foreign` (`user_id`);

--
-- 表的索引 `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `withdraws_datas`
--
ALTER TABLE `withdraws_datas`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_config`
--
ALTER TABLE `admin_config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `admin_operation_log`
--
ALTER TABLE `admin_operation_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1684;

--
-- 使用表AUTO_INCREMENT `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `article_types`
--
ALTER TABLE `article_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cashs_logs`
--
ALTER TABLE `cashs_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `machines_factories`
--
ALTER TABLE `machines_factories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `machines_styles`
--
ALTER TABLE `machines_styles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `machines_types`
--
ALTER TABLE `machines_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `plugs`
--
ALTER TABLE `plugs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `plug_types`
--
ALTER TABLE `plug_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `shares`
--
ALTER TABLE `shares`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `share_types`
--
ALTER TABLE `share_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `trades`
--
ALTER TABLE `trades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `user_realnames`
--
ALTER TABLE `user_realnames`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user_relations`
--
ALTER TABLE `user_relations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user_wallets`
--
ALTER TABLE `user_wallets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `withdraws_datas`
--
ALTER TABLE `withdraws_datas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 限制导出的表
--

--
-- 限制表 `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`) ON DELETE CASCADE;

--
-- 限制表 `user_realnames`
--
ALTER TABLE `user_realnames`
  ADD CONSTRAINT `user_realnames_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `user_relations`
--
ALTER TABLE `user_relations`
  ADD CONSTRAINT `user_relations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD CONSTRAINT `user_wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
