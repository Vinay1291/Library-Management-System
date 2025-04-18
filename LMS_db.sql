-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2025 at 01:31 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LMS_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `isbn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `cover_image` varchar(225) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `available_copies` int NOT NULL,
  `copies` int NOT NULL DEFAULT '1',
  `shelf_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('Available','Lended','Damaged') NOT NULL,
  `total_pages` int DEFAULT NULL,
  `features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `volume` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publisher_name` int DEFAULT NULL,
  `published_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `isbn`, `title`, `author`, `cover_image`, `category`, `language`, `available_copies`, `copies`, `shelf_code`, `status`, `total_pages`, `features`, `volume`, `created_date`, `publisher_name`, `published_date`) VALUES
(1, '132-324-54', 'DEMO', 'Lion', '1244dsfa.jpeg', 'DEMOcat', 'DEMOlang', 0, 3, '', 'Damaged', 0, '', '', '2025-04-17 14:49:44', NULL, NULL),
(2, 'LMS-B0-01', 'The Great Gatsby', 'F. Scott Fitzgerald', NULL, 'Fiction', 'English', 0, 10, '', 'Available', 0, '', '', '2025-04-18 11:53:44', NULL, NULL),
(4, 'LMS-B0-02', 'Pirates of the Caribbean', 'Jane Austen', NULL, 'Non-Fiction', 'Tamil', 0, 3, '', 'Lended', 0, '', '', '2025-04-18 11:59:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `borrow_records`
--

CREATE TABLE `borrow_records` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned') DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `activity` text,
  `activity_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', '9999999999', 'admin@lms.com', '$2y$10$SxXwCDkJ2NuEt6XGFeECsuPEPaBsv0WCVhh0layLdu9Ku6DRunxwq', 'admin', '2025-04-16 20:26:20'),
(2, 'Lion King', '1234567890', 'lion@king.com', '$2y$10$GyXbauWyqv0Dg741PK8ufudf5Pq.vZkRI63Ai8d1hEiXa3JDdexWu', 'user', '2025-04-16 20:30:43'),
(3, 'Hero Sama', '08097989507', 'sama@hero.com', '$2y$10$Rgk5CQUmTse.sbpS37TCQ.oj511dz4euthhBe9pRlZR1lZjUdjhV.', 'user', '2025-04-16 21:06:10'),
(4, 'Aditya Vishwakarma', '9833007196', 'aditya@hero.com', '$2y$10$de3mJ0Efzw5SVCfvVQ0/M.R8NIjDxFyrQSqbAWp1i3XtCHLEiKgWi', 'user', '2025-04-18 12:19:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrow_records`
--
ALTER TABLE `borrow_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `borrow_records`
--
ALTER TABLE `borrow_records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_records`
--
ALTER TABLE `borrow_records`
  ADD CONSTRAINT `borrow_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrow_records_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
