-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 04:26 PM
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
  `description` text DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_list`
--

INSERT INTO `announcement_list` (`id`, `title`, `image_path`, `description`, `date_created`) VALUES
(7, 'Sample Announcement B', 'uploads/announcements/7.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus sit amet dolor sit amet rutrum. Suspendisse mattis, elit in sagittis ultrices, enim dui tincidunt dui, et congue metus velit et erat. Nam bibendum ex risus, vel egestas sapien pharetra eget. Sed libero metus, feugiat eu arcu a, consectetur volutpat augue. Mauris blandit risus sit amet ex feugiat, vel dignissim tortor congue. Pellentesque blandit mauris ac tortor vulputate, eget mattis ligula interdum. Nullam varius, eros vitae molestie commodo, dui nisl suscipit ipsum, eu lacinia risus magna sed lectus.', '2025-08-08 19:16:51'),
(8, 'Sample Announcement A', 'uploads/announcements/8.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus sit amet dolor sit amet rutrum. Suspendisse mattis, elit in sagittis ultrices, enim dui tincidunt dui, et congue metus velit et erat. Nam bibendum ex risus, vel egestas sapien pharetra eget. Sed libero metus, feugiat eu arcu a, consectetur volutpat augue. Mauris blandit risus sit amet ex feugiat, vel dignissim tortor congue. Pellentesque blandit mauris ac tortor vulputate, eget mattis ligula interdum. Nullam varius, eros vitae molestie commodo, dui nisl suscipit ipsum, eu lacinia risus magna sed lectus.', '2025-08-08 19:17:13'),
(9, 'Sample Announcement C', 'uploads/announcements/9.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus sit amet dolor sit amet rutrum. Suspendisse mattis, elit in sagittis ultrices, enim dui tincidunt dui, et congue metus velit et erat. Nam bibendum ex risus, vel egestas sapien pharetra eget. Sed libero metus, feugiat eu arcu a, consectetur volutpat augue. Mauris blandit risus sit amet ex feugiat, vel dignissim tortor congue. Pellentesque blandit mauris ac tortor vulputate, eget mattis ligula interdum. Nullam varius, eros vitae molestie commodo, dui nisl suscipit ipsum, eu lacinia risus magna sed lectus.', '2025-08-08 19:17:46');

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
(10, 8, 33, 'PMS-USER-00033-SAMPLE_F-a9336fa1', '2025-08-09 11:43:33', 'present', 1),
(11, 8, 32, 'PMS-USER-00032-SAMPLE_E-d87f48da', '2025-08-09 11:43:42', 'present', 1),
(12, 8, 31, 'PMS-USER-00031-SAMPLE D-177120fe', '2025-08-09 11:43:49', 'present', 1),
(13, 8, 30, 'PMS-USER-00030-SAMPLE C-f5622689', '2025-08-09 11:43:52', 'present', 1),
(14, 8, 29, 'PMS-USER-00029-SAMPLE B-365e407a', '2025-08-09 11:43:57', 'present', 1),
(15, 8, 28, 'PMS-USER-00028-SAMPLE A-887fcc39', '2025-08-09 11:44:01', 'present', 1),
(16, 9, 32, 'PMS-USER-00032-SAMPLE_E-d87f48da', '2025-08-10 17:59:07', 'present', 1),
(17, 9, 31, 'PMS-USER-00031-SAMPLE D-177120fe', '2025-08-10 17:59:15', 'present', 1),
(18, 9, 30, 'PMS-USER-00030-SAMPLE C-f5622689', '2025-08-10 17:59:26', 'present', 1),
(19, 9, 29, 'PMS-USER-00029-SAMPLE B-365e407a', '2025-08-10 18:00:14', 'present', 1),
(20, 11, 32, 'PMS-USER-00032-SAMPLE_E-d87f48da', '2025-08-10 18:43:54', 'present', 1);

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
(8, 'Sample Event B', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus sit amet dolor sit amet rutrum. Suspendisse mattis, elit in sagittis ultrices, enim dui tincidunt dui, et congue metus velit et erat. Nam bibendum ex risus, vel egestas sapien pharetra eget. Sed libero metus, feugiat eu arcu a, consectetur volutpat augue. Mauris blandit risus sit amet ex feugiat, vel dignissim tortor congue. Pellentesque blandit mauris ac tortor vulputate, eget mattis ligula interdum. Nullam varius, eros vitae molestie commodo, dui nisl suscipit ipsum, eu lacinia risus magna sed lectus.', NULL, '[\"uploads\\/events\\/8_1754651939_0.png\",\"uploads\\/events\\/8_1754651939_1.png\",\"uploads\\/events\\/8_1754651939_2.png\",\"uploads\\/events\\/8_1754651939_3.png\",\"uploads\\/events\\/8_1754651939_4.png\"]', NULL, '2025-08-09 19:18:00'),
(9, 'Sample Event C', 'Lorem ipsum dolor sit amet, consecteturs adipiscing elit. Maecenas luctus sit amet dolor sit amet rutrum. Suspendisse mattis, elit in sagittis ultrices, enim dui tincidunt dui, et congue metus velit et erat. Nam bibendum ex risus, vel egestas sapien pharetra eget. Sed libero metus, feugiat eu arcu a, consectetur volutpat augue. Mauris blandit risus sit amet ex feugiat, vel dignissim tortor congue. Pellentesque blandit mauris ac tortor vulputate, eget mattis ligula interdum. Nullam varius, eros vitae molestie commodo, dui nisl suscipit ipsum, eu lacinia risus magna sed lectus.', NULL, '[\"uploads\\/events\\/9_1754651958_0.png\",\"uploads\\/events\\/9_1754651958_1.png\",\"uploads\\/events\\/9_1754651958_2.png\",\"uploads\\/events\\/9_1754651958_3.png\",\"uploads\\/events\\/9_1754651958_4.png\"]', NULL, '2025-08-10 11:19:00'),
(10, 'Sample Event D', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus sit amet dolor sit amet rutrum. Suspendisse mattis, elit in sagittis ultrices, enim dui tincidunt dui, et congue metus velit et erat. Nam bibendum ex risus, vel egestas sapien pharetra eget. Sed libero metus, feugiat eu arcu a, consectetur volutpat augue. Mauris blandit risus sit amet ex feugiat, vel dignissim tortor congue. Pellentesque blandit mauris ac tortor vulputate, eget mattis ligula interdum. Nullam varius, eros vitae molestie commodo, dui nisl suscipit ipsum, eu lacinia risus magna sed lectus.', NULL, '[\"uploads\\/events\\/10_1754651989_0.png\",\"uploads\\/events\\/10_1754651989_1.png\",\"uploads\\/events\\/10_1754651989_2.png\",\"uploads\\/events\\/10_1754651989_3.png\",\"uploads\\/events\\/10_1754651989_4.png\"]', NULL, '2025-08-11 19:19:00'),
(11, 'Sample F', 'dawedwaoidbioawd', NULL, '[\"uploads\\/events\\/11_1754822554_0.jpg\",\"uploads\\/events\\/11_1754822554_1.jpg\",\"uploads\\/events\\/11_1754822554_2.jpg\",\"uploads\\/events\\/11_1754822554_3.jpg\",\"uploads\\/events\\/11_1754822554_4.jpg\",\"uploads\\/events\\/11_1754822554_5.jpg\"]', NULL, '2025-08-10 18:42:00');

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
  `name` varchar(255) NOT NULL,
  `position` enum('chairman','councilor') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `zone` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order_position` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_officials`
--

INSERT INTO `sk_officials` (`id`, `name`, `position`, `image_path`, `firstname`, `middlename`, `lastname`, `date_of_birth`, `sex`, `contact`, `email`, `zone`, `status`, `order_position`, `date_created`, `date_updated`) VALUES
(1, '', 'chairman', '1754649960_s036012017.webp', 'Johnawd', 'A.', 'Dela Cruz', '1998-05-15', 'Male', '09123456789', 'john.delacruz@email.com', 'Zone 1', 0, 1, '2025-08-08 18:10:03', '2025-08-08 18:46:56'),
(2, '', 'councilor', NULL, 'Maria', 'B.', 'Santos', '2000-03-20', 'Female', '09987654321', 'maria.santos@email.com', 'Zone 2', 0, 2, '2025-08-08 18:10:03', '2025-08-08 18:47:03'),
(3, '', 'councilor', NULL, 'Jose', 'C.', 'Garcia', '1999-07-10', 'Male', '09111222333', 'jose.garcia@email.com', 'Zone 3', 0, 3, '2025-08-08 18:10:03', '2025-08-08 18:47:02'),
(4, '', 'councilor', NULL, 'Ana', 'D.', 'Rodriguez', '2001-01-25', 'Female', '09444555666', 'ana.rodriguez@email.com', 'Zone 4', 0, 4, '2025-08-08 18:10:03', '2025-08-08 18:46:58'),
(5, '', 'councilor', NULL, 'Miguel', 'E.', 'Lopez', '1997-11-30', 'Male', '09777888999', 'miguel.lopez@email.com', 'Zone 5', 0, 5, '2025-08-08 18:10:03', '2025-08-08 18:47:05'),
(6, '', 'councilor', NULL, 'Carmen', 'F.', 'Martinez', '2000-09-12', 'Female', '09123987456', 'carmen.martinez@email.com', 'Zone 6', 0, 6, '2025-08-08 18:10:03', '2025-08-08 18:47:00'),
(7, '', 'councilor', NULL, 'Pedro', 'G.', 'Gonzalez', '1998-12-05', 'Male', '09654321987', 'pedro.gonzalez@email.com', 'Zone 7', 0, 7, '2025-08-08 18:10:03', '2025-08-08 18:47:07'),
(8, '', 'councilor', NULL, 'Rosa', 'H.', 'Hernandez', '1999-04-18', 'Female', '09321654987', 'rosa.hernandez@email.com', 'Zone 8', 0, 8, '2025-08-08 18:10:03', '2025-08-08 18:47:09'),
(9, '', 'chairman', '1754650080_s036012017.webp', 'Zues', 'Col', 'Cong', '2000-08-08', 'Male', '0998798778', 'awd@gmail.com', 'Zone 1', 1, NULL, '2025-08-08 18:48:10', '2025-08-08 18:48:10'),
(10, '', 'councilor', '1754650080_s036012017.webp', 'Bread', 'Tug', 'Opes', '2000-06-20', 'Female', '09987987987', 'Wd@gmail.com', 'Zone 6', 1, NULL, '2025-08-08 18:48:54', '2025-08-08 18:48:54');

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
(31, 'Lopeu', 'Kold', 'Suer', 'Sample D', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00031-SAMPLE D-177120fe', NULL, 2, 1, '2025-08-08 19:23:06', '2025-08-08 22:43:21', 4, '2004-05-05', 21, 'Female'),
(32, 'Kikusu', 'Kosp', 'Posi', 'Sample E', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00032-SAMPLE_E-d87f48da', NULL, 2, 1, '2025-08-08 19:37:54', '2025-08-08 19:37:54', 2, '2005-09-06', 19, 'Female'),
(33, 'Kkols', 'Iolw', 'Loper', 'Sample F', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00033-SAMPLE_F-a9336fa1', NULL, 2, 1, '2025-08-08 22:37:37', '2025-08-08 22:37:37', 5, '2008-05-30', 17, 'Female'),
(34, 'Slowp', 'U', 'Soper', 'Sample X', '86c8148718b55269a336f9e2c57b4117', 'pet', 'sample', NULL, 'PMS-USER-00034-SAMPLE_X-7288e467', NULL, 2, 1, '2025-08-10 19:44:07', '2025-08-10 20:33:47', 1, '1994-08-11', 30, 'Male');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
