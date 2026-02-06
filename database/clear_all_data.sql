-- Complete database reset script
-- This will delete all users and jobs except one job

-- 1. Delete all users
DELETE FROM users;

-- 2. Delete all jobs except one (keeping job ID 39 - Software Developer)
DELETE FROM jobs WHERE id != 39;

-- 3. Delete all job applications (since users are deleted)
DELETE FROM job_applications;

-- 4. Delete all contact messages (optional - remove if you want to keep these)
DELETE FROM contact_messages;

-- 5. Reset auto-increment values
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE jobs AUTO_INCREMENT = 40;
ALTER TABLE job_applications AUTO_INCREMENT = 1;
ALTER TABLE contact_messages AUTO_INCREMENT = 1;

-- 6. Show what remains
SELECT 'Jobs remaining:' as status;
SELECT * FROM jobs;

SELECT 'Users remaining:' as status;
SELECT * FROM users;
