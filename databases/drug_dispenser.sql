-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 03:39 AM
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
-- Database: `drug_dispenser`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `administratorId` int(11) NOT NULL,
  `emailAddress` varchar(128) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`administratorId`, `emailAddress`, `passwordHash`) VALUES
(1, 'administrator@admin.com', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02'),
(2, 'Mercy@admin.com', '$2y$10$FMLnez1kbmi4aABIn1KoAOtsU7K9WssnskGoklMSf8nBnloc3PUES'),
(3, 'admin1@gmail.com', '$2y$10$h2HMqciCUfHRcWyK2ANPju4zi6EugWQIst6XlpNyq5P2DKvNtgHRO'),
(4, 'kilonza@gmail.com', '$2y$10$8rLRzghMSTT./QEa9tCWU.aaxsXaIHziMP6MjCKHdRLiX8H3/l3Sm');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `consultationID` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateScheduled` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `startTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(32) DEFAULT NULL,
  `patientDoctorId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consultationID`, `dateCreated`, `dateScheduled`, `startTime`, `endTime`, `status`, `patientDoctorId`) VALUES
(31, '2023-06-20 13:53:56', '2023-06-22 18:00:00', '2023-06-19 19:02:27', '2023-06-19 19:59:32', 'approved', 49),
(32, '2023-06-20 13:53:56', '2023-06-25 18:00:00', '2023-06-19 22:22:02', '2023-06-19 19:24:51', 'approved', 50),
(33, '2023-06-20 13:53:56', '2023-06-23 18:00:00', '2023-06-20 03:17:01', '2023-06-19 19:21:22', 'approved', 51),
(34, '2023-06-20 13:53:56', '2023-06-23 18:00:00', '2023-06-19 18:46:23', '2023-06-19 19:18:02', 'approved', 52),
(35, '2023-06-20 13:53:56', '2023-06-22 18:00:00', '2023-06-19 21:11:10', '2023-06-19 19:26:34', 'approved', 53),
(36, '2023-06-20 13:53:56', '2023-06-25 18:00:00', '2023-06-20 12:01:57', '2023-06-19 19:18:31', 'approved', 54),
(37, '2023-06-20 13:53:56', '2023-06-21 18:00:00', '2023-06-20 06:34:16', '2023-06-19 19:44:55', 'approved', 56),
(38, '2023-06-20 13:53:56', '2023-06-20 18:00:00', '2023-06-20 08:49:04', '2023-06-19 19:34:07', 'approved', 57),
(39, '2023-06-20 13:53:56', '2023-06-26 18:00:00', '2023-06-20 00:00:27', '2023-06-19 19:16:39', 'approved', 58),
(40, '2023-06-20 13:53:56', '2023-06-24 18:00:00', '2023-06-20 02:31:06', '2023-06-19 19:51:42', 'approved', 59),
(46, '2023-06-20 13:53:57', '2023-06-20 18:00:00', '2023-06-20 09:16:07', '2023-06-19 19:26:52', 'approved', 49),
(47, '2023-06-20 13:53:57', '2023-06-21 18:00:00', '2023-06-20 01:30:04', '2023-06-19 19:34:07', 'approved', 50),
(48, '2023-06-20 13:53:57', '2023-06-26 18:00:00', '2023-06-20 13:50:45', '2023-06-19 19:24:52', 'approved', 51),
(49, '2023-06-20 13:53:57', '2023-06-23 18:00:00', '2023-06-20 11:08:32', '2023-06-19 19:47:48', 'approved', 52),
(50, '2023-06-20 13:53:57', '2023-06-25 18:00:00', '2023-06-20 13:32:28', '2023-06-19 19:32:54', 'approved', 53),
(51, '2023-06-20 13:53:57', '2023-06-21 18:00:00', '2023-06-20 14:27:04', '2023-06-19 19:21:44', 'approved', 54),
(52, '2023-06-20 13:53:57', '2023-06-21 18:00:00', '2023-06-19 22:29:30', '2023-06-19 19:10:17', 'approved', 56),
(53, '2023-06-20 13:53:57', '2023-06-21 18:00:00', '2023-06-20 17:09:34', '2023-06-19 19:56:14', 'approved', 57),
(54, '2023-06-20 13:53:57', '2023-06-25 18:00:00', '2023-06-19 21:29:49', '2023-06-19 19:21:14', 'approved', 58),
(55, '2023-06-20 13:53:57', '2023-06-21 18:00:00', '2023-06-20 08:27:29', '2023-06-19 19:00:48', 'approved', 59),
(61, '2023-06-20 15:09:32', '2023-06-24 18:00:00', '2023-06-25 04:00:00', '2023-06-25 05:00:00', NULL, 51),
(62, '2023-06-20 15:11:17', '2023-06-22 18:00:00', '2023-06-23 05:00:00', '2023-06-22 18:00:00', 'pending', 61),
(63, '2023-06-21 13:36:24', '2023-06-21 18:00:00', '2023-06-22 05:30:00', '2023-06-22 06:30:00', 'pending', 62),
(64, '2023-06-22 08:45:33', '2023-06-22 21:00:00', '2023-06-23 10:01:00', '2023-06-23 11:01:00', 'pending', 60),
(65, '2023-07-20 15:09:46', '2024-12-02 21:00:00', '2023-07-20 03:09:00', '2023-07-20 03:09:00', 'pending', 64),
(66, '2023-07-20 15:34:11', '2023-07-20 21:00:00', '2023-07-20 15:33:00', '2023-07-28 03:33:00', 'pending', 65),
(67, '2023-07-28 10:09:28', '2023-07-27 21:00:00', '2023-07-27 22:10:00', '2023-07-28 10:12:00', 'pending', 66);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_payment`
--

CREATE TABLE `consultation_payment` (
  `consultationPaymentId` int(11) NOT NULL,
  `consultationId` int(11) DEFAULT NULL,
  `amountCashed` decimal(10,2) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `method` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `contractId` int(11) NOT NULL,
  `startDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `endDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text DEFAULT NULL,
  `pharmacyId` int(11) DEFAULT NULL,
  `pharmaceuticalId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`contractId`, `startDate`, `endDate`, `description`, `pharmacyId`, `pharmaceuticalId`) VALUES
