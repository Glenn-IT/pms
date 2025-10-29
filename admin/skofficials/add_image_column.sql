-- Add image column to sk_officials table
ALTER TABLE `sk_officials` ADD COLUMN `image` varchar(255) DEFAULT NULL AFTER `address`;
