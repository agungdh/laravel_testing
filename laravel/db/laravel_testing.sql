-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2018 at 01:27 PM
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
-- Indexes for table `phpmailer_server`
--
ALTER TABLE `phpmailer_server`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
