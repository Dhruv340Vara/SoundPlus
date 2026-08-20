-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 22, 2025 at 06:38 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soundplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','editor') DEFAULT 'editor',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@2005', 'superadmin', '2025-01-20 10:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
CREATE TABLE IF NOT EXISTS `albums` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  PRIMARY KEY (`album_id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `title`, `artist_id`, `cover_image`, `release_date`) VALUES
(5, 'new Album1', 13, 'download (3).jpg', '2025-03-16'),
(4, 'Top Album', 12, 'emotional_song_cover_img.jpg', '2025-03-23'),
(6, 'Hindi Album', 14, 'download (4).jpg', '2025-03-13'),
(7, 'gujrati Album', 20, 'images (2).jpg', '2025-03-29'),
(8, 'English Album', 17, 'download (7).jpg', '2025-03-16'),
(9, 'Rap Album', 15, 'download (5).jpg', '2025-03-06'),
(10, 'Top Album', 18, '.trashed-1744030394-channa_mereya(emotional songs).jpeg', '2025-03-23'),
(11, 'Album1', 15, 'images (2).jpg', '2025-04-04'),
(15, 'new', 17, '128Maar Udi - Sarfira 128 Kbps.jpg', '2025-02-25'),
(14, 'ALBUM 2.0', 25, '128Maar Udi - Sarfira 128 Kbps.jpg', '2025-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
CREATE TABLE IF NOT EXISTS `artists` (
  `artist_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`artist_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `name`, `profile_picture`, `bio`, `created_at`) VALUES
(12, 'Arijit Singh', 'download (2).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:43:31'),
(13, 'shreya goshal', 'download (3).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:44:12'),
(14, 'honey singh', 'download (4).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:44:25'),
(15, 'Badshah', 'download (5).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:44:51'),
(16, 'Raftar', 'download (6).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:45:05'),
(17, 'Amiway buntai', 'download (7).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:45:21'),
(18, 'kumar sanu', 'download (8).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:45:48'),
(19, 'lata mangeshkar', 'images.jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:46:12'),
(20, 'Rakesh barot', 'images (2).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:46:37'),
(21, 'hemesh rasmiya', 'images (3).jpg', 'he is very good singer. this singer are the indian best singer to all singer this singer best of the world singer.his voice amazing.World best singer.', '2025-03-10 06:46:50'),
(24, 'rock', 'download (5).jpg', 'best singer', '2025-03-12 11:00:00'),
(25, 'kk', 'download (7).jpg', 'best singers.', '2025-03-12 11:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in Days',
  `description` text,
  PRIMARY KEY (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `name`, `price`, `duration`, `description`) VALUES
(7, 'free', '0.00', 1, 'âŽListen To music ads-free or every \r\nâŽplay-anywhere even offline user\r\nâŽon-demand playback speed\r\nâœ…free download'),
(8, 'Basic', '200.00', 6, 'âœ…Listen To music ads-free or every \r\nâœ…play-anywhere even offline user\r\nâŽon-demand playback speed\r\nâœ…best plan for beginer or guest user\r\nâœ…free download\r\n'),
(9, 'pro', '300.00', 12, 'âœ…Listen To music ads-free or every \r\nâœ…play-anywhere even offline user\r\nâœ…on-demand playback speed\r\nâœ…best plan for beginer or guest user\r\nâœ…Unlimated downloads\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `user_id`, `name`, `created_at`) VALUES
(2, 8, 'new', '2025-03-21 10:15:30'),
(4, 8, 'thakor', '2025-03-21 10:28:53'),
(6, 8, 'raju', '2025-03-21 10:54:25'),
(7, 8, 'rr', '2025-03-21 11:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_songs`
--

DROP TABLE IF EXISTS `playlist_songs`;
CREATE TABLE IF NOT EXISTS `playlist_songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `playlist_songs`
--

INSERT INTO `playlist_songs` (`id`, `playlist_id`, `song_id`, `added_at`) VALUES
(3, 7, 8, '2025-03-22 06:10:55'),
(2, 2, 9, '2025-03-22 05:36:09'),
(4, 2, 8, '2025-03-22 06:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `rating`, `timestamp`) VALUES
(1, 2, '2025-02-19 10:40:34'),
(2, 2, '2025-02-19 10:41:21'),
(3, 5, '2025-02-19 10:41:30'),
(4, 5, '2025-02-19 10:48:58'),
(5, 4, '2025-02-19 10:49:48'),
(6, 5, '2025-02-19 10:49:51'),
(7, 2, '2025-02-19 10:49:57'),
(8, 4, '2025-02-19 10:50:08'),
(9, 5, '2025-02-19 10:50:17'),
(10, 5, '2025-02-19 10:50:26'),
(11, 5, '2025-02-19 10:50:27'),
(12, 5, '2025-02-19 10:50:29'),
(13, 5, '2025-02-19 10:50:30'),
(14, 5, '2025-02-19 10:50:33'),
(15, 1, '2025-02-19 10:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','inactive') DEFAULT 'active',
  `cover_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  KEY `artist_id` (`artist_id`),
  KEY `album_id` (`album_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `title`, `artist_id`, `album_id`, `genre`, `file_path`, `uploaded_at`, `status`, `cover_image`) VALUES
(32, 'hanumain kind', 14, 9, 'rap', '../uploads/songs/hanuman kind.crdownload', '2025-03-20 06:54:24', 'active', '../uploads/cover_img/WhatsApp Image 2025-02-01 at 11.36.40 PM.jpg'),
(9, 'kissak', 14, 6, 'pop', '../uploads/songs/Vishvambhari-Stuti-Kinjal-Dave-K.MP3', '2025-03-10 06:57:40', 'active', '../uploads/cover_img/128Kissik - Pushpa 2 The Rule 128 Kbps.jpg'),
(7, 'hanuman chalisa', 12, 5, 'bhakti', '../uploads/songs/Hanuman-Chalisa-Super-Fast-Music.MP3', '2025-03-10 06:54:45', 'active', '../uploads/cover_img/Shree-Hanuman-Chalisa-Hanuman-Ashtak-Hindi-1992-20230904173628-500x500.jpg'),
(8, 'bahubali song', 13, 4, 'top', '../uploads/songs/Kaun-Hain-Voh-Full-Video-Baahuba.MP3', '2025-03-10 06:56:29', 'active', '../uploads/cover_img/Kaun-Hain-Voh-Full-Video-Baahuba(bhakti song).jpg'),
(35, 'preti zanta', 25, 15, 'hindi ', '../uploads/songs/Maine-Royaa-1.MP3', '2025-03-20 08:43:50', 'active', '../uploads/cover_img/emotional_song_cover_img.jpg'),
(13, 'Banke-Hawa-Mein-Bezubaan-Mein-Of', 19, 9, 'pop', '../uploads/songs/Banke-Hawa-Mein-Bezubaan-Mein-Of.MP3', '2025-03-10 07:01:27', 'active', '../uploads/cover_img/Banke-Hawa-Mein-Bezubaan-Mein-Of.jpg'),
(14, 'bhula_dena_muje', 19, 10, 'pop', '../uploads/songs/Arijit-Singh-Humari-Adhuri-Kahan.MP3', '2025-03-10 07:02:09', 'active', '../uploads/cover_img/Hamari-Adhuri-Kahani-Hindi-2015-500x500.jpg'),
(15, 'bhula_dena_muje', 16, 9, 'pop', '../uploads/songs/Bhula-Dena-Mujhe-Video-Song-Aash.MP3', '2025-03-10 07:03:39', 'active', '../uploads/cover_img/bhula_dena_muje.jpg'),
(16, 'channa_mereya', 21, 6, 'pop', '../uploads/songs/Channa-Mereya-Lyric-Video-Ae-Dil.MP3', '2025-03-10 07:05:19', 'active', '../uploads/cover_img/channa_mereya.jpg'),
(17, '128Maar Udi - Sarfira 128 Kbps', 12, 7, 'pop', '../uploads/songs/Vishvambhari-Stuti-Kinjal-Dave-K.MP3', '2025-03-10 07:07:56', 'active', '../uploads/cover_img/images (1).jpg'),
(18, '128Singham Again Title Track - Singham Again 128 Kbps', 19, 9, 'pop', '../uploads/songs/Maa-Apne-Dware-Bula-Le-Mujhe-Ful.MP3', '2025-03-10 07:08:43', 'active', '../uploads/cover_img/128Singham Again Title Track - Singham Again 128 Kbps.jpg'),
(19, 'bhakt_song', 13, 9, 'pop', '../uploads/songs/Maa-Apne-Dware-Bula-Le-Mujhe-Ful.MP3', '2025-03-10 07:09:17', 'active', '../uploads/cover_img/bhakt_song_cover_img(1).jpg'),
(20, 'new song', 16, 6, 'pop', '../uploads/songs/Jai-Shree-Ram-Hansraj-Raghuwansh.MP3', '2025-03-10 07:10:09', 'active', '../uploads/cover_img/Jai-Shree-Ram-Hindi-2023-20231215230942-500x500.jpg'),
(34, 'agar tum sath ho', 13, 6, 'hindi', '../uploads/songs/Agar-Tum-Saath-Ho-FULL-AUDIO-Son.MP3', '2025-03-20 07:03:20', 'active', '../uploads/cover_img/.trashed-1744030394-agar_tum_sath_ho(emotional songs).jpg'),
(23, 'song1', 15, 4, 'pop', '../uploads/songs/Maine-Royaa-1.MP3', '2025-03-18 06:23:45', 'active', '../uploads/cover_img/mai_royaa.jpg'),
(31, 'milonre', 14, 9, 'rap', '../uploads/songs/millonre.crdownload', '2025-03-20 06:33:33', 'active', '../uploads/cover_img/download (4).jpg'),
(26, 'old song', 20, 12, 'pop', '../uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.39 AM (1).mpeg.crdownload', '2025-03-18 07:04:26', 'active', '../uploads/cover_img/download (5).jpg'),
(27, 'aj ki rat', 13, 5, 'hindi', '../uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.39 AM.mpeg.crdownload', '2025-03-18 07:08:58', 'active', '../uploads/cover_img/128Hauli Hauli - Khel Khel Mein 128 Kbps.jpg'),
(28, 'maa tuji salam', 17, 6, 'hindi', '../uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.40 AM (1).mpeg.crdownload', '2025-03-18 07:11:33', 'active', '../uploads/cover_img/Maa-Apne-Dware-Bula-Le-Mujhe-Hindi-2024-20240923191045-500x500.jpg'),
(29, 'ob dash miari', 18, 13, 'bhakti ', '../uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.40 AM.mpeg.crdownload', '2025-03-18 07:14:58', 'active', '../uploads/cover_img/download (3).jpg'),
(33, 'husan tera tuba tuba', 25, 6, 'hindi song', '../uploads/songs/husan tera tuba tuba.crdownload', '2025-03-20 07:00:29', 'active', '../uploads/cover_img/size_m_1738240989.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `subscription_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `user_id` (`user_id`),
  KEY `plan_id` (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`subscription_id`, `user_id`, `plan_id`, `start_date`, `end_date`) VALUES
(8, 8, 9, '2025-03-18', '2025-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default_user.png',
  `subscription_plan` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','inactive') DEFAULT 'active',
  `mobile` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_picture`, `subscription_plan`, `create_at`, `status`, `mobile`, `dob`, `gender`) VALUES
(8, 'raju@747', 'raju@gmail.com', '$2y$10$iOS7i3/Zgt2BgS1z6v3aReuD/ARtIfemqasEOookh.oVtEkw.LsLa', '67da86692a506.jpg', NULL, '2025-02-12 10:00:41', 'active', '9316251789', '2025-03-12', 'male'),
(2, 'darshan@', 'darshan1122@gmail.com', '$2y$10$cDHyJMDlAvV4kk4.umTkP.X/Kd.OsGEOzvFBSAeaHvnT7g/RNmSs.', 'default_user.png', NULL, '2025-01-27 04:59:22', 'active', '9724737491', NULL, NULL),
(4, 'raju@123', 'raju225@gmail.com', '$2y$10$XZ5gOnSqgDLEfqmakYSvuOz.Sb9DiWMgk6K3pvATjwVJHutU3pyhO', 'default_user.png', NULL, '2025-01-27 05:53:42', 'inactive', '8714737491', NULL, NULL),
(10, 'Raju@16389', 'thakor@gmail.cm', '$2y$10$tZe0i.qSwNu4VLKVafHICeujkatyy32iZu/kqYrnoEXVmvrYLty0y', 'default_user.png', NULL, '2025-02-19 10:58:27', 'active', '8980997050', NULL, NULL),
(11, '@raju37232', 'Raj2u@gmai.com', '$2y$10$mIhiBM02l6wowqt4zDcJFurfXh7npdQosjJP.ZiXdqaReucPXiEeW', 'default_user.png', NULL, '2025-02-19 11:00:26', 'active', '1234567891', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
