-- phpMyAdmin SQL Dump
-- version 4.0.10.16
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2016 at 01:24 AM
-- Server version: 5.1.73
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `usama`
--

-- --------------------------------------------------------

--
-- Table structure for table `stream`
--

CREATE TABLE IF NOT EXISTS `stream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(25) NOT NULL,
  `st_target` varchar(255) NOT NULL,
  `str_src_name` varchar(255) NOT NULL,
  `st_title` varchar(255) NOT NULL,
  `st_description` text NOT NULL,
  `flag` varchar(255) NOT NULL,
  `flag_option` varchar(255) NOT NULL DEFAULT 'none',
  `access_token` text NOT NULL,
  `user_identifier_id` int(56) NOT NULL,
  `new_stream_url` varchar(255) NOT NULL,
  `stream_key` text NOT NULL,
  `rmtp_stream_id` varchar(255) NOT NULL,
  `new_stream_url_secure` varchar(255) NOT NULL,
  `rtmp_url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

--
-- Dumping data for table `stream`
--

INSERT INTO `stream` (`id`, `user_id`, `st_target`, `str_src_name`, `st_title`, `st_description`, `flag`, `flag_option`, `access_token`, `user_identifier_id`, `new_stream_url`, `stream_key`, `rmtp_stream_id`, `new_stream_url_secure`, `rtmp_url`) VALUES
(3, 9, 'StreamTarget', 'hellotest', 'title test', 'descriptiontestting', 'Select An Option', '', 'EAAHlXHgGt98BAAZCwwsMwkwMcMrIrNU5ZBOZBGUBBZCvZAfUInrld6eQuKXnCzAzgZCrAN2MGPRHKtpxBy6U3K7a86BE2coiblw5kDlZBtCGAxS8fwafIsgHYZCDS2quybQSC5GhIyT7ecKCzJ3gscnG', 2147483647, 'rtmp://rtmp-api.facebook.com:80/rtmp/10154353585454004?ds=1&a=AaaAD0dddAMFTtnl', '10154353585454004?ds=1&a=AaaAD0dddAMFTtnl', '10154353585454004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154353585454004?ds=1&a=AaaAD0dddAMFTtnl', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154353585454004?ds=1&a=AaaAD0dddAMFTtnl'),
(42, 11, 'targete', 'sourcce', 'titit', 'descc', '', '', 'EAAHlXHgGt98BAJL6A0eH6w2tsSxN9OovvZC6yr0hc6ZBvHAGoFM20ZBCi4SKKAz8LTOaDOeZC3Nrx9ZC8z7CL31YIOZC0TwkKxelKNrVKFO0sFv4wFb4ptvUHX25JyYU14pIpVLFYIyvwaIMLPYvGgkdL0miImMEIZD', 2147483647, 'rtmp://209.190.18.178:1935/live2/sourcce', '10154378846139004?ds=1&a=AaYJlV0DoylGj-_Y', '10154378846139004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154378846139004?ds=1&a=AaYJlV0DoylGj-_Y', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154378846139004?ds=1&a=AaYJlV0DoylGj-_Y'),
(5, 10, 'ammaro', 'yousaf', 'hassan', 'yousaf', 'Select An Option', '', 'EAAHlXHgGt98BAKGSoYks3bDZAsfTi43u9Tapi9It6hZARD1khseUW38iAhWCi45RZCdZA4JOu6tabiykb9WHye4XuAgmLiYPEpEhYvDZCXi366543owKZAOiSjQWkICBSIfoKYdV8os8FETQWCYa0GMdUrKApCfS4ZD', 2147483647, 'rtmp://127.0.0.1:1935/live/Yousaf', '10154360304159004?ds=1&a=AabeUgwPGfoPWyWl', '10154360304159004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154360304159004?ds=1&a=AabeUgwPGfoPWyWl', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154360304159004?ds=1&a=AabeUgwPGfoPWyWl'),
(43, 11, 'newone', 'sous', 'dd', 'sss', '', '', 'EAAHlXHgGt98BAJL6A0eH6w2tsSxN9OovvZC6yr0hc6ZBvHAGoFM20ZBCi4SKKAz8LTOaDOeZC3Nrx9ZC8z7CL31YIOZC0TwkKxelKNrVKFO0sFv4wFb4ptvUHX25JyYU14pIpVLFYIyvwaIMLPYvGgkdL0miImMEIZD', 2147483647, 'rtmp://209.190.18.178:1935/live2/sous', '10154378975879004?ds=1&a=AaY21Eeo1xqo6pIA', '10154378975879004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154378975879004?ds=1&a=AaY21Eeo1xqo6pIA', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154378975879004?ds=1&a=AaY21Eeo1xqo6pIA'),
(41, 0, 'tar', 'shoaib', 'titlt', 'sss', '', '', 'EAAHlXHgGt98BAJL6A0eH6w2tsSxN9OovvZC6yr0hc6ZBvHAGoFM20ZBCi4SKKAz8LTOaDOeZC3Nrx9ZC8z7CL31YIOZC0TwkKxelKNrVKFO0sFv4wFb4ptvUHX25JyYU14pIpVLFYIyvwaIMLPYvGgkdL0miImMEIZD', 2147483647, 'rtmp://rtmp-api.facebook.com:80/rtmp/10154378821309004?ds=1&a=AaaxDbiiaON59jGy', '10154378821309004?ds=1&a=AaaxDbiiaON59jGy', '10154378821309004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154378821309004?ds=1&a=AaaxDbiiaON59jGy', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154378821309004?ds=1&a=AaaxDbiiaON59jGy'),
(39, 11, 'oshoaibiT', 'oshoaibiS', 'tit', 'desc', '', '', 'EAAHlXHgGt98BAFKIXMVpBFmfR9vSeTi7ZBOZCGeoV0KImh8NwZAouUHZAKy9y6mCTmXpovNX2JQZBCaTyQmbuLZAIY2KUaGiOqwO2x5EIgs2ZCayQJOJO4BZCPB2dR0WRHj1Jm6VwoQ4nRyXaXNRjn1f', 2147483647, 'rtmp://209.190.18.178:1935/live2/oshoaibiS', '10154375910429004?ds=1&a=AaaNtXVpbgdrrQ4Q', '10154375910429004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154375910429004?ds=1&a=AaaNtXVpbgdrrQ4Q', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154375910429004?ds=1&a=AaaNtXVpbgdrrQ4Q'),
(40, 0, 'shobi', 'zas', 'ttiti', 'dessc', '', '', 'EAAHlXHgGt98BAGkjZCZBzemtjjg0nBOhG6UhVADqWo1flqAy4GXRBMGenlBzkWXsaYFskTi7GJkbP1SZADb2UTxjsHJOTP9sMkcDD2EZCo5JaoZBaTlySpwotqoG7mY9uag8m8YQrx0PdSoVlJsG5', 2147483647, 'rtmp://rtmp-api.facebook.com:80/rtmp/10154378785839004?ds=1&a=AaZ8ZKp5EIBuk9Yb', '10154378785839004?ds=1&a=AaZ8ZKp5EIBuk9Yb', '10154378785839004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154378785839004?ds=1&a=AaZ8ZKp5EIBuk9Yb', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154378785839004?ds=1&a=AaZ8ZKp5EIBuk9Yb'),
(127, 1, 'ok', 'dokie', 'poii', 'asldasdzxc', 'timeline', 'SELF', 'EAAHlXHgGt98BAC6mqSC6JZBZBdZCS7m5CgeaduCttuS7VWVhhsZBK9Tk6EvqYK6J7gDisdMUgQuCFIvruwa4Ci4z4rCJTJGaRxTvZCVoZBGymq3iMGfARGzrdZAvlCRQHJj6wFIWhoZABBs6BM4ZBZB7aDiZCtdmFASCokZD', 2147483647, 'rtmp://209.190.18.178:1935/live/dokie', '10154386829499004?ds=1&a=AabQ_gnSSruBX_r1', '10154386829499004', 'rtmps://rtmp-api.facebook.com:443/rtmp/10154386829499004?ds=1&a=AabQ_gnSSruBX_r1', 'rtmp://rtmp-api.facebook.com:80/rtmp/10154386829499004?ds=1&a=AabQ_gnSSruBX_r1'),
(136, 20, 'testStream', 'inputstream', 'this demo ', 'demo', 'timeline', 'SELF', 'EAAHlXHgGt98BAGTZC4Wd1lr7MLLG3IoqybtNyunJDyuATHQc26QTCMTqzcVOQaaYfiL2k63HpNBeyXFZA1IG2vPmDMbJWvQeZBEHscOXiFGOS34EVO6OLQ7WcqkIRIAEAfFsmdXc5N5cZAQpaqLZA15Wesjq7pyIZD', 2147483647, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` enum('admin','user') NOT NULL DEFAULT 'user',
  `app_name` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `password`, `user_role`, `app_name`) VALUES
(1, 'Ammar Yousaf', 'a@gmail.com', '123456', 'user', 'live'),
(8, 'admin', 'admin@gmail.com', '123456', 'admin', 'live'),
(9, 'evales', 'e@armoinc.com', '123456', 'user', 'live'),
(11, 'sho@gmail.com', 'sho@gmail.com', '123', 'user', 'live2'),
(12, 'Usama', 'musamamushtaq@gmail.com', '123456', 'user', 'rctv'),
(13, 'celebracion', 'celebracion@gmail.com', '1234', 'user', 'celebracion'),
(14, 'testuser2', 'testuser2@gmail.com', '123', 'user', 'kkp'),
(15, 'tu3', 'tu3@gmail.com', '123', 'user', 'emvinonuevo'),
(16, 'tu4', 'testuser4@gmail.com', '1234', 'user', 'metrinetwork'),
(17, 'tu5', 'testuser5@gmail.com', '12345', 'user', 'united'),
(18, 'tu6', 'tu6@gmail.com', '123456', 'user', 'eagletech'),
(19, 'shoaib', 'shoaib@gmail.com', '123456', 'user', 'vod'),
(20, 'Shoaib', 'shoaib.zafar927@gmail.com', '12345', 'user', 'live2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
