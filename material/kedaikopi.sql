-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 05:09 PM
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
-- Database: `kedaikopi`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `image`) VALUES
(1, 'Espresso', 'image/menu/menu_1.jpg'),
(2, 'Latte', 'image/menu/menu_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `rating` int(5) NOT NULL,
  `price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `image`, `name`, `description`, `rating`, `price`) VALUES
(1, 'image/product/coffee_1.jpg', 'Robusta Brazil', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore.', 4, 10.00),
(2, 'image/product/coffee_2.jpg', 'Latte', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore..', 2, 5.00),
(3, 'image/product/coffee_2.jpg', 'Black Coffee', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore..', 3, 7.00),
(4, 'image/product/coffee_1.jpg', 'Cappuccino', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore..', 4, 8.00),
(5, 'image/product/coffee_1.jpg', 'Espresso', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore..', 4, 12.50),
(6, 'image/product/coffee_2.jpg', 'Americano', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore..', 3, 9.00),
(7, 'image/product/coffee_1.jpg', 'Café au lait', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex odio eius, natus incidunt repudiandae ratione vero libero magni excepturi deleniti illum iusto rerum repellendus aperiam veniam! Tempore..', 5, 8.50);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`) VALUES
(1, 'deli', 'deli', '$2y$10$8K6C7ARMZxc250k0npp5wuyzaaAyCJ7yENE6QZJZUshPZslTFOtIC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
