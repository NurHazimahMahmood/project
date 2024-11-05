-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.37 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table queue_system.appointment
CREATE TABLE IF NOT EXISTS `appointment` (
  `AppointmentID` int NOT NULL AUTO_INCREMENT,
  `PatientID` int DEFAULT NULL,
  `ServiceID` int DEFAULT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `AppointmentTime` time DEFAULT NULL,
  `QueueNumber` int DEFAULT NULL,
  `Status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'Booked',
  PRIMARY KEY (`AppointmentID`),
  KEY `PatientID` (`PatientID`),
  KEY `ServiceID` (`ServiceID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table queue_system.appointment: ~2 rows (approximately)
INSERT INTO `appointment` (`AppointmentID`, `PatientID`, `ServiceID`, `AppointmentDate`, `AppointmentTime`, `QueueNumber`, `Status`) VALUES
	(15, 27, 3, '2024-10-29', '16:56:00', 3001, 'Booked'),
	(16, 29, 6, '2024-10-29', '21:02:00', 6001, 'Booked');

-- Dumping structure for table queue_system.patients
CREATE TABLE IF NOT EXISTS `patients` (
  `PatientID` int NOT NULL AUTO_INCREMENT,
  `FullName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Address` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Gender` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  PRIMARY KEY (`PatientID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table queue_system.patients: ~6 rows (approximately)
INSERT INTO `patients` (`PatientID`, `FullName`, `DateOfBirth`, `Address`, `Gender`, `UserID`) VALUES
	(17, 'Umar Harraz', '2024-02-12', 'Jalan Sekolah Parit Saidi', 'Male', NULL),
	(18, 'Hannah Sofia', '2018-10-16', 'Jalan Sekolah Parit Saidi', 'Female', 4),
	(20, 'Haikal', '2021-06-12', 'Jalan Cheras Utama', 'Male', 3),
	(21, 'test', '2024-10-02', 'test', 'Male', 5),
	(23, 'test', '2024-10-15', 'test', 'Female', NULL),
	(26, 'Testing Edity', '2024-10-10', 'test', 'Female', 6),
	(27, 'New Patient Edited', '2024-10-06', 'test', 'Male', 7),
	(29, 'New Patient', '2024-10-31', 'test', 'Female', 7);

-- Dumping structure for table queue_system.queue_numbers
CREATE TABLE IF NOT EXISTS `queue_numbers` (
  `QueueID` int NOT NULL AUTO_INCREMENT,
  `AppointmentID` int DEFAULT NULL,
  `ServiceID` int DEFAULT NULL,
  `QueueNumber` int DEFAULT NULL,
  `IssuedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`QueueID`),
  KEY `AppointmentID` (`AppointmentID`),
  KEY `ServiceID` (`ServiceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table queue_system.queue_numbers: ~0 rows (approximately)

-- Dumping structure for table queue_system.room
CREATE TABLE IF NOT EXISTS `room` (
  `RoomID` int NOT NULL AUTO_INCREMENT,
  `RoomName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `RoomFloor` int NOT NULL,
  `RoomNumber` int NOT NULL,
  PRIMARY KEY (`RoomID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table queue_system.room: ~0 rows (approximately)

-- Dumping structure for table queue_system.service
CREATE TABLE IF NOT EXISTS `service` (
  `ServiceID` int NOT NULL AUTO_INCREMENT,
  `ServiceName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Duration` int NOT NULL,
  PRIMARY KEY (`ServiceID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table queue_system.service: ~6 rows (approximately)
INSERT INTO `service` (`ServiceID`, `ServiceName`, `Duration`) VALUES
	(1, 'Psychiatry & Psychol', 60),
	(2, 'Cardiology', 45),
	(3, 'Allergy & Immunology', 30),
	(4, 'Rehabilitation', 90),
	(5, 'Neurology', 50),
	(6, 'Orthopedic', 40);

-- Dumping structure for table queue_system.service_queues
CREATE TABLE IF NOT EXISTS `service_queues` (
  `ServiceID` int NOT NULL,
  `LastQueueNumber` int DEFAULT '0',
  PRIMARY KEY (`ServiceID`)
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table queue_system.service_queues: ~6 rows (approximately)
INSERT INTO `service_queues` (`ServiceID`, `LastQueueNumber`) VALUES
	(1, 0),
	(2, 0),
	(3, 1),
	(4, 0),
	(5, 0),
	(6, 1);

-- Dumping structure for table queue_system.users
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `FName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `LName` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Relationship` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `PhoneNumber` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Address` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Gender` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `userType` enum('user','admin') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table queue_system.users: ~3 rows (approximately)
INSERT INTO `users` (`UserID`, `Username`, `Password`, `FName`, `LName`, `Relationship`, `PhoneNumber`, `Email`, `Address`, `Gender`, `userType`) VALUES
	(1, 'AdminQueue', 'admin@123abc', '', '', '', '+60197722123', 'adminqueue@gmail.com', 'Hospital Batu Pahat', '', 'admin'),
	(3, 'hazirah33', 'hazirah33', 'NUR HAZIRAH', 'MAHMOOD', 'MOTHER', '0137715621', 'hazirah33@gmail.com', 'Jalan Sekolah Parit Saidi', 'Female', 'user'),
	(4, 'hazimah0504', 'hazimah0504', 'NUR HAZIMAH', 'MAHMOOD', 'AUNTY', '0136967703', 'hazimahmahmood0414@gmail.com', 'Jalan Sekolah Parit Saidi, Batu Pahat', 'Female', 'user'),
	(5, 'riansyh', '890990789', 'test', 'test', 'father', '567567676767', 'test@gmail.com', 'test', 'Male', 'user'),
	(6, 'testing', '12345678', 'test', 'test', 'test', '089888777333', 'test@gmail.com', 'test', 'Male', 'user'),
	(7, 'jokiproyek', '12345678', 'Joki', 'Proyek', 'Father', '6089888777666', 'jp@gmail.com', 'Jokiproyek address', 'Male', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
