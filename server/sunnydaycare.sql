-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2015 at 08:24 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `type`, `address`, `Client_id`) VALUES
(1, 'Billing', '123 Main Street Disneyland, CA 10001', 3),
(2, 'Mailing', '123 Main Street Disneyland, CA 10001', 3),
(15, 'Billing', '4444 Billing Address, Aurora CO 80016', 47),
(16, 'Mailling', '4444 Mailing Address, Westminster CO 80106', 47),
(17, 'Billing', '134 S Rocket Man Way, Denver CO 80250', 48),
(18, 'Mailling', '134 S Rocket Man Way, Denver CO 80250', 48);

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

CREATE TABLE IF NOT EXISTS `allergy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Allergy_Medical1_idx` (`Child_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `allergy`
--

INSERT INTO `allergy` (`id`, `type`, `Child_id`) VALUES
(1, 'qi6VSH3HHzx3BUYLI6opQg==', 29),
(9, 'IJLGSjeTOr3+oRyAhDJ5jw==', 36),
(10, 'X5S3hQr5nr028eprTjJ/rg==', 39),
(11, '3AHj5MZBMcACRWdMYA6dFHnJ9tfQIrfi', 40);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `datemade`, `datedue`, `total`, `Client_id`, `paymentdate`, `isFullyPaid`) VALUES
(1, '2015-02-01', '2015-03-01', 1280.24, 3, '2015-02-12', 1),
(5, '2015-05-05', '2015-06-15', 1664, 3, NULL, 0),
(7, '2015-06-15', '2015-06-15', 128, 7, NULL, 0),
(8, '2015-06-15', '2015-06-15', 590, 4, NULL, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`id`, `gender`, `piclink`, `checkedIn`, `comments`, `stateassistance`, `isactive`, `firstname`, `middlename`, `lastname`) VALUES
(1, 'M', NULL, 0, NULL, 0, 1, 'Jimmy', NULL, 'Smith'),
(2, 'F', '/pics/child/sally_smith042015.jpg', 0, NULL, 0, 1, 'Sally', 'Fields', 'Smith'),
(3, 'F', NULL, 0, 'She''s my favorite!!! ', 1, 1, 'Anne', NULL, 'Hathaway'),
(4, 'M', NULL, 0, 'He left because he was "Bad"...', 0, 0, 'Michael', NULL, 'Jackson'),
(5, 'M', NULL, 0, 'This is Bob.', 0, 1, 'Bob', 'Macintyre', 'Schmeck'),
(6, 'F', NULL, 0, 'Yes, she''s named Bobina.', 0, 1, 'Bobina', 'Francine', 'Goulae'),
(7, 'F', NULL, 0, 'I am not the walrus', 0, 1, 'Lucy', NULL, 'Smith'),
(8, 'M', NULL, 0, 'Here is a story, of a man named Brady...', 0, 1, 'Brady', 'Smith', 'Goober'),
(27, 'O', NULL, 0, NULL, 0, 1, 'Timmy', NULL, 'Turner'),
(28, 'F', NULL, 1, NULL, 0, 1, 'Fresh', 'John', 'Prince'),
(29, 'M', NULL, 1, NULL, 0, 1, 'Bobby', 'Hank', 'Hill'),
(36, 'F', NULL, 1, NULL, 0, 1, 'Frankie', NULL, 'Fresh'),
(38, 'M', NULL, 0, NULL, 0, 1, 'Firsty', NULL, 'Lasty'),
(39, 'F', NULL, 0, NULL, 0, 1, 'Sammi', 'Bubbles', 'Smith'),
(40, 'O', NULL, 0, NULL, 0, 1, 'Fraggle', NULL, 'Rock');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `child incident`
--

INSERT INTO `child incident` (`id`, `type`, `descrip`, `date`, `Child_id`) VALUES
(3, 'Run away', 'He ran away to the local Wendy''s', '2015-04-01', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `gender`, `piclink`, `primarycontact`, `billpayer`, `primaryphone`, `secondaryphone`, `isactive`, `relationship`, `stateassistance`, `firstname`, `middlename`, `lastname`) VALUES
(1, 'M', NULL, 0, 0, '5550001010', '3335551111', 1, 'Father', 0, 'Jason', NULL, 'Smith'),
(2, 'M', NULL, 0, 0, '1110000000', NULL, 1, 'Grandpa', 0, 'Bob', NULL, 'Smith'),
(3, 'F', NULL, 1, 1, '5550001010', '3335551111', 1, 'Mother', 0, 'Mary', 'Lou', 'Smith'),
(4, 'M', NULL, 1, 1, '2225554444', NULL, 1, 'Uncle', 1, 'Bob', 'Gene', 'Wilder'),
(5, 'M', NULL, 1, 1, '7893431000', NULL, 1, 'Father', 1, 'Mickey', NULL, 'Mouse'),
(6, 'F', NULL, 0, 0, '789-343-1000', NULL, 1, 'Mother', 0, 'Minnie', NULL, 'Mouse'),
(7, 'F', NULL, 1, 1, '5555550000', NULL, 1, 'Aunt', 1, 'Sue', NULL, 'Byron'),
(8, 'M', NULL, 1, 1, '8880005555', '1011010000', 1, 'Uncle', 0, 'Casey', NULL, 'Jones'),
(9, 'F', NULL, 0, 0, '9008880606', '9008880707', 1, 'Mother', 0, 'Patricia', NULL, 'Goober'),
(10, 'M', NULL, 0, 0, '1012023030', NULL, 0, 'Brother', 0, 'Tim', 'Toolman', 'Taylor'),
(11, 'M', NULL, 1, 1, '1112223333', NULL, 1, 'Other', 1, 'Goofy', NULL, 'Dog'),
(12, 'M', NULL, 0, 0, '4545651111', NULL, 1, 'Uncle', 0, 'James', NULL, 'Dean'),
(13, 'M', NULL, 0, 1, '1110002222', NULL, 1, 'Father', 0, 'Fred', NULL, 'Flinstone'),
(17, 'M', NULL, 0, 0, '1112223333', '0003331111', 1, 'Uncle', 1, 'Mack', NULL, 'Jones'),
(19, 'M', NULL, 0, 0, '1012024000', NULL, 1, 'Grandfather', 0, 'Bob', NULL, 'Jones'),
(20, 'M', NULL, 1, 1, '1112223333', NULL, 1, 'Uncle', 0, 'Alan', NULL, 'Smithee'),
(21, 'M', NULL, 0, 0, '2323230000', NULL, 1, 'Other', 0, 'Tom', NULL, 'Hanks'),
(22, 'M', NULL, 1, 1, '2022023344', NULL, 1, 'Father', 0, 'Hank', NULL, 'Hill'),
(23, 'F', NULL, 1, 0, '4046061111', NULL, 1, 'Aunt', 0, 'Sally', NULL, 'Solomon'),
(24, 'F', NULL, 1, 1, '344-555-6666', NULL, 1, 'Aunt', 0, 'Oni', NULL, 'Knoe'),
(31, 'F', NULL, 1, 0, '111-222-3333', NULL, 1, 'Sister', 1, 'jane', NULL, 'goodall'),
(32, 'M', NULL, 0, 1, '404-888-4343', NULL, 1, 'Grandfather', 0, 'Mister', NULL, 'MoneyBags'),
(47, 'F', NULL, 1, 1, '867-090-0008', NULL, 1, 'Grandmother', 1, 'Melinda', NULL, 'Monroe'),
(48, 'M', NULL, 1, 1, '(424)009-000', NULL, 1, 'Father', 0, 'Elton', 'Reginald', 'John');

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
(4, 3),
(7, 5),
(8, 6),
(1, 7),
(3, 7),
(9, 8),
(32, 8),
(8, 27),
(20, 28),
(8, 29),
(17, 36),
(20, 36),
(8, 38),
(3, 39),
(1, 40),
(2, 40),
(3, 40);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `username`, `password_hash`, `firstname`, `middlename`, `lastname`, `permissions`) VALUES
(1, 'joegordon', '$2y$10$P1fQB9uAviIYp/RWHWUYwe4ZQYmG16q.yj07hVYtMeZa1ho2HW70O', 'Joesph', NULL, 'Gordon-Levitt', 1),
(2, 'scarjo101', '$2y$10$OFtOOIknt.tEYrOOQt7VGuXH2A/NnUlf2OGVr41HBe8ILADMqTvKa', 'Scarlett', NULL, 'Johansson', 1),
(3, 'tenders0302', '$2y$10$A4qc5GncCYCTfFpWuRarT.NbHWjDoXYuwNBzv8kPUfZAeC0ZvTr5S', 'Tyberius', 'Caine', 'Enders', 4),
(4, 'genericUser', '$2y$10$ScCi2YYUjiPmGYR3Oefp4e8dk6vIpd7ZlLX7UHZl3VyWvyx16kzoi', 'Generic', NULL, 'User', 4);

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
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `date`, `time`, `description`) VALUES
(1, 'Graduation', '2015-05-22', '11:00:00', 'Graduation class for those moving on into elementary school.'),
(2, 'End of the school year picnic', '2015-05-20', '12:00:00', 'Picnic for families and students to celebrate those moving on to elementary school.\r\n\r\nSee AnnaBette for more details'),
(3, 'Some event', '2015-04-08', '00:00:00', 'Some description'),
(4, 'Another Event', '2015-06-16', '14:00:00', 'Some other random event');

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
  `In_Client_id` int(10) unsigned NOT NULL,
  `Out_Client_Id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`,`Child_id`,`In_Client_id`),
  KEY `fk_Log_Child1_idx` (`Child_id`),
  KEY `fk_Log_Client1_idx` (`In_Client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `Day`, `CheckIn`, `CheckOut`, `Child_id`, `In_Client_id`, `Out_Client_Id`) VALUES
