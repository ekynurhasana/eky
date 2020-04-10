-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2020 at 07:52 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing_address`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(8) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Address1` varchar(255) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `ZIP` varchar(255) NOT NULL,
  `Payment` varchar(255) NOT NULL,
  `Name_Card` varchar(255) NOT NULL,
  `Credit_Number` int(8) NOT NULL,
  `Expiration` date NOT NULL,
  `CVV` int(8) NOT NULL,
  `Time_Insert` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `FirstName`, `LastName`, `Username`, `Email`, `Address`, `Address1`, `Country`, `State`, `ZIP`, `Payment`, `Name_Card`, `Credit_Number`, `Expiration`, `CVV`, `Time_Insert`) VALUES
(23, 'Eky', 'Arjayanto', 'ean22', 'eky.ean22@gmail.com', 'Jln. Kakaktua No 10', '', 'Indonesia', 'Makassar', '90221', 'debit', 'Eky Arjayanto', 12345, '2022-10-22', 12345, '2020-04-10 13:14:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
