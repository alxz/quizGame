-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 25, 2019 at 08:08 PM
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
  `questionurl` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`qId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabquestions`
--

INSERT INTO `tabquestions` (`qId`, `qTxt`, `qIsTaken`, `qIsAnswered`, `questionurl`) VALUES
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
  `sessionId` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`uId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tabusers`
--

INSERT INTO `tabusers` (`uId`, `uIUN`, `uFName`, `uLName`, `uRetryCount`, `uTimer`, `uTotalScore`, `uIsFinished`, `timestart`, `timefinish`, `listofquestions`, `comment`, `sessionId`) VALUES
(1, 'JOHN0001', 'JOHN0001', 'JOHN0001', 1, 77, 6, 1, '2019-11-21T20:48:12.160Z', '2019-11-21T20:49:28.887Z', 'q:3, q:1, q:7, q:6, q:2, q:9, ', 'Have a nice day!', ''),
(2, 'Mike2010', 'Mike2010', 'Mike2010', 1, 33, 6, 1, '2019-11-21T21:51:25.220Z', '2019-11-21T21:51:58.320Z', 'q:12, q:8, q:4, q:2, q:10, q:9, ', 'Have a nice day!', ''),
(3, 'Mike2001', 'Mike2001', 'Mike2001', 1, 25, 6, 1, '2019-11-21T21:54:17.526Z', '2019-11-21T21:54:42.390Z', 'q:1, q:6, q:8, q:5, q:2, q:11, ', 'Have a nice day!', '834f5dbe-c266-4f94-9484-77a1a3464541'),
(4, 'MARIA2001', 'MARIA2001', 'MARIA2001', 1, 33, 6, 1, '2019-11-22T17:50:57.609Z', '2019-11-22T17:51:30.985Z', 'q:11, q:12, q:10, q:4, q:5, q:6, ', 'Have a nice day!', 'cb9aca32-f57c-4ce7-b8f7-17f2ed6eda99'),
(5, 'MARIA2001', 'MARIA2001', 'MARIA2001', 2, 33, 6, 1, '2019-11-22T17:54:29.445Z', '2019-11-22T17:55:02.230Z', 'q:4, q:10, q:12, q:11, q:8, q:7, ', 'Have a nice day!', '86185bc9-d74e-442d-9068-3da92544a83f'),
(6, 'JOHN0001', 'JOHN0001', 'JOHN0001', 2, 50, 6, 1, '2019-11-22T19:06:46.081Z', '2019-11-22T19:07:35.730Z', 'q:10, q:9, q:1, q:7, q:12, q:4, ', 'Have a nice day!', '0ceca287-2408-4f40-9520-f5759408dfce'),
(7, 'JOHN0001', 'JOHN0001', 'JOHN0001', 3, 30, 6, 1, '2019-11-22T19:11:54.222Z', '2019-11-22T19:12:24.530Z', 'q:3, q:2, q:7, q:4, q:1, q:12, ', 'Have a nice day!', 'fb2db12f-4ab7-447f-9f64-1327c7c6808d'),
(8, 'JOHN0001', 'JOHN0001', 'JOHN0001', 4, 31, 6, 1, '2019-11-22T19:15:14.570Z', '2019-11-22T19:15:45.974Z', 'q:3, q:6, q:12, q:11, q:7, q:4, ', '2) MostLeast:       ; 3) Suggest:       ', '71fc9a00-2b7f-4220-a825-4f8fb837bca7'),
(9, 'JOHN0001', 'JOHN0001', 'JOHN0001', 5, 29, 6, 1, '2019-11-22T19:20:19.953Z', '2019-11-22T19:20:49.368Z', 'q:5, q:2, q:11, q:1, q:6, q:10, ', '2) MostLeast:        3) Suggest:       ', '48f32171-95fd-466f-8eaf-45026eba2147'),
(10, 'JOHN0001', 'JOHN0001', 'JOHN0001', 6, 39, 6, 1, '2019-11-22T19:27:50.671Z', '2019-11-22T19:28:29.430Z', 'q:6, q:10, q:12, q:3, q:11, q:5, ', '3', 'ed6c7160-d0a0-4914-9c83-65eab2dc92c7'),
(11, 'JOHN0001', 'JOHN0001', 'JOHN0001', 7, 25, 6, 1, '2019-11-22T19:30:17.198Z', '2019-11-22T19:30:42.425Z', 'q:9, q:6, q:10, q:7, q:5, q:11, ', '1) Stars: 0 ; 2) MostLeast:       I like this questions! Bône fête! 3) Suggest:       ', 'c9a739f6-8e50-4935-95ff-e22d195d21b6'),
(12, 'JOHN0001', 'JOHN0001', 'JOHN0001', 8, 24, 6, 1, '2019-11-22T19:33:19.654Z', '2019-11-22T19:33:43.849Z', 'q:6, q:11, q:4, q:5, q:7, q:2, ', '1) Stars: 4 ; 2) MostLeast:       I like the questions! Nice! 3) Suggest:       2. Please add more interactive elements to the game to make it more interesting!!!', '4aa26a86-73dc-4b7f-9d48-ebf4c50fac14'),
(13, 'JOHN0001', 'JOHN0001', 'JOHN0001', 9, 40, 6, 1, '2019-11-22T22:10:29.345Z', '2019-11-22T22:11:09.519Z', 'q:2, q:12, q:10, q:11, q:7, q:9, ', '1)Stars: 3 ; 2)Likes: bfgbjgk,.hjk.l.hkl. 3)Suggest: dgnfghmghj k klh.hkl.kl', 'c3cc9584-84e0-4551-b846-ca08a402d310'),
(14, 'JOHN0001', 'JOHN0001', 'JOHN0001', 10, 71, 7, 1, '2019-11-23T00:34:36.420Z', '2019-11-23T00:35:47.151Z', 'q:7, q:4, q:5, q:10, q:10, q:12, q:9, ', '1)Stars: 5 ; 2)Likes: Super!!! Questions are fun! 3)Suggest: All ok, just a bit more fun!', 'f69f1198-2f18-4ac6-a361-625c6dde2a3f'),
(15, 'JOHN0001', 'JOHN0001', 'JOHN0001', 11, 53, 6, 1, '2019-11-23T00:37:25.717Z', '2019-11-23T00:38:18.995Z', 'q:5, q:12, q:9, q:4, q:11, q:8, ', '1)Stars: 5 ; 2)Likes:  3)Suggest: ', '900e1fcb-0d6a-409a-828a-8282a2cce256'),
(16, 'JOHN0001', 'JOHN0001', 'JOHN0001', 12, 149, 6, 1, '2019-11-23T00:40:34.727Z', '2019-11-23T00:43:03.342Z', 'q:10, q:2, q:4, q:1, q:11, q:5, ', '1)Stars:  ; Have a nice day!', '08a33515-4e42-463e-88f0-b21ecc02d8c7'),
(17, 'MARYBROWN', 'MARYBROWN', 'MARYBROWN', 1, 150, 7, 1, '2019-11-23T01:11:10.783Z', '2019-11-23T01:13:40.612Z', 'q:6, q:7, q:7, q:8, q:11, q:5, q:12, ', '1)Stars: 5 ; 2)Likes: Super! I like all questions! 3)Suggest: Add more fun please', '70a97781-6f70-45ac-8dda-bfe37bbae618'),
(18, 'JOHN0001', 'JOHN0001', 'JOHN0001', 13, 47, 6, 1, '2019-11-23T01:42:38.434Z', '2019-11-23T01:43:25.819Z', 'q:9, q:5, q:2, q:8, q:1, q:10, ', '1)Stars: 4 ; 2)Likes:  3)Suggest: ', '086929f2-6823-424b-b431-1bcce91a5065'),
(19, 'JOHN0001', 'JOHN0001', 'JOHN0001', 14, 44, 6, 1, '2019-11-23T21:49:11.511Z', '2019-11-23T21:49:55.577Z', 'q:10, q:3, q:5, q:2, q:12, q:9, ', '1)Stars: 4 ; 2)Likes: Cool! Like it! 3)Suggest: More fun please!', '6fb6ddc1-8e3b-4f3e-bd26-7bcf63fec06d'),
(20, 'JOHN0001', 'JOHN0001', 'JOHN0001', 15, 58, 6, 1, '2019-11-23T23:13:12.183Z', '2019-11-23T23:14:09.907Z', 'q:3, q:6, q:12, q:11, q:9, q:5, ', '1)Stars: 5 ; 2)Likes: jhkgh 3)Suggest: jgkjh', '71693292-aa38-4039-96df-5ae527eb0bcc'),
(21, 'JOHN0001', 'JOHN0001', 'JOHN0001', 16, 86, 6, 1, '2019-11-23T23:15:35.737Z', '2019-11-23T23:17:01.555Z', 'q:10, q:12, q:3, q:1, q:5, q:2, ', '1)Stars:  ; Have a nice day!', '7a2db8ff-24af-4173-882c-6860c7498711'),
(22, 'MARY0001', 'MARY0001', 'MARY0001', 1, 66, 7, 1, '2019-11-25T14:37:54.651Z', '2019-11-25T14:39:01.005Z', 'q:2, q:4, q:10, q:12, q:6, q:6, q:7, ', '1)Stars: 4 ; 2)Likes: Super! 3)Suggest: May be more rooms with less questions?', '79c59aca-db82-46cc-9374-b14a360e6b35'),
(23, 'MARYBROWN', 'MARYBROWN', 'MARYBROWN', 2, 145, 8, 1, '2019-11-25T16:10:03.090Z', '2019-11-25T16:12:27.809Z', 'q:8, q:3, q:4, q:4, q:7, q:7, q:9, q:10, q:10, ', '1)Stars: 5 ; 2)Likes: Enjoyed this game 3)Suggest: Make more cool questions!', 'd2c9ee9a-41d6-4877-86a5-d0143903fef4'),
(24, 'MARYBROWN', 'MARYBROWN', 'MARYBROWN', 2, 145, 9, 1, '2019-11-25T16:10:03.090Z', '2019-11-25T16:12:27.814Z', 'q:8, q:3, q:4, q:4, q:7, q:7, q:9, q:10, q:10, ', '1)Stars: 5 ; 2)Likes: Enjoyed this game 3)Suggest: Make more cool questions!', 'd2c9ee9a-41d6-4877-86a5-d0143903fef4'),
(25, 'JANNE1010', 'JANNE1010', 'JANNE1010', 1, 115, 9, 1, '2019-11-25T16:29:09.688Z', '2019-11-25T16:31:05.035Z', 'q:7, q:7, q:4, q:9, q:1, q:8, q:8, q:10, q:10, ', '1)Stars: 1 ; 2)Likes:  3)Suggest: ', '42cbbb08-27e2-407f-a467-21b543de51bb'),
(26, 'JANNE1010', 'JANNE1010', 'JANNE1010', 1, 115, 8, 1, '2019-11-25T16:29:09.688Z', '2019-11-25T16:31:05.033Z', 'q:7, q:7, q:4, q:9, q:1, q:8, q:8, q:10, q:10, ', '1)Stars: 1 ; 2)Likes:  3)Suggest: ', '42cbbb08-27e2-407f-a467-21b543de51bb'),
(27, 'MARYBROWN', 'MARYBROWN', 'MARYBROWN', 4, 123, 9, 1, '2019-11-25T16:35:24.852Z', '2019-11-25T16:37:27.837Z', 'q:8, q:10, q:10, q:6, q:4, q:4, q:9, q:12, q:12, q:12, ', '1)Stars: 5 ; 2)Likes: dadsas 3)Suggest: asda', '58345d16-687a-4e22-9655-fab1452714f3'),
(28, 'MARYBROWN', 'MARYBROWN', 'MARYBROWN', 5, 123, 10, 1, '2019-11-25T16:35:24.852Z', '2019-11-25T16:37:27.850Z', 'q:8, q:10, q:10, q:6, q:4, q:4, q:9, q:12, q:12, q:12, ', '1)Stars: 5 ; 2)Likes: dadsas 3)Suggest: asda', '58345d16-687a-4e22-9655-fab1452714f3'),
(29, 'MARYBROWN', 'MARYBROWN', 'MARYBROWN', 5, 123, 8, 1, '2019-11-25T16:35:24.852Z', '2019-11-25T16:37:27.832Z', 'q:8, q:10, q:10, q:6, q:4, q:4, q:9, q:12, q:12, q:12, ', '1)Stars: 5 ; 2)Likes: dadsas 3)Suggest: asda', '58345d16-687a-4e22-9655-fab1452714f3'),
(30, 'JOHN0001', 'JOHN0001', 'JOHN0001', 17, 233, 8, 1, '2019-11-25T16:39:48.846Z', '2019-11-25T16:43:42.212Z', 'q:1, q:12, q:6, q:6, q:2, q:9, q:7, q:5, ', 'Have a nice day!', '1f4a2fe5-a220-4a72-908b-3456b2d239d3'),
(31, 'JOHN0001', 'JOHN0001', 'JOHN0001', 18, 46, 6, 1, '2019-11-25T16:49:33.165Z', '2019-11-25T16:50:19.004Z', 'q:8, q:5, q:6, q:2, q:10, q:11, ', '1)Stars: 4 ; 2)Likes: wow! 3)Suggest: all ok, give more questions', 'ecb6a23e-f0fe-4827-bc2a-eac1b6adc5a2');

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
