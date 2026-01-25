-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 07:36 AM
-- Server version: 8.0.27
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usatum`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `id` int NOT NULL,
  `compagny` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `compagny`, `ifu`, `register_num`) VALUES
(3, 'Corp UK', '23dsf65fe6z5ff16', 'ds6f54ds64f56ds4f65sd'),
(37, 'ADE SARL', '5115645gfhgd4846', '5s6d4fsfd864ffgfd'),
(40, 'Group Trans', '65656848486', '648684486486');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `deleted`, `created_at`, `slug`) VALUES
(1, 'Ecobanck', 0, '2020-08-16 23:57:27', 'ecobank'),
(2, 'BOA', 0, '2020-08-16 23:57:52', 'boa');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `deleted`, `created_at`, `slug`) VALUES
(1, 'Audi', 0, '2020-08-09 18:59:49', 'audi'),
(2, 'Bmw', 0, '2020-08-09 18:59:49', 'bmw'),
(3, 'Citroen', 0, '2020-08-09 18:59:49', 'citroen'),
(4, 'Fiat', 0, '2020-08-09 18:59:49', 'fiat'),
(5, 'Ford', 0, '2020-08-09 18:59:49', 'ford'),
(6, 'Mercedes', 0, '2020-08-09 18:59:49', 'mercedes'),
(7, 'Opel', 0, '2020-08-09 18:59:49', 'opel'),
(8, 'Peugeot', 0, '2020-08-09 18:59:49', 'peugeot'),
(9, 'Renault', 0, '2020-08-09 18:59:49', 'renault'),
(10, 'Volkswagen', 0, '2020-08-09 18:59:49', 'volkswagen'),
(11, 'Abarth', 0, '2020-08-09 18:59:49', 'abarth'),
(12, 'Aixam', 0, '2020-08-09 18:59:50', 'aixam'),
(13, 'Aleko', 0, '2020-08-09 18:59:50', 'aleko'),
(14, 'Alfa Romeo', 0, '2020-08-09 18:59:50', 'alfa-romeo'),
(15, 'Alpina', 0, '2020-08-09 18:59:50', 'alpina'),
(16, 'Alpine', 0, '2020-08-09 18:59:50', 'alpine'),
(17, 'Alpine-Renault', 0, '2020-08-09 18:59:50', 'alpine-renault'),
(18, 'American-Motors', 0, '2020-08-09 18:59:50', 'american-motors'),
(19, 'Aro', 0, '2020-08-09 18:59:50', 'aro'),
(20, 'Artega', 0, '2020-08-09 18:59:50', 'artega'),
(21, 'Aston Martin', 0, '2020-08-09 18:59:50', 'aston-martin'),
(22, 'Austin', 0, '2020-08-09 18:59:50', 'austin'),
(23, 'Autobianchi', 0, '2020-08-09 18:59:50', 'autobianchi'),
(24, 'Auverland', 0, '2020-08-09 18:59:50', 'auverland'),
(25, 'Bedford', 0, '2020-08-09 18:59:50', 'bedford'),
(26, 'Bedford-GME', 0, '2020-08-09 18:59:50', 'bedford-gme'),
(27, 'Bellier', 0, '2020-08-09 18:59:50', 'bellier'),
(28, 'Bentley', 0, '2020-08-09 18:59:50', 'bentley'),
(29, 'Bertone', 0, '2020-08-09 18:59:50', 'bertone'),
(30, 'Bluecar Groupe Bollore', 0, '2020-08-09 18:59:50', 'bluecar-groupe-bollore'),
(31, 'Buic', 0, '2020-08-09 18:59:50', 'buic'),
(32, 'Buick', 0, '2020-08-09 18:59:50', 'buick'),
(33, 'Cadillac', 0, '2020-08-09 18:59:50', 'cadillac'),
(34, 'Casalini', 0, '2020-08-09 18:59:51', 'casalini'),
(35, 'Caterham', 0, '2020-08-09 18:59:51', 'caterham'),
(36, 'Chatenet', 0, '2020-08-09 18:59:51', 'chatenet'),
(37, 'Chevrolet', 0, '2020-08-09 18:59:51', 'chevrolet'),
(38, 'Chevrolet USA', 0, '2020-08-09 18:59:51', 'chevrolet-usa'),
(39, 'Chrysler', 0, '2020-08-09 18:59:51', 'chrysler'),
(40, 'Corvette', 0, '2020-08-09 18:59:51', 'corvette'),
(41, 'Cupra', 0, '2020-08-09 18:59:51', 'cupra'),
(42, 'Dacia', 0, '2020-08-09 18:59:51', 'dacia'),
(43, 'Daewoo', 0, '2020-08-09 18:59:51', 'daewoo'),
(44, 'Daihatsu', 0, '2020-08-09 18:59:51', 'daihatsu'),
(45, 'Dallas', 0, '2020-08-09 18:59:51', 'dallas'),
(46, 'Dangel', 0, '2020-08-09 18:59:51', 'dangel'),
(47, 'Datsun', 0, '2020-08-09 18:59:51', 'datsun'),
(48, 'De La Chapelle', 0, '2020-08-09 18:59:51', 'de-la-chapelle'),
(49, 'Dodge', 0, '2020-08-09 18:59:51', 'dodge'),
(50, 'Donkervoort', 0, '2020-08-09 18:59:51', 'donkervoort'),
(51, 'Dr', 0, '2020-08-09 18:59:51', 'dr'),
(52, 'Ds', 0, '2020-08-09 18:59:51', 'ds'),
(53, 'Due', 0, '2020-08-09 18:59:51', 'due'),
(54, 'Ferrari', 0, '2020-08-09 18:59:51', 'ferrari'),
(55, 'Fisker', 0, '2020-08-09 18:59:51', 'fisker'),
(56, 'Ford USA', 0, '2020-08-09 18:59:52', 'ford-usa'),
(57, 'Fso', 0, '2020-08-09 18:59:52', 'fso'),
(58, 'General motors', 0, '2020-08-09 18:59:52', 'general-motors'),
(59, 'Gme', 0, '2020-08-09 18:59:52', 'gme'),
(60, 'Grecav', 0, '2020-08-09 18:59:52', 'grecav'),
(61, 'Hommell', 0, '2020-08-09 18:59:52', 'hommell'),
(62, 'Honda', 0, '2020-08-09 18:59:52', 'honda'),
(63, 'Hummer', 0, '2020-08-09 18:59:52', 'hummer'),
(64, 'Hyundai', 0, '2020-08-09 18:59:52', 'hyundai'),
(65, 'Infiniti', 0, '2020-08-09 18:59:52', 'infiniti'),
(66, 'Innocenti', 0, '2020-08-09 18:59:52', 'innocenti'),
(67, 'Isuzu', 0, '2020-08-09 18:59:52', 'isuzu'),
(68, 'Iveco', 0, '2020-08-09 18:59:52', 'iveco'),
(69, 'Jaguar', 0, '2020-08-09 18:59:52', 'jaguar'),
(70, 'Jeep', 0, '2020-08-09 18:59:52', 'jeep'),
(71, 'Kia', 0, '2020-08-09 18:59:52', 'kia'),
(72, 'Ktm', 0, '2020-08-09 18:59:52', 'ktm'),
(73, 'Lada', 0, '2020-08-09 18:59:52', 'lada'),
(74, 'Lamborghini', 0, '2020-08-09 18:59:52', 'lamborghini'),
(75, 'Lancia', 0, '2020-08-09 18:59:52', 'lancia'),
(76, 'Land Rover', 0, '2020-08-09 18:59:52', 'land-rover'),
(77, 'Lexus', 0, '2020-08-09 18:59:52', 'lexus'),
(78, 'Ligier', 0, '2020-08-09 18:59:52', 'ligier'),
(79, 'Little', 0, '2020-08-09 18:59:53', 'little'),
(80, 'Lotus', 0, '2020-08-09 18:59:53', 'lotus'),
(81, 'MPM', 0, '2020-08-09 18:59:53', 'mpm'),
(82, 'MVS', 0, '2020-08-09 18:59:53', 'mvs'),
(83, 'Mahindra', 0, '2020-08-09 18:59:53', 'mahindra'),
(84, 'Maruti', 0, '2020-08-09 18:59:53', 'maruti'),
(85, 'Maserati', 0, '2020-08-09 18:59:53', 'maserati'),
(86, 'Mastretta', 0, '2020-08-09 18:59:53', 'mastretta'),
(87, 'Maybach', 0, '2020-08-09 18:59:53', 'maybach'),
(88, 'Mazda', 0, '2020-08-09 18:59:53', 'mazda'),
(89, 'Mclaren', 0, '2020-08-09 18:59:53', 'mclaren'),
(90, 'Mega', 0, '2020-08-09 18:59:53', 'mega'),
(91, 'Mg', 0, '2020-08-09 18:59:53', 'mg'),
(92, 'Mia', 0, '2020-08-09 18:59:53', 'mia'),
(93, 'Microcar', 0, '2020-08-09 18:59:53', 'microcar'),
(94, 'Mini', 0, '2020-08-09 18:59:53', 'mini'),
(95, 'Mini Hummer', 0, '2020-08-09 18:59:53', 'mini-hummer'),
(96, 'Mitsubishi', 0, '2020-08-09 18:59:53', 'mitsubishi'),
(97, 'Morgan', 0, '2020-08-09 18:59:53', 'morgan'),
(98, 'Moskvitch', 0, '2020-08-09 18:59:53', 'moskvitch'),
(99, 'Nissan', 0, '2020-08-09 18:59:53', 'nissan'),
(100, 'Oldsmobile', 0, '2020-08-09 18:59:53', 'oldsmobile'),
(101, 'Pgo', 0, '2020-08-09 18:59:54', 'pgo'),
(102, 'Piaggio', 0, '2020-08-09 18:59:54', 'piaggio'),
(103, 'Polski/fso', 0, '2020-08-09 18:59:54', 'polski-fso'),
(104, 'Pontiac', 0, '2020-08-09 18:59:54', 'pontiac'),
(105, 'Porsche', 0, '2020-08-09 18:59:54', 'porsche'),
(106, 'Proton', 0, '2020-08-09 18:59:54', 'proton'),
(107, 'Rolls-royce', 0, '2020-08-09 18:59:54', 'rolls-royce'),
(108, 'Rover', 0, '2020-08-09 18:59:54', 'rover'),
(109, 'Saab', 0, '2020-08-09 18:59:54', 'saab'),
(110, 'Santana', 0, '2020-08-09 18:59:54', 'santana'),
(111, 'Savel', 0, '2020-08-09 18:59:54', 'savel'),
(112, 'Seat', 0, '2020-08-09 18:59:54', 'seat'),
(113, 'Shuanghuan', 0, '2020-08-09 18:59:54', 'shuanghuan'),
(114, 'Simpa JDM', 0, '2020-08-09 18:59:54', 'simpa-jdm'),
(115, 'Skoda', 0, '2020-08-09 18:59:54', 'skoda'),
(116, 'Smart', 0, '2020-08-09 18:59:54', 'smart'),
(117, 'Ssangyong', 0, '2020-08-09 18:59:54', 'ssangyong'),
(118, 'Subaru', 0, '2020-08-09 18:59:54', 'subaru'),
(119, 'Suzuki', 0, '2020-08-09 18:59:54', 'suzuki'),
(120, 'Talbot', 0, '2020-08-09 18:59:54', 'talbot'),
(121, 'Tavria', 0, '2020-08-09 18:59:54', 'tavria'),
(122, 'Tesla', 0, '2020-08-09 18:59:55', 'tesla'),
(123, 'Toyota', 0, '2020-08-09 18:59:55', 'toyota'),
(124, 'Triumph', 0, '2020-08-09 18:59:55', 'triumph'),
(125, 'Tvr', 0, '2020-08-09 18:59:55', 'tvr'),
(126, 'Umm', 0, '2020-08-09 18:59:55', 'umm'),
(127, 'Venturi', 0, '2020-08-09 18:59:55', 'venturi'),
(128, 'Volvo', 0, '2020-08-09 18:59:55', 'volvo'),
(129, 'ZAZ', 0, '2020-08-09 18:59:55', 'zaz'),
(130, 'Zastava', 0, '2020-08-09 18:59:55', 'zastava'),
(131, 'Autres', 0, '2020-08-09 18:59:55', 'autres');

-- --------------------------------------------------------

--
-- Table structure for table `condition`
--

CREATE TABLE `condition` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `condition`
--

INSERT INTO `condition` (`id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 'Lorem ipsum dolor sita ameter, consectetur adipiscing elit, sedal do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '2020-08-29 19:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `demande_file`
--

