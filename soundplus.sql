-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2026 at 10:36 AM
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
-- Database: `soundplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','editor') DEFAULT 'editor',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@2005', 'superadmin', '2025-01-20 10:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in Days',
  `description` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `name`, `price`, `duration`, `description`) VALUES
(7, 'free', 0.00, 1, 'âŽListen To music ads-free or every \r\nâŽplay-anywhere even offline user\r\nâŽon-demand playback speed\r\nâœ…free download'),
(8, 'Basic', 200.00, 6, 'âœ…Listen To music ads-free or every \r\nâœ…play-anywhere even offline user\r\nâŽon-demand playback speed\r\nâœ…best plan for beginer or guest user\r\nâœ…free download\r\n'),
(9, 'pro', 300.00, 12, 'âœ…Listen To music ads-free or every \r\nâœ…play-anywhere even offline user\r\nâœ…on-demand playback speed\r\nâœ…best plan for beginer or guest user\r\nâœ…Unlimated downloads\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `playlist_songs` (
  `id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active',
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `title`, `artist_id`, `album_id`, `genre`, `file_path`, `uploaded_at`, `status`, `cover_image`) VALUES
(32, 'hanumain kind', 14, 9, 'rap', '../admin/uploads/songs/hanuman kind.crdownload', '2025-03-20 06:54:24', 'active', 'WhatsApp Image 2025-02-01 at 11.36.40 PM.jpg'),
(9, 'kissak', 14, 6, 'pop', '../admin/uploads/songs/Vishvambhari-Stuti-Kinjal-Dave-K.MP3', '2025-03-10 06:57:40', 'active', '128Kissik - Pushpa 2 The Rule 128 Kbps.jpg'),
(7, 'hanuman chalisa', 12, 5, 'bhakti', '../admin/uploads/songs/Hanuman-Chalisa-Super-Fast-Music.MP3', '2025-03-10 06:54:45', 'active', 'Shree-Hanuman-Chalisa-Hanuman-Ashtak-Hindi-1992-20230904173628-500x500.jpg'),
(8, 'bahubali song', 13, 4, 'top', '../admin/uploads/songs/Kaun-Hain-Voh-Full-Video-Baahuba.MP3', '2025-03-10 06:56:29', 'active', 'Kaun-Hain-Voh-Full-Video-Baahuba(bhakti song).jpg'),
(35, 'preti zanta', 25, 15, 'hindi ', '../admin/uploads/songs/Maine-Royaa-1.MP3', '2025-03-20 08:43:50', 'active', 'emotional_song_cover_img.jpg'),
(13, 'Banke-Hawa-Mein-Bezubaan-Mein-Of', 19, 9, 'pop', '../admin/uploads/songs/Banke-Hawa-Mein-Bezubaan-Mein-Of.MP3', '2025-03-10 07:01:27', 'active', 'Banke-Hawa-Mein-Bezubaan-Mein-Of.jpg'),
(14, 'bhula_dena_muje', 19, 10, 'pop', '../admin/uploads/songs/Arijit-Singh-Humari-Adhuri-Kahan.MP3', '2025-03-10 07:02:09', 'active', 'Hamari-Adhuri-Kahani-Hindi-2015-500x500.jpg'),
(15, 'bhula_dena_muje', 16, 9, 'pop', '../admin/uploads/songs/Bhula-Dena-Mujhe-Video-Song-Aash.MP3', '2025-03-10 07:03:39', 'active', 'bhula_dena_muje.jpg'),
(16, 'channa_mereya', 21, 6, 'pop', '../admin/uploads/songs/Channa-Mereya-Lyric-Video-Ae-Dil.MP3', '2025-03-10 07:05:19', 'active', 'channa_mereya.jpg'),
(17, '128Maar Udi - Sarfira 128 Kbps', 12, 7, 'pop', '../admin/uploads/songs/Vishvambhari-Stuti-Kinjal-Dave-K.MP3', '2025-03-10 07:07:56', 'active', 'images (1).jpg'),
(18, '128Singham Again Title Track - Singham Again 128 Kbps', 19, 9, 'pop', '../admin/uploads/songs/Maa-Apne-Dware-Bula-Le-Mujhe-Ful.MP3', '2025-03-10 07:08:43', 'active', '128Singham Again Title Track - Singham Again 128 Kbps.jpg'),
(19, 'bhakt_song', 13, 9, 'pop', '../admin/uploads/songs/Maa-Apne-Dware-Bula-Le-Mujhe-Ful.MP3', '2025-03-10 07:09:17', 'active', 'bhakt_song_cover_img(1).jpg'),
(20, 'new song', 16, 6, 'pop', '../admin/uploads/songs/Jai-Shree-Ram-Hansraj-Raghuwansh.MP3', '2025-03-10 07:10:09', 'active', 'Jai-Shree-Ram-Hindi-2023-20231215230942-500x500.jpg'),
(34, 'agar tum sath ho', 13, 6, 'hindi', '../admin/uploads/songs/Agar-Tum-Saath-Ho-FULL-AUDIO-Son.MP3', '2025-03-20 07:03:20', 'active', '.trashed-1744030394-agar_tum_sath_ho(emotional songs).jpg'),
(23, 'song1', 15, 4, 'pop', '../admin/uploads/songs/Maine-Royaa-1.MP3', '2025-03-18 06:23:45', 'active', 'mai_royaa.jpg'),
(31, 'milonre', 14, 9, 'rap', '../admin/uploads/songs/millonre.crdownload', '2025-03-20 06:33:33', 'active', 'download (4).jpg'),
(26, 'old song', 20, 12, 'pop', '../admin/uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.39 AM (1).mpeg.crdownload', '2025-03-18 07:04:26', 'active', 'download (5).jpg'),
(27, 'aj ki rat', 13, 5, 'hindi', '../admin/uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.39 AM.mpeg.crdownload', '2025-03-18 07:08:58', 'active', '128Hauli Hauli - Khel Khel Mein 128 Kbps.jpg'),
(28, 'maa tuji salam', 17, 6, 'hindi', '../admin/uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.40 AM (1).mpeg.crdownload', '2025-03-18 07:11:33', 'active', 'Maa-Apne-Dware-Bula-Le-Mujhe-Hindi-2024-20240923191045-500x500.jpg'),
(29, 'ob dash miari', 18, 13, 'bhakti ', '../admin/uploads/songs/WhatsApp Audio 2025-03-18 at 11.43.40 AM.mpeg.crdownload', '2025-03-18 07:14:58', 'active', 'download (3).jpg'),
(33, 'husan tera tuba tuba', 25, 6, 'hindi song', '../admin/uploads/songs/husan tera tuba tuba.crdownload', '2025-03-20 07:00:29', 'active', 'size_m_1738240989.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`subscription_id`, `user_id`, `plan_id`, `start_date`, `end_date`) VALUES
(8, 8, 9, '2025-03-18', '2025-03-30'),
(9, 13, 7, '2026-08-20', '2026-08-21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default_user.png',
  `subscription_plan` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active',
  `mobile` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_picture`, `subscription_plan`, `create_at`, `status`, `mobile`, `dob`, `gender`) VALUES
(8, 'raju@747', 'raju@gmail.com', '$2y$10$iOS7i3/Zgt2BgS1z6v3aReuD/ARtIfemqasEOookh.oVtEkw.LsLa', '67da86692a506.jpg', NULL, '2025-02-12 10:00:41', 'active', '9316251789', '2025-03-12', 'male'),
(2, 'darshan@', 'darshan1122@gmail.com', '$2y$10$cDHyJMDlAvV4kk4.umTkP.X/Kd.OsGEOzvFBSAeaHvnT7g/RNmSs.', 'default_user.png', NULL, '2025-01-27 04:59:22', 'active', '9724737491', NULL, NULL),
(4, 'raju@123', 'raju225@gmail.com', '$2y$10$XZ5gOnSqgDLEfqmakYSvuOz.Sb9DiWMgk6K3pvATjwVJHutU3pyhO', 'default_user.png', NULL, '2025-01-27 05:53:42', 'inactive', '8714737491', NULL, NULL),
(10, 'Raju@16389', 'thakor@gmail.cm', '$2y$10$tZe0i.qSwNu4VLKVafHICeujkatyy32iZu/kqYrnoEXVmvrYLty0y', 'default_user.png', NULL, '2025-02-19 10:58:27', 'active', '8980997050', NULL, NULL),
(11, '@raju37232', 'Raj2u@gmai.com', '$2y$10$mIhiBM02l6wowqt4zDcJFurfXh7npdQosjJP.ZiXdqaReucPXiEeW', 'default_user.png', NULL, '2025-02-19 11:00:26', 'active', '1234567891', NULL, NULL),
(13, 'dhruv@', 'dhruv@gmail.com', '$2y$10$gzxN/RUnxSJ8Q5.ZG5046unsNGK0efFci3y20DcUzQmxNhZf3MJxO', 'default_user.png', NULL, '2026-08-22 02:25:53', 'active', '1234567890', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `playlist_songs`
--
ALTER TABLE `playlist_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
