-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 29, 2025 at 08:16 AM
-- Server version: 12.0.2-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invenx`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `name_item` varchar(100) NOT NULL,
  `unit_item` varchar(100) NOT NULL,
  `update_at_item` date NOT NULL,
  `created_date_item` date NOT NULL,
  `status_item` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id_item`, `name_item`, `unit_item`, `update_at_item`, `created_date_item`, `status_item`) VALUES
(1, 'AYAM BEREMPAH', 'PCS', '2025-12-12', '2025-12-12', 1),
(2, 'PANKO CHIKEN / PARMIGIANA', 'PCS', '2025-12-12', '2025-12-12', 1),
(3, 'LAMB SHANK', 'PCS', '2025-12-17', '2025-12-17', 1),
(4, 'RIBEYE', 'PCS', '2025-12-17', '2025-12-17', 1),
(5, 'SALMON STEAK (FILLET)', 'PCS', '2025-12-17', '2025-12-17', 1),
(6, 'POLLOCK FILLET', 'PCS', '2025-12-17', '2025-12-17', 1),
(7, 'PRAWN GALAH', 'PCS', '2025-12-17', '2025-12-17', 1),
(8, 'SIAKAP (M)', 'PCS', '2025-12-17', '2025-12-17', 1),
(9, 'SIAKAP (L)', 'PCS', '2025-12-17', '2025-12-17', 1),
(10, 'GAROUPA', 'PCS', '2025-12-17', '2025-12-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id_stock` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `opening_stock` int(11) NOT NULL DEFAULT 0,
  `received_stock` int(11) NOT NULL DEFAULT 0,
  `closing_stock` int(11) NOT NULL DEFAULT 0,
  `sold_stock` int(11) NOT NULL DEFAULT 0,
  `discard_stock` int(11) NOT NULL DEFAULT 0,
  `notes_stock` text DEFAULT NULL,
  `update_at_stock` date NOT NULL,
  `created_date_stock` date NOT NULL DEFAULT current_timestamp(),
  `status_stock` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id_stock`, `id_item`, `opening_stock`, `received_stock`, `closing_stock`, `sold_stock`, `discard_stock`, `notes_stock`, `update_at_stock`, `created_date_stock`, `status_stock`) VALUES
(10, 1, 0, 9, 2, 7, 0, 'None', '2025-12-14', '2025-12-14', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id_stock`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
