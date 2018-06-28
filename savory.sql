-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2018 at 04:58 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `savory`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(2) NOT NULL,
  `num` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `num`) VALUES
(2, 6),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `des` varchar(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `des`, `img`, `price`) VALUES
(1, 'Fresh Mushrooms', 'Far far away, behind the word mountains, far from the countries Vokalia..', 'images/img_1.jpg', 19.15),
(2, 'Cheese and Garlic Toast', 'Far far away, behind the word mountains, far from the countries Vokalia..', 'images/img_2.jpg', 20.99),
(3, 'Grilled Chiken Salad', 'Far far away, behind the word mountains, far from the countries Vokalia..', 'images/img_3.jpg', 8.99),
(4, 'Organic Egg', 'Far far away, behind the word mountains, far from the countries Vokalia..', 'images/img_4.jpg', 12.99),
(5, 'Tomato Soup with Chicken', 'Far far away, behind the word mountains, far from the countries Vokalia..', 'images/img_5.jpg', 23.1),
(6, 'Salad with Crispy Chicken', 'Far far away, behind the word mountains, far from the countries Vokalia..', 'images/img_6.jpg', 5.59);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `password`) VALUES
(1, 'sanjaypj', 'sanjaypjayan2000@gmail.com', '$2y$10$j4m9WFREUJyu5a09FtDlHe7tWQKTLE2BY.KoC2omOeUL34oTAFWW6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