(1, '2015-04-30', '06:40:00', '22:55:40', 1, 3, 3),
(2, '2015-04-30', '03:14:20', '19:50:00', 3, 4, 4),
(3, '2015-04-30', '03:46:15', '20:02:04', 2, 1, 3),
(4, '2015-05-01', '00:15:22', '14:13:45', 3, 4, 4),
(5, '2015-05-01', '00:32:28', '15:26:52', 1, 3, 3),
(7, '2015-05-06', '06:06:46', '16:26:14', 1, 3, 3),
(8, '2015-05-06', '06:00:00', '24:00:00', 2, 1, NULL),
(9, '2015-05-07', '13:22:00', '24:00:00', 1, 3, NULL),
(10, '2015-05-07', '13:24:57', '13:53:22', 2, 3, 1),
(11, '2015-05-07', '13:44:45', '24:00:00', 5, 7, NULL),
(13, '2015-05-15', '08:11:26', NULL, 29, 8, NULL),
(14, '2015-05-15', '08:11:53', NULL, 28, 20, NULL),
(15, '2015-05-15', '08:12:25', NULL, 36, 20, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`id`, `Child_id`, `section`, `description`) VALUES
(3, 27, 'tjI9A1wThPSetVrjft2x0A==', 'xNo05uYNcIEUYzB8A3QxTOYuImUBELQ5'),
(4, 28, 'KPIlcfHgZt2t90ezbYHTD9gVeij4+tP8w2fyBYw+nOM=', 'oYW7wTAs+QDRxGHJX7lA6w=='),
(5, 29, '+R/P9FzeXwH/IDrputjgdgaq069FoTWg', 'N1OdqyazsTA1BRgcTL7dDQ=='),
(6, 29, '0yUL8bwnCcguR9/14WY21OMVL9RZVsZB', 'skMqAwlGjbK5vsLHTFyz4Q=='),
(9, 36, 'QXA27cQONZ6e/Kl7fDPaxg==', 'gLvJEHiC9IGN975xvqnR39T0rr+P9PFK'),
(10, 36, '5AaSf/EVi9EJN8/TzNRYRPDxFCJ09eAY', 'MA1S/fGFt1HyhiP3I3r/5eWIIMyXHNxg'),
(11, 38, '8xfTS5SKQGJSgbBPb1U+Bw==', 'VpbqgSzyRBnj8a5o5fnODQ=='),
(12, 40, 'zc/6F+1eDxGMKdAJoMlIWw==', 'Ygl09pfgVdFtpZXbj8WsTQODNkHQc85T'),
(14, 29, 'LOE4ckWtXCDKVCrpsgAKEg==', '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');

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
('Hourly', 20),
('LatePayment', 0.2),
('LatePickup', 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `restriction`
--

CREATE TABLE IF NOT EXISTS `restriction` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `detail` varchar(128) DEFAULT NULL,
  `Child_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`Child_id`),
  KEY `fk_Restriction_Child1_idx` (`Child_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `restriction`
--

INSERT INTO `restriction` (`id`, `type`, `detail`, `Child_id`) VALUES
(1, 'religious', 'Rga+nhNJFHucG6y6hazVlLdodstcFNEpgJ66ubUjlXeOdy9sZt5U1+iA2kkkYxw8z4FbNOg6ZIGzAY1P7EZiwaywQ9Sp5x0p', 2),
(2, 'personal', 'j4ayuRKQbJ2btZb4+c4ISkRV5/J5KeCDdxDPcZi+L9Xum1TZHlF64Q==', 1),
(7, 'Personal', 'abFQyKhUIiyNQGnNS3eSYMFlitInj0kMJ5wE6IwBems=', 27),
(8, 'Personal', 'ofXnQZR1wm+nYK+Nqyia4W0+gKSCO4NHZUstDhSHlt0=', 28),
(9, 'Religious', '6hVxvwY2qt0FP9F6IjLVtw==', 29),
(10, 'Religious', 'SC+QsKpT+FouvA9s/svaPA==', 29),
(11, 'Personal', 'd1ayJIIA0dg1gSfX3LNAX/bZE+xOgNU9', 36),
(12, 'Religious', '/XYJoT0/Y51ArA4RGTR7M0ICHt+Hb1lO', 40);

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
  ADD CONSTRAINT `fk_Allergy_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`);

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
  ADD CONSTRAINT `fk_Charge_Log1` FOREIGN KEY (`Log_id`) REFERENCES `log` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Charge_Rate1` FOREIGN KEY (`Rate_type`) REFERENCES `rate` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_Client_has_Child_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Client_has_Child_Client1` FOREIGN KEY (`Client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee incident`
--
ALTER TABLE `employee incident`
  ADD CONSTRAINT `fk_Incident_Employee1` FOREIGN KEY (`Employee_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_Log_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `updateMidnight` ON SCHEDULE EVERY 1 DAY STARTS '2015-05-15 00:01:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Update log at mignight' DO BEGIN
	UPDATE `log` SET CheckOut = '24:00:00' WHERE CheckOut IS NULL;
    UPDATE `child` SET checkedIn = FALSE WHERE 1;
END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
