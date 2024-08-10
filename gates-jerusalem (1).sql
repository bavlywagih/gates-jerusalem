-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 01:43 PM
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
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `gates`
--

INSERT INTO `gates` (`id`, `name`, `text`) VALUES
(1, 'بَابِ السَّمَكِ', '<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span dir=\"LTR\">&larr; </span><span style=\"background-color: #fbeeb8;\"><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">اللغة الإنجليزية</span><span dir=\"LTR\">:</span></span><span dir=\"LTR\">&nbsp;</span><span dir=\"LTR\">Fish Gate </span></p>\r\n<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span dir=\"LTR\">-&nbsp;</span><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\"><span style=\"background-color: #fbeeb8;\">اللغة العبرية:</span>&nbsp;</span><span lang=\"HE\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin; mso-bidi-language: HE;\">דָּג שַׁעַר </span></p>\r\n<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span lang=\"HE\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin; mso-bidi-language: HE;\">-&nbsp;</span><span style=\"background-color: #fbeeb8;\"><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">اللغة اليونانية</span><span dir=\"LTR\">:</span></span><span dir=\"LTR\">&pi;ύ&lambda;&eta;&sigmaf; &tau;&eta;&sigmaf; &iota;&chi;&theta;&upsilon;ϊ&kappa;ή&sigmaf;&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span dir=\"LTR\">-</span><span style=\"background-color: #fbeeb8;\"><span dir=\"LTR\">&nbsp;</span><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">اللغة اللاتينية:</span></span><span dir=\"LTR\">&nbsp;</span><span dir=\"LTR\">portae Piscium.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: right; direction: rtl; unicode-bidi: embed;\">&nbsp;</p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: right; direction: rtl; unicode-bidi: embed;\"><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">باب في أورشليم، وَيُرَجَّح أن صيادي السمك كانوا يدخلون منه ببضاعتهم لبيعها لأهل المدينة، ولعله كان بالقرب من بِركة السمك <a href=\"page.php?id=KvDv1ozrRuKQ6xXGgLMWSE5xbkw%3D\">(2 أخبار 33: 14)</a>. وربما كان في السور الذي كان على الجانب الشمالي للمدينة أورشليم</span><span dir=\"LTR\">.</span></p>'),
(2, 'الباب الثاني عشر', '<p>يببيبييب</p>'),
(4, 'ؤءؤء', '<p>ؤءءؤ</p>'),
(5, 'dssdds', '<p>dsdssdsd</p>'),
(6, 'يبيبيب', '<p>يبيبيب</p>'),
(7, 'بييبيب', '<p>يبيبيبيب</p>'),
(8, 'image', '<p>dsdssdsd</p>'),
(9, 'admin', '<p>dssdssdsd</p>'),
(10, 'admin', '<p>sdsdsdds</p>'),
(11, '6', '<p><a href=\"page.php?id=PGeTTpyIO%2BF0n6hrMSxijXVBPT0%3D\">3</a></p>'),
(12, 'الباب الحادي عشر', '<p style=\"text-align: center;\"><span style=\"background-color: #fbeeb8;\"><strong>الباب الحادي عشر</strong></span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `verse_reference` varchar(255) NOT NULL,
  `verse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `verse_reference`, `verse`) VALUES
(475, '(2 أخ 33: 14).', '\"وَبَعْدَ ذلِكَ بَنَى سُورًا خَارِجَ مَدِينَةِ دَاوُدَ غَرْبًا إِلَى جِيحُونَ فِي الْوَادِي، وَإِلَى مَدْخَلِ بَابِ السَّمَكِ، وَحَوَّطَ الأَكَمَةَ بِسُورٍ وَعَلاَّهُ جِدًّا. وَوَضَعَ رُؤَسَاءَ جُيُوشٍ فِي جَمِيعِ الْمُدُنِ الْحَصِينَةِ فِي يَهُوذَا.\"'),
(476, '(رسالة بولس الرسول إلى العبرانيين 13: 17، 18)', '5555'),
(477, 'hjjhhj', 'hjjhhj'),
(478, 'gh', 'hg');

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
(2, 'مكمك', '77889900', 'بافلي', 0),
(3, 'user-psalm', '172008', 'bavly wagih samir', 0),
(5, 'user-eucharist', '123456789', 'banaa', 0),
(6, 'user-divine', '223222', 'sasas', 0),
(7, 'user-ascension', '172008', 'بافلي وجية سمير', 0),
(8, 'user-vespers', '123456789', 'bavly wagih samir', 0),
(9, 'FkAzEOFCC1v5w/vq0HeFB0pBPT0=', '(سفر التكوين 37: 14)', '\"اذْهَبِ انْظُرْ سَلاَمَةَ إِخْوَتِكَ، وَسَلاَمَةَ الْغَنَمِ وَرُدَّ لِي خَبَرًا\"', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gates`
--
ALTER TABLE `gates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
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
-- AUTO_INCREMENT for table `gates`
--
ALTER TABLE `gates`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=479;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
