-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 27 Juillet 2017 à 18:00
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
CREATE TABLE `event` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(125) NOT NULL,
  `creation_time` int(12) NOT NULL,
  `address` varchar(125) NOT NULL,
  `date` int(12) NOT NULL,
  `theme` varchar(125) NOT NULL,
  `secret` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `event_invit`
--

DROP TABLE IF EXISTS `event_invit`;
CREATE TABLE `event_invit` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `guest_user_id` int(12) NOT NULL,
  `event_id` int(12) NOT NULL,
  `invit_time` int(12) NOT NULL,
  `status` int(2) NOT NULL,
  `status_time` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `name` varchar(125) NOT NULL,
  `surname` varchar(125) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `regitration_time` int(12) NOT NULL,
  `hashkey` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nickname`, `name`, `surname`, `mail`, `password`, `regitration_time`, `hashkey`) VALUES(1, 'e', 'e', 'e', 'e', 'e', 1, '2adb244920e24f591708aa893ccb3db7'),
-- --------------------------------------------------------

--
-- Structure de la table `user_contact`
--

DROP TABLE IF EXISTS `user_contact`;
CREATE TABLE `user_contact` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `new_contact_user_id` int(12) NOT NULL,
  `contact_time` int(12) NOT NULL,
  `status_time` int(12) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE `user_settings` (
  `id` int(12) NOT NULL,
  `user_notification` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `event_invit`
--
ALTER TABLE `event_invit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_contact`
--
ALTER TABLE `user_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `event_invit`
--
ALTER TABLE `event_invit`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT pour la table `user_contact`
--
ALTER TABLE `user_contact`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
