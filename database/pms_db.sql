-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 10:37 PM
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
-- Table structure for table `action_list`
--

CREATE TABLE `action_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `action_list`
--

INSERT INTO `action_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Solitary Confinement', 1, 0, '2022-05-31 11:56:31', '2022-05-31 11:56:31'),
(2, 'Infirmary Confinement', 1, 0, '2022-05-31 11:58:03', '2022-05-31 11:58:03'),
(3, 'Transported for Trial', 1, 0, '2022-05-31 11:59:14', '2022-05-31 11:59:14'),
(4, 'test - updated', 1, 1, '2022-05-31 11:59:34', '2022-05-31 11:59:49');

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
(10, 'Sample A', 'uploads/announcements/10_1.png', '[\"uploads/announcements/10_1.png\",\"uploads/announcements/10_2.png\",\"uploads/announcements/10_3.png\",\"uploads/announcements/10_4.png\",\"uploads/announcements/10_5.png\"]', 'qwewqe', '2025-08-15 11:54:31'),
(11, 'Sample B', 'uploads/announcements/11_1.jpg', '[\"uploads/announcements/11_1.jpg\",\"uploads/announcements/11_2.jpg\",\"uploads/announcements/11_3.jpg\",\"uploads/announcements/11_4.jpg\",\"uploads/announcements/11_5.jpg\"]', 'Sample', '2025-08-15 11:54:58');

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
-- Table structure for table `cell_list`
--

