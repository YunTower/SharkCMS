-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-07-07 17:39:48
-- 服务器版本： 5.7.26
-- PHP 版本： 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `sk_comment`
--

CREATE TABLE `sk_comment` (
  `id` int(6) UNSIGNED NOT NULL,
  `cid` int(6) NOT NULL,
  `type`text NOT NULL,
  `content` text NOT NULL,
  `uid` int(16) NOT NULL,
  `status` varchar(16) DEFAULT NULL,
  `parent` int DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sk_content`
--

CREATE TABLE `sk_content` (
  `cid` int(6) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `slug` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `cover` varchar(190) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `tag` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `uid` varchar(10) NOT NULL,
  `uname` varchar(32) NOT NULL,
  `allowComment` char(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sk_menu`
--

CREATE TABLE `sk_menu` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `url` text NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `uid` varchar(10) NOT NULL,
  `uname` varchar(32) NOT NULL,
  `parent` char(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sk_tag`
--

CREATE TABLE `sk_tag` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `cid` text NOT NULL,
  `uid` text NOT NULL,
  `uname` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sk_category`
--

CREATE TABLE `sk_category` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `cid` text NOT NULL,
  `uid` text NOT NULL,
  `uname` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sk_page`
--

CREATE TABLE `sk_page` (
  `pid` int(6) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(64) DEFAULT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `allowComment` char(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sk_setting`
--

CREATE TABLE `sk_setting` (
  `name` varchar(32) NOT NULL,
  `value` varchar(999) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sk_setting`
--

INSERT INTO `sk_setting` (`name`, `value`, `created`) VALUES
('theme-name', 'default', '2023-07-06 12:48:51');

-- --------------------------------------------------------

--
-- 表的结构 `sk_theme`
--

CREATE TABLE `sk_theme` (
  `tid` int(6) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sk_theme`
--

INSERT INTO `sk_theme` (`tid`, `name`, `value`, `created`) VALUES
(1, 'd-home-avatar', '/sk-content/upload/avatar/default.webp', '2023-07-07 09:00:32');

-- --------------------------------------------------------

--
-- 表的结构 `sk_user`
--

CREATE TABLE `sk_user` (
  `uid` int(6) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `avatar` text DEFAULT NULL,
  `group` varchar(64) NOT NULL,
  `ban` varchar(32) DEFAULT NULL,
  `logintime` varchar(64) DEFAULT NULL,
  `token` varchar(150) DEFAULT NULL,
  `created` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `sk_comment`
--
ALTER TABLE `sk_comment`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sk_content`
--
ALTER TABLE `sk_content`
  ADD PRIMARY KEY (`cid`);

--
-- 表的索引 `sk_menu`
--
ALTER TABLE `sk_menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sk_tag`
--
ALTER TABLE `sk_tag`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sk_category`
--
ALTER TABLE `sk_category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sk_page`
--
ALTER TABLE `sk_page`
  ADD PRIMARY KEY (`pid`);

--
-- 表的索引 `sk_theme`
--
ALTER TABLE `sk_theme`
  ADD PRIMARY KEY (`tid`);

--
-- 表的索引 `sk_user`
--
ALTER TABLE `sk_user`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `sk_comment`
--
ALTER TABLE `sk_comment`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `sk_content`
--
ALTER TABLE `sk_content`
  MODIFY `cid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `sk_menu`
--
ALTER TABLE `sk_menu`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `sk_tag`
--
ALTER TABLE `sk_tag`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `sk_category`
--
ALTER TABLE `sk_category`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
--
-- 使用表AUTO_INCREMENT `sk_page`
--
ALTER TABLE `sk_page`
  MODIFY `pid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `sk_theme`
--
ALTER TABLE `sk_theme`
  MODIFY `tid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `sk_user`
--
ALTER TABLE `sk_user`
  MODIFY `uid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
