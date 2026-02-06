-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 10:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `usernames` varchar(44) NOT NULL,
  `passwords` varchar(44) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`usernames`, `passwords`) VALUES
('asad', 'asad');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `full_name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Asad Waseem', 'asadwaseem.tech@gmail.com', 'Complain', 'ok', '2025-06-09 12:49:36'),
(2, 'Asad Waseem', 'asadwaseem.tech@gmail.com', 'Complain', 'ok', '2025-06-09 12:51:04'),
(3, 'Zia Farooqi', 'ziafarooqi@gmail.com', 'job complain', 'I have applied for wordpress job but didnt get any response', '2025-06-11 21:29:19'),
(4, 'Zia Farooqi', 'ziafarooqi@gmail.com', 'job complain', 'I have applied for wordpress job but didnt get any response', '2025-06-11 21:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company`, `location`, `category`, `type`, `description`, `created_at`) VALUES
(39, 'Software Developer', 'Subriz Media', 'Karachi', 'development', 'full-time', 'Urgent Hiring', '2025-06-11 20:30:35'),
(41, 'Software Developer', 'Subriz Media', 'Karachi', 'development', 'full-time', 'Urgent Hiring', '2025-06-11 21:24:02'),
(42, 'Checkssss', 'Check', 'karachi', 'sales', 'part-time', 'Check', '2025-06-14 09:00:34'),
(43, 'php dev', 'hghg', 'Karachi', 'development', 'full-time', 'urgent', '2025-06-14 14:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `resume_link` text NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `first_name`, `last_name`, `email`, `phone`, `position`, `resume_link`, `cover_letter`, `applied_at`, `created_at`) VALUES
(1, 'Asad', 'Waseem', 'asadwaseem.tech@gmail.com', '3122943462', 'Senior PHP Developer', 'http://localhost/Job%20Portal/apply.php?', 'lk,oassan', '2025-06-03 18:42:48', '2025-06-03 19:13:32'),
(2, 'Asad', 'Waseem', 'coreclinik@yahoo.com', '3122943462', 'Senior PHP Developer', 'http://localhost/Job%20Portal/apply.php?', 'sadasdsad', '2025-06-03 18:45:22', '2025-06-03 19:13:32'),
(3, 'Shayan', 'Ahmed', 'shayanahmed@gmail.com', '+923122943462', 'Database Administrator', 'http://localhost/Job%20Portal/apply.php?', 'yes i am the best for data base administrator', '2025-06-05 16:14:36', '2025-06-05 16:14:36'),
(4, 'Asad', 'Waseem', 'asadwaseem.tech@gmail.com', '3122943462', 'Wordpress Developer', 'http://localhost/Job%20Portal/apply.php?', 'sacc', '2025-06-11 16:14:10', '2025-06-11 16:14:10'),
(5, 'Asad', 'Waseem', 'asadwaseem.tech@gmail.com', '3122943462', 'Checkssss', 'http://localhost/Job%20Portal/apply.php?', 'lkAFLA', '2025-06-14 09:02:01', '2025-06-14 09:02:01'),
(6, 'FARAZ', 'BASIT', 'coreclinik@yahoo.com', '3122793316', 'Checkssss', 'http://localhost/Job%20Portal/apply.php?', 'AJLSDKFJ', '2025-06-14 09:02:26', '2025-06-14 09:02:26'),
(7, 'Asad', 'Waseem', 'asadwaseem.tech@gmail.com', '3122943462', 'Checkssss', 'https://drive.google.com/file/d/1EH5HldPQzAswN_h5CvZCUb5khHexMqyV/view?usp=drive_link', 'LSK', '2025-06-14 09:06:39', '2025-06-14 09:06:39'),
(8, 'Asad', 'Waseem', 'asadwaseem.tech@gmail.com', '3122943462', 'hasan ki gaand maro', 'https://drive.google.com/file/d/1EH5HldPQzAswN_h5CvZCUb5khHexMqyV/view?usp=drive_link', 'ok', '2025-06-15 17:42:18', '2025-06-15 17:42:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`) VALUES
(1, 'asadwaseem', 'asadwaseem.tech@gmail.com', 'asad1', 'asad1'),
(2, 'Sabikah', 'sabikah@gmail.com', 'sab', 'sab'),
(3, 'Shayan Waseem', 'shayanwaseem@gmail.com', 'shani', 'shani'),
(4, 'faraz abdul basit', 'faraz@gmail.com', 'faraz', 'faraz'),
(5, 'Rameez Khan', 'rameez@gmail.com', 'rameez', 'rameez'),
(6, 'Zia Farooqi', 'zia@gmail.com', 'zia', 'zia'),
(7, 'hasan', 'hasan@gmail.com', 'hasan', 'hasan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
