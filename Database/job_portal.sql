-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2020 at 03:44 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `selected` varchar(255) NOT NULL,
  `newfromseeker` int(11) NOT NULL,
  `newfromprovider` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `jobid`, `username`, `selected`, `newfromseeker`, `newfromprovider`, `message`) VALUES
(9, 27, 'Sabita', 'Approved', 2, 1, 'We select you'),
(10, 30, 'Sabita', 'Approved', 2, 2, 'Congrats! Please come for interview\r\n'),
(11, 30, 'blanc', 'Rejected', 2, 2, 'Sorry!!'),
(12, 31, 'blanc', 'Pending', 1, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(255) NOT NULL,
  `recruiter` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `newfromadmin` int(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `recruiter`, `title`, `status`, `salary`, `email`, `location`, `newfromadmin`, `username`) VALUES
(23, 'Blank', 'Teacher', 'Rejected', 'Negotiable', 'blancmanandhar@gmail.com', 'Bafal', 0, 'sanilm'),
(25, 'Blank', 'Program', 'Rejected', '20000', '123@gmail.com', '123', 1, 'sanilm'),
(26, 'Sabita', 'Teach', 'Rejected', '10000', '123@gmail.com', '123', 2, 'sanilm'),
(27, 'Rabindra', '123', 'Approved', '123', '123@gmail.com', '123', 2, 'sanilm'),
(30, 'Sanil', 'Hero', 'Approved', '20000', 'asdas@gmail.com', '123', 1, 'sanilm'),
(31, 'Blank', 'Tamer', 'Approved', '123', '123@gmail.com', 'Tahachal', 2, 'sanilm');

-- --------------------------------------------------------

--
-- Table structure for table `seekerdetails`
--

CREATE TABLE `seekerdetails` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seekerdetails`
--

INSERT INTO `seekerdetails` (`id`, `username`, `name`, `cv`, `address`, `email`) VALUES
(4, 'blanc', 'Blanc Shakya', 'uploads/blanc.pdf', 'Bafal', 'blankmanandhar@gmail.com'),
(5, 'Sabita', 'Sabita', 'uploads/Sabita.pdf', 'Bafal', 'manandharsabita3@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `token` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `accounttype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `verified`, `token`, `password`, `accounttype`) VALUES
(36, 'sanilm', 'sanilmanandhar@gmail.com', 1, '61f1ddfdf09fd24c7ecbf94bfd1596041c6b8ca1185e38b3d3e5eef285ffbb39793960497f29900f57c12314f6f638297a6e', '$2y$10$axO12/IBxMZk.9xxrFE.s.h0qLwxP3UYN7S7Lm0AU7wL01uUO2H0C', 'provider'),
(37, 'blanc', 'blancmanandhar@gmail.com', 1, '01bbf60e7e9cdc6d78e56084bad989176d00350ce965513ebe1dc3e9f540be76d6294a067af4d914893136d78f40579c08a9', '$2y$10$an3tPDuFyWN55QNzFx0JUu22GP2HL2HCwk7xCJtR4W/c4xJ4w7Hai', 'seeker'),
(38, 'Sabita', 'manandharsabita3@gmail.com', 1, '65e18d3c10f0abf69c4fe73142a6b87c57315849c48efc753e10e3f8721f3097ccd9063cc6fd297abd9f75a168e56b1b64d4', '$2y$10$PnaAnX0nbsapC/FISfjCae6HwHSqOJi92HJXn6curM0.m6QGyG/Ci', 'seeker');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seekerdetails`
--
ALTER TABLE `seekerdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `seekerdetails`
--
ALTER TABLE `seekerdetails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
