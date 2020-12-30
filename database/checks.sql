-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 30, 2020 at 08:17 AM
-- Server version: 5.7.31-log
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_8x`
--

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

DROP TABLE IF EXISTS `checks`;
CREATE TABLE IF NOT EXISTS `checks` (
  `check_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `check_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `check_overview` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `check_description` text CHARACTER SET utf8,
  `check_slug` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `check_image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `check_files` varchar(10000) CHARACTER SET utf8 DEFAULT NULL,
  `redmine_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `redmine_url` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `check_status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`check_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `checks`
--

INSERT INTO `checks` (`check_id`, `user_id`, `category_id`, `check_name`, `check_overview`, `check_description`, `check_slug`, `check_image`, `check_files`, `redmine_id`, `redmine_url`, `check_status`, `created_at`, `updated_at`) VALUES
(1, 9999, NULL, 'Bài 1: Giới thiệu Laravel111', 'sdfg sdfg ssdfg sdfg ssdfg sdfg s', '<p>sdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg s</p>', NULL, '/photos/9999/test/5ab1cee1a4aa4.jpeg', '[\"\\/files\\/9999\\/asdf\\/5ab3285de870c.pdf\"]', NULL, NULL, 99, '2018-03-25 21:50:51', '2018-04-05 00:15:35'),
(2, 9999, NULL, 'Bài 1: Giới thiệu Laravel', 'sdfg sdfg ssdfg sdfg ssdfg sdfg s', '<p>sdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg s</p>', NULL, NULL, '[]', NULL, NULL, 99, '2018-04-05 00:15:06', '2018-04-05 00:15:06'),
(3, 9999, NULL, 'Bài 1: Giới thiệu Laravel222', 'sdfg sdfg ssdfg sdfg ssdfg sdfg s', '<p>sdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg ssdfg sdfg s</p>', NULL, '/photos/9999/test/5ab1cee1a4aa4.jpeg', '[\"\\/files\\/9999\\/asdf\\/5ab3285de870c.pdf\"]', NULL, NULL, 99, '2018-04-05 00:15:47', '2018-04-05 00:15:47'),
(4, 1, NULL, NULL, NULL, NULL, NULL, NULL, '[\"\\/files\\/1\\/test1.xlsx\"]', '12312', 'Lorem ipsum dolor sit amet, conse', NULL, '2020-12-30 01:14:19', '2020-12-30 01:14:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
