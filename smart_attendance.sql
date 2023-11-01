-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2023 at 11:54 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `event_no` int(11) NOT NULL,
  `mac_address` varchar(250) NOT NULL,
  `attendance_type` varchar(250) NOT NULL,
  `marking_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `event_id`, `user_id`, `event_no`, `mac_address`, `attendance_type`, `marking_time`) VALUES
(1, 2, 1, 1, '', 'qr_code', '2023-04-26 07:10:33'),
(2, 4, 6, 1, '', 'unique_id', '2023-03-21 18:53:13'),
(3, 3, 1, 1, '', 'unique_id', '2023-03-22 07:28:57'),
(4, 2, 6, 3, '', 'qr_code', '2023-03-26 07:28:57'),
(5, 2, 6, 2, '', 'qr_code', '2023-03-26 07:28:57'),
(9, 2, 6, 5, '00:27:15:21:85:B1', 'qr_code', '2023-05-20 13:12:22'),
(10, 2, 7, 5, '00:27:15:21:85:B1', 'qr_code', '2023-05-20 13:16:11'),
(12, 2, 6, 6, '00:27:15:21:85:B1', 'qr_code', '2023-05-21 17:51:54'),
(13, 2, 6, 7, '00:27:15:21:85:B1', 'qr_code', '2023-05-25 04:26:22'),
(14, 71, 6, 1, '00:27:15:21:85:B1', 'qr_code', '2023-06-05 20:31:12'),
(15, 72, 1, 1, '00:27:15:21:85:B1', 'qr_code', '2023-06-08 04:18:49'),
(16, 66, 6, 6, 'EA:82:E7:85:14:0A', 'qr_code', '2023-07-12 19:32:59'),
(17, 66, 24, 6, 'EA:82:E7:85:14:0A', 'qr_code', '2023-07-12 19:33:28'),
(18, 66, 27, 7, 'EA:82:E7:85:14:0A', 'qr_code', '2023-07-13 05:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `continues_event`
--

CREATE TABLE `continues_event` (
  `Cevent_id` int(11) NOT NULL,
  `event_no` int(250) NOT NULL,
  `con_event_date` date NOT NULL,
  `con_start_time` time NOT NULL,
  `con_end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `continues_event`
--

