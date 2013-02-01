-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 01 月 31 日 12:46
-- 服务器版本: 5.5.25a
-- PHP 版本: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `template`
--

-- --------------------------------------------------------

--
-- 表的结构 `tb_authassignment`
--

CREATE TABLE IF NOT EXISTS `tb_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_authassignment`
--

INSERT INTO `tb_authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Authenticated', '2', NULL, 'N;'),
('Editor', '7', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `tb_authitem`
--

CREATE TABLE IF NOT EXISTS `tb_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_authitem`
--

INSERT INTO `tb_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Account.Findpwd', 0, '找回密码', NULL, 'N;'),
('Account.Login', 0, '用户登录', NULL, 'N;'),
('Account.Logout', 0, '用户登出', NULL, 'N;'),
('Account.Register', 0, '用户注册', NULL, 'N;'),
('Account.Resetpwd', 0, '重置密码', NULL, 'N;'),
('Admin', 2, '超级管理员', NULL, 'N;'),
('Authenticated', 2, '认证用户', 'return !Yii::app()->user->isGuest;', 'N;'),
('Editor', 2, '文章编辑', NULL, 'N;'),
('Guest', 2, '游客', 'return Yii::app()->user->isGuest;', 'N;'),
('Site.Contact', 0, '吐槽', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `tb_authitemchild`
--

CREATE TABLE IF NOT EXISTS `tb_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_authitemchild`
--

INSERT INTO `tb_authitemchild` (`parent`, `child`) VALUES
('Guest', 'Account.Findpwd'),
('Guest', 'Account.Login'),
('Authenticated', 'Account.Logout'),
('Guest', 'Account.Register'),
('Guest', 'Account.Resetpwd'),
('Editor', 'Authenticated'),
('Authenticated', 'Site.Contact');

-- --------------------------------------------------------

--
-- 表的结构 `tb_rights`
--

CREATE TABLE IF NOT EXISTS `tb_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_rights`
--

INSERT INTO `tb_rights` (`itemname`, `type`, `weight`) VALUES
('Authenticated', 2, 1),
('Guest', 2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(4) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `salt`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`) VALUES
(1, 'admin', '45f2603610af569b6155c45067268c6b', '1234', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', '2013-01-31 05:30:14', '2013-01-31 06:03:45', 1, 1),
(2, 'demo', 'ab10504bbb2ea90a11bba259431583a4', '4567', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', '2013-01-31 05:30:14', '0000-00-00 00:00:00', 0, 1),
(7, 'editor', '008abd88ecddf33a8b36fcecb58cb675', 'sPBY', 'rogeecn@qq.com', '290ea4c3184c3a7bfcf205cbe51982e6', '2013-01-31 10:59:37', '0000-00-00 00:00:00', 0, 0);

--
-- 限制导出的表
--

--
-- 限制表 `tb_authassignment`
--
ALTER TABLE `tb_authassignment`
  ADD CONSTRAINT `tb_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tb_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tb_authitemchild`
--
ALTER TABLE `tb_authitemchild`
  ADD CONSTRAINT `tb_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tb_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tb_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tb_rights`
--
ALTER TABLE `tb_rights`
  ADD CONSTRAINT `tb_rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tb_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