CREATE TABLE `cell_list` (
  `id` int(30) NOT NULL,
  `prison_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cell_list`
--

INSERT INTO `cell_list` (`id`, `prison_id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 1, 'Block 1 Cell 1001', 1, 0, '2022-05-31 09:16:32', '2022-05-31 09:16:32'),
(2, 1, 'Block 1 Cell 1002', 1, 0, '2022-05-31 09:17:07', '2022-05-31 09:17:07'),
(3, 1, 'Block 1 Cell 1003', 1, 0, '2022-05-31 09:17:18', '2022-05-31 09:17:18'),
(4, 1, 'Block 1 Cell 1004', 1, 0, '2022-05-31 09:17:25', '2022-05-31 09:17:25'),
(5, 1, 'Block 2 Cell 1001', 1, 0, '2022-05-31 09:17:34', '2022-05-31 09:17:34'),
(6, 1, 'Block 2 Cell 1002', 1, 0, '2022-05-31 09:17:43', '2022-05-31 09:17:43'),
(7, 1, 'Block 2 Cell 1003', 1, 0, '2022-05-31 09:17:52', '2022-05-31 09:17:52'),
(8, 1, 'Block 2 Cell 1004', 1, 0, '2022-05-31 09:17:58', '2022-05-31 09:17:58'),
(9, 1, 'Block 3 Cell 1001', 1, 0, '2022-05-31 09:18:07', '2022-05-31 09:18:07'),
(10, 1, 'Block 3 Cell 1002', 1, 0, '2022-05-31 09:18:16', '2022-05-31 09:18:16'),
(11, 1, 'Block 3 Cell 1003', 1, 0, '2022-05-31 09:18:26', '2022-05-31 09:18:26'),
(12, 2, 'Block 1 Cell 1001', 1, 0, '2022-05-31 09:18:36', '2022-05-31 09:18:36'),
(13, 2, 'Block 1 Cell 1002', 1, 0, '2022-05-31 09:18:41', '2022-05-31 09:18:41'),
(14, 2, 'Block 1 Cell 1003', 1, 0, '2022-05-31 09:18:49', '2022-05-31 09:18:49'),
(15, 2, 'Block 1 Cell 1004', 1, 0, '2022-05-31 09:18:55', '2022-05-31 09:18:55'),
(16, 2, 'test - updated', 0, 1, '2022-05-31 09:19:06', '2022-05-31 09:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `crime_list`
--

CREATE TABLE `crime_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crime_list`
--

INSERT INTO `crime_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Robbery', 1, 0, '2022-05-31 09:25:05', '2022-05-31 09:25:05'),
(2, 'Homicide', 1, 0, '2022-05-31 09:25:13', '2022-05-31 09:25:13'),
(3, 'Murder', 1, 0, '2022-05-31 09:25:20', '2022-05-31 09:25:20'),
(4, 'Attempted Murder', 1, 0, '2022-05-31 09:25:34', '2022-05-31 09:25:34'),
(5, 'Child Abuse', 1, 0, '2022-05-31 09:26:14', '2022-05-31 09:26:14'),
(6, 'Fraud', 1, 0, '2022-05-31 09:26:33', '2022-05-31 09:26:33'),
(7, 'Rape', 1, 0, '2022-05-31 09:26:57', '2022-05-31 09:26:57'),
(8, 'Sexual Assult', 1, 0, '2022-05-31 09:27:06', '2022-05-31 09:27:06'),
(9, 'Terrorism', 1, 0, '2022-05-31 09:27:26', '2022-05-31 09:27:26'),
(10, 'Stalking and Harassment', 1, 0, '2022-05-31 09:27:43', '2022-05-31 09:28:15');

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

--
-- Dumping data for table `event_attendance`
--

INSERT INTO `event_attendance` (`id`, `event_id`, `user_id`, `qr_code`, `scan_time`, `status`, `scanner_user_id`) VALUES
(38, 27, 28, 'PMS-USER-00028-SAMPLE A-887fcc39', '2025-09-15 18:32:22', 'present', 1),
(39, 27, 29, 'PMS-USER-00029-SAMPLE B-365e407a', '2025-09-15 18:32:26', 'present', 1),
(40, 27, 30, 'PMS-USER-00030-SAMPLE C-f5622689', '2025-09-15 18:32:32', 'present', 1),
(41, 26, 32, 'PMS-USER-00032-SAMPLE_E-d87f48da', '2025-09-15 18:32:55', 'present', 1),
(42, 26, 33, 'PMS-USER-00033-SAMPLE_F-a9336fa1', '2025-09-15 18:33:00', 'present', 1),
(43, 26, 30, 'PMS-USER-00030-SAMPLE C-f5622689', '2025-09-15 18:33:07', 'present', 1),
(44, 26, 29, 'PMS-USER-00029-SAMPLE B-365e407a', '2025-09-15 18:33:10', 'present', 1),
(45, 27, 39, 'PMS-USER-00039-CRISTEL-85843dfb', '2025-09-15 18:34:38', 'present', 1),
(46, 26, 39, 'PMS-USER-00039-CRISTEL-85843dfb', '2025-09-15 18:34:46', 'present', 1),
(47, 25, 39, 'PMS-USER-00039-CRISTEL-85843dfb', '2025-09-15 18:34:54', 'present', 1);

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
(25, 'Sample A', 'Sample', NULL, '[\"uploads\\/events\\/25_1757932272_0.png\"]', NULL, '2025-09-15 18:31:00'),
(26, 'Sample B', 'Sample B', NULL, '[\"uploads\\/events\\/26_1757932295_0.jpg\"]', NULL, '2025-09-15 18:31:00'),
(27, 'Sample C', 'Sample C', NULL, '[\"uploads\\/events\\/27_1757932313_0.png\"]', NULL, '2025-09-15 18:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `inmate_crimes`
--

CREATE TABLE `inmate_crimes` (
  `inmate_id` int(30) NOT NULL,
  `crime_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inmate_crimes`
--

INSERT INTO `inmate_crimes` (`inmate_id`, `crime_id`) VALUES
(1, 6),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inmate_list`
--

CREATE TABLE `inmate_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `sex` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `marital_status` varchar(250) NOT NULL,
  `eye_color` text NOT NULL,
  `complexion` text NOT NULL,
  `cell_id` int(11) NOT NULL,
  `sentence` text NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date DEFAULT NULL,
  `emergency_name` text DEFAULT NULL,
  `emergency_contact` text DEFAULT NULL,
  `emergency_relation` text DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `visiting_privilege` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inmate_list`
--

INSERT INTO `inmate_list` (`id`, `code`, `firstname`, `middlename`, `lastname`, `sex`, `dob`, `address`, `marital_status`, `eye_color`, `complexion`, `cell_id`, `sentence`, `date_from`, `date_to`, `emergency_name`, `emergency_contact`, `emergency_relation`, `image_path`, `status`, `visiting_privilege`, `date_created`, `date_updated`) VALUES
(1, '6231415', 'John', 'D', 'Smith', 'Male', '1990-06-23', 'Sample Address only', 'Married', 'Brown', 'Fair', 1, '2 Year', '2022-05-31', '2024-05-31', 'Will Smith', '09654123987', 'Brother', 'uploads/inmates/1.png?v=1653966405', 1, 1, '2022-05-31 11:06:45', '2022-05-31 14:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `prison_list`
--

CREATE TABLE `prison_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prison_list`
--

INSERT INTO `prison_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Men&#039;s Prison', 1, 0, '2022-05-31 09:03:13', '2022-05-31 09:03:13'),
(2, 'Women&#039;s Prison', 1, 0, '2022-05-31 09:03:23', '2022-05-31 09:03:23'),
(3, 'Test - updated', 0, 1, '2022-05-31 09:03:31', '2022-05-31 09:03:45');

-- --------------------------------------------------------

--
-- Table structure for table `record_list`
--

CREATE TABLE `record_list` (
  `id` int(30) NOT NULL,
  `inmate_id` int(30) NOT NULL,
  `action_id` int(30) NOT NULL,
  `remarks` text NOT NULL,
  `date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_list`
--

INSERT INTO `record_list` (`id`, `inmate_id`, `action_id`, `remarks`, `date`, `date_created`, `date_updated`) VALUES
(1, 1, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eget ante et lacus mollis euismod ut pellentesque nisl. Mauris at elit at dui tempor hendrerit.', '2022-05-27', '2022-05-31 13:19:24', '2022-05-31 13:28:46'),
(2, 1, 2, 'Fusce porta pharetra massa, id congue dolor suscipit vel. Praesent id interdum risus. Mauris scelerisque urna massa, eget fringilla mi condimentum vel.', '2022-05-31', '2022-05-31 13:26:22', '2022-05-31 13:26:22');

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
  `start_date` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_officials`
--

INSERT INTO `sk_officials` (`id`, `position`, `name`, `contact`, `email`, `age`, `address`, `start_date`, `status`, `date_created`, `date_updated`) VALUES
(1, 'chairman', 'juju', '0917-123-4567', 'chairman@sk.gov.ph', 25, 'Barangay Hall, Main Street', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:20:10'),
(2, 'secretary', 'Maria Santos', '0918-234-5678', 'secretary@sk.gov.ph', 23, 'Phase 1, Block 2, Lot 5', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:15:44'),
(3, 'treasurer', 'Pedro Garcia', '0919-345-6789', 'treasurer@sk.gov.ph', 24, 'Purok 3, Sitio Maligaya', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:15:44'),
(4, 'kagawad1', 'Anna Reyes', '0920-456-7890', 'anna@sk.gov.ph', 22, 'Phase 2, Block 1, Lot 10', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:15:44'),
(5, 'kagawad2', 'Carlos Lopez', '0921-567-8901', 'carlos@sk.gov.ph', 26, 'Purok 1, Sitio Bagong Silang', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:15:44'),
(6, 'kagawad3', 'Sofia Martinez', '0922-678-9012', 'sofia@sk.gov.ph', 21, 'Phase 3, Block 5, Lot 8', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:15:44'),
(7, 'kagawad4', 'Miguel Torres', '0923-789-0123', 'miguel@sk.gov.ph', 27, 'Purok 2, Sitio San Roque', '2024-01-15', 'active', '2025-09-26 04:15:44', '2025-09-26 04:15:44');

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
(1, 'Donny', '', 'Pangilinan', 'admin', '7488e331b8b64e5794da3fa4eb10ad5d', 'pet', 'admin', 'uploads/avatars/1.png?v=1649834664', 'PMS-USER-00001-ADMIN-6ab0e8d0', NULL, 1, 1, '2021-01-20 14:02:37', '2025-08-08 15:14:26', 0, NULL, 0, 'Male'),
(28, 'Lincoln', 'Gude', 'Soper', 'sample A', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00028-SAMPLE A-887fcc39', NULL, 2, 1, '2025-08-08 19:20:58', '2025-08-10 19:23:44', 1, '2000-02-02', 25, 'Male'),
(29, 'Kule', 'Lopus', 'Skuer', 'Sample B', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00029-SAMPLE B-365e407a', NULL, 2, 1, '2025-08-08 19:21:35', '2025-08-08 19:21:35', 2, '2001-01-05', 24, 'Female'),
(30, 'Kuuso', 'Jute', 'Slop', 'Sample C', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00030-SAMPLE C-f5622689', NULL, 2, 1, '2025-08-08 19:22:17', '2025-08-08 19:22:17', 3, '2003-03-02', 22, 'Male'),
(31, 'Lopeu', 'Kold', 'Suer', 'Sample D', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00031-SAMPLE_D-14423dce', NULL, 2, 1, '2025-08-08 19:23:06', '2025-08-31 11:06:00', 4, '1996-05-05', 29, 'Female'),
(32, 'Kikusu', 'Kosp', 'Posi', 'Sample E', '6abfd646c3d31cde591bf4eb4fddc296', 'pet', 'sample', NULL, 'PMS-USER-00032-SAMPLE_E-d87f48da', NULL, 2, 1, '2025-08-08 19:37:54', '2025-09-11 10:16:08', 2, '2005-09-06', 19, 'Female'),
(33, 'Kkols', 'Iolw', 'Loper', 'Sample F', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00033-SAMPLE_F-a9336fa1', NULL, 2, 1, '2025-08-08 22:37:37', '2025-08-08 22:37:37', 5, '2008-05-30', 17, 'Female'),
(34, 'Slowp', 'U', 'Soper', 'Sample X', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00034-SAMPLE_X-7288e467', NULL, 2, 0, '2025-08-10 19:44:07', '2025-09-12 11:36:49', 1, '1994-08-11', 30, 'Male'),
(39, 'Cristel', 'Ldiwk', 'Pulig', 'Cristel', '6abfd646c3d31cde591bf4eb4fddc296', 'pet', 'Sample12345', 'uploads/avatars/39.png?v=1757931504', 'PMS-USER-00039-CRISTEL-85843dfb', NULL, 2, 1, '2025-09-12 11:53:58', '2025-09-15 18:18:24', 6, '2001-01-01', 24, 'Female'),
(40, 'Sample ', 's', 'Uno', 'Sample Uno', '6abfd646c3d31cde591bf4eb4fddc296', 'pet', 'Sample12345', NULL, 'PMS-USER-00040-SAMPLE_U-e7fc386d', NULL, 2, 1, '2025-09-26 03:08:32', '2025-09-26 03:08:32', 1, '2001-01-01', 24, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `visit_list`
--

CREATE TABLE `visit_list` (
  `id` int(30) NOT NULL,
  `inmate_id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `relation` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visit_list`
--

INSERT INTO `visit_list` (`id`, `inmate_id`, `fullname`, `contact`, `relation`, `date_created`, `date_updated`) VALUES
(1, 1, 'Claire Blake', '09456213879', 'Fiance', '2022-05-31 14:43:13', '2022-05-31 14:43:13'),
(2, 1, 'Will Smith', '09456123123', 'Father', '2022-05-31 14:51:11', '2022-05-31 14:51:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_list`
--
ALTER TABLE `action_list`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `cell_list`
--
ALTER TABLE `cell_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prison_id` (`prison_id`);

--
-- Indexes for table `crime_list`
--
ALTER TABLE `crime_list`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `inmate_crimes`
--
ALTER TABLE `inmate_crimes`
  ADD KEY `inmate_id` (`inmate_id`),
  ADD KEY `crime_id` (`crime_id`);

--
-- Indexes for table `inmate_list`
--
ALTER TABLE `inmate_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cell_id` (`cell_id`);

--
-- Indexes for table `prison_list`
--
ALTER TABLE `prison_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `record_list`
--
ALTER TABLE `record_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inmate_id` (`inmate_id`),
  ADD KEY `action_id` (`action_id`);

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
-- Indexes for table `visit_list`
--
ALTER TABLE `visit_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inmate_id` (`inmate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_list`
--
ALTER TABLE `action_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `announcement_list`
--
ALTER TABLE `announcement_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cell_list`
--
ALTER TABLE `cell_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `crime_list`
--
ALTER TABLE `crime_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `inmate_list`
--
ALTER TABLE `inmate_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prison_list`
--
ALTER TABLE `prison_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `record_list`
--
ALTER TABLE `record_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `visit_list`
--
ALTER TABLE `visit_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cell_list`
--
ALTER TABLE `cell_list`
  ADD CONSTRAINT `prison_id_fk_cl` FOREIGN KEY (`prison_id`) REFERENCES `cell_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `event_attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_attendance_ibfk_3` FOREIGN KEY (`scanner_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inmate_crimes`
--
ALTER TABLE `inmate_crimes`
  ADD CONSTRAINT `crime_id_fk_ic` FOREIGN KEY (`crime_id`) REFERENCES `crime_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `inmate_id_fk_ic` FOREIGN KEY (`inmate_id`) REFERENCES `inmate_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `inmate_list`
--
ALTER TABLE `inmate_list`
  ADD CONSTRAINT `cell_id_fk_il` FOREIGN KEY (`cell_id`) REFERENCES `cell_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `record_list`
--
ALTER TABLE `record_list`
  ADD CONSTRAINT `action_id_fk_rl` FOREIGN KEY (`action_id`) REFERENCES `action_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `inmate_id_fk_rl` FOREIGN KEY (`inmate_id`) REFERENCES `inmate_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD CONSTRAINT `security_questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visit_list`
--
ALTER TABLE `visit_list`
  ADD CONSTRAINT `inmate_id_fk_vl` FOREIGN KEY (`inmate_id`) REFERENCES `inmate_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
