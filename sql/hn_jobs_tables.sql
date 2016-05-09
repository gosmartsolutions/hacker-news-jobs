-- phpMyAdmin SQL Dump
-- version 2.11.9.6
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 08, 2016 at 02:29 PM
-- Server version: 5.0.95
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hackernews`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_counts`
--

CREATE TABLE IF NOT EXISTS `category_counts` (
  `parent_id` char(20) default NULL,
  `type` char(30) default NULL,
  `category` char(30) NOT NULL,
  `total_count` mediumint(5) NOT NULL default '0',
  UNIQUE KEY `parent_id_category` (`parent_id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_counts`
--


-- --------------------------------------------------------

--
-- Table structure for table `hn_posts`
--

CREATE TABLE IF NOT EXISTS `hn_posts` (
  `post_id` char(20) NOT NULL,
  `parent_id` char(20) default NULL,
  `job_type` varchar(50) default NULL COMMENT 'ONSITE, REMOTE, INTERNS, VISA',
  `job_desc` text NOT NULL,
  `languages` varchar(255) default NULL,
  `frameworks` varchar(255) default NULL,
  `package_managers` varchar(255) default NULL,
  `databases` varchar(255) default NULL,
  `time_posted` char(10) NOT NULL,
  UNIQUE KEY `post_id` (`post_id`),
  KEY `job_type` (`job_type`),
  KEY `languages` (`languages`),
  KEY `frameworks` (`frameworks`),
  KEY `package_managers` (`package_managers`),
  KEY `databases` (`databases`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hn_posts`
--

