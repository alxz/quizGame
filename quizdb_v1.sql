-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 15, 2019 at 11:14 PM
-- Server version: 5.7.23
-- PHP Version: 7.0.32

SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: "quizdb"
--
CREATE DATABASE IF NOT EXISTS "quizdb" DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE quizdb;

-- --------------------------------------------------------

--
-- Table structure for table "tabanswers"
--

DROP TABLE IF EXISTS `tabanswers`;
CREATE TABLE "tabanswers" ;

--
-- Dumping data for table "tabanswers"
--

SET IDENTITY_INSERT "tabanswers" ON ;
INSERT INTO "tabanswers" ("ansId", "ansTxt", "ansQId", "ansIsValid") VALUES
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

SET IDENTITY_INSERT "tabanswers" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "tabquestions"
--

DROP TABLE IF EXISTS `tabquestions`;
CREATE TABLE "tabquestions" ;

--
-- Dumping data for table "tabquestions"
--

SET IDENTITY_INSERT "tabquestions" ON ;
INSERT INTO "tabquestions" ("qId", "qTxt", "qIsTaken", "qIsAnswered") VALUES
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

SET IDENTITY_INSERT "tabquestions" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "tabusers"
--

DROP TABLE IF EXISTS `tabusers`;
CREATE TABLE "tabusers" ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
