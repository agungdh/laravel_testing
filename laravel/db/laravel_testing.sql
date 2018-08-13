-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 13, 2018 at 05:17 PM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `na_mapel`
--

CREATE TABLE `na_mapel` (
  `id` int(11) NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `na_mapel`
--

INSERT INTO `na_mapel` (`id`, `mata_pelajaran`) VALUES
(1, 'MTK'),
(2, 'IPA'),
(3, 'IPS');

-- --------------------------------------------------------

--
-- Table structure for table `na_nilai`
--

CREATE TABLE `na_nilai` (
  `id` int(11) NOT NULL,
  `nis` varchar(32) NOT NULL,
  `tipe_nilai` enum('uh','uas','tugas') NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `nilai` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `na_nilai`
--

INSERT INTO `na_nilai` (`id`, `nis`, `tipe_nilai`, `mapel_id`, `nilai`) VALUES
(1, '15753003', 'uh', 2, '80.00'),
(3, '15753003', 'uh', 3, '81.00'),
(4, '15753003', 'uh', 1, '82.00'),
(5, '15753003', 'uas', 2, '90.00'),
(6, '15753003', 'uas', 3, '91.00'),
(7, '15753003', 'uas', 1, '92.00'),
(8, '15753003', 'tugas', 2, '70.00'),
(9, '15753003', 'tugas', 3, '71.00'),
(10, '15753003', 'tugas', 1, '72.00');

-- --------------------------------------------------------

--
-- Table structure for table `phpmailer_server`
--

CREATE TABLE `phpmailer_server` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `server` varchar(191) NOT NULL,
  `encryption` enum('ssl','tls') NOT NULL,
  `port` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phpmailer_server`
--

INSERT INTO `phpmailer_server` (`id`, `name`, `server`, `encryption`, `port`) VALUES
('a287b2e6-b9a1-4f6d-a3fc-005f18815b31', 'Outlook', 'smtp-mail.outlook.com', 'tls', '587'),
('f799871b-8a56-48ca-8e1a-636dec2fa576', 'Gmail', 'smtp.gmail.com', 'tls', '587');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `na_mapel`
--
ALTER TABLE `na_mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `na_nilai`
--
ALTER TABLE `na_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indexes for table `phpmailer_server`
--
ALTER TABLE `phpmailer_server`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `na_mapel`
--
ALTER TABLE `na_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `na_nilai`
--
ALTER TABLE `na_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `na_nilai`
--
ALTER TABLE `na_nilai`
  ADD CONSTRAINT `na_nilai_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `na_mapel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
