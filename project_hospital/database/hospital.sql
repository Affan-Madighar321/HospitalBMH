-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 06:50 AM
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
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `patient_age` int(3) NOT NULL,
  `patient_gender` char(1) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `patient_address` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `patient_mobilenumber` varchar(20) NOT NULL,
  `patient_weight` int DEFAULT NULL,
  `appointment_status` varchar(20) NOT NULL DEFAULT 'Not Arrived',
  `token_number` int(2) NOT NULL,
  PRIMARY KEY (`appointment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `availability_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`availability_id`, `doctor_id`, `available_date`, `start_time`, `end_time`) VALUES
(51, 26, '2023-09-18', '10:00:00', '14:00:00'),
(52, 24, '2023-09-19', '10:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(30) NOT NULL,
  `department_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_logo`) VALUES
(14, 'General Medicine', 'logo1.jpg'),
(15, 'Orthopedics', 'logo2.jpg'),
(17, 'Ophthalmology (Eyes)', 'logo4.jpg'),
(19, 'Pulmonology', 'logo9.jpg'),
(20, 'otolaryngology', 'logo6.jpg'),
(25, 'virus & infection', 'logo3.jpg'),
(26, 'Physiotherapy', 'logo12.jpg'),
(27, 'Cardiology', 'logo5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(30) NOT NULL,
  `doctor_image` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `doctor_experience` varchar(30) NOT NULL,
  `doctor_degree` varchar(50) NOT NULL,
  `doctor_specialities` varchar(30) NOT NULL,
  `doctor_gender` varchar(6) NOT NULL,
  `doctor_age` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `doctor_name`, `doctor_image`, `department_id`, `doctor_experience`, `doctor_degree`, `doctor_specialities`, `doctor_gender`, `doctor_age`) VALUES
(23, 'hadik', 'logo7.png', 14, '2year', 'MBBS, MD', 'General Medicine', 'Male', 22),
(24, 'chintan', 'logo7.png', 15, '2year', 'MBBS, MS', 'Orthopaedics', 'Male', 22),
(26, 'DR.PRAGATI ', 'logo8.png', 17, '2year', ' MBBS, MS', 'eyec are', 'Male', 26);

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `facility_id` int(11) NOT NULL,
  `facility_name` varchar(30) NOT NULL,
  `facility_logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`facility_id`, `facility_name`, `facility_logo`) VALUES
(3, 'ICU', 'icu.jpg'),
(4, 'X-ray Machine', 'xry.jpg'),
(5, 'ECG Machine', 'ecg.jpg'),
(6, 'Ambulance Service', 'logo8.jpg'),
(7, 'Operation Theatre', 'opthe.jpg'),
(8, 'Pharmacy', 'Pharmacy.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `feedback_name` varchar(30) NOT NULL,
  `feedback_mobilenumber` varchar(13) NOT NULL,
  `feedback` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_dob` varchar(32) DEFAULT NULL,
  `user_mobilenumber` varchar(13) NOT NULL,
  `user_age` int(3) NOT NULL,
  `user_gender` varchar(6) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_type` varchar(12) NOT NULL DEFAULT 'user',
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_dob`, `user_mobilenumber`, `user_age`, `user_gender`, `user_email`, `user_password`, `user_type`, `doctor_id`) VALUES
(32, 'admin', '287a00bd2c196a6594352f3dda8f31d8', '', 25, 'Male', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin', NULL),
(33, 'pooja ', 'a54a6f28247c00bceacc830ff6eace50', '7359058873', 18, 'female', 'rec@gmail.com', 'ee9322b492acd9126d329e3fcacef044', 'receptionist', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`availability_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
