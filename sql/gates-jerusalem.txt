-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2024 at 04:16 PM
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
(1, 'بَابِ السَّمَكِ', '<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span dir=\"LTR\">&larr; </span><span style=\"background-color: #fbeeb8;\"><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">اللغة الإنجليزية</span><span dir=\"LTR\">:</span></span><span dir=\"LTR\">&nbsp;</span><span dir=\"LTR\">Fish Gate </span></p>\r\n<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span dir=\"LTR\">-&nbsp;</span><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\"><span style=\"background-color: #fbeeb8;\">اللغة العبرية:</span>&nbsp;</span><span lang=\"HE\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin; mso-bidi-language: HE;\">דָּג שַׁעַר </span></p>\r\n<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span lang=\"HE\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin; mso-bidi-language: HE;\">-&nbsp;</span><span style=\"background-color: #fbeeb8;\"><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">اللغة اليونانية</span><span dir=\"LTR\">:</span></span><span dir=\"LTR\">&pi;ύ&lambda;&eta;&sigmaf; &tau;&eta;&sigmaf; &iota;&chi;&theta;&upsilon;ϊ&kappa;ή&sigmaf;&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"rtl\" style=\"text-align: right; unicode-bidi: embed;\"><span dir=\"LTR\">-</span><span style=\"background-color: #fbeeb8;\"><span dir=\"LTR\">&nbsp;</span><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">اللغة اللاتينية:</span></span><span dir=\"LTR\">&nbsp;</span><span dir=\"LTR\">portae Piscium.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: right; direction: rtl; unicode-bidi: embed;\">&nbsp;</p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: right; direction: rtl; unicode-bidi: embed;\"><span lang=\"AR-SA\" style=\"font-family: \'Arial\',sans-serif; mso-ascii-font-family: Calibri; mso-ascii-theme-font: minor-latin; mso-hansi-font-family: Calibri; mso-hansi-theme-font: minor-latin;\">باب في أورشليم، وَيُرَجَّح أن صيادي السمك كانوا يدخلون منه ببضاعتهم لبيعها لأهل المدينة، ولعله كان بالقرب من بِركة السمك <a title=\"(سفر أخبار الأيام الثاني 33: 14)\" href=\"page.php?id=515\" target=\"_blank\" rel=\"noopener\">(2 أخبار 33: 14)</a>. وربما كان في السور الذي كان على الجانب الشمالي للمدينة أورشليم</span><span dir=\"LTR\">.</span></p>\r\n<hr>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: right; direction: rtl; unicode-bidi: embed;\">وهو كان بابًا في<a title=\" السور الشمالي لأورشليم\" href=\"page.php?id=525\"> السور الشمالي لأورشليم</a>. والمفروض أنه سمي كذلك بالنسبة لقربه من سوق السمك (انظر نحميا 13: 16). وقد بَنَى منسى ملك يهوذا \"سورًا خارج مدينة داود غربًا إلى جيحون في الوادي وإلى مدخل باب السمك، وحوَّط الأكمة بسور وعلاَّه جدًَّا\" (2أخ 33: 14). ويذكر صفنيا، الذي تنبأ في أيام يوشيا ملك يهوذا، أنه \"يكون في ذلك اليوم يقول الرب صوت صراخ من باب السمك وولولة من القسم الثاني وكسر عظيم من الآكام\" (صف 1: 10). وبعد العودة من السبي، قام بنو هسناءة بإعادة بناء باب السمك إلى الغرب من برج حننئيل (نح 3: 3؛ 12: 39).</p>'),
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
  `page_title` varchar(255) NOT NULL,
  `verse_reference` varchar(255) DEFAULT NULL,
  `verse` mediumtext NOT NULL,
  `id_select` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_title`, `verse_reference`, `verse`, `id_select`) VALUES
(525, 'أسوار أورشليم | سور', NULL, '<p dir=\"rtl\" style=\"text-align: center;\" align=\"justify\"><span style=\"font-size: x-large;\">اسم أحد&nbsp;<span lang=\"ar-eg\">أبواب أورشليم</span>، لعله كان الباب الذي يؤدي من القصر الملكي إلى أفنية&nbsp;الهيكل. وقد أوقف&nbsp;يهوياداع الكاهن&nbsp;عنده ثلث قوة السعاة والجلادين، التي أعدها لحراسة الملك عند القضاء على الملكة الشريرة&nbsp;عَثليْا&nbsp;(2 مل 11: 6)&nbsp;ويسمى هذا الباب أيضا \"باب الأساس\"&nbsp;<a href=\"page.php?id=528\">(2 أخ 23: 5)</a>.</span></p>\r\n<p dir=\"rtl\" style=\"text-align: center;\" align=\"justify\">&nbsp;ويرّجح أن الأسوار اليبوسية كانت تحيط بالتل الجنوبي الشرقي في&nbsp;أورشليم&nbsp;الذي يقع إلى جنوبي منطقة الهيكل وبعد أن أخذ&nbsp;الملك داود&nbsp;المدينة حصّن هذا السور (2صم 5: 9؛ 1 أخبار 11: 8) بما في ذلك \"ملو\" التي كانت على ما يرّجح قلعة للطرف الشمالي للتلّ. وبنى&nbsp;سليمان&nbsp;سورًا حول&nbsp;أورشليم&nbsp;بما في ذلك الهيكل والقصر المشيدان على التل الأوسط الشرقي&nbsp;(1مل 3: 1)&nbsp;ولكن لا يعرف مكان سور&nbsp;سليمان&nbsp;على وجه التحقيق. وأما باب الزاوية المذكور في عصر&nbsp;<span style=\"font-size: x-large;\"><strong><span style=\"font-family: Times New Roman;\">أمصيا</span></strong></span>&nbsp;(2مل 14: 13)&nbsp;فيحتمل أنه كان بالقرب من مكان باب يافا أو باب الخليل، ويدل هذا على أن المدينة كانت تشمل التلّ الجنوبي الغربي. وكان السور الجنوبي الغربي للمدينة في عصر&nbsp;ارميا&nbsp;يصل إلى طرف وادي ابن هنّوم الذي هو الآن وادي الربابة&nbsp;(إر 19: 2)&nbsp;وكان السور الذي إلى الشمال في ذلك الحين، أي في القرن السابع قبل الميلاد، وكان يقع إلى شمال غربي الهيكل&nbsp;(2مل 22: 14).</p>\r\n<p dir=\"rtl\" style=\"text-align: center;\" align=\"justify\">ويصف&nbsp;نحميا&nbsp;في&nbsp;(نحم 2: 12-15)&nbsp;كيف أنه شاهد الأسوار والأبواب التي هدمها البابليون ويخبرنا في&nbsp;نحميا أصحاح 3&nbsp;كيف أصلح الشعب هذه الأسوار وهذه الأبواب ورمموها. وقد هدم&nbsp;انطيوخس أبيفانيس&nbsp;أسوار&nbsp;أورشليم&nbsp;في القرن الثاني قبل الميلاد (1 مكا 4: 60؛ 12: 36؛ 13: 10). وقد حصن&nbsp;هيرودس الكبير&nbsp;سور&nbsp;أورشليم&nbsp;وبنى فيها أبراجًا وبعض ما عمله هو أساس القلعة الموجودة في الوقت الحاضر في الزاوية الجنوبية الشرقية للمدينة وعند المكان الذي كان مبكى اليهود فيما قبل.</p>\r\n<p dir=\"rtl\" style=\"text-align: center;\" align=\"justify\">أما مكان السور على وجه التحقيق كما كان في أيام&nbsp;يسوع المسيح&nbsp;فغير يقيني. ويظن كثيرون من العلماء أن السور كان يتجه بحيث يجعل موقع كنيسة القيامة خارج المدينة وهذه هي وجهة النظر التقليدية. أما غيرهم فيظنون أن الأسوار كانت تشمل داخلها موقع هذه الكنيسة، وفي هذه الحال لا يكون هذا هو مكان الصلب الذي كان خارج المدينة&nbsp;(عب 13: 12). وقد بنى&nbsp;هيرودس اغريباس الأول&nbsp;السور الشمالي الثالث وقد اكتشفت بعض بقاياه شمالي السور الحالي. وفي سنة 132 ميلادية بنى&nbsp;الإمبراطور الروماني هدريان سورًا كان في الغالب مبنيًا في مكان الأسوار الحالية وقد أقامها السلطان التركي سليمان Suleiman the Magnificent في القرن السادس عشر بعد الميلاد. ويوجد في الأسوار الحالية 34 برجًا وثمانية أبواب.</p>', 1),
(527, '(سفر المزيامير 119: 1)', '(رسالة بولس الرسيول إلى العبرانيين 13: 17، 18)', '\"وَكَانَ لَهَا سُورٌ عَظِيمٌ وَعَال، وَكَانَ لَهَا اثْنَا عَشَرَ بَابًا، وَعَلَى الأَبْوَابِ اثْنَا عَشَرَ مَلاَكًا، وَأَسْمَاءٌ مَكْتُوبَةٌ هِيَ أَسْمَاءُ أَسْبَاطِ بَنِي إِسْرَائِيلَ الاثْنَيْ عَشَرَ.\"', 0),
(528, '(سفر أخبار الأيام الثاني 23: 5)', '(2 أخ 23: 5)', '\"وَالثُّلْثُ فِي بَيْتِ الْمَلِكِ، وَالثُّلْثُ فِي بَابِ الأَسَاسِ، وَجَمِيعُ الشَّعْبِ فِي دِيَارِ بَيْتِ الرَّبِّ.\"', 0);

-- --------------------------------------------------------

--
-- Table structure for table `page_images`
--

CREATE TABLE `page_images` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `page_images`
--

INSERT INTO `page_images` (`id`, `page_id`, `image_path`) VALUES
(16, 525, 'media/uploads/66bb69f0e61eb.jpg');

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
(8, 'user-vespers', '123456789', 'bavly wagih samir', 1);

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
-- Indexes for table `page_images`
--
ALTER TABLE `page_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

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
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT for table `page_images`
--
ALTER TABLE `page_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `page_images`
--
ALTER TABLE `page_images`
  ADD CONSTRAINT `page_images_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
