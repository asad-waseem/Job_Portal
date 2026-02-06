-- Testimonials/Reviews Table
-- Run this SQL in phpMyAdmin to create the testimonials table

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `rating` int(1) NOT NULL DEFAULT 5,
  `avatar_color` varchar(20) DEFAULT 'primary',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert some default testimonials
INSERT INTO `testimonials` (`name`, `profession`, `review`, `rating`, `avatar_color`, `is_active`) VALUES
('Sarah Williams', 'Software Developer', 'This platform made my job search so much easier! I found my ideal position within a week. The interface is clean and the application process is straightforward.', 5, 'primary', 1),
('Michael Johnson', 'Marketing Manager', 'Excellent service! The variety of jobs available is impressive. I was able to filter by location and industry, which saved me a lot of time. Highly recommend!', 5, 'success', 1),
('Emily Davis', 'Graphic Designer', 'The best job portal I''ve used! The user profile feature is great, and applying to jobs is seamless. Found my dream job thanks to this platform.', 5, 'info', 1);
