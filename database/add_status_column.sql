-- Add status column to users table
-- This script adds a status column to track active/deactivated users

ALTER TABLE `users` ADD COLUMN `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Deactivated' AFTER `type`;

-- Update existing users to be active by default
UPDATE `users` SET `status` = 1 WHERE `status` IS NULL OR `status` = 0;

-- Optional: Add index for better performance
ALTER TABLE `users` ADD INDEX `idx_status` (`status`);