INSERT INTO `continues_event` (`Cevent_id`, `event_no`, `con_event_date`, `con_start_time`, `con_end_time`) VALUES
(66, 0, '2023-07-13', '00:05:00', '01:10:00'),
(66, 1, '2023-07-13', '00:05:00', '01:10:00'),
(66, 2, '2023-07-13', '00:05:00', '01:10:00'),
(66, 3, '2023-07-13', '00:05:00', '01:10:00'),
(66, 4, '2023-07-13', '00:05:00', '01:10:00'),
(66, 5, '2023-07-13', '00:05:00', '01:10:00'),
(66, 6, '2023-07-13', '00:05:00', '01:10:00'),
(66, 7, '2023-07-13', '10:46:00', '11:49:00'),
(67, 0, '2023-05-31', '18:34:00', '19:35:00'),
(67, 1, '2023-06-01', '16:35:00', '17:36:00'),
(67, 2, '2023-06-03', '14:45:00', '16:45:00'),
(68, 0, '2023-05-28', '12:52:00', '14:52:00'),
(68, 1, '2023-05-29', '01:49:00', '03:49:00'),
(71, 0, '2023-06-05', '01:05:00', '02:05:00'),
(71, 1, '2023-06-06', '01:29:00', '02:30:00'),
(71, 2, '2023-06-16', '12:04:00', '13:04:00'),
(72, 0, '2023-06-07', '01:03:00', '02:03:00'),
(72, 1, '2023-06-08', '09:17:00', '10:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `create_event`
--

CREATE TABLE `create_event` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_no` int(11) NOT NULL,
  `operation` varchar(50) NOT NULL,
  `attendance_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `create_event`
--

INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES
(1, 66, 0, 'create_event', 0),
(1, 66, 1, 'create_event', 0),
(1, 66, 2, 'create_event', 0),
(1, 66, 3, 'create_event', 0),
(1, 66, 4, 'create_event', 0),
(1, 66, 5, 'create_event', 0),
(1, 66, 6, 'create_event', 0),
(1, 66, 7, 'create_event', 0),
(1, 67, 0, 'create_event', 0),
(1, 67, 1, 'create_event', 0),
(1, 67, 2, 'create_event', 0),
(1, 68, 0, 'create_event', 0),
(1, 68, 1, 'create_event', 0),
(1, 69, 0, 'create_event', 0),
(1, 71, 0, 'create_event', 0),
(1, 71, 1, 'create_event', 0),
(1, 71, 2, 'create_event', 0),
(1, 72, 0, 'join', 0),
(1, 72, 1, 'join', 15),
(1, 73, 0, 'create_event', 0),
(1, 74, 0, 'create_event', 0),
(1, 75, 0, 'create_event', 0),
(2, 67, 2, 'join', 1),
(2, 68, 0, 'join', 0),
(2, 72, 0, 'create_event', 0),
(2, 72, 1, 'create_event', 0),
(6, 66, 0, 'join', 0),
(6, 66, 1, 'join', 2),
(6, 66, 2, 'join', 0),
(6, 66, 3, 'join', 0),
(6, 66, 4, 'join', 0),
(6, 66, 5, 'join', 0),
(6, 66, 6, 'join', 16),
(6, 66, 7, 'join', 0),
(6, 67, 2, 'join', 0),
(6, 68, 0, 'join', 0),
(6, 68, 1, 'join', 0),
(6, 71, 0, 'join', 0),
(6, 71, 1, 'join', 14),
(6, 71, 2, 'join', 0),
(6, 72, 0, 'pending', 0),
(7, 68, 1, 'join', 0),
(7, 71, 0, 'join', 0),
(7, 71, 1, 'join', 0),
(7, 71, 2, 'join', 0),
(24, 66, 6, 'join', 17),
(24, 66, 7, 'join', 0),
(24, 67, 2, 'join', 0),
(24, 68, 1, 'join', 0),
(27, 66, 6, 'join', 0),
(27, 66, 7, 'join', 18),
(27, 67, 2, 'join', 0),
(27, 68, 1, 'join', 0),
(28, 66, 6, 'join', 0),
(28, 66, 7, 'join', 0),
(28, 67, 2, 'join', 0),
(28, 68, 1, 'join', 0),
(29, 66, 6, 'join', 0),
(29, 66, 7, 'join', 0),
(29, 67, 2, 'join', 0),
(29, 68, 1, 'join', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `event_type` varchar(150) DEFAULT NULL,
  `encrypt_event_id` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `event_type`, `encrypt_event_id`) VALUES
(66, 'Data Structure', 'continues', 'DnXDnX'),
(67, 'Cloud Computing', 'continues', 'DnXCmW'),
(68, 'Programing Fundamental', 'continues', 'DnXBlV'),
(69, 'High voltage engineering', 'one_time', 'DnXAkU'),
(70, 'web development', 'continues', 'CmWJtD'),
(71, 'High voltage engineering', 'continues', 'CmWIsC'),
(72, 'web development', 'continues', 'CmWHrB'),
(73, 'maths', 'one_time', 'CmWGqA'),
(74, 'Data Structure', 'one_time', 'CmWFpZ'),
(75, 'Book Fair', 'one_time', 'CmWEoY');

-- --------------------------------------------------------

--
-- Table structure for table `field_name`
--

CREATE TABLE `field_name` (
  `f_name_id` int(11) NOT NULL,
  `F_event_id` int(11) NOT NULL,
  `fields_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `field_name`
--

INSERT INTO `field_name` (`f_name_id`, `F_event_id`, `fields_name`) VALUES
(10, 69, 'Name '),
(11, 69, 'Father Name'),
(12, 69, 'Email'),
(13, 69, 'Address'),
(14, 73, 'Name '),
(15, 73, 'Father Name'),
(16, 74, 'Name '),
(17, 74, 'Address'),
(18, 74, 'Gmail'),
(19, 75, 'Name '),
(20, 75, 'Father Name'),
(21, 75, 'address');

-- --------------------------------------------------------

--
-- Table structure for table `field_values`
--

CREATE TABLE `field_values` (
  `F_values_id` int(11) NOT NULL,
  `F_name_id` int(11) NOT NULL,
  `F_event_id` int(11) NOT NULL,
  `field_values` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `field_values`
--

INSERT INTO `field_values` (`F_values_id`, `F_name_id`, `F_event_id`, `field_values`) VALUES
(17, 10, 69, 'Hasnain '),
(18, 11, 69, 'Kifayat noor '),
(19, 12, 69, 'hasnainsps@gmail.com'),
(20, 13, 69, 'Charsadda '),
(21, 10, 69, 'Abdullah '),
(22, 11, 69, 'Saeeduddin '),
(23, 12, 69, 'Abdullah@gmail.com'),
(24, 13, 69, 'Mardan '),
(25, 10, 69, 'Adnan'),
(26, 11, 69, 'Khan'),
(27, 12, 69, 'Adnan@gmail.com'),
(28, 13, 69, 'Swat'),
(29, 19, 75, 'Hasnain '),
(30, 20, 75, 'hasnain@gmail.com'),
(31, 21, 75, 'Charsadda '),
(32, 19, 75, 'Hasnain '),
(33, 20, 75, 'hasnain@gmail.com'),
(34, 21, 75, 'Charsadda '),
(35, 19, 75, 'Siyam'),
(36, 20, 75, 'Khan'),
(37, 21, 75, 'Mardan '),
(38, 19, 75, 'Noorullah '),
(39, 20, 75, 'Khan'),
(40, 21, 75, 'Malakand'),
(41, 19, 75, 'Asad'),
(42, 20, 75, 'Syed'),
(43, 21, 75, 'Swat');

-- --------------------------------------------------------

--
-- Table structure for table `one_time_event`
--

CREATE TABLE `one_time_event` (
  `OTevent_id` int(11) NOT NULL,
  `one_event_date` date NOT NULL,
  `one_start_time` time NOT NULL,
  `one_end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `one_time_event`
--

INSERT INTO `one_time_event` (`OTevent_id`, `one_event_date`, `one_start_time`, `one_end_time`) VALUES
(69, '2023-05-28', '14:00:00', '19:00:00'),
(73, '2023-06-23', '10:06:00', '23:07:00'),
(74, '2023-07-03', '11:46:00', '00:58:00'),
(75, '2023-07-04', '15:06:00', '16:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `password` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `Mobile_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `image`, `password`, `status`, `Mobile_number`) VALUES
(1, 'hasnain', 'hasnainsps@gmail.com', 'assets/images/image-gallery/user1.jpg', 'abcd', 'enable', '03493894854'),
(2, 'noorullah', 'noorullah@gmail.com', 'assets/images/image-gallery/user2.jpg', '1234', 'enable', '03023481931'),
(3, 'siyam', 'siyam@gmail.com', NULL, '1234', 'enable', '03191832310'),
(5, 'abdullah', 'abdullah@gmail.com', 'assets/images/image-gallery/user4.jpg', '1234', 'enable', '03203982735'),
(6, 'adnan', 'adnan@gmail.com', 'assets/images/image-gallery/user5.jpg', '1234', 'enable', '0'),
(7, 'asad', 'asad@gmail.com', 'assets/images/image-gallery/user6.jpg', '1234', 'disable', '0'),
(24, 'sudais ', 'sudais@gmail.com', NULL, '1234', 'enable', '03499374787'),
(27, 'arsalan', 'arsalan@gmail.com', NULL, '1234', 'enable', '03475891678'),
(28, 'ahmad', 'ahmad@gmail.com', NULL, '123445678', '', ''),
(29, 'khobaib', 'khobaib@gmail.com', NULL, '12345678', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `attendance_ibfk_1` (`user_id`);

--
-- Indexes for table `continues_event`
--
ALTER TABLE `continues_event`
  ADD PRIMARY KEY (`Cevent_id`,`event_no`);

--
-- Indexes for table `create_event`
--
ALTER TABLE `create_event`
  ADD PRIMARY KEY (`user_id`,`event_id`,`event_no`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `field_name`
--
ALTER TABLE `field_name`
  ADD PRIMARY KEY (`f_name_id`),
  ADD KEY `F_event_id` (`F_event_id`);

--
-- Indexes for table `field_values`
--
ALTER TABLE `field_values`
  ADD PRIMARY KEY (`F_values_id`),
  ADD KEY `F_name_id` (`F_name_id`),
  ADD KEY `F_event_id` (`F_event_id`);

--
-- Indexes for table `one_time_event`
--
ALTER TABLE `one_time_event`
  ADD PRIMARY KEY (`OTevent_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_name` (`user_name`,`email`),
  ADD UNIQUE KEY `user_name_2` (`user_name`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `field_name`
--
ALTER TABLE `field_name`
  MODIFY `f_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `field_values`
--
ALTER TABLE `field_values`
  MODIFY `F_values_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `continues_event`
--
ALTER TABLE `continues_event`
  ADD CONSTRAINT `continues_event_ibfk_1` FOREIGN KEY (`Cevent_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `create_event`
--
ALTER TABLE `create_event`
  ADD CONSTRAINT `create_event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `create_event_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `field_name`
--
ALTER TABLE `field_name`
  ADD CONSTRAINT `field_name_ibfk_1` FOREIGN KEY (`F_event_id`) REFERENCES `one_time_event` (`OTevent_id`);

--
-- Constraints for table `field_values`
--
ALTER TABLE `field_values`
  ADD CONSTRAINT `field_values_ibfk_1` FOREIGN KEY (`F_name_id`) REFERENCES `field_name` (`f_name_id`),
  ADD CONSTRAINT `field_values_ibfk_2` FOREIGN KEY (`F_event_id`) REFERENCES `one_time_event` (`OTevent_id`);

--
-- Constraints for table `one_time_event`
--
ALTER TABLE `one_time_event`
  ADD CONSTRAINT `one_time_event_ibfk_1` FOREIGN KEY (`OTevent_id`) REFERENCES `event` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
