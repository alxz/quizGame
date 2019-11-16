-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 16, 2019 at 07:11 PM
-- Server version: 5.7.23
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabanswers`
--

CREATE TABLE `tabanswers` (
  `ansId` bigint(20) NOT NULL,
  `ansTxt` text COLLATE latin1_general_ci NOT NULL,
  `ansQId` bigint(20) NOT NULL,
  `ansIsValid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabanswers`
--

INSERT INTO `tabanswers` (`ansId`, `ansTxt`, `ansQId`, `ansIsValid`) VALUES
(1, 'January and March', 1, 0),
(2, 'July and August', 1, 1),
(3, 'September and December', 1, 0),
(4, 'May and April', 1, 0),
(5, '11111', 2, 0),
(6, '99990', 2, 0),
(7, '99999', 2, 1),
(8, '90009', 2, 0),
(9, 'Green', 3, 0),
(10, 'Pink', 3, 1),
(11, 'Blue', 3, 0),
(12, 'Yellow', 3, 0),
(13, '4000 miles', 4, 1),
(14, '5000 km', 4, 0),
(15, '3000 miles', 4, 0),
(16, '9856 km', 4, 0),
(17, 'fifty two', 5, 0),
(18, 'twenty four', 5, 0),
(19, 'sixty five', 5, 0),
(20, 'fifty', 5, 1),
(21, 'Four stars', 6, 1),
(22, 'Two stars', 6, 0),
(23, 'Nine stars', 6, 0),
(24, 'Six stars', 6, 0),
(25, 'Oh, Canada!\r\n(Rideau Canal)', 7, 0),
(26, 'USA, sure USA, don\'t you know that? (The Wabash and Erie Canal)', 7, 0),
(27, 'Russia (White Sea–Baltic Canal)', 7, 0),
(28, 'China (Beijing-Hangzhou Grand Canal)', 7, 1),
(29, 'Orca (killer whale)', 8, 1),
(30, 'Octopus (deep-sea octopuses)', 8, 0),
(31, 'Grand cachalot', 8, 0),
(32, 'Giant squid', 8, 0),
(33, 'Norway', 9, 0),
(34, 'Denmark', 9, 1),
(35, 'Iceland', 9, 0),
(36, 'United Kingdom', 9, 0),
(37, 'the Celsius ', 10, 0),
(38, 'the Fahrenheit', 10, 0),
(39, 'The Kelvin', 10, 1),
(40, 'The Rankine', 10, 0),
(41, 'Vitamin E', 11, 0),
(42, 'Vitamin A', 11, 1),
(43, 'Vitamin D', 11, 0),
(44, 'Vitamin XYZ', 11, 0),
(45, 'One extra pair of ribs', 12, 0),
(46, 'The wrist bone', 12, 0),
(47, 'The pinky toe phalanges ', 12, 0),
(48, 'The big toe', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabquestions`
--

CREATE TABLE `tabquestions` (
  `qId` bigint(20) NOT NULL,
  `qTxt` text COLLATE latin1_general_ci NOT NULL,
  `qIsTaken` tinyint(1) NOT NULL,
  `qIsAnswered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabquestions`
--

INSERT INTO `tabquestions` (`qId`, `qTxt`, `qIsTaken`, `qIsAnswered`) VALUES
(1, 'Which two months are named after Roman emperors?', 0, 0),
(2, 'What is the largest number of five digits?', 0, 0),
(3, 'What colour to do you get when you mix red and white?', 0, 0),
(4, 'How long is the Great Wall of China?', 0, 0),
(5, 'How many stars has the American flag got?', 0, 0),
(6, 'How many stars feature on the flag of New Zealand?', 0, 0),
(7, 'What country is home to the longest canal in the world?', 0, 0),
(8, 'Which marine animal is the only known natural predator of the great white shark?', 0, 0),
(9, 'Located approximately halfway between Iceland and Norway, the Faroe Islands are a territory of which country?', 0, 0),
(10, 'What is the primary unit of temperature measurement in the physical sciences?', 0, 0),
(11, 'A deficiency of what vitamin may lead to dry eyes and night blindness?', 0, 0),
(12, 'In the human body, what is the hallux?', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tabusers`
--

CREATE TABLE `tabusers` (
  `uId` bigint(20) NOT NULL,
  `uIUN` text COLLATE latin1_general_ci NOT NULL,
  `uFName` text COLLATE latin1_general_ci NOT NULL,
  `uLName` text COLLATE latin1_general_ci NOT NULL,
  `uRetryCount` int(11) NOT NULL,
  `uTimer` int(11) NOT NULL,
  `uTotalScore` int(11) NOT NULL,
  `uIsFinished` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabusers`
--

INSERT INTO `tabusers` (`uId`, `uIUN`, `uFName`, `uLName`, `uRetryCount`, `uTimer`, `uTotalScore`, `uIsFinished`) VALUES
(1, 'JOHN0DOE', 'JOHN0DOE', 'JOHN0DOE', 1, 80, 8, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabanswers`
--
ALTER TABLE `tabanswers`
  ADD PRIMARY KEY (`ansId`),
  ADD KEY `ansQId` (`ansQId`);

--
-- Indexes for table `tabquestions`
--
ALTER TABLE `tabquestions`
  ADD PRIMARY KEY (`qId`);

--
-- Indexes for table `tabusers`
--
ALTER TABLE `tabusers`
  ADD PRIMARY KEY (`uId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabanswers`
--
ALTER TABLE `tabanswers`
  MODIFY `ansId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tabquestions`
--
ALTER TABLE `tabquestions`
  MODIFY `qId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tabusers`
--
ALTER TABLE `tabusers`
  MODIFY `uId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tabanswers`
--
ALTER TABLE `tabanswers`
  ADD CONSTRAINT `tabanswers_ibfk_1` FOREIGN KEY (`ansQId`) REFERENCES `tabquestions` (`qId`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
