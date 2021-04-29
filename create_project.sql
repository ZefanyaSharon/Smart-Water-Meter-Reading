-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2020 at 05:24 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `create_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `node_listrik`
--

CREATE TABLE `node_listrik` (
  `id` int(11) NOT NULL,
  `Tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Arus` float DEFAULT NULL,
  `Daya` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `node_listrik`
--

INSERT INTO `node_listrik` (`id`, `Tanggal`, `Arus`, `Daya`) VALUES
(10, '2020-06-05 05:59:30', 10, 220),
(11, '2020-06-05 05:59:39', 10, 2200),
(12, '2020-06-05 05:59:42', 10, 2200),
(13, '2020-06-05 05:59:42', 10, 2200),
(14, '2020-06-05 05:59:43', 10, 2200),
(15, '2020-06-05 05:59:43', 10, 2200),
(16, '2020-06-05 05:59:43', 10, 2200),
(17, '2020-06-05 05:59:43', 10, 2200),
(18, '2020-06-05 05:59:43', 10, 2200),
(19, '2020-06-05 05:59:43', 10, 2200),
(20, '2020-06-05 05:59:43', 10, 2200),
(21, '2020-06-05 05:59:44', 10, 2200),
(22, '2020-06-05 05:59:44', 10, 2200),
(23, '2020-06-05 05:59:44', 10, 2200),
(24, '2020-06-05 05:59:44', 10, 2200),
(25, '2020-06-05 05:59:44', 10, 2200),
(26, '2020-06-05 05:59:44', 10, 2200),
(27, '2020-06-05 05:59:45', 10, 2200),
(28, '2020-06-05 05:59:54', 11, 2420),
(29, '2020-06-05 05:59:56', 11, 2420),
(30, '2020-06-05 05:59:56', 11, 2420),
(31, '2020-06-05 05:59:56', 11, 2420),
(32, '2020-06-05 05:59:56', 11, 2420),
(33, '2020-06-05 05:59:56', 11, 2420),
(34, '2020-06-05 05:59:56', 11, 2420),
(35, '2020-06-05 05:59:57', 11, 2420),
(36, '2020-06-05 05:59:57', 11, 2420),
(37, '2020-06-05 05:59:57', 11, 2420),
(38, '2020-06-05 05:59:57', 11, 2420),
(39, '2020-06-05 05:59:57', 11, 2420),
(40, '2020-06-05 05:59:57', 11, 2420),
(41, '2020-06-05 06:00:08', 10, 2200),
(42, '2020-06-05 06:00:08', 10, 2200),
(43, '2020-06-05 06:00:08', 10, 2200),
(44, '2020-06-05 06:00:09', 10, 2200),
(45, '2020-06-05 06:00:09', 10, 2200),
(46, '2020-06-05 06:00:09', 10, 2200),
(47, '2020-06-05 06:00:09', 10, 2200),
(48, '2020-06-05 06:00:20', 11, 2420),
(49, '2020-06-05 06:00:20', 11, 2420),
(50, '2020-06-05 06:00:20', 11, 2420),
(51, '2020-06-05 06:00:20', 11, 2420),
(52, '2020-06-05 06:00:20', 11, 2420),
(53, '2020-06-05 06:00:20', 11, 2420),
(54, '2020-06-05 06:00:27', 11, 2420),
(55, '2020-06-05 06:00:42', 11, 2420),
(56, '2020-06-05 06:00:43', 11, 2420),
(57, '2020-06-05 06:00:43', 11, 2420),
(58, '2020-06-05 06:00:43', 11, 2420),
(59, '2020-06-05 06:00:43', 11, 2420),
(60, '2020-06-05 06:00:43', 11, 2420),
(61, '2020-06-05 06:00:43', 11, 2420),
(62, '2020-06-05 06:00:44', 11, 2420),
(63, '2020-06-05 06:00:44', 11, 2420),
(64, '2020-06-05 06:00:44', 11, 2420),
(65, '2020-06-05 06:00:44', 11, 2420);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `nama_project` varchar(256) DEFAULT NULL,
  `deskripsi` varchar(256) DEFAULT NULL,
  `link_svn` varchar(256) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `database` varchar(19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `nama_project`, `deskripsi`, `link_svn`, `id_user`, `database`) VALUES
(5, 'sdfdasfd', 'fds', NULL, NULL, 'MariaDB'),
(6, 'horas', 'fds', NULL, NULL, 'MariaDB'),
(7, 'aaaaaaaaa', 'f', NULL, NULL, 'MariaDB'),
(8, 'wer', 'rwe', NULL, NULL, 'PostgreSQL'),
(9, 'halo', 'asd', NULL, NULL, 'PostgreSQL'),
(10, 'het', 'sfd', NULL, NULL, 'PostgreSQL'),
(11, 'dadad', 'dadsasd', 'http://localhost:8080/svn/asasdad', 7647656, 'MariaDB'),
(12, 'dasboard', 'das', NULL, NULL, 'MariaDB'),
(13, 'bisa', 'wrfs', NULL, NULL, 'PostgreSQL'),
(14, 'tyty', 'wrfs', 'http://Notebook/svn/tyty', NULL, 'PostgreSQL'),
(15, 'tytp', 'wrfs', 'http://Notebook/svn/tytp', NULL, 'MariaDB'),
(16, 'pilat', 'ni hoda', 'http://DESKTOP-F98HH5I/svn/pilat', NULL, 'MariaDB'),
(17, 'aosdjk', 'asjdojsods', 'http://DESKTOP-F98HH5I/svn/aosdjk', NULL, 'MariaDB'),
(18, 'p', 'p', 'http://DESKTOP-F98HH5I/svn/p', NULL, 'PostgreSQL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(78, 'barurtad', '$2y$10$2NAdsk9iWShCVOUTpbpnne3aXTbeYW.auXTQiD17HxrQz1KAeq.6e', 'dqqwd@gmail.com'),
(156, 'yZ2LfhR8Ac', '$2y$10$v8DvL6ObnDc6a85D7VUNaeWS2tx6.wL6YrhHLb/EWEqPgRkBKlIyi', 'ND4krD24Jn@gmail.com'),
(556, 'baru', '$2y$10$LLBVR9T0f1ElLlio1S2mL.5RE3QSwMvWyoYN2qRdqGuaPGmDgjtmO', 'baru@gmail.com'),
(887, 'barurt', '$2y$10$57PUv/W8BE75EJ4q1OaQCOOCdbkJcN.tbW.8VmBv/Cc4r36BDYdZu', 'ad@gmail.com'),
(897, 'jasminasdasd', '$2y$10$nDODVcVocrMvEhZ4mO/ND.s7IgivpC2DtmOVf1QLjBjumlcqGt7dq', 'asdasd@sfsdf.l'),
(1634, '07JpxPPf9g', '$2y$10$6Qoj/2eGqAE5k5H2bklehuoyCaBZHWkDw4C/WnySzvti1Ykn0WB/y', 'Yubvpg5bQi@gmail.com'),
(2906, 'SaCq7MXVCi', '$2y$10$Pr3sknlRr8O2NLbPZLPLEeHLJCQTYSxjD4RYSkdOiGVVk9XMvuZke', 'QMJYmJ55Kv@gmail.com'),
(3141, 'jowUGdcbao', '$2y$10$lnpMVMu9s9GLj.h9oGRZHuPMQ2RED8DtyUUTBHdunKPyfgl0Gl32O', 'HYBboEiMmq@gmail.com'),
(4730, 'AHLkWi7biy', '$2y$10$KC9wim3XqCJ4IOqXpkQPT.py3Dnd1RoouKO6G.12jQtKJS41Rbdmq', 'hGaybP2ZQZ@gmail.com'),
(5729, 'qUmd3gVb7W', '$2y$10$AHYpjZuQBhxXDUijtNP8Qe8QhMxKLVWlgZmHvfvfArg0wurdWq3VG', 'ExkLZvpTVZ@gmail.com'),
(7987, 'asdalsd', '$2y$10$0N.L4tOLnHxVALaIM62bl.tyaS6m6zO.AFveynlc9Rr6wE9Ye6njm', 'as@blabla.com'),
(9053, '6Z3iXa1Tg8', '$2y$10$XqwgvLSOVCWHUo7S9LSc2e5WKDbJj.Eriz1c7O7U/.a3yG2fCv0o6', 'jXqh54XjJz@gmail.com'),
(9279, 'wgRtGZFCmI', '$2y$10$soux7rFKUaN3uoW0K7T8VuuZG77v5QQCERd1e0VNoTadWnqpaiAbm', 'ftRCukWSXP@gmail.com'),
(67476, 'boas', '$2y$10$PjIQyVrGFchgkwzYegMgjOixkcA0A2kkOl3FWUE5Ze9Jh/xy28vc.', 'boas@gmail.com'),
(547654, 'jdjjd', '$2y$10$yyWXXWlOr04.06pDiBkJQO3C4HT6XyrNV5WOSYY5agrnHW7K4RyaW', 'jajajj@gmail.com'),
(7647654, 'boasdemeson', '$2y$10$A8TdnRF4Doyu5FX8ReGMYOoxKRLkBjz4aJKU4DLOUyJ2Kdckrke3e', 'boasdemeson@gmail.com'),
(7647655, 'adsd', '$2y$10$k08aoFLQcRZ0g/6RpzQWIuzRL0..tmuZDosK0sWiEaj8Wxqlf.Bn.', 'boazdemesosn@gmail.com'),
(7647656, 'chandro', '$2y$10$hQouuU8QlpxbrkXS75qG/OVCY.Ds/tBvY8LJVn9UhknUSW6dtYH8e', 'chandropardede24@gmail.com'),
(7647657, 'chandri', '$2y$10$Fu6WSXhsBL88XP.P6k2FOu331X.44dOztnxwqt2H1xBnweaNwkFxO', 'chandropardede56@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `node_listrik`
--
ALTER TABLE `node_listrik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `node_listrik`
--
ALTER TABLE `node_listrik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7647658;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
