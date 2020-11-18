-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2020 at 04:46 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `find`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device`
--

CREATE TABLE `tbl_device` (
  `device_id` int(7) NOT NULL,
  `login_id` int(7) NOT NULL,
  `name` varchar(40) NOT NULL,
  `type` varchar(10) NOT NULL,
  `imei` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `login_id` int(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`login_id`, `email`, `password`, `status`) VALUES
(8, 'alan@mca.ajce.in', '$2y$10$CV664VsvrsLnId/07tpsDOagPwYyUASuEI.AuRv3Q7SVqzPZvYRkO', 1),
(11, 'alansmathew@icloud.com', '$2y$10$hq8X1oyI290s89X0LJAjLe2T8Jz.gKtWyGO4v9R1ZFP1bhSJ66gyS', 1),
(12, 'alan@icloud.com', '$2y$10$Gp1F9ZLumHBxduNeRM1imO6o8XaQ94Ca5ucQZOY4V52TeCwD9J.DC', 1),
(13, 'alansmathew@mca.ajce.in', '$2y$10$z2vOQf.cdVn8N0j6zgMskuTtct3I6amKVWQE0IaMyxZhkEfNkYova', 1),
(14, 'albin@gmail.com', '$2y$10$Ph7ogx4VX4sO32qDOD9Ckuk/hbUPMFvDwp1wH/pINbzqBKTLy57tC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pic`
--

CREATE TABLE `tbl_pic` (
  `pic_id` int(7) NOT NULL,
  `login_id` int(7) NOT NULL,
  `filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pic`
--

INSERT INTO `tbl_pic` (`pic_id`, `login_id`, `filename`) VALUES
(1, 10, 'IMG_5750.jpg'),
(2, 11, 'IMG_6438 2.JPG'),
(3, 13, 'IMG_1527.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reg`
--

CREATE TABLE `tbl_reg` (
  `reg_id` int(7) NOT NULL,
  `login_id` int(7) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reg`
--

INSERT INTO `tbl_reg` (`reg_id`, `login_id`, `name`) VALUES
(8, 8, 'alan'),
(11, 11, 'alansmathew'),
(12, 12, 'alansmatehw'),
(13, 13, 'alansmathew'),
(14, 14, 'alan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_device`
--
ALTER TABLE `tbl_device`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `tbl_pic`
--
ALTER TABLE `tbl_pic`
  ADD PRIMARY KEY (`pic_id`);

--
-- Indexes for table `tbl_reg`
--
ALTER TABLE `tbl_reg`
  ADD PRIMARY KEY (`reg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_device`
--
ALTER TABLE `tbl_device`
  MODIFY `device_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `login_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_pic`
--
ALTER TABLE `tbl_pic`
  MODIFY `pic_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_reg`
--
ALTER TABLE `tbl_reg`
  MODIFY `reg_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
