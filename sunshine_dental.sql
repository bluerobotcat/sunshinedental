-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 12, 2023 at 09:53 AM
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
-- Database: `sunshine_dental`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `DentistID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `AppointmentTime` time NOT NULL,
  `Status` enum('scheduled','completed','cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`AppointmentID`, `PatientID`, `DentistID`, `ServiceID`, `AppointmentDate`, `AppointmentTime`, `Status`) VALUES
(1, 15, 15, 15, '2023-12-15', '13:30:00', 'scheduled'),
(2, 14, 14, 14, '2023-12-14', '11:45:00', 'completed'),
(3, 13, 13, 13, '2023-12-13', '15:15:00', 'scheduled'),
(4, 12, 12, 12, '2023-12-12', '14:30:00', 'scheduled'),
(5, 11, 11, 11, '2023-12-11', '10:30:00', 'scheduled'),
(6, 10, 13, 10, '2023-12-10', '11:00:00', 'cancelled'),
(7, 9, 15, 9, '2023-12-09', '13:45:00', 'scheduled'),
(8, 8, 14, 8, '2023-12-08', '16:00:00', 'scheduled'),
(9, 7, 15, 7, '2023-12-07', '09:30:00', 'completed'),
(10, 6, 15, 6, '2023-12-06', '12:15:00', 'scheduled'),
(11, 5, 15, 5, '2023-12-05', '14:30:00', 'cancelled'),
(12, 4, 15, 4, '2023-12-04', '15:45:00', 'completed'),
(13, 3, 15, 3, '2023-12-03', '13:00:00', 'completed'),
(14, 2, 15, 2, '2023-12-02', '11:30:00', 'scheduled'),
(15, 1, 15, 1, '2023-12-01', '10:00:00', 'scheduled'),
(16, 10, 15, 4, '2023-11-10', '09:00:00', 'scheduled'),
(17, 12, 15, 2, '2023-11-11', '14:00:00', 'completed'),
(18, 13, 15, 3, '2023-11-15', '11:30:00', 'scheduled'),
(19, 14, 15, 4, '2023-11-18', '10:15:00', 'scheduled'),
(20, 15, 15, 5, '2023-11-20', '13:45:00', 'scheduled'),
(21, 6, 15, 6, '2023-11-25', '15:30:00', 'cancelled'),
(22, 7, 14, 7, '2023-11-28', '09:30:00', 'completed'),
(23, 8, 14, 8, '2023-11-30', '16:30:00', 'scheduled'),
(24, 1, 15, 1, '2023-11-10', '09:00:00', 'scheduled'),
(25, 32, 15, 2, '2023-11-11', '14:00:00', 'completed'),
(41, 3, 15, 3, '2023-11-15', '11:30:00', 'scheduled'),
(42, 4, 15, 4, '2023-11-18', '10:15:00', ''),
(43, 5, 15, 5, '2023-11-20', '13:45:00', 'scheduled'),
(44, 6, 15, 6, '2023-11-25', '15:30:00', ''),
(45, 7, 15, 7, '2023-11-28', '09:30:00', 'completed'),
(46, 8, 15, 8, '2023-11-30', '16:30:00', 'scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `dentists`
--

CREATE TABLE `dentists` (
  `DentistID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Specialization` varchar(255) NOT NULL,
  `ContactInfo` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Experience` varchar(255) DEFAULT NULL,
  `imgsrc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentists`
--

