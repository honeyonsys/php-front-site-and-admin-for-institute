-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 06:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `date` varchar(100) NOT NULL,
  `attendance` int(10) NOT NULL COMMENT '0 = absent, 1 = present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `date`, `attendance`) VALUES
(1, 1, '13-04-2023', 0),
(2, 2, '13-04-2023', 1),
(3, 2, '14-04-2023', 1),
(4, 3, '14-04-2023', 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='college upcoming events can save in this table';

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`) VALUES
(1, 'dance show', 'Dance show happen in april', '26-Apr-2023'),
(2, 'Hackathon ...', 'Hackathon for creating prject for govt ....', '18-Apr-2023'),
(4, 'New practical submission will happen soon', 'Practical submission date will be between 20-25', '28-Apr-2023');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL COMMENT '0 = article, 1 = notice',
  `category_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `author` int(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `category_name`, `title`, `body`, `author`, `created_at`) VALUES
(1, 0, '', 'replaced title', 'replaced ', 1, ''),
(4, 0, '', '', '', 0, '2023-04-15 07:01:16'),
(5, 0, '', 'test 1', 'this is anoher test', 1, '2023-04-15 07:02:17'),
(6, 0, '', 'Practical and Viva Scheduled', 'content for test 3', 1, '2023-04-15 07:04:58'),
(7, 0, '', 'College students wins hackathon', 'Our college students win hackathon competition which was held in ludhiana punjab', 1, '2023-04-15 07:07:18'),
(8, 0, '', 'College Results', 'The results for the semester 5,6 will announce on April 31. Students can check for their results on college&#039;s official website.', 1, '2023-04-15 07:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `courseId` int(100) NOT NULL,
  `createdOn` varchar(255) NOT NULL,
  `updatedOn` varchar(255) NOT NULL,
  `status` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(10) NOT NULL COMMENT '"0":student, "1": admin, "2": teacher',
  `token` text NOT NULL,
  `tokenExpire` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `dob`, `phone`, `address`, `courseId`, `createdOn`, `updatedOn`, `status`, `email`, `password`, `type`, `token`, `tokenExpire`) VALUES
(1, 'Shahrukh Khan', '02-10-1965', '787866776', 'zuhu, Mumbai', 2, '2323-0303-2828 0606:0303:5656', '2323-0303-2828 0606:0303:5656', 0, 'shahrukhkhan@gmail.com', '546be2d0f627ffda0501df03acf8094f', 0, '', 0),
(2, 'Harish KUmar', '02-10-1965', '787866776', 'zuhu, Mumbai', 2, '2323-0303-2828 0606:0303:3939', '2323-0303-2828 0606:0303:3939', 0, 'honeyonsys@gmail.com', '251800da8d338eb82819105d5f3c7629', 0, 'aG9uZXlvbnN5c0BnbWFpbC5jb20sMTY4MTcxMDUyMA==', 1681710520),
(3, 'Salman Khan', '02-10-1965', '787866776', 'zuhu, Mumbai', 2, '2323-0303-2828 1313:0303:1010', '2323-0303-2828 1313:0303:1010', 0, 'salmankhan@gmail.com', '44cd16be6350304f1853d6061acf6ed7', 0, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
