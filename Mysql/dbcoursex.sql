-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 04 Oca 2023, 10:19:14
-- Sunucu sürümü: 8.0.17
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dbcoursex`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblcarts`
--

CREATE TABLE `tblcarts` (
  `tblCartId` int(11) NOT NULL,
  `tblStudentId` int(11) NOT NULL,
  `tblCourseId` int(11) NOT NULL,
  `tblCartPrice` float(9,2) NOT NULL,
  `tblCartCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblcoursecategories`
--

CREATE TABLE `tblcoursecategories` (
  `tblCourseCategoryId` int(11) NOT NULL,
  `tblCourseCategoryTitle` varchar(100) NOT NULL,
  `tblCourseCategorySeoUrl` varchar(150) NOT NULL,
  `tblCourseCategoryCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tblCourseCategoryStatus` enum('Active','InActive') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblcoursecategories`
--

INSERT INTO `tblcoursecategories` (`tblCourseCategoryId`, `tblCourseCategoryTitle`, `tblCourseCategorySeoUrl`, `tblCourseCategoryCreatedDate`, `tblCourseCategoryStatus`) VALUES
(1, 'Mühendislik', 'muhendislik', '2023-01-03 00:10:56', 'Active'),
(4, 'Siber Güvenlik', 'siber-guvenlik', '2023-01-03 00:48:51', 'Active');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblcoursedetails`
--

CREATE TABLE `tblcoursedetails` (
  `CourseDetailId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `CourseArrangement` int(11) NOT NULL,
  `CourseTitle` varchar(200) NOT NULL,
  `FileUrl` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblcoursedetails`
--

INSERT INTO `tblcoursedetails` (`CourseDetailId`, `CourseId`, `CourseArrangement`, `CourseTitle`, `FileUrl`, `CreatedDate`) VALUES
(6, 4, 1, 'Css Nedir ?', 'cdn/courses/css-nedir-videos-63b483163b05a4.mp4', '2023-01-03 22:33:42'),
(7, 4, 2, 'Css Nedir 2', 'cdn/courses/css-nedir-2-videos-63b48752bd38f4.mp4', '2023-01-03 22:51:46'),
(8, 5, 1, 'PHP Nedir?', 'cdn/courses/php-nedir-videos-63b54321c88c35.mp4', '2023-01-04 12:13:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblcourses`
--

CREATE TABLE `tblcourses` (
  `tblCourseId` int(11) NOT NULL,
  `tblCourseCategoryId` int(11) NOT NULL,
  `tblInstructorId` int(11) NOT NULL,
  `tblCourseImageUrl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tblCourseTitle` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tblCourseSeoUrl` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tblCourseSummary` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tblCourseDetail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tblCourseRating` int(11) NOT NULL,
  `tblCoursePrice` float(9,2) NOT NULL,
  `tblCourseUpdatedDate` datetime NOT NULL,
  `tblCourseCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tblCourseStatus` enum('Active','InActive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Tablo döküm verisi `tblcourses`
--

INSERT INTO `tblcourses` (`tblCourseId`, `tblCourseCategoryId`, `tblInstructorId`, `tblCourseImageUrl`, `tblCourseTitle`, `tblCourseSeoUrl`, `tblCourseSummary`, `tblCourseDetail`, `tblCourseRating`, `tblCoursePrice`, `tblCourseUpdatedDate`, `tblCourseCreatedDate`, `tblCourseStatus`) VALUES
(4, 1, 2, 'cdn/images/courses/63b41f3312392.jpg', 'Microsoft Azure', 'microsoft-azure', 'özet', 'detay', 0, 180.00, '0000-00-00 00:00:00', '2023-01-03 15:24:21', 'Active'),
(5, 4, 2, 'cdn/images/courses/63b5429f07928.png', 'PHP ile Muheteşem Siteler Oluşturun !', 'php-ile-muhetesem-siteler-olusturun', 'php özet', 'php detay', 0, 149.00, '0000-00-00 00:00:00', '2023-01-04 12:10:55', 'Active');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblinstructors`
--

CREATE TABLE `tblinstructors` (
  `tblInstructorId` int(11) NOT NULL,
  `tblInstructorImageUrl` varchar(50) NOT NULL,
  `tblInstructorFirstname` varchar(100) NOT NULL,
  `tblInstructorLastname` varchar(100) NOT NULL,
  `tblInstructorDetail` longtext NOT NULL,
  `tblInstructorEmail` varchar(50) NOT NULL,
  `tblInstructorPhone` varchar(50) NOT NULL,
  `tblInstructorPassword` varchar(50) NOT NULL,
  `tblInstructorRating` int(11) NOT NULL,
  `tblInstructorLastLoginDate` datetime NOT NULL,
  `tblInstructorLastUpdatedDate` datetime NOT NULL,
  `tblInstructorDeletedDate` datetime NOT NULL,
  `tblInstructorCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tblInstructorStatus` enum('Active','InActive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblinstructors`
--

INSERT INTO `tblinstructors` (`tblInstructorId`, `tblInstructorImageUrl`, `tblInstructorFirstname`, `tblInstructorLastname`, `tblInstructorDetail`, `tblInstructorEmail`, `tblInstructorPhone`, `tblInstructorPassword`, `tblInstructorRating`, `tblInstructorLastLoginDate`, `tblInstructorLastUpdatedDate`, `tblInstructorDeletedDate`, `tblInstructorCreatedDate`, `tblInstructorStatus`) VALUES
(2, 'cdn/images/instructors/63b3291f682a1.jpg', 'Berkan', 'Yılmaz', 'I have worked as a Software Development Engineer in projects and companies in the software industry since 2017. Although my main area of expertise is C# .NET, I can use many programming languages effectively. I have more than 3 years of experience in software development using C# ASP.NET MVC, ASP.NET WebAPI, HTML5, CSS3, JavaScript. I am familiar with front-end frameworks for integration like AngularJS, AngularJS 2.0, REACT, Ember.js, VueJS. I\'m an Expert in Object Oriented Design. I can prepare OOP and database concepts. I have an expert understanding of .NET or related framework and up-to-date knowledge and experience with the latest releases. I have expert level knowledge about rapid development tools and applications. (Visual Studio, .Net 4.5+, LINQ). I have an expert understanding of fully responsive web applications and up-to-date knowledge and experience of the latest trends. • Expert knowledge of SPA design. I specialize in database and ORM optimization (Entity Framework). I have experience developing cross-browser web applications. I specialize in SOAP, RESTful web services, WebApi, WCF and SOA techniques. I have extensive technical knowledge of software development methodologies, design and implementation. I am Experienced with Test Driven Development (TDD). I am a self-motivated, detail-oriented, responsible teammate. I specialize in creating high quality systems with best practices, design patterns for software project. I have experience working in a fast-growing environment that requires flexibility and constant innovation.', 'berkan@bytecth.com', '0 539 692 81 38', '8de3852737be9df75c', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-01-02 17:07:44', 'Active');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblmanagers`
--

CREATE TABLE `tblmanagers` (
  `tblManagerId` int(2) NOT NULL,
  `tblManagerEmail` varchar(100) NOT NULL,
  `tblManagerPassword` varchar(100) NOT NULL,
  `tblManagerFirstname` varchar(50) NOT NULL,
  `tblManagerLastname` varchar(50) NOT NULL,
  `tblManagerPosition` varchar(50) NOT NULL,
  `tblManagerIpAddress` varchar(50) NOT NULL,
  `tblManagerPub` enum('MODERATOR','ADMINISTRATOR') NOT NULL,
  `tblManagerLastLoginDate` datetime NOT NULL,
  `tblManagerUpdatedDate` datetime NOT NULL,
  `tblManagerDeletedDate` datetime NOT NULL,
  `tblManagerCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tblManagerStatus` enum('ACTIVE','INACTIVE') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblmanagers`
--

INSERT INTO `tblmanagers` (`tblManagerId`, `tblManagerEmail`, `tblManagerPassword`, `tblManagerFirstname`, `tblManagerLastname`, `tblManagerPosition`, `tblManagerIpAddress`, `tblManagerPub`, `tblManagerLastLoginDate`, `tblManagerUpdatedDate`, `tblManagerDeletedDate`, `tblManagerCreatedDate`, `tblManagerStatus`) VALUES
(1, 'berkan@bytecth.com', '155d95861c35febb700cb661b', 'Berkan', 'Yılmaz', 'Sr. Software Engineer', '::1', 'ADMINISTRATOR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2022-12-22 22:09:45', 'ACTIVE');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblnewsletters`
--

CREATE TABLE `tblnewsletters` (
  `tblNewsletterId` int(11) NOT NULL,
  `tblNewsletterEmail` varchar(50) NOT NULL,
  `tblNewsletterCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblnewsletters`
--

INSERT INTO `tblnewsletters` (`tblNewsletterId`, `tblNewsletterEmail`, `tblNewsletterCreatedDate`) VALUES
(4, 'berkan@bytecth.com', '2023-01-04 11:40:19'),
(5, 'berkan@bytecth.com.tr', '2023-01-04 12:34:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblorders`
--

CREATE TABLE `tblorders` (
  `tblOrderId` int(11) NOT NULL,
  `tblOrderCourseId` int(11) NOT NULL,
  `tblOrderStudentId` int(11) NOT NULL,
  `tblOrderTotalAmount` float(9,2) NOT NULL,
  `tblOrderCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblorders`
--

INSERT INTO `tblorders` (`tblOrderId`, `tblOrderCourseId`, `tblOrderStudentId`, `tblOrderTotalAmount`, `tblOrderCreatedDate`) VALUES
(1, 4, 1, 180.00, '2023-01-04 06:08:47'),
(2, 5, 1, 149.00, '2023-01-04 12:14:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblpages`
--

CREATE TABLE `tblpages` (
  `tblPageId` int(1) NOT NULL,
  `tblPageTitle` varchar(200) NOT NULL,
  `tblPageSeoUrl` varchar(200) NOT NULL,
  `tblPageDetail` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tblPageArrangement` int(2) NOT NULL,
  `tblPageCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblpages`
--

INSERT INTO `tblpages` (`tblPageId`, `tblPageTitle`, `tblPageSeoUrl`, `tblPageDetail`, `tblPageArrangement`, `tblPageCreatedDate`) VALUES
(2, 'Gizlilik Sözleşmesi', 'gizlilik-sozlesmesi', 'Gizlilik sözleşmesi detay', 2, '2023-01-04 11:29:13'),
(3, 'Hakkımızda', 'hakkimizda', 'Hakkımızda detay', 1, '2023-01-04 11:29:23'),
(4, 'Kullanıcı Sözleşmesi', 'kullanici-sozlesmesi', 'sözleşme detay', 3, '2023-01-04 11:45:21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblsettings`
--

CREATE TABLE `tblsettings` (
  `tblSettingId` int(1) NOT NULL,
  `tblSettingTitle` varchar(250) NOT NULL,
  `tblSettingDescription` text NOT NULL,
  `tblSettingLogoUrl` varchar(100) NOT NULL,
  `tblSettingCompanyTitle` varchar(50) NOT NULL,
  `tblSettingEmail` varchar(50) NOT NULL,
  `tblSettingSupportEmail` varchar(50) NOT NULL,
  `tblSettingPhone` varchar(50) NOT NULL,
  `tblSettingGsm` varchar(50) NOT NULL,
  `tblSettingAddress` varchar(250) NOT NULL,
  `tblSettingCity` varchar(50) NOT NULL,
  `tblSettingDistrict` varchar(50) NOT NULL,
  `tblSettingSmtpUser` varchar(50) NOT NULL,
  `tblSettingSmtpPassword` varchar(50) NOT NULL,
  `tblSettingSmtpPort` varchar(50) NOT NULL,
  `tblSettingSmtpHost` varchar(50) NOT NULL,
  `tblSettingFacebook` varchar(50) NOT NULL,
  `tblSettingInstagram` varchar(50) NOT NULL,
  `tblSettingTwitter` varchar(50) NOT NULL,
  `tblSettingLinkedin` varchar(50) NOT NULL,
  `tblSettingYoutube` varchar(50) NOT NULL,
  `tblSettingSiteControl` enum('ACTIVE','INACTIVE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblsettings`
--

INSERT INTO `tblsettings` (`tblSettingId`, `tblSettingTitle`, `tblSettingDescription`, `tblSettingLogoUrl`, `tblSettingCompanyTitle`, `tblSettingEmail`, `tblSettingSupportEmail`, `tblSettingPhone`, `tblSettingGsm`, `tblSettingAddress`, `tblSettingCity`, `tblSettingDistrict`, `tblSettingSmtpUser`, `tblSettingSmtpPassword`, `tblSettingSmtpPort`, `tblSettingSmtpHost`, `tblSettingFacebook`, `tblSettingInstagram`, `tblSettingTwitter`, `tblSettingLinkedin`, `tblSettingYoutube`, `tblSettingSiteControl`) VALUES
(1, 'CourseX', 'Descriptions', 'cdn/images/logo/63b48d16a6f4c.png', 'CourseX', 'mail@CourseX.com', 'support@CourseX.com', '0 212 678 92 92', '0 539 890 00 33', 'adress', 'İstanbul', 'Merkez', 'user', 'password', 'port', 'host', 'facebook', 'instagram', 'twitter', 'linkedin', 'youtube', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tblstudents`
--

CREATE TABLE `tblstudents` (
  `tblStudentId` int(11) NOT NULL,
  `tblStudentFirstname` varchar(100) NOT NULL,
  `tblStudentLastname` varchar(100) NOT NULL,
  `tblStudentEmail` varchar(50) NOT NULL,
  `tblStudentPassword` varchar(100) NOT NULL,
  `tblStudentLastLoginDate` datetime NOT NULL,
  `tblStudentUpdatedDate` datetime NOT NULL,
  `tblStudentDeletedDate` datetime NOT NULL,
  `tblStudentCreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tblStudentStatus` enum('Active','InActive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tblstudents`
--

INSERT INTO `tblstudents` (`tblStudentId`, `tblStudentFirstname`, `tblStudentLastname`, `tblStudentEmail`, `tblStudentPassword`, `tblStudentLastLoginDate`, `tblStudentUpdatedDate`, `tblStudentDeletedDate`, `tblStudentCreatedDate`, `tblStudentStatus`) VALUES
(1, 'Berkan', 'Yılmaz', 'berkan@bytecth.com', '55d95861c35febb700', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-01-04 02:00:17', 'Active'),
(2, 'Berkan', 'Yılmaz', 'berkan@bytecth.com.tr', '55d95861c35febb700', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-01-04 02:02:16', 'Active'),
(3, 'Berkan', 'Yılmaz', 'berkan@amazon.com.tr', '55d95861c35febb700', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-01-04 02:02:53', 'Active'),
(5, 'Oğuz', 'Atay', 'tutunamayanlar@gmail.com', '55d95861c35febb700', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-01-04 12:16:48', 'Active');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tblcarts`
--
ALTER TABLE `tblcarts`
  ADD PRIMARY KEY (`tblCartId`);

--
-- Tablo için indeksler `tblcoursecategories`
--
ALTER TABLE `tblcoursecategories`
  ADD PRIMARY KEY (`tblCourseCategoryId`);

--
-- Tablo için indeksler `tblcoursedetails`
--
ALTER TABLE `tblcoursedetails`
  ADD PRIMARY KEY (`CourseDetailId`);

--
-- Tablo için indeksler `tblcourses`
--
ALTER TABLE `tblcourses`
  ADD PRIMARY KEY (`tblCourseId`);

--
-- Tablo için indeksler `tblinstructors`
--
ALTER TABLE `tblinstructors`
  ADD PRIMARY KEY (`tblInstructorId`),
  ADD UNIQUE KEY `tblInstructorEmail` (`tblInstructorEmail`);

--
-- Tablo için indeksler `tblmanagers`
--
ALTER TABLE `tblmanagers`
  ADD PRIMARY KEY (`tblManagerId`),
  ADD UNIQUE KEY `tblManagerEmail` (`tblManagerEmail`);

--
-- Tablo için indeksler `tblnewsletters`
--
ALTER TABLE `tblnewsletters`
  ADD PRIMARY KEY (`tblNewsletterId`);

--
-- Tablo için indeksler `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`tblOrderId`);

--
-- Tablo için indeksler `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`tblPageId`);

--
-- Tablo için indeksler `tblsettings`
--
ALTER TABLE `tblsettings`
  ADD PRIMARY KEY (`tblSettingId`);

--
-- Tablo için indeksler `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`tblStudentId`),
  ADD UNIQUE KEY `tblStudentEmail` (`tblStudentEmail`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tblcarts`
--
ALTER TABLE `tblcarts`
  MODIFY `tblCartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `tblcoursecategories`
--
ALTER TABLE `tblcoursecategories`
  MODIFY `tblCourseCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `tblcoursedetails`
--
ALTER TABLE `tblcoursedetails`
  MODIFY `CourseDetailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `tblcourses`
--
ALTER TABLE `tblcourses`
  MODIFY `tblCourseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `tblinstructors`
--
ALTER TABLE `tblinstructors`
  MODIFY `tblInstructorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `tblmanagers`
--
ALTER TABLE `tblmanagers`
  MODIFY `tblManagerId` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `tblnewsletters`
--
ALTER TABLE `tblnewsletters`
  MODIFY `tblNewsletterId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `tblOrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `tblPageId` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `tblStudentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