(1, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 7, 2),
(2, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 8, 3),
(3, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 8, 5),
(4, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 6, 3),
(5, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 4, 3),
(6, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 6, 2),
(7, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 9, 5),
(8, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 6, 3),
(9, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 2, 3),
(10, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 4, 1),
(11, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 2, 3),
(12, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 5, 4),
(13, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 7, 5),
(14, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 3, 3),
(15, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 7, 1),
(16, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 9, 5),
(17, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 3, 1),
(18, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 3, 1),
(19, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 1, 4),
(20, '2023-06-20 13:16:11', '2024-06-20 13:16:11', 'Contract description', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `diagnosisId` int(11) NOT NULL,
  `consultationId` int(11) DEFAULT NULL,
  `symptom` varchar(128) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`diagnosisId`, `consultationId`, `symptom`, `description`) VALUES
(1, 48, 'Fever', 'The patient is experiencing an elevated body temperature above the normal range.'),
(2, 31, 'Headache', 'The patient is experiencing pain or discomfort in the head, ranging from mild to severe intensity. It can be a dull ache, a throbbing sensation, or a feeling of pressure.'),
(3, 31, 'Sore throat', 'The patient has irritation, pain, or a scratchy sensation in the throat. Swallowing, speaking, or eating may worsen the discomfort.\r\n'),
(4, 31, 'Shortness of breath', 'The patient is experiencing difficulty breathing or a sensation of breathlessness. It may feel like the individual is not getting enough air or cannot take deep breaths.'),
(5, 63, 'Nausea', 'The patient feels an unsettled stomach and the urge to vomit, although actual vomiting may or may not occur.'),
(6, 63, 'Diarrhea', 'The patient is passing loose, watery stools more frequently than usual.'),
(7, 63, 'Chest pain', 'The patient experiences discomfort or aching in the chest area, which may be sharp, stabbing, or a pressure-like sensation.'),
(8, 46, 'Dizziness', 'The patient feels lightheaded, unsteady, or off-balance, as if the surrounding environment is spinning or moving.'),
(9, 46, 'Muscle aches', 'The patient experiences generalized or localized muscle pain, which can range from a dull ache to sharp, cramping sensations.'),
(10, 46, 'Swollen glands', 'The patient notices enlarged or tender lymph nodes, typically in the neck, armpits, or groin area.'),
(11, 46, 'Abdominal pain', 'The patient experiences discomfort or pain in the stomach or abdominal area. It can range from mild cramping to severe, sharp pain.'),
(12, 61, 'Severe Headache', 'Patient feels severe headache and protracted thumping leading to extreme wriggling.'),
(13, 65, 'Headache, nausia, fever', '.....................'),
(14, 67, 'Headache, nausia, fever', ',./');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctorId` int(11) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `specialization` varchar(128) NOT NULL,
  `healthCenterId` int(11) NOT NULL,
  `SSN` int(11) NOT NULL,
  `startYear` int(11) NOT NULL,
  `activeStatus` tinyint(1) DEFAULT 1,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctorId`, `firstName`, `lastName`, `gender`, `emailAddress`, `phoneNumber`, `specialization`, `healthCenterId`, `SSN`, `startYear`, `activeStatus`, `passwordHash`) VALUES
