-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2015 at 01:50 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cx_comments`
--

CREATE TABLE IF NOT EXISTS `cx_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `issue_id` int(11) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cx_issues`
--

CREATE TABLE IF NOT EXISTS `cx_issues` (
  `issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `parent_issue` int(11) NOT NULL,
  `tracking_num` varchar(255) NOT NULL,
  `issue_title` varchar(255) NOT NULL,
  `issue_description` text NOT NULL,
  `priority_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cx_priority`
--

CREATE TABLE IF NOT EXISTS `cx_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cx_priority`
--

INSERT INTO `cx_priority` (`id`, `priority`) VALUES
(1, 'Regular'),
(2, 'High'),
(3, 'Critical');

-- --------------------------------------------------------

--
-- Table structure for table `cx_projects`
--

CREATE TABLE IF NOT EXISTS `cx_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cx_projects`
--

INSERT INTO `cx_projects` (`id`, `project`) VALUES
(1, 'ERP');

-- --------------------------------------------------------

--
-- Table structure for table `cx_status`
--

CREATE TABLE IF NOT EXISTS `cx_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cx_status`
--

INSERT INTO `cx_status` (`id`, `status`) VALUES
(1, 'Open'),
(2, 'Received'),
(3, 'In Progress'),
(4, 'Resolved'),
(5, 'In Testing'),
(6, 'Ready for Review'),
(7, 'Closed'),
(8, 'Reopened');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_temp` varchar(60) NOT NULL,
  `user_type` int(11) NOT NULL,
  `code` varchar(60) NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `remember_token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `password_temp`, `user_type`, `code`, `active`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'srijon00@yahoo.com', 'srijon', '$2y$10$HHDVFRhtSXKlSD.pEDikfesrJSM9mM1OelkPBWnz7oEZP0kgmqL7O', '', 1, '', 1, '2014-01-18 11:27:47', '2015-01-09 12:49:41', 'SRRPRaU6rVFfGOHjTp9vNbYyMYkQToDiEjJw7HM0f4ZjjB2QXAE8amyKslMk'),
(2, 'shomiie@live.com', 'shomi', '$2y$10$HHDVFRhtSXKlSD.pEDikfesrJSM9mM1OelkPBWnz7oEZP0kgmqL7O', '', 1, '', 1, '2014-01-18 12:02:37', '2014-01-18 15:42:06', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
