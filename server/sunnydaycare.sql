-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2015 at 01:26 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sunnydaycare`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `Client_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Client_id`),
  KEY `fk_Address_Client1_idx` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE IF NOT EXISTS `alert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `descrip` text,
  `Client_id` int(10) unsigned DEFAULT NULL,
  `Child_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Alert_Client1_idx` (`Client_id`),
  KEY `fk_Alert_Child1_idx` (`Child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

CREATE TABLE IF NOT EXISTS `allergy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Allergies_Child1_idx` (`Child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datemade` date NOT NULL,
  `datedue` date NOT NULL,
  `total` float unsigned NOT NULL,
  `Client_id` int(10) unsigned NOT NULL,
  `paymentdate` date DEFAULT NULL,
  `isFullyPaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`Client_id`),
  KEY `fk_Billing_Client1_idx` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE IF NOT EXISTS `charge` (
  `type` varchar(25) NOT NULL,
  `amount` float unsigned NOT NULL,
  `Billing_id` int(10) unsigned NOT NULL,
  `Rate_type` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`type`,`Billing_id`,`Rate_type`),
  KEY `fk_Charge_Billing1_idx` (`Billing_id`),
  KEY `fk_Charge_Rate1_idx` (`Rate_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE IF NOT EXISTS `child` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gender` varchar(10) DEFAULT NULL,
  `piclink` varchar(100) DEFAULT NULL,
  `checkedIn` tinyint(1) NOT NULL,
  `comments` text,
  `stateassistance` tinyint(1) NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  `Client_id` int(10) unsigned NOT NULL,
  `Demographics_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Client_id`,`Demographics_id`),
  KEY `fk_Child_Client_idx` (`Client_id`),
  KEY `fk_Child_Demographics1_idx` (`Demographics_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`id`, `gender`, `piclink`, `checkedIn`, `comments`, `stateassistance`, `isactive`, `Client_id`, `Demographics_id`) VALUES
(1, 'M', NULL, 0, NULL, 0, 1, 1, 5),
(2, 'F', NULL, 0, NULL, 0, 1, 1, 6),
(3, 'F', NULL, 0, NULL, 0, 1, 4, 7),
(4, 'M', NULL, 1, NULL, 1, 1, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gender` varchar(10) DEFAULT NULL,
  `piclink` varchar(45) DEFAULT NULL,
  `primarycontact` tinyint(1) NOT NULL,
  `billpayer` tinyint(1) NOT NULL,
  `primaryphone` varchar(12) NOT NULL,
  `secondaryphone` varchar(12) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL,
  `relationship` varchar(15) NOT NULL,
  `stateassistance` tinyint(1) NOT NULL,
  `Demographics_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Demographics_id`),
  KEY `fk_Client_Demographics1_idx` (`Demographics_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `gender`, `piclink`, `primarycontact`, `billpayer`, `primaryphone`, `secondaryphone`, `isactive`, `relationship`, `stateassistance`, `Demographics_id`) VALUES
(1, 'F', NULL, 1, 1, '5550001010', '3335551111', 1, 'Mother', 0, 1),
(2, 'M', NULL, 0, 0, '5550001010', '3335551111', 1, 'Father', 0, 3),
(3, 'M', NULL, 0, 0, '5550001010', '3335551111', 1, 'Grandfather', 0, 2),
(4, 'F', NULL, 0, 0, '5550001010', '3335551111', 1, 'Grandmother', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `demographics`
--

CREATE TABLE IF NOT EXISTS `demographics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `demographics`
--

INSERT INTO `demographics` (`id`, `firstname`, `middlename`, `lastname`) VALUES
(1, 'Mary', 'Lou', 'Smith'),
(2, 'Bob', NULL, 'Smith'),
(3, 'Jason', 'Reed', 'Smith'),
(4, 'Gwendolyn', NULL, 'Windsor-Smith'),
(5, 'Jimmy', 'Mack', 'Smith'),
(6, 'Sally', 'Field', 'Smith'),
(7, 'Anne', NULL, 'Hathaway'),
(8, 'Billy', 'Bob', 'Thorton');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password_hash` varchar(200) NOT NULL,
  `password_salt` varchar(200) NOT NULL,
  `Demographics_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Demographics_id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `fk_Employee_Demographics1_idx` (`Demographics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE IF NOT EXISTS `incident` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `descrip` text,
  `date` date NOT NULL,
  `Child_id` int(10) unsigned DEFAULT NULL,
  `Client_id` int(10) unsigned DEFAULT NULL,
  `Employee_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Incident_Child1_idx` (`Child_id`),
  KEY `fk_Incident_Client1_idx` (`Client_id`),
  KEY `fk_Incident_Employee1_idx` (`Employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE IF NOT EXISTS `medical` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Medical_Child1_idx` (`Child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `type` varchar(45) NOT NULL,
  `val` float unsigned NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restriction`
--

CREATE TABLE IF NOT EXISTS `restriction` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `detail` varchar(45) DEFAULT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Restriction_Child1_idx` (`Child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_Address_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `alert`
--
ALTER TABLE `alert`
  ADD CONSTRAINT `fk_Alert_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Alert_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `allergy`
--
ALTER TABLE `allergy`
  ADD CONSTRAINT `fk_Allergies_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `fk_Billing_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `fk_Charge_Billing1` FOREIGN KEY (`Billing_id`) REFERENCES `billing` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Charge_Rate1` FOREIGN KEY (`Rate_type`) REFERENCES `rate` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `child`
--
ALTER TABLE `child`
  ADD CONSTRAINT `fk_Child_Client` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Child_Demographics1` FOREIGN KEY (`Demographics_id`) REFERENCES `demographics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_Client_Demographics1` FOREIGN KEY (`Demographics_id`) REFERENCES `demographics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_Employee_Demographics1` FOREIGN KEY (`Demographics_id`) REFERENCES `demographics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `incident`
--
ALTER TABLE `incident`
  ADD CONSTRAINT `fk_Incident_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Incident_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Incident_Employee1` FOREIGN KEY (`Employee_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `medical`
--
ALTER TABLE `medical`
  ADD CONSTRAINT `fk_Medical_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `restriction`
--
ALTER TABLE `restriction`
  ADD CONSTRAINT `fk_Restriction_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
