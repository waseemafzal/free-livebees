-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2021 at 07:34 AM
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
-- Database: `cyphersol_realstate`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `resource_type` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `readed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `body`, `sender_id`, `receiver_id`, `resource_id`, `resource_type`, `created_date`, `readed`) VALUES
(122, 'afif bhatti signalé un nid', 211, 207, 628, 'nest', '2021-02-26 12:37:42', 0),
(123, 'hi', 211, 207, 1, 'abc', '2021-02-26 12:47:47', 0),
(124, 'asdjajsd', 207, 0, 1, 'message', '2021-02-26 13:01:54', 0),
(125, 'sdfgsdgf', 207, 0, 1, 'message', '2021-02-26 13:02:24', 0),
(126, 'ok', 207, 211, 1, 'message', '2021-02-26 13:09:07', 0),
(127, 'dfdf', 207, 0, 1, 'message', '2021-02-26 13:11:20', 0),
(128, 'ere', 207, 0, 1, 'message', '2021-02-26 13:12:17', 0),
(129, 'hacene hebbar signalé un nid', 191, 179, 629, 'nest', '2021-03-02 09:22:13', 1),
(130, 'Test  Pro signalé un nid', 195, 179, 630, 'nest', '2021-04-02 12:49:27', 0),
(131, 'Tests en firect', 179, 195, 1, 'message', '2021-04-02 12:55:34', 0),
(132, 'Hac Test Hebbar signalé un nid', 215, 179, 631, 'nest', '2021-04-12 10:03:43', 0),
(133, 'Hac Test Hebbar signalé un nid', 215, 183, 632, 'nest', '2021-04-12 10:08:27', 0),
(134, 'HH heb signalé un nid', 216, 215, 635, 'nest', '2021-04-12 10:25:50', 0),
(135, 'HH heb signalé un nid', 216, 216, 636, 'nest', '2021-04-12 10:29:04', 0),
(136, 'waseem  afzal signalé un nid', 126, 196, 639, 'nest', '2021-04-13 04:54:23', 0),
(137, 'waseem  afzal signalé un nid', 126, 196, 639, 'nest', '2021-04-13 04:59:50', 0),
(138, 'waseem  afzal signalé un nid', 126, 196, 639, 'nest', '2021-04-13 05:01:52', 0),
(139, 'waseem  afzal signalé un nid', 126, 196, 639, 'nest', '2021-04-13 05:10:21', 0),
(140, 'waseem  afzal signalé un nid', 126, 196, 639, 'nest', '2021-04-13 05:15:15', 0),
(141, 'i am fine', 126, 196, 1, 'message', '2021-04-13 11:56:16', 0),
(142, 'waseem  afzal signalé un nid', 126, 181, 641, 'nest', '2021-04-13 13:18:28', 0),
(143, 'hacene  hebbar  signalé un nid', 191, 183, 642, 'nest', '2021-04-14 02:01:21', 0),
(144, 'asdas', 0, 0, 1, 'message', '2021-04-27 11:38:37', 0),
(145, 'waseem  afzal signalé un nid', 126, 218, 644, 'nest', '2021-05-24 03:59:34', 0),
(146, 'waseem  afzal signalé un nid', 126, 218, 644, 'nest', '2021-05-24 04:07:45', 0),
(147, 'waseem  afzal signalé un nid', 126, 218, 644, 'nest', '2021-05-24 04:09:50', 0),
(148, 'waseem  afzal signalé un nid', 126, 218, 644, 'nest', '2021-05-24 04:10:25', 0),
(149, 'waseem  afzal signalé un nid', 126, 218, 644, 'nest', '2021-05-24 04:16:21', 0),
(150, 'how are you?\r\n', 67, 66, 1, 'message', '2021-06-01 08:28:27', 0),
(151, 'i am fine', 66, 67, 1, 'message', '2021-06-01 08:30:32', 0),
(152, 'whatsa up?\r\n', 67, 66, 1, 'message', '2021-06-01 08:36:27', 0),
(153, 'nothing special', 66, 67, 1, 'message', '2021-06-01 08:36:38', 0),
(154, 'hello haris bhai', 67, 66, 1, 'message', '2021-06-02 06:35:19', 0),
(155, 'i am fine what about you?', 66, 67, 1, 'message', '2021-06-02 09:21:36', 0),
(156, 'i am fine what about you?', 66, 67, 1, 'message', '2021-06-02 09:21:53', 0),
(157, 'i am fine what about you?', 66, 67, 1, 'message', '2021-06-02 09:34:23', 0),
(158, 'thats great...\r\n', 67, 66, 1, 'message', '2021-06-02 09:34:37', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
