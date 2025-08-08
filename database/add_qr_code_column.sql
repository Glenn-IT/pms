-- Add QR Code column to users table
-- Run this SQL query to add the QR code functionality

ALTER TABLE `users` ADD COLUMN `qr_code` TEXT NULL AFTER `avatar`;

-- Create uploads/qrcodes directory (this will be done programmatically)
-- Make sure to create the directory: uploads/qrcodes/ with proper permissions
