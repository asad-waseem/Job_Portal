-- Delete all users from database
DELETE FROM users;

-- Reset auto-increment for users table
ALTER TABLE users AUTO_INCREMENT = 1;
