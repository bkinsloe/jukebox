-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2016 at 12:13 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jukebox`
--
CREATE DATABASE IF NOT EXISTS `jukebox` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jukebox`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_playlist`
--

CREATE TABLE IF NOT EXISTS `admin_playlist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  `youtube_id` varchar(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `thumbnail` varchar(128) NOT NULL,
  `length` int(5) NOT NULL,
  `plays` int(8) NOT NULL DEFAULT '0',
  `requested_by` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `admin_playlist`
--

INSERT INTO `admin_playlist` (`id`, `type`, `youtube_id`, `title`, `thumbnail`, `length`, `plays`, `requested_by`) VALUES
(2, 'youtube', 'tc3Gw6AaTVU', '', '', 0, 1, ''),
(3, 'youtube', 'Nf9FzEmt4mM', '', '', 0, 1, ''),
(5, 'youtube', 'XR9-y4u9mew', '', '', 0, 1, ''),
(6, 'youtube', 'xarfMRZ3E0k', '', '', 0, 1, ''),
(7, 'youtube', 'YFK6H_CcuX8', '', '', 0, 1, ''),
(8, 'youtube', 'X5AfjAXcBXY', '', '', 0, 1, ''),
(9, 'youtube', 'mIjZE4kcg_Q', '', '', 0, 1, ''),
(10, 'youtube', '1DrJbxKzsDo', '', '', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `users_playlist`
--

CREATE TABLE IF NOT EXISTS `users_playlist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  `youtube_id` varchar(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `thumbnail` varchar(128) NOT NULL,
  `length` int(5) NOT NULL,
  `plays` int(8) NOT NULL DEFAULT '0',
  `requested_by` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users_playlist`
--

INSERT INTO `users_playlist` (`id`, `type`, `youtube_id`, `title`, `thumbnail`, `length`, `plays`, `requested_by`) VALUES
(11, 'youtube', 'kdemFfbS5H0', '', '', 0, 1, ''),
(12, 'youtube', 'kdemFfbS5H0', '', '', 0, 1, ''),
(13, 'youtube', 'vuXnpVjNDKA', '', '', 0, 1, ''),
(14, 'youtube', 'ILpxEl8r51A', '', '', 0, 1, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
