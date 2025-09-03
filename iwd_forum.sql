-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 11:12 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iwd_forum`
--
CREATE DATABASE IF NOT EXISTS `iwd_forum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `iwd_forum`;

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` tinyint(4) UNSIGNED NOT NULL,
  `forum_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_name`) VALUES
(1, 'General Discussion'),
(2, 'News and Events'),
(3, 'Video and Images');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `event_type`, `username`, `ip_address`, `log_date`, `event_details`) VALUES
(1, 'Unsuccessful login', NULL, '::1', '2023-10-28 12:39:54', 'username jbloggs'),
(2, 'Unsuccessful Login', NULL, '::1', '2023-10-28 12:41:00', 'username hdroxas'),
(3, 'Successful Login', 'jbloggs', '::1', '2023-10-28 12:42:57', NULL),
(4, 'Post Reply', 'jbloggs', '::1', '2023-10-28 12:47:14', 'thread_id: 7'),
(5, 'Logout', 'jbloggs', '::1', '2023-10-28 12:54:36', NULL),
(6, 'Successful Login', 'hdroxas', '::1', '2023-10-28 13:03:53', NULL),
(7, 'Logout', 'hdroxas', '::1', '2023-10-28 13:03:56', NULL),
(8, 'Successful Login', 'hdroxas', '::1', '2023-10-28 13:59:00', NULL),
(9, 'Logout', 'hdroxas', '::1', '2023-10-28 14:07:44', NULL),
(10, 'Successful Login', 'cchloems', '::1', '2023-10-28 14:09:59', NULL),
(11, 'Logout', 'cchloems', '::1', '2023-10-28 14:12:12', NULL),
(12, 'Successful Login', 'hdroxas', '::1', '2023-10-28 14:12:22', NULL),
(13, 'Logout', 'hdroxas', '::1', '2023-10-28 14:14:49', NULL),
(14, 'Successful Login', 'cchloems', '::1', '2023-10-28 14:28:51', NULL),
(15, 'Successful Login', 'hdroxas', '::1', '2023-10-28 15:09:28', NULL),
(16, 'Logout', 'hdroxas', '::1', '2023-10-28 15:09:53', NULL),
(17, 'Successful Login', 'cchloems', '::1', '2023-10-28 15:10:03', NULL),
(18, 'Logout', 'cchloems', '::1', '2023-10-28 16:21:03', NULL),
(19, 'Successful Login', 'jbloggs', '::1', '2023-10-28 16:21:11', NULL),
(20, 'Thread Edit', 'jbloggs', '::1', '2023-10-28 16:21:42', 'thread_id: 3'),
(21, 'Logout', 'jbloggs', '::1', '2023-10-28 16:32:08', NULL),
(22, 'Successful Login', 'cchloems', '::1', '2023-10-28 16:32:32', NULL),
(23, 'Thread deletion', 'cchloems', '::1', '2023-10-28 16:32:37', 'thread_id: 4'),
(24, 'Logout', 'cchloems', '::1', '2023-10-28 16:33:26', NULL),
(25, 'Successful Login', 'hdroxas', '::1', '2023-10-28 16:33:32', NULL),
(26, 'Thread deletion', 'hdroxas', '::1', '2023-10-28 16:52:14', 'thread_id: 6'),
(27, 'Post Thread', 'hdroxas', '::1', '2023-10-28 16:52:42', 'thread_id: 13'),
(28, 'Logout', 'hdroxas', '::1', '2023-10-28 16:53:08', NULL),
(29, 'Successful Login', 'cchloems', '::1', '2023-10-28 16:53:15', NULL),
(30, 'Thread deletion', 'cchloems', '::1', '2023-10-28 16:55:51', 'thread_id: 13'),
(31, 'Post Reply', 'cchloems', '::1', '2023-10-28 17:01:20', 'thread_id: 1'),
(32, 'Post Thread', 'cchloems', '::1', '2023-10-28 17:01:40', 'thread_id: 14'),
(33, 'Thread deletion', 'cchloems', '::1', '2023-10-28 17:01:46', 'thread_id: 14'),
(34, 'Post Thread', 'cchloems', '::1', '2023-10-28 17:01:59', 'thread_id: 15'),
(35, 'Thread Edit', 'cchloems', '::1', '2023-10-28 17:02:07', 'thread_id: 15'),
(36, 'Successful Login', 'cchloems', '::1', '2023-10-28 17:32:14', NULL),
(37, 'Registration', NULL, '::1', '2023-10-29 03:06:48', 'username suejames');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `username`, `thread_id`, `content`, `post_date`) VALUES
(1, 'hdroxas', 7, 'blah', '2023-10-28 08:13:50'),
(2, 'hdroxas', 7, 'blah\r\n', '2023-10-28 11:55:05'),
(3, 'hdroxas', 7, 'blah', '2023-10-28 11:55:33'),
(4, 'hdroxas', 7, 'hey', '2023-10-28 11:57:49'),
(5, 'jbloggs', 7, 'hey', '2023-10-28 12:43:11'),
(6, 'jbloggs', 7, 'yo', '2023-10-28 12:47:14'),
(7, 'cchloems', 1, 'dasdas', '2023-10-28 17:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` smallint(6) NOT NULL,
  `tag_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(4, 'art'),
(2, 'events'),
(3, 'gaming'),
(1, 'news');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `thread_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `forum_id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(40000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `username`, `forum_id`, `title`, `content`, `post_date`) VALUES
(1, 'bsmith', 1, 'So how about this weather?', 'It has been raining non-stop for the past few days - getting pretty sick of it, plus it\'s really cold!', '2023-08-31 15:07:54'),
(2, 'jbloggs', 1, 'Strong rain last night', 'For a few minutes last night, there was a downpour that was stronger than anything I\'ve ever experienced before.\n\nIt was loud enough (on my tin roof) to wake me up and I couldn\'t get back to sleep afterwards!', '2023-08-31 15:07:54'),
(3, 'jbloggs', 2, 'Turn your lights on when driving in the rain', 'It can be really hard to see other cars on the road, particularly grey ones, when there is heavy rain.<br /><br /><br />\r\nSo please, turn your li', '2023-10-28 16:21:42'),
(5, 'bsmith', 2, 'Perfectly normal thread', 'This not at all a test of whether this forum is vulnerable to XSS attacks.\n<script>alert(\"Hacked!\");</script>\nPlease move along.', '2023-08-31 15:07:54'),
(7, 'hdroxas', 2, 'Look at this!', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus', '2023-09-09 02:10:17'),
(8, 'jbloggs', 1, 'Wow!', 'Look at this!', '2023-09-01 11:10:30'),
(15, 'cchloems', 2, 'fdsfdsf', 'dsfsdfsd', '2023-10-28 17:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `thread_tag`
--

CREATE TABLE `thread_tag` (
  `thread_id` int(11) NOT NULL,
  `tag_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(100) DEFAULT NULL,
  `dob` date NOT NULL,
  `access_level` varchar(10) NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `real_name`, `dob`, `access_level`) VALUES
