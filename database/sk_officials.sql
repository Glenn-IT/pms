-- Table structure for SK Officials
CREATE TABLE `sk_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` enum('Chairman', 'Councilor') NOT NULL,
  `zone` varchar(100) NOT NULL,
  `age` int(3) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default SK officials (1 Chairman + 7 Councilors)
INSERT INTO `sk_officials` (`name`, `position`, `zone`, `age`, `contact`, `image`) VALUES
('John Doe', 'Chairman', 'Zone 1', 25, '09123456789', NULL),
('Jane Smith', 'Councilor', 'Zone 1', 22, '09234567890', NULL),
('Mike Johnson', 'Councilor', 'Zone 2', 24, '09345678901', NULL),
('Sarah Wilson', 'Councilor', 'Zone 3', 23, '09456789012', NULL),
('David Brown', 'Councilor', 'Zone 4', 26, '09567890123', NULL),
('Lisa Garcia', 'Councilor', 'Zone 5', 21, '09678901234', NULL),
('Robert Miller', 'Councilor', 'Zone 6', 25, '09789012345', NULL),
('Emily Davis', 'Councilor', 'Zone 7', 22, '09890123456', NULL);
