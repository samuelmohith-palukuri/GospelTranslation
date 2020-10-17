-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2020 at 05:23 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GospelTranslation`
--

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `langID` int(11) NOT NULL,
  `languageName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleID` int(11) NOT NULL,
  `roleName` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleID`, `roleName`) VALUES
(1, 'Requestor'),
(2, 'Translator'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `translator`
--

CREATE TABLE `translator` (
  `userID` int(11) NOT NULL,
  `langID` int(11) NOT NULL,
  `approverID` int(11) NOT NULL,
  `approvalStatus` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transReq`
--

CREATE TABLE `transReq` (
  `transReqID` int(11) NOT NULL,
  `requestorID` int(11) NOT NULL,
  `translatorID` int(11) DEFAULT NULL,
  `souceLanguageID` int(11) NOT NULL,
  `targetLanguageID` int(11) NOT NULL,
  `sourceText` text NOT NULL,
  `translatedText` text,
  `transStatusID` int(11) NOT NULL,
  `commentsRequestor` text,
  `commentsTranslator` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transStatus`
--

CREATE TABLE `transStatus` (
  `transStatusID` int(11) NOT NULL,
  `transStatus` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transStatus`
--

INSERT INTO `transStatus` (`transStatusID`, `transStatus`) VALUES
(1, 'New'),
(2, 'TranslationInProgress'),
(3, 'TranslationCompleted'),
(4, 'TranlsationAcceptedByRequestor'),
(5, 'TranslationRejectedByRequestor');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userID` int(11) NOT NULL,
  `phoneNumber` bigint(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `roleID` int(11) NOT NULL DEFAULT '0',
  `password` varchar(256) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `emailID` varchar(256) DEFAULT NULL,
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`langID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `transReq`
--
ALTER TABLE `transReq`
  ADD PRIMARY KEY (`transReqID`),
  ADD KEY `transStatusForeignKey` (`transStatusID`),
  ADD KEY `requestorForeignKey` (`requestorID`),
  ADD KEY `translatorForeignKey` (`translatorID`),
  ADD KEY `sourceLanguageForeignKey` (`souceLanguageID`),
  ADD KEY `targetLanguageForeignKey` (`targetLanguageID`);

--
-- Indexes for table `transStatus`
--
ALTER TABLE `transStatus`
  ADD PRIMARY KEY (`transStatusID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD KEY `roleForeignKey` (`roleID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transReq`
--
ALTER TABLE `transReq`
  ADD CONSTRAINT `requestorForeignKey` FOREIGN KEY (`requestorID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sourceLanguageForeignKey` FOREIGN KEY (`souceLanguageID`) REFERENCES `language` (`langID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `targetLanguageForeignKey` FOREIGN KEY (`targetLanguageID`) REFERENCES `language` (`langID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transStatusForeignKey` FOREIGN KEY (`transStatusID`) REFERENCES `transStatus` (`transStatusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `translatorForeignKey` FOREIGN KEY (`translatorID`) REFERENCES `User` (`userID`) ON UPDATE NO ACTION;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `roleForeignKey` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