('bsmith', '$2y$10$B2U2yL5Bok0azaC4PEil6O24ycBL3oDgROKpSu5/0t5PSqBxdgrzm', 'Bob Smith', '1998-05-21', 'member'),
('cchloems', '$2y$10$B2U2yL5Bok0azaC4PEil6O24ycBL3oDgROKpSu5/0t5PSqBxdgrzm', 'Chloe Sianghio', '1996-05-09', 'admin'),
('haowen', '$2y$10$B2U2yL5Bok0azaC4PEil6O24ycBL3oDgROKpSu5/0t5PSqBxdgrzm', 'David Cook', '1994-11-06', 'member'),
('hdroxas', '$2y$10$B2U2yL5Bok0azaC4PEil6O24ycBL3oDgROKpSu5/0t5PSqBxdgrzm', 'Harvey Roxas', '1994-11-06', 'member'),
('jbloggs', '$2y$10$B2U2yL5Bok0azaC4PEil6O24ycBL3oDgROKpSu5/0t5PSqBxdgrzm', 'Joe Bloggs', '2000-10-01', 'member'),
('suejames', '$2y$10$JO9QFLsJURFyAq1b89j/r.0PRv9jK/CeyNuWw6ppd/lmhyf2rrU9q', 'Sue James', '1994-10-05', 'member'),
('tr21212', '$2y$10$B2U2yL5Bok0azaC4PEil6O24ycBL3oDgROKpSu5/0t5PSqBxdgrzm', 'David Cook', '1986-11-01', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD UNIQUE KEY `forum_name` (`forum_name`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `username` (`username`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `username` (`username`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Indexes for table `thread_tag`
--
ALTER TABLE `thread_tag`
  ADD PRIMARY KEY (`thread_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`) ON DELETE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`forum_id`);

--
-- Constraints for table `thread_tag`
--
ALTER TABLE `thread_tag`
  ADD CONSTRAINT `thread_tag_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`),
  ADD CONSTRAINT `thread_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
