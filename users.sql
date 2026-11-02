-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 01, 2026 at 06:11 PM
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
-- Database: `jobconnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('seeker','recruiter','admin') NOT NULL DEFAULT 'seeker',
  `phone` varchar(30) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `profile_image`, `status`, `created_at`) VALUES
(1, 'Renuka Reddy', 'renukareddy123@gmail.com', '$2y$10$uCuXRkz7GovnYFLfQtKboeyNcJJT//DKROV8.Vg2XDiUQFHzSxrGu', 'seeker', NULL, NULL, 'active', '2026-10-30 19:08:21'),
(2, 'BrightWave Recruiter', 'recruiter@jobconnect.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'recruiter', '9000000001', NULL, 'active', '2026-10-30 19:18:40'),
(3, 'Renuka Reddy', 'renukareddy@gmail.com', '$2y$10$qgvmhOvt7FEeak2X5tIgden59EeXqvN./4zmF02WufvIXADplOlvO', 'recruiter', NULL, NULL, 'active', '2026-10-30 19:20:04'),
(4, 'Lalithya Reddy', 'lalithyareddy@gmail.com', '$2y$10$7Pat8yL6MaGnNbyXMuwczuMI8xd/H1fBSy9tDFvf16hqDzIykZjvK', 'seeker', NULL, NULL, 'active', '2026-10-30 19:33:21'),
(5, 'MarketMint Recruiter', 'marketmint@jobconnect.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'recruiter', '9000000002', NULL, 'active', '2026-11-01 12:38:42'),
(6, 'PixelCraft Recruiter', 'pixelcraft@jobconnect.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'recruiter', '9000000003', NULL, 'active', '2026-11-01 12:38:42'),
(7, 'FinEdge Recruiter', 'finedge@jobconnect.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'recruiter', '9000000004', NULL, 'active', '2026-11-01 12:38:42'),
(8, 'CareFirst Recruiter', 'carefirst@jobconnect.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'recruiter', '9000000005', NULL, 'active', '2026-11-01 12:38:42'),
(9, 'LearnSphere Recruiter', 'learnsphere@jobconnect.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'recruiter', '9000000006', NULL, 'active', '2026-11-01 12:38:42');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
