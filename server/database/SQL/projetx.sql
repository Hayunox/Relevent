-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 26 Juillet 2017 à 05:45
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetx`
--
CREATE DATABASE IF NOT EXISTS `projetx` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projetx`;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(125) NOT NULL,
  `creation_time` int(12) NOT NULL,
  `address` varchar(125) NOT NULL,
  `date` int(12) NOT NULL,
  `theme` varchar(125) NOT NULL,
  `secret` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `event_acceptation`
--

DROP TABLE IF EXISTS `event_acceptation`;
CREATE TABLE IF NOT EXISTS `event_acceptation` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `event_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `acceptation_time` int(12) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `event_invit`
--

DROP TABLE IF EXISTS `event_invit`;
CREATE TABLE IF NOT EXISTS `event_invit` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `send_user_id` int(12) NOT NULL,
  `receive_user_id` int(12) NOT NULL,
  `event_id` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL,
  `name` varchar(125) NOT NULL,
  `surname` varchar(125) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `regitration_time` int(12) NOT NULL,
  `hashkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user_contact`
--

DROP TABLE IF EXISTS `user_contact`;
CREATE TABLE IF NOT EXISTS `user_contact` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `ask_user_id` int(12) NOT NULL,
  `accept_user_id` int(12) NOT NULL,
  `contact_time` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_notification` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
