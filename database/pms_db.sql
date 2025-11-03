-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2025 at 06:05 PM
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
-- Database: `pms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement_list`
--

CREATE TABLE `announcement_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_list`
--

INSERT INTO `announcement_list` (`id`, `title`, `image_path`, `images`, `description`, `date_created`) VALUES
(12, 'Sample Announcement', 'uploads/announcements/12_1.jpg', '[\"uploads/announcements/12_1.jpg\",\"uploads/announcements/12_2.jpg\",\"uploads/announcements/12_3.jpg\",\"uploads/announcements/12_4.jpg\",\"uploads/announcements/12_5.jpg\"]', 'awdawd', '2025-10-30 00:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `time_scanned` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_attendance`
--

CREATE TABLE `event_attendance` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `scan_time` datetime DEFAULT current_timestamp(),
  `status` enum('present','absent') DEFAULT 'present',
  `scanner_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_paths` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_list`
--

INSERT INTO `event_list` (`id`, `title`, `description`, `image_path`, `image_paths`, `images`, `date_created`) VALUES
(31, 'Sample', 'Sample', NULL, '[\"uploads\\/events\\/31_1761756295_0.jpg\",\"uploads\\/events\\/31_1761756295_1.jpg\",\"uploads\\/events\\/31_1761756295_2.jpg\",\"uploads\\/events\\/31_1761756295_3.jpg\",\"uploads\\/events\\/31_1761756295_4.jpg\"]', NULL, '2025-10-31 14:44:00'),
(32, 'awdqweqwe', 'ewqeq', NULL, '[\"uploads\\/events\\/32_1761756421_0.jpeg\"]', NULL, '2025-10-30 00:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `forum_messages`
--

CREATE TABLE `forum_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(50) NOT NULL,
  `message` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE `security_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_officials`
--

CREATE TABLE `sk_officials` (
  `id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_officials`
--

INSERT INTO `sk_officials` (`id`, `position`, `name`, `contact`, `email`, `age`, `address`, `image`, `start_date`, `image_path`, `status`, `date_created`, `date_updated`) VALUES
(1, 'chairman', 'Chaer U kiwoe', '0917-123-4567', 'chairman@sk.gov.ph', NULL, NULL, 'uploads/sk_officials/chairman_1759135217.jpg', NULL, '../../uploads/sk_officials/sk_official_68da3e082365b.jpg', 'active', '2025-09-26 04:15:44', '2025-10-29 23:49:41'),
(2, 'secretary', 'Maria Santos', '0918-234-5678', 'secretary@sk.gov.ph', NULL, NULL, 'uploads/sk_officials/secretary_1759135974.jpg', NULL, '../../assets/images/sk_officials/secretary.svg', 'active', '2025-09-26 04:15:44', '2025-09-29 16:52:54'),
(3, 'treasurer', 'Pedro Garcia', '0919-345-6789', 'treasurer@sk.gov.ph', 24, 'Purok 3, Sitio Maligaya', NULL, '2024-01-15', '../../assets/images/sk_officials/treasurer.svg', 'active', '2025-09-26 04:15:44', '2025-09-29 15:50:24'),
(4, 'kagawad1', 'Anna Reyes', '0920-456-7890', 'anna@sk.gov.ph', 22, 'Phase 2, Block 1, Lot 10', NULL, '2024-01-15', '../../assets/images/sk_officials/kagawad.svg', 'active', '2025-09-26 04:15:44', '2025-09-29 15:50:24'),
(5, 'kagawad2', 'Carlos Lopez', '0921-567-8901', 'carlos@sk.gov.ph', 26, 'Purok 1, Sitio Bagong Silang', NULL, '2024-01-15', '../../assets/images/sk_officials/kagawad.svg', 'active', '2025-09-26 04:15:44', '2025-09-29 15:50:24'),
(6, 'kagawad3', 'Sofia Martinez', '0922-678-9012', 'sofia@sk.gov.ph', 21, 'Phase 3, Block 5, Lot 8', NULL, '2024-01-15', '../../assets/images/sk_officials/kagawad.svg', 'active', '2025-09-26 04:15:44', '2025-09-29 15:50:24'),
(7, 'kagawad4', 'Miguel Torres', '0923-789-0123', 'miguel@sk.gov.ph', 27, 'Purok 2, Sitio San Roque', NULL, '2024-01-15', '../../assets/images/sk_officials/kagawad.svg', 'active', '2025-09-26 04:15:44', '2025-09-29 15:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'YOUTH INFORMATION SYSTEM OF MAGUILLING, PIAT, CAGAYAN'),
(6, 'short_name', 'YISPC- PHP'),
(11, 'logo', 'uploads/logo.png?v=1653957857'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1653957858'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@musicschool.com'),
(20, 'address', 'Here St, Down There City, Anywhere Here, 2306 -updated');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `zone` int(1) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(3) NOT NULL,
  `sex` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `security_question`, `security_answer`, `avatar`, `qr_code`, `last_login`, `type`, `status`, `date_added`, `date_updated`, `zone`, `birthdate`, `age`, `sex`) VALUES
(1, 'Donny', '', 'Pangilinan', 'admin', '7488e331b8b64e5794da3fa4eb10ad5d', 'pet', 'admin', 'uploads/avatars/1.png?v=1649834664', 'PMS-USER-00001-ADMIN-6ab0e8d0', NULL, 1, 1, '2021-01-20 14:02:37', '2025-08-08 15:14:26', 0, NULL, 0, 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement_list`
--
ALTER TABLE `announcement_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`event_id`,`user_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_user_unique` (`event_id`,`user_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `scanner_user_id` (`scanner_user_id`);

--
-- Indexes for table `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_messages`
--
ALTER TABLE `forum_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sk_officials`
--
ALTER TABLE `sk_officials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_position` (`position`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `announcement_list`
--
ALTER TABLE `announcement_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `forum_messages`
--
ALTER TABLE `forum_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sk_officials`
--
ALTER TABLE `sk_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `event_attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_attendance_ibfk_3` FOREIGN KEY (`scanner_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `forum_messages`
--
ALTER TABLE `forum_messages`
  ADD CONSTRAINT `forum_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD CONSTRAINT `security_questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
