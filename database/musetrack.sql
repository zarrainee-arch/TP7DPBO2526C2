-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2026 at 04:19 PM
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
-- Database: `musetrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `artist_name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `debut_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `artist_name`, `country`, `debut_year`) VALUES
(1, 'Taylor Swift', 'United States', '2006'),
(2, 'Cigarettes After Sex', 'United States', '2008'),
(3, 'LANY', 'United States', '2014'),
(4, 'Avril Lavigne', 'Canada', '2002'),
(5, 'Lizzy McAlpine', 'USA', '2020');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `genre_name`, `description`) VALUES
(1, 'Pop', 'Popular contemporary music'),
(2, 'Indie Pop', 'Independent pop music'),
(3, 'Dream Pop', 'Atmospheric and dreamy pop music'),
(4, 'Alternative Rock', 'Alternative rock music');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `release_year` year(4) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist_id`, `genre_id`, `release_year`, `duration`) VALUES
(1, 'Timeless', 1, 1, '2023', 256),
(2, 'Heavenly', 2, 3, '2019', 264),
(3, 'Soft', 3, 2, '2017', 185),
(4, 'Complicated', 4, 4, '2002', 245),
(5, 'Spring Into Summer', 5, 2, '2022', 204);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genre_name` (`genre_name`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_song_artist` (`artist_id`),
  ADD KEY `fk_song_genre` (`genre_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `fk_song_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_song_genre` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