(1, 'Waiharo', 'Njogu', 'Male', 'waiharo.njogu@gmail.com', '+254 373 266 543', 'Cardiology', 1, 827334423, 2001, 1, '$2y$10$uMO1kCoqb/YWveiDrq9xxuHSTzUdohNiYvRNfulcP/5G9b9zosKPK'),
(2, 'Ombogo', 'Miriam', 'Female', 'ombogo.miriam@gmail.com', '+254 783 343 234', 'Dermatology', 2, 367433672, 1998, 1, '$2y$10$VMjnx6Srpqb9KldJRwTxn.3.HBqi442l1ZaN7q6jV3yljfYiDVgq2'),
(3, 'Trevis', 'Opiyo', 'Male', 'trevis.opiyo@gmail.com', '+254 464 323 234', 'Gastroenterology', 3, 735643233, 2003, 1, '$2y$10$B3aiJIYsl5mJMwc0R504leS.P6ydEWKkzl2SD02VovD136r8T5Q2u'),
(4, 'Kiplagat', 'Tanui', 'Female', 'kiplagat.tanui@gmail.com', '+254 864 345 654', 'Gastroenterology', 4, 235754323, 1996, 1, '$2y$10$0Z9/lHZoxQ5eBC//dXlKRuo55vCQyF5cQ/mnCQUe3GoSHsaD0eqt.'),
(5, 'Owen', 'Philip', 'Male', 'owen.philip@yahoo.com', '+254 467 335 975', 'Obstetrics and Gynecology', 5, 927344223, 2007, 1, '$2y$10$nlUWw1esx.GHr7VPimzsLua3Qf0pPKGGLPkYyV6ESYBXOiTfVZebC'),
(6, 'Kinyua', 'Janet', 'Female', 'kinyua.janet@knh.co.ke', '+254 367 533 223', 'Orthopedics', 1, 735455221, 1997, 1, '$2y$10$6sDdPvmJgSXMwpBaCVwgWe1tPwoHNIHRF1C6y1OIhgGoNJLhwfHCi'),
(7, 'Caleb', 'Kiprotich', 'Male', 'caleb.kiprotich737@gmail.com', '+255 464 653 932', 'Ophthalmology', 3, 983672446, 2008, 1, '$2y$10$2sNZRGwRonczWmh7eXguBOVAaiw84bNApGyEdcyylX2r49zljC7Y6'),
(8, 'Farhan', 'Khalif Yussuf', 'Male', 'farhan.yussuf@gmail.com', '+254 464 323 433', 'Radiology', 4, 857465345, 2004, 1, '$2y$10$BCF5I9.z0IVEqrhIefq9euQYXetqhQ0MoUquJC0DAFuQVEpCHN6H.'),
(9, 'Abdimalik', 'Adan Edin', 'Male', 'abdi37malik@yahoo.co.ke', '+255 463 334 234', 'Pediatrics', 3, 366234334, 2003, 1, '$2y$10$kja8NwPNNmsnLm/RURSUJ./x9JusWGwdkW4ijbWnAK2HdiZDrlF1K'),
(10, 'Vince', 'Kaleli Muthama', 'Male', 'vince.kaleli@gmail.com', '+254 335 324 326', 'Neurology', 1, 634984001, 2005, 1, '$2y$10$3GHsRNJdju.57XQoXhBZO.oVpV42.JOk8c9YiLQwbGToqczM4u2Qm'),
(11, 'doctor1', '.....', 'Female', 'doctor1@gmail.com', '12345678', 'orthopedist', 1, 345678, 2021, 1, '$2y$10$Fva6JWfHkz1as5.TPzbsrO.W/5dtW4S84YK7jOcyqex0DTnmG/h1a');

-- --------------------------------------------------------

--
-- Table structure for table `drug`
--

