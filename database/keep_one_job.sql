-- Delete all jobs except one (keeping job ID 39 - Software Developer)
DELETE FROM jobs WHERE id != 39;

-- Reset auto-increment for jobs table
ALTER TABLE jobs AUTO_INCREMENT = 40;
