-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2021 at 08:39 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geonest`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) UNSIGNED NOT NULL,
  `owner_id` int(11) UNSIGNED NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `owner_id`, `modified`, `receiver_id`) VALUES
(34, 211, '2021-02-18 13:04:52', 207),
(35, 191, '2021-02-22 11:32:54', 179),
(36, 198, '2021-02-22 11:37:35', 191),
(37, 212, '2021-02-24 11:56:44', 191),
(38, 186, '2021-02-24 12:07:24', 212),
(39, 207, '2021-02-24 12:23:25', 181),
(40, 213, '2021-02-25 11:51:12', 181),
(41, 213, '2021-02-25 11:53:20', 194),
(42, 186, '2021-02-26 12:04:47', 207),
(43, 195, '2021-04-02 14:49:52', 179),
(44, 215, '2021-04-12 12:04:03', 179),
(45, 215, '2021-04-12 12:08:44', 183),
(46, 216, '2021-04-12 12:25:58', 215),
(47, 126, '2021-04-13 06:54:53', 196),
(48, 126, '2021-04-13 15:18:41', 181),
(49, 191, '2021-04-14 04:01:31', 183);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
