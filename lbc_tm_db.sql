-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 11:37 AM
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
-- Database: `lbc_tm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `available_tickets` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `event_time`, `location`, `venue`, `image_path`, `capacity`, `available_tickets`, `price`, `created_at`, `updated_at`) VALUES
(1, 'magbalik', 'magbalikable', '2025-09-19', '99:47:59', 'dmatagpuan', 'bahayko', 'C:\\xampp\\htdocs\\ticket\\lbc_tm\\images\\movements_turnover_cover_night_3', 10, 6, 100.00, '2025-09-19 08:47:01', '2025-09-19 08:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` enum('admin','manager','employee') DEFAULT 'employee',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `failed_login_attempts` int(11) DEFAULT 0,
  `account_locked_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `role`, `is_active`, `created_at`, `updated_at`, `last_login`, `failed_login_attempts`, `account_locked_until`) VALUES
(1, 'admin', 'admin@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System', 'Administrator', 'admin', 1, '2025-09-12 06:41:43', '2025-09-19 09:25:23', '2025-09-19 09:25:23', 2, NULL),
(2, 'jsmith', 'john.smith@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'manager', 1, '2025-09-12 06:41:43', '2025-09-19 07:26:16', '2025-09-19 07:26:16', 2, NULL),
(3, 'mjohnson', 'mary.johnson@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mary', 'Johnson', 'employee', 1, '2025-09-12 06:41:43', '2025-09-12 07:31:29', NULL, 1, NULL),
(4, 'rbrown', 'robert.brown@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Robert', 'Brown', 'employee', 1, '2025-09-12 06:41:43', '2025-09-12 06:41:43', NULL, 0, NULL),
(5, 'swilson', 'sarah.wilson@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah', 'Wilson', 'manager', 1, '2025-09-12 06:41:43', '2025-09-12 06:41:43', NULL, 0, NULL),
(6, 'dlee', 'david.lee@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Lee', 'employee', 0, '2025-09-12 06:41:43', '2025-09-12 06:41:43', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `status` enum('pending','confirmed','cancelled','used') DEFAULT 'pending',
  `payment_reference` varchar(100) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `event_id`, `user_id`, `ticket_type`, `price`, `purchase_date`, `status`, `payment_reference`, `payment_date`, `amount_paid`, `account_name`, `account_number`, `created_at`, `updated_at`) VALUES
(1, 'LBC-68CD18DB45734', 1, 1, 'General Admission', 100.00, '2025-09-19 16:48:27', 'confirmed', '3123123', '2025-09-19 16:43:00', 99999999.99, 'dfsdfsdf', 'fdsfsedfse', '2025-09-19 08:48:27', '2025-09-19 08:48:27'),
(2, 'LBC-68CD18ED240F2', 1, 1, 'General Admission', 100.00, '2025-09-19 16:48:45', 'confirmed', '3123123', '2025-09-19 16:48:00', 50.00, 'dfsdfsdf', 'fdsfsedfse', '2025-09-19 08:48:45', '2025-09-19 08:48:45'),
(3, 'LBC-68CD1A0C94A71', 1, 1, 'General Admission', 100.00, '2025-09-19 16:53:32', 'confirmed', '1234567890987', '2025-09-19 16:53:00', 444.00, 'BASTAEWAN', '0912345678', '2025-09-19 08:53:32', '2025-09-19 08:53:32'),
(4, 'LBC-68CD1AF2820C2', 1, 1, 'General Admission', 100.00, '2025-09-19 16:57:22', 'confirmed', '3123123', '2025-09-19 16:56:00', 100.00, 'dfsdfsdf', '0912345678', '2025-09-19 08:57:22', '2025-09-19 08:57:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `event_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `event_id` FOREIGN KEY (`user_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
