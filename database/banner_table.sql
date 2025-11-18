-- SQL for Banner Management Feature
-- Add this to your database

-- Create banner_list table
CREATE TABLE IF NOT EXISTS `banner_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `date_created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add some indexes for better performance
ALTER TABLE `banner_list` ADD INDEX `idx_status` (`status`);
ALTER TABLE `banner_list` ADD INDEX `idx_date_created` (`date_created`);
