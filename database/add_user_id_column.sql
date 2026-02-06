-- Add user_id column to job_applications table
ALTER TABLE job_applications ADD COLUMN user_id INT(11) NULL AFTER cover_letter;

-- Add foreign key constraint (optional but recommended)
-- ALTER TABLE job_applications ADD CONSTRAINT fk_applications_user 
-- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;
