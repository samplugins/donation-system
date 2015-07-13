-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 13, 2015 at 01:49 PM
-- Server version: 10.0.20-MariaDB
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `samplugi_donate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`user_id`, `username`, `password`) VALUES
(1, 'admin', 'adaee80b35d71dcaf2c0045ea93c0000');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `donation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(64) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `donation_date` datetime NOT NULL,
  `status_id` varchar(20) DEFAULT '8',
  `status_updated_on` datetime NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `donation_transaction_data` text NOT NULL,
  `payment_method` varchar(8) NOT NULL,
  PRIMARY KEY (`donation_id`),
  KEY `status_id` (`status_id`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `enable_auto_response` tinyint(1) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `no_reply_email` varchar(100) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `reply_to` varchar(100) NOT NULL,
  `to_email` text NOT NULL,
  `enable_email` tinyint(1) NOT NULL,
  `donation_statement_title` varchar(140) NOT NULL,
  `merchant_test_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`subject`, `message`, `enable_auto_response`, `from_name`, `no_reply_email`, `from_email`, `reply_to`, `to_email`, `enable_email`, `donation_statement_title`, `merchant_test_mode`) VALUES
('Your Donation Status', '[NAME],\n\nThank you for your donation.\n\nDonation Details:\nDate: [DATE]\nStatus: [STATUS]\n\nBest Regards,\n\nSam\n', 1, 'Donation Form', 'noreply@samplugins.com', 'samplugins@gmail.com', 'samplugins@gmail.com', 'samplugins@gmail.com, adaptcoder@gmail.com', 1, 'Secure Donation ', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
