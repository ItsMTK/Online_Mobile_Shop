-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2021 at 11:43 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `products_table`
--

CREATE TABLE `products_table` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `count` int(11) NOT NULL,
  `price` decimal(9,2) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_table`
--

INSERT INTO `products_table` (`product_id`, `product_name`, `product_description`, `count`, `price`, `user_id`) VALUES
(41, 'My Phone', 'This is my new phone', 15, '421.20', 1),
(42, 'New Phone', 'The best phone in the world\r\n', 21, '552.99', 2),
(43, 'Tiny Phone', 'The smallest phone in the whole world', 22, '422.12', 5),
(44, 'phone with new design', 'This phone has new design', 18, '552.99', 1),
(48, 'Microsoft phone', 'This phone from microsoft !!', 20, '521.20', 8),
(49, 'Phone with good Camera', 'This phone has a great camera!!', 18, '200.00', 2),
(50, 'Black phone', 'This phone for black lovers!!', 19, '430.20', 13),
(51, 'Rezen Phone', 'This phone is super!!', 3, '542.99', 1),
(52, 'Nokia mobile phone', 'Mobile for business men', 1, '233.50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `records_table`
--

CREATE TABLE `records_table` (
  `record_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `record_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `records_table`
--

INSERT INTO `records_table` (`record_id`, `user_id`, `product_id`, `amount`, `record_date`) VALUES
(5, 3, 48, 2, '2021-10-25 17:20:48'),
(12, 13, 42, 2, '2021-10-26 00:10:02'),
(13, 13, 43, 2, '2021-10-26 00:18:23'),
(21, 14, 44, 2, '2021-10-26 19:06:53'),
(31, 8, 52, 1, '2021-10-26 22:57:34'),
(35, 1, 49, 2, '2021-10-27 00:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`user_id`, `username`, `password`) VALUES
(1, 'mohammad@gmail.com', '123'),
(2, 'tala@gmail.com', '123456'),
(3, 'Hamsa@gmail.com', '4321'),
(5, 'Mazen@gmail.com', '111222333444'),
(8, 'Ahmad@gmail.com', '987654321'),
(9, 'Noah@hotmail.com', '666555444333222111'),
(13, 'Mohannad@hotmail.com', '123'),
(14, 'ali@gmail.com', '123'),
(15, 'test2@gmail.com', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products_table`
--
ALTER TABLE `products_table`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_products_users` (`user_id`);

--
-- Indexes for table `records_table`
--
ALTER TABLE `records_table`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `fk_records_users` (`user_id`),
  ADD KEY `fk_records_products` (`product_id`);

--
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products_table`
--
ALTER TABLE `products_table`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `records_table`
--
ALTER TABLE `records_table`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products_table`
--
ALTER TABLE `products_table`
  ADD CONSTRAINT `fk_products_users` FOREIGN KEY (`user_id`) REFERENCES `users_table` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `records_table`
--
ALTER TABLE `records_table`
  ADD CONSTRAINT `fk_records_products` FOREIGN KEY (`product_id`) REFERENCES `products_table` (`product_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_records_users` FOREIGN KEY (`user_id`) REFERENCES `users_table` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
