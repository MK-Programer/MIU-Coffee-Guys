-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2021 at 05:54 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpoop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `model` varchar(150) NOT NULL,
  `id_admin` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `images` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `model`, `id_admin`, `title`, `description`, `price`, `images`, `created_at`) VALUES
(16, 'House Blend', 1, 'House Blend Milk', '', 10, 'house blend milk.jpeg', '2021-05-28 17:12:27'),
(17, 'House Blend', 1, 'House Blend Chocolate', '', 12, 'house blend chocolate.jpeg', '2021-05-28 17:17:31'),
(18, 'House Blend', 1, 'House Blend Milk And Chocolate', '', 15, 'house blend milk and chocolate.jpeg', '2021-05-28 17:20:59'),
(19, 'Dark Roast', 1, 'Dark Roast', '', 20, 'dark roast.jpeg', '2021-05-28 17:41:55'),
(20, 'Espresso', 1, 'Espresso', '', 18, 'espresso.jpeg', '2021-05-28 17:43:07'),
(21, 'Decaf', 1, 'Decaf With Milk', '', 12, 'decaf milk.jpeg', '2021-05-28 17:46:30'),
(22, 'Coffee', 1, 'Coffee', '', 10, 'coffee.jpeg', '2021-05-28 17:48:25'),
(23, 'Cappuccino', 1, 'Cappuccino With Milk', '', 20, 'cappuccino milk.jpeg', '2021-05-28 17:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `license_date` varchar(255) DEFAULT NULL,
  `active_status` varchar(255) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `online` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `password`, `create_date`, `license_date`, `active_status`, `status`, `role`, `online`) VALUES
(1, 'Mostafa', 'Khaled', 'Mostafa1810751@miuegypt.edu.eg', '$2y$10$/GhjnRrHpqTxduAxZ3iKTuYvjaRtU4.zNd0HKo68vavyHWLFykqDG', '2021-05-28 17:59:05', '2022-05-28', '854473', 0, 'admin', 0),
(2, 'Kareem', 'Ehab', 'kareem1802405@miuegypt.edu.eg', '$2y$10$u0y106RZkgb4MT.7pvnmq.fUDfX/U0OgdQUozcqpYz.KvJIFcausG', '2021-05-30 21:48:10', '2022-05-30', '488035', 0, 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
