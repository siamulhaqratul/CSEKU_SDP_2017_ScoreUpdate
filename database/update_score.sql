-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 05, 2017 at 04:44 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `update_score`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(128) DEFAULT NULL,
  `isPresent` int(11) DEFAULT NULL,
  `isActive` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `username`, `password`, `email`, `role`, `isPresent`, `isActive`) VALUES
(11, 'Md:Moniruzzaman Aurangzeb', 'Moniruzzaman', 'moniruzzaman', 'monir150227@gmail.com', 'super_admin', 1, 0),
(12, 'Md: Tanvir Hossain', 'Tanvir cse', 'tn12345', 'tanvir07@gmail.com', 'admin', 1, 0),
(13, 'Shish Been Baha Uddin', 'Shish Been', 'been675r', 'shish150225@gmail.com', 'admin', 1, 0),
(14, 'Zubaer Rayhan', 'Zubi cse', 'zubi0912', 'zubaer150208@gmail.com', 'admin', 1, 0),
(17, 'Imran Hussain', 'imranvai', '123', 'imran1540@cseku.ac.bd', 'admin', 1, 1),
(18, 'Ratul Haq', 'sql', '123', 'siamulhaqratul@gmail.com', 'admin', 1, 0),
(19, 'Ratul Hossain Haq', 'admin', '123', '1234@gmail.com', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_atch`
--

DROP TABLE IF EXISTS `m_atch`;
CREATE TABLE IF NOT EXISTS `m_atch` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_Aid` int(11) DEFAULT NULL,
  `team_Bid` int(11) DEFAULT NULL,
  `team_Aname` varchar(128) DEFAULT NULL,
  `team_Bname` varchar(128) DEFAULT NULL,
  `admin_name` varchar(128) DEFAULT NULL,
  `toss` int(11) DEFAULT NULL,
  `overs` int(11) NOT NULL,
  `isActive` int(11) DEFAULT '0',
  `isSelect` int(11) DEFAULT '0',
  `adminid` int(11) DEFAULT NULL,
  `isFinished` int(11) DEFAULT '0',
  PRIMARY KEY (`match_id`),
  KEY `team_Aid` (`team_Aid`),
  KEY `team_Bid` (`team_Bid`),
  KEY `match_id` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_atch`
--

INSERT INTO `m_atch` (`match_id`, `team_Aid`, `team_Bid`, `team_Aname`, `team_Bname`, `admin_name`, `toss`, `overs`, `isActive`, `isSelect`, `adminid`, `isFinished`) VALUES
(42, 95, 96, 'Bangladesh', 'India', 'imranvai', 95, 1, 1, 1, 17, 0),
(43, 97, 98, 'Dhaka', 'Khulna', 'Shish Been', 97, 2, 1, 1, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_name` varchar(30) DEFAULT NULL,
  `tem_id` int(11) DEFAULT NULL,
  `isSelect` int(11) DEFAULT '0',
  PRIMARY KEY (`player_id`),
  KEY `tem_id` (`tem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1033 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`player_id`, `player_name`, `tem_id`, `isSelect`) VALUES
(985, 'A', 95, 1),
(986, 'B', 95, 1),
(987, 'C', 95, 0),
(988, 'D', 95, 0),
(989, 'E', 95, 0),
(990, 'F', 95, 0),
(991, 'G', 95, 0),
(992, 'H', 95, 0),
(993, 'I', 95, 0),
(994, 'J', 95, 0),
(995, 'K', 95, 0),
(996, 'L', 95, 0),
(997, 'Z', 96, 0),
(998, 'Y', 96, 0),
(999, 'X', 96, 0),
(1000, 'W', 96, 0),
(1001, 'P', 96, 0),
(1002, 'Q', 96, 0),
(1003, 'R', 96, 0),
(1004, 'S', 96, 0),
(1005, 'T', 96, 0),
(1006, 'U', 96, 0),
(1007, 'V', 96, 0),
(1008, 'M', 96, 0),
(1009, 'AB', 97, 1),
(1010, 'BC', 97, 1),
(1011, 'CD', 97, 1),
(1012, 'DE', 97, 0),
(1013, 'EF', 97, 0),
(1014, 'FG', 97, 0),
(1015, 'GH', 97, 0),
(1016, 'HI', 97, 0),
(1017, 'IJ', 97, 0),
(1018, 'JK', 97, 0),
(1019, 'KL', 97, 0),
(1020, 'LM', 97, 0),
(1021, 'MN', 98, 0),
(1022, 'NO', 98, 0),
(1023, 'OP', 98, 0),
(1024, 'PQ', 98, 0),
(1025, 'QR', 98, 0),
(1026, 'RS', 98, 0),
(1027, 'ST', 98, 0),
(1028, 'TU', 98, 0),
(1029, 'UV', 98, 0),
(1030, 'VX', 98, 0),
(1031, 'XY', 98, 0),
(1032, 'YZ', 98, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `bat_run` int(11) DEFAULT '0',
  `played_ball` int(11) DEFAULT '0',
  `hitted_fours` int(11) DEFAULT '0',
  `hitted_sixes` int(11) DEFAULT '0',
  `bowlruns` int(11) DEFAULT '0',
  `bowled_overs` int(11) DEFAULT '0',
  `wicket` int(11) DEFAULT '0',
  `extra` int(11) DEFAULT '0',
  `out_type` varchar(255) DEFAULT NULL,
  `stricking_role` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `toss` int(11) DEFAULT NULL,
  `extra_wicket` int(11) DEFAULT '0',
  `noball` int(11) DEFAULT '0',
  `wideball` int(11) DEFAULT '0',
  PRIMARY KEY (`status_id`),
  KEY `match_id` (`match_id`),
  KEY `player_id` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `player_id`, `bat_run`, `played_ball`, `hitted_fours`, `hitted_sixes`, `bowlruns`, `bowled_overs`, `wicket`, `extra`, `out_type`, `stricking_role`, `match_id`, `toss`, `extra_wicket`, `noball`, `wideball`) VALUES
(116, 985, 2, 1, 0, 0, 0, 0, 0, 0, 'not out', 1, 42, 95, 0, 0, 0),
(117, 986, 0, 0, 0, 0, 0, 0, 0, 0, 'not out', 2, 42, 95, 0, 0, 0),
(118, 1007, 0, 0, 0, 0, 3, 1, 0, 1, NULL, 1, 42, 96, 0, 0, 1),
(119, 1021, 1, 1, 0, 0, 0, 0, 0, 0, 'run out', NULL, 43, 98, 0, 0, 0),
(120, 1022, 12, 4, 1, 1, 0, 0, 0, 0, 'c bJK', NULL, 43, 98, 0, 0, 0),
(121, 1018, 0, 0, 0, 0, 13, 6, 1, 0, NULL, NULL, 43, 97, 1, 0, 0),
(122, 1023, 1, 2, 0, 0, 0, 0, 0, 0, 'stm bKL', NULL, 43, 98, 0, 0, 0),
(123, 1024, 0, 0, 0, 0, 0, 0, 0, 0, 'run out', NULL, 43, 98, 0, 0, 0),
(124, 1019, 0, 0, 0, 0, 13, 6, 3, 10, NULL, NULL, 43, 97, 2, 2, 3),
(125, 1025, 0, 3, 0, 0, 0, 0, 0, 0, 'lbw bKL', NULL, 43, 98, 0, 0, 0),
(126, 1026, 2, 2, 0, 0, 0, 0, 0, 0, 'run out', NULL, 43, 98, 0, 0, 0),
(127, 1027, 0, 1, 0, 0, 0, 0, 0, 0, 'not out', NULL, 43, 98, 0, 0, 0),
(128, 1028, 0, 1, 0, 0, 0, 0, 0, 0, 'hitw bKL', NULL, 43, 98, 0, 0, 0),
(129, 1009, 26, 8, 3, 2, 0, 0, 0, 0, 'not out', NULL, 43, 97, 0, 0, 0),
(130, 1010, 0, 1, 0, 0, 0, 0, 0, 0, 'not out', NULL, 43, 97, 0, 0, 0),
(131, 1030, 0, 0, 0, 0, 18, 6, 0, 2, NULL, NULL, 43, 98, 1, 2, 0),
(132, 1011, 0, 1, 0, 0, 0, 0, 0, 0, 'run out', NULL, 43, 97, 0, 0, 0),
(133, 1029, 0, 0, 0, 0, 10, 2, 0, 0, NULL, NULL, 43, 98, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(30) DEFAULT NULL,
  `manager_name` varchar(30) NOT NULL,
  `coach_name` varchar(30) NOT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`, `manager_name`, `coach_name`) VALUES
(95, 'Bangladesh', 'efat', 'shish'),
(96, 'India', 'Durjoy', 'Sudipto'),
(97, 'Dhaka', 'Sumon', 'Mamun'),
(98, 'Khulna', 'Liton', 'Anam');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_atch`
--
ALTER TABLE `m_atch`
  ADD CONSTRAINT `m_atch_ibfk_1` FOREIGN KEY (`team_Aid`) REFERENCES `team` (`team_id`),
  ADD CONSTRAINT `m_atch_ibfk_2` FOREIGN KEY (`team_Bid`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`tem_id`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_2` FOREIGN KEY (`match_id`) REFERENCES `m_atch` (`match_id`),
  ADD CONSTRAINT `status_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
