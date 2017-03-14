-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-12-18 11:00:17
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hhs`
--

-- --------------------------------------------------------

--
-- 表的结构 `hdb_func`
--

CREATE TABLE IF NOT EXISTS `hdb_func` (
  `fun_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '操作ID',
  `fun_name` varchar(50) DEFAULT NULL COMMENT '操作名称',
  `fun_code` varchar(50) DEFAULT NULL COMMENT '操作编码',
  `fun_url` varchar(100) DEFAULT NULL COMMENT '拦截URl前缀',
  `fun_fid` int(11) DEFAULT NULL COMMENT '操作父ID',
  PRIMARY KEY (`fun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='功能操作表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hdb_group_role`
--

CREATE TABLE IF NOT EXISTS `hdb_group_role` (
  `ugroup_id` int(11) NOT NULL COMMENT '用户组ID',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组角色关联表';

-- --------------------------------------------------------

--
-- 表的结构 `hdb_menu`
--

CREATE TABLE IF NOT EXISTS `hdb_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `menu_name` varchar(30) DEFAULT NULL COMMENT '菜单名称',
  `menu_url` varchar(100) DEFAULT NULL COMMENT '菜单路径',
  `fid` int(11) DEFAULT '0' COMMENT '父菜单ID(0表示无父类)',
  `sort` int(11) DEFAULT '0' COMMENT '菜单排序',
  `status` varchar(255) DEFAULT 'y' COMMENT '是否可用,y为可用，n为不能用',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `hdb_menu`
--

INSERT INTO `hdb_menu` (`menu_id`, `menu_name`, `menu_url`, `fid`, `sort`, `status`) VALUES
(1, '系统管理', '/sys', 0, 1, 'y'),
(2, '用户管理', '/user', 3, 1, 'y'),
(3, '系统管理1', '/sys', 0, 2, 'y'),
(4, '系统管理2', '/sys', 3, 2, 'y'),
(5, '系统管理3', '/sys', 3, 4, 'y'),
(6, '系统管理4', '/sys', 3, 3, 'y'),
(7, '用户管理1', '/user', 1, 2, 'y');

-- --------------------------------------------------------

--
-- 表的结构 `hdb_menu_func`
--

CREATE TABLE IF NOT EXISTS `hdb_menu_func` (
  `id` int(255) NOT NULL AUTO_INCREMENT COMMENT '菜单操作ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '菜单ID',
  `func_id` int(11) DEFAULT NULL COMMENT '操作ID',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单操作表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hdb_role`
--

CREATE TABLE IF NOT EXISTS `hdb_role` (
  `role_id` int(255) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `role_name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `status` varchar(5) DEFAULT 'y' COMMENT '是否可用',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `hdb_role`
--

INSERT INTO `hdb_role` (`role_id`, `role_name`, `status`) VALUES
(3, '程序员', 'y'),
(4, '超级管理员', 'y');

-- --------------------------------------------------------

--
-- 表的结构 `hdb_role_operate`
--

CREATE TABLE IF NOT EXISTS `hdb_role_operate` (
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `menu_id` int(11) NOT NULL COMMENT '权限ID',
  `func_id` int(11) DEFAULT '0' COMMENT '操作ID',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色权限关联表' AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `hdb_role_operate`
--

INSERT INTO `hdb_role_operate` (`role_id`, `menu_id`, `func_id`, `id`) VALUES
(4, 2, 0, 24),
(4, 6, 0, 25),
(3, 2, 0, 30),
(3, 4, 0, 31),
(3, 6, 0, 32);

-- --------------------------------------------------------

--
-- 表的结构 `hdb_ugroup`
--

CREATE TABLE IF NOT EXISTS `hdb_ugroup` (
  `u_group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `u_group_name` varchar(50) NOT NULL COMMENT '用户组名称',
  `u_group_fid` int(11) NOT NULL DEFAULT '0' COMMENT '用户组父ID',
  PRIMARY KEY (`u_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hdb_user`
--

CREATE TABLE IF NOT EXISTS `hdb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `sex` varchar(5) NOT NULL COMMENT '性别:1为男，2为女',
  `age` int(11) NOT NULL COMMENT '年龄',
  `account` varchar(20) NOT NULL COMMENT '账号',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `remember_token` varchar(100) NOT NULL COMMENT '记住密码',
  `headpic` varchar(255) NOT NULL COMMENT '头像',
  `phone` varchar(50) DEFAULT NULL COMMENT '手机号',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `address` varchar(50) DEFAULT NULL COMMENT '地址',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` varchar(5) DEFAULT 'y' COMMENT '是否可用,y为可用，n为不能用',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `hdb_user`
--

INSERT INTO `hdb_user` (`id`, `name`, `sex`, `age`, `account`, `password`, `remember_token`, `headpic`, `phone`, `email`, `address`, `time`, `status`, `remark`) VALUES
(16, 'admin', '1', 12, 'admin', 'd9bb99e5830286f3fdd3724dd0569748', 'T8jOe2AHE2pvQ6a13kyJtzz2pATVBEmwFbO0vDv86bOfGQg05wVcoEjsz9st', '', '123', '12312', '1123', '2015-12-18 00:51:42', 'y', '');

-- --------------------------------------------------------

--
-- 表的结构 `hdb_user_group`
--

CREATE TABLE IF NOT EXISTS `hdb_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ugroup_id` int(11) NOT NULL COMMENT '用户组ID',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组和用户关联表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `hdb_user_role`
--

CREATE TABLE IF NOT EXISTS `hdb_user_role` (
  `user_id` varchar(255) NOT NULL COMMENT '用户ID',
  `role_id` varchar(255) NOT NULL COMMENT '角色ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关联表';

--
-- 转存表中的数据 `hdb_user_role`
--

INSERT INTO `hdb_user_role` (`user_id`, `role_id`) VALUES
('20', '3'),
('20', '4');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
