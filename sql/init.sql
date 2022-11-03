-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 03 nov. 2022 à 14:24
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `memory`
--

-- --------------------------------------------------------

--
-- Structure de la table `Jeux`
--

CREATE TABLE `Jeux` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Messages`
--

CREATE TABLE `Messages` (
  `message_id` int(11) NOT NULL,
  `message_game_id` int(11) NOT NULL,
  `message_user_id` int(11) NOT NULL,
  `message_value` text NOT NULL,
  `message_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Scores`
--

CREATE TABLE `Scores` (
  `score_id` int(11) NOT NULL,
  `score_user_id` int(11) NOT NULL,
  `score_game_id` int(11) NOT NULL,
  `score_level` varchar(255) NOT NULL,
  `score_value` int(11) NOT NULL,
  `score_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_pseudo` varchar(255) NOT NULL,
  `user_register_date` datetime NOT NULL,
  `user_last_connection` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Jeux`
--
ALTER TABLE `Jeux`
  ADD PRIMARY KEY (`game_id`),
  ADD UNIQUE KEY `game_name` (`game_name`);

--
-- Index pour la table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_user_id_message` (`message_user_id`),
  ADD KEY `fk_game_id_message` (`message_game_id`);

--
-- Index pour la table `Scores`
--
ALTER TABLE `Scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `fk_game_id_score` (`score_game_id`),
  ADD KEY `fk_user_id_score` (`score_user_id`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique` (`user_email`,`user_password`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Jeux`
--
ALTER TABLE `Jeux`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Scores`
--
ALTER TABLE `Scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `fk_game_id_message` FOREIGN KEY (`message_game_id`) REFERENCES `Jeux` (`game_id`),
  ADD CONSTRAINT `fk_user_id_message` FOREIGN KEY (`message_user_id`) REFERENCES `Utilisateurs` (`user_id`);

--
-- Contraintes pour la table `Scores`
--
ALTER TABLE `Scores`
  ADD CONSTRAINT `fk_game_id_score` FOREIGN KEY (`score_game_id`) REFERENCES `Jeux` (`game_id`),
  ADD CONSTRAINT `fk_user_id_score` FOREIGN KEY (`score_user_id`) REFERENCES `Utilisateurs` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
