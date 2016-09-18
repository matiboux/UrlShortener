-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 18, 2016 at 04:36 AM
-- Server version: 5.6.25-1~dotdeb+7.1
-- PHP Version: 5.6.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `accounts`
--
-- Creation: Jul 30, 2016 at 03:37 PM
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `birthday` date DEFAULT NULL,
  `register_date` datetime NOT NULL,
  `user_right` varchar(32) NOT NULL,
  `language` varchar(32) NOT NULL,
  `admin_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_infos`
--
-- Creation: Aug 12, 2016 at 09:11 PM
--

CREATE TABLE `accounts_infos` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `pseudonym` varchar(64) NOT NULL,
  `nickname` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `displayed_name` varchar(32) NOT NULL,
  `add_pseudonym` tinyint(1) NOT NULL,
  `gender` varchar(32) NOT NULL,
  `biography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_requests`
--
-- Creation: Jul 30, 2016 at 03:37 PM
--

CREATE TABLE `accounts_requests` (
  `id` bigint(20) NOT NULL,
  `username` varchar(64) NOT NULL,
  `activate_key` varchar(256) NOT NULL,
  `action` varchar(64) NOT NULL,
  `request_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_rights`
--
-- Creation: Jul 30, 2016 at 03:37 PM
--

CREATE TABLE `accounts_rights` (
  `id` int(11) NOT NULL,
  `user_right` varchar(64) NOT NULL,
  `acronym` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_sessions`
--
-- Creation: Jul 30, 2016 at 03:37 PM
--

CREATE TABLE `accounts_sessions` (
  `id` bigint(20) NOT NULL,
  `username` varchar(64) NOT NULL,
  `auth_key` varchar(256) NOT NULL,
  `user_ip` varchar(64) NOT NULL,
  `port` varchar(32) NOT NULL,
  `login_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `last_seen_page` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
-- Creation: Aug 03, 2016 at 02:19 PM
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'url', 'u.matiboux.com/'),
(2, 'name', 'Url Shortener'),
(3, 'description', 'A simple url shortener service\n'),
(4, 'media_path', 'content/media/'),
(5, 'theme_path', 'content/urlshortener/'),
(6, 'force_https', '0'),
(7, 'version', '1.1.0'),
(8, 'creation_date', '2016-02-29'),
(9, 'status', 'finished');
(10, 'auth_key_cookie_name', 'ProjectsAuthKey'),
(11, 'owner', 'Matiboux');

-- --------------------------------------------------------

--
-- Table structure for table `shortcut_links`
--
-- Creation: Jul 30, 2016 at 03:37 PM
--

CREATE TABLE `shortcut_links` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shortcut_links`
--

INSERT INTO `shortcut_links` (`id`, `name`, `url`) VALUES
(1, 'projects', 'http://projects.matiboux.com/'),
(2, 'accounts', 'http://accounts.matiboux.com/'),
(3, 'admin', 'http://admin.matiboux.com/'),
(4, 'login', 'http://accounts.matiboux.com/login/'),
(5, 'cdn', 'http://cdn.matiboux.com/');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--
-- Creation: Jul 30, 2016 at 03:37 PM
--

CREATE TABLE `translations` (
  `id` bigint(11) NOT NULL,
  `en` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `fr` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `br` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `en`, `fr`, `br`) VALUES
(1, 'Hello World!', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `url_shortener_list`
--
-- Creation: Sep 17, 2016 at 06:44 PM
--

CREATE TABLE `url_shortener_list` (
  `id` int(11) NOT NULL,
  `link` varchar(256) NOT NULL,
  `rating` varchar(64) NOT NULL,
  `owner` varchar(64) NOT NULL,
  `date` datetime NOT NULL,
  `link_key` varchar(64) NOT NULL,
  `views` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `url_shortener_settings`
--
-- Creation: Sep 18, 2016 at 12:07 AM
--

CREATE TABLE `url_shortener_settings` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `delay` tinyint(1) NOT NULL,
  `rating` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_infos`
--
ALTER TABLE `accounts_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_requests`
--
ALTER TABLE `accounts_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_rights`
--
ALTER TABLE `accounts_rights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_sessions`
--
ALTER TABLE `accounts_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shortcut_links`
--
ALTER TABLE `shortcut_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `url_shortener_list`
--
ALTER TABLE `url_shortener_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `url_shortener_settings`
--
ALTER TABLE `url_shortener_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `accounts_requests`
--
ALTER TABLE `accounts_requests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts_rights`
--
ALTER TABLE `accounts_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `accounts_sessions`
--
ALTER TABLE `accounts_sessions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `shortcut_links`
--
ALTER TABLE `shortcut_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `url_shortener_list`
--
ALTER TABLE `url_shortener_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `url_shortener_settings`
--
ALTER TABLE `url_shortener_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
