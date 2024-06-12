-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 09:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datastockname`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `Nama` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Nama`, `Email`, `Password`) VALUES
('imam', 'aliyudinganz34@gmail.com', 'udinnganga'),
('rafli', 'Rafli@gmail.com', 'udin');

-- --------------------------------------------------------

--
-- Table structure for table `stockopname`
--

CREATE TABLE `stockopname` (
  `id` int(10) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Jenis` varchar(20) NOT NULL,
  `Merk` varchar(20) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Stok` int(255) NOT NULL,
  `Qty` varchar(50) NOT NULL,
  `Keterangan` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stockopname`
--

INSERT INTO `stockopname` (`id`, `Nama`, `Jenis`, `Merk`, `Type`, `Stok`, `Qty`, `Keterangan`, `Status`) VALUES
(1, 'nunuj', 'laptop', 'sony', 'high', 10, '10', 'terjual', 'terjual'),
(2, 'rafli', 'laptop', 'samsung', 'high', 20, '20', 'terjual', 'terjual'),
(3, 'sena', 'laptop', 'sony', 'high', 30, '30', 'terjual', 'terjual');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stockopname`
--
ALTER TABLE `stockopname`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stockopname`
--
ALTER TABLE `stockopname`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
