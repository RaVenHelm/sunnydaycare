-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2015 at 04:57 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `Day`, `CheckIn`, `CheckOut`, `Child_id`, `In_Client_id`, `Out_Client_Id`) VALUES
(1, '2015-04-30', '06:40:00', '22:55:40', 1, 3, 3),
(2, '2015-04-30', '03:14:20', '19:50:00', 3, 4, 4),
(3, '2015-04-30', '03:46:15', '20:02:04', 2, 1, 3),
(4, '2015-05-01', '00:15:22', '14:13:45', 3, 4, 4),
(5, '2015-05-01', '00:32:28', '15:26:52', 1, 3, 3),
(6, '2015-05-01', '19:28:27', '20:46:08', 2, 1, 3),
(7, '2015-05-06', '06:06:46', '16:26:14', 1, 3, 3),
(8, '2015-05-06', '06:04:56', NULL, 2, 1, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_Log_Child1` FOREIGN KEY (`Child_id`) REFERENCES `child` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
