-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2019 at 12:09 AM
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
CREATE DATABASE IF NOT EXISTS `quizdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `quizdb`;

-- --------------------------------------------------------

--
-- Table structure for table `tabanswers`
--

CREATE TABLE IF NOT EXISTS `tabanswers` (
  `ansId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ansTxt` text COLLATE latin1_general_ci NOT NULL,
  `ansQId` bigint(20) NOT NULL,
  `ansIsValid` tinyint(1) NOT NULL,
  PRIMARY KEY (`ansId`),
  KEY `ansQId` (`ansQId`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
(25, 'Oh, Canada! (Rideau Canal)', 7, 0),
(26, 'USA, sure USA, don\'t you know that? (The Wabash and Erie Canal)', 7, 0),
(27, 'Russia (White Sea Baltic Canal)', 7, 0),
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

CREATE TABLE IF NOT EXISTS `tabquestions` (
  `qId` bigint(20) NOT NULL AUTO_INCREMENT,
  `qTxt` text COLLATE latin1_general_ci NOT NULL,
  `qIsTaken` tinyint(1) NOT NULL,
  `qIsAnswered` tinyint(1) NOT NULL,
  `qestionurl` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`qId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabquestions`
--

INSERT INTO `tabquestions` (`qId`, `qTxt`, `qIsTaken`, `qIsAnswered`, `qestionurl`) VALUES
(1, 'Which two months are named after Roman emperors?', 0, 0, 'https://player.vimeo.com/video/303102987'),
(2, 'What is the largest number of five digits?', 0, 0, 'https://player.vimeo.com/video/303102987'),
(3, 'What colour to do you get when you mix red and white?', 0, 0, 'https://player.vimeo.com/video/241087789'),
(4, 'How long is the Great Wall of China?', 0, 0, 'https://player.vimeo.com/video/241087789'),
(5, 'How many stars has the American flag got?', 0, 0, 'https://player.vimeo.com/video/241087842'),
(6, 'How many stars feature on the flag of New Zealand?', 0, 0, 'https://player.vimeo.com/video/241087842'),
(7, 'What country is home to the longest canal in the world?', 0, 0, 'https://player.vimeo.com/video/302832544'),
(8, 'Which marine animal is the only known natural predator of the great white shark?', 0, 0, 'https://player.vimeo.com/video/302832544'),
(9, 'Located approximately halfway between Iceland and Norway, the Faroe Islands are a territory of which country?', 0, 0, 'https://player.vimeo.com/video/241087805'),
(10, 'What is the primary unit of temperature measurement in the physical sciences?', 0, 0, 'https://player.vimeo.com/video/241087805'),
(11, 'A deficiency of what vitamin may lead to dry eyes and night blindness?', 0, 0, 'https://player.vimeo.com/video/241087805'),
(12, 'In the human body, what is the hallux?', 0, 0, 'https://player.vimeo.com/video/241087805');

-- --------------------------------------------------------

--
-- Table structure for table `tabusers`
--

CREATE TABLE IF NOT EXISTS `tabusers` (
  `uId` bigint(20) NOT NULL AUTO_INCREMENT,
  `uIUN` text COLLATE latin1_general_ci NOT NULL,
  `uFName` text COLLATE latin1_general_ci NOT NULL,
  `uLName` text COLLATE latin1_general_ci NOT NULL,
  `uRetryCount` int(11) NOT NULL,
  `uTimer` int(11) NOT NULL,
  `uTotalScore` int(11) NOT NULL,
  `uIsFinished` tinyint(1) NOT NULL,
  `timestart` text COLLATE latin1_general_ci NOT NULL,
  `timefinish` text COLLATE latin1_general_ci NOT NULL,
  `listofquestions` text COLLATE latin1_general_ci NOT NULL,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`uId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabusers`
--

INSERT INTO `tabusers` (`uId`, `uIUN`, `uFName`, `uLName`, `uRetryCount`, `uTimer`, `uTotalScore`, `uIsFinished`, `timestart`, `timefinish`, `listofquestions`, `comment`) VALUES
(1, 'JOHN0DOE', 'JOHN0DOE', 'JOHN0DOE', 1, 80, 8, 1, '', '', '', ''),
(2, 'JOHN0001', 'JOHN0001', 'JOHN0001', 1, 200, 8, 1, '', '', '', ''),
(3, 'JOHN0001', 'JOHN0001', 'JOHN0001', 2, 200, 8, 1, '', '', '', ''),
(4, 'JOHN0001', 'JOHN0001', 'JOHN0001', 3, 122, 8, 1, '', '', '', ''),
(5, 'JOHN0001', 'JOHN0001', 'JOHN0001', 4, 136, 8, 1, '', '', '', ''),
(6, 'JOHN0001', 'JOHN0001', 'JOHN0001', 5, 30, 6, 1, '', '', '', ''),
(7, 'JOHN0001', 'JOHN0001', 'JOHN0001', 6, 123, 7, 1, '', '', '', ''),
(8, 'JOHN0001', 'JOHN0001', 'JOHN0001', 7, 57, 8, 1, '', '', '', ''),
(11, 'JOHN0001', 'JOHN0001', 'JOHN0001', 8, 58, 12, 1, '2019-11-18T20:48:19.978Z', '2019-11-18T20:49:17.999Z', 'q:11, q:11, q:1, q:4, q:10, q:8, q:8, q:9, q:6, q:5, q:5, q:5, ', 'Have a nice day!'),
(12, 'MARYB120', 'MARYB120', 'MARYB120', 1, 46, 8, 1, '2019-11-18T20:54:08.192Z', '2019-11-18T20:54:53.919Z', 'q:2, q:1, q:1, q:9, q:3, q:3, q:12, q:8, ', 'Have a nice day!');

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
