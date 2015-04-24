-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2015 at 07:01 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `type`, `address`, `Client_id`) VALUES
(1, 'Billing', '123 Main Street Disneyland, CA 10001', 3);

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

CREATE TABLE IF NOT EXISTS `allergy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `Medical_id` int(10) NOT NULL,
  PRIMARY KEY (`id`,`Medical_id`),
  KEY `fk_Allergy_Medical1_idx` (`Medical_id`)
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
  `Log_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`type`,`Billing_id`,`Rate_type`,`Log_id`),
  KEY `fk_Charge_Billing1_idx` (`Billing_id`),
  KEY `fk_Charge_Rate1_idx` (`Rate_type`),
  KEY `fk_Charge_Log1_idx` (`Log_id`)
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
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`id`, `gender`, `piclink`, `checkedIn`, `comments`, `stateassistance`, `isactive`, `firstname`, `middlename`, `lastname`) VALUES
(1, 'M', NULL, 0, NULL, 0, 1, 'Jimmy', NULL, 'Smith'),
(2, 'F', '/pics/child/sally_smith042015.jpg', 1, NULL, 0, 1, 'Sally', 'Fields', 'Smith'),
(3, 'F', NULL, 1, 'She''s my favorite!!! ', 1, 1, 'Anne', NULL, 'Hathaway'),
(4, 'M', NULL, 0, 'He left because he was "Bad"...', 0, 0, 'Michael', NULL, 'Jackson');

-- --------------------------------------------------------

--
-- Table structure for table `child alert`
--

CREATE TABLE IF NOT EXISTS `child alert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `descrip` text,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Child Alert_Child1_idx` (`Child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `child incident`
--

CREATE TABLE IF NOT EXISTS `child incident` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `descrip` text,
  `date` date NOT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Child Incident_Child1_idx` (`Child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `gender`, `piclink`, `primarycontact`, `billpayer`, `primaryphone`, `secondaryphone`, `isactive`, `relationship`, `stateassistance`, `firstname`, `middlename`, `lastname`) VALUES
(1, 'M', NULL, 0, 0, '5550001010', '3335551111', 1, 'Father', 0, 'Jason', NULL, 'Smith'),
(2, 'M', NULL, 0, 0, '1110000000', '', 1, 'Grandpa', 0, 'Bob', NULL, 'Smith'),
(3, 'F', NULL, 1, 1, '5550001010', '3335551111', 1, 'Mother', 0, 'Mary', 'Lou', 'Smith'),
(4, 'M', NULL, 1, 1, '2225554444', NULL, 1, 'Uncle', 1, 'Bob', 'Gene', 'Wilder');

-- --------------------------------------------------------

--
-- Table structure for table `client alert`
--

CREATE TABLE IF NOT EXISTS `client alert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `descrip` text,
  `Client_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Client_id`),
  KEY `fk_Alert_Client1_idx` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `client incident`
--

CREATE TABLE IF NOT EXISTS `client incident` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `descrip` text,
  `date` date NOT NULL,
  `Client_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Client_id`),
  KEY `fk_Client Incident_Client1_idx` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_has_child`
--

CREATE TABLE IF NOT EXISTS `client_has_child` (
  `Client_id` int(10) unsigned NOT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Client_id`,`Child_id`),
  KEY `fk_Client_has_Child_Child1_idx` (`Child_id`),
  KEY `fk_Client_has_Child_Client1_idx` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_has_child`
--

INSERT INTO `client_has_child` (`Client_id`, `Child_id`) VALUES
(3, 1),
(1, 2),
(3, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password_hash` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(45) NOT NULL,
  `permissions` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `username`, `password_hash`, `firstname`, `middlename`, `lastname`, `permissions`) VALUES
(1, 'joegordon', '$2y$10$P1fQB9uAviIYp/RWHWUYwe4ZQYmG16q.yj07hVYtMeZa1ho2HW70O', 'Joesph', NULL, 'Gordon-Levitt', 1),
(2, 'scarjo101', '$2y$10$OFtOOIknt.tEYrOOQt7VGuXH2A/NnUlf2OGVr41HBe8ILADMqTvKa', 'Scarlett', NULL, 'Johansson', 1),
(3, 'tenders0302', '$2y$10$A4qc5GncCYCTfFpWuRarT.NbHWjDoXYuwNBzv8kPUfZAeC0ZvTr5S', 'Tyberius', 'Caine', 'Enders', 4);

-- --------------------------------------------------------

--
-- Table structure for table `employee incident`
--

CREATE TABLE IF NOT EXISTS `employee incident` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `descrip` text,
  `date` date NOT NULL,
  `Employee_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Employee_id`),
  KEY `fk_Incident_Employee1_idx` (`Employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Day` date NOT NULL,
  `CheckIn` time DEFAULT NULL,
  `CheckOut` time DEFAULT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  `Client_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`,`Client_id`),
  KEY `fk_Log_Child1_idx` (`Child_id`),
  KEY `fk_Log_Client1_idx` (`Client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE IF NOT EXISTS `medical` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Child_id` int(10) unsigned NOT NULL,
  `section` varchar(50) NOT NULL,
  `description` text NOT NULL,
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

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`type`, `val`) VALUES
('Hourly', 20);

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
-- Constraints for table `allergy`
--
ALTER TABLE `allergy`
  ADD CONSTRAINT `fk_Allergy_Medical1` FOREIGN KEY (`Medical_id`) REFERENCES `medical` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_Charge_Rate1` FOREIGN KEY (`Rate_type`) REFERENCES `rate` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Charge_Log1` FOREIGN KEY (`Log_id`) REFERENCES `log` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `child alert`
--
ALTER TABLE `child alert`
  ADD CONSTRAINT `fk_Child Alert_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `child incident`
--
ALTER TABLE `child incident`
  ADD CONSTRAINT `fk_Child Incident_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client alert`
--
ALTER TABLE `client alert`
  ADD CONSTRAINT `fk_Alert_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client incident`
--
ALTER TABLE `client incident`
  ADD CONSTRAINT `fk_Client Incident_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client_has_child`
--
ALTER TABLE `client_has_child`
  ADD CONSTRAINT `fk_Client_has_Child_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Client_has_Child_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee incident`
--
ALTER TABLE `employee incident`
  ADD CONSTRAINT `fk_Incident_Employee1` FOREIGN KEY (`Employee_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_Log_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Log_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
