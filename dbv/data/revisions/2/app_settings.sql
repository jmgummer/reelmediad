-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2014 at 11:57 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `app_settings`
--

-- --------------------------------------------------------

--
-- Table structure for table `anvil_electronic`
--

CREATE TABLE IF NOT EXISTS `anvil_electronic` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_unique_result_id` int(11) DEFAULT NULL,
  `db_station_id` int(11) DEFAULT NULL,
  `db_station_name` varchar(100) NOT NULL,
  `db_date` date DEFAULT NULL,
  `db_time` time DEFAULT NULL,
  `db_brand` varchar(100) DEFAULT NULL,
  `db_incantation` varchar(100) DEFAULT NULL,
  `db_entry_type` smallint(6) DEFAULT NULL,
  `db_length` varchar(100) DEFAULT NULL,
  `db_comment` varchar(100) DEFAULT NULL,
  `db_rate` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`db_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `anvil_electronic_master`
--

CREATE TABLE IF NOT EXISTS `anvil_electronic_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `entry_type_id` int(11) DEFAULT NULL,
  `incantation_id` varchar(100) NOT NULL,
  `station_id` int(11) DEFAULT NULL,
  `station_name` varchar(100) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `rate` varchar(100) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `entry_type` varchar(100) DEFAULT NULL,
  `incantation_name` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `industry_report_types`
--

CREATE TABLE IF NOT EXISTS `industry_report_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `industry_report_types`
--

INSERT INTO `industry_report_types` (`id`, `report_name`) VALUES
(1, 'Number of Mentions'),
(2, 'AVE'),
(3, 'Share of Voice/Ink - By Media Type'),
(4, 'Share of Voice/Ink - By Mentions'),
(5, 'Share of Voice/Ink - By AVE'),
(6, 'Categories Mentioned'),
(7, 'Pictures & File Footage'),
(8, 'Tonality');

-- --------------------------------------------------------

--
-- Table structure for table `report_logs`
--

CREATE TABLE IF NOT EXISTS `report_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `report_gen_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `report_duration` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `report_type`
--

CREATE TABLE IF NOT EXISTS `report_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(80) DEFAULT NULL,
  `report_sys` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `story_category`
--

CREATE TABLE IF NOT EXISTS `story_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `story_category`
--

INSERT INTO `story_category` (`id`, `category_name`) VALUES
(1, 'All Stories'),
(2, 'My Stories Only'),
(3, 'Industry Stories Only');

-- --------------------------------------------------------

--
-- Table structure for table `story_type`
--

CREATE TABLE IF NOT EXISTS `story_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `story_type`
--

INSERT INTO `story_type` (`id`, `type_name`) VALUES
(1, 'Electronic & Print'),
(2, 'Print Only'),
(3, 'Electronic Only');

-- --------------------------------------------------------

--
-- Table structure for table `visitors_table`
--

CREATE TABLE IF NOT EXISTS `visitors_table` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_ip` varchar(32) DEFAULT NULL,
  `visitor_browser` varchar(255) DEFAULT NULL,
  `visitor_hour` smallint(2) NOT NULL,
  `visitor_minute` smallint(2) NOT NULL,
  `visitor_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visitor_day` smallint(2) NOT NULL,
  `visitor_month` smallint(2) NOT NULL,
  `visitor_year` smallint(4) NOT NULL,
  `visitor_refferer` varchar(255) DEFAULT NULL,
  `visitor_page` varchar(255) DEFAULT NULL,
  `company_name` varchar(100) NOT NULL,
  `platform` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `visitors_table`
--

INSERT INTO `visitors_table` (`ID`, `visitor_ip`, `visitor_browser`, `visitor_hour`, `visitor_minute`, `visitor_date`, `visitor_day`, `visitor_month`, `visitor_year`, `visitor_refferer`, `visitor_page`, `company_name`, `platform`) VALUES
(1, '192.168.0.234', 'mozilla', 10, 1, '2014-10-24 07:01:35', 24, 10, 2014, 'http://192.168.0.234/anvild/home/index', 'http://192.168.0.234/anvild/media/electronic', 'Safaricom Limited', 'windows'),
(2, '192.168.0.234', 'mozilla', 10, 1, '2014-10-24 07:01:48', 24, 10, 2014, 'http://192.168.0.234/anvild/media/electronic', 'http://192.168.0.234/anvild/media/electronic', 'Safaricom Limited', 'windows'),
(3, '192.168.0.234', 'mozilla', 10, 15, '2014-10-24 07:15:30', 24, 10, 2014, 'http://192.168.0.234/anvild/home/index', 'http://192.168.0.234/anvild/media/electronic', 'Safaricom Limited', 'windows'),
(4, '192.168.0.234', 'mozilla', 10, 20, '2014-10-24 07:20:17', 24, 10, 2014, 'http://192.168.0.234/anvild/media/electronic', 'http://192.168.0.234/anvild/media/electronic', 'Safaricom Limited', 'windows'),
(5, '192.168.0.234', 'mozilla', 10, 25, '2014-10-24 07:25:23', 24, 10, 2014, '192.168.0.234', 'http://192.168.0.234/anvild/media/electronic', 'Safaricom Limited', 'windows'),
(6, '192.168.0.234', 'mozilla', 10, 37, '2014-10-24 07:37:20', 24, 10, 2014, 'http://192.168.0.234/anvild/media/electronic', 'http://192.168.0.234/anvild/media/electronic', 'Safaricom Limited', 'windows');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
