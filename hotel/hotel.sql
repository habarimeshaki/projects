-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2026 at 04:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `authorized_users`
--

CREATE TABLE `authorized_users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorized_users`
--

INSERT INTO `authorized_users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'hotel_manager', '$2y$10$wLxf9Wcyg2QNFik8Kf8TZ.og9wtUEY5ldpykH8.1kLQp2cHrEXdty', 'manager@hotel.test', 'admin'),
(2, 'frontdesk', '$2y$10$v5RJyxgrtcGaJn4YyhAJNO0CeiBff4O4Z2s8w6RXBEJfRvq4SayF2', 'desk@hotel.test', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `guest` int(10) DEFAULT NULL,
  `room_type` varchar(20) DEFAULT NULL,
  `request` text DEFAULT NULL,
  `nights` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `receipt_accepted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `phone`, `name`, `email`, `check_in`, `check_out`, `guest`, `room_type`, `request`, `nights`, `total_price`, `receipt_accepted`) VALUES
(17, '0786506320', 'Mucyo', 'habarimeshaki@gmail.com', '2026-08-01', '2026-07-18', 8, 'Standard', 'none', 0, 0.00, 1),
(20, '079999999999', 'Mulisa Ange', 'example@gmail.com', '2026-08-01', '2026-07-18', 2, 'Standard', 'none', 0, 0.00, 1),
(21, '0786506320', 'Habari Meshaki', 'habarimeshaki@gmail.com', '2026-08-01', '2026-07-18', 8, 'Standard', 'none', 0, 0.00, 0),
(22, '0786506320', 'Iriza', 'habarimeshaki@gmail.com', '2026-07-03', '2026-08-09', 5, 'Standard', 'Swimming poor', 0, 0.00, 0),
(23, '0793029839', 'Ibrahim Fiston', 'habarimeshak2005@gmail.com', '2026-07-03', '2026-08-09', 78, 'VIP', 'Swimming poor', 0, 0.00, 0),
(25, '+2507888888888', 'iriza bar', 'iribar@gmail.com', '2026-08-02', '2026-08-15', 4, 'Standard', 'Tourist car', 3, 750.00, 1),
(26, '0784796253', 'Barekeriyo Iriza', 'irizabrkry@gmail.com', '2026-08-01', '2026-08-16', 2, 'VIP', 'Vegetarian Food only', 4, 600.00, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorized_users`
--
ALTER TABLE `authorized_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_authorized_username` (`username`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authorized_users`
--
ALTER TABLE `authorized_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
