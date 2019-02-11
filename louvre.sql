-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 08 fév. 2019 à 13:12
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `louvre`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking` date NOT NULL,
  `booking_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `day` tinyint(1) NOT NULL,
  `ticket_number` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `booking`, `booking_code`, `email`, `day`, `ticket_number`, `paid`, `creation_date`) VALUES
(16, '2019-02-27', '387599', 'jkenobi@free.fr', 0, 1, 1, '2019-02-08 10:44:56');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `totalTicket` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `date`, `totalTicket`) VALUES
(13, '2019-02-15', 0),
(14, '2019-02-14', 1),
(15, '2019-02-27', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) DEFAULT NULL,
  `f_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `l_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `country` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `reduc` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ticket`
--

INSERT INTO `ticket` (`id`, `commande_id`, `f_name`, `l_name`, `birthday`, `country`, `reduc`) VALUES
(22, 16, 'Jérémie', 'Stadelmann', '1992-10-11', 's:2:\"FR\";', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Évènements
--
DROP EVENT `term_commande`$$
CREATE DEFINER=`root`@`localhost` EVENT `term_commande` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-01-25 16:04:33' ON COMPLETION NOT PRESERVE ENABLE DO DELETE
FROM
    commande
WHERE
    CURRENT_TIME > ADDTIME(creation_date, '03:00:00') AND paid = 0$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
