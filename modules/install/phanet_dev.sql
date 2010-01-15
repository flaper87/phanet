-- phpMyAdmin SQL Dump
-- version 2.11.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-05-2008 a las 02:08:48
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `phanet_dev`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_actions`
--

DROP TABLE IF EXISTS `ph1_actions`;
CREATE TABLE IF NOT EXISTS `ph1_actions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) collate latin1_general_ci NOT NULL,
  `fname` varchar(32) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_authors`
--

DROP TABLE IF EXISTS `ph1_authors`;
CREATE TABLE IF NOT EXISTS `ph1_authors` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nickname` varchar(32) collate latin1_general_ci default NULL,
  `email` varchar(32) collate latin1_general_ci default NULL,
  `website` varchar(64) collate latin1_general_ci default NULL,
  `state` char(7) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_blogs`
--

DROP TABLE IF EXISTS `ph1_blogs`;
CREATE TABLE IF NOT EXISTS `ph1_blogs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) collate latin1_general_ci default NULL,
  `description` varchar(128) collate latin1_general_ci default NULL,
  `owner_id` int(10) unsigned default NULL,
  `url` varchar(128) collate latin1_general_ci default NULL,
  `feed_url` varchar(128) collate latin1_general_ci default NULL,
  `last_update` char(19) collate latin1_general_ci default NULL,
  `last_post_id` int(10) unsigned NOT NULL,
  `state` char(7) collate latin1_general_ci NOT NULL,
  `categories` char(250) collate latin1_general_ci NOT NULL,
  `language` char(2) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_categories`
--

DROP TABLE IF EXISTS `ph1_categories`;
CREATE TABLE IF NOT EXISTS `ph1_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `label` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_languages`
--

DROP TABLE IF EXISTS `ph1_languages`;
CREATE TABLE IF NOT EXISTS `ph1_languages` (
  `id` char(2) collate latin1_general_ci NOT NULL,
  `en_name` varchar(255) collate latin1_general_ci NOT NULL,
  `name` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_modules`
--

DROP TABLE IF EXISTS `ph1_modules`;
CREATE TABLE IF NOT EXISTS `ph1_modules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) collate latin1_general_ci default NULL,
  `path` varchar(64) collate latin1_general_ci NOT NULL,
  `enabled` int(10) unsigned NOT NULL,
  `weight` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_owners`
--

DROP TABLE IF EXISTS `ph1_owners`;
CREATE TABLE IF NOT EXISTS `ph1_owners` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nickname` varchar(32) collate latin1_general_ci NOT NULL,
  `fullname` varchar(32) collate latin1_general_ci default NULL,
  `email` varchar(32) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_posts`
--

DROP TABLE IF EXISTS `ph1_posts`;
CREATE TABLE IF NOT EXISTS `ph1_posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(64) collate latin1_general_ci default NULL,
  `text` text collate latin1_general_ci,
  `date` char(19) collate latin1_general_ci default NULL,
  `author` int(10) unsigned default NULL,
  `blog` int(10) unsigned default NULL,
  `link` varchar(128) collate latin1_general_ci default NULL,
  `tags` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_settings`
--

DROP TABLE IF EXISTS `ph1_settings`;
CREATE TABLE IF NOT EXISTS `ph1_settings` (
  `keyid` varchar(32) collate latin1_general_ci NOT NULL,
  `value` varchar(1024) collate latin1_general_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_tags`
--

DROP TABLE IF EXISTS `ph1_tags`;
CREATE TABLE IF NOT EXISTS `ph1_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `label` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_themes`
--

DROP TABLE IF EXISTS `ph1_themes`;
CREATE TABLE IF NOT EXISTS `ph1_themes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) collate latin1_general_ci default NULL,
  `path` varchar(64) collate latin1_general_ci NOT NULL,
  `enabled` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_users`
--

DROP TABLE IF EXISTS `ph1_users`;
CREATE TABLE IF NOT EXISTS `ph1_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nickname` varchar(32) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci NOT NULL,
  `fullname` varchar(255) collate latin1_general_ci NOT NULL,
  `email` varchar(32) collate latin1_general_ci default NULL,
  `website` varchar(64) collate latin1_general_ci default NULL,
  `author_id` int(10) unsigned default NULL,
  `status` char(1) collate latin1_general_ci default NULL,
  `usertype` char(1) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ph1_watchdog`
--

DROP TABLE IF EXISTS `ph1_watchdog`;
CREATE TABLE IF NOT EXISTS `ph1_watchdog` (
  `wid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `type` varchar(16) NOT NULL default '',
  `message` longtext NOT NULL,
  `function` varchar(50) NOT NULL,
  `severity` tinyint(3) unsigned NOT NULL default '0',
  `link` varchar(255) NOT NULL default '',
  `file` varchar(50) NOT NULL,
  `timestamp` int(11) NOT NULL default '0',
  PRIMARY KEY  (`wid`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=697 ;