CREATE TABLE `drug` (
  `drugId` int(11) NOT NULL,
  `tradeName` varchar(128) NOT NULL,
  `scientificName` varchar(255) NOT NULL,
  `formula` varchar(255) NOT NULL,
  `form` varchar(128) NOT NULL,
  `dateManufactured` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expiryDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `supplyId` int(11) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug`
--

INSERT INTO `drug` (`drugId`, `tradeName`, `scientificName`, `formula`, `form`, `dateManufactured`, `expiryDate`, `supplyId`, `imagePath`, `category`) VALUES
(39, 'Piriton', 'Chlorphenamine', 'C16H19ClN2', 'Tablet', '2023-10-02 01:03:00', '2023-10-26 01:03:00', 1, './uploaded_images/piriton.jpg', 'Painkillers'),
(40, 'Paracetamol', 'Acetaminophen', 'C8H9NO2', 'Syrup', '2023-10-09 01:04:00', '2023-10-27 01:04:00', 2, './uploaded_images/download.jpg', 'Painkillers'),
(41, 'Benadryl', 'Diphenhydramine', 'C17H21NO', 'Capsule', '2023-10-02 01:06:00', '2023-10-27 01:06:00', 2, './uploaded_images/Benadryl.jpg', 'Vaccines'),
(42, 'Pantoprazole', 'Pantoprazole', 'C16H15F2N3NaO4S', 'Capsule', '2023-10-02 01:08:00', '2023-11-02 01:08:00', 4, './uploaded_images/Pantoprazole.jpg', 'Antidepressants'),
(43, 'Ibuprofen', '2-(4-isobutylphenyl)propanoic acid', 'C13H18O2', 'Injection', '2023-08-16 01:34:00', '2024-05-02 01:34:00', 2, './uploaded_images/Ibuprofen.jpg', 'Painkillers');

-- --------------------------------------------------------

--
-- Table structure for table `health_center`
--

CREATE TABLE `health_center` (
  `healthCenterId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_center`
--

INSERT INTO `health_center` (`healthCenterId`, `name`, `location`, `emailAddress`, `phoneNumber`) VALUES
(1, 'Kenyatta National Hospital (Nairobi)', 'Hospital Road, Upper Hill, Nairobi', 'info@knh.co.ke', '+254 763 253 243'),
(2, 'Aga Khan University Hospital', 'Limuru Road, Parklands, Nairobi', 'info@akuh.co.ke', '+254 756 256 234'),
(3, 'Nairobi Hospital (Nairobi)', 'Argwings Kodhek Road, Hurlingham, Nairobi', 'info@nairobihospital.co.ke', '+254 372 363 836'),
(4, 'Moi Teaching and Referral Hospital (Eldoret)', 'Nandi Road, Eldoret', 'info@mtrh.co.ke', '+254 367 343 247'),
(5, 'Coast General Hospital', 'Moi Avenue, Ganjoni, Mombasa', 'info@cgh.co.ke', '+254 377 234 213');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patientId` int(11) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `location` varchar(255) NOT NULL,
  `dateOfBirth` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passwordHash` varchar(255) NOT NULL,
  `SSN` int(11) NOT NULL,
  `activeStatus` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patientId`, `firstName`, `lastName`, `gender`, `emailAddress`, `phoneNumber`, `location`, `dateOfBirth`, `passwordHash`, `SSN`, `activeStatus`) VALUES
