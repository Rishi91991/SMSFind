-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2013 at 07:13 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smsfind`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `Keyword` varchar(500) NOT NULL,
  `Result` varchar(500) NOT NULL,
  `MD5_Keyword` varchar(130) NOT NULL,
  `Hit_Count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`Keyword`, `Result`, `MD5_Keyword`, `Hit_Count`) VALUES
('MCDONALDS+IN+BORIVALI', 'Agora Business Plaza, Near Kora Kendra, SV Road, Borivali (West), Mumbai - 400092 MH, India', '7b831a82ac4d73feb7ff0c61385d84d4', 17),
('SHAHRUKH+KHAN', 'Shahrukh Khan often credited as Shah Rukh Khan and informally referred as   SRK or SK, is an Indian film actor. Referred to in the media as "Badshah of ...', 'cf46bcf2fb1ca528e89550badf68c3a5', 22);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
