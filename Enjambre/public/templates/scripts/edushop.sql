-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2024 at 03:48 PM
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
-- Database: `edushop`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_title` varchar(100) DEFAULT NULL,
  `item_description` text DEFAULT NULL,
  `item_price` decimal(10,2) DEFAULT NULL,
  `item_quantity` int(11) DEFAULT NULL,
  `item_upload_date` datetime DEFAULT current_timestamp(),
  `item_condition` varchar(255) DEFAULT NULL,
  `item_is_boosted` bit(1) DEFAULT b'0',
  `item_is_donated` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `item_title`, `item_description`, `item_price`, `item_quantity`, `item_upload_date`, `item_condition`, `item_is_boosted`, `item_is_donated`) VALUES
(5, 1028, 'Band Logo', 'WANYK a cebu based NU-Metal Band Patch', 50.00, 2, '2024-02-22 22:27:14', 'like-new', b'0', b'0'),
(6, 1028, 'Flowchart', 'Flowchart used for NETWORKING and Programming', 100.00, 3, '2024-02-22 22:29:47', 'good', b'0', b'0'),
(7, 1028, 'Prank', '2 pcs prankster lying in the area', 150.00, 2, '2024-02-22 22:31:33', 'fair', b'0', b'0'),
(8, 1028, 'Source Code', 'Pancit Canton', 100.00, 2, '2024-02-22 22:33:31', 'like-new', b'0', b'0'),
(9, 1028, 'Luck', 'Best of Luck ', 1000.00, 2, '2024-02-22 22:38:25', 'good', b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `image_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`image_id`, `item_id`, `image_path`) VALUES
(3, 5, '../users/Ralph Evan/items/Band Logo/Screenshot 2023-04-02 152750.png'),
(4, 5, '../users/Ralph Evan/items/Band Logo/Screenshot 2023-04-02 153942.png'),
(5, 6, '../users/Ralph Evan/items/Flowchart/IQ.PNG'),
(6, 6, '../users/Ralph Evan/items/Flowchart/Screenshot 2023-04-14 200513.png'),
(7, 6, '../users/Ralph Evan/items/Flowchart/Screenshot 2023-05-02 134232.png'),
(8, 7, '../users/Ralph Evan/items/Prank/Screenshot 2023-07-27 145913.png'),
(9, 7, '../users/Ralph Evan/items/Prank/Screenshot 2023-07-30 000658.png'),
(10, 8, '../users/Ralph Evan/items/Source Code/Screenshot 2023-08-07 203803.png'),
(11, 8, '../users/Ralph Evan/items/Source Code/Screenshot 2023-08-07 203913.png'),
(12, 8, '../users/Ralph Evan/items/Source Code/Screenshot 2023-08-07 204309.png'),
(13, 8, '../users/Ralph Evan/items/Source Code/Screenshot 2023-08-07 210351.png'),
(14, 8, '../users/Ralph Evan/items/Source Code/Screenshot 2023-08-15 210242.png'),
(15, 8, '../users/Ralph Evan/items/Source Code/Screenshot 2023-08-15 211029.png'),
(16, 9, '../users/Ralph Evan/items/Luck/1000002052.jpg'),
(17, 9, '../users/Ralph Evan/items/Luck/1000002051.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_password` varchar(50) DEFAULT NULL,
  `user_type` varchar(50) DEFAULT NULL,
  `user_verification_token` varchar(100) DEFAULT NULL,
  `user_createdAt` datetime DEFAULT NULL,
  `user_status` varchar(50) DEFAULT NULL,
  `user_email_verification_status` smallint(6) DEFAULT 0 COMMENT '0 = Not Verified\r\n1 = Verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_type`, `user_verification_token`, `user_createdAt`, `user_status`, `user_email_verification_status`) VALUES
(1016, 'jureyhoybia25@gmail.com', '202cb962ac59075b964b07152d234b70', 'User', '0e74e62c7f3da6c9350e891bdf54045e', '2024-02-15 22:08:09', 'Active', 0),
(1028, 'rlphevan@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'User', '3ce38f09de15c4a34d13523d8f43e7d6', '2024-02-22 05:13:46', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_first_name` varchar(50) DEFAULT NULL,
  `user_last_name` varchar(50) DEFAULT NULL,
  `user_middle_name` varchar(50) DEFAULT NULL,
  `user_address` varchar(100) DEFAULT NULL,
  `user_contact_number` varchar(50) DEFAULT NULL,
  `user_image` varchar(50) DEFAULT NULL,
  `user_date_created` date DEFAULT NULL,
  `user_academic_achievement` varchar(100) DEFAULT NULL,
  `user_academic_achievement_proof` varchar(50) DEFAULT NULL,
  `user_acadachievement_is_authenticated` int(11) DEFAULT NULL,
  `user_academic_achievement_authenticated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_first_name`, `user_last_name`, `user_middle_name`, `user_address`, `user_contact_number`, `user_image`, `user_date_created`, `user_academic_achievement`, `user_academic_achievement_proof`, `user_acadachievement_is_authenticated`, `user_academic_achievement_authenticated_by`) VALUES
(1016, 'jureyhoybia25@gmail.com', 'Jurey', 'Hoybia', 'Bascon', '351 Camomot Street', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1028, 'rlphevan@gmail.com', 'Ralph Evan', 'Cabellon', 'Deiparine', 'Bulacao, Cebu City', NULL, '../users/Ralph Evan/profile/defaultprofile.png', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1029;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `item_images`
--
ALTER TABLE `item_images`
  ADD CONSTRAINT `item_images_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
