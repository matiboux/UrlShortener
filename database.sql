-- phpMyAdmin SQL Dump
-- version 4.7.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2018 at 03:10 AM
-- Server version: 5.6.38-1~dotdeb+7.1
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wdsqpw_projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings_urlshortener`
--

CREATE TABLE `settings_urlshortener` (
  `name` varchar(64) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings_urlshortener`
--

INSERT INTO `settings_urlshortener` (`name`, `value`) VALUES
('url', 'urwebs.it/'),
('name', 'Url Shortener'),
('description', 'A simple URL shortener service.'),
('creation_date', '2016-02-29'),
('owner', NULL),
('version', '2.2'),
('status', NULL),
('github', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `urlshortener`
--

CREATE TABLE `urlshortener` (
  `link_key` varchar(64) NOT NULL,
  `link` varchar(256) NOT NULL,
  `rating` varchar(64) DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL,
  `views` int(11) NOT NULL,
  `author` varchar(36) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urlshortener`
--

-- INSERT INTO `urlshortener` (`link_key`, `link`, `rating`, `disabled`, `views`, `author`, `date`) VALUES
-- ('UX12IT', 'https://urwebs.it/', 'general', 0, 0, '0800a354-3fe8-408c-a748-4e2630f16d56', '2018-11-06 00:30:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings_urlshortener`
--
ALTER TABLE `settings_urlshortener`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `urlshortener`
--
ALTER TABLE `urlshortener`
  ADD PRIMARY KEY (`link_key`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
