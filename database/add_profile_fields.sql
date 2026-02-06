-- Add missing profile fields to users table
ALTER TABLE `users` 
ADD COLUMN `phone` varchar(20) DEFAULT NULL AFTER `password`,
ADD COLUMN `profession` varchar(100) DEFAULT NULL AFTER `phone`,
ADD COLUMN `description` text DEFAULT NULL AFTER `profession`,
ADD COLUMN `address` varchar(255) DEFAULT NULL AFTER `description`;

-- Update existing users with sample data (optional)
-- UPDATE `users` SET 
-- phone = NULL,
-- profession = NULL,
-- description = NULL,
-- address = NULL
-- WHERE phone IS NULL;