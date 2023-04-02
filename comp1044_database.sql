-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 11:13 PM
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
  `sr_no` int(11) NOT NULL,
  `category` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`sr_no`, `category`, `name`, `username`, `email`, `password`) VALUES
(16, 'Customer', 'sadsd', '2rwef2', 'siddharthray.sidray@gmail.com', 'e8609e4bfc4c51b5990f0753aa4de51c'),
(1, 'Employee', 'Admin', 'admin', 'admin@dde.com', '4e3850db3bc08755ec1b6e86895c73f2'),
(17, 'Customer', 'awdawsd', 'afaesdf', 'asfasda@FAEDFA.caiosfn', 'a63004c40eaac4a24701edc6e2914b6f'),
(20, 'Customer', 'ASDa', 'asdasd', 'asdargs@sfsaf.fgsds', '71f3996886e35b334f9b238484d1f118'),
(23, 'Customer', 'Siddharth Ray', 'asdasdasd', 'adawsdaw@blackman.com', 'c9b0c6c80f0b11aa21b8e72091f2b9a7'),
(3, 'Employee', 'Clara', 'claradde', 'clara@dde.com', 'f99f46bdc221a094e3b79c83a52f1f16'),
(19, 'Customer', 'Adszfcz', 'DXCAF', 'ssdad@gsad.com', 'ec02c59dee6faaca3189bace969c22d3'),
(2, 'Employee', 'John', 'johndde', 'john@dde.com', '002bc04f923faaa3602f45faa25c7ad8'),
(21, 'Customer', 'Sas', 'Sads', 'ar353@sdg.cim', 'bb92ecf1cbd3f76429ff47f1aae00b9e'),
(18, 'Customer', 'drfhgsfg', 'sfgggs', 'gsdfgsxfg@hsrfg.cfhcgfh', 'd1fc373d65ee121da0b3270c16fbe192'),
(22, 'Customer', 'Siddharth Roy', 'Sid2004', 'siddharthray@gmail.com', 'e8609e4bfc4c51b5990f0753aa4de51c'),
(9, 'Customer', 'Siddharth Ray', 'SiddharthRay2004', 'siddharthray.siddharthray@gmail.com', 'e8609e4bfc4c51b5990f0753aa4de51c'),
(24, 'Customer', 'Tester 1', 'tester1', 'asdasd@aef.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `car_name` varchar(45) NOT NULL,
  `car_sr_no` int(11) NOT NULL,
  `customer_username` varchar(45) NOT NULL,
  `reservation_id` varchar(45) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`car_name`, `car_sr_no`, `customer_username`, `reservation_id`, `pickup_date`, `return_date`, `no_of_days`, `total_cost`) VALUES
('Array', 1, 'SiddharthRay2004', '1.2023-04-02.2023-04-02', '2023-04-02', '2023-04-02', 1, 1),
('Rolls Royce Phantom', 1, 'SiddharthRay2004', '1.2023-04-03.2023-04-04', '2023-04-03', '2023-04-04', 2, 19600);

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
  ADD PRIMARY KEY (`car_name`),
  ADD KEY `CarSrNo` (`car_sr_no`),
  ADD KEY `CustomerUsername` (`customer_username`);

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
  ADD CONSTRAINT `CustomerUsername` FOREIGN KEY (`customer_username`) REFERENCES `login_details` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