CREATE TABLE `demande_file` (
  `id` int NOT NULL,
  `removal_id` int DEFAULT NULL,
  `transfer_id` int DEFAULT NULL,
  `file_id` int NOT NULL,
  `used_for` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `vehicle_id` int DEFAULT NULL,
  `remover_id` int DEFAULT NULL,
  `inform_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande_file`
--

INSERT INTO `demande_file` (`id`, `removal_id`, `transfer_id`, `file_id`, `used_for`, `deleted`, `created_at`, `vehicle_id`, `remover_id`, `inform_id`, `user_id`) VALUES
(1, NULL, 11, 13, 'bol', 0, '2020-08-16 21:11:09', 18, NULL, NULL, NULL),
(2, 11, NULL, 57, 'bfu', 0, '2020-08-18 22:28:54', NULL, NULL, NULL, NULL),
(3, 11, NULL, 58, 'entry', 0, '2020-08-18 22:28:54', NULL, NULL, NULL, NULL),
(4, 11, NULL, 59, 'receipt', 0, '2020-08-18 22:28:54', NULL, NULL, NULL, NULL),
(5, 10, NULL, 60, 'bfu', 0, '2020-08-20 00:34:15', NULL, NULL, NULL, NULL),
(6, NULL, NULL, 61, 'bol', 0, '2020-08-20 01:02:05', 46, NULL, NULL, NULL),
(7, NULL, NULL, 62, 'bol', 0, '2020-08-20 01:06:14', 47, NULL, NULL, NULL),
(8, 12, NULL, 64, 'bfu', 0, '2020-08-20 01:07:30', NULL, NULL, NULL, NULL),
(9, 12, NULL, 65, 'entry', 0, '2020-08-20 01:07:30', NULL, NULL, NULL, NULL),
(10, 12, NULL, 66, 'receipt', 0, '2020-08-20 01:07:30', NULL, NULL, NULL, NULL),
(11, NULL, NULL, 67, 'bol', 0, '2020-08-20 01:19:01', 48, NULL, NULL, NULL),
(12, 13, NULL, 69, 'bfu', 0, '2020-08-20 01:19:55', NULL, NULL, NULL, NULL),
(13, 13, NULL, 70, 'entry', 0, '2020-08-20 01:19:55', NULL, NULL, NULL, NULL),
(14, 13, NULL, 71, 'receipt', 0, '2020-08-20 01:19:55', NULL, NULL, NULL, NULL),
(15, NULL, NULL, 72, 'bol', 0, '2020-08-20 01:25:07', 49, NULL, NULL, NULL),
(16, 14, NULL, 74, 'bfu', 0, '2020-08-20 01:26:01', NULL, NULL, NULL, NULL),
(17, 14, NULL, 75, 'entry', 0, '2020-08-20 01:26:02', NULL, NULL, NULL, NULL),
(18, 14, NULL, 76, 'receipt', 0, '2020-08-20 01:26:02', NULL, NULL, NULL, NULL),
(19, NULL, NULL, 77, 'bol', 0, '2020-08-20 01:29:11', 50, NULL, NULL, NULL),
(20, 15, NULL, 83, 'bfu', 0, '2020-08-20 01:30:01', NULL, NULL, NULL, NULL),
(21, 15, NULL, 80, 'entry', 0, '2020-08-20 01:30:01', NULL, NULL, NULL, NULL),
(22, 15, NULL, 81, 'receipt', 0, '2020-08-20 01:30:01', NULL, NULL, NULL, NULL),
(23, NULL, NULL, 82, 'bol', 0, '2020-08-20 01:32:25', 50, NULL, NULL, NULL),
(24, NULL, NULL, 84, 'bol', 0, '2020-08-20 01:36:16', 50, NULL, NULL, NULL),
(25, NULL, NULL, 85, 'bol', 0, '2020-08-22 21:16:35', 51, NULL, NULL, NULL),
(26, NULL, NULL, 86, 'bol', 0, '2020-08-23 10:41:07', 52, NULL, NULL, NULL),
(27, NULL, NULL, 87, 'bol', 0, '2020-08-24 21:47:04', 53, NULL, NULL, NULL),
(28, 16, NULL, 93, 'bfu', 0, '2020-08-24 21:48:35', NULL, NULL, NULL, NULL),
(29, 16, NULL, 94, 'entry', 0, '2020-08-24 21:48:35', NULL, NULL, NULL, NULL),
(30, 16, NULL, 95, 'receipt', 0, '2020-08-24 21:48:36', NULL, NULL, NULL, NULL),
(31, NULL, NULL, 92, 'bol', 0, '2020-08-25 21:32:22', 53, NULL, NULL, NULL),
(32, NULL, NULL, 99, 'bol', 0, '2020-08-25 22:01:16', 54, NULL, NULL, NULL),
(33, NULL, 1, 102, 'assurance', 0, '2020-08-26 19:16:39', NULL, NULL, NULL, NULL),
(34, NULL, 6, 103, 'assurance', 0, '2020-08-26 19:19:50', NULL, NULL, NULL, NULL),
(35, NULL, 7, 104, 'assurance', 0, '2020-08-26 19:21:32', NULL, NULL, NULL, NULL),
(36, NULL, NULL, 105, 'bol', 0, '2020-08-28 23:25:46', 55, NULL, NULL, NULL),
(37, NULL, NULL, 108, 'bol', 0, '2020-08-29 01:02:24', 56, NULL, NULL, NULL),
(38, NULL, NULL, 109, 'bol', 0, '2020-08-29 01:19:55', 57, NULL, NULL, NULL),
(39, NULL, NULL, 110, 'cin', 0, '2020-08-29 01:29:42', NULL, 16, NULL, NULL),
(40, 17, NULL, 111, 'bfu', 0, '2020-08-29 01:30:01', NULL, NULL, NULL, NULL),
(41, 17, NULL, 112, 'entry', 0, '2020-08-29 01:30:01', NULL, NULL, NULL, NULL),
(42, 17, NULL, 113, 'receipt', 0, '2020-08-29 01:30:02', NULL, NULL, NULL, NULL),
(43, NULL, 16, 114, 'assurance', 0, '2020-08-29 02:59:54', NULL, NULL, NULL, NULL),
(44, NULL, NULL, 115, 'bol', 0, '2020-08-29 12:21:57', 58, NULL, NULL, NULL),
(45, NULL, NULL, 116, 'bol', 0, '2020-08-29 12:41:52', 59, NULL, NULL, NULL),
(46, NULL, NULL, 117, 'cin', 0, '2020-08-29 12:42:48', NULL, 17, NULL, NULL),
(47, 18, NULL, 118, 'bfu', 0, '2020-08-29 12:42:59', NULL, NULL, NULL, NULL),
(48, 18, NULL, 119, 'entry', 0, '2020-08-29 12:43:00', NULL, NULL, NULL, NULL),
(49, 18, NULL, 120, 'receipt', 0, '2020-08-29 12:43:00', NULL, NULL, NULL, NULL),
(50, NULL, NULL, 121, 'bol', 0, '2020-08-30 09:11:23', 60, NULL, NULL, NULL),
(51, NULL, NULL, 122, 'cin', 0, '2020-08-30 09:13:02', NULL, 18, NULL, NULL),
(52, NULL, NULL, 123, 'bol', 0, '2020-08-30 09:13:53', 61, NULL, NULL, NULL),
(53, NULL, NULL, 124, 'cin', 0, '2020-08-30 09:14:35', NULL, 19, NULL, NULL),
(54, 19, NULL, 125, 'bfu', 0, '2020-08-30 09:14:47', NULL, NULL, NULL, NULL),
(55, 19, NULL, 126, 'entry', 0, '2020-08-30 09:14:48', NULL, NULL, NULL, NULL),
(56, 19, NULL, 127, 'receipt', 0, '2020-08-30 09:14:48', NULL, NULL, NULL, NULL),
(57, 20, NULL, 128, 'bfu', 0, '2020-08-30 09:17:01', NULL, NULL, NULL, NULL),
(58, 20, NULL, 129, 'entry', 0, '2020-08-30 09:17:02', NULL, NULL, NULL, NULL),
(59, 20, NULL, 130, 'receipt', 0, '2020-08-30 09:17:02', NULL, NULL, NULL, NULL),
(60, NULL, NULL, 131, 'bol', 0, '2020-08-30 09:48:39', 62, NULL, NULL, NULL),
(61, 21, NULL, 132, 'bfu', 0, '2020-08-30 09:49:05', NULL, NULL, NULL, NULL),
(62, 21, NULL, 133, 'entry', 0, '2020-08-30 09:49:06', NULL, NULL, NULL, NULL),
(63, 21, NULL, 134, 'receipt', 0, '2020-08-30 09:49:06', NULL, NULL, NULL, NULL),
(64, NULL, NULL, 135, 'bol', 0, '2020-08-30 10:03:37', 63, NULL, NULL, NULL),
(65, NULL, 18, 136, 'assurance', 0, '2020-08-30 10:09:58', NULL, NULL, NULL, NULL),
(66, NULL, NULL, 137, 'bol', 0, '2020-08-30 11:53:12', 64, NULL, NULL, NULL),
(67, NULL, 19, 138, 'assurance', 0, '2020-08-30 12:02:13', NULL, NULL, NULL, NULL),
(68, NULL, NULL, 139, 'bol', 0, '2020-08-30 12:12:57', 65, NULL, NULL, NULL),
(69, NULL, NULL, 140, 'cin', 0, '2020-08-30 12:17:33', NULL, 20, NULL, NULL),
(70, 22, NULL, 141, 'bfu', 0, '2020-08-30 12:17:56', NULL, NULL, NULL, NULL),
(71, 22, NULL, 142, 'entry', 0, '2020-08-30 12:17:57', NULL, NULL, NULL, NULL),
(72, 22, NULL, 143, 'receipt', 0, '2020-08-30 12:17:57', NULL, NULL, NULL, NULL),
(73, NULL, NULL, 144, 'bol', 0, '2020-08-30 22:05:03', 66, NULL, NULL, NULL),
(74, 23, NULL, 145, 'bfu', 0, '2020-08-30 22:06:21', NULL, NULL, NULL, NULL),
(75, 23, NULL, 146, 'entry', 0, '2020-08-30 22:06:22', NULL, NULL, NULL, NULL),
(76, 23, NULL, 147, 'receipt', 0, '2020-08-30 22:06:23', NULL, NULL, NULL, NULL),
(77, NULL, NULL, 148, 'bol', 0, '2020-08-31 00:11:28', 67, NULL, NULL, NULL),
(78, NULL, NULL, 149, 'bol', 0, '2020-08-31 00:13:55', 68, NULL, NULL, NULL),
(79, NULL, NULL, 150, 'bol', 0, '2020-08-31 00:18:25', 69, NULL, NULL, NULL),
(80, NULL, NULL, 151, 'bol', 0, '2020-08-31 00:21:06', 70, NULL, NULL, NULL),
(81, 24, NULL, 152, 'bfu', 0, '2020-08-31 00:21:37', NULL, NULL, NULL, NULL),
(82, 24, NULL, 153, 'entry', 0, '2020-08-31 00:21:38', NULL, NULL, NULL, NULL),
(83, 24, NULL, 154, 'receipt', 0, '2020-08-31 00:21:38', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200810213646', '2020-08-10 21:37:01', 41812),
('DoctrineMigrations\\Version20200810220633', '2020-08-10 22:06:40', 787),
('DoctrineMigrations\\Version20200812213011', '2020-08-12 21:30:38', 3562),
('DoctrineMigrations\\Version20200813225516', '2020-08-16 13:31:59', 1242),
('DoctrineMigrations\\Version20200816133126', '2020-08-16 13:33:17', 1942),
('DoctrineMigrations\\Version20200816133432', '2020-08-16 13:34:37', 1825),
('DoctrineMigrations\\Version20200816140227', '2020-08-16 14:02:39', 945),
('DoctrineMigrations\\Version20200816180944', '2020-08-16 18:09:50', 1126),
('DoctrineMigrations\\Version20200816204805', '2020-08-16 20:48:16', 865),
('DoctrineMigrations\\Version20200816213353', '2020-08-16 21:34:03', 1089),
('DoctrineMigrations\\Version20200817224559', '2020-08-17 22:46:03', 1767),
('DoctrineMigrations\\Version20200817224639', '2020-08-17 22:46:42', 1478),
('DoctrineMigrations\\Version20200818005541', '2020-08-18 00:58:38', 1407),
('DoctrineMigrations\\Version20200818213140', '2020-08-18 21:32:27', 2734),
('DoctrineMigrations\\Version20200818214241', '2020-08-18 21:42:45', 1745),
('DoctrineMigrations\\Version20200818214516', '2020-08-18 21:45:19', 1093),
('DoctrineMigrations\\Version20200818223353', '2020-08-18 22:34:01', 3559),
('DoctrineMigrations\\Version20200819210608', '2020-08-19 21:06:13', 4221),
('DoctrineMigrations\\Version20200820201448', '2020-08-20 20:15:02', 2501),
('DoctrineMigrations\\Version20200820205801', '2020-08-20 20:58:08', 1256),
('DoctrineMigrations\\Version20200820210509', '2020-08-20 21:05:16', 941),
('DoctrineMigrations\\Version20200825231136', '2020-08-25 23:11:47', 2851),
('DoctrineMigrations\\Version20200829010200', '2020-08-29 01:02:16', 1914),
('DoctrineMigrations\\Version20200829010908', '2020-08-29 01:09:17', 3173),
('DoctrineMigrations\\Version20200829012602', '2020-08-29 01:26:05', 1014),
('DoctrineMigrations\\Version20200829175818', '2020-08-29 17:58:57', 4082),
('DoctrineMigrations\\Version20200830081839', '2020-08-30 08:18:46', 5538),
('DoctrineMigrations\\Version20200830082221', '2020-08-30 08:22:30', 869),
('DoctrineMigrations\\Version20200830082526', '2020-08-30 08:25:35', 1014),
('DoctrineMigrations\\Version20200830084310', '2020-08-30 08:43:17', 831),
('DoctrineMigrations\\Version20200830215320', '2020-08-30 21:53:41', 3969),
('DoctrineMigrations\\Version20200830215659', '2020-08-30 21:57:02', 1293),
('DoctrineMigrations\\Version20200830234522', '2020-08-30 23:45:30', 3358);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `user_id`, `client_name`, `size`, `link`, `deleted`, `created_at`) VALUES
(1, 2, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200814_5f35e49d595d4.png', 0, '2020-08-14 01:10:53'),
(2, 2, 'config reseau initial1', 0, '20200808/bol_20200814_5f35e6edccdeb.png', 0, '2020-08-14 01:20:45'),
(3, 2, 'config reseau initial3', 0, '20200808/bol_20200814_5f35e98dd6550.png', 0, '2020-08-14 01:31:57'),
(4, 2, 'config reseau initial3', 0, '20200808/bol_20200814_5f35ea47078c1.png', 0, '2020-08-14 01:35:03'),
(5, 2, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200814_5f35ec3541d84.png', 0, '2020-08-14 01:43:17'),
(6, 2, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200814_5f35f9cec3a64.png', 0, '2020-08-14 02:41:18'),
(7, 4, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200816_5f390ca2eb037.png', 0, '2020-08-16 10:38:26'),
(8, 5, 'config reseau initial2', 0, '20200808/bol_20200816_5f3917e03dc88.png', 0, '2020-08-16 11:26:24'),
(9, 4, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200816_5f397105f32c0.png', 0, '2020-08-16 17:46:46'),
(10, 4, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200816_5f397280f2f10.png', 0, '2020-08-16 17:53:04'),
(11, 4, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200816_5f3972c95c8bc.png', 0, '2020-08-16 17:54:17'),
(12, 4, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200816_5f39782f77031.png', 0, '2020-08-16 18:17:19'),
(13, 2, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200816_5f39a0ed04615.png', 0, '2020-08-16 21:11:09'),
(14, 3, 'Annotation 2020-07-27 023432', 0, '20200808/cin_20200816_5f39a54e1dc95.png', 0, '2020-08-16 21:29:50'),
(15, 3, 'Annotation 2020-07-27 023432', 0, '20200808/cin_20200816_5f39a76ca9ad6.png', 0, '2020-08-16 21:38:52'),
(16, 3, 'Annotation 2020-07-27 023432', 0, '20200808/cin_20200816_5f39a797b4788.png', 0, '2020-08-16 21:39:35'),
(17, 3, 'GmlGFlottant', 0, '20200808/cin_20200816_5f39aba14bf31.jpeg', 0, '2020-08-16 21:56:49'),
(18, 3, 'GmlGFlottant', 0, '20200808/cin_20200816_5f39abacb35c0.jpeg', 0, '2020-08-16 21:57:00'),
(19, 3, 'GmlGFlottant', 0, '20200808/cin_20200816_5f39abd1580fa.jpeg', 0, '2020-08-16 21:57:37'),
(20, 3, 'data-berlin-6535-179', 0, '20200808/cin_20200816_5f39ac27dcc4e.jpeg', 0, '2020-08-16 21:59:03'),
(21, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3afe2dcf549.png', 0, '2020-08-17 22:01:17'),
(22, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3afefe76a09.png', 0, '2020-08-17 22:04:46'),
(23, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b0186c8aa2.png', 0, '2020-08-17 22:15:34'),
(24, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b01c55739e.png', 0, '2020-08-17 22:16:37'),
(25, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b0205a4c4f.png', 0, '2020-08-17 22:17:41'),
(26, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b05ee1be71.png', 0, '2020-08-17 22:34:22'),
(27, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b064983484.png', 0, '2020-08-17 22:35:53'),
(28, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b06911ffe2.png', 0, '2020-08-17 22:37:05'),
(29, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b073b11d4c.png', 0, '2020-08-17 22:39:55'),
(30, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200817_5f3b0b0c188b6.png', 0, '2020-08-17 22:56:12'),
(31, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b1fbf137e0.png', 0, '2020-08-18 00:24:31'),
(32, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b221c716fc.png', 0, '2020-08-18 00:34:36'),
(33, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b226628f6d.png', 0, '2020-08-18 00:35:50'),
(34, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b22e00b26d.png', 0, '2020-08-18 00:37:52'),
(35, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b23bc46613.png', 0, '2020-08-18 00:41:32'),
(36, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b26b75edfa.png', 0, '2020-08-18 00:54:15'),
(37, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3b28b882628.png', 0, '2020-08-18 01:02:48'),
(38, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c2f78d6fab.png', 0, '2020-08-18 19:43:52'),
(39, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c314b565f1.png', 0, '2020-08-18 19:51:39'),
(40, 3, 'config reseau initial3', 0, '20200808/cin_20200818_5f3c318378898.png', 0, '2020-08-18 19:52:35'),
(41, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c31c710664.png', 0, '2020-08-18 19:53:43'),
(42, 3, 'config reseau initial2', 0, '20200808/cin_20200818_5f3c3202b8915.png', 0, '2020-08-18 19:54:42'),
(43, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c347051b49.png', 0, '2020-08-18 20:05:04'),
(44, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c34b22216c.png', 0, '2020-08-18 20:06:10'),
(45, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c355a1cf40.png', 0, '2020-08-18 20:08:58'),
(46, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c379359858.png', 0, '2020-08-18 20:18:27'),
(47, 3, 'Annotation 2020-07-27 023432', 0, '20200808/cin_20200818_5f3c3ddb3f411.png', 0, '2020-08-18 20:45:15'),
(48, 3, 'Annotation 2020-07-27 023432', 0, '20200808/cin_20200818_5f3c3f06d0305.png', 0, '2020-08-18 20:50:14'),
(49, 3, 'Annotation 2020-07-27 023432', 0, '20200808/cin_20200818_5f3c442469dc5.png', 0, '2020-08-18 21:12:04'),
(50, 3, 'config reseau initial1', 0, '20200808/cin_20200818_5f3c4492a0384.png', 0, '2020-08-18 21:13:54'),
(51, 3, 'config reseau initial1', 0, '20200808/cin_20200818_5f3c44e912851.png', 0, '2020-08-18 21:15:21'),
(52, 3, 'config reseau initial1', 0, '20200808/cin_20200818_5f3c450f7aaf4.png', 0, '2020-08-18 21:15:59'),
(53, 3, 'config reseau initial1', 0, '20200808/cin_20200818_5f3c4731c3909.png', 0, '2020-08-18 21:25:05'),
(54, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c4d42283d1.png', 0, '2020-08-18 21:50:58'),
(55, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c4f1102375.png', 0, '2020-08-18 21:58:41'),
(56, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c5243a97ed.png', 0, '2020-08-18 22:12:19'),
(57, 3, 'Annotation 2020-07-27 023432', 0, '20200808/bol_20200818_5f3c5626300b8.png', 0, '2020-08-18 22:28:54'),
(58, 3, 'config reseau initial3', 0, '20200808/bol_20200818_5f3c56264b321.png', 0, '2020-08-18 22:28:54'),
(59, 3, 'data-berlin-6535-179', 0, '20200808/bol_20200818_5f3c562670766.jpeg', 0, '2020-08-18 22:28:54'),
(60, 3, '827', 0, '20200808/bfu_20200820_5f3dc5072209c.jpeg', 0, '2020-08-20 00:34:15'),
(61, 3, 'Annotation 2020-06-20 004118', 0, '20200808/bol_20200820_5f3dcb8d028a4.png', 0, '2020-08-20 01:02:05'),
(62, 3, 'Annotation 2020-06-20 004118', 0, '20200808/bol_20200820_5f3dcc8639f5d.png', 0, '2020-08-20 01:06:14'),
(63, 3, '91302737_522715215114101_1744705523401359360_n', 0, '20200808/cin_20200820_5f3dccc4c86bd.jpeg', 0, '2020-08-20 01:07:16'),
(64, 3, '827', 0, '20200808/bfu_20200820_5f3dccd21a11a.jpeg', 0, '2020-08-20 01:07:30'),
(65, 3, 'psie', 0, '20200808/entry_20200820_5f3dccd22ee37.png', 0, '2020-08-20 01:07:30'),
(66, 3, 'Annotation 2020-06-20 004118', 0, '20200808/receipt_20200820_5f3dccd24944a.png', 0, '2020-08-20 01:07:30'),
(67, 3, 'Annotation 2020-06-20 004118', 0, '20200808/bol/', 0, '2020-08-20 01:19:01'),
(68, 3, '91302737_522715215114101_1744705523401359360_n', 0, '20200808/cin/', 0, '2020-08-20 01:19:41'),
(69, 3, '827', 0, '20200808/bfu/', 0, '2020-08-20 01:19:55'),
(70, 3, 'psie', 0, '20200808/entry/', 0, '2020-08-20 01:19:55'),
(71, 3, '91815366_583625952244241_5740603440443162624_n', 0, '20200808/receipt/', 0, '2020-08-20 01:19:55'),
(72, 3, 'Annotation 2020-06-20 004118', 0, '20200808/bol/bol_20200820_5f3dd0f348c61.png', 0, '2020-08-20 01:25:07'),
(73, 3, '91302737_522715215114101_1744705523401359360_n', 0, '20200808/cin/cin_20200820_5f3dd120aad68.jpeg', 0, '2020-08-20 01:25:52'),
(74, 3, '827', 0, '20200808/bfu/bfu_20200820_5f3dd129cce91.jpeg', 0, '2020-08-20 01:26:01'),
(75, 3, 'psie', 0, '20200808/entry/entry_20200820_5f3dd129e2ec2.png', 0, '2020-08-20 01:26:01'),
(76, 3, '91815366_583625952244241_5740603440443162624_n', 0, '20200808/receipt/receipt_20200820_5f3dd12a1f100.jpeg', 0, '2020-08-20 01:26:02'),
(77, 3, 'Annotation 2020-06-20 004118', 0, '20200808/bol/bol_20200820_5f3dd1e70d688.png', 0, '2020-08-20 01:29:11'),
(78, 3, '91302737_522715215114101_1744705523401359360_n', 0, '20200808/cin/cin_20200820_5f3dd21024394.jpeg', 0, '2020-08-20 01:29:52'),
(79, 3, '827', 0, '20200808/bfu/bfu_20200820_5f3dd2192f3d6.jpeg', 0, '2020-08-20 01:30:01'),
(80, 3, '3d-moving-wallpaper-for-windows-10-51-images-3d-moving-wallpaper', 0, '20200808/entry/entry_20200820_5f3dd21943af4.jpeg', 0, '2020-08-20 01:30:01'),
(81, 3, '91815366_583625952244241_5740603440443162624_n', 0, '20200808/receipt/receipt_20200820_5f3dd21950307.jpeg', 0, '2020-08-20 01:30:01'),
(82, 3, 'debrouillons nous', 0, '20200808/bol/bol_20200820_5f3dd2a94c01f.png', 0, '2020-08-20 01:32:25'),
(83, 3, 'debrouillons nous', 0, '20200808/bfu/bfu_20200820_5f3dd2bc937a3.png', 0, '2020-08-20 01:32:44'),
(84, 3, 'DSC_1722', 0, '20200808/bol/bol_20200820_5f3dd390caccc.jpeg', 0, '2020-08-20 01:36:16'),
(85, 2, 'DSC_1722', 0, '20200808/bol/bol_20200822_5f418b32e1c53.jpeg', 0, '2020-08-22 21:16:34'),
(86, 2, 'Annotation 2020-06-20 004118', 0, '20200808/bol/bol_20200823_5f4247c35ec37.png', 0, '2020-08-23 10:41:07'),
(87, 3, 'WhatsApp Image 2020-08-23 at 12.42.30 PM', 0, '20200808/bol/bol_20200824_5f443558b6bc8.jpeg', 0, '2020-08-24 21:47:04'),
(88, 3, 'WhatsApp Image 2020-08-23 at 12.39.39 PM', 0, '20200808/cin/cin_20200824_5f4435a84b51b.jpeg', 0, '2020-08-24 21:48:24'),
(89, 3, 'WhatsApp Image 2020-08-23 at 12.39.39 PM', 0, '20200808/bfu/bfu_20200824_5f4435b3d07d3.jpeg', 0, '2020-08-24 21:48:35'),
(90, 3, 'WhatsApp Image 2020-08-23 at 12.39.39 PM', 0, '20200808/entry/entry_20200824_5f4435b3e2d23.jpeg', 0, '2020-08-24 21:48:35'),
(91, 3, 'Annotation 2020-07-27 023432', 0, '20200808/receipt/receipt_20200824_5f4435b3f3486.png', 0, '2020-08-24 21:48:36'),
(92, 3, 'config reseau initial2', 0, '20200808/bol/bol_20200825_5f458366cd088.png', 0, '2020-08-25 21:32:22'),
(93, 3, 'data-berlin-6535-179', 0, '20200808/bfu/bfu_20200825_5f45838393eff.jpeg', 0, '2020-08-25 21:32:51'),
(94, 3, 'Untitled-1', 0, '20200808/entry/entry_20200825_5f458383a32c6.png', 0, '2020-08-25 21:32:51'),
(95, 3, 'Annotation 2020-07-27 023432', 0, '20200808/receipt/receipt_20200825_5f458383b3ab5.png', 0, '2020-08-25 21:32:51'),
(97, 2, 'config reseau initial2', 0, '20200808/bol/bol_20200825_5f4586a6ac2a3.png', 0, '2020-08-25 21:46:14'),
(98, 2, 'Annotation 2020-07-27 023432', 0, '20200808/bol/bol_20200825_5f458865db25e.png', 0, '2020-08-25 21:53:41'),
(99, 2, 'config reseau initial2', 0, '20200808/bol/bol_20200825_5f458a2cb2efc.png', 0, '2020-08-25 22:01:16'),
(100, 2, 'user', 0, '20200808/bol/bol_20200825_5f458a8e0b74a.jpeg', 0, '2020-08-25 22:02:54'),
(101, 2, 'vlcsnap-2020-07-26-08h04m58s094', 0, '20200808/bol/bol_20200825_5f458af4528f9.png', 0, '2020-08-25 22:04:36'),
(102, 6, 'config reseau initial1', 0, '20200808/assurance/assurance_20200826_5f46b5175240d.png', 0, '2020-08-26 19:16:39'),
(103, 6, 'GmlGFlottant', 0, '20200808/assurance/assurance_20200826_5f46b5d660c0d.jpeg', 0, '2020-08-26 19:19:50'),
(104, 6, 'IMG-20190413-WA0042', 0, '20200808/assurance/assurance_20200826_5f46b63cacae3.jpeg', 0, '2020-08-26 19:21:32'),
(105, 2, 'data-berlin-6535-179', 0, 'bol/20200808/bol_20200828_5f499278ea498.jpeg', 0, '2020-08-28 23:25:46'),
(108, 2, 'debrouillons nous', 0, 'bol/20200808/bol_20200829_5f49bbb9a35cb.png', 0, '2020-08-29 01:02:24'),
(109, 3, '827', 0, 'bol/20200808/bol_20200829_5f49ad3aa294b.jpeg', 0, '2020-08-29 01:19:55'),
(110, 3, 'debrouillons nous', 0, 'cin/20200808/cin_20200829_5f49af854e661.png', 0, '2020-08-29 01:29:42'),
(111, 3, '91815366_583625952244241_5740603440443162624_n', 0, 'bfu/20200808/bfu_20200829_5f49b0297bda8.jpeg', 0, '2020-08-29 01:30:01'),
(112, 3, '91302737_522715215114101_1744705523401359360_n', 0, 'entry/20200808/entry_20200829_5f49af9947b48.jpeg', 0, '2020-08-29 01:30:01'),
(113, 3, 'data-berlin-6535-179', 0, 'receipt/20200808/receipt_20200829_5f49b02b0d2b3.jpeg', 0, '2020-08-29 01:30:02'),
(114, 6, 'data-berlin-6535-179', 0, 'assurance/20200808/assurance_20200829_5f49c4a8e0a23.jpeg', 0, '2020-08-29 02:59:54'),
(115, 2, 'user', 0, 'bol/20200808/bol_20200829_5f4a486407e18.jpeg', 0, '2020-08-29 12:21:57'),
(116, 3, 'windows-10-sinii-fon-windows', 0, 'bol/20200808/bol_20200829_5f4a4d0e919a9.jpeg', 0, '2020-08-29 12:41:52'),
(117, 3, 'debrouillons nous', 0, 'cin/20200808/cin_20200829_5f4a4d46c70f0.png', 0, '2020-08-29 12:42:48'),
(118, 3, '827', 0, 'bfu/20200808/bfu_20200829_5f4a4d5261ad8.jpeg', 0, '2020-08-29 12:42:59'),
(119, 3, '91302737_522715215114101_1744705523401359360_n', 0, 'entry/20200808/entry_20200829_5f4a4d53eb4eb.jpeg', 0, '2020-08-29 12:43:00'),
(120, 3, 'user', 0, 'receipt/20200808/receipt_20200829_5f4a4d543aeb8.jpeg', 0, '2020-08-29 12:43:00'),
(121, 37, '827', 0, 'bol/20200808/bol_20200830_5f4b6d39b13f1.jpeg', 0, '2020-08-30 09:11:23'),
(122, 37, 'debrouillons nous', 0, 'cin/20200808/cin_20200830_5f4b6d9d5f336.png', 0, '2020-08-30 09:13:02'),
(123, 37, '827', 0, 'bol/20200808/bol_20200830_5f4b6dcf8bea2.jpeg', 0, '2020-08-30 09:13:53'),
(124, 37, 'windows-10-sinii-fon-windows', 0, 'cin/20200808/cin_20200830_5f4b6df9a3744.jpeg', 0, '2020-08-30 09:14:35'),
(125, 37, 'data-berlin-6535-179', 0, 'bfu/20200808/bfu_20200830_5f4b6e065416a.jpeg', 0, '2020-08-30 09:14:47'),
(126, 37, 'user', 0, 'entry/20200808/entry_20200830_5f4b6e07eafce.jpeg', 0, '2020-08-30 09:14:48'),
(127, 37, 'psie', 0, 'receipt/20200808/receipt_20200830_5f4b6e08407ef.png', 0, '2020-08-30 09:14:48'),
(128, 37, 'debrouillons nous', 0, 'bfu/20200808/bfu_20200830_5f4b6e8c53334.png', 0, '2020-08-30 09:17:01'),
(129, 37, 'data-berlin-6535-179', 0, 'entry/20200808/entry_20200830_5f4b6e8e09b5c.jpeg', 0, '2020-08-30 09:17:02'),
(130, 37, 'psie', 0, 'receipt/20200808/receipt_20200830_5f4b6e8e664d7.png', 0, '2020-08-30 09:17:02'),
(131, 37, 'Annotation 2020-06-20 004118', 0, 'bol/20200808/bol_20200830_5f4b75f63d45d.png', 0, '2020-08-30 09:48:39'),
(132, 37, 'Annotation 2020-06-20 004118', 0, 'bfu/20200808/bfu_20200830_5f4b761018433.png', 0, '2020-08-30 09:49:05'),
(133, 37, 'psie', 0, 'entry/20200808/entry_20200830_5f4b7611539e5.png', 0, '2020-08-30 09:49:06'),
(134, 37, 'psie', 0, 'receipt/20200808/receipt_20200830_5f4b761237a3e.png', 0, '2020-08-30 09:49:06'),
(135, 2, 'user', 0, 'bol/20200808/bol_20200830_5f4b7978434f0.jpeg', 0, '2020-08-30 10:03:37'),
(136, 6, 'debrouillons nous', 0, 'assurance/20200808/assurance_20200830_5f4b7af5141c3.png', 0, '2020-08-30 10:09:58'),
(137, 39, 'psie', 0, 'bol/20200808/bol_20200830_5f4b9472429d9.png', 0, '2020-08-30 11:53:12'),
(138, 38, 'Annotation 2020-06-20 004118', 0, 'assurance/20200808/assurance_20200830_5f4b954406a27.png', 0, '2020-08-30 12:02:13'),
(139, 40, 'debrouillons nous', 0, 'bol/20200808/bol_20200830_5f4b97c78a1bf.png', 0, '2020-08-30 12:12:57'),
(140, 40, 'data-berlin-6535-179', 0, 'cin/20200808/cin_20200830_5f4b98db74343.jpeg', 0, '2020-08-30 12:17:33'),
(141, 40, 'data-berlin-6535-179', 0, 'bfu/20200808/bfu_20200830_5f4b98f2074e5.jpeg', 0, '2020-08-30 12:17:56'),
(142, 40, 'Annotation 2020-06-20 004118', 0, 'entry/20200808/entry_20200830_5f4b98f4e4062.png', 0, '2020-08-30 12:17:57'),
(143, 40, 'debrouillons nous', 0, 'receipt/20200808/receipt_20200830_5f4b98f55d9a8.png', 0, '2020-08-30 12:17:57'),
(144, 3, 'Annotation 2020-06-20 004118', 0, 'bol/20200808/bol_20200830_5f4c228aa0d2d.png', 0, '2020-08-30 22:05:03'),
(145, 3, 'Annotation 2020-06-20 004118', 0, 'bfu/20200808/bfu_20200830_5f4c22dce0616.png', 0, '2020-08-30 22:06:21'),
(146, 3, 'debrouillons nous', 0, 'entry/20200808/entry_20200830_5f4c22de0dc7b.png', 0, '2020-08-30 22:06:22'),
(147, 3, 'windows-10-sinii-fon-windows', 0, 'receipt/20200808/receipt_20200830_5f4c22dec0e79.jpeg', 0, '2020-08-30 22:06:23'),
(148, 2, '91815366_583625952244241_5740603440443162624_n', 0, 'bol/20200808/bol_20200831_5f4c402f75a95.jpeg', 0, '2020-08-31 00:11:28'),
(149, 2, 'Annotation 2020-06-20 004118', 0, 'bol/20200808/bol_20200831_5f4c40c210ebd.png', 0, '2020-08-31 00:13:55'),
(150, 3, 'Annotation 2020-06-20 004118', 0, 'bol/20200808/bol_20200831_5f4c41cfebb02.png', 0, '2020-08-31 00:18:25'),
(151, 3, '827', 0, 'bol/20200808/bol_20200831_5f4c4270e4f65.jpeg', 0, '2020-08-31 00:21:06'),
(152, 3, 'Annotation 2020-06-20 004118', 0, 'bfu/20200808/bfu_20200831_5f4c429056d32.png', 0, '2020-08-31 00:21:37'),
(153, 3, 'quantum-theory-bends-the-limits-of-physics-showing-two-way-signaling-may-be-possible2', 0, 'entry/20200808/entry_20200831_5f4c42919e9f8.jpeg', 0, '2020-08-31 00:21:38'),
(154, 3, 'psie', 0, 'receipt/20200808/receipt_20200831_5f4c42922b7d6.png', 0, '2020-08-31 00:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `fleet`
--

CREATE TABLE `fleet` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fleet`
--

INSERT INTO `fleet` (`id`, `user_id`, `name`, `info`, `deleted`, `created_at`) VALUES
(3, 1, 'TAG A,B,D', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias assumenda deserunt eos est laborum magnam maxime, molestias optio sint veniam veritatis vitae! Dolor ex iste magnam numquam, recusandae suscipit.', 0, '2020-08-06 23:08:20'),
(4, 1, 'SOBAMAR', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias assumenda deserunt eos est laborum magnam maxime, molestias optio sint veniam veritatis vitae! Dolor ex iste magnam numquam, recusandae suscipit.', 0, '2020-08-06 23:08:38'),
(5, 1, 'ROYAL', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias assumenda deserunt eos est laborum magnam maxime, molestias optio sint veniam veritatis vitae! Dolor ex iste magnam numquam, recusandae suscipit.', 0, '2020-08-06 23:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `home_announce`
--

CREATE TABLE `home_announce` (
  `id` int NOT NULL,
  `summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imform`
--

CREATE TABLE `imform` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `importer`
--

CREATE TABLE `importer` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `importer`
--

INSERT INTO `importer` (`id`, `user_id`, `name`, `phone`, `email`, `address`, `deleted`, `created_at`) VALUES
(1, 2, 'Ginette', '+22998154748', 'ginette2@net.fr', NULL, 0, '2020-08-10 22:11:42'),
(2, 2, 'Hugues', '+229989856', 'net@de.d', NULL, 0, '2020-08-10 22:20:24'),
(3, 4, 'Halène', '974503627', 'marnog5nac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-12 01:48:42'),
(4, 3, 'Hougbè', '+22998787810', NULL, NULL, 0, '2020-08-12 20:34:45'),
(5, 2, 'Géraldo', '+22998747475', NULL, NULL, 0, '2020-08-12 20:53:51'),
(6, 4, 'Ulrick', '+22987147852', 'djd@oo.de', NULL, 1, '2020-08-12 20:55:07'),
(7, 3, 'Ruth', '+2298877488', NULL, NULL, 0, '2020-08-12 21:19:38'),
(8, 2, 'Gilles', '+22996968585', NULL, NULL, 0, '2020-08-12 21:23:00'),
(9, 3, 'Marno', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-13 23:14:10'),
(10, 2, 'Marnoo', '97403628', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-13 23:14:59'),
(11, 3, 'Parfait', '+229989885811', 'ner@net.de', NULL, 0, '2020-08-14 01:00:34'),
(14, 2, 'Dsf Sarl', '+229987878', NULL, NULL, 1, '2020-08-16 14:11:27'),
(15, 3, 'Gt Sarl', '+2299898845', NULL, NULL, 1, '2020-08-16 14:14:36'),
(16, 2, 'Koko Sarl', '+2299984984', NULL, NULL, 1, '2020-08-16 14:16:02'),
(17, 2, 'Kaki Sarl', '+22989889968', NULL, NULL, 1, '2020-08-16 14:16:44'),
(18, 4, 'Too Sarl', '+2299887885', NULL, NULL, 0, '2020-08-16 14:17:18'),
(19, 4, 'Goi Sarl', '+2299894849', NULL, NULL, 0, '2020-08-16 14:20:31'),
(20, 2, 'Fea Sarl', NULL, NULL, NULL, 1, '2020-08-16 14:20:56'),
(24, 4, 'Dea Sarl', '+2299894889', 'dea@nel.fr', 'dea sis à cotoonou', 0, '2020-08-16 14:25:40'),
(25, 2, 'Sdf Sarl', '56fg54fdg65', NULL, NULL, 1, '2020-08-16 14:25:52'),
(26, 2, 'Sddsds', 'dssqdsqdqsdsqd', NULL, NULL, 1, '2020-08-16 14:29:52'),
(27, 2, 'Dfgfdgfd', 'fgfdgfdgfdngdgnf', NULL, NULL, 1, '2020-08-16 14:31:28'),
(28, 2, 'Rtretreter', NULL, NULL, NULL, 1, '2020-08-16 14:31:57'),
(35, 3, 'Raix Sarl', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:46:14'),
(36, 3, 'Toto Sarl', '97403699', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:46:34'),
(37, 3, 'Alexandre', '+22997403600', 'marnognabc@gmail.com', 'Porto-Novo/Tokpota/C/SB M\\GNACADJA', 0, '2020-08-20 00:57:45'),
(38, 2, 'Gigort Sarl', '+229988985', NULL, NULL, 0, '2020-08-29 01:00:16'),
(39, 37, 'Celineimport', '+22998988587', 'celine@nel.fr', NULL, 0, '2020-08-30 09:11:05'),
(40, 39, 'Gvot Sarl', '+22997983478', NULL, NULL, 0, '2020-08-30 11:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `inform`
--

CREATE TABLE `inform` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logger`
--

CREATE TABLE `logger` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `entity_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` int DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `made_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logger`
--

INSERT INTO `logger` (`id`, `user_id`, `entity_name`, `entity_id`, `action`, `path`, `ip`, `made_at`) VALUES
(1, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:22:41'),
(2, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:28:23'),
(3, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:28:24'),
(4, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:52'),
(5, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:55'),
(6, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:55'),
(7, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:56'),
(8, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:56'),
(9, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:56'),
(10, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:56'),
(11, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:57'),
(12, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:57'),
(13, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:30:57'),
(14, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:40'),
(15, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:41'),
(16, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:43'),
(17, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:43'),
(18, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:44'),
(19, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:45'),
(20, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-11-14 23:38:45'),
(21, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:23:07'),
(22, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:25:22'),
(23, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:34:54'),
(24, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:34:57'),
(25, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:34:58'),
(26, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:47:56'),
(27, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:47:59'),
(28, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:48:00'),
(29, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 04:49:18'),
(30, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 05:18:26'),
(31, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 05:18:28'),
(32, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-21 05:19:26'),
(33, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-23 02:03:26'),
(34, 1, 'AdminDashboard', NULL, 'displayed.index', 'http://localhost:8000/dashboard', '127.0.0.1', '2025-12-23 02:03:27'),
(35, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-12-28 03:18:19'),
(36, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2025-12-28 03:39:32'),
(37, 1, 'AdminDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/actors/admin', '127.0.0.1', '2025-12-28 03:39:43'),
(38, 1, 'App\\Entity\\Transfer', NULL, 'displayed.index', 'https://127.0.0.1:8000/transfer/waiting', '127.0.0.1', '2025-12-28 03:42:42'),
(39, 1, 'App\\Entity\\Transfer.Waiting', NULL, 'displayed.index', 'https://127.0.0.1:8000/transfer/inprogress', '127.0.0.1', '2025-12-28 03:42:43'),
(40, 1, 'App\\Entity\\Transfer.Rejected', NULL, 'displayed.index', 'https://127.0.0.1:8000/transfer/rejected', '127.0.0.1', '2025-12-28 03:42:44'),
(41, 1, 'App\\Entity\\Transfer.Finalized', NULL, 'displayed.index', 'https://127.0.0.1:8000/transfer/finalized', '127.0.0.1', '2025-12-28 03:42:45'),
(42, 1, 'App\\Entity\\Importer', NULL, 'displayed.index', 'https://127.0.0.1:8000/importer/', '127.0.0.1', '2025-12-28 03:42:52'),
(43, 1, 'App\\Entity\\Vehicle', NULL, 'displayed.index', 'https://127.0.0.1:8000/vehicle/', '127.0.0.1', '2025-12-28 03:42:53'),
(44, 1, 'ManagerDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/actors/manager', '127.0.0.1', '2025-12-28 03:42:56'),
(45, 1, 'ManagerDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/actors/manager', '127.0.0.1', '2025-12-28 04:45:24'),
(46, 1, 'ManagerDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/actors/manager', '127.0.0.1', '2025-12-28 05:57:29'),
(47, 1, 'App\\Entity\\Vehicle', NULL, 'displayed.index', 'https://127.0.0.1:8000/vehicle/', '127.0.0.1', '2025-12-28 05:57:37'),
(48, 1, 'App\\Entity\\Importer', NULL, 'displayed.index', 'https://127.0.0.1:8000/importer/', '127.0.0.1', '2025-12-28 05:57:41'),
(49, 1, 'App\\Entity\\Transfer', NULL, 'displayed.index', 'https://127.0.0.1:8000/transfer/waiting', '127.0.0.1', '2025-12-28 05:57:43'),
(50, 1, 'ManagerDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2026-01-01 04:50:20'),
(51, 1, 'ManagerDashboard', NULL, 'displayed.index', 'https://127.0.0.1:8000/dashboard', '127.0.0.1', '2026-01-15 03:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int NOT NULL,
  `fleet_id` int NOT NULL,
  `compagny` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `fleet_id`, `compagny`, `ifu`, `register_num`) VALUES
(2, 5, 'Umbrela Corp', 'f7sdfd5664s8d4', '65sdf4f6ds4f65sd4'),
(4, 4, 'Sobamar', '511564cfg554846', '5s6d4fsd864f'),
(5, 4, 'sobamar', '2sd5f5sfe568', 'sd6f5d4f6ze9f4'),
(39, 4, 'SOBAMAR', '51156554454846', 'dfds5d445s');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `transfer_id` int DEFAULT NULL,
  `removal_id` int DEFAULT NULL,
  `creator_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_already_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `transfer_id`, `removal_id`, `creator_id`, `title`, `content`, `created_at`, `type`, `is_already_read`) VALUES
(1, 37, NULL, 19, 6, 'Demande acceptée', 'Votre demande d\'enlèvement a été approuvée', '2020-08-30 09:21:05', 'success', 0),
(2, 37, NULL, 12, 6, 'Demande acceptée', 'Votre demande d\'enlèvement du véhicle de chassis ds5f56dsfzee8zf484fz a été approuvée', '2020-08-30 09:25:18', 'success', 1),
(3, 37, NULL, 20, 6, 'Demande rejetée', 'Votre demande d\'enlèvement a été rejetée', '2020-08-30 09:26:04', 'danger', 1),
(4, 37, NULL, 21, 6, 'Demande rejetée', 'Votre demande d\'enlèvement du véhicule de châssis 78945678912345678 a été rejetée <br><b><u>Raison</u>: Veuillez revoir la photo de la demande</b>', '2020-08-30 09:51:34', 'danger', 1),
(5, 37, NULL, 21, 6, 'Demande rejetée', 'Votre demande d\'enlèvement du véhicule de châssis 78945678912345678 a été rejetée <br><b><u>Raison</u>: Vous n\'avez pas mis à jour la bonne photo</b>', '2020-08-30 09:59:07', 'danger', 1),
(6, 2, 18, NULL, 6, 'Demande rejetée', 'Votre demande de transfert du véhicule de châssis JT40P2613UV801754 a été rejetée <br><b><u>Raison</u>: Veuillez mettre à jour le connaissancement. Ce n\'est pas visible</b>', '2020-08-30 10:04:47', 'danger', 1),
(7, 2, 18, NULL, 6, 'Demande acceptée', 'Votre demande de transfert du véhicule de châssis JT40P2613UV801754 a été approuvée', '2020-08-30 10:09:58', 'success', 1),
(8, 39, 19, NULL, 38, 'Demande rejetée', 'Votre demande de transfert du véhicule de châssis JT223640556342011 a été rejetée <br><b><u>Raison</u>: Le connaissement n\'est pas lisible</b>', '2020-08-30 11:57:23', 'danger', 1),
(9, 39, 19, NULL, 38, 'Demande acceptée', 'Votre demande de transfert du véhicule de châssis JT223640556342011 a été approuvée', '2020-08-30 12:02:13', 'success', 1),
(10, 40, NULL, 22, 38, 'Demande acceptée', 'Votre demande d\'enlèvement du véhicule de châssis JT223640556342081 a été approuvée', '2020-08-30 12:19:39', 'success', 0),
(11, 40, NULL, 22, 38, 'Demande acceptée', 'Votre demande d\'enlèvement du véhicule de châssis JT223640556342081 a été approuvée', '2020-08-30 12:22:38', 'success', 0),
(12, 3, NULL, 24, 6, 'Demande acceptée', 'Votre demande d\'enlèvement du véhicule de châssis JT40P2613UV010259 a été approuvée', '2020-08-31 01:08:53', 'success', 0);

-- --------------------------------------------------------

--
-- Table structure for table `processing`
--

CREATE TABLE `processing` (
  `id` int NOT NULL,
  `transfer_id` int DEFAULT NULL,
  `removal_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `verdict` tinyint(1) DEFAULT NULL,
  `reason` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `processing`
--

INSERT INTO `processing` (`id`, `transfer_id`, `removal_id`, `user_id`, `verdict`, `reason`, `created_at`) VALUES
(4, 12, NULL, 6, 1, NULL, '2020-08-23 11:19:56'),
(5, 1, NULL, 6, 1, NULL, '2020-08-23 22:38:48'),
(6, NULL, 1, 6, 1, NULL, '2020-08-24 21:41:37'),
(7, NULL, 1, 6, 1, NULL, '2020-08-24 22:10:01'),
(8, NULL, 2, 6, 1, NULL, '2020-08-24 22:25:57'),
(9, NULL, 2, 6, 1, NULL, '2020-08-24 22:30:43'),
(10, NULL, 2, 6, 0, 'veuillez rejoindre les fichiers', '2020-08-24 23:48:43'),
(11, NULL, 16, 6, 1, NULL, '2020-08-25 21:04:36'),
(12, NULL, 16, 6, 0, 'Veuillez joindre un fichier de connaissement', '2020-08-25 21:14:37'),
(13, NULL, 3, 6, 0, 'veuillez joindre les images', '2020-08-25 21:19:51'),
(14, NULL, 15, 6, 1, NULL, '2020-08-25 21:22:39'),
(15, NULL, 14, 6, 1, NULL, '2020-08-25 21:23:29'),
(16, 2, NULL, 6, 0, 'veuillez joindre le connaissement du véhicule', '2020-08-25 21:34:53'),
(17, 3, NULL, 6, 0, 'portez ce vieuw whisky au juge blond qui fume', '2020-08-25 21:37:19'),
(18, 6, NULL, 6, 1, NULL, '2020-08-25 21:37:52'),
(19, 7, NULL, 6, 0, 'je ne suis pas sur de ce que vous dites là', '2020-08-25 21:47:38'),
(20, 13, NULL, 6, 1, NULL, '2020-08-25 21:56:20'),
(21, 7, NULL, 6, 1, NULL, '2020-08-25 22:09:33'),
(22, 8, NULL, 6, 1, NULL, '2020-08-25 22:11:02'),
(23, NULL, 14, 6, 0, 'veuillez revoie les images et renvoyé la demande', '2020-08-25 22:17:08'),
(24, 9, NULL, 10, 0, 'je me le demande', '2020-08-26 02:10:19'),
(25, 10, NULL, 6, 1, NULL, '2020-08-26 23:05:51'),
(26, 11, NULL, 6, 1, NULL, '2020-08-26 23:07:10'),
(27, 11, NULL, 6, 1, NULL, '2020-08-26 23:31:25'),
(28, 11, NULL, 6, 1, NULL, '2020-08-26 23:40:33'),
(29, 11, NULL, 6, 1, NULL, '2020-08-27 19:52:55'),
(30, 11, NULL, 6, 1, NULL, '2020-08-27 20:32:26'),
(31, 11, NULL, 6, 1, NULL, '2020-08-27 20:48:12'),
(32, 11, NULL, 6, 0, 'aucun ficiher trouver', '2020-08-28 01:54:36'),
(33, 16, NULL, 6, 1, NULL, '2020-08-29 02:55:26'),
(34, NULL, 17, 6, 1, NULL, '2020-08-29 03:01:24'),
(35, NULL, 18, 6, 1, NULL, '2020-08-29 12:48:09'),
(36, NULL, 18, 6, 1, NULL, '2020-08-29 12:51:12'),
(37, NULL, 18, 6, 1, NULL, '2020-08-29 13:11:23'),
(38, NULL, 18, 6, 1, NULL, '2020-08-29 13:12:38'),
(39, NULL, 18, 6, 1, NULL, '2020-08-29 14:48:58'),
(40, 1, NULL, 6, 1, NULL, '2020-08-29 14:50:43'),
(41, 1, NULL, 6, 1, NULL, '2020-08-29 14:53:56'),
(42, NULL, 13, 6, 1, NULL, '2020-08-29 15:33:58'),
(43, NULL, 13, 6, 1, NULL, '2020-08-29 16:59:22'),
(44, 17, NULL, 6, 1, NULL, '2020-08-29 17:21:12'),
(45, NULL, 19, 6, 1, NULL, '2020-08-30 09:20:05'),
(46, NULL, 12, 6, 1, NULL, '2020-08-30 09:25:13'),
(47, NULL, 20, 6, 0, 'Veuillez ajouter les photos correctes', '2020-08-30 09:25:43'),
(48, NULL, 21, 6, 0, 'Veuillez revoir la photo de la demande', '2020-08-30 09:49:41'),
(49, NULL, 21, 6, 0, 'Vous n\'avez pas mis à jour la bonne photo', '2020-08-30 09:58:42'),
(50, 18, NULL, 6, 0, 'Veuillez mettre à jour le connaissancement. Ce n\'est pas visible', '2020-08-30 10:04:15'),
(51, 18, NULL, 6, 1, NULL, '2020-08-30 10:06:35'),
(52, 19, NULL, 38, 0, 'Le connaissement n\'est pas lisible', '2020-08-30 11:54:56'),
(53, 19, NULL, 38, 1, NULL, '2020-08-30 11:58:58'),
(54, NULL, 22, 38, 1, NULL, '2020-08-30 12:18:33'),
(55, NULL, 24, 6, 1, NULL, '2020-08-31 01:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `name`, `deleted`, `public`, `created_at`, `slug`) VALUES
(1, 'Commissionnaire agrée en Douane', 0, 1, '2020-08-03 02:13:21', 'agent'),
(2, 'Gestionnaire de parc', 0, 1, '2020-08-04 07:45:52', 'manager'),
(3, 'Personnel de USAT Bénin', 0, 0, '2020-08-06 23:29:39', 'staff'),
(4, 'Personnel du Ministère', 0, 0, '2020-08-06 23:30:14', 'controller'),
(5, 'Importateur', 0, 0, '2020-08-09 22:49:07', 'importer'),
(6, 'Responsable USAT Bénin', 0, 0, '2020-08-25 23:52:28', 'staff_admin');

-- --------------------------------------------------------

--
-- Table structure for table `removal`
--

CREATE TABLE `removal` (
  `id` int NOT NULL,
  `agent_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `remover_id` int NOT NULL,
  `pay_bank_id` int NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bfu_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `fleet_id` int NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `removal`
--

INSERT INTO `removal` (`id`, `agent_id`, `vehicle_id`, `remover_id`, `pay_bank_id`, `status`, `bfu_num`, `entry_num`, `deleted`, `created_at`, `fleet_id`, `reference`) VALUES
(1, 3, 27, 1, 1, 'inprogress', '6564sd8f4sd89f4', '8ds4f68ds4f864', 0, '2020-08-17 23:46:29', 4, NULL),
(2, 3, 28, 1, 2, 'rejected', '6564sdd8f4sd89f4', '8ds4f6d8ds4f864', 0, '2020-08-17 22:56:24', 3, NULL),
(3, 3, 29, 1, 1, 'rejected', 'fdggfgsnsnsdsdg', 'fgndfgdfryy,eryerye', 0, '2020-08-18 00:31:51', 5, NULL),
(4, 3, 30, 1, 1, 'waiting', 'rtrgretetertertretert', 'gsgsdfsdfsdfzeze', 0, '2020-08-18 00:34:58', 5, NULL),
(5, 3, 33, 1, 1, 'waiting', '6564sdd8f4sd89f4', 'fdgfdgrtrdfgdfgddf', 0, '2020-08-18 00:51:40', 4, NULL),
(8, 3, 34, 1, 2, 'waiting', '6564sdd8f4sd89f5', 'gsgsdfsdfsdfzezef', 0, '2020-08-18 01:02:16', 5, NULL),
(9, 3, 35, 1, 2, 'waiting', '6564sdd8f4sd89f4d', 'fdgfdgrtrdfgdfgdd', 0, '2020-08-18 01:03:25', 3, NULL),
(10, 3, 38, 6, 1, 'waiting', '6564sdd8f4sd8941', 'gsgsdfsdfsdfze74', 0, '2020-08-18 19:54:48', 4, NULL),
(11, 3, 45, 3, 2, 'waiting', 'sdgfdsfdsfgdsfsdfse', 'hhrturutrytyertzrz', 0, '2020-08-18 22:28:54', 4, NULL),
(12, 3, 47, 11, 1, 'finalized', '6564sd_d8f4sd89f4', '8ds4f6_d8ds4f864', 0, '2020-08-20 01:07:30', 3, NULL),
(13, 3, 48, 12, 1, 'finalized', '6564sdd8f4sd89f4p', 'gsgsdfsdfsdfzezer', 0, '2020-08-20 01:19:55', 5, NULL),
(14, 3, 49, 13, 1, 'rejected', '65ppp64sdd8f4sd89f4', '65fsd65f4s8f4ds6f8ll', 0, '2020-08-20 01:26:01', 4, NULL),
(15, 37, 50, 14, 1, 'finalized', '656vv4sdd8f4sd89f4', '8ds4f6d8vvvds4f864', 0, '2020-08-20 01:30:01', 4, NULL),
(16, 3, 53, 15, 1, 'rejected', '6564sdd8f4sd000', '65fs0004s8f4ds6f8', 0, '2020-08-24 21:48:35', 4, NULL),
(17, 3, 57, 16, 1, 'finalized', '6564sdd4474sd89f4', 'gsgsdfsdrtfsdfzeze', 0, '2020-08-29 01:29:59', 3, NULL),
(18, 3, 59, 17, 1, 'finalized', '6564sdd8f4sd89f41', '8ds4f6d8ds4f864f', 0, '2020-08-29 12:42:58', 3, NULL),
(19, 37, 61, 19, 1, 'finalized', '6564sd8ghff4sd89f4', 'gsgsdfsdfsfgfdfzeze', 0, '2020-08-30 09:14:46', 3, NULL),
(20, 37, 60, 3, 1, 'rejected', '6564sdd8f4fezsd89f4', 'fdgfdgdfgddhefgdf', 0, '2020-08-30 09:17:00', 3, NULL),
(21, 37, 62, 1, 1, 'waiting', '6564sdd8df4sd89f4', 'fdgfdsdgrtrdfgdfgddf', 0, '2020-08-30 10:00:52', 5, NULL),
(22, 40, 65, 20, 1, 'finalized', '00174321', 's0262002', 0, '2020-08-30 12:17:53', 5, NULL),
(23, 3, 66, 1, 1, 'waiting', '6564sdd8f4sffd89f4', 'fdgfdgffrtrdfgdfgddf', 0, '2020-08-30 22:06:20', 4, NULL),
(24, 3, 70, 16, 1, 'finalized', '6564sdeeed8f4sd89f4', 'fdgfdgdsddsfgdfgdf', 0, '2020-08-31 00:21:36', 3, 'ENO771V0NG37');

-- --------------------------------------------------------

--
-- Table structure for table `remover`
--

CREATE TABLE `remover` (
  `id` int NOT NULL,
  `agent_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remover`
--

INSERT INTO `remover` (`id`, `agent_id`, `name`, `last_name`, `phone`, `email`, `address`, `deleted`, `created_at`) VALUES
(1, 3, 'Antoine', 'PADONOU', '98788587', 'antoine@nel.fr', 'Porto-Novo/Tokpota/C/SB M\\GNACADJA', 0, '2020-08-16 21:39:35'),
(2, 3, 'Donald', 'KAKA', '+22998987858', 'kaka@nel.fr', 'Porto-Novo', 0, '2020-08-18 19:52:35'),
(3, 3, 'Tibo', 'GOUTON', '+22989858578', 'tibo@nel.fr', 'Porto-Novo', 0, '2020-08-18 19:54:42'),
(4, 3, 'Marnol', 'Gnacqy', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 20:45:15'),
(5, 3, 'Mar', 'Gnacos', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 20:50:14'),
(6, 3, 'Marnox', 'Gnacx', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:12:04'),
(7, 3, 'Marnor', 'Gnacr', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:13:54'),
(8, 3, 'Marnot', 'Gnact', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:15:21'),
(9, 3, 'Marnop', 'Gnacp', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:15:59'),
(10, 3, 'Marnol', 'Gnacl', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-18 21:25:05'),
(11, 3, 'Marnog', 'Gnacg', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-20 01:07:16'),
(12, 3, 'Marnoqq', 'Gnacqq', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-20 01:19:41'),
(13, 3, 'Marnopo', 'Gnacpo', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-20 01:25:52'),
(14, 3, 'Marnovv', 'Gnacvv', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-20 01:29:52'),
(15, 3, 'Alexis', 'Goton', '+22989898748', 'alexis@net.fr', NULL, 0, '2020-08-24 21:48:24'),
(16, 3, 'Rose', 'Gouthon', '+22998898578', 'rose@nel.fr', 'Porto-Novo/Tokpota/C/SB M\\GNACADJA', 0, '2020-08-29 01:29:41'),
(17, 3, 'Marnol', 'Gnaca', '97403627', 'marnognac@gmail.com', 'BENIN/COTONOU', 0, '2020-08-29 12:42:46'),
(18, 37, 'Harry', 'FOUTOU', '+22998988586', 'harry@nel.fr', NULL, 0, '2020-08-30 09:13:01'),
(19, 37, 'James', 'Harry', '+2299898856', 'james@nel.fr', NULL, 0, '2020-08-30 09:14:33'),
(20, 40, 'Janvier', 'AHOUAN', '+22996334598', 'gmlginolias@gmail.com', 'Djeffa', 0, '2020-08-30 12:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ship`
--

CREATE TABLE `ship` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ship`
--

INSERT INTO `ship` (`id`, `name`, `deleted`, `created_at`, `slug`) VALUES
(1, 'ARGO', 0, '2020-08-10 22:02:37', 'argo'),
(2, 'BSL CAPE TOWN', 0, '2020-08-10 22:02:38', 'bsl-cape-town'),
(3, 'CPO NORFOLK', 0, '2020-08-10 22:02:38', 'cpo-norfolk'),
(4, 'GRANDE ATLANTICO', 0, '2020-08-10 22:02:38', 'grande-atlantico'),
(5, 'GRANDE BENIN', 0, '2020-08-10 22:02:38', 'grande-benin'),
(6, 'GRANDE DAKAR', 0, '2020-08-10 22:02:38', 'grande-dakar'),
(7, 'GRANDE TEMA', 0, '2020-08-10 22:02:38', 'grande-tema'),
(8, 'GRANDE TOGO', 0, '2020-08-10 22:02:38', 'grande-togo'),
(9, 'JPO SCORPIUS', 0, '2020-08-10 22:02:38', 'jpo-scorpius'),
(10, 'LPG LAPEROUSE', 0, '2020-08-10 22:02:38', 'lpg-laperouse'),
(11, 'MAERSK CAPE COAST', 0, '2020-08-10 22:02:38', 'maersk-cape-coast'),
(12, 'MERKUR FJORD', 0, '2020-08-10 22:02:38', 'merkur-fjord'),
(13, 'MSC DONATA', 0, '2020-08-10 22:02:38', 'msc-donata'),
(14, 'MSC INDIA', 0, '2020-08-10 22:02:38', 'msc-india'),
(15, 'MSC KATYAYNI', 0, '2020-08-10 22:02:39', 'msc-katyayni'),
(16, 'MSC SANDRA', 0, '2020-08-10 22:02:39', 'msc-sandra'),
(17, 'MSC SANDRA', 0, '2020-08-10 22:02:39', 'msc-sandra'),
(18, 'MSC SHAULA', 0, '2020-08-10 22:02:39', 'msc-shaula'),
(19, 'NESTOS REEFER', 0, '2020-08-10 22:02:39', 'nestos-reefer'),
(20, 'NORDIC MACAU', 0, '2020-08-10 22:02:39', 'nordic-macau'),
(21, 'NORTHERN PRELUDE', 0, '2020-08-10 22:02:39', 'northern-prelude'),
(22, 'PORT GDYNIA', 0, '2020-08-10 22:02:39', 'port-gdynia'),
(23, 'SFL TRENT', 0, '2020-08-10 22:02:39', 'sfl-trent'),
(24, 'SILVER MOON', 0, '2020-08-10 22:02:39', 'silver-moon'),
(25, 'SURVILLE', 0, '2020-08-10 22:02:39', 'surville'),
(26, 'THERESE SELMER', 0, '2020-08-10 22:02:39', 'therese-selmer'),
(27, 'TOMMI RITSCHER', 0, '2020-08-10 22:02:39', 'tommi-ritscher');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` int NOT NULL,
  `manager_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id`, `manager_id`, `vehicle_id`, `status`, `deleted`, `created_at`, `reference`) VALUES
(1, 2, 2, 'inprogress', 0, '2020-08-12 22:43:16', NULL),
(2, 2, 7, 'rejected', 0, '2020-08-13 22:58:53', NULL),
(3, 2, 8, 'rejected', 0, '2020-08-13 23:16:01', NULL),
(6, 2, 12, 'finalized', 0, '2020-08-14 01:35:02', NULL),
(7, 2, 13, 'finalized', 0, '2020-08-14 02:41:18', NULL),
(8, 4, 14, 'inprogress', 0, '2020-08-16 10:38:26', NULL),
(9, 5, 15, 'rejected', 0, '2020-08-16 11:26:24', NULL),
(10, 4, 17, 'inprogress', 0, '2020-08-16 18:17:19', NULL),
(11, 2, 18, 'rejected', 0, '2020-08-16 21:11:08', NULL),
(12, 2, 51, 'inprogress', 0, '2020-08-22 21:16:34', NULL),
(13, 2, 52, 'inprogress', 0, '2020-08-23 10:41:01', NULL),
(14, 2, 54, 'waiting', 0, '2020-08-25 22:01:16', NULL),
(15, 2, 55, 'waiting', 0, '2020-08-28 23:25:44', NULL),
(16, 2, 56, 'finalized', 0, '2020-08-29 01:02:22', NULL),
(17, 2, 58, 'inprogress', 0, '2020-08-29 12:21:55', NULL),
(18, 2, 63, 'finalized', 0, '2020-08-30 10:05:58', NULL),
(19, 39, 64, 'finalized', 0, '2020-08-30 11:58:44', NULL),
(20, 2, 67, 'waiting', 0, '2020-08-31 00:11:27', 'TRA7JU6X8154'),
(21, 2, 68, 'waiting', 0, '2020-08-31 00:13:53', 'TRL3C7DPP654');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `profil_id` int NOT NULL,
  `username` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_connection` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `profil_id`, `username`, `roles`, `password`, `name`, `last_name`, `phone`, `email`, `address`, `status`, `created_at`, `last_connection`, `is_verified`, `user_type`) VALUES
(1, 2, 'admin', '[\"ROLE_MANAGER\"]', '$2y$13$.E7UQIaFjpEVI6Hhjh75V.k7pMGvtVTG8DYwgm0hi69QL0BXT5Eie', 'Admin', 'Admin', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-09 01:38:00', '2026-01-15 03:59:11', 1, 'User'),
(2, 2, 'geo', '[\"ROLE_MANAGER\"]', '$argon2id$v=19$m=65536,t=4,p=1$c3lFVUZUd1hycjVyNThlUw$ecLmUD/PMALC1+4CH0oMaavZet13tWavrQy3z5rhJJI', 'Geo', 'GANTIN', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-09 01:38:00', '2020-08-31 00:10:20', 1, 'Manager'),
(3, 1, 'serge', '[\"ROLE_AGENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$blZnNFZ3WGovQ01VOC82Wg$Cyx+gu0uZeBvIZ9MQkyLbG4FSuqHc4v/y7SM4F063M4', 'Serge', 'GOHOU', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-09 01:16:19', '2020-08-31 00:17:44', 1, 'Agent'),
(4, 2, 'harry', '[\"ROLE_MANAGER\"]', '$argon2id$v=19$m=65536,t=4,p=1$ekhhYlcwVEhGYWVJVHdCNA$4l0qe4XCh+J6v3znPYNcu+oAoc6AZN9kSXCFYeBErGg', 'Harry', 'HUSTON', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-16 10:28:01', '2020-08-16 10:28:01', 1, 'Manager'),
(5, 2, 'price', '[\"ROLE_MANAGER\"]', '$argon2id$v=19$m=65536,t=4,p=1$YmMzOGY2elNjRzE5ZFEyVg$YjnKUqBihB0QsUSQL4/qkVPmjNXuJ94u51fjuwJ0830', 'Price', 'AMELINA', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-16 11:13:03', '2020-08-16 11:13:03', 1, 'Manager'),
(6, 6, 'nel', '[\"ROLE_STAFF_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$c3lFVUZUd1hycjVyNThlUw$ecLmUD/PMALC1+4CH0oMaavZet13tWavrQy3z5rhJJI', 'Nel', 'GNAC', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-20 19:57:57', '2020-08-31 01:08:25', 1, 'User'),
(9, 4, 'grace', '[\"ROLE_CONTROL\"]', '$argon2id$v=19$m=65536,t=4,p=1$R0ttWHV0aTM3N1IzY3d3NA$Cc2W0kGPUt9vvGjeOv8ZvDFXI2OdgEWq2l1hKcJd7v8', 'Grâce', 'Gilli', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-25 23:07:00', '2020-08-25 23:23:07', 0, 'User'),
(10, 3, 'bazil', '[\"ROLE_STAFF\"]', '$argon2id$v=19$m=65536,t=4,p=1$TGV3NkoyU0VEYU4wYXI3Sg$cHSa1u9X4TpIfewbcT482vOu5LeKVOBU1NZpkuGDWZA', 'Bazil', 'ATCHADÉ', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-25 23:09:55', '2020-08-26 02:23:38', 1, 'User'),
(37, 1, 'celine', '[\"ROLE_AGENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$QkJuTXVoSzhFWnNka28zaw$8VEPTM5XZSi+zFmXaJYTAqOefYPARBIv/MT9e5X3V78', 'Celine', 'HOUSSOU', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-30 07:48:34', '2020-08-30 09:59:28', 1, 'Agent'),
(38, 6, 'fabrice', '[\"ROLE_STAFF_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$ZDFiRktIZVVBaWFWZmFhcw$+Dha5NO9xf5a8ocbS9+RnhORJoesxEdGQsoJ02oUN8o', 'Fabrice', 'KOKOU', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-30 11:40:01', '2020-08-30 11:40:38', 1, 'User'),
(39, 2, 'farid', '[\"ROLE_MANAGER\"]', '$argon2id$v=19$m=65536,t=4,p=1$RXhELll1S2JtWi5ISnhGSw$EXhtGhlqu5r2WFpAeuNRs6LENZ1jk1G8jELzvojTGAo', 'Farid', 'SAM', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-30 11:45:23', '2020-08-30 11:57:52', 1, 'Manager'),
(40, 1, 'ducarmel', '[\"ROLE_AGENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$Y1hISk9UYmNqYnpRMkFJMw$rUnoVBZ7MgUvKHNbPGHHSo9h6ZIOiyu2c0buM81FrJA', 'Ducarmel', 'MORMON', '+2290100000000', 'info@marnel.me', 'Porto-Novo/Benin', 1, '2020-08-30 12:05:30', '2020-08-25 23:23:07', 1, 'Agent');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int NOT NULL,
  `brand_id` int NOT NULL,
  `ship_id` int NOT NULL,
  `importer_id` int NOT NULL,
  `put_in_use_at` date NOT NULL,
  `came_at` date NOT NULL,
  `consignee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `chassis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remover_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `brand_id`, `ship_id`, `importer_id`, `put_in_use_at`, `came_at`, `consignee`, `created_at`, `deleted`, `user_id`, `chassis`, `remover_id`) VALUES
(1, 14, 15, 2, '2019-05-12', '2020-08-01', 'GOUTON Alain', '2020-08-10 22:37:54', 0, 2, 'JT40P2613UV000175', NULL),
(2, 10, 18, 1, '2019-11-13', '2020-07-29', 'GOUTON Alain', '2020-08-10 22:40:35', 0, 2, 'JT40P2613UV100175', NULL),
(3, 28, 15, 10, '2010-04-01', '2019-07-15', 'GOUTON Alain', '2020-08-12 21:25:19', 1, 4, 'JT40P2613UV020175', NULL),
(7, 2, 14, 10, '2018-12-01', '2020-05-05', 'Codjo Alex', '2020-08-13 22:58:53', 0, 4, 'JT40P2613UV003175', NULL),
(8, 15, 17, 18, '2017-07-05', '2018-05-07', 'Codjo Alex', '2020-08-13 23:16:01', 0, 4, 'JT40P2613UV400175', NULL),
(12, 13, 16, 14, '2008-02-05', '2020-05-01', 'GOUTON Alain', '2020-08-14 01:35:02', 0, 2, 'JT40P2613UV080175', NULL),
(13, 15, 6, 2, '2020-07-27', '2020-08-06', 'GOUTON Alain', '2020-08-14 02:41:18', 0, 2, 'JT40P2613UV700175', NULL),
(14, 123, 13, 19, '2020-04-28', '2020-08-14', 'RORO Shipping', '2020-08-16 10:38:26', 0, 2, 'JT40P2613UV001275', NULL),
(15, 123, 4, 16, '2000-12-15', '2019-12-12', 'GRIMALDI BENIN', '2020-08-16 11:26:24', 0, 2, 'JT40P2613UV001754', NULL),
(16, 123, 4, 16, '2000-12-15', '2019-12-12', 'GRIMALDI BENIN', '2020-08-16 11:26:24', 0, 2, 'JT40P2613UV001754', NULL),
(17, 113, 15, 24, '2005-02-01', '2015-05-01', 'GRIMALDI BENIN', '2020-08-16 18:17:19', 0, 4, 'JT40P2613UV001754', NULL),
(18, 10, 11, 2, '2010-05-05', '2018-05-05', 'GOUTON Alain', '2020-08-16 21:11:08', 0, 2, 'JT40P2613UV000257', NULL),
(19, 10, 4, 5, '2010-05-01', '2010-05-04', 'GOUTON Alain', '2020-08-17 22:01:17', 0, 3, '12345678912345678', NULL),
(20, 10, 4, 5, '2010-05-01', '2010-05-04', 'GOUTON Alain', '2020-08-17 22:04:46', 0, 3, '12345674891456708', NULL),
(21, 10, 12, 17, '2015-05-01', '2010-05-05', 'RORO Shipping', '2020-08-17 22:15:34', 0, 3, '17345678912345678', NULL),
(22, 10, 12, 17, '2015-05-01', '2010-05-05', 'RORO Shipping', '2020-08-17 22:16:37', 0, 3, '17345688912345678', NULL),
(23, 10, 12, 17, '2015-05-01', '2010-05-05', 'RORO Shipping', '2020-08-17 22:17:41', 0, 3, '17345688915345678', NULL),
(24, 13, 16, 5, '2020-07-28', '2020-07-31', 'RORO Shipping', '2020-08-17 22:34:21', 0, 3, '12345448917345678', NULL),
(25, 13, 16, 5, '2020-07-28', '2020-07-31', 'RORO Shipping', '2020-08-17 22:35:53', 0, 3, '12344448917345678', NULL),
(26, 13, 16, 5, '2020-07-28', '2020-07-31', 'RORO Shipping', '2020-08-17 22:37:05', 0, 3, '42344448917345678', NULL),
(27, 18, 15, 4, '2020-07-27', '2020-08-05', 'GOUTON Alain', '2020-08-17 22:39:54', 0, 3, '12345678917345678', NULL),
(28, 29, 11, 17, '2020-07-27', '2020-07-30', 'RORO Shipping', '2020-08-17 22:56:11', 0, 3, 'JT40P2613UV000257', NULL),
(29, 7, 4, 20, '2020-07-27', '2020-08-07', 'RORO Shipping', '2020-08-18 00:24:30', 0, 3, 'JT40P2613UV000257', NULL),
(30, 14, 4, 5, '2020-07-27', '2020-08-06', 'GOUTON Alain', '2020-08-18 00:34:36', 0, 3, 'JT40P2613UV000257', NULL),
(31, 38, 7, 10, '2020-07-27', '2020-08-07', 'RORO Shipping', '2020-08-18 00:35:50', 0, 3, '12345678917345678', NULL),
(32, 49, 3, 15, '2020-08-03', '2020-08-01', 'GOUTON Alain', '2020-08-18 00:37:51', 0, 3, '12345678917345678', NULL),
(33, 49, 3, 15, '2020-08-03', '2020-08-01', 'GOUTON Alain', '2020-08-18 00:41:32', 0, 3, '22345678917345678', NULL),
(34, 4, 12, 26, '2020-07-27', '2020-08-05', 'GOUTON Alain', '2020-08-18 00:54:15', 0, 3, 'JT40P2613UV000257', NULL),
(35, 8, 12, 28, '2020-07-27', '2020-08-08', 'RORO Shipping', '2020-08-18 01:02:48', 0, 3, '17345678912345678', NULL),
(36, 18, 12, 10, '2020-07-27', '2020-08-06', 'RORO Shipping', '2020-08-18 19:43:52', 0, 3, '12345678912345678', NULL),
(37, 13, 11, 25, '2020-07-27', '2020-07-31', 'RORO Shipping', '2020-08-18 19:51:39', 0, 3, 'JT40P2613UV000257', NULL),
(38, 8, 4, 1, '2020-07-27', '2020-08-06', 'RORO Shipping', '2020-08-18 19:53:42', 0, 3, 'JT40P2613UV000257', NULL),
(39, 12, 5, 10, '2020-07-27', '2020-07-30', 'RORO Shipping', '2020-08-18 20:05:04', 0, 3, 'JT40P2613UV000257', 4),
(40, 12, 5, 10, '2020-07-27', '2020-07-30', 'RORO Shipping', '2020-08-18 20:06:10', 0, 3, 'JT40P2613UV001257', 3),
(41, 12, 5, 10, '2020-07-27', '2020-07-30', 'RORO Shipping', '2020-08-18 20:08:57', 0, 3, 'JT40P2613UT001257', 7),
(42, 12, 5, 10, '2020-07-27', '2020-07-30', 'RORO Shipping', '2020-08-18 20:18:27', 0, 3, 'JT40P26g3UT001257', 6),
(43, 8, 3, 36, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-18 21:50:58', 0, 3, '12345z78912345678', 3),
(44, 8, 3, 36, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-18 21:58:40', 0, 3, '12345z78912345611', 2),
(45, 62, 4, 5, '2020-07-27', '2020-08-13', 'RORO Shipping', '2020-08-18 22:12:19', 0, 3, 'JT40P2613UV000257', 10),
(46, 10, 2, 3, '2020-07-27', '2020-08-05', 'RORO Shipping', '2020-08-20 01:02:04', 0, 3, 'JT40P4443UV000257', NULL),
(47, 53, 4, 3, '2020-07-28', '2020-08-05', 'GOUTON Alain', '2020-08-20 01:06:14', 0, 3, 'JT40P2613UV000257', NULL),
(48, 54, 11, 35, '2020-07-28', '2020-08-13', 'GRIMALDI BENIN', '2020-08-20 01:19:00', 0, 3, 'JT40P2613UV800257', NULL),
(49, 72, 17, 24, '2020-07-27', '2020-08-08', 'GRIMALDI BENIN', '2020-08-20 01:25:07', 0, 3, 'JT40P2613UV000257', NULL),
(50, 90, 16, 35, '2020-07-28', '2020-08-13', 'RORO Shipping', '2020-08-20 01:29:10', 0, 37, 'JT40P2613UV000257', NULL),
(51, 125, 13, 18, '2020-08-03', '2020-08-12', 'GRIMALDI BENIN', '2020-08-22 21:16:34', 0, 2, 'JT40P2613UV021275', NULL),
(52, 2, 15, 24, '2020-07-27', '2020-08-06', 'RORO Shipping', '2020-08-23 10:41:01', 0, 2, '54sd68f4dfgds5551', NULL),
(53, 8, 3, 18, '2020-07-27', '2020-08-11', 'RORO Shipping', '2020-08-24 21:47:03', 0, 3, '10045678917345678', NULL),
(54, 17, 11, 18, '2020-07-27', '2020-08-11', 'RORO Shipping', '2020-08-25 22:01:16', 0, 37, '54sd68f4d0gds5555', NULL),
(55, 3, 3, 4, '2020-08-19', '2020-08-07', 'RORO Shipping', '2020-08-28 23:25:44', 0, 2, 'JT40P2613UV001701', NULL),
(56, 2, 11, 38, '2020-08-11', '2020-08-25', 'RORO Shipping', '2020-08-29 01:02:22', 0, 2, 'n4sd68f4dfgds5555', NULL),
(57, 7, 11, 35, '2020-07-27', '2020-08-05', 'RORO Shipping', '2020-08-29 01:19:54', 0, 3, 'JT41P2613UV000257', NULL),
(58, 5, 13, 36, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-29 12:21:55', 0, 2, 'JT40P2613UV221751', NULL),
(59, 10, 4, 19, '2020-08-20', '2020-08-05', 'RORO Shipping', '2020-08-29 12:41:50', 0, 3, 'JT40P2613LK000257', NULL),
(60, 6, 11, 39, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-30 09:11:21', 0, 37, 'JT40P2613UV001257', NULL),
(61, 10, 4, 39, '2020-07-29', '2020-08-20', 'RORO Shipping', '2020-08-30 09:13:51', 0, 37, 'JT40P2613UV450257', NULL),
(62, 14, 5, 38, '2020-07-28', '2020-08-20', 'RORO Shipping', '2020-08-30 09:48:38', 0, 37, '78945678912345678', NULL),
(63, 79, 12, 39, '2020-08-27', '2020-08-04', 'RORO Shipping', '2020-08-30 10:03:36', 0, 2, 'JT40P2613UV801754', NULL),
(64, 123, 24, 40, '1990-12-10', '2019-07-20', 'RORO Shipping', '2020-08-30 11:53:09', 0, 39, 'JT223640556342011', NULL),
(65, 123, 12, 40, '2010-08-08', '2019-12-05', 'RORO Shipping', '2020-08-30 12:12:55', 0, 40, 'JT223640556342081', NULL),
(66, 10, 14, 40, '2010-05-04', '2020-05-08', 'RORO Shipping', '2020-08-30 22:04:57', 0, 3, '17345698912345678', NULL),
(67, 53, 16, 40, '2010-05-01', '2018-04-05', 'RORO Shipping', '2020-08-31 00:11:27', 0, 2, '1JT40P2613UX40175', NULL),
(68, 19, 4, 40, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-31 00:13:53', 0, 2, 'zsdgfsdf65f4s65d1', NULL),
(69, 18, 11, 40, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-31 00:18:23', 0, 3, 'JT40P2613UV010257', NULL),
(70, 18, 11, 40, '2020-07-27', '2020-08-12', 'RORO Shipping', '2020-08-31 00:21:04', 0, 3, 'JT40P2613UV010259', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `condition`
--
ALTER TABLE `condition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BDD68843A76ED395` (`user_id`);

--
-- Indexes for table `demande_file`
--
ALTER TABLE `demande_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EB3A44C593CB796C` (`file_id`),
  ADD KEY `IDX_EB3A44C5A00B94E6` (`removal_id`),
  ADD KEY `IDX_EB3A44C5537048AF` (`transfer_id`),
  ADD KEY `IDX_EB3A44C5545317D1` (`vehicle_id`),
  ADD KEY `IDX_EB3A44C5E54D128A` (`remover_id`),
  ADD KEY `IDX_EB3A44C51132D5DB` (`inform_id`),
  ADD KEY `IDX_EB3A44C5A76ED395` (`user_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8C9F3610A76ED395` (`user_id`);

--
-- Indexes for table `fleet`
--
ALTER TABLE `fleet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A05E1E47A76ED395` (`user_id`);

--
-- Indexes for table `home_announce`
--
ALTER TABLE `home_announce`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imform`
--
ALTER TABLE `imform`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8C576E9EA76ED395` (`user_id`);

--
-- Indexes for table `importer`
--
ALTER TABLE `importer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64E883E8A76ED395` (`user_id`);

--
-- Indexes for table `inform`
--
ALTER TABLE `inform`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CBF7144EA76ED395` (`user_id`);

--
-- Indexes for table `logger`
--
ALTER TABLE `logger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_987E13F3A76ED395` (`user_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FA2425B94B061DF9` (`fleet_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BF5476CAA76ED395` (`user_id`),
  ADD KEY `IDX_BF5476CA537048AF` (`transfer_id`),
  ADD KEY `IDX_BF5476CAA00B94E6` (`removal_id`),
  ADD KEY `IDX_BF5476CA61220EA6` (`creator_id`);

--
-- Indexes for table `processing`
--
ALTER TABLE `processing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_886CAB2B537048AF` (`transfer_id`),
  ADD KEY `IDX_886CAB2BA00B94E6` (`removal_id`),
  ADD KEY `IDX_886CAB2BA76ED395` (`user_id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E6D6B297989D9B62` (`slug`);

--
-- Indexes for table `removal`
--
ALTER TABLE `removal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D4DBB74B545317D1` (`vehicle_id`),
  ADD UNIQUE KEY `UNIQ_D4DBB74B2FFFD108` (`entry_num`),
  ADD KEY `IDX_D4DBB74B3414710B` (`agent_id`),
  ADD KEY `IDX_D4DBB74BE54D128A` (`remover_id`),
  ADD KEY `IDX_D4DBB74BF7223C8A` (`pay_bank_id`),
  ADD KEY `IDX_D4DBB74B4B061DF9` (`fleet_id`);

--
-- Indexes for table `remover`
--
ALTER TABLE `remover`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4AB84F2C3414710B` (`agent_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `ship`
--
ALTER TABLE `ship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4034A3C0545317D1` (`vehicle_id`),
  ADD KEY `IDX_4034A3C0783E3463` (`manager_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD KEY `IDX_8D93D649275ED078` (`profil_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1B80E48644F5D008` (`brand_id`),
  ADD KEY `IDX_1B80E486C256317D` (`ship_id`),
  ADD KEY `IDX_1B80E4867FCFE58E` (`importer_id`),
  ADD KEY `IDX_1B80E486A76ED395` (`user_id`),
  ADD KEY `IDX_1B80E486E54D128A` (`remover_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `condition`
--
ALTER TABLE `condition`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `demande_file`
--
ALTER TABLE `demande_file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `fleet`
--
ALTER TABLE `fleet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `home_announce`
--
ALTER TABLE `home_announce`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imform`
--
ALTER TABLE `imform`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `importer`
--
ALTER TABLE `importer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `inform`
--
ALTER TABLE `inform`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logger`
--
ALTER TABLE `logger`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `processing`
--
ALTER TABLE `processing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `removal`
--
ALTER TABLE `removal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `remover`
--
ALTER TABLE `remover`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ship`
--
ALTER TABLE `ship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `FK_268B9C9DBF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `condition`
--
ALTER TABLE `condition`
  ADD CONSTRAINT `FK_BDD68843A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `demande_file`
--
ALTER TABLE `demande_file`
  ADD CONSTRAINT `FK_EB3A44C51132D5DB` FOREIGN KEY (`inform_id`) REFERENCES `inform` (`id`),
  ADD CONSTRAINT `FK_EB3A44C5537048AF` FOREIGN KEY (`transfer_id`) REFERENCES `transfer` (`id`),
  ADD CONSTRAINT `FK_EB3A44C5545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  ADD CONSTRAINT `FK_EB3A44C593CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`),
  ADD CONSTRAINT `FK_EB3A44C5A00B94E6` FOREIGN KEY (`removal_id`) REFERENCES `removal` (`id`),
  ADD CONSTRAINT `FK_EB3A44C5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_EB3A44C5E54D128A` FOREIGN KEY (`remover_id`) REFERENCES `remover` (`id`);

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `FK_8C9F3610A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `fleet`
--
ALTER TABLE `fleet`
  ADD CONSTRAINT `FK_A05E1E47A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `imform`
--
ALTER TABLE `imform`
  ADD CONSTRAINT `FK_8C576E9EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `importer`
--
ALTER TABLE `importer`
  ADD CONSTRAINT `FK_64E883E8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `inform`
--
ALTER TABLE `inform`
  ADD CONSTRAINT `FK_CBF7144EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `logger`
--
ALTER TABLE `logger`
  ADD CONSTRAINT `FK_987E13F3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `FK_FA2425B94B061DF9` FOREIGN KEY (`fleet_id`) REFERENCES `fleet` (`id`),
  ADD CONSTRAINT `FK_FA2425B9BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_BF5476CA537048AF` FOREIGN KEY (`transfer_id`) REFERENCES `transfer` (`id`),
  ADD CONSTRAINT `FK_BF5476CA61220EA6` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BF5476CAA00B94E6` FOREIGN KEY (`removal_id`) REFERENCES `removal` (`id`),
  ADD CONSTRAINT `FK_BF5476CAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `processing`
--
ALTER TABLE `processing`
  ADD CONSTRAINT `FK_886CAB2B537048AF` FOREIGN KEY (`transfer_id`) REFERENCES `transfer` (`id`),
  ADD CONSTRAINT `FK_886CAB2BA00B94E6` FOREIGN KEY (`removal_id`) REFERENCES `removal` (`id`),
  ADD CONSTRAINT `FK_886CAB2BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `removal`
--
ALTER TABLE `removal`
  ADD CONSTRAINT `FK_D4DBB74B3414710B` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`),
  ADD CONSTRAINT `FK_D4DBB74B4B061DF9` FOREIGN KEY (`fleet_id`) REFERENCES `fleet` (`id`),
  ADD CONSTRAINT `FK_D4DBB74B545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  ADD CONSTRAINT `FK_D4DBB74BE54D128A` FOREIGN KEY (`remover_id`) REFERENCES `remover` (`id`),
  ADD CONSTRAINT `FK_D4DBB74BF7223C8A` FOREIGN KEY (`pay_bank_id`) REFERENCES `bank` (`id`);

--
-- Constraints for table `remover`
--
ALTER TABLE `remover`
  ADD CONSTRAINT `FK_4AB84F2C3414710B` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `FK_4034A3C0545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  ADD CONSTRAINT `FK_4034A3C0783E3463` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`id`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `FK_1B80E48644F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `FK_1B80E4867FCFE58E` FOREIGN KEY (`importer_id`) REFERENCES `importer` (`id`),
  ADD CONSTRAINT `FK_1B80E486A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_1B80E486C256317D` FOREIGN KEY (`ship_id`) REFERENCES `ship` (`id`),
  ADD CONSTRAINT `FK_1B80E486E54D128A` FOREIGN KEY (`remover_id`) REFERENCES `remover` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
