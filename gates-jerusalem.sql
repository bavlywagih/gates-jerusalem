-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 12:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gates-jerusalem`
--

-- --------------------------------------------------------

--
-- Table structure for table `gates`
--

CREATE TABLE `gates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `gates`
--

INSERT INTO `gates` (`id`, `name`, `text`) VALUES
(90, 'الباب الاول', '<p>الباب الاول</p>'),
(91, 'الباب الثاني', '<p>الباب الثاني</p>'),
(92, 'الباب الثالث', ''),
(93, 'الباب الرابع', '<p>يببي</p>\r\n<p>&nbsp;</p>'),
(94, 'الباب الخامس', '<p>الباب الخامس</p>'),
(95, 'الباب السادس', '<p>الباب السادس</p>\r\n<p>&nbsp;</p>'),
(96, 'الباب السابع', '<p style=\"text-align: right;\">الباب السابع</p>\r\n<p style=\"text-align: right;\">&nbsp;</p>'),
(97, 'الباب الثامن', '<p>الباب الثامن</p>'),
(98, 'الباب التاسع ', '<p>الباب التاسع&nbsp;</p>'),
(99, 'الباب العاشر', '<p>الباب العاشر</p>'),
(100, 'البابا الحادي عشر', '<h1 style=\"text-align: center;\"><span style=\"background-color: #f1c40f;\">البابا الحادي عشر</span></h1>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `group-id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `group-id`) VALUES
(1, 'bavly', '172008', 'bavly wagih samir', 1),
(2, 'مكمك', '77889900', 'بافلي', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gates`
--
ALTER TABLE `gates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `text_4` (`text`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `text` (`text`),
  ADD KEY `text_3` (`text`);
ALTER TABLE `gates` ADD FULLTEXT KEY `text_2` (`text`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gates`
--
ALTER TABLE `gates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