(1, 'James gURU', 'Kamau', 'Male', 'james.kamau@strathmore.edu', '0114742349', 'Nairobi, Kenya', '0000-00-00 00:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 2535336, 1),
(2, 'John', 'Doe', 'Male', 'johndoe@gmail.com', '+254123456', 'Nairobi', '1990-05-14 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 1234567890, 1),
(3, 'Sarah', 'Wangari Maathai', 'Female', 'sarahmkuu@yahoo.com', '+254222222', 'Kisumu', '2001-10-09 18:00:00', '$2y$10$amfUhaoJCnjhUfABpMXsiudfbByZdgCG6nQPCTbJ0fkA0rOnvPlmy', 1357924680, 1),
(4, 'Alice', 'Korir', 'Female', 'alicekorir@gmail.com', '+254444444', 'Nyeri', '1991-09-04 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 1234567890, 1),
(5, 'Mary', 'Wambui', 'Female', 'marywambui@gmail.com', '+254666666', 'Machakos', '1997-02-17 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 1357924680, 1),
(6, 'Grace', 'Njoroge', 'Female', 'gracenjoroge@gmail.com', '+254888888', 'Nanyuki', '1987-04-29 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 1234567890, 1),
(8, 'Jane', 'Smith', 'Female', 'janesmith@gmail.com', '+254987654', 'Mombasa', '1985-08-19 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 123456789, 1),
(9, 'David', 'Ngugi', 'Male', 'davidngugi@yahoo.com', '+254111111', 'Nakuru', '1992-11-30 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 246813579, 1),
(11, 'Michael', 'Omondi', 'Male', 'michaelomondi@gmail.com', '+254333333', 'Eldoret', '1995-03-24 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 987654321, 1),
(15, 'Daniel', 'Oduor', 'Male', 'danielodour@gmail.com', '+254777777', 'Kisii', '1994-11-07 18:00:00', '$2y$10$FLhJ2uoXLMt.pn/sVB7.surJOLTAOKnWrVAujf7ADuWpoCAAyun02', 987654321, 1),
(16, 'kk', 'kl', 'Female', 'mwau@gmail.com', '0789654321', 'meru', '2003-12-03 21:00:00', '$2y$10$8663ZLWha5Pr6A87N8NjCOjGYMu51gzMUwQHW59GZNQph0Ozxj/G.', 1234, 1),
(17, 'Mercy', 'Kiminza', 'Female', 'kim@gmail.com', '0768934661', 'bypass', '2021-03-03 21:00:00', '$2y$10$q9drQmBEYp30/RnJ6eIj2e8S15zpjFw27ZBsVonOZUy0RvWGpKaYK', 12345, 1),
(18, 'ann', 'Kamau', 'Female', 'ann.kamau@gmail.com', '4556678912', 'ruiru', '2004-12-01 21:00:00', '$2y$10$KpVJgmmMOXYzYoePW3bT/OjvhGQjc1mYw0PlnMeFVjBQFswBTIqcK', 123456, 1),
(19, 'patient1', '....', 'Male', 'Patient1@gmail.com', '12345678', 'ngong', '2008-02-22 21:00:00', '$2y$10$vZwMDAct7fbofr0G749PJulW7t9ygh8L2GuCQNxkEKwdjTbUFj2uu', 67890, 1),
(20, 'patient2', '....', 'Female', 'patient2@gmail.com', '56788923', 'murang&#039;a', '2023-02-13 21:00:00', '$2y$10$71pOaJ7ZCGZjzJ.cZh4hceIJhiv5ovO.GkHDkNpvSqohuYyQOTbLS', 34567, 1),
(21, 'Lisa', 'Wanjiru', 'Female', 'lisa@gmail.com', '0745678903', 'madaraka', '2006-12-02 21:00:00', '$2y$10$Bcebp0IJyEAPSoxiK8pvfurgdjlm5VXDdMMiiovc9wPUBA3ZSMoeW', 5678, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient_doctor`
--

CREATE TABLE `patient_doctor` (
  `patientDoctorId` int(11) NOT NULL,
  `patientId` int(11) NOT NULL,
  `doctorId` int(11) NOT NULL,
  `dateAssigned` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isPrimary` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_doctor`
--

INSERT INTO `patient_doctor` (`patientDoctorId`, `patientId`, `doctorId`, `dateAssigned`, `isPrimary`) VALUES
(49, 1, 1, '2023-06-19 18:00:00', 1),
(50, 2, 2, '2023-06-19 18:00:00', 1),
(51, 3, 3, '2023-06-19 18:00:00', 1),
(52, 4, 4, '2023-06-19 18:00:00', 1),
(53, 5, 5, '2023-06-19 18:00:00', 1),
(54, 6, 6, '2023-06-19 18:00:00', 1),
(56, 8, 7, '2023-06-19 18:00:00', 1),
(57, 8, 8, '2023-06-19 18:00:00', 1),
(58, 9, 9, '2023-06-19 18:00:00', 1),
(59, 11, 10, '2023-06-19 18:00:00', 1),
(60, 1, 6, '2023-06-20 14:08:42', 0),
(61, 11, 7, '2023-06-20 15:10:37', 0),
(62, 1, 3, '2023-06-21 13:35:36', 0),
(63, 1, 8, '2023-06-22 08:44:26', 0),
(64, 19, 11, '2023-07-20 15:08:11', 1),
(65, 20, 11, '2023-07-20 15:33:32', 1),
(66, 21, 7, '2023-07-28 10:08:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pharmaceutical`
--

CREATE TABLE `pharmaceutical` (
  `pharmaceuticalId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmaceutical`
--

INSERT INTO `pharmaceutical` (`pharmaceuticalId`, `name`, `location`, `emailAddress`, `phoneNumber`) VALUES
(1, 'Novartis Pharmaceuticals Kenya Limited', '6th Floor, AON Minet House, Mamlaka Road, Nairobi, Kenya', 'info@npkl.co.ke', '+254 20 3763000'),
(2, 'GlaxoSmithKline Kenya Ltd', 'Enterprise Road, Industrial Area, Nairobi, Kenya', 'info@gskl.co.ke', '+254 20 3763676'),
(3, 'AstraZeneca Pharmaceuticals Kenya Ltd', 'Belgravia Building, 14 Riverside Drive, Nairobi, Kenya', 'info@azpkl.co.ke', '+254 20 37433000'),
(4, 'Sanofi Kenya Ltd', 'Sanofi House, 6 Muthangari Drive, Westlands, Nairobi, Kenya', 'info@sanofi.co.ke', '+254 48925 4634'),
(5, 'Pfizer Laboratories Ltd', 'Muthaiga Business Center, Thigiri Ridge Road, Nairobi, Kenya', 'info@pfizer.co.ke', '+254 793 363 244'),
(6, 'Roche Pharmaceuticals Kenya Ltd', 'CIC Plaza, 3rd Floor, Mara Road, Upper Hill, Nairobi, Kenya', 'info@rochep.co.ke', '+254 777888999'),
(7, 'Aspen Pharmacare Kenya Limited', 'Aspen Nairobi Warehouse, Namanga Road, Athi River, Kenya', 'info@gchp', '+254 897 266 366'),
(8, 'Cipla Quality Chemical Industries Limited', 'Baba Dogo Road, Ruaraka, Nairobi, Kenya', 'info@cqci.co.ke', '+254 674 554 344'),
(9, 'Bristol-Myers Squibb Kenya Limited', 'Parkfield Place, Muthangari Drive, Westlands, Nairobi, Kenya', 'info@bristolmyers.co.ke', '+254 789 736344'),
(10, 'Johnson &amp; Johnson Kenya Limited', 'Regal Plaza, Limuru Road, Parklands, Nairobi, Kenya', 'info@jjkenya.co.ke', '+254 748 464647');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist`
--

CREATE TABLE `pharmacist` (
  `pharmacistId` int(11) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `gender` varchar(32) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `pharmacyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacist`
--

INSERT INTO `pharmacist` (`pharmacistId`, `firstName`, `lastName`, `gender`, `emailAddress`, `phoneNumber`, `passwordHash`, `pharmacyId`) VALUES
(1, 'John', 'Doe', 'Male', 'johndoe@gmail.com', '+254123456789', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 1),
(2, 'Jane', 'Smith', 'Female', 'janesmith@gmail.com', '+254987654321', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 1),
(3, 'David', 'Ngugi', 'Male', 'davidngugi@yahoo.com', '+254111111111', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 2),
(4, 'Grace', 'Wanjiku', 'Female', 'gracewanjiku@yahoo.com', '+254222222222', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 2),
(5, 'Michael', 'Omondi', 'Male', 'michaelomondi@gmail.com', '+254333333333', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 3),
(6, 'Sarah', 'Kamau', 'Female', 'sarahkamau@gmail.com', '+254444444444', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 3),
(7, 'James', 'Mwaura', 'Male', 'jamesmwaura@yahoo.com', '+254555555555', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 4),
(8, 'Alice', 'Kariuki', 'Female', 'alicekariuki@yahoo.com', '+254666666666', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 4),
(9, 'Peter', 'Njoroge', 'Male', 'peternjoroge@gmail.com', '+254777777777', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 5),
(10, 'Mary', 'Kamau', 'Female', 'marykamau@gmail.com', '+254888888888', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 5),
(11, 'Joseph Mukama', 'Kamau', 'Male', 'josephkamau@gmail.com', '+254999999999', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 6),
(12, 'Rebecca', 'Wangari', 'Female', 'rebeccawangari@gmail.com', '+254101010101', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 6),
(13, 'Mark', 'Oduor', 'Male', 'markodour@yahoo.com', '+254121212121', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 7),
(14, 'Julia', 'Kinyua', 'Female', 'juliakinyua@yahoo.com', '+254131313131', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 7),
(15, 'Daniel', 'Ochieng', 'Male', 'danielochieng@gmail.com', '+254141414141', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 8),
(16, 'Linda', 'Wambui', 'Female', 'lindawambui@gmail.com', '+254151515151', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 8),
(17, 'Patrick', 'Maina', 'Male', 'patrickmaina@yahoo.com', '+254161616161', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(18, 'Catherine', 'Muthoni', 'Female', 'catherinemuthoni@yahoo.com', '+254171717171', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(21, 'Samuel', 'Kiptoo', 'Male', 'samuelkiptoo@gmail.com', '+254181818181', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(22, 'Rose', 'Atieno', 'Female', 'roseatieno@gmail.com', '+254191919191', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(32, 'John', 'Mwangi', 'Male', 'johnmwangi@gmail.com', '+254123456781', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 1),
(33, 'Jane', 'Korir', 'Female', 'janekorir@gmail.com', '+254987654782', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 2),
(35, 'Grace', 'Muthoni', 'Female', 'gracemuthoni@gmail.com', '+254222222784', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 4),
(36, 'David', 'Omondi', 'Male', 'davidomondi@gmail.com', '+254333333785', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 5),
(37, 'Sarah', 'Wangari', 'Female', 'sarahwangari@gmail.com', '+254444444786', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 6),
(38, 'Michael', 'Kiptoo', 'Male', 'michaelkiptoo@gmail.com', '+254555555787', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 7),
(39, 'Alice', 'Wambui', 'Female', 'alicewambui@gmail.com', '+254666666788', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 8),
(40, 'Peter', 'Oduor', 'Male', 'peterodour@gmail.com', '+254777777789', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(41, 'pharmacist1', '......', 'Male', 'pharmacist1@gmail.com', '34567890', '$2y$10$cG1MH6tnKZVPjPhJl7VuFuiUXw4VBtL7.IVxrvDn3sOgGDP8s2Cvm', 5);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacyId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`pharmacyId`, `name`, `location`, `emailAddress`, `phoneNumber`) VALUES
(1, 'Kenyatta National Hospital Pharmacy', 'Hospital Road, Nairobi', 'info@knhp.co.ke', '+254 20 2726300'),
(2, 'Medanta Africare Pharmacy', 'Mbagathi Way, Nairobi', 'info@medanta.co.ke', '+254 20 5225555'),
(3, 'Healthcare Pharmacy', 'Muthangari Drive, Nairobi', 'info@healthcare.co.ke', '+254 719 085000'),
(4, 'Green Cross Pharmacy', 'Biashara Street, Nairobi', 'info@greencross.co.ke', '+254 20 2218786'),
(5, 'Karen Hospital Pharmacy', 'Karen Road, Nairobi', 'info@knp.co.ke', '+254 709 320000'),
(6, 'Aga Khan University Hospital Pharmacy', '3rd Parklands Avenue, Nairobi', 'info@aknup.co.ke', '+254 20 3662000'),
(7, 'Gertrude\'s Children\'s Hospital Pharmacy', 'Muthaiga Road, Nairobi', 'info@gchp', '+254 20 3763000'),
(8, 'M.P. Shah Hospital Pharmacy', 'Shivachi Road, Nairobi', 'info@mpshp', '+254 20 3740635'),
(9, 'Nairobi West Hospital Pharmacy', 'Gandhi Avenue, Nairobi', 'info@nwhp', '+254 719 025000');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `prescriptionId` int(11) NOT NULL,
  `consultationId` int(11) DEFAULT NULL,
  `drugId` int(11) DEFAULT NULL,
  `dosage` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL,
  `startDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `endDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescriptionId`, `consultationId`, `drugId`, `dosage`, `quantity`, `startDate`, `endDate`, `dateCreated`) VALUES
(1, 48, 11, '1 x 3', 12, '2023-06-21 18:00:00', '2023-06-25 18:00:00', '2023-06-21 11:58:50'),
(2, 65, 41, '2*3', 12, '2023-07-20 15:30:00', '2023-07-20 15:30:00', '2023-07-20 15:30:30'),
(3, 65, 25, '1*3', 15, '2023-07-20 15:31:00', '2023-07-20 03:31:00', '2023-07-20 15:31:43'),
(4, 67, 11, '2*3', 16, '2023-07-28 13:16:00', '2023-08-03 10:10:00', '2023-07-28 10:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE `supervisor` (
  `supervisorId` int(11) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `gender` varchar(32) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `pharmaceuticalId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`supervisorId`, `firstName`, `lastName`, `gender`, `emailAddress`, `phoneNumber`, `passwordHash`, `pharmaceuticalId`) VALUES
(1, 'Odongo', 'Davis Omogi', 'Male', 'odongo.davis@novartis.com', '+254 378 344 784', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 1),
(2, 'Mutua', 'Emmanuel Kioko', 'Male', 'mutua.emmanuel@rochepharm.com', '+254 464 293 990', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 6),
(3, 'Noah', 'Memiti Nabala', 'Male', 'naoh.memiti@jjke.co.ke', '+254 567 843 275', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 10),
(4, 'Caleb', 'Otieno Oketch', 'Male', 'caleb.otieno@bristolmyers.co.ke', '+255 567 543 938', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(5, 'John', 'Doe', 'Male', 'johndoe@gmail.com', '+254123456789', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 1),
(6, 'Jane', 'Smith', 'Female', 'janesmith@gmail.com', '+254987654321', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 1),
(7, 'David', 'Ngugi', 'Male', 'davidngugi@yahoo.com', '+254111111111', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 2),
(8, 'Grace', 'Wanjiku', 'Female', 'gracewanjiku@yahoo.com', '+254222222222', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 2),
(9, 'Michael', 'Omondi', 'Male', 'michaelomondi@gmail.com', '+254333333333', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 3),
(10, 'Sarah', 'Kamau', 'Female', 'sarahkamau@gmail.com', '+254444444444', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 3),
(11, 'James', 'Mwaura', 'Male', 'jamesmwaura@yahoo.com', '+254555555555', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 4),
(12, 'Alice', 'Kariuki', 'Female', 'alicekariuki@yahoo.com', '+254666666666', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 4),
(13, 'Peter', 'Njoroge', 'Male', 'peternjoroge@gmail.com', '+254777777777', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 5),
(14, 'Mary', 'Kamau', 'Female', 'marykamau@gmail.com', '+254888888888', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 5),
(15, 'Joseph', 'Kamau', 'Male', 'josephkamau@gmail.com', '+254999999999', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 6),
(16, 'Rebecca', 'Wangari', 'Female', 'rebeccawangari@gmail.com', '+254101010101', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 6),
(17, 'Mark', 'Oduor', 'Male', 'markodour@yahoo.com', '+254121212121', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 7),
(18, 'Julia', 'Kinyua', 'Female', 'juliakinyua@yahoo.com', '+254131313131', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 7),
(19, 'Daniel', 'Ochieng', 'Male', 'danielochieng@gmail.com', '+254141414141', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 8),
(20, 'Linda', 'Wambui', 'Female', 'lindawambui@gmail.com', '+254151515151', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 8),
(21, 'Patrick', 'Maina', 'Male', 'patrickmaina@yahoo.com', '+254161616161', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(22, 'Catherine', 'Muthoni', 'Female', 'catherinemuthoni@yahoo.com', '+254171717171', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 9),
(23, 'Samuel', 'Kiptoo', 'Male', 'samuelkiptoo@gmail.com', '+254181818181', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 10),
(24, 'Rose', 'Atieno', 'Female', 'roseatieno@gmail.com', '+254191919191', '$2y$10$yOQfx94hy28Tasuev.XhQO5DFjvDJHli6yrMLWKRuqvEAqKLdmL0e', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `supplyId` int(11) NOT NULL,
  `contractId` int(11) DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`supplyId`, `contractId`, `dateCreated`, `status`) VALUES
(1, 10, '2023-06-19 18:00:00', 'Pending'),
(2, 9, '2023-06-19 18:00:00', 'Pending'),
(3, 8, '2023-06-19 18:00:00', 'Pending'),
(4, 7, '2023-06-19 18:00:00', 'Pending'),
(5, 6, '2023-06-19 18:00:00', 'Pending'),
(6, 5, '2023-06-19 18:00:00', 'Pending'),
(7, 4, '2023-06-19 18:00:00', 'Completed'),
(8, 3, '2023-06-19 18:00:00', 'Pending'),
(9, 2, '2023-06-19 18:00:00', 'Pending'),
(10, 1, '2023-06-19 18:00:00', 'Pending'),
(11, 10, '2023-06-19 18:00:00', 'Pending'),
(12, 9, '2023-06-19 18:00:00', 'Pending'),
(13, 8, '2023-06-19 18:00:00', 'Pending'),
(14, 7, '2023-06-19 18:00:00', 'Pending'),
(15, 6, '2023-06-19 18:00:00', 'Pending'),
(16, 5, '2023-06-19 18:00:00', 'Pending'),
(17, 4, '2023-06-19 18:00:00', 'Pending'),
(18, 3, '2023-06-19 18:00:00', 'Pending'),
(19, 2, '2023-06-19 18:00:00', 'Pending'),
(20, 1, '2023-06-19 18:00:00', 'Pending'),
(21, 18, '2023-07-18 06:43:04', 'Pending'),
(22, 18, '2023-07-18 06:43:07', 'Pending'),
(23, 5, '2023-07-20 15:03:33', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `supply_payment`
--

CREATE TABLE `supply_payment` (
  `supplyPaymentId` int(11) NOT NULL,
  `supplyId` int(11) DEFAULT NULL,
  `amountCashed` decimal(10,2) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `method` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply_payment`
--

INSERT INTO `supply_payment` (`supplyPaymentId`, `supplyId`, `amountCashed`, `dateCreated`, `method`) VALUES
(1, 7, 167.00, '2023-07-17 14:22:57', 'visa'),
(2, 1, 16000.00, '2023-07-20 15:45:54', 'mpesa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`administratorId`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`consultationID`),
  ADD KEY `patientDoctorId` (`patientDoctorId`);

--
-- Indexes for table `consultation_payment`
--
ALTER TABLE `consultation_payment`
  ADD PRIMARY KEY (`consultationPaymentId`),
  ADD KEY `consultationId` (`consultationId`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`contractId`),
  ADD KEY `pharmacyId` (`pharmacyId`),
  ADD KEY `pharmaceuticalId` (`pharmaceuticalId`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`diagnosisId`),
  ADD KEY `consultationId` (`consultationId`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctorId`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD KEY `healthCenterId` (`healthCenterId`);

--
-- Indexes for table `drug`
--
ALTER TABLE `drug`
  ADD PRIMARY KEY (`drugId`);

--
-- Indexes for table `health_center`
--
ALTER TABLE `health_center`
  ADD PRIMARY KEY (`healthCenterId`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientId`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- Indexes for table `patient_doctor`
--
ALTER TABLE `patient_doctor`
  ADD PRIMARY KEY (`patientDoctorId`),
  ADD KEY `patientId` (`patientId`),
  ADD KEY `doctorId` (`doctorId`);

--
-- Indexes for table `pharmaceutical`
--
ALTER TABLE `pharmaceutical`
  ADD PRIMARY KEY (`pharmaceuticalId`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- Indexes for table `pharmacist`
--
ALTER TABLE `pharmacist`
  ADD PRIMARY KEY (`pharmacistId`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD KEY `pharmacyId` (`pharmacyId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drug`
--
ALTER TABLE `drug`
  MODIFY `drugId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
