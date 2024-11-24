-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 01:37 PM
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
-- Database: `membershiphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `equipment` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `equipment`, `quantity`, `price`, `purchase_date`, `created_at`) VALUES
(13, 'Smith A+ with Counter Weight', 1, 75000, '2024-11-23', '2024-11-23 13:57:03'),
(14, 'Smith A+ with Counter Weight', 1, 75000, '2023-05-15', '2024-11-24 03:20:09'),
(15, 'Leg Ext. & Lying Leg Curl Combo Plate Load Machine', 1, 21500, '2023-05-15', '2024-11-24 03:20:33'),
(16, 'Lat Pulldown Machine with 200lb Wt. Stack B', 1, 55000, '2018-03-17', '2024-11-24 03:21:08'),
(17, 'Olympic Adjustable Flat to Incline Bench', 1, 27000, '2018-03-17', '2024-11-24 03:21:39'),
(18, 'Preacher Curl Bench', 1, 11000, '2018-03-16', '2024-11-24 03:22:17'),
(19, '2.5kg . Olympic Hole Rubber Plates', 8, 5880, '2018-03-16', '2024-11-24 03:22:57'),
(20, '10kg. Olympic Hole Rubber Plates', 8, 11760, '2018-03-16', '2024-11-24 03:23:48'),
(21, '15kg. Olympic Hole Rubber Plates', 8, 17640, '2018-03-16', '2024-11-24 03:24:26'),
(22, '20kg. Olympic Hole Rubber Plates', 6, 17640, '2018-03-16', '2024-11-24 03:24:56'),
(23, 'Long Adjustable Sit-Up Bench with Wheels', 1, 15500, '2022-05-25', '2024-11-24 03:25:53'),
(24, 'Fixed Rubber Barbell 20 to 60 lbs (Straight & EZ) with Rack', 1, 42000, '2022-06-11', '2024-11-24 03:26:44'),
(25, 'ISO Shoulder Press Leverage Plate Load Machine', 1, 42000, '2022-07-18', '2024-11-24 03:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `membership_type` int(11) NOT NULL,
  `membership_number` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `qrcode` text NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `fullname`, `email`, `password`, `dob`, `gender`, `contact_number`, `address`, `country`, `postcode`, `occupation`, `membership_type`, `membership_number`, `created_at`, `photo`, `expiry_date`, `qrcode`, `role`) VALUES
(36, 'Admin', 'admin@mail.com', '', '1990-01-01', 'Male', '+1 (234) 567-8901', '123 Main St', '', '', '', 1, 'CA-99999', '2024-11-16 09:32:05', '', NULL, '', 'admin'),
(41, 'Edrick James Acerado', 'edrickjamesa@gmail.com', '', '2002-07-29', 'Male', '09388924203', 'Gabawan, Daraga, Albay', '', '', '', 1, 'CA-154698', '2024-11-24 11:01:20', '', '2025-02-24', 'Edrick James Acerado17324460801732446080.2802', 'user'),
(42, 'John Renzo Toledo', 'toledojohnrenzo32@gmail.com', '', '2002-07-23', 'Male', '09519039279', 'Sumlang, Camalig, Albay', '', '', '', 1, 'CA-617741', '2024-11-24 11:02:43', '', '2024-12-24', 'John Renzo Toledo17324461631732446163.1002', 'user'),
(43, 'Loen Dave Bosogon', 'loendaveb@gmail.com', '', '2002-05-28', 'Male', '09075002792', 'Brgy. 2 Camalig, Albay', '', '', '', 1, 'CA-707844', '2024-11-24 11:05:17', '', '2023-07-24', 'Loen Dave Bosogon17324463171732446317.3189', 'user'),
(44, 'John Leonard Solano', 'solanojohnleonard@gmail.com', '', '2001-04-24', 'Male', '09958676593', 'Brgy. 2 Camalig, Albay', '', '', '', 12, 'CA-359569', '2024-11-24 11:07:39', '', '2024-12-24', 'John Leonard Solano17324464591732446459.11', 'user'),
(45, 'Christian Jay Nierva', 'onepunch358@gmail.com', '', '2001-06-06', 'Male', '09511476546', 'Quirangay, Camalig, Albay', '', '', '', 1, 'CA-333252', '2024-11-24 11:09:59', '', '2023-10-27', 'Christian Jay Nierva17324465991732446599.979', 'user'),
(46, 'Clint De Villa', 'clintnapadevilla@gmail.com', '', '2001-11-16', 'Male', '09277404709', 'Tagaytay, Camalig, Albay', '', '', '', 1, 'CA-870580', '2024-11-24 11:11:24', '', '2025-11-24', 'Clint De Villa17324466831732446683.9566', 'user'),
(47, 'Aaron Bonaobra', 'aaronbonaobra@gmail.com', '', '2003-01-27', 'Male', '09637076992', 'Cabangan, Legazpi, Albay', '', '', '', 12, 'CA-312621', '2024-11-24 11:13:02', '', '2024-12-24', 'Aaron Bonaobra17324467821732446782.2415', 'user'),
(48, 'Corazon Noveno', 'corazonnoveno@gmail.com', '', '1960-09-19', 'Female', '09193456781', 'Brgy. 1 Camalig, Albay', '', '', '', 13, 'CA-459258', '2024-11-24 11:15:03', '', '2024-12-24', 'Corazon Noveno17324469031732446903.7746', 'user'),
(49, 'Hazel Anne Retuerma', 'retuermahazel@gmail.com', '', '2002-10-11', 'Female', '09274985622', 'Masarawag, Guinobatan, Albay', '', '', '', 12, 'CA-416314', '2024-11-24 11:16:57', '', '2025-02-24', 'Hazel Anne Retuerma17324470171732447017.0556', 'user'),
(52, 'Loraine Jane Naje', 'lorainejanen@gmail.com', '', '2007-02-27', 'Female', '09928826576', 'Baligang, Camalig, Albay', '', '', '', 16, 'CA-991138', '2024-11-24 12:30:31', '', '2024-11-25', 'Loraine Jane Naje17324514311732451431.1398', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `membership_types`
--

CREATE TABLE `membership_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `membership_types`
--

