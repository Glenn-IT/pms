-- Add images column to announcement_list table for multiple image support
ALTER TABLE `announcement_list` ADD COLUMN `images` TEXT NULL AFTER `image_path`;

-- Update existing announcements to include image_path in images column for backward compatibility
UPDATE `announcement_list` 
SET `images` = CONCAT('[\"', `image_path`, '\"]') 
WHERE `image_path` IS NOT NULL AND `image_path` != '' AND `images` IS NULL;
