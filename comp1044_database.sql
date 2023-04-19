-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2023 at 02:51 AM
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
-- Database: `comp1044_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `sr_no` int(11) NOT NULL,
  `car_name` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `colour` varchar(45) NOT NULL,
  `rate` int(4) NOT NULL COMMENT 'rate per day in RM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`sr_no`, `car_name`, `category`, `colour`, `rate`) VALUES
(1, 'Rolls Royce Phantom', 'Luxurious', 'Blue', 9800),
(2, 'Bentley Continental Flying Spur', 'Luxurious', 'White', 4800),
(3, 'Mercedes Benz CLS 350', 'Luxurious', 'Silver', 1350),
(4, 'Jaguar S Type', 'Luxurious', 'Champagne', 1350),
(5, 'Ferrari F430 Scuderia', 'Sports', 'Red', 6000),
(6, 'Lamborghini Murcielago LP640', 'Sports', 'Matte Black', 7000),
(7, 'Porsche Boxster', 'Sports', 'White', 2800),
(8, 'Lexus SC430', 'Sports', 'Black', 1600),
(9, 'Jaguar MK 2', 'Classics', 'White', 2200),
(10, 'Rolls Royce Silver Spirit Limousine', 'Classics', 'Georgian Silver', 3200),
(11, 'MG TD', 'Classics', 'Red', 2500);

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `category` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`category`, `name`, `username`, `email`, `password`) VALUES
('Employee', 'Admin', 'admin', 'admin@dde.com', '4e3850db3bc08755ec1b6e86895c73f2'),
('Employee', 'Clara', 'claradde', 'clara@dde.com', 'f99f46bdc221a094e3b79c83a52f1f16'),
('Employee', 'John', 'johndde', 'john@dde.com', '002bc04f923faaa3602f45faa25c7ad8'),
('Customer', 'Siddharth Ray', 'SiddharthRay2004', 'siddharthray.siddharthray@gmail.com', 'e8609e4bfc4c51b5990f0753aa4de51c'),
('Customer', 'Tester', 'tester1', 'tester1@gmail.com', 'f5d1278e8109edd94e1e4197e04873b9');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `car_name` varchar(45) NOT NULL,
  `car_sr_no` int(11) NOT NULL,
  `category` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `reservation_id` varchar(45) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `CarSrNo` (`car_sr_no`),
  ADD KEY `CustomerUsername` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `CarSrNo` FOREIGN KEY (`car_sr_no`) REFERENCES `cars` (`sr_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `CustomerUsername` FOREIGN KEY (`username`) REFERENCES `login_details` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