INSERT INTO `dentists` (`DentistID`, `FirstName`, `LastName`, `Specialization`, `ContactInfo`, `Email`, `Password`, `Experience`, `imgsrc`) VALUES
(1, 'Darren', 'Doe', 'Dental Implant Fixing and Tooth Extraction', '+65 9362 4567', 'dr.doe@example.com', 'hashed_password1', '20 years of experience in Dental Implant Fixing and Impacted Tooth Extraction', 'images/doctor-1.png'),
(2, 'Julian', 'Lee', 'Invisalign braces, Veneers / Laminates, Orthodontics', '+65 9362 4568', 'dr.julian@example.com', 'hashed_password2', 'Specialist in Invisalign braces, Veneers / Laminates, and Orthodontics', 'images/doctor-2.png'),
(3, 'William', 'Homes', 'Routine Exams (Scaling & Polishing)', '+65 9362 4569', 'dr.william@example.com', 'hashed_password3', 'Specialist in Routine Exams (Scaling & Polishing)', 'images/doctor-3.png'),
(4, 'Rachel', 'Green', 'Orthodontics', '+65 9362 4570', 'dr.rachel@example.com', 'hashed_password4', 'Specialized in Orthodontics. Committed to creating beautiful smiles', 'images/doctor-4.png'),
(5, 'Steven', 'Choi', 'Dental Implant Fixing and Tooth Extraction', '+65 9362 4571', 'dr.steven@example.com', 'hashed_password5', 'Specialized in Dental Implant Fixing and Impacted Tooth Extraction', 'images/doctor-5.png'),
(6, 'Ashley', 'Khoo', 'Routine Exams (Scaling & Polishing)', '+65 9362 4572', 'dr.ashley@example.com', 'hashed_password6', 'Specialized in Routine Exams (Scaling & Polishing)', 'images/doctor-6.png'),
(7, 'Tiffany', 'Koh', 'Invisalign braces and Veneers / Laminates', '+65 9362 4573', 'dr.tiffany@example.com', 'hashed_password7', 'Specialized in Invisalign braces and Veneers / Laminates', 'images/doctor-7.png'),
(8, 'Joseph', 'Liew', 'Orthodontics and Dental Implant Fixing', '+65 9362 4574', 'dr.joseph@example.com', 'hashed_password8', 'Specialized in Orthodontics and Dental Implant Fixing', 'images/doctor-8.png'),
(9, 'Limous', 'Ng', 'Orthodontics', '+65 9123 4567', 'dr.limous@example.com', 'hashed_password1', 'No specific experience', 'images/doctor-9.png'),
(10, 'Tank', 'Bay', 'Pedodontics', '+65 8234 5678', 'dr.tang@example.com', 'hashed_password2', 'No specific experience', 'images/doctor-10.png'),
(11, 'Bob', 'Goh', 'Oral Surgery', '+65 9271 5678', 'dr.goh@example.com', 'hashed_password11', 'No specific experience', 'images/doctor-11.png'),
(12, 'Priscilla', 'Tay', 'Endodontics', '+65 8143 4567', 'dr.tay@example.com', 'hashed_password12', 'No specific experience', 'images/doctor-12.png'),
(13, 'Linus', 'Chua', 'Orthodontics', '+65 9187 1234', 'dr.linus@example.com', 'hashed_password13', 'No specific experience', 'images/doctor-13.png'),
(14, 'Tammy', 'Wong', 'Pedodontics', '+65 8562 9876', 'dr.tamwong@example.com', 'hashed_password14', 'No specific experience', 'images/doctor-14.png'),
(15, 'Marvis', 'Koh', 'Periodontics', '+65 9362 4567', 'dr.marviskoh@example.com', 'hashed_password15', 'No specific experience', 'images/doctor-15.png');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `PatientID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `ContactInfo` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`PatientID`, `FirstName`, `LastName`, `ContactInfo`, `Email`, `Password`) VALUES
(1, 'Elias', 'Tan', '+65 9123 4567', 'elias@example.com', 'hashed_password1'),
(2, 'Alya', 'Lim', '+65 8234 5678', 'alya@example.com', 'hashed_password2'),
(3, 'Rayan', 'Ng', '+65 8765 4321', 'rayan@example.com', 'hashed_password3'),
(4, 'Zara', 'Koh', '+65 9321 7890', 'zara@example.com', 'hashed_password4'),
(5, 'Aiden', 'Wong', '+65 9456 1234', 'aiden@example.com', 'hashed_password5'),
(6, 'Maya', 'Teo', '+65 9123 7890', 'maya@example.com', 'hashed_password6'),
(7, 'Daniel', 'Chua', '+65 8234 5678', 'daniel@example.com', 'hashed_password7'),
(8, 'Zoey', 'Tan', '+65 8123 4567', 'zoey@example.com', 'hashed_password8'),
(9, 'Nathan', 'Goh', '+65 9345 6123', 'nathan@example.com', 'hashed_password9'),
(10, 'Sophia', 'Lim', '+65 8156 2378', 'sophia@example.com', 'hashed_password10'),
(11, 'Liam', 'Ong', '+65 9271 5678', 'liam@example.com', 'hashed_password11'),
(12, 'Olivia', 'Koh', '+65 8143 4567', 'olivia@example.com', 'hashed_password12'),
(13, 'Ethan', 'Wong', '+65 9187 1234', 'ethan@example.com', 'hashed_password13'),
(14, 'Mia', 'Neo', '+65 8562 9876', 'mia@example.com', 'hashed_password14'),
(15, 'Emma', 'Chen', '+65 9362 4567', 'emma@example.com', 'hashed_password15'),
(31, 'Mina', 'Kwon', '+6581234567', 'minakwon@eg.com', '$2y$10$Hp1OUnHC4UQnjx5SBCyj5.fJ.FBTrSmK8QMP44zJ4gBzZEJO3cOj.'),
(32, 'A', 'A', '+6581231234', 'a@a', 'a'),
(33, 'a', 'a', '+6581234567', 'q@q', '$2y$10$57qPpTIAgkQxoVuc3X1Lo.LffaNi6EbDt5UcNULLceaCXIbAsvwQC');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceName` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `Description`, `Cost`) VALUES
(1, 'Dental Cleaning', 'Routine dental cleaning and checkup', 100.00),
(2, 'Cavity Filling', 'Treatment for tooth cavities', 150.00),
(3, 'Teeth Whitening', 'Professional teeth whitening procedure', 200.00),
(4, 'Braces Installation', 'Orthodontic treatment with braces', 2500.00),
(5, 'Root Canal', 'Treatment for infected tooth pulp', 350.00),
(6, 'Dental Implants', 'Implant surgery for missing teeth', 1200.00),
(7, 'Dentures', 'Removable dental prosthetics', 800.00),
(8, 'Tooth Extraction', 'Removal of a problematic tooth', 100.00),
(9, 'Orthodontic Consultation', 'Consultation for orthodontic treatment', 50.00),
(10, 'Gum Surgery', 'Surgical treatment for gum issues', 400.00),
(11, 'Dental X-Rays', 'Radiography for dental diagnostics', 80.00),
(12, 'Crowns and Bridges', 'Restoration of damaged teeth', 300.00),
(13, 'Teeth Cleaning and Polishing', 'Cleaning and polishing for teeth', 60.00),
(14, 'Teeth Veneers', 'Custom-made veneers for tooth aesthetics', 350.00),
(15, 'Oral Surgery', 'Surgical procedures for oral health', 700.00);

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `SlotID` int(11) NOT NULL,
  `DentistID` int(11) NOT NULL,
  `SlotDateTime` datetime NOT NULL,
  `IsBooked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`SlotID`, `DentistID`, `SlotDateTime`, `IsBooked`) VALUES
(1, 15, '2023-12-01 10:00:00', 0),
(2, 15, '2023-12-01 11:00:00', 0),
(3, 15, '2023-12-01 12:00:00', 0),
(4, 14, '2023-12-02 10:30:00', 0),
(5, 15, '2023-12-02 11:30:00', 0),
(6, 15, '2023-12-02 13:30:00', 0),
(7, 15, '2023-12-03 09:00:00', 0),
(8, 15, '2023-12-03 10:00:00', 0),
(9, 15, '2023-12-03 11:00:00', 0),
(10, 15, '2023-12-04 14:00:00', 0),
(11, 15, '2023-12-04 15:00:00', 0),
(12, 15, '2023-12-04 16:00:00', 0),
(13, 15, '2023-12-05 13:00:00', 0),
(14, 15, '2023-12-05 14:00:00', 0),
(15, 15, '2023-12-05 15:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `PatientID` (`PatientID`),
  ADD KEY `DentistID` (`DentistID`),
  ADD KEY `ServiceID` (`ServiceID`);

--
-- Indexes for table `dentists`
--
ALTER TABLE `dentists`
  ADD PRIMARY KEY (`DentistID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`PatientID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`SlotID`),
  ADD KEY `DentistID` (`DentistID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `dentists`
--
ALTER TABLE `dentists`
  MODIFY `DentistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6001;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `SlotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `patients` (`PatientID`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`DentistID`) REFERENCES `dentists` (`DentistID`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`ServiceID`) REFERENCES `services` (`ServiceID`);

--
-- Constraints for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD CONSTRAINT `timeslots_ibfk_1` FOREIGN KEY (`DentistID`) REFERENCES `dentists` (`DentistID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
