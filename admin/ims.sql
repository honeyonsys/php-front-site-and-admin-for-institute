-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2023 at 09:36 AM
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
(1, 0, '', 'some sample title', 'Title of the pagesome content ', 1, ''),
(2, 0, '', 'some sample title', 'Title of the pagesome content ', 1, '23232323-0404-1010 05:22:29'),
(3, 0, '', 'some sample title', 'Title of the pagesome content ', 1, '20232023-04-10 05:23:19');

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
(2, 'Harish KUmar', '02-10-1965', '787866776', 'zuhu, Mumbai', 2, '2323-0303-2828 0606:0303:3939', '2323-0303-2828 0606:0303:3939', 0, 'honeyonsys@gmail.com', '251800da8d338eb82819105d5f3c7629', 0, 'aG9uZXlvbnN5c0BnbWFpbC5jb20sMTY4MTExMTMzMQ==', 1681111331),
(3, 'Salman Khan', '02-10-1965', '787866776', 'zuhu, Mumbai', 2, '2323-0303-2828 1313:0303:1010', '2323-0303-2828 1313:0303:1010', 0, 'salmankhan@gmail.com', '44cd16be6350304f1853d6061acf6ed7', 0, '', 0);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
