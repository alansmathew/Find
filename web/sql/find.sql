-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2021 at 06:28 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id15446935_find`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_device`
--

CREATE TABLE `tbl_device` (
  `device_id` int(7) NOT NULL,
  `login_id` int(7) NOT NULL,
  `name` varchar(60) NOT NULL,
  `type` varchar(10) NOT NULL,
  `imei` varchar(255) NOT NULL,
  `lat` varchar(50) NOT NULL DEFAULT '0',
  `lon` varchar(50) NOT NULL DEFAULT '0',
  `state` varchar(20) NOT NULL DEFAULT 'active',
  `time` varchar(50) NOT NULL,
  `hashcode` varchar(70) NOT NULL DEFAULT 'blah',
  `oflineid` varchar(255) NOT NULL DEFAULT 'bleh',
  `paringtime` varchar(50) NOT NULL DEFAULT '07:48:28 20-06-10'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_device`
--

INSERT INTO `tbl_device` (`device_id`, `login_id`, `name`, `type`, `imei`, `lat`, `lon`, `state`, `time`, `hashcode`, `oflineid`, `paringtime`) VALUES
(1, 11, 'iphone 8 plus', 'mobile', '123456789101213', '9.520925', '76.728531', 'active', '00:00:00', 'blah', 'bleh', '07:48:28 20-06-10'),
(3, 11, 'macbook pro', 'pc', '123456789101234', '9.532424926757809', '76.73396301269528', 'active', '04:19:16', 'blah', 'bleh', '07:48:28 20-06-10'),
(11, 32, 'alan', 'mobile', '123456789000000', '9.528543943105372', '76.73174012339688', 'active', '05:38:20', 'blah', 'bleh', '07:48:28 20-06-10'),
(12, 11, 'alansiphone ', 'mobile', '123456789009878', '9.52566106248664', '76.7304490870004', 'active', '09:14:27', 'blah', 'bleh', '07:48:28 20-06-10'),
(13, 11, 'alans iphone6', 'mobile', '123456789099999', '9.53206630942153', '76.73331436447639', 'active', '10:10:27', 'blah', 'bleh', '07:48:28 20-06-10'),
(14, 34, 'abins. iphone', 'mobile', '123456789000000', '9.532100653179084', '76.73333738872316', 'active', '10:13:20', 'blah', 'bleh', '07:48:28 20-06-10'),
(49, 35, 'SAMSUNG A10', 'mobile', 'QP1A.190711.020', '9.5226335', '76.7222886', 'active', '11:05:17 21-06-10', 'blah', 'bleh', '07:48:28 20-06-10'),
(51, 35, 'Alans iPhone', 'mobile', '419CAC00-438F-433B-A1A5-DF8D356A9368', '9.531266069726588', '76.73241398858818', 'active', '10:18:37 21-06-13', 'blah', 'bleh', '07:48:28 20-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

CREATE TABLE `tbl_log` (
  `log_id` int(11) NOT NULL,
  `login_id` int(7) NOT NULL,
  `type` varchar(10) NOT NULL,
  `dis` varchar(200) NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` varchar(10) NOT NULL,
  `datetime` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_log`
--

INSERT INTO `tbl_log` (`log_id`, `login_id`, `type`, `dis`, `date`, `time`, `datetime`) VALUES
(61, 11, 'profile', 'Login Activity', '22-04-21', '09:38:40', '09:38:40 22-04-21'),
(62, 32, 'profile', 'Login Activity', '22-04-21', '11:06:50', '11:06:50 22-04-21'),
(63, 32, 'profile', 'Login Activity', '22-04-21', '11:07:42', '11:07:42 22-04-21'),
(64, 11, 'profile', 'Login Activity', '23-04-21', '02:39:50', '02:39:50 23-04-21'),
(65, 11, 'profile', 'Login Activity', '23-04-21', '02:42:32', '02:42:32 23-04-21'),
(66, 33, 'profile', 'New Account Creation', '23-04-21', '03:28:12', '03:28:12 23-04-21'),
(67, 11, 'profile', 'Login Activity', '23-04-21', '03:31:10', '03:31:10 23-04-21'),
(68, 11, 'profile', 'Profile name changed', '23-04-21', '03:36:14', '03:36:14 23-04-21'),
(69, 11, 'profile', 'Profile Email changed', '23-04-21', '03:36:14', '03:36:14 23-04-21'),
(70, 11, 'profile', 'Profile password changed using profile updation settings', '23-04-21', '03:36:14', '03:36:14 23-04-21'),
(71, 11, 'profile', 'Login Activity', '23-04-21', '03:36:49', '03:36:49 23-04-21'),
(72, 11, 'profile', 'Password reset attempt', '23-04-21', '03:38:07', '03:38:07 23-04-21'),
(73, 11, 'profile', 'Password reseted sucessfully', '23-04-21', '03:39:55', '03:39:55 23-04-21'),
(74, 11, 'profile', 'Login Activity', '23-04-21', '03:40:17', '03:40:17 23-04-21'),
(75, 32, 'profile', 'Login Activity', '06-06-21', '09:28:01', '09:28:01 06-06-21'),
(76, 32, 'profile', 'Login Activity', '06-06-21', '12:49:45', '12:49:45 06-06-21'),
(77, 11, 'profile', 'Password reset attempt', '07-06-21', '02:24:28', '02:24:28 07-06-21'),
(78, 11, 'profile', 'Password reset attempt', '07-06-21', '02:26:59', '02:26:59 07-06-21'),
(79, 11, 'profile', 'Password reset attempt', '07-06-21', '02:37:00', '02:37:00 07-06-21'),
(80, 11, 'profile', 'Password reseted sucessfully', '07-06-21', '02:37:46', '02:37:46 07-06-21'),
(81, 11, 'profile', 'Login Activity', '07-06-21', '02:38:04', '02:38:04 07-06-21'),
(82, 35, 'profile', 'Login Activity', '08-06-21', '08:38:07', '08:38:07 08-06-21'),
(83, 35, 'profile', 'Login Activity', '08-06-21', '09:02:14', '09:02:14 08-06-21'),
(84, 35, 'profile', 'Login Activity', '08-06-21', '09:39:30', '09:39:30 08-06-21'),
(85, 35, 'profile', 'Login Activity', '09-06-21', '08:44:05', '08:44:05 09-06-21'),
(86, 35, 'profile', 'Login Activity', '10-06-21', '12:14:27', '12:14:27 10-06-21'),
(87, 11, 'profile', 'Password reset attempt', '10-06-21', '03:42:54', '03:42:54 10-06-21'),
(88, 35, 'profile', 'Login Activity', '10-06-21', '03:58:25', '03:58:25 10-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `login_id` int(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`login_id`, `email`, `password`, `status`) VALUES
(11, 'alansmathew@icloud.com', '$2y$10$dwwEEmP2dEyC3xFRflsVRezexhHV/.RobbwBCls/HF/mD3a5BQpZ.', 1),
(31, 'albinbennyvcra@gmail.com', '$2y$10$7pY5K7d2YMgou7pWr3QV4uRrPE18YV5FVz/ShSLMXnLlA3/J8geKa', 1),
(32, 'alansmathew008@gmail.com', '$2y$10$7ChEH19H9yXWYAsChVxJjOrejs/U/jJQs7HxK0lVHbfA6J.9RMPmW', 1),
(33, 'albin@mca.ajce.in', '$2y$10$4yJRnZzsbHSmt1CqtRFM2uSuCV/QaminTohNlh.mLofgIvFJGfu7G', 1),
(34, 'albin@gmail.com', '$2y$10$y6TNRh/jwDTlvXpRKYYXVO5863JgxqCybBt9U2PkFqiiVARZ93bsG', 1),
(35, 'kjmathew640@gmail.com', '$2y$10$G66Hb5p/Fnx00dVjjGGmneK6ni4dIGUO9f3FbreXDW2A0o5lPSRBe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_otp`
--

CREATE TABLE `tbl_otp` (
  `otp_id` int(7) NOT NULL,
  `login_id` int(7) NOT NULL,
  `otp_time` varchar(20) NOT NULL,
  `otp_data` varchar(10) NOT NULL,
  `otp_random` varchar(61) NOT NULL,
  `otp_attempt` int(4) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_otp`
--

INSERT INTO `tbl_otp` (`otp_id`, `login_id`, `otp_time`, `otp_data`, `otp_random`, `otp_attempt`) VALUES
(16, 11, '21-06-10 10:12:54', '132739', 'QXj91PLSykRKv0ICqb6J5FgNpcfhVwA42YTnDE7mGUOizoWtHlMasB8Zxeu3', 3);

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
(2, 11, 'IMG_6438 2.JPG'),
(4, 31, 'C0D9067A-7571-4D56-8B52-6738EEA157A6.jpeg');

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
(11, 11, 'alansmathew'),
(29, 31, 'pampu'),
(30, 32, 'alan'),
(31, 33, 'albin'),
(32, 34, 'abin'),
(33, 35, 'kjmathew	');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_device`
--
ALTER TABLE `tbl_device`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD PRIMARY KEY (`otp_id`);

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
  MODIFY `device_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `login_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  MODIFY `otp_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_pic`
--
ALTER TABLE `tbl_pic`
  MODIFY `pic_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_reg`
--
ALTER TABLE `tbl_reg`
  MODIFY `reg_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