INSERT INTO `membership_types` (`id`, `type`, `amount`) VALUES
(1, 'Standard', 800),
(12, 'Student', 700),
(13, 'Senior', 600),
(16, 'Session', 100);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `member` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `member`, `date`, `mode`, `reference`, `created_at`) VALUES
(33, '41', '2024-11-24', 'Gcash', '3475820193', '2024-11-24 11:01:20'),
(34, '42', '2024-11-24', 'Gcash', '5739602814', '2024-11-24 11:02:43'),
(35, '43', '2024-11-24', 'Paymaya', '9034726518', '2024-11-24 11:05:17'),
(36, '44', '2024-11-24', 'Cash', '', '2024-11-24 11:07:39'),
(37, '45', '2024-11-24', 'Gcash', '3475820193', '2024-11-24 11:09:59'),
(38, '46', '2024-11-24', 'Paymaya', '5761893042', '2024-11-24 11:11:24'),
(39, '47', '2024-11-24', 'Cash', '', '2024-11-24 11:13:02'),
(40, '48', '2024-11-24', 'Cash', '', '2024-11-24 11:15:03'),
(41, '49', '2024-11-24', 'Gcash', '2654890371', '2024-11-24 11:16:57'),
(42, '50', '2024-11-24', 'cash', '', '2024-11-24 11:36:45'),
(43, '51', '2024-11-24', 'cash', '', '2024-11-24 12:20:03'),
(44, '52', '2024-11-24', 'Cash', '', '2024-11-24 12:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `renew`
--

CREATE TABLE `renew` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `membership_type` int(11) NOT NULL,
  `upto` varchar(255) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `renew_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `renew`
--

INSERT INTO `renew` (`id`, `member_id`, `total_amount`, `membership_type`, `upto`, `payment_id`, `renew_date`) VALUES
(50, 41, 2400.00, 1, '3', 33, '2024-11-24'),
(51, 42, 800.00, 1, '1', 34, '2024-11-24'),
(52, 43, 4800.00, 1, '6', 35, '2024-11-24'),
(53, 44, 700.00, 12, '1', 36, '2024-11-24'),
(54, 45, 4800.00, 1, '6', 37, '2024-11-24'),
(55, 46, 9600.00, 1, '12', 38, '2024-11-24'),
(56, 47, 700.00, 12, '1', 39, '2024-11-24'),
(57, 48, 600.00, 13, '1', 40, '2024-11-24'),
(58, 49, 2100.00, 12, '3', 41, '2024-11-24'),
(61, 52, 100.00, 16, '111', 44, '2024-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `system_name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `currency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_name`, `logo`, `currency`) VALUES
(1, 'Camalig Fitness Gym', 'uploads/mlg.png', 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `member_id`, `registration_date`, `updated_date`) VALUES
(1, 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '2024-11-10 13:10:38', '2024-11-10 14:28:29'),
(72, 'asdasd@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 03:39:34', '2024-11-24 03:39:34'),
(73, 'edrickjamesa@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:01:20', '2024-11-24 11:01:20'),
(74, 'toledojohnrenzo32@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:02:43', '2024-11-24 11:02:43'),
(75, 'loendaveb@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:05:17', '2024-11-24 11:05:17'),
(76, 'solanojohnleonard@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:07:39', '2024-11-24 11:07:39'),
(77, 'onepunch358@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:09:59', '2024-11-24 11:09:59'),
(78, 'clintnapadevilla@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:11:24', '2024-11-24 11:11:24'),
(79, 'aaronbonaobra@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:13:02', '2024-11-24 11:13:02'),
(80, 'corazonnoveno@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:15:03', '2024-11-24 11:15:03'),
(81, 'retuermahazel@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:16:57', '2024-11-24 11:16:57'),
(82, 'test@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 11:36:45', '2024-11-24 11:36:45'),
(83, 'testicles@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 12:20:03', '2024-11-24 12:20:03'),
(84, 'lorainejanen@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-11-24 12:30:31', '2024-11-24 12:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `workout_lists`
--

CREATE TABLE `workout_lists` (
  `workout_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `workout_name` varchar(255) NOT NULL,
  `target_muscle_group` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_lists`
--

INSERT INTO `workout_lists` (`workout_id`, `description`, `workout_name`, `target_muscle_group`) VALUES
(43, 'A rowing exercise using a cable machine to strengthen the back and biceps.', 'Cable Rows', 'Back, Biceps'),
(44, 'A shoulder exercise performed with dumbbells or a barbell to target the deltoid muscles.', 'Shoulder Press', 'Shoulders, Triceps'),
(45, 'A compound exercise that targets the back, glutes, and hamstrings by lifting a barbell from the ground to hip height.', 'Deadlifts', 'Back, Glutes, Hamstrings'),
(46, 'A chest exercise performed on a bench with a barbell to strengthen the pectorals and triceps.', 'Bench Press', 'Chest, Triceps'),
(47, 'An upper body exercise where you pull your body up towards a bar to strengthen the back, biceps, and shoulders.', 'Pull-Ups', 'Back, Biceps, Shoulders'),
(48, 'A bodyweight exercise where you push your body up from the ground to target the chest, triceps, and shoulders.', 'Push-Ups', 'Chest, Triceps, Shoulders'),
(49, 'A compound lower body exercise that targets the quadriceps, hamstrings, and glutes by lowering and raising the body with a barbell or body weight.', 'Squats', 'Quadriceps, Hamstrings, Glutes'),
(50, 'A lower body exercise where you step forward into a lunge position to target the legs and glutes.', 'Lunges', 'Quadriceps, Hamstrings, Glutes'),
(51, 'An isolation exercise that targets the biceps by lifting a dumbbell or barbell towards the shoulder.', 'Bicep Curls', 'Biceps'),
(52, 'An exercise performed by lowering and raising the body using parallel bars, primarily targeting the triceps.', 'Tricep Dips', 'Triceps');

-- --------------------------------------------------------

--
-- Table structure for table `workout_program`
--

CREATE TABLE `workout_program` (
  `id` int(11) NOT NULL,
  `workout_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `reps` varchar(255) DEFAULT NULL,
  `sets` int(11) DEFAULT NULL,
  `workout_split` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership_type` (`membership_type`);

--
-- Indexes for table `membership_types`
--
ALTER TABLE `membership_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renew`
--
ALTER TABLE `renew`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `workout_lists`
--
ALTER TABLE `workout_lists`
  ADD PRIMARY KEY (`workout_id`);

--
-- Indexes for table `workout_program`
--
ALTER TABLE `workout_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_id` (`workout_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `membership_types`
--
ALTER TABLE `membership_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `renew`
--
ALTER TABLE `renew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `workout_lists`
--
ALTER TABLE `workout_lists`
  MODIFY `workout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `workout_program`
--
ALTER TABLE `workout_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `renew`
--
ALTER TABLE `renew`
  ADD CONSTRAINT `renew_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `workout_program`
--
ALTER TABLE `workout_program`
  ADD CONSTRAINT `workout_program_ibfk_1` FOREIGN KEY (`workout_id`) REFERENCES `workout_lists` (`workout_id`),
  ADD CONSTRAINT `workout_program_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
