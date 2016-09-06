-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 06, 2016 at 06:10 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.6.14-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `degreeplanner`
--
CREATE DATABASE IF NOT EXISTS `degreeplanner` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `degreeplanner`;

-- --------------------------------------------------------

--
-- Table structure for table `tblCourse`
--

CREATE TABLE IF NOT EXISTS `tblCourse` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Department` int(11) NOT NULL,
  `Num` int(11) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Description` varchar(1028) DEFAULT NULL,
  `Hours` smallint(6) NOT NULL DEFAULT '3',
  `Honors` tinyint(1) NOT NULL DEFAULT '0',
  `Writing` tinyint(1) NOT NULL DEFAULT '0',
  `Lab` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblDegree`
--

CREATE TABLE IF NOT EXISTS `tblDegree` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Department` int(11) NOT NULL,
  `Type` varchar(3) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Catalog` year(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblDepartment`
--

CREATE TABLE IF NOT EXISTS `tblDepartment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `School` int(11) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Code` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `School` (`School`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblSchool`
--

CREATE TABLE IF NOT EXISTS `tblSchool` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(64) NOT NULL,
  `ShortName` varchar(8) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblCourse`
--
ALTER TABLE `tblCourse`
  ADD CONSTRAINT `tblCourse_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `tblDepartment` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `tblDegree`
--
ALTER TABLE `tblDegree`
  ADD CONSTRAINT `tblDegree_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `tblDepartment` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `tblDepartment`
--
ALTER TABLE `tblDepartment`
  ADD CONSTRAINT `tblDepartment_ibfk_1` FOREIGN KEY (`School`) REFERENCES `tblSchool` (`ID`) ON DELETE CASCADE;
COMMIT;
